@extends('layouts.main')
@section('content')
<main class="px-4 py-6 space-y-6">
    <!-- Profile Card -->
    <div class="bg-white rounded-2xl shadow p-6 text-center">
        <div class="flex justify-center">
            <div class="relative w-24 h-24 mx-auto">
                <!-- Skeleton -->
                <div id="avatar-skeleton" class="absolute inset-0 rounded-full bg-gray-200 animate-pulse"></div>

                <!-- Avatar -->
                <img id="avatar-img" src="https://scontent-cgk2-1.xx.fbcdn.net/v/t39.30808-6/615485720_2915041972033045_7299596539693875443_n.jpg?_nc_cat=104&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeFUgBlPec5cP_lfj4s0vMrsVAKZb5XWHc1UAplvldYdzVhHY_eq-PdoFYXARegz3AVC2H2NjGnwsZGCbwraqqgg&_nc_ohc=24jfbNoIcZkQ7kNvwGhsugt&_nc_oc=AdkVIXh9dwEZ9q37RraJnQO59eAvDv72CijShxB7WXN0UTi4fAYMD__9u9w4rCpryh0&_nc_zt=23&_nc_ht=scontent-cgk2-1.xx&_nc_gid=dqRzu4xe-JFI3KXGyuu-fg&oh=00_Afry1TPEs_TbPD_Redz7B51qRDcFeWdFF4kqHm7_Tb3AFw&oe=697CC1B1" alt="Avatar" class="w-24 h-24 rounded-full border-4 border-white shadow object-cover opacity-0 transition-opacity duration-300" onload=" document.getElementById('avatar-skeleton').style.display ='none'; this.classList.remove('opacity-0');"/>
            </div>
        </div>

        <h2 class="mt-4 text-lg font-semibold">{{ Auth::user()->name }}</h2>
        <p class="text-sm text-gray-500">{{ Auth::user()->nip }}</p>
    </div>

    <!-- Menu List -->
    <div class="bg-white rounded-2xl shadow divide-y">
    <!-- Item -->
    <a href="#" class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition">
        <div class="flex items-center gap-3">
            <span class="text-blue-500">
                <i class="fas fa-user w-5"></i>
            </span>
            <span>Profil</span>
        </div>
        <span class="text-gray-400">›</span>
    </a>

    <a
        href="#"
        class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition"
    >
        <div class="flex items-center gap-3">
        <span class="text-amber-500">
            <i class="fas fa-question-circle w-5"></i>
        </span>
        <span>Pusat Bantuan</span>
        </div>
        <span class="text-gray-400">›</span>
    </a>

    <a
        href="#"
        class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition"
    >
        <div class="flex items-center gap-3">
        <span class="text-emerald-500">
            <i class="fas fa-user-shield w-5"></i>
        </span>
        <span>Kebijakan Privasi</span>
        </div>
        <span class="text-gray-400">›</span>
    </a>

    <a
        href="#"
        class="flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition"
    >
        <div class="flex items-center gap-3">
        <span class="text-gray-700">
            <i class="fas fa-info-circle w-5"></i>
        </span>
        <span>Tentang</span>
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