@extends('layouts.main')
@section('content')
    
<!-- Mobile Wrapper -->
<div class="w-full h-screen flex flex-col">
    <!-- Section Hijau-->
    <div class="h-[40%] bg-gradient-to-b from-primary to-primaryDark flex flex-col items-center justify-center text-center relative overflow-hidden">
        <!-- Soft Glow -->
        <div class="absolute inset-0 bg-white/5 blur-3xl"></div>
        <div class="relative z-10">
            <!-- Avatar -->
            <div class="mx-auto w-24 h-24 rounded-full bg-gray-200 shadow-lg overflow-hidden">
                <img src="https://cdn-icons-png.flaticon.com/512/4140/4140048.png" class="w-full h-full object-cover"/>
            </div>

            <h2 class="text-white font-semibold text-lg mt-4">Rifqi Rifaldi</h2>
            <p class="text-white/80 text-sm">IDP0002</p>
            <p class="text-white font-bold text-3xl tracking-wide">
                <span id="clock"></span>
            </p>
        </div>
    </div>

    {{-- Section Putih --}}
    <div class="h-[60%] bg-white rounded-t-big px-6 pt-16 pb-8 flex flex-col relative z-20">
        <p class="text-gray-500 mt-6 text-center mb-2">
            Hari ini, <span id="tanggal"></span>
        </p>
        <!-- Time Info -->
        <div class="flex justify-center items-center gap-10 text-center border border-1 border-gray-200 shadow-2xl rounded-2xl pt-4 pb-3 mb-10">
            <div>
                <p class="text-primary text-sm font-medium">
                    <i class="fas fa-clock"></i> In Time
                </p>
                <p class="text-gray-400 text-sm">00:00</p>
            </div>

            <div class="w-px h-10 bg-gray-300"></div>

            <div>
                <p class="text-amber-500 text-sm font-medium">
                    <i class="fas fa-clock"></i> Out Time
                </p>
                <p class="text-gray-400 text-sm">00:00</p>
            </div>
        </div>

        <!-- Button -->
        <button onclick="window.location.href = '{{ route('absensi.facecam') }}'" class="w-full py-3 rounded-full text-white font-semibold shadow-md bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark active:scale-95 transition-all">
            <i class="fas fa-sign-in-alt pe-1"></i> Check In Time
        </button>
    </div>
</div>

@endsection