@extends('admin.layouts.app')

@section('title', 'Edit Event')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Data Event</h1>
            <p class="text-muted small mb-0">Update informasi event: <strong>{{ $event->title }}</strong></p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-calendar-alt me-2"></i>Formulir Edit Event</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('title', $event->title) }}"
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
                                           value="{{ old('start_date', $event->start_date->format('Y-m-d')) }}"
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
                                           value="{{ old('end_date', $event->end_date->format('Y-m-d')) }}"
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
                                           value="{{ old('start_time', $event->start_time) }}"
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
                                           value="{{ old('end_time', $event->end_time) }}"
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
                                           value="{{ old('location', $event->location) }}"
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
                                           value="{{ old('organizer', $event->organizer) }}"
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
                                           value="{{ old('participants', $event->participants) }}"
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
                                           value="{{ old('url', $event->url) }}"
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
                                           value="{{ old('keywords', $event->keywords) }}"
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
                                              required>{{ old('description', $event->description) }}</textarea>
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
                                    {{-- Current Poster Display --}}
                                    @if($event->poster)
                                    <div class="mb-3">
                                        <p class="small text-muted mb-2">Poster saat ini:</p>
                                        <div class="d-flex align-items-center gap-3 p-3 bg-light border rounded">
                                            <div class="flex-shrink-0">
                                                <img src="{{ Storage::url($event->poster) }}" 
                                                     alt="Current Poster" 
                                                     class="rounded shadow-sm"
                                                     style="width: 120px; height: 80px; object-fit: cover;">
                                            </div>
                                            <div class="flex-grow-1 min-w-0">
                                                <p class="fw-semibold mb-0 small">{{ basename($event->poster) }}</p>
                                                <small class="text-muted">Poster tersimpan</small>
                                            </div>
                                            <a href="{{ Storage::url($event->poster) }}" 
                                               class="btn btn-sm btn-primary flex-shrink-0" 
                                               target="_blank">
                                                <i class="fas fa-eye me-1"></i>Lihat
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    <label class="form-label fw-bold small">
                                        Upload Poster {{ $event->poster ? 'Baru' : '' }}
                                        @if($event->poster)
                                            <span class="text-muted">(Opsional - kosongkan jika tidak ingin mengubah)</span>
                                        @endif
                                    </label>
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
                                    <div id="previewContainer" class="d-none mt-3 p-3 bg-success bg-opacity-10 rounded border border-success" style="max-width: 300px;">
                                        <p class="small text-success fw-bold mb-2">
                                            <i class="fas fa-check-circle me-1"></i>Preview Poster Baru:
                                        </p>
                                        <img id="posterPreview" class="img-fluid rounded shadow-sm" style="max-height: 300px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="resetPoster()">
                                            <i class="fas fa-times me-1"></i> Hapus Preview
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
                                                <option value="draft" {{ old('status', $event->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                                                <option value="published" {{ old('status', $event->status) == 'published' ? 'selected' : '' }}>Published</option>
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
                                <i class="fas fa-save me-1"></i> Update Event
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
                                <strong>Tanggal:</strong> {{ $event->formatted_date }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Waktu:</strong> {{ $event->formatted_time }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Lokasi:</strong> {{ $event->location }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Status:</strong> 
                                <span class="badge {{ $event->status === 'published' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $event->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-calendar text-primary me-2"></i> Tanggal & Waktu
                            </h6>
                            <p class="text-muted small mb-0">
                                Ubah tanggal/waktu jika ada perubahan jadwal. Pastikan data konsisten.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-image text-success me-2"></i> Poster Event
                            </h6>
                            <p class="text-muted small mb-0">
                                @if($event->poster)
                                    Poster sudah ada. Upload file baru hanya jika ingin mengganti poster lama.
                                @else
                                    Belum ada poster. Silakan upload poster event.
                                @endif
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-calendar-check text-warning me-2"></i> Status Event
                            </h6>
                            <p class="text-muted small mb-0">
                                @if($event->isOngoing())
                                    <span class="badge bg-primary">Sedang Berlangsung</span>
                                @elseif($event->start_date > now())
                                    <span class="badge bg-warning text-dark">Akan Datang</span>
                                @else
                                    <span class="badge bg-secondary">Sudah Selesai</span>
                                @endif
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting
                            </h6>
                            <p class="text-muted small mb-0">
                                • Pastikan tanggal & waktu benar<br>
                                • Poster tidak corrupt (jika diganti)<br>
                                • Status sesuai kebutuhan<br>
                                • Cek preview sebelum submit
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
                container.classList.add('d-none');
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