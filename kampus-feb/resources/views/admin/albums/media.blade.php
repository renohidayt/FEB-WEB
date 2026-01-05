@extends('admin.layouts.app')

@section('page-title', 'Kelola Media - ' . $album->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">{{ $album->name }}</h2>
            <p class="text-gray-600">Kelola Foto & Video</p>
        </div>
        <a href="{{ route('admin.albums.index') }}" 
           class="px-4 py-2 border rounded-lg font-semibold hover:bg-gray-50">
            ← Kembali
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        {{ session('success') }}
    </div>
    @endif

    <!-- Upload Section -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-lg mb-4">Upload Media Baru</h3>
        
        <form action="{{ route('admin.albums.media.upload', $album) }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf
            
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                <input type="file" 
                       name="files[]" 
                       multiple 
                       accept="image/*,video/*"
                       id="file-upload"
                       class="hidden"
                       onchange="showFileNames(this)">
                
                <label for="file-upload" class="cursor-pointer">
                    <div class="text-6xl mb-4">📤</div>
                    <p class="text-gray-600 mb-2">Klik untuk upload atau drag & drop</p>
                    <p class="text-sm text-gray-500">Support: JPG, PNG, MP4, MOV (Max: 50MB per file)</p>
                </label>
            </div>

            <div id="file-list" class="mt-4 hidden">
                <p class="font-semibold mb-2">File yang dipilih:</p>
                <div id="file-names" class="space-y-2"></div>
            </div>

            @error('files')
            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
            @enderror

            <button type="submit" 
                    id="upload-btn"
                    class="mt-4 w-full bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold hidden">
                📤 Upload File
            </button>
        </form>
    </div>

    <!-- Media Grid -->
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-lg mb-4">
            Media dalam Album ({{ $album->photos_count }} foto, {{ $album->videos_count }} video)
        </h3>
        
        @if($album->media->count() === 0)
        <p class="text-gray-500 text-center py-8">Belum ada media dalam album ini</p>
        @else
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @foreach($album->media as $media)
            <div class="relative group">
                <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
                    @if($media->type === 'photo')
                    <img src="{{ $media->url }}" 
                         alt="{{ $media->title }}" 
                         class="w-full h-full object-cover">
                    @else
                    <div class="w-full h-full flex items-center justify-center bg-gray-200">
                        <span class="text-6xl">🎥</span>
                    </div>
                    @endif
                </div>
                
                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                    <form action="{{ route('admin.albums.media.destroy', [$album, $media]) }}" 
                          method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus media ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-500 text-white p-2 rounded-full hover:bg-red-600 shadow-lg">
                            🗑️
                        </button>
                    </form>
                </div>
                
                <p class="mt-2 text-sm text-gray-600 truncate">{{ $media->title }}</p>
                <p class="text-xs text-gray-400">{{ $media->size_formatted }}</p>
            </div>
            @endforeach
        </div>
        @endif
    </div>
</div>

<script>
function showFileNames(input) {
    const fileList = document.getElementById('file-list');
    const fileNames = document.getElementById('file-names');
    const uploadBtn = document.getElementById('upload-btn');
    
    if (input.files.length > 0) {
        fileList.classList.remove('hidden');
        uploadBtn.classList.remove('hidden');
        fileNames.innerHTML = '';
        
        Array.from(input.files).forEach(file => {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between bg-gray-50 p-3 rounded';
            div.innerHTML = `
                <span class="text-sm">${file.name}</span>
                <span class="text-xs text-gray-500">${(file.size / 1024 / 1024).toFixed(2)} MB</span>
            `;
            fileNames.appendChild(div);
        });
    }
}
</script>
@endsection
