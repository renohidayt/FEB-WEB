@extends('admin.layouts.app')

@section('title', 'Tambah Kategori')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Kategori</h1>
            <p class="text-muted small mb-0">Buat kategori baru untuk mengorganisir berita.</p>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-tag me-2"></i>Formulir Kategori</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.store') }}" method="POST" id="categoryForm">
                        @csrf
                        
                        {{-- Nama Kategori --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold small">
                                Nama Kategori <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="fas fa-tag text-primary"></i>
                                </span>
                                <input type="text" 
                                       name="name" 
                                       id="name" 
                                       value="{{ old('name') }}" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Contoh: Teknologi, Olahraga, Politik"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">Slug akan dibuat otomatis dari nama kategori</small>
                        </div>

                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold small">
                                Deskripsi <span class="text-muted">(Opsional)</span>
                            </label>
                            <textarea name="description" 
                                      id="description" 
                                      rows="4" 
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Tulis deskripsi singkat tentang kategori ini...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Maksimal 255 karakter</small>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                            <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-success"><i class="fas fa-eye me-2"></i>Preview</h6>
                </div>
                <div class="card-body">
                    <div class="border rounded p-3 bg-light">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded p-3 flex-shrink-0">
                                <i class="fas fa-tag text-primary" style="font-size: 1.5rem;"></i>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <h6 class="mb-1 fw-bold" id="preview-name">Nama Kategori</h6>
                                <p class="text-muted small mb-0" id="preview-desc">Deskripsi kategori akan muncul di sini...</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Buat kategori yang jelas dan mudah dipahami.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-tag text-primary me-2"></i> Nama Kategori
                            </h6>
                            <p class="text-muted small mb-0">
                                • Gunakan nama yang jelas<br>
                                • Hindari nama yang mirip<br>
                                • Contoh: Teknologi, Olahraga<br>
                                • Slug otomatis dibuat<br>
                                • Max 50 karakter
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-align-left text-success me-2"></i> Deskripsi
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Opsional:</strong><br>
                                • Jelaskan isi kategori<br>
                                • Bantu pembaca memahami<br>
                                • Max 255 karakter<br>
                                • Singkat & informatif
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-lightbulb text-warning me-2"></i> Best Practices
                            </h6>
                            <p class="text-muted small mb-0">
                                • Konsisten dengan tema<br>
                                • Jangan terlalu banyak<br>
                                • 5-10 kategori ideal<br>
                                • Review berkala<br>
                                • Hapus yang tidak terpakai
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
// Live preview
document.getElementById('name').addEventListener('input', function(e) {
    const previewName = document.getElementById('preview-name');
    previewName.textContent = e.target.value || 'Nama Kategori';
});

document.getElementById('description').addEventListener('input', function(e) {
    const previewDesc = document.getElementById('preview-desc');
    previewDesc.textContent = e.target.value || 'Deskripsi kategori akan muncul di sini...';
});
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection