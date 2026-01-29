@extends('layouts.main')

@section('no-navigation')
@endsection

@section('content')
<!-- Phone Frame -->
<div class="w-full bg-white mb-6 overflow-hidden">
    <!-- Header -->
    <div class="flex items-center gap-3 px-3 py-2 border-b bg-gray-90">
        <a href="{{ route('home') }}" class="p-2 text-gray-700 rounded-full hover:bg-gray-100 transition">
            <i class="fas fa-arrow-left"></i>
        </a>
        <h1 class="text-lg font-semibold text-gray-700">Absens Sore</h1>
    </div>

    <!-- Content -->
    <div class="flex flex-col items-center justify-center p-6">
        <!-- Camera Container -->
        <div class="relative w-80 aspect-[9/16] overflow-hidden bg-black shadow-lg rounded-2xl">
            <!-- Camera -->
            <video id="camera" autoplay muted playsinline class="w-full h-full object-cover scale-x-[-1]"></video>
            <canvas id="canvas" class="hidden w-full h-full"></canvas>
            <img id="preview" class="hidden w-full h-full object-cover" />

            <!-- Overlay -->
            <div class="absolute inset-0 pointer-events-none z-10">
                <!-- Frame Corners -->
                <div id="frameCorners">
                    <span class="absolute top-3 left-3 w-10 h-10 border-t-4 border-l-4 border-emerald-700 rounded-tl-xl"></span>
                    <span class="absolute top-3 right-3 w-10 h-10 border-t-4 border-r-4 border-emerald-700 rounded-tr-xl"></span>
                    <span class="absolute bottom-3 left-3 w-10 h-10 border-b-4 border-l-4 border-emerald-700 rounded-bl-xl"></span>
                    <span class="absolute bottom-3 right-3 w-10 h-10 border-b-4 border-r-4 border-emerald-700 rounded-br-xl"></span>
                </div>
                <!-- Scan Line -->
                <div id="scanLine" class="scan-line absolute left-0 w-full h-1 z-20 bg-gradient-to-r from-transparent via-green-400 to-transparent opacity-80"></div>
            </div>
        </div>
    </div>

    <div class="flex flex-row items-center justify-center mt-6 w-full gap-4">
        <!-- Absen Sekarang -->
        <button id="btnAbsen" class="bg-green-700 hover:bg-green-800 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition active:scale-95">
            Absen Sekarang
        </button>

        <!-- Foto Ulang -->
        <button id="btnRetake" class="hidden bg-amber-700 hover:bg-amber-800 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition active:scale-95">
            Foto Ulang
        </button>

        <!-- Selesai -->
        <button id="btnSubmit" class="hidden bg-blue-700 hover:bg-blue-800 text-white font-semibold py-3 px-6 rounded-full shadow-lg transition active:scale-95">
            Selesai
        </button>
    </div>


</div>

@push('scripts')
<script>
    const video = document.getElementById("camera");
    const canvas = document.getElementById('canvas');
    const preview = document.getElementById('preview');

    const btnAbsen = document.getElementById('btnAbsen');
    const btnRetake = document.getElementById('btnRetake');
    const btnSubmit = document.getElementById('btnSubmit');

    const scanLine = document.getElementById('scanLine');
    const frameCorners = document.getElementById('frameCorners');

    let photoData = null;
    let latitude = null;
    let longitude = null;

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

    // Ambil lokasi
    navigator.geolocation.getCurrentPosition(pos => {
        latitude = pos.coords.latitude;
        longitude = pos.coords.longitude;
    });

    // Ambil foto
    btnAbsen.onclick = () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;

        const ctx = canvas.getContext('2d');

        // Flip horizontal agar foto normal
        ctx.translate(canvas.width, 0); // geser koordinat canvas ke kanan
        ctx.scale(-1, 1);               // balik horizontal
        ctx.drawImage(video, 0, 0);

        photoData = canvas.toDataURL('image/jpeg');

        preview.src = photoData;

        video.classList.add('hidden');
        preview.classList.remove('hidden');

        btnAbsen.classList.add('hidden');
        btnRetake.classList.remove('hidden');
        btnSubmit.classList.remove('hidden');

        // Hapus efek scan
        scanLine.classList.add('hidden');
        frameCorners.classList.add('hidden');
    };

    // Take ulang
    btnRetake.onclick = () => {
        video.classList.remove('hidden');
        preview.classList.add('hidden');

        btnAbsen.classList.remove('hidden');
        btnRetake.classList.add('hidden');
        btnSubmit.classList.add('hidden');

        // Tampilkan lagi efek scan
        scanLine.classList.remove('hidden');
        frameCorners.classList.remove('hidden');
    };

    // Submit ke Laravel
    btnSubmit.onclick = () => {
        // Ganti teks & disable tombol
        btnSubmit.innerText = "Menyimpan...";
        btnSubmit.disabled = true;
        btnSubmit.classList.add("opacity-50", "cursor-not-allowed");

        // Kirim data ke Laravel
        fetch("/absensi/store-out", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                photo: photoData,
                latitude: latitude,
                longitude: longitude
            })
        })

        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                showToast(res.message ?? 'Berhasil', 'success');
                setTimeout(() => {
                    window.location.href = "/";
                }, 1500);
            } else {
                showToast(res.message ?? 'Gagal', 'error');
                setTimeout(() => {
                    window.location.href = "/";
                }, 1500);
            }
        })
        .catch(() => {
            // Jika error, aktifkan tombol lagi
            btnSubmit.innerText = "Selesai";
            btnSubmit.disabled = false;
            btnSubmit.classList.remove("opacity-50", "cursor-not-allowed");
            showToast('Terjadi kesalahan jaringan', 'error');
        });
    };

</script>

@include('absensi.toast')
@endpush

@endsection