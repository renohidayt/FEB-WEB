@extends('admin.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Gallery Management</h1>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
            📤 Upload Media
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    @if($galleries->count() > 0)
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Preview</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Caption</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Album</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created At</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($galleries as $gallery)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $gallery->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($gallery->file_type === 'image')
                        <img src="{{ asset('storage/' . $gallery->file_path) }}" alt="{{ $gallery->title }}" class="w-16 h-16 object-cover rounded">
                        @else
                        <video class="w-16 h-16 object-cover rounded" muted>
                            <source src="{{ asset('storage/' . $gallery->file_path) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $gallery->title ?? '-' }}</td>
                    <td class="px-6 py-4 text-sm text-gray-900">
                        @if($gallery->caption)
                        {{ Str::limit($gallery->caption, 50) }}
                        @else
                        -
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        @if($gallery->file_type === 'image')
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded">Image</span>
                        @else
                        <span class="px-2 py-1 bg-purple-100 text-purple-800 rounded">Video</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $gallery->album ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $gallery->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                        <form action="{{ route('admin.gallery.destroy', $gallery->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4 flex justify-between items-center">
        <div class="text-sm text-gray-700">
            Showing {{ $galleries->firstItem() }} to {{ $galleries->lastItem() }} of {{ $galleries->total() }} entries
        </div>
        <div>
            {{ $galleries->links() }}
        </div>
    </div>
    @else
    <div class="bg-white shadow-md rounded-lg p-12 text-center">
        <p class="text-gray-500 mb-4">No media found in gallery.</p>
        <button onclick="openModal()" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
            📤 Upload First Media
        </button>
    </div>
    @endif
</div>

<!-- Upload Modal -->
<div id="uploadModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full mx-4 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center p-6 border-b">
            <h2 class="text-2xl font-bold text-gray-800">Upload Media</h2>
            <button onclick="closeModal()" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
        </div>
        
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <!-- Media Type Selection -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Media Type</label>
                <select id="mediaType" onchange="toggleMediaType()" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <option value="image">Image</option>
                    <option value="video">Video</option>
                </select>
            </div>

            <!-- Image Upload -->
            <div id="imageUpload" class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Upload Image</label>
                <input type="file" name="image" accept="image/*" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF | Max: 5MB</p>
            </div>

            <!-- Video Options -->
            <div id="videoEmbed" class="mb-6 hidden">
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                    <p class="text-sm text-blue-800">
                        💡 <strong>Tips:</strong> Untuk hasil terbaik, upload video langsung (format MP4) agar autoplay lancar dan tanpa loading.
                    </p>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Pilih Sumber Video</label>
                    <select id="videoSource" onchange="toggleVideoSource()" class="w-full border border-gray-300 rounded-lg px-4 py-2 mb-4">
                        <option value="upload">Upload Video Langsung (Recommended)</option>
                        <option value="embed">Embed dari Platform Lain</option>
                    </select>
                </div>
                
                <!-- Upload Video File -->
                <div id="videoUploadSection">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Upload Video File <span class="text-green-600">(Recommended)</span>
                    </label>
                    <input type="file" name="video_file" accept="video/mp4,video/webm,video/ogg" onchange="previewVideo(this)" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-xs text-gray-500 mt-1">
                        Format: MP4, WebM, OGG | Max: 50MB | Rekomendasi: 1920x1080px, durasi 10-30 detik
                    </p>
                    <div id="videoPreview" class="mt-4 hidden">
                        <video id="previewVideo" class="max-w-md rounded-lg shadow" controls muted></video>
                    </div>
                </div>
                
                <!-- Embed dari Platform -->
                <div id="videoEmbedSection" class="hidden">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Platform Video</label>
                        <select name="video_platform" class="w-full border border-gray-300 rounded-lg px-4 py-2">
                            <option value="youtube">YouTube</option>
                            <option value="vimeo">Vimeo</option>
                            <option value="custom">Custom URL</option>
                        </select>
                        <p class="text-xs text-yellow-600 mt-1">
                            ⚠️ Instagram dan TikTok tidak mendukung autoplay embed dengan baik
                        </p>
                    </div>
                    
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Video</label>
                    <input type="url" name="video_embed" value="{{ old('video_embed') }}" placeholder="https://www.youtube.com/watch?v=..." class="w-full border border-gray-300 rounded-lg px-4 py-2">
                    <p class="text-xs text-gray-500 mt-1">
                        Masukkan URL lengkap video dari platform yang dipilih
                    </p>
                </div>
            </div>

            <!-- Title -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Title (Optional)</label>
                <input type="text" name="title" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <!-- Caption -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Caption (Optional)</label>
                <textarea name="caption" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-2"></textarea>
            </div>

            <!-- Album -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Album (Optional)</label>
                <input type="text" name="album" class="w-full border border-gray-300 rounded-lg px-4 py-2">
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition duration-200">
                    Cancel
                </button>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Upload Media
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal() {
    document.getElementById('uploadModal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('uploadModal').classList.add('hidden');
}

function toggleMediaType() {
    const mediaType = document.getElementById('mediaType').value;
    const imageUpload = document.getElementById('imageUpload');
    const videoEmbed = document.getElementById('videoEmbed');
    
    if (mediaType === 'image') {
        imageUpload.classList.remove('hidden');
        videoEmbed.classList.add('hidden');
    } else {
        imageUpload.classList.add('hidden');
        videoEmbed.classList.remove('hidden');
    }
}

function toggleVideoSource() {
    const source = document.getElementById('videoSource').value;
    const uploadSection = document.getElementById('videoUploadSection');
    const embedSection = document.getElementById('videoEmbedSection');
    
    if (source === 'upload') {
        uploadSection.classList.remove('hidden');
        embedSection.classList.add('hidden');
    } else {
        uploadSection.classList.add('hidden');
        embedSection.classList.remove('hidden');
    }
}

function previewVideo(input) {
    if (input.files && input.files[0]) {
        const video = document.getElementById('previewVideo');
        const preview = document.getElementById('videoPreview');
        
        video.src = URL.createObjectURL(input.files[0]);
        preview.classList.remove('hidden');
    }
}

// Initialize
toggleMediaType();
toggleVideoSource();
</script>
@endsection