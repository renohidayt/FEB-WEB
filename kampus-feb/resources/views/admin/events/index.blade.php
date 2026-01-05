@extends('admin.layouts.app')

@section('title', 'Kelola Events')

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

    .event-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .event-card:hover {
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
            <h1 class="h4 fw-bold mb-1">Kelola Events</h1>
            <p class="text-muted small mb-0">Manajemen event dan agenda Fakultas</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Buat Event Baru
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Events</p>
                            <h3 class="h5 fw-bold mb-0">{{ $events->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-calendar-check text-primary" style="font-size: 1.25rem;"></i>
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
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $events->where('status', 'published')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-eye text-success" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Draft</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $events->where('status', 'draft')->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-file-alt text-warning" style="font-size: 1.25rem;"></i>
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
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $events->whereBetween('start_date', [now()->startOfMonth(), now()->endOfMonth()])->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-calendar-day text-info" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3"> 
            <form method="GET" action="{{ route('admin.events.index') }}">
                <div class="row g-2">
                    <div class="col-md-4">
                        <input type="text" name="search" class="form-control form-control-sm" 
                               placeholder="Cari event..." 
                               value="{{ request('search') }}">
                    </div>
                    <div class="col-6 col-md-3">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-6 col-md-3">
                        <select name="sort" class="form-select form-select-sm">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="upcoming" {{ request('sort') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-dark btn-sm flex-grow-1">
                                <i class="fas fa-search"></i><span class="d-none d-sm-inline ms-1">Cari</span>
                            </button>
                            @if(request()->hasAny(['search', 'status', 'sort']))
                                <a href="{{ route('admin.events.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
                                    <i class="fas fa-redo"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Events Grid -->
    @forelse($events as $event)
        @if($loop->first)
            <div class="row g-3 mb-3">
        @endif
        
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm event-card">
                <!-- Event Image -->
                <div class="position-relative">
                    @if($event->poster)
                        <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" 
                             class="card-img-top" style="height:180px;object-fit:cover">
                    @else
                        <div class="card-img-top d-flex align-items-center justify-content-center" 
                             style="height:180px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%)">
                            <i class="fas fa-calendar-alt text-white" style="font-size:2.5rem"></i>
                        </div>
                    @endif
                    
                    <span class="badge position-absolute top-0 end-0 m-2 {{ $event->status === 'published' ? 'bg-success' : 'bg-secondary' }}" style="font-size: 0.7rem;">
                        {{ $event->status === 'published' ? 'Published' : 'Draft' }}
                    </span>
                </div>

                <div class="card-body p-3">
                    <h5 class="card-title fw-bold mb-2 small text-truncate" title="{{ $event->title }}">
                        {{ Str::limit($event->title, 50) }}
                    </h5>
                    
                    <div class="mb-2">
                        <div class="d-flex align-items-center text-muted mb-1" style="font-size: 0.75rem;">
                            <i class="fas fa-calendar text-primary me-2 flex-shrink-0"></i>
                            <span class="text-truncate">{{ $event->formatted_date }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted mb-1" style="font-size: 0.75rem;">
                            <i class="fas fa-clock text-info me-2 flex-shrink-0"></i>
                            <span class="text-truncate">{{ $event->formatted_time }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted mb-1" style="font-size: 0.75rem;">
                            <i class="fas fa-map-marker-alt text-danger me-2 flex-shrink-0"></i>
                            <span class="text-truncate">{{ Str::limit($event->location, 35) }}</span>
                        </div>
                        <div class="d-flex align-items-center text-muted" style="font-size: 0.75rem;">
                            <i class="fas fa-users text-success me-2 flex-shrink-0"></i>
                            <span class="text-truncate">{{ $event->organizer }}</span>
                        </div>
                    </div>

                    @if($event->isOngoing())
                        <span class="badge bg-primary mb-2" style="font-size: 0.7rem;">
                            <i class="fas fa-circle-notch fa-spin me-1"></i>Sedang Berlangsung
                        </span>
                    @elseif($event->start_date > now())
                        <span class="badge bg-warning text-dark mb-2" style="font-size: 0.7rem;">
                            <i class="fas fa-clock me-1"></i>Akan Datang
                        </span>
                    @else
                        <span class="badge bg-secondary mb-2" style="font-size: 0.7rem;">
                            <i class="fas fa-check me-1"></i>Sudah Selesai
                        </span>
                    @endif
                </div>

                <div class="card-footer bg-transparent border-0 p-3 pt-0">
                    <div class="d-flex gap-1">
                        <a href="{{ route('admin.events.show', $event) }}" class="btn btn-sm btn-outline-info flex-grow-1">
                            <i class="fas fa-eye"></i><span class="d-none d-md-inline ms-1">Detail</span>
                        </a>
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus event {{ $event->title }}?')">
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

        @if($loop->last)
            </div>
        @endif
    @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-calendar-times text-muted mb-3" style="font-size:3rem"></i>
                <h5 class="text-muted mb-3">Belum Ada Event</h5>
                <p class="text-muted mb-4 small">Mulai buat event pertama Anda sekarang!</p>
                <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus me-2"></i>Buat Event Pertama
                </a>
            </div>
        </div>
    @endforelse

    <!-- Pagination -->
    @if($events->hasPages())
        <div class="mt-3">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection