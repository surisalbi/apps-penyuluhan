<?php

namespace App\Http\Controllers;

use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function index()
    {
        $title = "Login";
        return view('auth.index', compact('title'));
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Reset otp session agar wajib OTP setiap login
            session()->forget('otp_success');

            // Generate OTP
            $otp = rand(100000, 999999);

            // Simpan di database
            $user->otp_code = $otp;
            $user->otp_expired_at = now()->addMinutes(5);
            $user->save();

            // Kirim via email
            Mail::to($user->email)->send(new OtpMail($otp));

            // Simpan role sementara di session (nanti dipakai setelah verifikasi)
            session(['login_role' => $user->role]);

            session([
                'otp_email' => $user->email,
            ]);
            
            // Redirect user ke halaman OTP
            return redirect()->route('login.verify');
        }

        return back()->withErrors([
            'failed' => 'Email atau password salah'
        ])->onlyInput('email');
    }

    public function verify()
    {
        return view('auth.verify');
    }

    public function verifyProcess(Request $request)
    {
        $request->validate([
            'otp' => 'required|digits:6'
        ]);

        $user = Auth::user()->refresh(); // ambil data terbaru

        if (!$user) {
            return redirect('/login');
        }

        // Cek OTP
        if ($user->otp_code != $request->otp) {
            return back()->withErrors(['failed' => 'Kode OTP salah']);
        }

        // Cek expired
        if (now()->greaterThan($user->otp_expired_at)) {
            return back()->withErrors(['failed' => 'Kode OTP kadaluarsa']);
        }

        $user->otp_code = null;
        $user->otp_expired_at = null;
        $user->save();

        // Tandai OTP sudah diverifikasi pada session login saat ini
        session(['otp_success' => true]);

        // refresh auth session
        Auth::login($user);

        // Ambil role dari session
        $role = session('login_role');

        // Bersihkan session login_role
        session()->forget('login_role');

        // Redirect sesuai role
        if ($role === 'admin' || $role === 'user') {
            return redirect('/');
        }

        return redirect('/login')->withErrors([
            'failed' => 'Role tidak dikenali'
        ]);
    }

    public function resendOtp()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect('/login')->withErrors([
                'failed' => 'Silakan login terlebih dahulu.'
            ]);
        }

        // Generate OTP baru
        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expired_at = now()->addMinutes(5);
        $user->save();

        // Kirim email OTP
        Mail::to($user->email)->send(new OtpMail($otp));

        // Update session email (opsional, tapi aman)
        session(['otp_email' => $user->email]);

        // Redirect kembali ke halaman verify dengan info sukses
        return redirect()->route('login.verify')->with('success', 'Kode OTP baru telah dikirim ke email Anda.');
    }


    public function logout(Request $request)
    {
        // hapus otp success dari session
        session()->forget('otp_success');
        session()->forget('login_role');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
