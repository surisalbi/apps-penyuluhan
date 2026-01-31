@extends('layouts.main')
@section('content')
<!-- Phone Frame -->
<div class="w-full bg-white">
    <!-- Header -->
    <div class="flex items-center gap-3 px-4 py-4 border-b bg-gray-100">
        <h1 class="flex flex-1 text-lg font-semibold text-gray-700">
            Absensi 
            <a href="#" onclick="openUploadModal()" class="ms-2 text-emerald-700"><i class="fas fa-plus-circle"></i></a>
        </h1>
    </div>
    <!-- Content -->
    <main class="px-4 py-4 space-y-4 pb-24">
        <form action="{{ route('absensi.show') }}" method="post" class="flex">
            @csrf
            <select name="bulan" class="flex flex-1 border border-gray-300 rounded-lg px-2 py-2 text-gray-700">
                <option value="" disabled selected>Tampilkan bulan</option>
                @for ($i=1; $i <= 12; $i++)
                <option value="{{ $i }}" {{ $i === (int) $bulan ? 'selected' : '' }}>
                    {{ \Carbon\Carbon::createFromDate(null, $i, 1)->translatedFormat('F') }}
                </option>
                @endfor
            </select>
            <button type="submit" class="ms-2 px-4 py-2 bg-gray-400 rounded-lg text-white">
                <i class="fas fa-search"></i>
            </button> 
            <button type="button" onclick="window.location.href='{{ route('absensi.download', $bulan) }}'" class="ms-2 px-4 py-2 bg-emerald-400 rounded-lg text-white">
                <i class="fas fa-download"></i>
            </button>
        </form>

        @if ($absensi->isEmpty())
            <div class="flex flex-col items-center justify-center py-16 px-6">
                <div class="flex items-center justify-center w-20 h-20 rounded-full bg-gray-100 mb-6">
                    <i class="fas fa-search text-gray-400 text-2xl"></i>
                </div>

                <h3 class="text-lg font-normal text-gray-700">
                    Data tidak ditemukan
                </h3>
            </div>

        @endif

        @foreach ($absensi as $row)
        <!-- Card -->
        <div class="{{ $loop->first ? 'bg-gray-100' : '' }} rounded-xl {{ $loop->first ? 'border-2' : 'border border-1' }} border-gray-250 p-4">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <p class="font-medium text-sm text-gray-700">
                        {{ \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y') }}
                    </p>
                </div>
                 @php
                    $bgColor = match($row->status) {
                        0     => 'bg-amber-100',
                        1     => 'bg-emerald-100',
                        default => 'gray'
                    };

                    $text = match($row->status) {
                        0     => 'Proses',
                        1     => 'Selesai',
                        default => '-'
                    };

                    $textColor = match($row->status) {
                        0     => 'text-amber-600',
                        1     => 'text-emerald-600',
                        default => '-'
                    };
                @endphp
                <span class="text-xs font-medium px-3 py-1 rounded-md {{ $bgColor }} {{ $textColor }}">
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

<div id="upload-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-end justify-center">
    <!-- Modal Box -->
    <div id="upload-panel" class="w-full max-h-[90vh] bg-white transform translate-y-full transition-transform duration-300 overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b">
            <h2 class="text-lg font-semibold">Absen</h2>
            <button onclick="closeUploadModal()" class="text-gray-500 text-xl">&times;</button>
        </div>

        <!-- Content -->
        <div class="p-6 space-y-6">
            <!-- Progress Wrapper -->
            <div id="progressWrapper" class="mt-4 hidden">
                <div class="flex justify-between text-xs mb-1">
                    <span id="progressLabel" class="text-gray-600">Mengunggah...</span>
                    <span id="progressText" class="text-gray-600">0%</span>
                </div>

                <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                    <div
                        id="progressBar"
                        class="h-full w-0 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full transition-all duration-300 ease-out"
                    ></div>
                </div>
            </div>
            <!-- Action -->
            <form id="uploadForm" method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data">
                <!-- Drag Area -->
                <label for="file-input" id="drop-area" class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition text-center">
                    <i class="fas fa-cloud-upload-alt text-5xl text-emerald-600 mb-3"></i>
                    <p class="font-medium">Upload Foto</p>
                    <p class="text-sm text-gray-500">Pilih foto dri galeri anda</p>
                </label>

                <!-- Preview Area -->
                <div id="preview-container" class="hidden space-y-4">
                    <!-- Grid Foto -->
                    <div class="grid grid-cols-2 gap-3" id="preview-grid"></div>

                    <!-- Action Preview -->
                    <div class="flex gap-3">
                        <button id="add-btn" class="flex-1 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                            <i class="fas fa-plus"></i>
                        </button>

                        <button id="clear-btn" class="flex-1 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <!-- Info -->
                <p class="text-xs text-gray-500 text-center mt-3">Format JPG, PNG &#183; Maks 5MB</p>

                
                <!-- Hidden Input -->
                <input type="file" name="photo[]" id="file-input" accept="image/*" class="hidden" multiple/>
                <select name="jenis_absen" id="" class="border border-gray-400 rounded-lg w-full p-[14px] mt-5 mb-5 text-gray-700">
                    <option value="" disabled selected>Pilih Absen Pagi / Sore</option>
                    <option value="pagi">Pagi</option>
                    <option value="sore">Sore</option>
                </select>
                <input type="date" name="tanggal" class="border border-gray-400 rounded-lg w-full p-3 mb-5 text-gray-700">
                <button id="uploadBtn" class="w-full py-3 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">Upload</button>


                <!-- Progress Wrapper -->
                <div id="progressWrapper" class="mt-4 hidden">
                    <div class="flex justify-between text-xs mb-1">
                        <span id="progressLabel" class="text-gray-600">Mengunggah...</span>
                        <span id="progressText" class="text-gray-600">0%</span>
                    </div>

                    <div class="w-full h-6 bg-gray-200 rounded-full overflow-hidden">
                        <div
                            id="progressBar"
                            class="h-full w-0 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-full transition-all duration-300 ease-out"
                        ></div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>

@push('scripts')
    @include('absensi.script')
@endpush

@endsection