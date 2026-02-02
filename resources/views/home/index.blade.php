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
                    <i class="fas fa-sign-in-alt"></i> In Time
                </p>
                <p class="text-gray-500 text-sm">
                    @if($absensi)
                        {{ $absensi->clock_in ? substr($absensi->clock_in, 0, 5) : '-' }}
                    @else
                        -
                    @endif
                </p>
            </div>

            <div class="w-px h-10 bg-gray-300"></div>

            <div>
                <p class="text-amber-500 text-sm font-medium">
                    <i class="fas fa-sign-out-alt"></i> Out Time
                </p>
                <p class="text-gray-500 text-sm">
                    @if($absensi)
                        {{ $absensi->clock_out ? substr($absensi->clock_out, 0, 5) : '-' }}
                    @else
                        -
                    @endif
                </p>
            </div>
        </div>

        @if (!$absensi)
            {{-- <button onclick="window.location.href = '{{ route('absensi.in') }}'" class="w-full py-3 rounded-full text-white font-semibold shadow-md bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark active:scale-95 transition-all"> --}}
                {{-- <i class="fas fa-sign-in-alt pe-1"></i> Check In Time --}}
            {{-- </button> --}}
            <button onclick="openUploadModal()" class="w-full py-3 rounded-full text-white font-semibold shadow-md bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark active:scale-95 transition-all">
                <i class="fas fa-sign-in-alt pe-1"></i> Check In Time
            </button>
        @elseif($absensi && !$absensi->clock_out)
            {{-- <button onclick="window.location.href = '{{ route('absensi.out') }}'" class="w-full py-3 rounded-full text-white font-semibold shadow-md bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark active:scale-95 transition-all"> --}}
                {{-- <i class="fas fa-sign-in-alt pe-1"></i> Check Out Time --}}
            {{-- </button> --}}
            <button onclick="openUploadModal()" class="w-full py-3 rounded-full text-white font-semibold shadow-md bg-gradient-to-r from-primary to-primaryDark hover:from-primaryDark hover:to-primaryDark active:scale-95 transition-all">
                <i class="fas fa-sign-in-alt pe-1"></i> Check Out Time
            </button>
        @else
        @endif
    </div>
</div>

<div id="upload-modal" class="fixed inset-0 z-50 bg-black/50 hidden items-end justify-center">
    <!-- Modal Box -->
    <div id="upload-panel" class="w-full h-full bg-white transform translate-y-full transition-transform duration-300 overflow-y-auto">
        <!-- Header -->
        <div class="flex items-center justify-between px-4 py-4 border-b">
            <h2 class="text-lg font-semibold">
                @if(!$absensi)
                    Absen Pagi
                @elseif($absensi && !$absensi->clock_out)
                    Absen Sore
                @else
                @endif
            </h2>
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
            <p class="text-gray-500 mt-2 text-center mb-2">
                Hari ini, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
            </p>
            <!-- Action -->
            <form id="uploadForm" enctype="multipart/form-data">
                <!-- Drag Area -->
                <label for="file-input" id="drop-area" class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-emerald-500 hover:bg-emerald-50 transition text-center">
                    <i class="fas fa-cloud-upload-alt text-5xl text-emerald-600 mb-3"></i>
                    <p class="font-medium">Pilih foto dari galeri anda</p>
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
                <button id="uploadBtn" class="w-full py-3 mt-6 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition">Simpan</button>
                <button id="uploadBtnProcess" class="hidden w-full py-3 mt-6 bg-emerald-600 text-white rounded-xl font-medium hover:bg-emerald-700 transition disabled:opacity-70 disabled:cursor-not-allowed">Sedang mengunggah...</button>


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
    @include('home.script')
@endpush

@endsection