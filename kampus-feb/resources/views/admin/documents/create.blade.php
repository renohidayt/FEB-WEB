@extends('admin.layouts.app')

@section('title', 'Upload Dokumen')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Upload Dokumen Baru</h1>
            <p class="text-muted small mb-0">Upload file dokumen untuk kampus.</p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-upload me-2"></i>Formulir Upload Dokumen</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.documents.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                        @csrf

                        {{-- 1. INFORMASI DOKUMEN --}}
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
                                           value="{{ old('name') }}"
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
                                        <option value="Akademik" {{ old('category') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                                        <option value="Administrasi" {{ old('category') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                                        <option value="Kurikulum" {{ old('category') == 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                                        <option value="Penelitian" {{ old('category') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                                        <option value="Pengabdian" {{ old('category') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                                        <option value="Lainnya" {{ old('category') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
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
                                              placeholder="Tambahkan deskripsi tentang dokumen ini...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Deskripsi akan membantu pengguna memahami isi dokumen</small>
                                </div>
                            </div>
                        </div>

                        {{-- 2. UPLOAD FILE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-file-upload me-2"></i>Upload File
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">File Dokumen <span class="text-danger">*</span></label>
                                    
                                    <div class="border border-2 border-dashed rounded p-4 text-center bg-light" 
                                         id="dropZone"
                                         style="border-color: #dee2e6; cursor: pointer; transition: all 0.3s;">
                                        <input type="file" 
                                               name="file" 
                                               id="fileInput"
                                               class="d-none"
                                               accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip,.rar"
                                               onchange="handleFileSelect(this)"
                                               required>
                                        
                                        <div id="uploadPrompt">
                                            <i class="fas fa-cloud-upload-alt text-primary mb-3" style="font-size: 3rem;"></i>
                                            <p class="mb-2">
                                                <span class="text-primary fw-semibold">Klik untuk upload</span>
                                                <span class="text-muted"> atau drag & drop</span>
                                            </p>
                                            <p class="small text-muted mb-0">
                                                PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, ZIP, RAR (Max: 20MB)
                                            </p>
                                        </div>

                                        <div id="fileInfo" class="d-none">
                                            <i class="fas fa-file-alt text-success mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="fw-semibold mb-1" id="fileName"></p>
                                            <p class="text-muted small mb-2" id="fileSize"></p>
                                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                                                <i class="fas fa-times me-1"></i>Ganti File
                                            </button>
                                        </div>
                                    </div>
                                    
                                    @error('file')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                    
                                    {{-- File Type Info --}}
                                    <div class="alert alert-info mt-3 mb-0" role="alert">
                                        <h6 class="alert-heading small mb-2">
                                            <i class="fas fa-info-circle me-1"></i>Tipe File yang Didukung:
                                        </h6>
                                        <div class="d-flex flex-wrap gap-1">
                                            <span class="badge bg-primary">PDF</span>
                                            <span class="badge bg-primary">DOC/DOCX</span>
                                            <span class="badge bg-primary">XLS/XLSX</span>
                                            <span class="badge bg-primary">PPT/PPTX</span>
                                            <span class="badge bg-primary">ZIP/RAR</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.documents.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                                <i class="fas fa-upload me-1"></i> Upload Dokumen
                            </button>
                            <button type="button" class="btn btn-primary btn-sm d-none" id="loadingBtn" disabled>
                                <span class="spinner-border spinner-border-sm me-2"></span>Mengupload...
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
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Upload</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field yang bertanda <span class="text-danger">*</span> wajib diisi.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-file-alt text-primary me-2"></i> Nama & Kategori
                            </h6>
                            <p class="text-muted small mb-0">
                                • Gunakan nama yang jelas & deskriptif<br>
                                • Pilih kategori yang sesuai:<br>
                                  - Akademik: Panduan, silabus<br>
                                  - Administrasi: Form, surat<br>
                                  - Kurikulum: Struktur kurikulum<br>
                                  - Penelitian: Proposal, laporan<br>
                                  - Pengabdian: Laporan kegiatan
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-upload text-success me-2"></i> File Upload
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: PDF, Office, Archive<br>
                                • Ukuran: Maksimal 20MB<br>
                                • Pastikan file tidak corrupt<br>
                                • Gunakan ZIP untuk file besar<br>
                                • Drag & drop atau klik upload
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-align-left text-warning me-2"></i> Deskripsi
                            </h6>
                            <p class="text-muted small mb-0">
                                Tambahkan deskripsi untuk:<br>
                                • Menjelaskan isi dokumen<br>
                                • Memudahkan pencarian<br>
                                • Memberikan konteks<br>
                                • Opsional tapi disarankan
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • Pastikan file bebas virus<br>
                                • Maksimal 20MB per file<br>
                                • File tidak bisa diedit<br>
                                • Hanya bisa dihapus & upload ulang<br>
                                • Kompres file besar dengan ZIP
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
const dropZone = document.getElementById('dropZone');
const fileInput = document.getElementById('fileInput');
const uploadPrompt = document.getElementById('uploadPrompt');
const fileInfo = document.getElementById('fileInfo');
const fileNameDisplay = document.getElementById('fileName');
const fileSizeDisplay = document.getElementById('fileSize');
const submitBtn = document.getElementById('submitBtn');
const loadingBtn = document.getElementById('loadingBtn');

// File size limit (20MB)
const MAX_FILE_SIZE = 20 * 1024 * 1024;

// Handle file selection
function handleFileSelect(input) {
    const file = input.files[0];
    if (file) {
        if (file.size > MAX_FILE_SIZE) {
            alert('Ukuran file terlalu besar! Maksimal 20MB');
            input.value = '';
            return;
        }
        displayFileInfo(file);
    }
}

// Display file information
function displayFileInfo(file) {
    const fileSize = (file.size / 1024 / 1024).toFixed(2);
    fileNameDisplay.textContent = file.name;
    fileSizeDisplay.textContent = `${fileSize} MB`;
    
    uploadPrompt.classList.add('d-none');
    fileInfo.classList.remove('d-none');
}

// Clear file selection
function clearFile() {
    fileInput.value = '';
    uploadPrompt.classList.remove('d-none');
    fileInfo.classList.add('d-none');
}

// Drag and drop
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

dropZone.addEventListener('drop', (e) => {
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        handleFileSelect(fileInput);
    }
});

// Click to select file
dropZone.addEventListener('click', (e) => {
    if (e.target.id !== 'fileInput' && !e.target.closest('button')) {
        fileInput.click();
    }
});

// Form submission with loading state
document.getElementById('uploadForm').addEventListener('submit', function() {
    submitBtn.classList.add('d-none');
    loadingBtn.classList.remove('d-none');
});
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection