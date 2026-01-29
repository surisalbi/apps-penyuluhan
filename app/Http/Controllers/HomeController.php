<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $title = "Home";
        $absensi = Absensi::select('user_id','clock_in','clock_out')
        ->where('user_id', auth()->user()->id)
        ->whereDate('created_at', Carbon::today())
        ->first();
        return view('home.index', compact('title', 'absensi'));
    }
}
