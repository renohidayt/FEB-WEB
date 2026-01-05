@extends('admin.layouts.app')

@section('title', 'Edit File Akademik')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit File Akademik</h1>
            <p class="text-muted small mb-0">Update informasi file: <strong>{{ $academicFile->title }}</strong></p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-file-upload me-2"></i>Formulir Edit File</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.academic-files.update', $academicFile) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                        <option value="kalender" {{ old('type', $academicFile->type) === 'kalender' ? 'selected' : '' }}>Kalender Akademik</option>
                                        <option value="jadwal" {{ old('type', $academicFile->type) === 'jadwal' ? 'selected' : '' }}>Jadwal Perkuliahan</option>
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
                                           value="{{ old('title', $academicFile->title) }}"
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
                                              placeholder="Deskripsi singkat tentang file ini...">{{ old('description', $academicFile->description) }}</textarea>
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
                                           value="{{ old('academic_year', $academicFile->academic_year) }}"
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
                                        <option value="ganjil" {{ old('semester', $academicFile->semester) === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                                        <option value="genap" {{ old('semester', $academicFile->semester) === 'genap' ? 'selected' : '' }}>Genap</option>
                                    </select>
                                    @error('semester')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. FILE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-file me-2"></i>File Dokumen
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    {{-- Current File Display --}}
                                    <div class="mb-3">
                                        <p class="small text-muted mb-2">File saat ini:</p>
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light border rounded">
                                            <div class="flex-shrink-0">
                                                @php
                                                    $iconClass = match($academicFile->file_type) {
                                                        'pdf' => 'fa-file-pdf text-danger',
                                                        'csv' => 'fa-file-csv text-success',
                                                        'xls', 'xlsx' => 'fa-file-excel text-success',
                                                        'doc', 'docx' => 'fa-file-word text-primary',
                                                        default => 'fa-file text-secondary'
                                                    };
                                                @endphp
                                                <i class="fas {{ $iconClass }} fa-2x"></i>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <p class="fw-semibold mb-0 small text-truncate">{{ $academicFile->file_name }}</p>
                                                <small class="text-muted">
                                                    {{ strtoupper($academicFile->file_type) }} • {{ $academicFile->getFileSizeFormatted() }}
                                                </small>
                                                <div class="mt-1">
                                                    <small class="text-muted">
                                                        <i class="fas fa-download me-1"></i>{{ $academicFile->download_count }} downloads
                                                    </small>
                                                </div>
                                            </div>
                                            <a href="{{ $academicFile->getDownloadUrl() }}" 
                                               class="btn btn-sm btn-primary flex-shrink-0" 
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    </div>

                                    <label class="form-label fw-bold small">
                                        Ganti File <span class="text-muted">(Opsional - kosongkan jika tidak ingin mengubah)</span>
                                    </label>
                                    <input type="file" 
                                           name="file" 
                                           id="fileInput" 
                                           accept=".pdf,.csv,.xls,.xlsx,.doc,.docx"
                                           class="form-control @error('file') is-invalid @enderror"
                                           onchange="updateFileName(this)">
                                    <div class="form-text text-muted small">Format: PDF, CSV, Excel, Word. Maksimal 10MB. Biarkan kosong jika tidak ingin mengganti.</div>
                                    @error('file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- New File Name Display --}}
                                    <div id="file-name" class="d-none mt-2 p-2 bg-success bg-opacity-10 rounded border border-success">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <span class="small fw-medium text-success"></span>
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
                                               {{ old('is_active', $academicFile->is_active) ? 'checked' : '' }}>
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
                                <i class="fas fa-save me-1"></i> Update File
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
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Edit</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data yang diubah sudah benar sebelum menyimpan.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Info Current Data --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-info-circle text-info me-2"></i> Data Saat Ini
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>Tipe:</strong> 
                                <span class="badge {{ $academicFile->type === 'kalender' ? 'bg-info' : 'bg-success' }}">
                                    {{ $academicFile->type === 'kalender' ? 'Kalender' : 'Jadwal' }}
                                </span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Tahun/Semester:</strong> {{ $academicFile->academic_year }} - {{ ucfirst($academicFile->semester) }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>File:</strong> {{ strtoupper($academicFile->file_type) }} ({{ $academicFile->getFileSizeFormatted() }})
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Status:</strong> 
                                <span class="badge {{ $academicFile->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $academicFile->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-file-alt text-primary me-2"></i> Tipe & Judul
                            </h6>
                            <p class="text-muted small mb-0">
                                Ubah tipe atau judul jika ada kesalahan input. Pastikan sesuai dengan isi dokumen.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-file text-success me-2"></i> Ganti File
                            </h6>
                            <p class="text-muted small mb-0">
                                File sudah ada. Upload file baru hanya jika ingin mengganti file lama. File lama akan dihapus otomatis.
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting
                            </h6>
                            <p class="text-muted small mb-0">
                                • Pastikan tahun ajaran benar<br>
                                • File baru tidak corrupt (jika diganti)<br>
                                • Status aktif untuk tampil di website<br>
                                • Download count akan tetap tersimpan
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
        
        span.textContent = `File baru: ${fileName} (${fileSize} MB)`;
        fileNameDisplay.classList.remove('d-none');
    } else {
        fileNameDisplay.classList.add('d-none');
    }
}
</script>
@endsection