<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $title = "Absensi";
        $absensi = Absensi::select('created_at','clock_in','clock_out','status')
        ->where('user_id', auth()->user()->id)
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->orderBy('id', 'desc')
        ->get();
        return view('absensi.index', compact('title', 'absensi'));
    }

    public function in()
    {
        $title = "Face Cam In";
        return view('absensi.in', compact('title'));
    }

    public function out()
    {
        $title = "Face Cam In";
        return view('absensi.out', compact('title'));
    }

    public function store_in(Request $request)
    {
        $request->validate([
            'photo' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        // Decode base64 image
        $image = str_replace('data:image/jpeg;base64,', '', $request->photo);
        $image = base64_decode($image);

        $filename = 'absen_in_' . time() . '.jpg';

        // Tentukan folder tujuan di public
        $folder = public_path('uploads/absensi/in');

        // Buat folder kalau belum ada
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        // Simpan file langsung ke public folder
        file_put_contents($folder . '/' . $filename, $image);

        // Path relatif untuk database
        $relativePath = 'uploads/absensi/in/' . $filename;

        Absensi::create([
            'user_id'   => auth()->user()->id,
            'foto_in'   => $relativePath,
            'clock_in'  => Carbon::now('Asia/Jakarta'),
            'latitude_in'  => $request->latitude,
            'longitude_in' => $request->longitude,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    public function store_out(Request $request)
    {
        $request->validate([
            'photo' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        // Decode base64 image
        $image = str_replace('data:image/jpeg;base64,', '', $request->photo);
        $image = base64_decode($image);

        $filename = 'absen_out_' . time() . '.jpg';
        
        // Tentukan folder tujuan di public
        $folder = public_path('uploads/absensi/out');

        // Buat folder kalau belum ada
        if (!file_exists($folder)) {
            mkdir($folder, 0755, true);
        }

        // Simpan file langsung ke public folder
        file_put_contents($folder . '/' . $filename, $image);

        // Path relatif untuk database
        $relativePath = 'uploads/absensi/out/' . $filename;

        $absensi = Absensi::where('user_id', auth()->user()->id)
        ->whereDate('created_at', Carbon::today())
        ->first();

        if (!$absensi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data absensi hari ini tidak ditemukan'
            ]);
        }

        $absensi->update([
            'foto_out'   => $relativePath,
            'clock_out'  => Carbon::now('Asia/Jakarta'),
            'latitude_out'  => $request->latitude,
            'longitude_out' => $request->longitude,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

}
