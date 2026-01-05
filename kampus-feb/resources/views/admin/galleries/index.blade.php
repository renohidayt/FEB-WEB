@extends('admin.layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Upload New Media</h4>
                    <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Gallery
                    </a>
                </div>
                <div class="card-body">
                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Oops!</strong> There were some problems with your input:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('admin.galleries.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="file_type" class="form-label">Media Type <span class="text-danger">*</span></label>
                            <select name="file_type" id="file_type" class="form-select @error('file_type') is-invalid @enderror" required>
                                <option value="">-- Select Type --</option>
                                <option value="image" {{ old('file_type') == 'image' ? 'selected' : '' }}>Image</option>
                                <option value="video" {{ old('file_type') == 'video' ? 'selected' : '' }}>Video</option>
                            </select>
                            @error('file_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Choose the type of media you want to upload</small>
                        </div>

                        <div class="mb-3">
                            <label for="file" class="form-label">File Upload <span class="text-danger">*</span></label>
                            <input type="file" 
                                   name="file" 
                                   id="file" 
                                   class="form-control @error('file') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg,video/mp4,video/quicktime"
                                   required>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">
                                Accepted formats: JPEG, PNG, JPG, MP4, MOV | Max size: 50MB
                            </small>
                        </div>

                        <div class="mb-3">
                            <div id="preview-container" class="mt-3" style="display: none;">
                                <label class="form-label">Preview:</label>
                                <div id="image-preview" style="display: none;">
                                    <img id="preview-image" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px;">
                                </div>
                                <div id="video-preview" style="display: none;">
                                    <video id="preview-video" controls class="img-thumbnail" style="max-width: 400px;">
                                        <source src="" type="video/mp4">
                                    </video>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" 
                                   name="title" 
                                   id="title" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   value="{{ old('title') }}"
                                   maxlength="255"
                                   placeholder="Enter media title (optional)">
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="caption" class="form-label">Caption</label>
                            <textarea name="caption" 
                                      id="caption" 
                                      rows="3" 
                                      class="form-control @error('caption') is-invalid @enderror" 
                                      placeholder="Enter caption or description (optional)">{{ old('caption') }}</textarea>
                            @error('caption')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="album" class="form-label">Album</label>
                            <input type="text" 
                                   name="album" 
                                   id="album" 
                                   class="form-control @error('album') is-invalid @enderror" 
                                   value="{{ old('album') }}"
                                   maxlength="100"
                                   placeholder="Enter album name (optional)">
                            @error('album')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="form-text text-muted">Group related media by album name</small>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('admin.galleries.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload"></i> Upload Media
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const fileInput = document.getElementById('file');
    const previewContainer = document.getElementById('preview-container');
    const imagePreview = document.getElementById('image-preview');
    const videoPreview = document.getElementById('video-preview');
    const previewImage = document.getElementById('preview-image');
    const previewVideo = document.getElementById('preview-video');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const fileType = file.type;
            const reader = new FileReader();

            reader.onload = function(event) {
                previewContainer.style.display = 'block';
                
                if (fileType.startsWith('image/')) {
                    imagePreview.style.display = 'block';
                    videoPreview.style.display = 'none';
                    previewImage.src = event.target.result;
                } else if (fileType.startsWith('video/')) {
                    imagePreview.style.display = 'none';
                    videoPreview.style.display = 'block';
                    previewVideo.querySelector('source').src = event.target.result;
                    previewVideo.load();
                }
            };

            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    });
});
</script>
@endpush
@endsection