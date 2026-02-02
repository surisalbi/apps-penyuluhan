<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    public function index()
    {
        $title = "Absensi";
        $absensi = Absensi::select('id','created_at','clock_in','clock_out','status','tanggal')
        ->where('user_id', auth()->user()->id)
        ->whereMonth('tanggal', Carbon::now()->month)
        ->whereYear('tanggal', Carbon::now()->year)
        ->orderBy('tanggal', 'desc')
        ->get();
        $bulan = date("m");
        return view('absensi.index', compact('title', 'absensi', 'bulan'));
    }

    public function show(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric'
        ]);

        $bulan = $request->bulan;

        $title = "Absensi Bulanan";
        $absensi = Absensi::select('id','created_at','clock_in','clock_out','status','tanggal')
        ->where('user_id', auth()->user()->id)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', Carbon::now()->year)
        ->orderBy('tanggal', 'desc')
        ->get();
        return view('absensi.index', compact('title', 'absensi', 'bulan'));
    }

    public function edit($id)
    {
        $title = "Absensi";
        $absensi = Absensi::select('id','clock_in','clock_out','foto_in','foto_out','status','tanggal')
        ->where('user_id', auth()->user()->id)
        ->where('id', decrypt($id))
        ->firstOrFail();
        return view('absensi.edit', compact('title', 'absensi'));
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
            'photo' => 'required|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $paths = [];

        foreach ($request->file('photo') as $file) {
            // Buat nama file unik
            $filename = uniqid('in_') . '.' . $file->getClientOriginalExtension();
        
            // Folder tujuan di public
            $folder = public_path('uploads/absensi/in');
        
            // Buat folder jika belum ada
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
        
            // Pindahkan file ke public folder
            $file->move($folder, $filename);
        
            // Path relatif untuk database
            $relativePath = 'uploads/absensi/in/' . $filename;
            $paths[] = $relativePath;

            // Kalau mau simpan ke DB per file
            
            Absensi::create([
                'user_id'   => auth()->user()->id,
                'foto_in'   => $relativePath,
                'clock_in'  => Carbon::now('Asia/Jakarta'),
                'latitude_in'  => $request->latitude,
                'longitude_in' => $request->longitude,
                'tanggal' => Carbon::today()
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload berhasil',
            'files' => $paths
        ]);
    }

    public function store_out(Request $request)
    {
        $request->validate([
            'photo' => 'required|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $paths = [];

        foreach ($request->file('photo') as $file) {
            // Buat nama file unik
            $filename = uniqid('out_') . '.' . $file->getClientOriginalExtension();
        
            // Folder tujuan di public
            $folder = public_path('uploads/absensi/out');
        
            // Buat folder jika belum ada
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
        
            // Pindahkan file ke public folder
            $file->move($folder, $filename);
        
            // Path relatif untuk database
            $relativePath = 'uploads/absensi/out/' . $filename;
            $paths[] = $relativePath;

            // Kalau mau simpan ke DB per file

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
                'tanggal' => Carbon::today()
            ]);
            
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload berhasil',
            'files' => $paths
        ]);
    }

    public function store_morning(Request $request)
    {
        $request->validate([
            'jenis_absen' => 'required|string',
            'tanggal' => 'required|date',
            'photo' => 'required|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $absensi = Absensi::select('status')
        ->where('user_id', auth()->user()->id)
        ->whereDate('tanggal', $request->tanggal)
        ->exists();

        if ($absensi) {
            return response()->json([
                'status' => 'error',
                'message' => 'Sudah ada absensi untuk tanggal yg anda pilih'
            ]);
        }

        $paths = [];

        foreach ($request->file('photo') as $file) {
            // Buat nama file unik
            $filename = uniqid('in_') . '.' . $file->getClientOriginalExtension();
        
            // Folder tujuan di public
            $folder = public_path('uploads/absensi/in');
        
            // Buat folder jika belum ada
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
        
            // Pindahkan file ke public folder
            $file->move($folder, $filename);
        
            // Path relatif untuk database
            $relativePath = 'uploads/absensi/in/' . $filename;
            $paths[] = $relativePath;

            // Kalau mau simpan ke DB per file
            
            Absensi::create([
                'user_id'   => auth()->user()->id,
                'foto_in'   => $relativePath,
                'clock_in'  => Carbon::now('Asia/Jakarta'),
                'latitude_in'  => $request->latitude,
                'longitude_in' => $request->longitude,
                'tanggal' => $request->tanggal
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload berhasil',
            'files' => $paths
        ]);
    }

    public function store_afternoon(Request $request)
    {
        $request->validate([
            'jenis_absen' => 'required|string',
            'tanggal' => 'required|date',
            'photo' => 'required|array',
            'photo.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ]);

        $absensi = Absensi::where('user_id', auth()->user()->id)
        ->whereDate('tanggal', $request->tanggal)
        ->first();

        // Belum absen pagi pada tanggal yg dipilih
        if (! $absensi || ! $absensi->clock_in) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda belum absen pagi pada tanggal yg dipilih'
            ], 422);
        }

        // Sudah absen sore pada tanggal yg dipilih
        if ($absensi->clock_out) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda sudah absen sore pada tanggal yg dipilih'
            ], 422);
        }

        $paths = [];

        foreach ($request->file('photo') as $file) {
            // Buat nama file unik
            $filename = uniqid('out_') . '.' . $file->getClientOriginalExtension();
        
            // Folder tujuan di public
            $folder = public_path('uploads/absensi/out');
        
            // Buat folder jika belum ada
            if (!file_exists($folder)) {
                mkdir($folder, 0755, true);
            }
        
            // Pindahkan file ke public folder
            $file->move($folder, $filename);
        
            // Path relatif untuk database
            $relativePath = 'uploads/absensi/out/' . $filename;
            $paths[] = $relativePath;

            // Kalau mau simpan ke DB per file
            
            $absensi->update([
                'user_id'   => auth()->user()->id,
                'foto_out'   => $relativePath,
                'clock_out'  => Carbon::now('Asia/Jakarta'),
                'latitude_out'  => $request->latitude,
                'longitude_out' => $request->longitude,
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Upload berhasil',
            'files' => $paths
        ]);
    }

    public function _store_in(Request $request)
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

    public function _store_out(Request $request)
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

    public function update(Request $request, $id)
    {
        $absensi = Absensi::findOrFail(decrypt($id));

        // Validasi
        $request->validate([
            'tanggal'   => 'required|date',
            'clock_in'  => 'nullable',
            'clock_out' => 'nullable',
            'foto_in'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
            'foto_out'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        // Update data utama
        $absensi->tanggal   = $request->tanggal;
        $absensi->clock_in  = $request->clock_in;
        $absensi->clock_out = $request->clock_out;

        $path_in = public_path('uploads/absensi/in');
        $path_out = public_path('uploads/absensi/out');

        // Pastikan folder ada
        if (!File::exists($path_in)) {
            File::makeDirectory($path_in, 0755, true);
        }

        if (!File::exists($path_out)) {
            File::makeDirectory($path_out, 0755, true);
        }

        /** =================
         * FOTO PAGI
         * ================= */
        if ($request->hasFile('foto_in')) {
            // hapus foto lama
            if ($absensi->foto_in && File::exists(public_path($absensi->foto_in))) {
                File::delete(public_path($absensi->foto_in));
            }

            $file = $request->file('foto_in');
            $fileName = uniqid('in_') . '.' . $file->getClientOriginalExtension();

            $file->move($path_in, $fileName);

            $absensi->foto_in = 'uploads/absensi/in/' . $fileName;
        }

        /** =================
         * FOTO SORE
         * ================= */
        if ($request->hasFile('foto_out')) {
            // hapus foto lama
            if ($absensi->foto_out && File::exists(public_path($absensi->foto_out))) {
                File::delete(public_path($absensi->foto_out));
            }

            $file = $request->file('foto_out');
            $fileName = uniqid('out_') . '.' . $file->getClientOriginalExtension();

            $file->move($path_out, $fileName);

            $absensi->foto_out = 'uploads/absensi/out/' . $fileName;
        }

        $absensi->save();

        return back()->with('success', 'Data absensi berhasil diperbarui');
    }

    public function destroy($id)
    {
        $absensi = Absensi::find(decrypt($id));
        if ($absensi->foto_out && File::exists(public_path($absensi->foto_out))) {
            File::delete(public_path($absensi->foto_out));
        }
        if ($absensi->foto_in && File::exists(public_path($absensi->foto_in))) {
            File::delete(public_path($absensi->foto_in));
        }
        $absensi->delete();

        return redirect('/absensi')->with('success', 'Data absensi berhasil diperbarui');
    }

    public function download($bulan)
    {
        $absensi = Absensi::select('created_at','clock_in','clock_out','status','tanggal','foto_in','foto_out')
        ->where('user_id', auth()->user()->id)
        ->whereMonth('tanggal', $bulan)
        ->whereYear('tanggal', Carbon::now()->year)
        ->orderBy('tanggal', 'desc')
        ->get();

        $pdf = Pdf::loadView('absensi.download', compact('absensi','bulan'))
              ->setPaper('A4', 'portrait');
        return $pdf->download('Data Absensi Penyuluhan '.\Carbon\Carbon::createFromDate(null, (int)$bulan, 1)->translatedFormat('F').' '.Carbon::now()->year.' .pdf');
    }

}
