@extends('admin.layouts.app')

@section('title', 'Edit Statistik')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Statistik</h1>
            <p class="text-muted small mb-0">Update: <strong>{{ $stat->label }}</strong></p>
        </div>
        <a href="{{ route('admin.stats.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.stats.update', $stat) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-line me-2"></i>Informasi Statistik</h6>
                    </div>
                    <div class="card-body">
                        {{-- Key --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Key (ID Unik) <span class="text-danger">*</span></label>
                            <input type="text" name="key" value="{{ old('key', $stat->key) }}" 
                                   class="form-control @error('key') is-invalid @enderror"
                                   placeholder="mahasiswa, dosen, alumni" required>
                            <small class="text-muted">Gunakan lowercase tanpa spasi</small>
                            @error('key')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Label --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Label Tampilan <span class="text-danger">*</span></label>
                            <input type="text" name="label" value="{{ old('label', $stat->label) }}" 
                                   class="form-control @error('label') is-invalid @enderror"
                                   placeholder="Mahasiswa" required>
                            <small class="text-muted">Nama yang ditampilkan di website</small>
                            @error('label')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Value --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Angka/Nilai <span class="text-danger">*</span></label>
                            <input type="number" name="value" value="{{ old('value', $stat->value) }}" 
                                   class="form-control @error('value') is-invalid @enderror"
                                   min="0" required>
                            <small class="text-muted">Angka statistik (contoh: 1500)</small>
                            @error('value')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Order --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Urutan Tampilan <span class="text-danger">*</span></label>
                            <input type="number" name="order" value="{{ old('order', $stat->order) }}" 
                                   class="form-control" min="0" required>
                            <small class="text-muted">Urutan dari kiri ke kanan (0, 1, 2, 3...)</small>
                        </div>

                        {{-- Is Active --}}
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', $stat->is_active) ? 'checked' : '' }}
                                       class="form-check-input" id="isActive">
                                <label class="form-check-label fw-bold" for="isActive">Aktif (Tampilkan di website)</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.stats.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Update
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                </div>
                <div class="card-body">
                    {{-- Current Preview --}}
                    <div class="bg-light p-3 rounded border mb-3">
                        <h6 class="text-primary fw-bold mb-2 small">
                            <i class="fas fa-eye me-2"></i> Preview Saat Ini
                        </h6>
                        <div class="text-center py-2">
                            <h2 class="fw-bold mb-1 text-dark">{{ $stat->formatted_value }}</h2>
                            <p class="text-muted small mb-0">{{ $stat->label }}</p>
                        </div>
                    </div>

                    {{-- Stats Info --}}
                    <div class="bg-light p-3 rounded border mb-3">
                        <h6 class="text-success fw-bold mb-2 small">
                            <i class="fas fa-chart-bar text-success me-2"></i> Data
                        </h6>
                        <p class="text-muted small mb-1">
                            <strong>Key:</strong> <code>{{ $stat->key }}</code>
                        </p>
                        <p class="text-muted small mb-1">
                            <strong>Order:</strong> {{ $stat->order }}
                        </p>
                        <p class="text-muted small mb-0">
                            <strong>Dibuat:</strong> {{ $stat->created_at->format('d M Y') }}
                        </p>
                    </div>

                    {{-- Tips --}}
                    <div class="bg-light p-3 rounded border">
                        <h6 class="text-warning fw-bold mb-2 small">
                            <i class="fas fa-lightbulb text-warning me-2"></i> Tips
                        </h6>
                        <p class="text-muted small mb-0">
                            • Update angka secara berkala<br>
                            • Order menentukan urutan kiri-kanan<br>
                            • Angka akan otomatis diformat (1.500)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection