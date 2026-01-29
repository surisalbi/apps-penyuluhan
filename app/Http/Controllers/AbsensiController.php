<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Absensi";
        return view('absensi.index', compact('title'));
    }

    public function facecam()
    {
        $title = "Face Cam";
        return view('absensi.facecam', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
            'foto_in'   => 'absensi/' . $filename,
            'clock_in'  => Carbon::now('Asia/Jakarta'),
            'latitude'  => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
