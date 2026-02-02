<?php

use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home')
->middleware(['auth', 'otp_verified', 'role:user']);

// Data Absensi
Route::get('/absensi', [AbsensiController::class, 'index'])->name('absensi')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::post('/absensi', [AbsensiController::class, 'show'])->name('absensi.show')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/absensi/download/{bulan}', [AbsensiController::class, 'download'])->name('absensi.download')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/absensi/edit/{id}', [AbsensiController::class, 'edit'])->name('absensi.edit')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::put('/absensi/{id}', [AbsensiController::class, 'update'])->name('absensi.update')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::delete('/absensi/{id}', [AbsensiController::class, 'destroy'])->name('absensi.destroy')
->middleware(['auth', 'otp_verified', 'role:user']);

// Facecam Absen Pagi
Route::get('/absensi/in', [AbsensiController::class, 'in'])->name('absensi.in')
->middleware(['auth', 'otp_verified', 'role:user']);

// Store Absen Pagi
Route::post('/absensi/store-in', [AbsensiController::class, 'store_in'])->name('absensi.store_in')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::post('/absensi/store-morning', [AbsensiController::class, 'store_morning'])->name('absensi.store_morning')
->middleware(['auth', 'otp_verified', 'role:user']);

// Facecam Absen Sore
Route::get('/absensi/out', [AbsensiController::class, 'out'])->name('absensi.out')
->middleware(['auth', 'otp_verified', 'role:user']);

// Store Absen Sore
Route::post('/absensi/store-out', [AbsensiController::class, 'store_out'])->name('absensi.store_out')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::post('/absensi/store-afternoon', [AbsensiController::class, 'store_afternoon'])->name('absensi.store_afternoon')
->middleware(['auth', 'otp_verified', 'role:user']);

// Upload Screenshot
Route::get('/upload', [UploadController::class, 'index'])->name('upload')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::post('/upload', [UploadController::class, 'show'])->name('upload.show')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/upload/download/{bulan}', [UploadController::class, 'download'])->name('upload.download')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::post('/upload/store', [UploadController::class, 'store'])->name('upload.store')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/upload/edit/{id}', [UploadController::class, 'edit'])->name('upload.edit')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::put('/upload/{id}', [UploadController::class, 'update'])->name('upload.update')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::delete('/upload/{id}', [UploadController::class, 'destroy'])->name('upload.destroy')
->middleware(['auth', 'otp_verified', 'role:user']);

// Akun
Route::get('/akun', [AkunController::class, 'index'])->name('akun')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/akun/profil', [AkunController::class, 'profil'])->name('akun.profil')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/akun/bantuan', [AkunController::class, 'bantuan'])->name('akun.bantuan')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/akun/kebijakan', [AkunController::class, 'kebijakan'])->name('akun.kebijakan')
->middleware(['auth', 'otp_verified', 'role:user']);
Route::get('/akun/tentang', [AkunController::class, 'tentang'])->name('akun.tentang')
->middleware(['auth', 'otp_verified', 'role:user']);

// Authentication
Route::get('/login', [AuthController::class, 'index']);
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/login/verify', [AuthController::class, 'verify'])->name('login.verify');
Route::post('/verify', [AuthController::class, 'verifyProcess'])->name('verify.process');
Route::get('/login/resend-otp', [AuthController::class, 'resendOtp'])->name('login.resendOtp');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');