@extends('layouts.main')

@section('no-navigation')
@endsection

@section('content')
<!-- Phone Frame -->
<div class="w-full h-screen bg-white shadow-2xl overflow-hidden">
    <!-- Header -->
    <div class="flex items-center gap-3 px-3 py-4 border-b bg-gray-90">
        <a href="{{ route('home') }}" class="p-2 text-gray-700 rounded-full hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-700">Absensi</h1>
    </div>

    <!-- Content -->
    <div class="flex flex-col items-center justify-center">
        <!-- Camera Container -->
        <div class="relative w-64 h-64 rounded-2xl overflow-hidden bg-black shadow-lg mt-6">
            <!-- Camera -->
            <video id="camera" autoplay muted playsinline class="w-full h-full object-cover scale-x-[-1]"></video>

            <!-- Overlay -->
            <div class="absolute inset-0 pointer-events-none z-10">
                <!-- Frame Corners -->
                <span class="absolute top-3 left-3 w-10 h-10 border-t-4 border-l-4 border-emerald-700 rounded-tl-xl"></span>
                <span class="absolute top-3 right-3 w-10 h-10 border-t-4 border-r-4 border-emerald-700 rounded-tr-xl"></span>
                <span class="absolute bottom-3 left-3 w-10 h-10 border-b-4 border-l-4 border-emerald-700 rounded-bl-xl"></span>
                <span class="absolute bottom-3 right-3 w-10 h-10 border-b-4 border-r-4 border-emerald-700 rounded-br-xl"></span>
                <!-- Scan Line -->
                <div class="scan-line absolute left-0 w-full h-1 z-20 bg-gradient-to-r from-transparent via-green-400 to-transparent opacity-80"></div>
                <!-- Face Icon -->
                <div class="absolute inset-0 flex items-center justify-center opacity-60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round"stroke-linejoin="round"stroke-width="1.5"d="M12 12c2.761 0 5-2.239 5-5s-2.239-5-5-5-5 2.239-5 5 2.239 5 5 5z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 21a8 8 0 10-16 0"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Button -->
        <button onclick="window.location.href = 'home.html'" class="mt-16 w-full max-w-xs bg-green-700 hover:bg-green-800 text-white font-semibold py-3 rounded-full shadow-lg transition active:scale-95">
            Absen Sekarang
        </button>
    </div>
</div>

@push('scripts')
<script>
    const video = document.getElementById("camera");

    navigator.mediaDevices
    .getUserMedia({
        video: {
        facingMode: "user",
        },
        audio: false,
    })
    .then((stream) => {
        video.srcObject = stream;
    })
    .catch((err) => {
        alert("Kamera tidak bisa diakses: " + err.message);
    });
</script>
@endpush

@endsection