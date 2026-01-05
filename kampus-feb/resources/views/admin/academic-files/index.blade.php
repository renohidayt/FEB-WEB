@extends('admin.layouts.app')

@section('title', 'Kelola File Akademik')

@push('styles')
<style>
    .stat-card {
        border-radius: 10px;
        transition: all 0.2s;
        border: 1px solid #e5e7eb;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    @media (max-width: 768px) {
        .stat-card {
            padding: 0.75rem !important;
        }
    }
</style>
@endpush

@section('content')
<div class="px-3 py-3">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Kelola File Akademik</h1>
            <p class="text-muted small mb-0">Manajemen kalender akademik dan jadwal perkuliahan</p>
        </div>
        <a href="{{ route('admin.academic-files.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-upload me-2"></i>Upload File
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total File</p>
                            <h3 class="h5 fw-bold mb-0">{{ $files->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-file text-primary" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Kalender</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $files->where('type', 'kalender')->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-calendar-alt text-info" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Jadwal</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $files->where('type', 'jadwal')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-table text-success" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Download</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $files->sum('download_count') }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-download text-warning" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.academic-files.index') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Cari file..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-6 col-md-3">
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Semua Tipe</option>
                            <option value="kalender" {{ request('type') === 'kalender' ? 'selected' : '' }}>Kalender Akademik</option>
                            <option value="jadwal" {{ request('type') === 'jadwal' ? 'selected' : '' }}>Jadwal Perkuliahan</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-3">
                        <select name="semester" class="form-select form-select-sm">
                            <option value="">Semua Semester</option>
                            <option value="ganjil" {{ request('semester') === 'ganjil' ? 'selected' : '' }}>Ganjil</option>
                            <option value="genap" {{ request('semester') === 'genap' ? 'selected' : '' }}>Genap</option>
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-dark btn-sm flex-grow-1">
                                <i class="fas fa-search"></i><span class="d-none d-sm-inline ms-1">Cari</span>
                            </button>
                            @if(request()->hasAny(['search', 'type', 'semester']))
                                <a href="{{ route('admin.academic-files.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                                    <i class="fas fa-redo"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="card border-0 shadow-sm d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 fw-semibold text-muted small">TIPE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">JUDUL</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">TAHUN/SEMESTER</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">FILE INFO</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">DOWNLOAD</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">STATUS</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($files as $file)
                    <tr>
                        <td class="px-3 py-2">
                            <span class="badge {{ $file->type === 'kalender' ? 'bg-info' : 'bg-success' }}" style="font-size: 0.7rem;">
                                {{ $file->type === 'kalender' ? 'Kalender' : 'Jadwal' }}
                            </span>
                        </td>

                        <td class="px-3 py-2">
                            <div class="fw-semibold small">{{ $file->title }}</div>
                            @if($file->description)
                                <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($file->description, 50) }}</small>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <div class="small">{{ $file->academic_year }}</div>
                            <small class="text-muted text-capitalize" style="font-size: 0.75rem;">{{ $file->semester }}</small>
                        </td>

                        <td class="px-3 py-2">
                            <div class="small fw-medium">{{ $file->file_name }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">
                                {{ strtoupper($file->file_type) }} • {{ $file->getFileSizeFormatted() }}
                            </small>
                        </td>

                        <td class="px-3 py-2 text-center">
                            <span class="badge bg-light text-dark">{{ $file->download_count }}</span>
                        </td>

                        <td class="px-3 py-2 text-center">
                            @if($file->is_active)
                                <span class="badge bg-success" style="font-size: 0.7rem;">Aktif</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.7rem;">Nonaktif</span>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ $file->getDownloadUrl() }}" 
                                   class="btn btn-sm btn-outline-success" 
                                   title="Lihat" 
                                   target="_blank">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <a href="{{ route('admin.academic-files.edit', $file) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.academic-files.destroy', $file) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin hapus file ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-folder-open text-muted mb-3" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">Belum ada file yang diupload</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($files->hasPages())
        <div class="card-footer bg-light py-2">
            {{ $files->links() }}
        </div>
        @endif
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($files as $file)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body p-3">
                <!-- Type Badge -->
                <div class="mb-2">
                    <span class="badge {{ $file->type === 'kalender' ? 'bg-info' : 'bg-success' }}" style="font-size: 0.7rem;">
                        {{ $file->type === 'kalender' ? 'Kalender' : 'Jadwal' }}
                    </span>
                    @if($file->is_active)
                        <span class="badge bg-success ms-1" style="font-size: 0.7rem;">Aktif</span>
                    @else
                        <span class="badge bg-secondary ms-1" style="font-size: 0.7rem;">Nonaktif</span>
                    @endif
                </div>

                <h6 class="fw-bold mb-1 small">{{ $file->title }}</h6>
                @if($file->description)
                    <small class="text-muted d-block mb-2" style="font-size: 0.75rem;">{{ Str::limit($file->description, 60) }}</small>
                @endif

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Tahun/Semester</small>
                        <span class="small fw-medium">{{ $file->academic_year }}</span>
                        <small class="text-muted d-block text-capitalize" style="font-size: 0.7rem;">{{ $file->semester }}</small>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">File Info</small>
                        <span class="small fw-medium">{{ strtoupper($file->file_type) }}</span>
                        <small class="text-muted d-block" style="font-size: 0.7rem;">{{ $file->getFileSizeFormatted() }}</small>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <small class="text-muted" style="font-size: 0.75rem;">
                        <i class="fas fa-download me-1"></i>{{ $file->download_count }} downloads
                    </small>

                    <div class="d-flex gap-1">
                        <a href="{{ $file->getDownloadUrl() }}" 
                           class="btn btn-sm btn-outline-success" 
                           target="_blank">
                            <i class="fas fa-eye"></i>
                        </a>

                        <a href="{{ route('admin.academic-files.edit', $file) }}" 
                           class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.academic-files.destroy', $file) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Yakin hapus file ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-folder-open text-muted mb-3" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0">Belum ada file yang diupload</p>
            </div>
        </div>
        @endforelse

        @if($files->hasPages())
        <div class="mt-3">
            {{ $files->links() }}
        </div>
        @endif
    </div>
</div>
@endsection