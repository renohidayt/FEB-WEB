@extends('admin.layouts.app')

@section('title', 'Import Mahasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Import Data Mahasiswa</h1>
            <p class="text-muted small mb-0">Upload file CSV untuk import mahasiswa secara massal</p>
        </div>
        <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            {{-- UPLOAD FORM --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-file-excel me-2"></i>Upload File Excel
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.students.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- File Input --}}
                        <div class="mb-3">
                            <label class="form-label fw-bold small">File Excel <span class="text-danger">*</span></label>
                            <input type="file" 
                                   name="file" 
                                   class="form-control @error('file') is-invalid @enderror" 
                                   accept=".xlsx,.xls,.csv"
                                   required>
                            <small class="text-muted">Format: .xlsx, .xls, .csv (Max: 10MB)</small>
                            @error('file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Info Alert --}}
                        <div class="alert alert-info border-0 mb-3">
                            <h6 class="alert-heading fw-bold">
                                <i class="fas fa-info-circle me-2"></i>Informasi Penting
                            </h6>
                            <ul class="small mb-0 ps-3">
                                <li>File harus sesuai dengan template yang disediakan</li>
                                <li>NIM akan menjadi username login</li>
                                <li>Tanggal lahir akan menjadi password awal (format: DDMMYYYY)</li>
                                <li>Mahasiswa dengan NIM yang sudah ada akan dilewati</li>
                            </ul>
                        </div>

                        {{-- Buttons --}}
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-upload me-1"></i> Upload & Import
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ERROR MESSAGES --}}
            @if(session('errors') && is_array(session('errors')))
                <div class="card shadow-sm border-danger">
                    <div class="card-header bg-danger text-white py-3">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Ditemukan {{ count(session('errors')) }} Error
                        </h6>
                    </div>
                    <div class="card-body" style="max-height: 300px; overflow-y: auto;">
                        <ul class="small mb-0 ps-3">
                            @foreach(session('errors') as $error)
                                <li class="text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        {{-- SIDEBAR --}}
        <div class="col-lg-4">
            {{-- Download Template --}}
            <div class="card shadow-sm mb-3 border-left-primary">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold">
                        <i class="fas fa-download me-2"></i>Download Template
                    </h6>
                </div>
                <div class="card-body text-center">
                    <i class="fas fa-file-excel text-success mb-3" style="font-size: 3rem;"></i>
                    <p class="small text-muted mb-3">Download template CSV untuk import mahasiswa</p>
                    {{-- Ganti baris ini --}}
<a href="{{ asset('templates/template_mahasiswa.csv') }}" 
   class="btn btn-success btn-sm w-100" 
   download="template_mahasiswa.csv"> {{-- Tambahkan atribut download di sini --}}
    <i class="fas fa-download me-1"></i> Download Template
</a>
                </div>
            </div>

            {{-- Format Kolom --}}
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 fw-bold text-warning">
                        <i class="fas fa-table me-2"></i>Format Kolom Excel
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm small">
                            <thead class="table-light">
                                <tr>
                                    <th>Kolom</th>
                                    <th>Wajib</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>NIM</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>NIK</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                                <tr>
                                    <td>Nama</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>Program Studi</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>Tanggal Masuk</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>Status</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                                <tr>
                                    <td>Jenis</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                                <tr>
                                    <td>Biaya Masuk</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                                <tr>
                                    <td>Jenis Kelamin</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>Tempat,Tanggal Lahir</td>
                                    <td><span class="badge bg-danger">Ya</span></td>
                                </tr>
                                <tr>
                                    <td>Agama</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                                <tr>
                                    <td>Alamat</td>
                                    <td><span class="badge bg-secondary">Tidak</span></td>
                                </tr>
                            </tbody>
                        </table>
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