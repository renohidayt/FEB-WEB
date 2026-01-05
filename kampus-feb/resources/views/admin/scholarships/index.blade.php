@extends('admin.layouts.app')

@section('title', 'Kelola Beasiswa')

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

    .scholarship-card {
        transition: all 0.2s;
    }

    .scholarship-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
    }

    .poster-img {
        height: 200px;
        object-fit: cover;
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
    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Info Beasiswa</h1>
            <p class="text-muted small mb-0">Kelola informasi beasiswa untuk mahasiswa</p>
        </div>
        <a href="{{ route('admin.scholarships.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Beasiswa
        </a>
    </div>

    {{-- SUCCESS/ERROR MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATS CARDS --}}
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Beasiswa</p>
                            <h3 class="h5 fw-bold mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-graduation-cap text-primary" style="font-size: 1.25rem;"></i>
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
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $stats['active'] }}</h3>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Dibuka</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $stats['open'] }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-door-open text-info" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Featured</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $stats['featured'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-star text-warning" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTER --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body p-3">
            <div class="d-flex flex-wrap gap-2">
                <a href="{{ route('admin.scholarships.index') }}" 
                   class="btn btn-sm {{ !request('category') && !request('status') ? 'btn-primary' : 'btn-outline-secondary' }}">
                    Semua
                </a>
                
                @foreach(\App\Models\Scholarship::categories() as $key => $label)
                    <a href="{{ route('admin.scholarships.index', ['category' => $key]) }}" 
                       class="btn btn-sm {{ request('category') === $key ? 'btn-primary' : 'btn-outline-secondary' }}">
                        {{ $label }}
                    </a>
                @endforeach

                <div class="vr mx-2 d-none d-md-block"></div>

                <a href="{{ route('admin.scholarships.index', ['status' => 'open']) }}" 
                   class="btn btn-sm {{ request('status') === 'open' ? 'btn-success' : 'btn-outline-success' }}">
                    Dibuka
                </a>
                <a href="{{ route('admin.scholarships.index', ['status' => 'closed']) }}" 
                   class="btn btn-sm {{ request('status') === 'closed' ? 'btn-danger' : 'btn-outline-danger' }}">
                    Ditutup
                </a>
            </div>
        </div>
    </div>

    {{-- GRID CARDS --}}
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
        @forelse($scholarships as $item)
            <div class="col">
                <div class="card border-0 shadow-sm scholarship-card h-100">
                    {{-- Poster --}}
                    <div class="position-relative">
                        @if($item->poster)
                            <img src="{{ asset('storage/' . $item->poster) }}" 
                                 class="card-img-top poster-img"
                                 alt="{{ $item->name }}">
                        @else
                            <div class="card-img-top poster-img bg-gradient-primary d-flex align-items-center justify-content-center">
                                <i class="fas fa-graduation-cap text-white" style="font-size: 4rem; opacity: 0.5;"></i>
                            </div>
                        @endif

                        {{-- Status Badge --}}
                        <div class="position-absolute top-0 end-0 m-2">
                            {!! $item->getStatusBadge() !!}
                        </div>

                        {{-- Featured Badge --}}
                        @if($item->is_featured)
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">⭐ Featured</span>
                            </div>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="card-body p-3">
                        {{-- Category --}}
                        <div class="mb-2">
                            <span class="badge {{ $item->getCategoryBadgeColor() }}" style="font-size: 0.65rem;">
                                {{ \App\Models\Scholarship::categories()[$item->category] }}
                            </span>
                        </div>

                        {{-- Title --}}
                        <h6 class="fw-bold mb-2" style="font-size: 0.95rem; line-height: 1.3;">{{ Str::limit($item->name, 60) }}</h6>

                        {{-- Info --}}
                        <div class="small text-muted mb-3" style="font-size: 0.8rem;">
                            @if($item->provider)
                                <div class="d-flex align-items-center mb-1">
                                    <i class="fas fa-building me-2" style="width: 14px;"></i>
                                    <span class="text-truncate">{{ Str::limit($item->provider, 30) }}</span>
                                </div>
                            @endif

                            <div class="d-flex align-items-center mb-1 text-success fw-semibold">
                                <i class="fas fa-money-bill-wave me-2" style="width: 14px;"></i>
                                {{ $item->getFormattedAmount() }}
                            </div>

                            @if($item->registration_end)
                                <div class="d-flex align-items-center mb-1 {{ $item->getRegistrationStatus() === 'open' ? 'text-danger' : '' }}">
                                    <i class="fas fa-calendar me-2" style="width: 14px;"></i>
                                    <span>Deadline: {{ $item->registration_end->format('d M Y') }}</span>
                                </div>
                                @if($item->getRemainingDays())
                                    <div class="ps-4 text-danger" style="font-size: 0.75rem;">
                                        <i class="fas fa-clock me-1"></i> {{ $item->getRemainingDays() }} hari lagi
                                    </div>
                                @endif
                            @endif

                            @if($item->quota)
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-users me-2" style="width: 14px;"></i>
                                    Kuota: {{ $item->quota }} orang
                                </div>
                            @endif
                        </div>

                        {{-- Actions --}}
                        <div class="d-flex gap-1 pt-2 border-top">
                            <a href="{{ route('admin.scholarships.show', $item) }}" 
                               class="btn btn-sm btn-outline-info flex-fill" 
                               style="font-size: 0.75rem;">
                                <i class="fas fa-eye"></i><span class="d-none d-sm-inline ms-1">Detail</span>
                            </a>
                            <a href="{{ route('admin.scholarships.edit', $item) }}" 
                               class="btn btn-sm btn-outline-warning flex-fill"
                               style="font-size: 0.75rem;">
                                <i class="fas fa-edit"></i><span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            <form action="{{ route('admin.scholarships.destroy', $item) }}" 
                                  method="POST" 
                                  class="d-inline"
                                  onsubmit="return confirm('Yakin ingin menghapus beasiswa {{ $item->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="btn btn-sm btn-outline-danger"
                                        style="font-size: 0.75rem;">
                                    <i class="fas fa-trash"></i>
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
                        <i class="fas fa-graduation-cap text-muted mb-3" style="font-size: 3rem;"></i>
                        <p class="text-muted mb-2 fw-semibold">Belum ada info beasiswa</p>
                        <p class="text-muted small">Tambah beasiswa pertama untuk memulai</p>
                        <a href="{{ route('admin.scholarships.create') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="fas fa-plus me-1"></i>Tambah Beasiswa
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    @if($scholarships->hasPages())
        <div class="mt-4">
            {{ $scholarships->links() }}
        </div>
    @endif
</div>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #0d6efd 0%, #6610f2 100%);
}
</style>
@endsection