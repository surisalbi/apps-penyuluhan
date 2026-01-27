@extends('layouts.main')
@section('content')
<!-- Phone Frame -->
<div class="w-full bg-white">
    <!-- Header -->
    <div class="flex items-center gap-3 px-3 py-4 border-b bg-gray-100">
        <h1 class="text-lg font-semibold text-gray-700 ms-3">
            <i class="fas fa-calendar me-2"></i> Absensi
        </h1>
    </div>
    <!-- Content -->
    <main class="px-4 py-4 space-y-4 pb-24">
        <p class="text-sm text-gray-500">Januari 2025</p>
        @for ($i=0; $i < 10; $i++)
        <!-- Card -->
        <div class="bg-white rounded-xl border border-1 border-gray-250 shadow p-4">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <p class="font-semibold">24 Januari 2026</p>
                </div>
                <span class="text-xs font-medium px-3 py-1 rounded-full bg-amber-100 text-success">Proses</span>
                <span class="text-xs font-medium px-3 py-1 rounded-full bg-green-100 text-success">Selesai</span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Absen Pagi</p>
                    <p class="font-medium text-success">07:58</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Absen Pulang</p>
                    <p class="font-medium text-success">17:02</p>
                </div>
            </div>
        </div>
        @endfor
    </main>
</div>
@endsection