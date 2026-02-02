@extends('layouts.main')

@section('no-navigation')
@endsection

@section('content')
<div class="bg-gray-100 min-h-screen">

    <!-- Header -->
    <header class="fixed top-0 left-0 right-0 bg-white shadow-sm z-50">
        <div class="flex items-center gap-3 px-4 py-3">
            <button onclick="window.location.href='{{ route('upload') }}'" class="text-gray-600">
                <i class="fas fa-chevron-left"></i>
            </button>
            <h1 class="text-lg font-semibold text-gray-800">Ubah Data Screenshot</h1>
        </div>
    </header>
    
    <!-- Content -->
    <main class="pt-20 px-4 pb-6 w-full">
    
        <!-- Card -->
        <div class="bg-white rounded-2xl text-gray-700 shadow-md p-6">
            @error('kategori')
                <!-- Alert statis -->
                <div class="w-full text-sm mx-auto bg-red-100 border border-red-400 text-red-800 px-4 py-3 rounded-full flex items-center space-x-3 mb-4" role="alert">
                    <!-- Icon -->
                    <i class="fas fa-info-circle"></i>

                    <!-- Message -->
                    <span class="font-medium">{{ $message }}</span>
                </div>
            @enderror
            @error('tanggal')
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

            <form action="{{ route('upload.update', encrypt($upload->id)) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="w-full grid mb-6">
                    <label for="kategori" class="text-sm mb-1">Kategori</label>
                    <select name="kategori" id="kategori" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="" disabled selected>Pilih</option>
                        <option {{ $upload->kategori == "like" ? 'selected' : '' }} value="like">Like</option>
                        <option {{ $upload->kategori == "comment" ? 'selected' : '' }} value="comment">Comment</option>
                        <option {{ $upload->kategori == "share" ? 'selected' : '' }} value="share">Share</option>
                    </select>
                </div>
                <div class="w-full grid mb-6">
                    <label for="tanggal" class="text-sm mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="border border-gray-200 rounded-lg px-3 py-2 focus:outline-none focus:ring-1 focus:ring-emerald-500 focus:border-emerald-500" value="{{ $upload->tanggal }}">
                </div>

                <button class="w-full bg-emerald-500 text-white px-3 py-2 mt-6 rounded-md hover:bg-emerald-700">
                    <i class="fas fa-check-circle me-1"></i>
                    Simpan
                </button>

            </form>
        </div>
    
    </main>
</div>

@endsection