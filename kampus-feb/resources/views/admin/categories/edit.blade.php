@extends('admin.layouts.app')

@section('title', 'Edit Kategori')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Kategori</h1>
            <p class="text-muted small mb-0">Update: <strong>{{ $category->name }}</strong></p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Formulir Edit Kategori</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" id="categoryForm">
                        @csrf
                        @method('PUT')
                        
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
                                       value="{{ old('name', $category->name) }}" 
                                       class="form-control @error('name') is-invalid @enderror"
                                       placeholder="Contoh: Teknologi, Olahraga, Politik"
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <small class="text-muted">
                                Slug saat ini: <code class="bg-light px-2 py-1 rounded">{{ $category->slug }}</code>
                            </small>
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
                                      placeholder="Tulis deskripsi singkat tentang kategori ini...">{{ old('description', $category->description) }}</textarea>
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
                                <i class="fas fa-save me-1"></i> Update Kategori
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Preview Card --}}
            <div class="card shadow-sm mb-3">
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
                                <h6 class="mb-1 fw-bold" id="preview-name">{{ $category->name }}</h6>
                                <p class="text-muted small mb-0" id="preview-desc">
                                    {{ $category->description ?: 'Deskripsi kategori akan muncul di sini...' }}
                                </p>
                            </div>
                            <span class="badge bg-primary ms-auto">{{ $category->news_count }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Danger Zone --}}
            @if($category->news_count == 0)
            <div class="card border-danger shadow-sm">
                <div class="card-header py-3 bg-danger text-white">
                    <h6 class="m-0 fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Danger Zone</h6>
                </div>
                <div class="card-body">
                    <p class="text-muted mb-3">
                        Kategori ini tidak memiliki berita. Anda dapat menghapusnya jika tidak diperlukan lagi.
                    </p>
                    
                    <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" 
                          onsubmit="return confirm('⚠️ Yakin ingin menghapus kategori ini?\n\nKategori yang dihapus tidak dapat dikembalikan!')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i> Hapus Kategori
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="card border-warning shadow-sm">
                <div class="card-body">
                    <div class="d-flex gap-3 align-items-start">
                        <i class="fas fa-exclamation-triangle text-warning" style="font-size: 1.5rem;"></i>
                        <div>
                            <strong class="text-warning">Peringatan</strong>
                            <p class="text-muted mb-0 mt-1 small">
                                Kategori ini memiliki <strong>{{ $category->news_count }} berita</strong>. 
                                Anda tidak dapat menghapus kategori yang masih memiliki berita.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- KOLOM KANAN: INFORMASI --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data sudah benar.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Stats --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-chart-bar text-info me-2"></i> Statistik
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>Jumlah Berita:</strong> {{ $category->news_count }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Dibuat:</strong> {{ $category->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $category->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Informasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Nama kategori<br>
                                • Deskripsi<br>
                                <br>
                                <strong>Slug otomatis update!</strong>
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-trash text-danger me-2"></i> Hapus Kategori
                            </h6>
                            <p class="text-muted small mb-0">
                                • Hanya jika tidak ada berita<br>
                                • Tidak dapat dikembalikan<br>
                                • Review sebelum hapus<br>
                                • Pindahkan berita dulu
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
    previewName.textContent = e.target.value || '{{ $category->name }}';
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