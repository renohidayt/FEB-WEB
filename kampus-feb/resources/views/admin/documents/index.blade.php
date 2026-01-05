@extends('admin.layouts.app')

@section('title', 'Kelola Dokumen')

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
            <h1 class="h4 fw-bold mb-1">Kelola Dokumen</h1>
            <p class="text-muted small mb-0">Kelola dan monitor semua dokumen kampus</p>
        </div>
        <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Dokumen
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Dokumen</p>
                            <h3 class="h5 fw-bold mb-0">{{ $documents->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-file-alt text-primary" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Downloads</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $documents->sum('downloads') }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-download text-success" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Bulan Ini</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $documents->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-calendar text-info" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Kategori</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $documents->pluck('category')->filter()->unique()->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-tags text-warning" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.documents.index') }}">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Cari dokumen..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-md-4">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            <option value="Akademik" {{ request('category') == 'Akademik' ? 'selected' : '' }}>Akademik</option>
                            <option value="Administrasi" {{ request('category') == 'Administrasi' ? 'selected' : '' }}>Administrasi</option>
                            <option value="Kurikulum" {{ request('category') == 'Kurikulum' ? 'selected' : '' }}>Kurikulum</option>
                            <option value="Penelitian" {{ request('category') == 'Penelitian' ? 'selected' : '' }}>Penelitian</option>
                            <option value="Pengabdian" {{ request('category') == 'Pengabdian' ? 'selected' : '' }}>Pengabdian</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-dark btn-sm flex-grow-1">
                                <i class="fas fa-search"></i><span class="d-none d-sm-inline ms-1">Cari</span>
                            </button>
                            @if(request()->hasAny(['search', 'category']))
                                <a href="{{ route('admin.documents.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
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
                        <th class="px-3 py-2 fw-semibold text-muted small">DOKUMEN</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">KATEGORI</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">TIPE FILE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">DOWNLOADS</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">UPLOAD</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($documents as $document)
                    <tr>
                        <td class="px-3 py-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="text-primary flex-shrink-0">
                                    <i class="fas fa-file-{{ $document->file_type == 'pdf' ? 'pdf' : 'alt' }}" style="font-size: 1.5rem;"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="fw-semibold small text-truncate">{{ $document->name }}</div>
                                    <small class="text-muted text-truncate d-block" style="font-size: 0.75rem;">{{ basename($document->file_path) }}</small>
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-2">
                            @if($document->category)
                                <span class="badge bg-primary" style="font-size: 0.7rem;">{{ $document->category }}</span>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <span class="badge bg-secondary text-uppercase" style="font-size: 0.7rem;">
                                {{ $document->file_type ?? pathinfo($document->file_path, PATHINFO_EXTENSION) }}
                            </span>
                        </td>

                        <td class="px-3 py-2 text-center">
                            <span class="badge bg-success" style="font-size: 0.7rem;">
                                <i class="fas fa-download me-1"></i>{{ $document->downloads }}
                            </span>
                        </td>

                        <td class="px-3 py-2">
                            <div class="small">{{ $document->created_at->format('d M Y') }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $document->created_at->diffForHumans() }}</small>
                        </td>

                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Download --}}
                                <a href="{{ asset('storage/' . $document->file_path) }}"
   target="_blank"
   download
   class="btn btn-sm btn-outline-success"
   title="Download">
    <i class="fas fa-download"></i>
</a>


                                {{-- Edit --}}
                                <a href="{{ route('admin.documents.edit', $document) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Delete --}}
                                <form action="{{ route('admin.documents.destroy', $document) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus dokumen {{ $document->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-danger"
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-file-alt text-muted mb-3" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-2 fw-semibold">Belum ada dokumen</p>
                            <p class="text-muted small">Upload dokumen pertama untuk memulai</p>
                            <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>Upload Dokumen
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($documents->hasPages())
        <div class="card-footer bg-light py-2">
            {{ $documents->links() }}
        </div>
        @endif
    </div>

    <!-- Mobile Cards -->
    <div class="d-md-none">
        @forelse($documents as $document)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body p-3">
                <div class="d-flex gap-2 mb-2">
                    <div class="text-primary flex-shrink-0">
                        <i class="fas fa-file-{{ $document->file_type == 'pdf' ? 'pdf' : 'alt' }}" style="font-size: 2rem;"></i>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-semibold mb-1 small">{{ $document->name }}</h6>
                        <p class="text-muted mb-2 text-truncate" style="font-size: 0.75rem;">{{ basename($document->file_path) }}</p>
                        
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @if($document->category)
                                <span class="badge bg-primary" style="font-size: 0.65rem;">{{ $document->category }}</span>
                            @endif
                            <span class="badge bg-secondary text-uppercase" style="font-size: 0.65rem;">{{ $document->file_type ?? 'FILE' }}</span>
                            <span class="badge bg-success" style="font-size: 0.65rem;">
                                <i class="fas fa-download me-1"></i>{{ $document->downloads }}
                            </span>
                        </div>

                        <p class="text-muted mb-0" style="font-size: 0.7rem;">
                            <i class="fas fa-calendar me-1"></i>{{ $document->created_at->format('d M Y') }}
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-1 pt-2 border-top">
                    <a href="{{ asset('storage/' . $document->file_path) }}"
   target="_blank"
   download
   class="btn btn-sm btn-outline-success flex-grow-1">
    <i class="fas fa-download"></i>
    <span class="d-none d-sm-inline ms-1">Download</span>
</a>


                    <a href="{{ route('admin.documents.edit', $document) }}" 
                       class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('admin.documents.destroy', $document) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus dokumen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-file-alt text-muted mb-3" style="font-size: 2.5rem;"></i>
                <p class="text-muted mb-2 fw-semibold">Belum ada dokumen</p>
                <p class="text-muted small">Upload dokumen pertama untuk memulai</p>
                <a href="{{ route('admin.documents.create') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-plus me-1"></i>Upload Dokumen
                </a>
            </div>
        </div>
        @endforelse

        @if($documents->hasPages())
        <div class="mt-3">
            {{ $documents->links() }}
        </div>
        @endif
    </div>
</div>
@endsection