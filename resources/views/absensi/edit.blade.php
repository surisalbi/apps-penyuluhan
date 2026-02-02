@extends('layouts.main')

@section('no-navigation')
@endsection

@section('content')
<div class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="flex items-center gap-3 px-4 py-3">
            <button onclick="window.location.href='{{ route('absensi') }}'" class="text-gray-600">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Ubah Data Absen</h1>
        </div>
    </header>
    
    <!-- Content -->
    <main class="pt-20 px-4 pb-6 w-full">
    
        <!-- Card -->
        <div class="bg-white rounded-2xl text-gray-700 shadow-md p-6">
            @error('foto_in')
                <!-- Alert statis -->
                <div class="w-full text-sm mx-auto bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-full flex items-center space-x-3 mb-4" role="alert">
                    <!-- Icon -->
                    <i class="fas fa-info-circle"></i>

                    <!-- Message -->
                    <span class="font-medium">{{ $message }}</span>
                </div>
            @enderror
            @error('foto_out')
                <!-- Alert statis -->
                <div class="w-full text-sm mx-auto bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-full flex items-center space-x-3 mb-4" role="alert">
                    <!-- Icon -->
                    <i class="fas fa-info-circle"></i>

                    <!-- Message -->
                    <span class="font-medium">{{ $message }}</span>
                </div>
            @enderror
            @if (session('success'))
                <!-- Alert statis -->
                <div class="w-full max-w-sm mx-auto bg-emerald-100 border border-emerald-400 text-emerald-800 px-4 py-3 rounded-full text-sm flex items-center space-x-3 mt-4" role="alert">
                    <!-- Icon -->
                    <i class="fas fa-info-circle"></i>

                    <!-- Message -->
                    <span class="font-medium">{{ session('success') }}</span>
                </div>

            @endif

            <form action="{{ route('absensi.update', encrypt($absensi->id)) }}" method="post" enctype="multipart/form-data" onsubmit="handleSubmit()">
                @csrf
                @method('PUT')
                <div class="w-full grid mb-6">
                    <label for="tanggal" class="text-sm mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $absensi->tanggal }}">
                </div>
                <div class="fw-full grid mb-6">
                    <label for="clock_in" class="text-sm mb-1">Jam Pagi</label>
                    <input type="time" name="clock_in" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $absensi->clock_in }}">
                </div>
                <div class="fw-full grid mb-6">
                    <label for="clock_out" class="text-sm mb-1">Jam Sore</label>
                    <input type="time" name="clock_out" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $absensi->clock_out }}">
                </div>
                <div class="flex flex-col gap-2 mb-6">
                    <label class="text-sm">Foto Pagi</label>
                    <img
                        id="preview_foto_in"
                        src="{{ asset($absensi->foto_in) }}"
                        data-original="{{ asset($absensi->foto_in) }}"
                        class="w-full rounded-lg border object-cover"
                        alt="foto in">

                    <div class="flex items-center gap-2">
                        <label for="foto_in" class="w-16 rounded-md bg-blue-500 text-white px-2 py-1 text-sm text-center">
                            Ubah
                        </label>
                        <input id="foto_in" type="file" name="foto_in" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_foto_in')">
                        <button
                            type="button"
                            onclick="resetImage('preview_foto_in', this)"
                            class="w-24 rounded-md bg-red-400 px-2 py-1 hidden text-sm text-white hover:underline">
                            Hapus foto
                        </button>
                    </div>
                </div>
                <div class="flex flex-col gap-2">
                    <label class="text-sm">Foto Sore</label>
                    <img
                        id="preview_foto_out"
                        src="{{ asset($absensi->foto_out) }}"
                        data-original="{{ asset($absensi->foto_out) }}"
                        class="w-full rounded-lg border object-cover"
                        alt="foto out">
                    <div class="flex items-center gap-2">
                        <label for="foto_out" class="w-16 rounded-md bg-blue-500 text-white px-2 py-1 text-sm text-center">
                            Ubah
                        </label>
                        <input id="foto_out" type="file" name="foto_out" class="hidden" accept="image/*" onchange="previewImage(event, 'preview_foto_out')">
                        <button
                            type="button"
                            onclick="resetImage('preview_foto_out', this)"
                            class="w-24 rounded-md bg-red-400 px-2 py-1 hidden text-sm text-white hover:underline">
                            Hapus foto
                        </button>
                    </div>
                </div>

                <button id="btnSubmit" class="w-full bg-emerald-500 text-white px-3 py-2 mt-6 rounded-md hover:bg-emerald-700">
                    <i class="fas fa-check-circle me-1"></i>
                    <span id="btnText">Simpan</span>
                </button>

            </form>
            <form action="{{ route('absensi.destroy', encrypt($absensi->id)) }}" method="post" onsubmit="handleDelete()">
                @csrf
                @method('DELETE')
                <button id="btnDelete" class="w-full bg-red-500 text-white px-3 py-2 mt-6 rounded-md hover:bg-red-700">
                    <i class="fas fa-check-circle me-1"></i>
                    <span id="btnTextDel">Hapus</span>
                </button>
            </form>
        </div>
    
    </main>
</div>

@push('scripts')
    <script>
        function previewImage(event, previewId) {
            const input = event.target;
            const img = document.getElementById(previewId);
            const deleteBtn = input.nextElementSibling;

            if (input.files && input.files[0]) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    img.src = e.target.result;
                };

                reader.readAsDataURL(input.files[0]);

                deleteBtn.classList.remove('hidden');
            }
        }

        function resetImage(previewId, button) {
            const img = document.getElementById(previewId);
            const original = img.dataset.original;
            const input = button.previousElementSibling;

            img.src = original;
            input.value = '';
            button.classList.add('hidden');
        }
    </script>

    <script>
        function handleSubmit() {
            const btn = document.getElementById('btnSubmit');
            const text = document.getElementById('btnText');

            btn.disabled = true;
            text.textContent = 'Sedang mengupdate...';
        }

        function handleDelete() {
            const btnDel = document.getElementById('btnDelete');
            const textDel = document.getElementById('btnTextDel');

            btnDel.disabled = true;
            textDel.textContent = 'Sedang menghapus...';
        }
    </script>

@endpush

@endsection