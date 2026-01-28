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
            <h1 class="text-lg font-semibold text-gray-800">Kebijakan Privasi</h1>
        </div>
    </header>
    
    <!-- Content -->
    <main class="pt-20 px-4 pb-6 max-w-md mx-auto">
    
        <!-- Card -->
        <div class="bg-white rounded-2xl text-gray-700 shadow-md p-6">
            Belum ada data
        </div>
    
    </main>
</div>

@endsection