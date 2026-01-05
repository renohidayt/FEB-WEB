@extends('admin.layouts.app')

@section('title', 'Edit Dokumen')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Dokumen</h1>
            <p class="text-muted small mb-0">Update informasi dokumen: <strong>{{ $document->name }}</strong></p>
        </div>
        <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Formulir Edit Dokumen</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documents.update', $document) }}" method="POST" enctype="multipart/form-data" id="updateForm">
                        @csrf
                        @method('PUT')

                        {{-- 1. FILE SAAT INI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-file me-2"></i>File Saat Ini
                            </h6>
                            
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="text-primary flex-shrink-0">
                                            <i class="fas fa-file-{{ $document->file_type == 'pdf' ? 'pdf' : 'alt' }}" style="font-size: 3rem;"></i>
                                        </div>
                                        <div class="flex-grow-1 min-w-0">
                                            <h6 class="fw-bold mb-1">{{ basename($document->file_path) }}</h6>
                                            <p class="text-muted small mb-2">
                                                <span class="badge bg-secondary text-uppercase me-2">
                                                    {{ $document->file_type ?? pathinfo($document->file_path, PATHINFO_EXTENSION) }}
                                                </span>
                                                <span class="badge bg-success">
                                                    <i class="fas fa-download me-1"></i>{{ $document->downloads }} downloads
                                                </span>
                                            </p>
                                            <a href="{{ route('admin.documents.download', $document) }}" class="btn btn-sm btn-outline-success">
                                                <i class="fas fa-download me-1"></i>Download File
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                File tidak bisa diganti. Untuk mengganti file, hapus dokumen ini dan upload ulang.
                            </small>
                        </div>

                        {{-- 2. INFORMASI DOKUMEN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dokumen
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Nama Dokumen --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Dokumen <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name', $document->name) }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Panduan Akademik 2024"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Kategori</label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror">
                                        <option value="">Pilih Kategori</option>
                                        <option value="Akademik" {{ old('category', $document->category) == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Administrasi" {{ old('category', $document->category) == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="Kurikulum" {{ old('category', $document->category) == 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                                        <option value="Penelitian" {{ old('category', $document->category) == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                        <option value="Pengabdian" {{ old('category', $document->category) == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                        <option value="Lainnya" {{ old('category', $document->category) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6"></div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi</label>
                                    <textarea name="description" 
                                              rows="4" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Tambahkan deskripsi tentang dokumen ini...">{{ old('description', $document->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Deskripsi akan membantu pengguna memahami isi dokumen</small>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                <i class="fas fa-save me-1"></i> Update Dokumen
                            </button>
                            <button type="button" class="btn btn-primary btn-sm d-none" id="loadingBtn" disabled>
                                <span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...
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
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Dokumen</h6>
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
                                <strong>Kategori:</strong> 
                                @if($document->category)
                                    <span class="badge bg-primary">{{ $document->category }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Tipe File:</strong> 
                                <span class="badge bg-secondary text-uppercase">
                                    {{ $document->file_type ?? pathinfo($document->file_path, PATHINFO_EXTENSION) }}
                                </span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Downloads:</strong> {{ $document->downloads }}x
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Upload:</strong> {{ $document->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $document->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Informasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Nama dokumen<br>
                                • Kategori<br>
                                • Deskripsi<br>
                                <br>
                                <strong>File tidak bisa diganti!</strong>
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-download text-success me-2"></i> Download File
                            </h6>
                            <p class="text-muted small mb-0">
                                Klik tombol "Download File" di atas untuk melihat atau mengunduh dokumen saat ini.
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • File tidak bisa diganti<br>
                                • Untuk ganti file: hapus & upload ulang<br>
                                • Downloads tetap tersimpan<br>
                                • Perubahan langsung tersimpan<br>
                                • URL download tetap sama
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
const submitBtn = document.getElementById('submitBtn');
const loadingBtn = document.getElementById('loadingBtn');

// Form submission with loading state
document.getElementById('updateForm').addEventListener('submit', function() {
    submitBtn.classList.add('d-none');
    loadingBtn.classList.remove('d-none');
});
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection