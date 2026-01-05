@extends('admin.layouts.app')

@section('title', 'Kelola Media - ' . $album->name)

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER WITH COVER --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-center gap-3">
                <div class="d-flex gap-3 align-items-start">
                    <img src="{{ $album->cover_url }}" 
                         alt="{{ $album->name }}" 
                         class="rounded shadow-sm" 
                         style="width: 70px; height: 70px; object-fit: cover;">
                    <div>
                        <h1 class="h5 fw-bold mb-1">{{ $album->name }}</h1>
                        <p class="text-muted mb-1 small">Kelola Foto & Video Album</p>
                        @if($album->date)
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">
                                <i class="fas fa-calendar-alt me-1"></i>{{ $album->date->format('d M Y') }}
                            </p>
                        @endif
                    </div>
                </div>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.albums.edit', $album) }}" class="btn btn-outline-warning btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <a href="{{ route('admin.albums.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="fas fa-arrow-left me-1"></i>Kembali
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- SUCCESS/ERROR MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- UPLOAD SECTION --}}
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary"><i class="fas fa-cloud-upload-alt me-2"></i>Upload Media Baru</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.albums.media.upload', $album) }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="uploadForm">
                @csrf
                
                <div class="border border-2 border-dashed rounded p-4 text-center bg-light" 
                     id="drop-zone"
                     style="border-color: #dee2e6; transition: all 0.3s;">
                    <input type="file" 
                           name="files[]" 
                           multiple 
                           accept="image/*,video/*"
                           id="file-upload"
                           class="d-none"
                           onchange="handleFiles(this.files)">
                    
                    <label for="file-upload" class="mb-0 w-100" style="cursor: pointer;">
                        <i class="fas fa-cloud-upload-alt text-primary mb-3" style="font-size: 3.5rem;"></i>
                        <p class="mb-2 fw-semibold">Klik untuk upload atau drag & drop</p>
                        <p class="small text-muted mb-1">Support: JPG, PNG, WebP, MP4, MOV</p>
                        <p class="small text-muted mb-0">(Max: 50MB per file)</p>
                    </label>
                </div>

                @error('files')
                    <div class="alert alert-danger mt-3 mb-0">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                    </div>
                @enderror

                <div id="file-list" class="mt-3 d-none">
                    <p class="fw-semibold mb-2 small">
                        <i class="fas fa-list me-2"></i>File yang dipilih:
                    </p>
                    <div id="file-names" class="overflow-auto" style="max-height: 300px;"></div>
                </div>

                <button type="submit" 
                        id="upload-btn"
                        class="btn btn-primary w-100 mt-3 d-none">
                    <i class="fas fa-cloud-upload-alt me-2"></i>Upload <span id="file-count">0</span> File
                </button>
            </form>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3 text-center">
                    <i class="fas fa-image text-purple mb-2" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 fw-bold mb-0">{{ $album->photos_count }}</h3>
                    <small class="text-muted">Total Foto</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3 text-center">
                    <i class="fas fa-video text-warning mb-2" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 fw-bold mb-0">{{ $album->videos_count }}</h3>
                    <small class="text-muted">Total Video</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3 text-center">
                    <i class="fas fa-folder text-primary mb-2" style="font-size: 1.5rem;"></i>
                    <h3 class="h5 fw-bold mb-0">{{ $album->media->count() }}</h3>
                    <small class="text-muted">Total Media</small>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3 text-center">
                    @if($album->is_published)
                        <i class="fas fa-check-circle text-success mb-2" style="font-size: 1.5rem;"></i>
                        <h5 class="fw-bold mb-0 text-success">Published</h5>
                    @else
                        <i class="fas fa-eye-slash text-secondary mb-2" style="font-size: 1.5rem;"></i>
                        <h5 class="fw-bold mb-0 text-secondary">Draft</h5>
                    @endif
                    <small class="text-muted">Status Album</small>
                </div>
            </div>
        </div>
    </div>

    {{-- MEDIA GRID --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-images me-2"></i>Media dalam Album
            </h6>
            @if($album->media->count() > 0)
                <span class="badge bg-primary">{{ $album->media->count() }} media</span>
            @endif
        </div>
        <div class="card-body">
            @if($album->media->count() === 0)
                <div class="text-center py-5">
                    <i class="fas fa-folder-open text-muted mb-3" style="font-size: 3rem;"></i>
                    <p class="text-muted mb-3 fw-semibold">Belum ada media dalam album ini</p>
                    <p class="text-muted small">Silakan upload foto atau video untuk memulai</p>
                </div>
            @else
                <div class="row g-3">
                    @foreach($album->media as $media)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="card border-0 shadow-sm h-100 position-relative media-card">
                            {{-- Media Content --}}
                            <div class="position-relative" style="padding-top: 100%; background: #f0f0f0;">
                                @if($media->type === 'photo')
                                    <img src="{{ $media->url }}" 
                                         alt="{{ $media->title }}" 
                                         class="position-absolute top-0 start-0 w-100 h-100 rounded-top cursor-pointer"
                                         style="object-fit: cover;"
                                         onclick="openLightbox('{{ $media->url }}', '{{ $media->title }}')">
                                @else
                                    <div class="position-absolute top-0 start-0 w-100 h-100 bg-dark rounded-top">
                                        <video class="w-100 h-100" style="object-fit: cover;" preload="metadata">
                                            <source src="{{ $media->url }}" type="{{ $media->mime_type ?? 'video/mp4' }}">
                                        </video>
                                        <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50 cursor-pointer" 
                                             onclick="openVideoModal('{{ $media->url }}', '{{ $media->title }}')">
                                            <i class="fas fa-play-circle text-white" style="font-size: 2.5rem;"></i>
                                        </div>
                                    </div>
                                @endif
                                
                                {{-- Type Badge --}}
                                <span class="position-absolute top-0 start-0 m-2 badge {{ $media->type === 'photo' ? 'bg-purple' : 'bg-warning' }}" style="font-size: 0.65rem;">
                                    <i class="fas fa-{{ $media->type === 'photo' ? 'image' : 'video' }} me-1"></i>
                                    {{ $media->type === 'photo' ? 'Foto' : 'Video' }}
                                </span>

                                {{-- Delete Button --}}
                                <form action="{{ route('admin.albums.media.destroy', [$album, $media]) }}" 
                                      method="POST"
                                      class="position-absolute top-0 end-0 m-2 media-action"
                                      onsubmit="return confirm('Yakin ingin menghapus media ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm rounded-circle p-0 shadow"
                                            style="width: 28px; height: 28px; font-size: 0.7rem;"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            
                            {{-- Media Info --}}
                            <div class="card-body p-2">
                                @if($media->title)
                                    <p class="small mb-1 fw-semibold text-truncate" title="{{ $media->title }}">{{ $media->title }}</p>
                                @endif
                                <p class="small text-muted mb-0" style="font-size: 0.7rem;">{{ $media->size_formatted ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>

{{-- LIGHTBOX MODAL --}}
<div class="modal fade" id="lightbox" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark">
            <div class="modal-header border-0">
                <h6 class="text-white mb-0" id="lightbox-title"></h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center p-0">
                <img id="lightbox-img" src="" alt="" class="img-fluid" style="max-height: 80vh;">
            </div>
        </div>
    </div>
</div>

{{-- VIDEO MODAL --}}
<div class="modal fade" id="video-modal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title mb-0" id="video-title"></h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-0">
                <video id="modal-video" controls class="w-100">
                    <source src="" type="video/mp4">
                    Browser tidak mendukung video.
                </video>
            </div>
        </div>
    </div>
</div>

<script>
// Handle file selection
function handleFiles(files) {
    const fileList = document.getElementById('file-list');
    const fileNames = document.getElementById('file-names');
    const uploadBtn = document.getElementById('upload-btn');
    const fileCount = document.getElementById('file-count');
    
    if (files.length > 0) {
        fileList.classList.remove('d-none');
        uploadBtn.classList.remove('d-none');
        fileNames.innerHTML = '';
        fileCount.textContent = files.length;
        
        Array.from(files).forEach((file, index) => {
            const fileType = file.type.startsWith('image/') ? 'image' : 'video';
            const icon = fileType === 'image' ? 'fa-image text-purple' : 'fa-video text-warning';
            const sizeMB = (file.size / 1024 / 1024).toFixed(2);
            const isTooBig = file.size > 50 * 1024 * 1024;
            
            const div = document.createElement('div');
            div.className = `alert ${isTooBig ? 'alert-danger' : 'alert-light'} d-flex justify-content-between align-items-center mb-2 py-2`;
            div.innerHTML = `
                <div class="d-flex align-items-center gap-2 flex-grow-1 overflow-hidden">
                    <i class="fas ${icon}"></i>
                    <span class="text-truncate small">${file.name}</span>
                </div>
                <span class="badge bg-secondary ms-2">${sizeMB} MB${isTooBig ? ' (Terlalu besar!)' : ''}</span>
            `;
            fileNames.appendChild(div);
        });
    }
}

// Drag & Drop
const dropZone = document.getElementById('drop-zone');
['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, e => {
        e.preventDefault();
        e.stopPropagation();
    });
});

['dragenter', 'dragover'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.style.borderColor = '#0d6efd';
        dropZone.style.backgroundColor = '#f0f8ff';
    });
});

['dragleave', 'drop'].forEach(eventName => {
    dropZone.addEventListener(eventName, () => {
        dropZone.style.borderColor = '#dee2e6';
        dropZone.style.backgroundColor = '';
    });
});

dropZone.addEventListener('drop', e => {
    const files = e.dataTransfer.files;
    document.getElementById('file-upload').files = files;
    handleFiles(files);
});

// Lightbox
let lightboxModal;
function openLightbox(url, title) {
    document.getElementById('lightbox-img').src = url;
    document.getElementById('lightbox-title').textContent = title || 'Foto';
    lightboxModal = new bootstrap.Modal(document.getElementById('lightbox'));
    lightboxModal.show();
}

// Video Modal
let videoModal;
function openVideoModal(url, title) {
    const video = document.getElementById('modal-video');
    document.getElementById('video-title').textContent = title || 'Video';
    video.querySelector('source').src = url;
    video.load();
    videoModal = new bootstrap.Modal(document.getElementById('video-modal'));
    videoModal.show();
    video.play();
}

// Pause video when modal closes
document.getElementById('video-modal').addEventListener('hidden.bs.modal', function () {
    const video = document.getElementById('modal-video');
    video.pause();
    video.currentTime = 0;
});
</script>

<style>
.cursor-pointer { cursor: pointer; }
.text-purple { color: #6f42c1 !important; }
.bg-purple { background-color: #6f42c1 !important; }

.media-action {
    opacity: 0;
    transition: opacity 0.2s;
}

.media-card:hover .media-action {
    opacity: 1;
}

@media (max-width: 768px) {
    .media-action {
        opacity: 1; /* Always show on mobile */
    }
}
</style>
@endsection