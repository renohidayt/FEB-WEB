@extends('admin.layouts.app')

@section('title', 'Tambah Berita')

@push('styles')
<style>
    .image-preview {
        max-width: 100%;
        max-height: 350px;
        object-fit: cover;
        border-radius: 10px;
    }
    
    .gallery-preview {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.75rem;
        margin-top: 1rem;
    }
    
    .gallery-item {
        position: relative;
        border-radius: 8px;
        overflow: hidden;
        border: 2px solid #e5e7eb;
        background: white;
        transition: all 0.2s;
    }
    
    .gallery-item:hover {
        border-color: #0d6efd;
        box-shadow: 0 2px 8px rgba(13, 110, 253, 0.2);
    }
    
    .gallery-item img {
        width: 100%;
        height: 150px;
        object-fit: cover;
    }
    
    .gallery-item .remove-btn {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
        background: rgba(220, 53, 69, 0.95);
        color: white;
        border-radius: 50%;
        width: 26px;
        height: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        font-size: 14px;
        transition: all 0.2s;
        border: none;
    }
    
    .gallery-item .remove-btn:hover {
        background: #dc3545;
        transform: scale(1.1);
    }

    .sticky-sidebar {
        position: sticky;
        top: 100px;
    }
</style>
@endpush

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Berita Baru</h1>
            <p class="text-muted small mb-0">Buat dan publikasikan artikel berita baru.</p>
        </div>
        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data" id="newsForm">
        @csrf

        <div class="row">
            {{-- KOLOM KIRI: FORM --}}
            <div class="col-lg-8">
                
                {{-- 1. INFORMASI DASAR --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Informasi Dasar</h6>
                    </div>
                    <div class="card-body">
                        {{-- Judul --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Judul Berita <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title') }}" 
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Masukkan judul berita yang menarik..."
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Kategori & Penulis --}}
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                                <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nama Penulis</label>
                                <input type="text" 
                                       name="author_name" 
                                       value="{{ old('author_name') }}" 
                                       class="form-control @error('author_name') is-invalid @enderror"
                                       placeholder="Contoh: John Doe">
                                <small class="text-muted">Default: <strong>{{ auth()->user()->name }}</strong></small>
                                @error('author_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. KONTEN --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-file-alt me-2"></i>Konten Berita</h6>
                    </div>
                    <div class="card-body">
                        {{-- Content Editor --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Konten <span class="text-danger">*</span></label>
                            <textarea name="content" 
                                      id="content" 
                                      rows="12" 
                                      class="form-control @error('content') is-invalid @enderror"
                                      placeholder="Tulis konten berita di sini...">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Excerpt --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small">Ringkasan (Excerpt)</label>
                            <textarea name="excerpt" 
                                      rows="3" 
                                      class="form-control @error('excerpt') is-invalid @enderror"
                                      placeholder="Tulis ringkasan singkat...">{{ old('excerpt') }}</textarea>
                            <small class="text-muted">Kosongkan untuk auto-generate dari konten</small>
                            @error('excerpt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- 3. MEDIA --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-images me-2"></i>Media & Gambar</h6>
                    </div>
                    <div class="card-body">
                        {{-- Featured Image --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Gambar Unggulan</label>
                            <div class="border border-2 border-dashed rounded p-4 text-center bg-light" style="cursor: pointer;" onclick="document.getElementById('featured_image').click()">
                                <input type="file" name="featured_image" id="featured_image" accept="image/*" class="d-none">
                                <i class="fas fa-cloud-upload-alt text-muted mb-2" style="font-size:2.5rem"></i>
                                <p class="mb-1 fw-semibold">Klik untuk upload gambar</p>
                                <small class="text-muted">PNG, JPG, WEBP hingga 2MB</small>
                            </div>
                            @error('featured_image')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                            
                            {{-- Preview --}}
                            <div id="imagePreview" class="mt-3 d-none">
                                <p class="fw-bold small mb-2">Preview:</p>
                                <div class="position-relative d-inline-block">
                                    <img id="preview" src="" alt="Preview" class="image-preview border border-2 border-primary shadow-sm">
                                    <button type="button" id="removeImage" class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2">
                                        <i class="fas fa-times me-1"></i> Hapus
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Gallery --}}
                        <div class="card bg-light border-0">
                            <div class="card-body p-3">
                                <label class="form-label fw-bold small">Galeri Foto (Opsional)</label>
                                <p class="small text-muted mb-2">Upload beberapa foto untuk galeri berita</p>
                                
                                <input type="file" name="additional_images[]" id="additionalImages" accept="image/*" multiple class="form-control form-control-sm">
                                
                                <div id="galleryPreview" class="gallery-preview"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 4. SEO --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-search me-2"></i>Optimasi SEO (Opsional)</h6>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Meta Title</label>
                            <input type="text" name="meta_title" value="{{ old('meta_title') }}" 
                                   maxlength="60" class="form-control form-control-sm"
                                   placeholder="Judul untuk mesin pencari">
                            <small class="text-muted">Maksimal 60 karakter</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Meta Description</label>
                            <textarea name="meta_description" rows="2" maxlength="160" 
                                      class="form-control form-control-sm"
                                      placeholder="Deskripsi untuk mesin pencari">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">Maksimal 160 karakter</small>
                        </div>
                        
                        <div class="mb-0">
                            <label class="form-label fw-bold small">Meta Keywords</label>
                            <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" 
                                   class="form-control form-control-sm" 
                                   placeholder="berita, teknologi, indonesia">
                            <small class="text-muted">Pisahkan dengan koma</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: SIDEBAR --}}
            <div class="col-lg-4">
                <div class="card shadow-sm sticky-sidebar">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 fw-bold"><i class="fas fa-cog me-2"></i>Pengaturan Publikasi</h6>
                    </div>
                    <div class="card-body">
                        {{-- Tanggal Publikasi --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Tanggal Publikasi</label>
                            <input type="datetime-local" 
                                   name="published_at" 
                                   value="{{ old('published_at') }}" 
                                   class="form-control form-control-sm">
                            <small class="text-muted">Kosongkan untuk waktu saat ini</small>
                        </div>

                        {{-- Checkboxes --}}
                  

                         {{-- is_published --}}
<div class="card bg-light border-0 mb-2">
    <div class="card-body p-3">
        <div class="form-check form-switch">
            <input type="hidden" name="is_published" value="0">
            <input type="checkbox" 
                   name="is_published" 
                   value="1" 
                   checked
                   class="form-check-input" 
                   id="isPublished">
            <label class="form-check-label fw-bold" for="isPublished">
                Terbitkan Sekarang
            </label>
            <small class="d-block text-muted">Berita akan langsung terlihat publik</small>
        </div>
    </div>
</div>

{{-- show_on_homepage --}}
<div class="card bg-light border-0 mb-2">
    <div class="card-body p-3">
        <div class="form-check form-switch">
            <input type="hidden" name="show_on_homepage" value="0">
            <input type="checkbox" 
                   name="show_on_homepage" 
                   value="1" 
                   {{ old('show_on_homepage') ? 'checked' : '' }}
                   class="form-check-input" 
                   id="showHomepage">
            <label class="form-check-label fw-bold" for="showHomepage">
                Tampilkan di Beranda
            </label>
            <small class="d-block text-muted">Muncul di halaman utama website</small>
        </div>
    </div>
</div>



                        {{-- Buttons --}}
                        <div class="d-grid gap-2 pt-3 border-top">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Berita
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/tinymce@6.8.3/tinymce.min.js" referrerpolicy="origin"></script>

<script>
// TinyMCE
tinymce.init({
    selector: '#content',
    height: 450,
    menubar: false,
    plugins: [
        'advlist autolink lists link image charmap preview anchor',
        'searchreplace visualblocks code fullscreen',
        'insertdatetime media table help wordcount'
    ],
    toolbar: 'undo redo | blocks | bold italic underline | ' +
             'alignleft aligncenter alignright alignjustify | ' +
             'bullist numlist outdent indent | link image | code',
    content_style: 'body { font-family: Arial, sans-serif; font-size: 14px; }',
    language: 'id'
});

// Featured Image Preview
const imageInput = document.getElementById('featured_image');
const imagePreview = document.getElementById('imagePreview');
const preview = document.getElementById('preview');
const removeBtn = document.getElementById('removeImage');
const currentImageDisplay = document.getElementById('currentImageDisplay');

imageInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate size (2MB)
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            imagePreview.classList.remove('d-none');
            
            // Opacity change for current image
            if (currentImageDisplay) {
                currentImageDisplay.style.opacity = '0.5';
            }
        };
        reader.readAsDataURL(file);
    }
});

removeBtn.addEventListener('click', function() {
    imageInput.value = '';
    imagePreview.classList.add('d-none');
    preview.src = '';
    
    // Restore current image opacity
    if (currentImageDisplay) {
        currentImageDisplay.style.opacity = '1';
    }
});

// Gallery Preview
const additionalImagesInput = document.getElementById('additionalImages');
const galleryPreview = document.getElementById('galleryPreview');
let galleryFiles = [];

additionalImagesInput.addEventListener('change', function(e) {
    const files = Array.from(e.target.files);
    galleryFiles = galleryFiles.concat(files);
    renderGallery();
});

function renderGallery() {
    galleryPreview.innerHTML = '';
    
    if (galleryFiles.length > 0) {
        const header = document.createElement('p');
        header.className = 'small text-muted mb-2 mt-3';
        header.innerHTML = '<i class="fas fa-images me-1"></i>Foto Baru yang Akan Ditambahkan (' + galleryFiles.length + ')';
        galleryPreview.appendChild(header);
    }
    
    galleryFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'gallery-item';
            div.innerHTML = `
                <span class="badge bg-info position-absolute top-0 start-0 m-2" style="font-size: 0.65rem; z-index: 1;">
                    Baru
                </span>
                <img src="${e.target.result}" alt="Gallery ${index + 1}">
                <button type="button" class="remove-btn" onclick="removeGalleryImage(${index})">×</button>
                <div class="p-2">
                    <input type="text" name="image_captions[]" 
                        placeholder="Caption (opsional)" 
                        class="form-control form-control-sm" style="font-size: 0.75rem;">
                </div>
            `;
            galleryPreview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removeGalleryImage(index) {
    galleryFiles.splice(index, 1);
    
    const dt = new DataTransfer();
    galleryFiles.forEach(file => dt.items.add(file));
    additionalImagesInput.files = dt.files;
    
    renderGallery();
}

// ============================================
// PERBAIKAN: Auto-fill published_at
// ============================================
document.addEventListener('DOMContentLoaded', function() {
    const publishCheckbox = document.getElementById('isPublished');
    const publishedAtInput = document.querySelector('input[name="published_at"]');
    
    // Function untuk set datetime
    function setCurrentDateTime() {
        if (publishCheckbox.checked && !publishedAtInput.value) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            
            publishedAtInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    }
    
    // Set saat page load
    setCurrentDateTime();
    
    // Set saat checkbox berubah
    publishCheckbox.addEventListener('change', setCurrentDateTime);
});
</script>
@endpush