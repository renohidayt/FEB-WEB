@extends('admin.layouts.app')

@section('title', 'Tambah Profil')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Profil Baru</h1>
            <p class="text-muted small mb-0">Lengkapi formulir untuk menambahkan profil.</p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-user-plus me-2"></i>Formulir Profil</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profiles.store') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                        @csrf

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
                                {{-- Tipe Profil --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tipe Profil <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">-- Pilih Tipe Profil --</option>
                                        @foreach($availableTypes as $key => $label)
                                            <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih kategori profil yang sesuai</small>
                                </div>

                                {{-- Nama/Judul --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama/Judul <span class="text-muted">(Opsional)</span></label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Prof. Dr. John Doe, M.Sc">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Nama orang atau judul profil</small>
                                </div>
                            </div>
                        </div>

                        {{-- 2. FOTO PROFIL --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-camera me-2"></i>Foto Profil
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Foto <span class="text-muted">(Opsional)</span></label>
                                    <input type="file" 
                                           name="photo" 
                                           id="photoInput"
                                           class="form-control @error('photo') is-invalid @enderror"
                                           accept="image/*">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="alert alert-info mt-2 mb-0" role="alert">
                                        <p class="small mb-1"><strong>📋 Spesifikasi Foto:</strong></p>
                                        <ul class="small mb-0">
                                            <li><strong>Format:</strong> JPG, PNG, WEBP</li>
                                            <li><strong>Ukuran Maksimal:</strong> 5MB</li>
                                            <li><strong>Dimensi Rekomendasi:</strong> 800x800px (Square)</li>
                                        </ul>
                                    </div>
                                    
                                    <!-- Preview -->
                                    <div id="photoPreview" class="mt-3 d-none">
                                        <p class="fw-bold small mb-2">Preview Foto:</p>
                                        <div class="position-relative d-inline-block">
                                            <img id="preview" 
                                                 src="" 
                                                 class="img-fluid rounded border border-2 border-primary shadow"
                                                 style="max-width: 300px; max-height: 300px;">
                                            <button type="button" 
                                                    class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2"
                                                    onclick="clearPhoto()">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. KONTEN/DESKRIPSI --}}
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
                                              placeholder="Masukkan deskripsi atau konten profil...">{{ old('content') }}</textarea>
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
                                <i class="fas fa-save me-1"></i> Simpan Profil
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field yang bertanda <span class="text-danger">*</span> wajib diisi.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-list text-primary me-2"></i> Tipe Profil
                            </h6>
                            <p class="text-muted small mb-0">
                                Pilih kategori yang sesuai:<br>
                                • <strong>Sejarah:</strong> Riwayat institusi<br>
                                • <strong>Visi & Misi:</strong> Tujuan organisasi<br>
                                • <strong>Struktur:</strong> Organisasi/kepengurusan<br>
                                • <strong>Pimpinan:</strong> Profil leadership<br>
                                • <strong>Lainnya:</strong> Informasi tambahan
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-user text-success me-2"></i> Nama/Judul
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Opsional:</strong><br>
                                • Untuk profil orang: nama lengkap + gelar<br>
                                • Untuk konten umum: bisa dikosongkan<br>
                                • Contoh: "Prof. Dr. John Doe, M.Sc"<br>
                                • Atau: "Rektor Universitas"
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-camera text-warning me-2"></i> Foto Profil
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Specs:</strong><br>
                                • Format: JPG, PNG, WEBP<br>
                                • Ukuran: Max 5MB<br>
                                • Dimensi: 800x800px (square)<br>
                                • Untuk profil orang: foto formal<br>
                                • Opsional untuk konten umum
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-align-left text-info me-2"></i> Konten
                            </h6>
                            <p class="text-muted small mb-0">
                                Isi dengan:<br>
                                • Deskripsi lengkap<br>
                                • Riwayat singkat<br>
                                • Informasi relevan<br>
                                • Format bebas (text/paragraf)<br>
                                • Bisa menggunakan line break
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
        }
        reader.readAsDataURL(file);
    }
});

function clearPhoto() {
    photoInput.value = '';
    photoPreview.classList.add('d-none');
    preview.src = '';
}
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection