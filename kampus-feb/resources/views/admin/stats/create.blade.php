@extends('admin.layouts.app')

@section('title', 'Tambah Statistik')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Statistik Baru</h1>
            <p class="text-muted small mb-0">Tambah angka statistik untuk homepage</p>
        </div>
        <a href="{{ route('admin.stats.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <form action="{{ route('admin.stats.store') }}" method="POST">
                @csrf

                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-chart-line me-2"></i>Informasi Statistik</h6>
                    </div>
                    <div class="card-body">
                        {{-- Key --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">Key (ID Unik) <span class="text-danger">*</span></label>
                            <input type="text" name="key" value="{{ old('key') }}" 
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
                            <input type="text" name="label" value="{{ old('label') }}" 
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
                            <input type="number" name="value" value="{{ old('value', 0) }}" 
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
                            <input type="number" name="order" value="{{ old('order', 0) }}" 
                                   class="form-control" min="0" required>
                            <small class="text-muted">Urutan dari kiri ke kanan (0, 1, 2, 3...)</small>
                        </div>

                        {{-- Is Active --}}
                        <div class="mb-0">
                            <div class="form-check form-switch">
                                <input type="checkbox" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}
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
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-lightbulb me-2"></i>Contoh Data</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 mb-3">
                        <small>Isi data untuk ditampilkan di homepage</small>
                    </div>

                    <div class="bg-light p-3 rounded border mb-3">
                        <p class="small fw-bold mb-2">Contoh 1: Mahasiswa</p>
                        <ul class="small text-muted mb-0 ps-3">
                            <li>Key: <code>mahasiswa</code></li>
                            <li>Label: Mahasiswa</li>
                            <li>Value: 1500</li>
                            <li>Order: 0</li>
                        </ul>
                    </div>

                    <div class="bg-light p-3 rounded border mb-3">
                        <p class="small fw-bold mb-2">Contoh 2: Dosen</p>
                        <ul class="small text-muted mb-0 ps-3">
                            <li>Key: <code>dosen</code></li>
                            <li>Label: Dosen</li>
                            <li>Value: 45</li>
                            <li>Order: 1</li>
                        </ul>
                    </div>

                    <div class="bg-light p-3 rounded border">
                        <p class="small fw-bold mb-2">Contoh 3: Alumni</p>
                        <ul class="small text-muted mb-0 ps-3">
                            <li>Key: <code>alumni</code></li>
                            <li>Label: Alumni</li>
                            <li>Value: 5000</li>
                            <li>Order: 2</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection