@extends('admin.layouts.app')

@section('title', 'Tambah Album')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Album Baru</h1>
            <p class="text-muted small mb-0">Lengkapi informasi album dan upload cover.</p>
        </div>
        <a href="{{ route('admin.albums.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-folder-plus me-2"></i>Formulir Album Baru</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.albums.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. COVER ALBUM --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Cover Album
                            </h6>
                            
                            {{-- Cover Preview --}}
                            <div class="text-center mb-3">
                                <div class="position-relative d-inline-block">
                                    <img id="cover-preview" 
                                         src="https://via.placeholder.com/600x400?text=Upload+Cover+Album" 
                                         alt="Cover Preview"
                                         class="img-fluid rounded shadow-sm"
                                         style="max-height: 300px; max-width: 100%; object-fit: cover;">
                                </div>
                            </div>

                            <div class="row g-3">
                                {{-- Upload File --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Cover</label>
                                    <input type="file" 
                                           id="cover-file" 
                                           name="cover" 
                                           accept="image/*"
                                           class="form-control @error('cover') is-invalid @enderror"
                                           onchange="previewCover(event)">
                                    <small class="text-muted">JPG, PNG, WebP (Maks. 2MB, Rekomendasi: 1200x800px)</small>
                                    @error('cover')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- OR Cover URL --}}
                                <div class="col-12">
                                    <div class="alert alert-info mb-0" role="alert">
                                        <label for="cover_url" class="form-label fw-bold small mb-2">
                                            <i class="fas fa-link me-1"></i>Atau Gunakan URL Cover
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
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Wisuda 2024, Kejuaraan Nasional"
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
                                           value="{{ old('date') }}"
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
                                              maxlength="500">{{ old('description') }}</textarea>
                                    <small class="text-muted">Maksimal 500 karakter</small>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. STATUS --}}
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
                                               {{ old('is_published', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_published">Publikasikan album sekarang</label>
                                        <small class="d-block text-muted">Album akan langsung terlihat di website publik</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.albums.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Album
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
                                <i class="fas fa-image text-primary me-2"></i> Cover Album
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: JPG, PNG, WebP<br>
                                • Ukuran: Maksimal 2MB<br>
                                • Dimensi: 1200x800px (rekomendasi)<br>
                                • Pilih foto terbaik sebagai cover<br>
                                • Bisa upload file atau pakai URL
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-folder text-success me-2"></i> Nama Album
                            </h6>
                            <p class="text-muted small mb-0">
                                Gunakan nama yang jelas & deskriptif:<br>
                                • "Wisuda Periode April 2024"<br>
                                • "Kejuaraan Futsal Nasional"<br>
                                • "Seminar Teknologi AI"<br>
                                • "Kegiatan Kemahasiswaan 2024"
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-calendar text-warning me-2"></i> Tanggal & Deskripsi
                            </h6>
                            <p class="text-muted small mb-0">
                                • Tanggal: Kapan acara berlangsung<br>
                                • Deskripsi: Max 500 karakter<br>
                                • Jelaskan singkat tentang acara<br>
                                • Opsional tapi disarankan diisi
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-lightbulb text-info me-2"></i> Langkah Selanjutnya
                            </h6>
                            <p class="text-muted small mb-0">
                                1. Buat album terlebih dahulu<br>
                                2. Setelah tersimpan, klik "Kelola Media"<br>
                                3. Upload foto/video ke album<br>
                                4. Atur urutan & caption media
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
        // Validate size
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 2MB.');
            event.target.value = '';
            return;
        }
        
        // Validate type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG, WebP)');
            event.target.value = '';
            return;
        }
        
        // Show preview
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

// Character counter for description
const descTextarea = document.querySelector('textarea[name="description"]');
if (descTextarea) {
    descTextarea.addEventListener('input', function() {
        if (this.value.length > 500) {
            this.value = this.value.substring(0, 500);
        }
    });
}
</script>
@endsection