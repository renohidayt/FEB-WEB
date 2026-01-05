@extends('admin.layouts.app')

@section('title', 'Tambah Beasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Info Beasiswa Baru</h1>
            <p class="text-muted small mb-0">Lengkapi informasi beasiswa untuk mahasiswa.</p>
        </div>
        <a href="{{ route('admin.scholarships.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <form action="{{ route('admin.scholarships.store') }}" method="POST" enctype="multipart/form-data" id="scholarshipForm">
                @csrf

                {{-- 1. INFORMASI DASAR --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-graduation-cap me-2"></i>Informasi Dasar</h6>
                    </div>
                    <div class="card-body">
                        {{-- Nama Beasiswa --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Beasiswa <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="name" 
                                   value="{{ old('name') }}"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Contoh: Beasiswa PPA Kemenag 2024"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-3">
                            {{-- Jenis --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Jenis Beasiswa <span class="text-danger">*</span></label>
                                <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                    <option value="">Pilih Jenis</option>
                                    @foreach(\App\Models\Scholarship::types() as $key => $label)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Kategori --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kategori Website <span class="text-danger">*</span></label>
                                <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach(\App\Models\Scholarship::categories() as $key => $label)
                                        <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Pemberi --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Pemberi Beasiswa</label>
                                <input type="text" 
                                       name="provider" 
                                       value="{{ old('provider') }}"
                                       class="form-control"
                                       placeholder="Contoh: Kementerian Agama RI">
                            </div>

                            {{-- Nominal --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nominal Beasiswa</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           name="amount" 
                                           value="{{ old('amount') }}"
                                           class="form-control"
                                           placeholder="5000000"
                                           min="0"
                                           step="1000">
                                </div>
                                <small class="text-muted">Kosongkan jika tidak disebutkan</small>
                            </div>

                            {{-- Kuota --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kuota Penerima</label>
                                <input type="number" 
                                       name="quota" 
                                       value="{{ old('quota') }}"
                                       class="form-control"
                                       placeholder="50"
                                       min="1">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. TANGGAL --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-calendar me-2"></i>Jadwal Pendaftaran</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Buka Pendaftaran</label>
                                <input type="date" 
                                       name="registration_start" 
                                       value="{{ old('registration_start') }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Tutup Pendaftaran</label>
                                <input type="date" 
                                       name="registration_end" 
                                       value="{{ old('registration_end') }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Tanggal Pengumuman</label>
                                <input type="date" 
                                       name="announcement_date" 
                                       value="{{ old('announcement_date') }}"
                                       class="form-control">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. POSTER --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-image me-2"></i>Poster/Banner</h6>
                    </div>
                    <div class="card-body">
                        <label class="form-label fw-bold small">Upload Poster Beasiswa</label>
                        <div class="border border-2 border-dashed rounded p-4 text-center bg-light" style="cursor: pointer;" onclick="document.getElementById('posterInput').click()">
                            <input type="file" 
                                   name="poster" 
                                   id="posterInput"
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewPoster(this)"
                                   class="d-none">
                            <i class="fas fa-cloud-upload-alt text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="mb-1 fw-semibold">Klik untuk upload poster</p>
                            <small class="text-muted">PNG, JPG (1080x1350px, Max: 5MB)</small>
                        </div>
                        @error('poster')
                            <div class="text-danger small mt-2">{{ $message }}</div>
                        @enderror
                        
                        <div id="posterPreview" class="mt-3 d-none text-center">
                            <img id="previewImage" class="img-fluid rounded shadow-sm" style="max-width: 300px;">
                        </div>
                    </div>
                </div>

                {{-- 4. DESKRIPSI & PERSYARATAN --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-file-alt me-2"></i>Deskripsi & Persyaratan</h6>
                    </div>
                    <div class="card-body">
                        {{-- Deskripsi --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Deskripsi Beasiswa <span class="text-danger">*</span></label>
                            <textarea name="description" 
                                      rows="6"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Jelaskan tentang beasiswa ini..."
                                      required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Persyaratan --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small">Persyaratan <span class="text-danger">*</span></label>
                            <textarea name="requirements" 
                                      rows="6"
                                      class="form-control @error('requirements') is-invalid @enderror"
                                      placeholder="- IPK minimal 3.0&#10;- Aktif organisasi&#10;- Tidak sedang menerima beasiswa lain"
                                      required>{{ old('requirements') }}</textarea>
                            <small class="text-muted">Tuliskan persyaratan (satu per baris dengan tanda -)</small>
                            @error('requirements')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- 5. KONTAK --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-phone me-2"></i>Informasi Kontak</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Contact Person</label>
                                <input type="text" 
                                       name="contact_person" 
                                       value="{{ old('contact_person') }}"
                                       class="form-control"
                                       placeholder="Nama PIC">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">No. HP/WhatsApp</label>
                                <input type="text" 
                                       name="contact_phone" 
                                       value="{{ old('contact_phone') }}"
                                       class="form-control"
                                       placeholder="08123456789">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email</label>
                                <input type="email" 
                                       name="contact_email" 
                                       value="{{ old('contact_email') }}"
                                       class="form-control"
                                       placeholder="beasiswa@kampus.ac.id">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Link Website/Pendaftaran</label>
                                <input type="url" 
                                       name="website_url" 
                                       value="{{ old('website_url') }}"
                                       class="form-control"
                                       placeholder="https://...">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 6. STATUS --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-toggle-on me-2"></i>Pengaturan</h6>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" 
                                                   name="is_active" 
                                                   value="1"
                                                   {{ old('is_active', true) ? 'checked' : '' }}
                                                   class="form-check-input" 
                                                   id="isActive">
                                            <label class="form-check-label fw-bold" for="isActive">Aktif</label>
                                            <small class="d-block text-muted">Tampilkan di website</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light border-0">
                                    <div class="card-body p-3">
                                        <div class="form-check form-switch">
                                            <input type="checkbox" 
                                                   name="is_featured" 
                                                   value="1"
                                                   {{ old('is_featured') ? 'checked' : '' }}
                                                   class="form-check-input" 
                                                   id="isFeatured">
                                            <label class="form-check-label fw-bold" for="isFeatured">⭐ Featured</label>
                                            <small class="d-block text-muted">Tampil di homepage</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex justify-content-end gap-2 mb-3">
                    <a href="{{ route('admin.scholarships.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Simpan Beasiswa
                    </button>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field bertanda <span class="text-danger">*</span> wajib diisi.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-graduation-cap text-primary me-2"></i> Info Dasar
                            </h6>
                            <p class="text-muted small mb-0">
                                • Nama beasiswa harus jelas<br>
                                • Pilih jenis yang sesuai<br>
                                • Nominal opsional<br>
                                • Kuota jika ada
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-calendar text-success me-2"></i> Jadwal
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Tanggal penting:</strong><br>
                                • Buka pendaftaran<br>
                                • Tutup pendaftaran<br>
                                • Pengumuman hasil<br>
                                • Semua opsional
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-image text-warning me-2"></i> Poster
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Specs:</strong><br>
                                • Format: JPG, PNG<br>
                                • Size: Max 5MB<br>
                                • Resolusi: 1080x1350px<br>
                                • Rasio: Portrait (4:5)
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-circle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • Deskripsi harus lengkap<br>
                                • Persyaratan jelas<br>
                                • Kontak dapat dihubungi<br>
                                • Review sebelum publish
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
function previewPoster(input) {
    const preview = document.getElementById('posterPreview');
    const previewImage = document.getElementById('previewImage');
    
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            preview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection