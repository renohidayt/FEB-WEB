@extends('admin.layouts.app')

@section('title', 'Edit Album')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Album</h1>
            <p class="text-muted small mb-0">Update informasi untuk: <strong>{{ $album->name }}</strong></p>
        </div>
        <a href="{{ route('admin.albums.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white d-flex justify-content-between align-items-center">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Formulir Edit Album</h6>
                    @if($album->is_published)
                        <span class="badge bg-success" style="font-size: 0.7rem;">Published</span>
                    @else
                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Draft</span>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.albums.update', $album) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. COVER SAAT INI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Cover Album
                            </h6>
                            
                            {{-- Current Cover --}}
                            <div class="mb-3">
                                <p class="small text-muted mb-2">Cover saat ini:</p>
                                <div class="text-center p-3 bg-light border rounded">
                                    <img id="cover-preview" 
                                         src="{{ $album->cover_url }}" 
                                         alt="{{ $album->name }}"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 250px; object-fit: cover;">
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Upload File Baru --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">
                                        Ganti Cover <span class="text-muted">(Opsional)</span>
                                    </label>
                                    <input type="file" 
                                           id="cover-file" 
                                           name="cover" 
                                           accept="image/*"
                                           class="form-control @error('cover') is-invalid @enderror"
                                           onchange="previewCover(event)">
                                    <small class="text-muted">JPG, PNG, WebP (Maks. 2MB). Kosongkan jika tidak ingin mengubah.</small>
                                    @error('cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- OR Cover URL --}}
                                <div class="col-12">
                                    <div class="alert alert-info mb-0" role="alert">
                                        <label for="cover_url" class="form-label fw-bold small mb-2">
                                            <i class="fas fa-link me-1"></i>Atau Gunakan URL Cover Baru
                                        </label>
                                        <input type="url" 
                                               id="cover_url" 
                                               name="cover_url" 
                                               class="form-control form-control-sm @error('cover_url') is-invalid @enderror" 
                                               value="{{ old('cover_url') }}"
                                               placeholder="https://example.com/image.jpg"
                                               onchange="previewCoverUrl(this.value)">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle"></i>
                                            Jika URL diisi, file upload akan diabaikan
                                        </small>
                                        @error('cover_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. INFORMASI ALBUM --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Album
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Nama Album --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Album <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', $album->name) }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Wisuda 2024"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Acara --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tanggal Acara</label>
                                    <input type="date" 
                                           name="date" 
                                           value="{{ old('date', $album->date?->format('Y-m-d')) }}"
                                           class="form-control @error('date') is-invalid @enderror">
                                    @error('date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6"></div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi Album</label>
                                    <textarea name="description" 
                                              rows="4" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Tulis deskripsi singkat tentang album ini..."
                                              maxlength="500">{{ old('description', $album->description) }}</textarea>
                                    <small class="text-muted">Maksimal 500 karakter</small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. STATISTIK MEDIA --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-chart-bar me-2"></i>Statistik Media
                            </h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="card bg-light border-0 text-center">
                                        <div class="card-body p-3">
                                            <i class="fas fa-image text-purple mb-2" style="font-size: 1.5rem;"></i>
                                            <h4 class="fw-bold mb-0">{{ $album->photos_count }}</h4>
                                            <small class="text-muted">Total Foto</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light border-0 text-center">
                                        <div class="card-body p-3">
                                            <i class="fas fa-video text-warning mb-2" style="font-size: 1.5rem;"></i>
                                            <h4 class="fw-bold mb-0">{{ $album->videos_count }}</h4>
                                            <small class="text-muted">Total Video</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="{{ route('admin.albums.media.index', $album) }}" class="btn btn-success btn-sm w-100 mt-2">
                                <i class="fas fa-folder-open me-2"></i>Kelola Media Album
                            </a>
                        </div>

                        {{-- 4. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Publikasi
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_published" 
                                               name="is_published" 
                                               value="1"
                                               {{ old('is_published', $album->is_published) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_published">Publikasikan album</label>
                                        <small class="d-block text-muted">Album akan terlihat di website publik</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.albums.media.index', $album) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-folder-open me-1"></i> Kelola Media
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save me-1"></i> Update Album
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Album</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data yang diubah sudah benar.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Current Info --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-database text-info me-2"></i> Data Saat Ini
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>Status:</strong> 
                                <span class="badge {{ $album->is_published ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $album->is_published ? 'Published' : 'Draft' }}
                                </span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Media:</strong> {{ $album->photos_count }} foto, {{ $album->videos_count }} video
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Dibuat:</strong> {{ $album->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $album->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-image text-primary me-2"></i> Ganti Cover
                            </h6>
                            <p class="text-muted small mb-0">
                                Cover saat ini sudah tersimpan. Upload file baru hanya jika ingin mengubah cover album.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-folder-open text-success me-2"></i> Kelola Media
                            </h6>
                            <p class="text-muted small mb-0">
                                Klik tombol "Kelola Media" untuk:<br>
                                • Upload foto/video baru<br>
                                • Hapus media yang ada<br>
                                • Atur caption media
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting
                            </h6>
                            <p class="text-muted small mb-0">
                                • Cover: Opsional (kosongkan jika tidak ubah)<br>
                                • Media tetap tersimpan saat edit<br>
                                • Status: Published = tampil di website<br>
                                • Perubahan langsung tersimpan
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function previewCover(event) {
    const file = event.target.files[0];
    if (file) {
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }
        
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG, WebP)');
            event.target.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('cover-preview').src = e.target.result;
            document.getElementById('cover_url').value = '';
        }
        reader.readAsDataURL(file);
    }
}

function previewCoverUrl(url) {
    if (url) {
        document.getElementById('cover-preview').src = url;
        document.getElementById('cover-file').value = '';
    }
}

// Character counter
const descTextarea = document.querySelector('textarea[name="description"]');
if (descTextarea) {
    descTextarea.addEventListener('input', function() {
        if (this.value.length > 500) {
            this.value = this.value.substring(0, 500);
        }
    });
}
</script>

<style>
.text-purple { color: #6f42c1 !important; }
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection