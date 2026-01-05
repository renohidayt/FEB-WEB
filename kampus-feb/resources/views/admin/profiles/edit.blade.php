@extends('admin.layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Profil</h1>
            <p class="text-muted small mb-0">Perbarui informasi profil: <strong>{{ $profile->name ?: 'Profil ' . \App\Models\Profile::TYPES[$profile->type] }}</strong></p>
        </div>
        <a href="{{ route('admin.profiles.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Formulir Edit Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profiles.update', $profile) }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf
                        @method('PUT')

                        {{-- ERROR ALERT --}}
                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                <div class="d-flex align-items-start">
                                    <i class="fas fa-exclamation-circle me-2 mt-1"></i>
                                    <div>
                                        <strong>Terdapat {{ $errors->count() }} kesalahan:</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        {{-- 1. INFORMASI DASAR --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Tipe Profil (Disabled) --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tipe Profil <span class="text-danger">*</span></label>
                                    <select class="form-select bg-light" disabled>
                                        <option>{{ \App\Models\Profile::TYPES[$profile->type] ?? $profile->type }}</option>
                                    </select>
                                    <input type="hidden" name="type" value="{{ $profile->type }}">
                                    <small class="text-muted">
                                        <i class="fas fa-lock me-1"></i>Tipe tidak dapat diubah setelah dibuat
                                    </small>
                                </div>

                                {{-- Nama/Judul --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama/Judul <span class="text-muted">(Opsional)</span></label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', $profile->name) }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Prof. Dr. John Doe, M.Sc">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Nama orang atau judul profil</small>
                                </div>
                            </div>
                        </div>

                        {{-- 2. FOTO SAAT INI --}}
                        @if($profile->photo)
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Foto Saat Ini
                            </h6>
                            
                            <div class="card bg-light border-0">
                                <div class="card-body p-3">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <img src="{{ $profile->photo_url }}" 
                                                 id="currentPhoto"
                                                 alt="Current photo"
                                                 class="rounded shadow-sm" 
                                                 style="width: 150px; height: 150px; object-fit: cover; transition: opacity 0.3s;">
                                        </div>
                                        <div class="col">
                                            <p class="mb-1"><span class="badge bg-success">Ada Foto</span></p>
                                            <p class="small text-muted mb-0">Upload foto baru di bawah untuk mengganti</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- 3. UPLOAD FOTO BARU --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-camera me-2"></i>{{ $profile->photo ? 'Ganti Foto' : 'Upload Foto' }}
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Foto Baru <span class="text-muted">(Opsional)</span></label>
                                    <input type="file" 
                                           name="photo" 
                                           id="photoInput"
                                           class="form-control @error('photo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                    
                                    <div class="alert alert-info mt-2 mb-0" role="alert">
                                        <p class="small mb-1"><strong>📋 Spesifikasi Foto:</strong></p>
                                        <ul class="small mb-0">
                                            <li><strong>Format:</strong> JPG, PNG, WEBP</li>
                                            <li><strong>Ukuran Maksimal:</strong> 5MB</li>
                                            <li><strong>Dimensi Rekomendasi:</strong> 800x800px (Square)</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Preview Foto Baru -->
                                    <div id="photoPreview" class="mt-3 d-none">
                                        <div class="alert alert-success border-0">
                                            <strong>Preview Foto Baru:</strong>
                                        </div>
                                        <div class="position-relative d-inline-block">
                                            <img id="preview" 
                                                 src="" 
                                                 class="img-fluid rounded border border-2 border-success shadow"
                                                 style="max-width: 300px; max-height: 300px;">
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="clearPhoto()">
                                                <i class="fas fa-times me-1"></i> Batal
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. KONTEN/DESKRIPSI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-align-left me-2"></i>Konten/Deskripsi
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi <span class="text-muted">(Opsional)</span></label>
                                    <textarea name="content" 
                                              rows="8" 
                                              class="form-control @error('content') is-invalid @enderror"
                                              placeholder="Masukkan deskripsi atau konten profil...">{{ old('content', $profile->content) }}</textarea>
                                    @error('content')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Detail informasi profil, riwayat, atau deskripsi lengkap</small>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.profiles.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Update Profil
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: INFORMASI --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Profil</h6>
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
                                <strong>Tipe:</strong> 
                                <span class="badge bg-primary">{{ \App\Models\Profile::TYPES[$profile->type] ?? $profile->type }}</span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Foto:</strong> 
                                @if($profile->photo)
                                    <span class="badge bg-success">Ada</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Ada</span>
                                @endif
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Dibuat:</strong> {{ $profile->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $profile->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Informasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Nama/judul profil<br>
                                • Foto profil (optional)<br>
                                • Konten/deskripsi<br>
                                <br>
                                <strong>Tipe tidak bisa diubah!</strong>
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-camera text-success me-2"></i> Ganti Foto
                            </h6>
                            <p class="text-muted small mb-0">
                                • Upload baru = replace otomatis<br>
                                • Kosongkan = tetap pakai yang ada<br>
                                • Max 5MB<br>
                                • Format: JPG, PNG, WEBP<br>
                                • Foto lama akan terhapus
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • Tipe profil tidak dapat diubah<br>
                                • Foto baru replace yang lama<br>
                                • Perubahan langsung tersimpan<br>
                                • Pastikan data sudah benar<br>
                                • Review sebelum save
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
const photoInput = document.getElementById('photoInput');
const photoPreview = document.getElementById('photoPreview');
const preview = document.getElementById('preview');
const currentPhoto = document.getElementById('currentPhoto');

photoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validate size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            this.value = '';
            return;
        }
        
        // Validate type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG, WEBP)');
            this.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            photoPreview.classList.remove('d-none');
            if (currentPhoto) currentPhoto.style.opacity = '0.5';
        }
        reader.readAsDataURL(file);
    }
});

function clearPhoto() {
    photoInput.value = '';
    photoPreview.classList.add('d-none');
    preview.src = '';
    if (currentPhoto) currentPhoto.style.opacity = '1';
}
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection