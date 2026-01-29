@extends('layouts.main')
@section('content')
<main class="px-4 py-6 space-y-6">
    <!-- Profile Card -->
    <div class="relative bg-cover bg-center rounded-2xl shadow p-6 text-center" style="background-image: url('{{ asset('assets/img/bg-profil.jpg') }}')">
        <div class="absolute inset-0 bg-black/40 rounded-2xl"></div>
        <div class="flex justify-center">
            <div class="relative w-24 h-24 mx-auto">
                <!-- Skeleton -->
                <div id="avatar-skeleton" class="absolute inset-0 rounded-full bg-gray-200 animate-pulse"></div>

                <!-- Avatar -->
                <img id="avatar-img" src="https://ui-avatars.com/api/?name={{ urlencode(strtoupper(auth()->user()->name)) }}&background=1B5E20&color=fff" alt="Avatar" class="w-24 h-24 rounded-full border-2 border-white shadow-2xl object-cover opacity-0 transition-opacity duration-300" onload=" document.getElementById('avatar-skeleton').style.display ='none'; this.classList.remove('opacity-0');"/>
            </div>
        </div>

        <div class="relative z-10 text-center">
            <h2 class="mt-4 text-lg text-white font-semibold">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-white">NIP: {{ Auth::user()->nip }}</p>
        </div>
    </div>

    <!-- Menu List -->
    <div class="bg-white rounded-2xl shadow divide-y">
        <!-- Item -->
        <a href="{{ route('akun.profil') }}" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="text-blue-500">
                    <i class="fas fa-user w-5"></i>
                </span>
                <span class="text-sm text-gray-700">Profil</span>
            </div>
            <span class="text-gray-400">›</span>
        </a>

        <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="text-amber-500">
                    <i class="fas fa-question-circle w-5"></i>
                </span>
                <span class="text-sm text-gray-700">Pusat Bantuan</span>
            </div>
            <span class="text-gray-400">›</span>
        </a>

        <a href="{{ route('akun.kebijakan') }}" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="text-emerald-500">
                    <i class="fas fa-user-shield w-5"></i>
                </span>
                <span class="text-sm text-gray-700">Kebijakan Privasi</span>
            </div>
            <span class="text-gray-400">›</span>
        </a>

        <a href="{{ route('akun.tentang') }}" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
            <div class="flex items-center gap-3">
                <span class="text-gray-700">
                    <i class="fas fa-info-circle w-5"></i>
                </span>
                <span class="text-sm text-gray-700">Tentang</span>
            </div>
            <span class="text-gray-400">›</span>
        </a>
    </div>

    <!-- Logout -->
    <div class="bg-white rounded-2xl shadow">
        @if(Auth::check())
        <form action="{{ route('logout') }}" method="POST" class="d-inline">
            @csrf
            <button class="w-full flex items-center justify-center gap-2 px-5 py-4 text-danger font-medium hover:bg-danger hover:text-white transition rounded-2xl">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </form>
        @endif
    </div>
</main>
@endsection