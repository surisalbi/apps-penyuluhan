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

        $filename = 'absen_' . time() . '.jpg';
        Storage::disk('public')->put('absensi/in/' . $filename, $image);

        Absensi::create([
            'user_id'   => auth()->user()->id,
            'foto_in'   => 'absensi/in/' . $filename,
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

        $filename = 'absen_' . time() . '.jpg';
        Storage::disk('public')->put('absensi/out/' . $filename, $image);

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
            'foto_out'   => 'absensi/out/' . $filename,
            'clock_out'  => Carbon::now('Asia/Jakarta'),
            'latitude_out'  => $request->latitude,
            'longitude_out' => $request->longitude,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

}
