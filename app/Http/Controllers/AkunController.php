<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AkunController extends Controller
{
    public function index()
    {
        $title = "Akun";
        return view('akun.index', compact('title'));
    }

    public function profil()
    {
        $title = "Profil";
        return view('akun.profil', compact('title'));
    }

    public function kebijakan()
    {
        $title = "Kebijakan Privasi";
        return view('akun.kebijakan_privasi', compact('title'));
    }

    public function tentang()
    {
        $title = "Tentang";
        return view('akun.tentang', compact('title'));
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
