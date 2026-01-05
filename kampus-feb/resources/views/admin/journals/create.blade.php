@extends('admin.layouts.app')

@section('title', 'Tambah Jurnal')

@section('content')
<div class="container-fluid px-4">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Jurnal Baru</h1>
            <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk menambahkan jurnal ilmiah.</p>
        </div>
        <a href="{{ route('admin.journals.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-book me-2"></i>Formulir Data Jurnal</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.journals.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. INFORMASI DASAR --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar Jurnal
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Nama Jurnal --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Jurnal <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name') }}" 
                                           placeholder="Contoh: Jurnal Ekonomi dan Bisnis Indonesia"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Bidang/Fokus --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Bidang / Fokus Jurnal <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="field" 
                                           class="form-control @error('field') is-invalid @enderror" 
                                           value="{{ old('field') }}" 
                                           placeholder="Contoh: Ekonomi, Manajemen, Akuntansi"
                                           required>
                                    @error('field')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi Jurnal</label>
                                    <textarea name="description" 
                                              rows="4" 
                                              class="form-control @error('description') is-invalid @enderror" 
                                              placeholder="Deskripsi singkat tentang jurnal ini">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pengelola --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Pengelola (Fakultas / Prodi) <span class="text-danger">*</span></label>
                                    <select name="manager" class="form-select @error('manager') is-invalid @enderror" required>
                                        <option value="">-- Pilih Pengelola --</option>
                                        <option value="Fakultas Ekonomi dan Bisnis" {{ old('manager') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                                        <option value="Prodi Manajemen" {{ old('manager') == 'Prodi Manajemen' ? 'selected' : '' }}>Prodi Manajemen</option>
                                        <option value="Prodi Akuntansi" {{ old('manager') == 'Prodi Akuntansi' ? 'selected' : '' }}>Prodi Akuntansi</option>
                                        <option value="Prodi Magister Manajemen" {{ old('manager') == 'Prodi Magister Manajemen' ? 'selected' : '' }}>Prodi Magister Manajemen</option>
                                    </select>
                                    @error('manager')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. IDENTIFIKASI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-barcode me-2"></i>Identifikasi & Akreditasi
                            </h6>
                            
                            <div class="row g-3">
                                {{-- ISSN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">ISSN (Print)</label>
                                    <input type="text" 
                                           name="issn" 
                                           class="form-control @error('issn') is-invalid @enderror" 
                                           value="{{ old('issn') }}" 
                                           placeholder="1234-567X"
                                           maxlength="9"
                                           pattern="[0-9]{4}-[0-9]{3}[0-9X]">
                                    <small class="text-muted">Format: 1234-567X</small>
                                    @error('issn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- e-ISSN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">e-ISSN (Online)</label>
                                    <input type="text" 
                                           name="e_issn" 
                                           class="form-control @error('e_issn') is-invalid @enderror" 
                                           value="{{ old('e_issn') }}" 
                                           placeholder="1234-567X"
                                           maxlength="9"
                                           pattern="[0-9]{4}-[0-9]{3}[0-9X]">
                                    <small class="text-muted">Format: 1234-567X</small>
                                    @error('e_issn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Akreditasi --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Status Akreditasi</label>
                                    <select name="accreditation_status" class="form-select @error('accreditation_status') is-invalid @enderror">
                                        <option value="">-- Pilih Status Akreditasi --</option>
                                        @foreach($accreditationStatuses as $key => $label)
                                            <option value="{{ $key }}" {{ old('accreditation_status') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('accreditation_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. URL & LINKS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-link me-2"></i>Website & Link Jurnal
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Website Jurnal --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Website Jurnal (OJS)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-globe"></i></span>
                                        <input type="url" 
                                               name="website_url" 
                                               class="form-control @error('website_url') is-invalid @enderror" 
                                               value="{{ old('website_url') }}" 
                                               placeholder="https://jurnal.example.ac.id">
                                    </div>
                                    @error('website_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Submit URL --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">URL Submit Artikel</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-paper-plane"></i></span>
                                        <input type="url" 
                                               name="submit_url" 
                                               class="form-control @error('submit_url') is-invalid @enderror" 
                                               value="{{ old('submit_url') }}" 
                                               placeholder="https://jurnal.example.ac.id/submit">
                                    </div>
                                    @error('submit_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- SINTA URL --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Link SINTA</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-chart-line"></i></span>
                                        <input type="url" 
                                               name="sinta_url" 
                                               class="form-control @error('sinta_url') is-invalid @enderror" 
                                               value="{{ old('sinta_url') }}" 
                                               placeholder="https://sinta.kemdikbud.go.id/...">
                                    </div>
                                    @error('sinta_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Garuda URL --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Link Garuda</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-book-open"></i></span>
                                        <input type="url" 
                                               name="garuda_url" 
                                               class="form-control @error('garuda_url') is-invalid @enderror" 
                                               value="{{ old('garuda_url') }}" 
                                               placeholder="https://garuda.kemdikbud.go.id/...">
                                    </div>
                                    @error('garuda_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Scholar URL --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Link Google Scholar</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fab fa-google"></i></span>
                                        <input type="url" 
                                               name="scholar_url" 
                                               class="form-control @error('scholar_url') is-invalid @enderror" 
                                               value="{{ old('scholar_url') }}" 
                                               placeholder="https://scholar.google.com/...">
                                    </div>
                                    @error('scholar_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 4. INFORMASI TAMBAHAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info me-2"></i>Informasi Tambahan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Frekuensi Terbit --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Frekuensi Terbit</label>
                                    <input type="text" 
                                           name="frequency" 
                                           class="form-control @error('frequency') is-invalid @enderror" 
                                           value="{{ old('frequency') }}" 
                                           placeholder="Contoh: 2x setahun">
                                    @error('frequency')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pemimpin Redaksi --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Pemimpin Redaksi</label>
                                    <input type="text" 
                                           name="editor_in_chief" 
                                           class="form-control @error('editor_in_chief') is-invalid @enderror" 
                                           value="{{ old('editor_in_chief') }}" 
                                           placeholder="Nama pemimpin redaksi">
                                    @error('editor_in_chief')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Penerbit --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Penerbit</label>
                                    <input type="text" 
                                           name="publisher" 
                                           class="form-control @error('publisher') is-invalid @enderror" 
                                           value="{{ old('publisher') }}" 
                                           placeholder="Nama lembaga penerbit">
                                    @error('publisher')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 5. COVER IMAGE --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Cover Jurnal
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Cover Image</label>
                                    <input type="file" 
                                           name="cover_image" 
                                           class="form-control @error('cover_image') is-invalid @enderror"
                                           id="coverInput"
                                           accept="image/*"
                                           onchange="previewCover(this)">
                                    <div class="form-text text-muted small">Format: JPG, PNG. Maksimal 2MB. Minimal 300x400px. Rasio 3:4 direkomendasikan.</div>
                                    @error('cover_image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Container --}}
                                    <div id="previewContainer" class="d-none mt-3 p-3 bg-light rounded border text-center" style="max-width: 200px;">
                                        <p class="small text-success fw-bold mb-2">Preview Cover:</p>
                                        <img id="coverPreview" class="img-fluid rounded shadow-sm" style="max-height: 250px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="resetCover()">
                                            <i class="fas fa-times me-1"></i> Hapus Cover
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 6. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Status
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="isVisible" 
                                                       name="is_visible" 
                                                       value="1" 
                                                       {{ old('is_visible', true) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="isVisible">Tampilkan di Website</label>
                                                <small class="d-block text-muted">Jurnal akan muncul di halaman publik.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="isActive" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="isActive">Status Aktif</label>
                                                <small class="d-block text-muted">Jurnal masih aktif menerbitkan.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.journals.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Jurnal
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
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-barcode text-primary me-2"></i> Format ISSN
                            </h6>
                            <p class="text-muted small mb-0">
                                Format ISSN harus: <code>1234-567X</code><br>
                                8 digit angka dengan strip di tengah. Digit terakhir bisa X.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-image text-success me-2"></i> Cover Jurnal
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: JPG atau PNG<br>
                                • Ukuran: Minimal 300x400px<br>
                                • File: Maksimal 2MB<br>
                                • Rasio: 3:4 (portrait)
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-link text-warning me-2"></i> Link URL
                            </h6>
                            <p class="text-muted small mb-0">
                                Semua URL harus lengkap dengan <code>https://</code><br>
                                Contoh: https://jurnal.example.ac.id
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-medal text-info me-2"></i> Akreditasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Pilih status akreditasi yang sesuai. SINTA 1 adalah yang tertinggi, SINTA 6 terendah.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK PREVIEW COVER --}}
<script>
    function previewCover(input) {
        const preview = document.getElementById('coverPreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            if (input.files[0].size > 2048 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetCover() {
        const input = document.getElementById('coverInput');
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('coverPreview');

        input.value = '';
        preview.src = '';
        container.classList.add('d-none');
    }
</script>
@endsection