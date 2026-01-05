@extends('admin.layouts.app')

@section('title', 'Tambah Mahasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Mahasiswa</h1>
            <p class="text-muted small mb-0">Tambah data mahasiswa secara manual</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- INFO ALERT --}}
    <div class="alert alert-info border-0 mb-3">
        <h6 class="alert-heading fw-bold">
            <i class="fas fa-info-circle me-2"></i>Informasi Password
        </h6>
        <ul class="small mb-0 ps-3">
            <li>Password default akan dibuat dari tanggal lahir (format: DDMMYYYY)</li>
            <li>Contoh: Jika lahir 29 Maret 2007, password = <code>29032007</code></li>
            <li>Email otomatis: <code>NIM@student.unsap.ac.id</code></li>
            <li>Mahasiswa dapat login dengan NIM sebagai username</li>
        </ul>
    </div>

    {{-- FORM CARD --}}
    <div class="card shadow-sm">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-user-plus me-2"></i>Form Data Mahasiswa
            </h6>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.students.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    {{-- NIM --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            NIM <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nim" 
                               class="form-control @error('nim') is-invalid @enderror" 
                               value="{{ old('nim') }}"
                               placeholder="Contoh: 220660121001"
                               required>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Nomor Induk Mahasiswa (harus unik)</small>
                    </div>

                    {{-- NIK --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">NIK</label>
                        <input type="text" 
                               name="nik" 
                               class="form-control @error('nik') is-invalid @enderror" 
                               value="{{ old('nik') }}"
                               placeholder="16 digit">
                        @error('nik')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Nama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">
                            Nama Lengkap <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="nama" 
                               class="form-control @error('nama') is-invalid @enderror" 
                               value="{{ old('nama') }}"
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
                            <option value="">Pilih...</option>
                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
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
                               value="{{ old('tempat_tanggal_lahir') }}"
                               required>
                        @error('tempat_tanggal_lahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">Akan digunakan sebagai password default</small>
                    </div>

                    {{-- Agama --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Agama</label>
                        <select name="agama" class="form-select @error('agama') is-invalid @enderror">
                            <option value="">Pilih...</option>
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
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
                            <option value="">Pilih...</option>
                            <option value="S1 Akuntansi" {{ old('program_studi') == 'S1 Akuntansi' ? 'selected' : '' }}>S1 Akuntansi</option>
                            <option value="S1 Manajemen" {{ old('program_studi') == 'S1 Manajemen' ? 'selected' : '' }}>S1 Manajemen</option>
                            <option value="S2 Magister Managemen" {{ old('program_studi') == 'S2 Magister Managemen' ? 'selected' : '' }}>S2 Magister Managemen</option>
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
                               value="{{ old('tanggal_masuk', date('Y-m-d')) }}"
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
                            <option value="AKTIF" {{ old('status', 'AKTIF') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                            <option value="CUTI" {{ old('status') == 'CUTI' ? 'selected' : '' }}>Cuti</option>
                            <option value="LULUS" {{ old('status') == 'LULUS' ? 'selected' : '' }}>Lulus</option>
                            <option value="KELUAR" {{ old('status') == 'KELUAR' ? 'selected' : '' }}>Keluar</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Jenis --}}
                    <div class="col-md-6">
                        <label class="form-label fw-bold small">Jenis Peserta</label>
                        <select name="jenis" class="form-select @error('jenis') is-invalid @enderror">
                            <option value="Peserta didik baru" {{ old('jenis', 'Peserta didik baru') == 'Peserta didik baru' ? 'selected' : '' }}>Peserta didik baru</option>
                            <option value="Peserta didik pindahan" {{ old('jenis') == 'Peserta didik pindahan' ? 'selected' : '' }}>Peserta didik pindahan</option>
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
                               value="{{ old('biaya_masuk') }}"
                               step="1000"
                               placeholder="0">
                        @error('biaya_masuk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Alamat --}}
                    <div class="col-12">
                        <label class="form-label fw-bold small">Alamat</label>
                        <textarea name="alamat" 
                                  rows="3" 
                                  class="form-control @error('alamat') is-invalid @enderror"
                                  placeholder="Alamat lengkap">{{ old('alamat') }}</textarea>
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="mt-4 pt-3 border-top d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection