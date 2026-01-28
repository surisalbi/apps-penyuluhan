@extends('layouts.main')

@section('no-navigation')
@endsection

@section('content')
<div class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="flex items-center gap-3 px-4 py-3">
            <button onclick="window.location.href='{{ route('akun') }}'" class="text-gray-600">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Profil Saya</h1>
        </div>
    </header>
    
    <!-- Content -->
    <main class="pt-20 px-4 pb-6 max-w-md mx-auto">
    
        <!-- Profile Card -->
        <div class="bg-white rounded-2xl shadow-md p-6">
    
            <!-- Foto Profil -->
            <div class="flex flex-col items-center">
                <div class="w-28 h-28 rounded-full overflow-hidden ring-4 ring-[#2E7D32]">
                    <img
                        src="https://ui-avatars.com/api/?name={{ urlencode(strtoupper(auth()->user()->name)) }}&background=1B5E20&color=fff"
                        alt="Foto Profil"
                        class="w-full h-full object-cover"
                    >
                </div>
    
                <h2 class="mt-4 text-lg font-semibold text-gray-800">
                    {{ auth()->user()->name }}
                </h2>
                <p class="text-sm text-gray-500">NIP: {{ auth()->user()->nip }}</p>
            </div>
    
            <!-- Divider -->
            <div class="border-t my-6"></div>
    
            <!-- Data Profil -->
            <div class="space-y-4">
    
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Email</span>
                    <span class="font-medium text-gray-800">
                        {{ auth()->user()->email }}
                    </span>
                </div>
    
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Wilayah Binaan</span>
                    <span class="font-medium text-gray-800">
                        {{ auth()->user()->wilayah_binaan }}
                    </span>
                </div>
    
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kecamatan</span>
                    <span class="font-medium text-gray-800">
                        {{ auth()->user()->kecamatan }}
                    </span>
                </div>
    
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Kabupaten</span>
                    <span class="font-medium text-gray-800">
                        {{ auth()->user()->kabupaten }}
                    </span>
                </div>
    
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Provinsi</span>
                    <span class="font-medium text-gray-800">
                        {{ auth()->user()->provinsi }}
                    </span>
                </div>
    
            </div>
        </div>
    
    </main>
</div>

@endsection