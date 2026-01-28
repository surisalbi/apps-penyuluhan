@extends('layouts.main')
@section('content')
<!-- Header -->
<header class="sticky top-0 z-10 bg-white shadow-sm">
    <div class="px-4 py-4 flex items-center justify-between bg-white">
        <h1 class="text-lg font-semibold">Upload Screenshot</h1>
        <button onclick="openUploadModal()" class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-white bg-emerald-500 rounded-full shadow hover:bg-emerald-700 transition">
            <i class="fas fa-upload text-sm"></i>
        </button>
    </div>

    <!-- Tabs -->
    <div class="flex border-t">
        <button
            class="tab-btn flex-1 py-3 text-center text-sm text-gray-500
                border-b-2 border-transparent"
        >
            <i class="fas fa-heart"></i> Like
        </button>

        <button
            class="tab-btn flex-1 py-3 text-center text-sm text-gray-500
                border-b-2 border-transparent"
        >
            <i class="fas fa-comment"></i> Comment
        </button>

        <button
            class="tab-btn flex-1 py-3 text-center text-sm text-gray-500
                border-b-2 border-transparent"
        >
            <i class="fas fa-share-alt"></i> Share
        </button>
    </div>


</header>

<!-- Content -->
<main class="px-4 py-4 pb-24">
    <!-- Like -->
    <section class="tab-content grid grid-cols-2 gap-3" id="like">
        @for ($i=1; $i <= 10; $i++)
        <div class="relative aspect-[5/6] rounded-xl overflow-hidden shadow-sm">
            <img src="https://picsum.photos/800/1000?{{ $i }}" class="w-full h-full object-cover photo-item"/>
            <!-- Caption -->
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                <p class="text-sm text-white font-medium">09:15 · 26 Jan 2026</p>
                <p class="text-xs text-gray-200 truncate">Jakarta, Indonesia</p>
            </div>
        </div>
        @endfor
    </section>

    <!-- Comment -->
    <section class="tab-content hidden grid grid-cols-2 gap-3" id="comment">
        @for ($i=10; $i <= 20; $i++)
        <div class="relative aspect-[5/6] rounded-xl overflow-hidden shadow-sm">
            <img src="https://picsum.photos/800/1000?{{ $i }}" class="w-full h-full object-cover photo-item"/>
            <!-- Caption -->
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                <p class="text-sm text-white font-medium">09:15 · 26 Jan 2026</p>
                <p class="text-xs text-gray-200 truncate">Jakarta, Indonesia</p>
            </div>
        </div>
        @endfor
    </section>

    <!-- Share -->
    <section class="tab-content hidden grid grid-cols-2 gap-3" id="share">
        @for ($i=20; $i <= 30; $i++)
        <div class="relative aspect-[5/6] rounded-xl overflow-hidden shadow-sm">
            <img src="https://picsum.photos/800/1000?{{ $i }}" class="w-full h-full object-cover photo-item"/>
            <!-- Caption -->
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/70 to-transparent p-3">
                <p class="text-sm text-white font-medium">09:15 · 26 Jan 2026</p>
                <p class="text-xs text-gray-200 truncate">Jakarta, Indonesia</p>
            </div>
        </div>
        @endfor
    </section>
</main>

<!-- Modal Preview -->
<div
    id="photo-modal"
    class="fixed inset-0 bg-black/80 hidden items-center justify-center z-50"
>
    <!-- Modal Content -->
    <div class="relative">
    <!-- Delete Button -->
    <button
        id="delete-btn"
        class="absolute top-3 right-3 z-10 w-9 h-9 flex items-center justify-center rounded-full bg-gray-200 text-gray-500 shadow-2xl hover:bg-gray-300 transition"
        title="Hapus Foto"
    >
        <i class="fas fa-trash text-sm"></i>
    </button>

    <!-- Image -->
    <img
        id="modal-img"
        class="max-w-[90vw] max-h-[90vh] rounded-xl shadow-lg"
    />
    </div>
</div>

<div
    id="upload-modal"
    class="fixed inset-0 z-50 bg-black/50 hidden items-end justify-center"
>
    <!-- Modal Box -->
    <div
    id="upload-panel"
    class="w-full max-h-[90vh] bg-white transform translate-y-full transition-transform duration-300 overflow-y-auto"
    >
    <!-- Header -->
    <div class="flex items-center justify-between px-4 py-4 border-b">
        <h2 class="text-lg font-semibold">Upload Foto</h2>
        <button onclick="closeUploadModal()" class="text-gray-500 text-xl">
        &times;
        </button>
    </div>

    <!-- Content -->
    <div class="p-6 space-y-6">
        <!-- Drag Area -->
        <label
        for="file-input"
        id="drop-area"
        class="flex flex-col items-center justify-center h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition text-center"
        >
        <i class="fas fa-cloud-upload-alt text-5xl text-blue-600 mb-3"></i>
        <p class="font-medium">Upload Foto</p>
        <p class="text-sm text-gray-500">Pilih foto dri galeri anda</p>
        </label>

        <!-- Hidden Input -->
        <input
        type="file"
        id="file-input"
        accept="image/*"
        class="hidden"
        multiple
        />

        <!-- Preview Area -->
        <div id="preview-container" class="hidden space-y-4">
        <!-- Grid Foto -->
        <div class="grid grid-cols-2 gap-3" id="preview-grid"></div>

        <!-- Action Preview -->
        <div class="flex gap-3">
            <button
            id="add-btn"
            class="flex-1 py-2 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
            >
            <i class="fas fa-plus"></i>
            </button>

            <button
            id="clear-btn"
            class="flex-1 py-2 rounded-xl bg-red-500 text-white hover:bg-red-600 transition"
            >
            <i class="fas fa-trash"></i>
            </button>
        </div>
        </div>

        <!-- Info -->
        <p class="text-xs text-gray-500 text-center">
        Format JPG, PNG · Maks 5MB
        </p>

        <!-- Action -->
        <button
        class="w-full py-3 bg-blue-600 text-white rounded-xl font-medium shadow hover:bg-blue-700 transition"
        >
        Upload
        </button>
    </div>
    </div>
</div>
@endsection