@extends('admin.layouts.app')

@section('title', 'Tambah Event')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Event Baru</h1>
            <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk membuat event baru.</p>
        </div>
        <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i>Formulir Data Event</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- 1. INFORMASI DASAR --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-edit me-2"></i>Informasi Dasar
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Judul Event --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Judul Event <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="title" 
                                           value="{{ old('title') }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="Contoh: Seminar Nasional Ekonomi Digital"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tanggal Mulai & Selesai --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tanggal Mulai <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           name="start_date" 
                                           value="{{ old('start_date') }}"
                                           class="form-control @error('start_date') is-invalid @enderror" 
                                           required>
                                    @error('start_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Tanggal Selesai <span class="text-danger">*</span></label>
                                    <input type="date" 
                                           name="end_date" 
                                           value="{{ old('end_date') }}"
                                           class="form-control @error('end_date') is-invalid @enderror" 
                                           required>
                                    @error('end_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jam Mulai & Selesai --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Jam Mulai <span class="text-danger">*</span></label>
                                    <input type="time" 
                                           name="start_time" 
                                           value="{{ old('start_time') }}"
                                           class="form-control @error('start_time') is-invalid @enderror" 
                                           required>
                                    @error('start_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Jam Selesai <span class="text-danger">*</span></label>
                                    <input type="time" 
                                           name="end_time" 
                                           value="{{ old('end_time') }}"
                                           class="form-control @error('end_time') is-invalid @enderror" 
                                           required>
                                    @error('end_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Tempat --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tempat <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="location" 
                                           value="{{ old('location') }}"
                                           class="form-control @error('location') is-invalid @enderror"
                                           placeholder="Contoh: Aula Utama Gedung A"
                                           required>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Penyelenggara --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Penyelenggara <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="organizer" 
                                           value="{{ old('organizer') }}"
                                           class="form-control @error('organizer') is-invalid @enderror"
                                           placeholder="Contoh: Fakultas Ekonomi dan Bisnis"
                                           required>
                                    @error('organizer')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. INFORMASI TAMBAHAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-align-left me-2"></i>Informasi Tambahan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Peserta --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Peserta</label>
                                    <input type="text" 
                                           name="participants" 
                                           value="{{ old('participants') }}"
                                           class="form-control @error('participants') is-invalid @enderror"
                                           placeholder="Contoh: Mahasiswa, Dosen, Umum">
                                    @error('participants')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- URL/Link --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">URL/Link</label>
                                    <input type="url" 
                                           name="url" 
                                           value="{{ old('url') }}"
                                           class="form-control @error('url') is-invalid @enderror"
                                           placeholder="https://contoh.com/event">
                                    @error('url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Link pendaftaran atau informasi lebih lanjut</small>
                                </div>

                                {{-- Kata Kunci --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Kata Kunci</label>
                                    <input type="text" 
                                           name="keywords" 
                                           value="{{ old('keywords') }}"
                                           class="form-control @error('keywords') is-invalid @enderror"
                                           placeholder="seminar, workshop, teknologi">
                                    @error('keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Pisahkan dengan koma</small>
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi <span class="text-danger">*</span></label>
                                    <textarea name="description" 
                                              rows="6" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Jelaskan detail event..." 
                                              required>{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. POSTER EVENT --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-image me-2"></i>Poster Event
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Poster</label>
                                    <input type="file" 
                                           name="poster" 
                                           id="posterInput" 
                                           accept="image/*"
                                           class="form-control @error('poster') is-invalid @enderror"
                                           onchange="previewPoster(this)">
                                    <div class="form-text text-muted small">Format: JPG, PNG. Maksimal 2MB.</div>
                                    @error('poster')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Container --}}
                                    <div id="previewContainer" class="d-none mt-3 p-3 bg-light rounded border text-center" style="max-width: 300px;">
                                        <p class="small text-success fw-bold mb-2">Preview Poster:</p>
                                        <img id="posterPreview" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="resetPoster()">
                                            <i class="fas fa-times me-1"></i> Hapus Poster
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Publikasi
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label fw-bold small">Status <span class="text-danger">*</span></label>
                                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                                <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                            <small class="text-muted d-block mt-1">Draft tidak akan ditampilkan di website</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.events.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Event
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
                                <i class="fas fa-calendar text-primary me-2"></i> Tanggal & Waktu
                            </h6>
                            <p class="text-muted small mb-0">
                                • Pastikan tanggal mulai ≤ tanggal selesai<br>
                                • Jam mulai harus < jam selesai<br>
                                • Format 24 jam (HH:MM)
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-map-marker-alt text-success me-2"></i> Lokasi Event
                            </h6>
                            <p class="text-muted small mb-0">
                                Tuliskan nama lengkap tempat. Contoh:<br>
                                • Aula Utama Gedung A<br>
                                • Ruang Seminar Lantai 3<br>
                                • Atau: "Online via Zoom"
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-image text-warning me-2"></i> Poster Event
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: JPG atau PNG<br>
                                • Ukuran: Maksimal 2MB<br>
                                • Dimensi: Min 800x600px<br>
                                • Rasio: 4:3 atau 16:9 recommended
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-align-left text-info me-2"></i> Deskripsi
                            </h6>
                            <p class="text-muted small mb-0">
                                Tuliskan informasi lengkap:<br>
                                • Tema/topik event<br>
                                • Pembicara (jika ada)<br>
                                • Agenda acara<br>
                                • Manfaat bagi peserta
                            </p>
                        </div>

                        {{-- Guide 5 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-cog text-danger me-2"></i> Status Publikasi
                            </h6>
                            <p class="text-muted small mb-0">
                                • <span class="badge bg-secondary">Draft</span> untuk menyimpan dulu<br>
                                • <span class="badge bg-success">Published</span> untuk tampil di website<br>
                                Status bisa diubah kapan saja
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK PREVIEW POSTER --}}
<script>
    function previewPoster(input) {
        const preview = document.getElementById('posterPreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            if (input.files[0].size > 2 * 1024 * 1024) {
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

    function resetPoster() {
        const input = document.getElementById('posterInput');
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('posterPreview');

        input.value = '';
        preview.src = '';
        container.classList.add('d-none');
    }
</script>
@endsection