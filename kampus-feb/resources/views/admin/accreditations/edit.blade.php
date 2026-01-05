@extends('admin.layouts.app')

@section('title', 'Edit Akreditasi')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Data Akreditasi</h1>
            <p class="text-muted small mb-0">Update informasi akreditasi: <strong>{{ $accreditation->study_program }}</strong></p>
        </div>
        <a href="{{ route('admin.accreditations.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-certificate me-2"></i>Formulir Edit Akreditasi</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.accreditations.update', $accreditation) }}" method="POST" enctype="multipart/form-data" id="accreditationForm">
                        @csrf
                        @method('PUT')

                        {{-- 1. TIPE & KATEGORI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-layer-group me-2"></i>Tipe Akreditasi
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Type --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tipe Akreditasi <span class="text-danger">*</span></label>
                                    <select name="type" 
                                            id="type" 
                                            class="form-select @error('type') is-invalid @enderror"
                                            required
                                            onchange="toggleCategoryField()">
                                        <option value="">Pilih Tipe Akreditasi</option>
                                        @foreach($types as $key => $label)
                                            <option value="{{ $key }}" {{ old('type', $accreditation->type) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pilih tipe sesuai dengan jenis akreditasi</small>
                                </div>

                                {{-- Category (Conditional) --}}
                                <div id="categoryField" class="col-md-12" style="display: {{ in_array(old('type', $accreditation->type), ['program_studi', 'program_studi_old']) ? 'block' : 'none' }}">
                                    <label class="form-label fw-bold small">Kategori Program <span class="text-muted">(Opsional untuk Prodi)</span></label>
                                    <select name="category" 
                                            id="category" 
                                            class="form-select @error('category') is-invalid @enderror">
                                        <option value="">Tidak Ada / Umum</option>
                                        @foreach($categories as $key => $label)
                                            <option value="{{ $key }}" {{ old('category', $accreditation->category) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Contoh: S1, S2, D3 (untuk membedakan jenjang)</small>
                                </div>
                            </div>
                        </div>

                        {{-- 2. INFORMASI PROGRAM --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-graduation-cap me-2"></i>Informasi Program
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Study Program --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">
                                        <span id="programLabel">
                                            {{ in_array($accreditation->type, ['perguruan_tinggi', 'perguruan_tinggi_old']) ? 'Perguruan Tinggi' : 'Program Studi' }}
                                        </span>
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           name="study_program" 
                                           id="study_program" 
                                           value="{{ old('study_program', $accreditation->study_program) }}"
                                           class="form-control @error('study_program') is-invalid @enderror"
                                           placeholder="Contoh: Sistem Informasi"
                                           required>
                                    @error('study_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Grade --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Peringkat Akreditasi <span class="text-danger">*</span></label>
                                    <select name="grade" 
                                            id="grade" 
                                            class="form-select @error('grade') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih Peringkat</option>
                                        @foreach($grades as $key => $label)
                                            <option value="{{ $key }}" {{ old('grade', $accreditation->grade) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('grade')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Accreditation Body --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Lembaga Akreditasi <span class="text-danger">*</span></label>
                                    <select name="accreditation_body" 
                                            id="accreditation_body" 
                                            class="form-select @error('accreditation_body') is-invalid @enderror"
                                            required>
                                        <option value="">Pilih Lembaga</option>
                                        @foreach($bodies as $key => $label)
                                            <option value="{{ $key }}" {{ old('accreditation_body', $accreditation->accreditation_body) == $key ? 'selected' : '' }}>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('accreditation_body')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Certificate Number --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nomor Sertifikat</label>
                                    <input type="text" 
                                           name="certificate_number" 
                                           id="certificate_number" 
                                           value="{{ old('certificate_number', $accreditation->certificate_number) }}"
                                           class="form-control @error('certificate_number') is-invalid @enderror"
                                           placeholder="Contoh: 1234/BAN-PT/Ak-PPJ/S/XI/2023">
                                    @error('certificate_number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. MASA BERLAKU --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-calendar-alt me-2"></i>Masa Berlaku
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Valid From --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Berlaku Dari</label>
                                    <input type="date" 
                                           name="valid_from" 
                                           id="valid_from" 
                                           value="{{ old('valid_from', $accreditation->valid_from?->format('Y-m-d')) }}"
                                           class="form-control @error('valid_from') is-invalid @enderror">
                                    @error('valid_from')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Valid Until --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Berlaku Sampai <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           name="valid_until" 
                                           id="valid_until" 
                                           value="{{ old('valid_until', $accreditation->valid_until->format('Y-m-d')) }}"
                                           class="form-control @error('valid_until') is-invalid @enderror"
                                           required>
                                    @error('valid_until')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 4. SERTIFIKAT FILE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-file-pdf me-2"></i>Sertifikat Akreditasi
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    {{-- Current File Display --}}
                                    @if($accreditation->certificate_file)
                                    <div class="mb-3">
                                        <p class="small text-muted mb-2">File saat ini:</p>
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light border rounded">
                                            <div class="flex-shrink-0">
                                                <i class="fas fa-file-pdf text-danger fa-2x"></i>
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <p class="fw-semibold mb-0 small text-truncate">{{ basename($accreditation->certificate_file) }}</p>
                                                <small class="text-muted">File tersimpan</small>
                                            </div>
                                            <a href="{{ route('admin.accreditations.download', $accreditation) }}" 
                                               class="btn btn-sm btn-primary flex-shrink-0" 
                                               target="_blank">
                                                <i class="fas fa-download me-1"></i>Unduh
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    <label class="form-label fw-bold small">
                                        Upload File {{ $accreditation->certificate_file ? 'Baru' : '' }} (PDF)
                                        @if($accreditation->certificate_file)
                                            <span class="text-muted">(Opsional - kosongkan jika tidak ingin mengubah)</span>
                                        @else
                                            <span class="text-danger">*</span>
                                        @endif
                                    </label>
                                    <input type="file" 
                                           name="certificate_file" 
                                           id="certificate_file" 
                                           class="form-control @error('certificate_file') is-invalid @enderror"
                                           accept=".pdf,application/pdf"
                                           onchange="updateFileName(this)">
                                    <div class="form-text text-muted small">Format: PDF. Maksimal 5MB.</div>
                                    @error('certificate_file')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- File Name Display --}}
                                    <div id="file-name" class="d-none mt-2 p-2 bg-success bg-opacity-10 rounded border border-success">
                                        <i class="fas fa-file-pdf text-success me-2"></i>
                                        <span class="small fw-medium text-success"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 5. INFORMASI TAMBAHAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Description --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi</label>
                                    <textarea name="description" 
                                              id="description" 
                                              rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Tambahkan catatan atau informasi tambahan...">{{ old('description', $accreditation->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 6. STATUS --}}
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
                                               {{ old('is_active', $accreditation->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">Aktifkan akreditasi ini</label>
                                        <small class="d-block text-muted">Akreditasi yang aktif akan ditampilkan di website.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.accreditations.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Update Akreditasi
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
                                <strong>Tipe:</strong> {{ $accreditation->type_label }}
                            </p>
                            @if($accreditation->category)
                            <p class="text-muted small mb-1">
                                <strong>Kategori:</strong> {{ $accreditation->category }}
                            </p>
                            @endif
                            <p class="text-muted small mb-1">
                                <strong>Grade:</strong> <span class="badge {{ $accreditation->grade_badge_color }}">{{ $accreditation->grade }}</span>
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Status:</strong> <span class="badge {{ $accreditation->status_badge_color }}">{{ $accreditation->status_label }}</span>
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-layer-group text-primary me-2"></i> Tipe Akreditasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Ubah tipe hanya jika terjadi kesalahan input. Perubahan tipe akan mempengaruhi tampilan data.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-file-pdf text-success me-2"></i> File Sertifikat
                            </h6>
                            <p class="text-muted small mb-0">
                                @if($accreditation->certificate_file)
                                    File sertifikat sudah ada. Upload file baru hanya jika ingin mengganti file lama.
                                @else
                                    Belum ada file sertifikat. Silakan upload file PDF.
                                @endif
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-calendar-alt text-warning me-2"></i> Masa Berlaku
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Berlaku sampai:</strong> {{ $accreditation->valid_until->format('d M Y') }}<br>
                                @if(!$accreditation->isExpired())
                                    <span class="badge bg-info">{{ $accreditation->remaining_days }} hari lagi</span>
                                @else
                                    <span class="badge bg-danger">Sudah kadaluarsa</span>
                                @endif
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting
                            </h6>
                            <p class="text-muted small mb-0">
                                • Pastikan tanggal berlaku benar<br>
                                • File PDF tidak corrupt<br>
                                • Grade sesuai dengan sertifikat<br>
                                • Status aktif untuk ditampilkan
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
        
        if (input.files[0].size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB');
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

function toggleCategoryField() {
    const typeSelect = document.getElementById('type');
    const categoryField = document.getElementById('categoryField');
    const programLabel = document.getElementById('programLabel');
    const selectedType = typeSelect.value;
    
    if (selectedType.includes('program_studi')) {
        categoryField.style.display = 'block';
        programLabel.textContent = 'Program Studi';
    } else {
        categoryField.style.display = 'none';
        programLabel.textContent = 'Perguruan Tinggi';
        // Don't clear category on edit, just hide
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleCategoryField();
});
</script>
@endsection