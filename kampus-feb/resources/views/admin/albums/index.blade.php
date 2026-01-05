@extends('admin.layouts.app')

@section('title', 'Kelola Album')

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

    .album-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .album-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }

    .border-purple { border-color: #6f42c1 !important; }
    .bg-purple { background-color: #6f42c1 !important; }
    .text-purple { color: #6f42c1 !important; }

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
            <h1 class="h4 fw-bold mb-1">Kelola Album</h1>
            <p class="text-muted small mb-0">Manajemen album foto dan video kampus</p>
        </div>
        <a href="{{ route('admin.albums.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Album
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Album</p>
                            <h3 class="h5 fw-bold mb-0">{{ $albums->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-folder text-primary" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Published</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $albums->where('is_published', true)->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-check-circle text-success" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Foto</p>
                            <h3 class="h5 fw-bold mb-0 text-purple">{{ $albums->sum('photos_count') }}</h3>
                        </div>
                        <div class="bg-purple bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-image text-purple" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Video</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $albums->sum('videos_count') }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-video text-warning" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.albums.index') }}">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Cari album..." 
                               value="{{ request('search') }}">
                    </div>
                    
                    <div class="col-md-4">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-dark btn-sm flex-grow-1">
                                <i class="fas fa-search"></i><span class="d-none d-sm-inline ms-1">Cari</span>
                            </button>
                            @if(request()->hasAny(['search', 'status']))
                                <a href="{{ route('admin.albums.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
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
                        <th class="px-3 py-2 fw-semibold text-muted small">COVER</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">ALBUM</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">TANGGAL</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">MEDIA</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">STATUS</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($albums as $album)
                    <tr>
                        <td class="px-3 py-2">
                            <img src="{{ $album->cover_url }}" 
                                 alt="{{ $album->name }}" 
                                 class="rounded" 
                                 style="width: 60px; height: 60px; object-fit: cover;">
                        </td>

                        <td class="px-3 py-2">
                            <div class="fw-semibold small">{{ $album->name }}</div>
                            @if($album->description)
                                <small class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($album->description, 60) }}</small>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            @if($album->date)
                                <div class="small">{{ $album->date->format('d M Y') }}</div>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $album->date->diffForHumans() }}</small>
                            @else
                                <span class="text-muted small">-</span>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <span class="badge bg-purple me-1" style="font-size: 0.7rem;">
                                <i class="fas fa-image me-1"></i>{{ $album->photos_count }}
                            </span>
                            <span class="badge bg-warning" style="font-size: 0.7rem;">
                                <i class="fas fa-video me-1"></i>{{ $album->videos_count }}
                            </span>
                        </td>

                        <td class="px-3 py-2 text-center">
                            @if($album->is_published)
                                <span class="badge bg-success" style="font-size: 0.7rem;">Published</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.7rem;">Draft</span>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                {{-- Manage Media --}}
                                <a href="{{ route('admin.albums.media.index', $album) }}" 
                                   class="btn btn-sm btn-outline-success" 
                                   title="Kelola Media">
                                    <i class="fas fa-folder-open"></i>
                                </a>

                                {{-- Edit --}}
                                <a href="{{ route('admin.albums.edit', $album) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                {{-- Toggle Publish --}}
                                <form action="{{ route('admin.albums.toggle-publish', $album) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin {{ $album->is_published ? 'unpublish' : 'publish' }} album ini?')">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="btn btn-sm btn-outline-{{ $album->is_published ? 'secondary' : 'info' }}"
                                            title="{{ $album->is_published ? 'Unpublish' : 'Publish' }}">
                                        <i class="fas fa-{{ $album->is_published ? 'eye-slash' : 'eye' }}"></i>
                                    </button>
                                </form>

                                {{-- Delete --}}
                                <form action="{{ route('admin.albums.destroy', $album) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin menghapus album {{ $album->name }}? Semua media ({{ $album->photos_count + $album->videos_count }}) akan ikut terhapus!')">
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
                            <i class="fas fa-folder-open text-muted mb-3" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-2 fw-semibold">Belum ada album</p>
                            <p class="text-muted small">Silakan tambahkan album baru untuk memulai</p>
                            <a href="{{ route('admin.albums.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>Tambah Album
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($albums->hasPages())
        <div class="card-footer bg-light py-2">
            {{ $albums->links() }}
        </div>
        @endif
    </div>

    <!-- Mobile Cards -->
    <div class="d-md-none">
        @forelse($albums as $album)
        <div class="card border-0 shadow-sm mb-2 album-card">
            <img src="{{ $album->cover_url }}" 
                 class="card-img-top" 
                 alt="{{ $album->name }}" 
                 style="height: 160px; object-fit: cover;">
            
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="card-title mb-0 fw-bold small">{{ $album->name }}</h6>
                    @if($album->is_published)
                        <span class="badge bg-success" style="font-size: 0.7rem;">Published</span>
                    @else
                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Draft</span>
                    @endif
                </div>
                
                @if($album->description)
                    <p class="card-text text-muted mb-2" style="font-size: 0.75rem;">{{ Str::limit($album->description, 80) }}</p>
                @endif

                @if($album->date)
                <p class="text-muted mb-2" style="font-size: 0.7rem;">
                    <i class="fas fa-calendar-alt me-1"></i>{{ $album->date->format('d M Y') }}
                </p>
                @endif

                <div class="mb-2">
                    <span class="badge bg-purple me-1" style="font-size: 0.7rem;">
                        <i class="fas fa-image me-1"></i>{{ $album->photos_count }}
                    </span>
                    <span class="badge bg-warning" style="font-size: 0.7rem;">
                        <i class="fas fa-video me-1"></i>{{ $album->videos_count }}
                    </span>
                </div>

                <div class="d-flex gap-1">
                    <a href="{{ route('admin.albums.media.index', $album) }}" 
                       class="btn btn-sm btn-outline-success flex-grow-1">
                        <i class="fas fa-folder-open"></i>
                    </a>

                    <a href="{{ route('admin.albums.edit', $album) }}" 
                       class="btn btn-sm btn-outline-warning">
                        <i class="fas fa-edit"></i>
                    </a>

                    <form action="{{ route('admin.albums.toggle-publish', $album) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin {{ $album->is_published ? 'unpublish' : 'publish' }}?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="btn btn-sm btn-outline-{{ $album->is_published ? 'secondary' : 'info' }}">
                            <i class="fas fa-{{ $album->is_published ? 'eye-slash' : 'eye' }}"></i>
                        </button>
                    </form>

                    <form action="{{ route('admin.albums.destroy', $album) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus album + {{ $album->photos_count + $album->videos_count }} media?')">
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
                <i class="fas fa-folder-open text-muted mb-3" style="font-size: 2.5rem;"></i>
                <p class="text-muted mb-2 fw-semibold">Belum ada album</p>
                <p class="text-muted small">Silakan tambahkan album baru untuk memulai</p>
                <a href="{{ route('admin.albums.create') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-plus me-1"></i>Tambah Album
                </a>
            </div>
        </div>
        @endforelse

        @if($albums->hasPages())
        <div class="mt-3">
            {{ $albums->links() }}
        </div>
        @endif
    </div>
</div>
@endsection