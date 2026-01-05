@extends('admin.layouts.app')

@section('title', 'Edit Mahasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Mahasiswa</h1>
            <p class="text-muted small mb-0">Perbarui data mahasiswa {{ $student->nama }}</p>
        </div>
        <a href="{{ route('admin.students.show', $student) }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- WARNING ALERT --}}
    <div class="alert alert-warning border-0 mb-3">
        <h6 class="alert-heading fw-bold">
            <i class="fas fa-exclamation-triangle me-2"></i>Perhatian
        </h6>
        <ul class="small mb-0 ps-3">
            <li><strong>NIM tidak dapat diubah</strong> karena terkait dengan akun login</li>
            <li>Perubahan nama akan mempengaruhi nama di akun user</li>
            <li>Password tetap menggunakan tanggal lahir (tidak berubah otomatis)</li>
        </ul>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-warning">
                <i class="fas fa-edit me-2"></i>Form Edit Data
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.update', $student) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    {{-- NIM (Read Only) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            NIM <span class="badge bg-secondary">Tidak dapat diubah</span>
                        </label>
                        <input type="text" 
                               class="form-control bg-light" 
                               value="{{ $student->nim }}"
                               readonly>
                        <small class="text-muted">NIM tidak dapat diubah setelah data dibuat</small>
                    </div>

                    {{-- NIK (Read Only) --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            NIK <span class="badge bg-secondary">Tidak dapat diubah</span>
                        </label>
                        <input type="text" 
                               class="form-control bg-light" 
                               value="{{ $student->nik ?? '-' }}"
                               readonly>
                    </div>

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama', $student->nama) }}"
                               required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis Kelamin --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Jenis Kelamin <span class="text-danger">*</span>
                        </label>
                        <select name="jenis_kelamin" class="form-select @error('jenis_kelamin') is-invalid @enderror" required>
                            <option value="L" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin', $student->jenis_kelamin) == 'P' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('jenis_kelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Lahir --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Tanggal Lahir <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               name="tempat_tanggal_lahir" 
                               class="form-control @error('tempat_tanggal_lahir') is-invalid @enderror" 
                               value="{{ old('tempat_tanggal_lahir', $student->tempat_tanggal_lahir ? $student->tempat_tanggal_lahir->format('Y-m-d') : '') }}"
                               required>
                        @error('tempat_tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Password tidak akan berubah otomatis jika tanggal lahir diubah</small>
                    </div>

                    {{-- Agama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Agama</label>
                        <select name="agama" class="form-select @error('agama') is-invalid @enderror">
                            <option value="">Pilih...</option>
                            <option value="Islam" {{ old('agama', $student->agama) == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama', $student->agama) == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama', $student->agama) == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama', $student->agama) == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama', $student->agama) == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama', $student->agama) == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Program Studi --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Program Studi <span class="text-danger">*</span>
                        </label>
                        <select name="program_studi" class="form-select @error('program_studi') is-invalid @enderror" required>
                            <option value="S1 Akuntansi" {{ old('program_studi', $student->program_studi) == 'S1 Akuntansi' ? 'selected' : '' }}>S1 Akuntansi</option>
                            <option value="S1 Manajemen" {{ old('program_studi', $student->program_studi) == 'S1 Manajemen' ? 'selected' : '' }}>S1 Manajemen</option>
                            <option value="S1 Ekonomi Pembangunan" {{ old('program_studi', $student->program_studi) == 'S1 Ekonomi Pembangunan' ? 'selected' : '' }}>S1 Ekonomi Pembangunan</option>
                        </select>
                        @error('program_studi')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Tanggal Masuk --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Tanggal Masuk <span class="text-danger">*</span>
                        </label>
                        <input type="date" 
                               name="tanggal_masuk" 
                               class="form-control @error('tanggal_masuk') is-invalid @enderror" 
                               value="{{ old('tanggal_masuk', $student->tanggal_masuk->format('Y-m-d')) }}"
                               required>
                        @error('tanggal_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Status <span class="text-danger">*</span>
                        </label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                            <option value="AKTIF" {{ old('status', $student->status) == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                            <option value="CUTI" {{ old('status', $student->status) == 'CUTI' ? 'selected' : '' }}>Cuti</option>
                            <option value="LULUS" {{ old('status', $student->status) == 'LULUS' ? 'selected' : '' }}>Lulus</option>
                            <option value="KELUAR" {{ old('status', $student->status) == 'KELUAR' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Jenis Peserta</label>
                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
                            <option value="Peserta didik baru" {{ old('jenis', $student->jenis) == 'Peserta didik baru' ? 'selected' : '' }}>Peserta didik baru</option>
                            <option value="Peserta didik pindahan" {{ old('jenis', $student->jenis) == 'Peserta didik pindahan' ? 'selected' : '' }}>Peserta didik pindahan</option>
                        </select>
                        @error('jenis')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Biaya Masuk --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Biaya Masuk</label>
                        <input type="number" 
                               name="biaya_masuk" 
                               class="form-control @error('biaya_masuk') is-invalid @enderror" 
                               value="{{ old('biaya_masuk', $student->biaya_masuk) }}"
                               step="1000">
                        @error('biaya_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label class="form-label fw-bold small">Alamat</label>
                        <textarea name="alamat" 
                                  rows="3" 
                                  class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $student->alamat) }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 pt-3 border-top d-flex justify-content-between">
                    <a href="{{ route('admin.students.show', $student) }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save me-1"></i> Update Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- INFO CARD --}}
    <div class="card shadow-sm mt-3 border-info">
        <div class="card-body">
            <h6 class="fw-bold text-info">
                <i class="fas fa-info-circle me-2"></i>Informasi Tambahan
            </h6>
            <ul class="small mb-0">
                <li>Password saat ini: <code>{{ $student->tempat_tanggal_lahir ? $student->tempat_tanggal_lahir->format('dmY') : 'N/A' }}</code></li>
            </ul>
        </div>
    </div>
</div>
@endsection