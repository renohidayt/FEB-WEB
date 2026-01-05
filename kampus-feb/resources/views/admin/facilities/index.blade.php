@extends('admin.layouts.app')

@section('title', 'Kelola Fasilitas')

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

    .facility-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .facility-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
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
            <h1 class="h4 fw-bold mb-1">Kelola Fasilitas</h1>
            <p class="text-muted small mb-0">Manajemen fasilitas kampus</p>
        </div>
        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Fasilitas
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Fasilitas</p>
                            <h3 class="h5 fw-bold mb-0">{{ $facilities->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-building text-primary" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Aktif</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $facilities->where('is_active', true)->count() }}</h3>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Nonaktif</p>
                            <h3 class="h5 fw-bold mb-0 text-secondary">{{ $facilities->where('is_active', false)->count() }}</h3>
                        </div>
                        <div class="bg-secondary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-eye-slash text-secondary" style="font-size: 1.25rem;"></i>
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
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $facilities->sum('photos_count') }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-images text-info" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Kategori -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.facilities.index') }}" 
                   class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    <i class="fas fa-th me-1"></i>Semua
                </a>
                @foreach(App\Models\Facility::categories() as $key => $label)
                    <a href="{{ route('admin.facilities.index', ['category' => $key]) }}" 
                       class="btn btn-sm {{ request('category') === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Grid Fasilitas -->
    <div class="row g-3">
        @forelse($facilities as $facility)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm facility-card">
                <!-- Foto -->
                <div class="position-relative" style="height: 180px; background: #f0f0f0;">
                    @if($facility->photos->count() > 0)
                        <img src="{{ asset('storage/' . $facility->photos->first()->photo) }}" 
                             class="w-100 h-100" 
                             style="object-fit: cover;">
                        @if($facility->photos->count() > 1)
                            <span class="position-absolute top-0 end-0 m-2 badge bg-dark bg-opacity-75" style="font-size: 0.7rem;">
                                <i class="fas fa-images me-1"></i>+{{ $facility->photos->count() - 1 }} foto
                            </span>
                        @endif
                    @else
                        <div class="d-flex align-items-center justify-content-center h-100">
                            <i class="fas fa-image text-muted opacity-25" style="font-size: 2.5rem;"></i>
                        </div>
                    @endif
                    
                    <!-- Badge Status -->
                    <span class="position-absolute top-0 start-0 m-2 badge {{ $facility->is_active ? 'bg-success' : 'bg-secondary' }}" style="font-size: 0.7rem;">
                        {{ $facility->is_active ? 'Aktif' : 'Nonaktif' }}
                    </span>
                </div>

                <!-- Content -->
                <div class="card-body p-3">
                    <h5 class="card-title fw-bold mb-2 small">{{ $facility->name }}</h5>
                    
                    <div class="mb-2" style="font-size: 0.75rem;">
                        @if($facility->category)
                            <div class="mb-1 text-muted">
                                <i class="fas fa-tag me-1"></i>{{ $facility->category }}
                            </div>
                        @endif
                        
                        @if($facility->capacity)
                            <div class="mb-1 text-muted">
                                <i class="fas fa-users me-1"></i>{{ $facility->capacity }}
                            </div>
                        @endif

                        <div class="text-muted">
                            <i class="fas fa-images me-1"></i>{{ $facility->photos_count }} foto
                        </div>
                    </div>

                    @if($facility->description)
                        <p class="card-text text-muted mb-0" 
                           style="font-size: 0.75rem; 
                                  display: -webkit-box;
                                  -webkit-line-clamp: 2;
                                  -webkit-box-orient: vertical;
                                  overflow: hidden;">
                            {{ $facility->description }}
                        </p>
                    @endif
                </div>

                <!-- Actions -->
                <div class="card-footer bg-white border-top p-2">
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.facilities.edit', $facility) }}" 
                           class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="fas fa-edit"></i><span class="d-none d-md-inline ms-1">Edit</span>
                        </a>
                        <form action="{{ route('admin.facilities.destroy', $facility) }}" 
                              method="POST" 
                              class="flex-grow-1"
                              onsubmit="return confirm('Yakin hapus fasilitas beserta {{ $facility->photos_count }} foto?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                <i class="fas fa-trash"></i><span class="d-none d-md-inline ms-1">Hapus</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-building text-muted opacity-25 mb-3" style="font-size: 3rem;"></i>
                    <h5 class="text-muted mb-3">
                        @if(request('category'))
                            Belum ada fasilitas di kategori ini
                        @else
                            Belum ada fasilitas
                        @endif
                    </h5>
                    @if(!request('category'))
                        <a href="{{ route('admin.facilities.create') }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Tambah Fasilitas Pertama
                        </a>
                    @else
                        <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-th me-2"></i>Lihat Semua Fasilitas
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($facilities->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $facilities->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection