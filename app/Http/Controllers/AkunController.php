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

    public function bantuan()
    {
        $title = "Pusat Bantuan";
        return view('akun.bantuan', compact('title'));
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

}
