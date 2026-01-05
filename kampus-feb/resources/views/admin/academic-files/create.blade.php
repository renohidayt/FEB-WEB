@extends('admin.layouts.app')

@section('title', 'Upload File Akademik')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Upload File Akademik</h1>
            <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk upload file akademik.</p>
        </div>
        <a href="{{ route('admin.academic-files.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-file-upload me-2"></i>Formulir Upload File</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.academic-files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. INFORMASI FILE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi File
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Tipe File --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tipe File <span class="text-danger">*</span></label>
                                    <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                        <option value="">Pilih Tipe</option>
                                        <option value="kalender" {{ old('type') === 'kalender' ? 'selected' : '' }}>Kalender Akademik</option>
                                        <option value="jadwal" {{ old('type') === 'jadwal' ? 'selected' : '' }}>Jadwal Perkuliahan</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Judul --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Judul <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="title" 
                                           value="{{ old('title') }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="Contoh: Kalender Akademik Semester Ganjil 2024/2025"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi</label>
                                    <textarea name="description" 
                                              rows="3" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Deskripsi singkat tentang file ini...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. PERIODE AKADEMIK --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Periode Akademik
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Tahun Ajaran --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tahun Ajaran <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="academic_year" 
                                           value="{{ old('academic_year', '2024/2025') }}"
                                           class="form-control @error('academic_year') is-invalid @enderror"
                                           placeholder="2024/2025"
                                           required>
                                    @error('academic_year')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Format: 2024/2025</small>
                                </div>

                                {{-- Semester --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Semester <span class="text-danger">*</span></label>
                                    <select name="semester" class="form-select @error('semester') is-invalid @enderror" required>
                                        <option value="ganjil" {{ old('semester', 'ganjil') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="genap" {{ old('semester') === 'genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. UPLOAD FILE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-upload me-2"></i>Upload File
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">File Dokumen <span class="text-danger">*</span></label>
                                    <input type="file" 
                                           name="file" 
                                           id="fileInput" 
                                           accept=".pdf,.csv,.xls,.xlsx,.doc,.docx"
                                           class="form-control @error('file') is-invalid @enderror"
                                           required
                                           onchange="updateFileName(this)">
                                    <div class="form-text text-muted small">Format: PDF, CSV, Excel, Word. Maksimal 10MB.</div>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- File Name Display --}}
                                    <div id="file-name" class="d-none mt-2 p-2 bg-light rounded border">
                                        <i class="fas fa-file text-primary me-2"></i>
                                        <span class="small fw-medium"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Status
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">Aktifkan file ini</label>
                                        <small class="d-block text-muted">File yang aktif akan ditampilkan di website.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.academic-files.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-upload me-1"></i> Upload File
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
                                <i class="fas fa-file-alt text-primary me-2"></i> Tipe File
                            </h6>
                            <p class="text-muted small mb-0">
                                • <strong>Kalender:</strong> Kalender akademik semester<br>
                                • <strong>Jadwal:</strong> Jadwal perkuliahan/ujian<br>
                                Pilih sesuai dengan jenis dokumen
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-calendar text-success me-2"></i> Tahun Ajaran
                            </h6>
                            <p class="text-muted small mb-0">
                                Format: <code>2024/2025</code><br>
                                Gunakan tahun ajaran berjalan atau periode mendatang sesuai kebutuhan.
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-upload text-warning me-2"></i> File Upload
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: PDF, CSV, Excel, Word<br>
                                • Ukuran: Maksimal 10MB<br>
                                • Nama file akan tersimpan otomatis<br>
                                Pastikan file tidak corrupt
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-cog text-info me-2"></i> Status Aktif
                            </h6>
                            <p class="text-muted small mb-0">
                                • <span class="badge bg-success">Aktif</span> = Tampil di website<br>
                                • <span class="badge bg-secondary">Nonaktif</span> = Hanya admin<br>
                                Status bisa diubah kapan saja
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
function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file-name');
    const span = fileNameDisplay.querySelector('span');
    
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        const fileSize = (input.files[0].size / 1024 / 1024).toFixed(2);
        
        if (input.files[0].size > 10 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 10MB');
            input.value = '';
            fileNameDisplay.classList.add('d-none');
            return;
        }
        
        span.textContent = `${fileName} (${fileSize} MB)`;
        fileNameDisplay.classList.remove('d-none');
    } else {
        fileNameDisplay.classList.add('d-none');
    }
}
</script>
@endsection