@extends('layouts.main')
@section('content')
<!-- Phone Frame -->
<div class="w-full bg-white">
    <!-- Header -->
    <div class="flex items-center gap-3 px-4 py-4 border-b bg-gray-100">
        <h1 class="flex flex-1 text-lg font-semibold text-gray-700">Absensi</h1>
        <a href="" class="text-gray-700"><i class="fas fa-calendar"></i></a>
    </div>
    <!-- Content -->
    <main class="px-4 py-4 space-y-4 pb-24">
        <p class="text-sm text-gray-500">
            {{ now()->locale('id')->translatedFormat('F Y') }}
        </p>
        @foreach ($absensi as $row)
        <!-- Card -->
        <div class="{{ $loop->first ? 'bg-gray-100' : '' }} rounded-xl {{ $loop->first ? 'border-2' : 'border border-1' }} border-gray-250 p-4">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <p class="font-medium text-sm text-gray-700">
                        {{ $row->created_at->format('d/m/Y') }}
                    </p>
                </div>
                 @php
                    $bgColor = match($row->status) {
                        0     => 'bg-amber-500',
                        1     => 'bg-emerald-500',
                        default => 'gray'
                    };

                    $text = match($row->status) {
                        0     => 'Proses',
                        1     => 'Selesai',
                        default => '-'
                    };
                @endphp
                <span class="text-xs font-medium px-3 py-1 rounded-md {{ $bgColor }} text-white">
                    {{ $text }}
                </span>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <p class="text-xs text-gray-500">Absen Pagi</p>
                    <p class="font-medium text-gray-700">{{ substr($row->clock_in,0,5) }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Absen Pulang</p>
                    <p class="font-medium text-gray-700">{{ $row->clock_out ? substr($row->clock_out,0,5) : '-' }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </main>
</div>
@endsection