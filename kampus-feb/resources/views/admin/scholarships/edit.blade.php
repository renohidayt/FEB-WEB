@extends('admin.layouts.app')

@section('title', 'Edit Beasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Info Beasiswa</h1>
            <p class="text-muted small mb-0">Update: <strong>{{ $scholarship->name }}</strong></p>
        </div>
        <a href="{{ route('admin.scholarships.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <form action="{{ route('admin.scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data" id="scholarshipForm">
                @csrf
                @method('PUT')

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
                                   value="{{ old('name', $scholarship->name) }}"
                                   class="form-control @error('name') is-invalid @enderror"
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
                                    @foreach(\App\Models\Scholarship::types() as $key => $label)
                                        <option value="{{ $key }}" {{ old('type', $scholarship->type) == $key ? 'selected' : '' }}>
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
                                    @foreach(\App\Models\Scholarship::categories() as $key => $label)
                                        <option value="{{ $key }}" {{ old('category', $scholarship->category) == $key ? 'selected' : '' }}>
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
                                       value="{{ old('provider', $scholarship->provider) }}"
                                       class="form-control">
                            </div>

                            {{-- Nominal --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Nominal Beasiswa</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rp</span>
                                    <input type="number" 
                                           name="amount" 
                                           value="{{ old('amount', $scholarship->amount) }}"
                                           class="form-control"
                                           min="0"
                                           step="1000">
                                </div>
                            </div>

                            {{-- Kuota --}}
                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Kuota Penerima</label>
                                <input type="number" 
                                       name="quota" 
                                       value="{{ old('quota', $scholarship->quota) }}"
                                       class="form-control"
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
                                       value="{{ old('registration_start', $scholarship->registration_start?->format('Y-m-d')) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Tutup Pendaftaran</label>
                                <input type="date" 
                                       name="registration_end" 
                                       value="{{ old('registration_end', $scholarship->registration_end?->format('Y-m-d')) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-4">
                                <label class="form-label fw-bold small">Tanggal Pengumuman</label>
                                <input type="date" 
                                       name="announcement_date" 
                                       value="{{ old('announcement_date', $scholarship->announcement_date?->format('Y-m-d')) }}"
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
                        {{-- Current Poster --}}
                        @if($scholarship->poster)
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Poster Saat Ini</label>
                            <div class="card bg-light border-0" id="currentPoster">
                                <div class="card-body p-3 text-center">
                                    <img src="{{ asset('storage/' . $scholarship->poster) }}" 
                                         alt="{{ $scholarship->name }}"
                                         class="img-fluid rounded shadow-sm" 
                                         style="max-width: 300px; transition: opacity 0.3s;">
                                    <p class="small text-muted mb-0 mt-2">Upload baru di bawah untuk mengganti</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        {{-- Upload New --}}
                        <label class="form-label fw-bold small">
                            {{ $scholarship->poster ? 'Ganti Poster' : 'Upload Poster' }} <span class="text-muted">(Opsional)</span>
                        </label>
                        <div class="border border-2 border-dashed rounded p-4 text-center bg-light" style="cursor: pointer;" onclick="document.getElementById('posterInput').click()">
                            <input type="file" 
                                   name="poster" 
                                   id="posterInput"
                                   accept="image/jpeg,image/png,image/jpg"
                                   onchange="previewPoster(this)"
                                   class="d-none">
                            <i class="fas fa-cloud-upload-alt text-muted mb-2" style="font-size: 2.5rem;"></i>
                            <p class="mb-1 fw-semibold">Klik untuk upload poster baru</p>
                            <small class="text-muted">PNG, JPG (Max: 5MB)</small>
                        </div>
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah poster</small>
                        
                        <div id="posterPreview" class="mt-3 d-none text-center">
                            <div class="alert alert-success border-0">
                                <strong>Preview Poster Baru:</strong>
                            </div>
                            <img id="previewImage" class="img-fluid rounded shadow-sm border border-2 border-success" style="max-width: 300px;">
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
                                      required>{{ old('description', $scholarship->description) }}</textarea>
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
                                      required>{{ old('requirements', $scholarship->requirements) }}</textarea>
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
                                       value="{{ old('contact_person', $scholarship->contact_person) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">No. HP/WhatsApp</label>
                                <input type="text" 
                                       name="contact_phone" 
                                       value="{{ old('contact_phone', $scholarship->contact_phone) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Email</label>
                                <input type="email" 
                                       name="contact_email" 
                                       value="{{ old('contact_email', $scholarship->contact_email) }}"
                                       class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-bold small">Link Website/Pendaftaran</label>
                                <input type="url" 
                                       name="website_url" 
                                       value="{{ old('website_url', $scholarship->website_url) }}"
                                       class="form-control">
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
                                                   {{ old('is_active', $scholarship->is_active) ? 'checked' : '' }}
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
                                                   {{ old('is_featured', $scholarship->is_featured) ? 'checked' : '' }}
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
                        <i class="fas fa-save me-1"></i> Update Beasiswa
                    </button>
                </div>
            </form>
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
                                <strong>Views:</strong> {{ $scholarship->views ?? 0 }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Dibuat:</strong> {{ $scholarship->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $scholarship->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Data
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Semua informasi<br>
                                • Poster (optional)<br>
                                • Status & featured<br>
                                • Kontak informasi
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-image text-success me-2"></i> Ganti Poster
                            </h6>
                            <p class="text-muted small mb-0">
                                • Upload baru = replace<br>
                                • Kosongkan = tetap lama<br>
                                • Max 5MB<br>
                                • Format: JPG, PNG
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • Cek tanggal pendaftaran<br>
                                • Pastikan kontak valid<br>
                                • Review sebelum save<br>
                                • Update jika ada perubahan
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
const currentPoster = document.getElementById('currentPoster');

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
            
            // Opacity for current
            if (currentPoster) {
                currentPoster.style.opacity = '0.5';
            }
        };
        reader.readAsDataURL(file);
    }
}
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection