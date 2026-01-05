@extends('admin.layouts.app')

@section('title', 'Kelola Akreditasi')

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

    .type-badge {
        font-size: 0.7rem;
        padding: 0.3rem 0.6rem;
        font-weight: 600;
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
            <h1 class="h4 fw-bold mb-1">Kelola Akreditasi</h1>
            <p class="text-muted small mb-0">Manajemen akreditasi perguruan tinggi dan program studi</p>
        </div>
        <a href="{{ route('admin.accreditations.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Akreditasi
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Main Statistics -->
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total</p>
                            <h3 class="h5 fw-bold mb-0">{{ $stats['total'] }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-certificate text-primary" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Berakhir</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $stats['expiring'] }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-exclamation-triangle text-warning" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Kadaluarsa</p>
                            <h3 class="h5 fw-bold mb-0 text-danger">{{ $stats['expired'] }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-times-circle text-danger" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Type Statistics -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <h6 class="fw-bold mb-3 small">Statistik Berdasarkan Tipe</h6>
            <div class="row g-2">
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-university text-info small"></i>
                        </div>
                        <div class="min-w-0">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Akreditasi PT</small>
                            <span class="fw-bold small">{{ $stats['pt'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-secondary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-history text-secondary small"></i>
                        </div>
                        <div class="min-w-0">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">PT Terdahulu</small>
                            <span class="fw-bold small">{{ $stats['pt_old'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-graduation-cap text-success small"></i>
                        </div>
                        <div class="min-w-0">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Akreditasi Prodi</small>
                            <span class="fw-bold small">{{ $stats['prodi'] }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-archive text-warning small"></i>
                        </div>
                        <div class="min-w-0">
                            <small class="text-muted d-block" style="font-size: 0.7rem;">Riwayat Prodi</small>
                            <span class="fw-bold small">{{ $stats['prodi_old'] }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body p-3">
            <form method="GET" action="{{ route('admin.accreditations.index') }}">
                <div class="row g-2">
                    <div class="col-md-3">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari program studi..." class="form-control form-control-sm">
                    </div>
                    
                    <div class="col-6 col-md-2">
                        <select name="type" class="form-select form-select-sm">
                            <option value="">Semua Tipe</option>
                            @foreach(App\Models\Accreditation::types() as $key => $label)
                                <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                                    {{ Str::limit($label, 20) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($categories->count() > 0)
                    <div class="col-6 col-md-2">
                        <select name="category" class="form-select form-select-sm">
                            <option value="">Semua Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                                    {{ $category }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    @endif

                    <div class="col-6 col-md-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="expiring" {{ request('status') == 'expiring' ? 'selected' : '' }}>Berakhir</option>
                            <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Kadaluarsa</option>
                        </select>
                    </div>

                    <div class="col-6 col-md-1">
                        <select name="grade" class="form-select form-select-sm">
                            <option value="">Grade</option>
                            @foreach(App\Models\Accreditation::grades() as $key => $label)
                                <option value="{{ $key }}" {{ request('grade') == $key ? 'selected' : '' }}>{{ $key }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-12 col-md-2">
                        <div class="d-flex gap-1">
                            <button type="submit" class="btn btn-dark btn-sm flex-grow-1">
                                <i class="fas fa-search"></i><span class="d-none d-sm-inline ms-1">Cari</span>
                            </button>
                            @if(request()->hasAny(['search', 'type', 'category', 'status', 'grade']))
                                <a href="{{ route('admin.accreditations.index') }}" class="btn btn-outline-secondary btn-sm" title="Reset">
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
                        <th class="px-3 py-2 fw-semibold text-muted small">PROGRAM STUDI</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">GRADE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small d-none d-lg-table-cell">LEMBAGA</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">BERLAKU</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">STATUS</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accreditations as $accreditation)
                    <tr>
                        <td class="px-3 py-2">
                            <span class="badge type-badge {{ 
                                $accreditation->type == 'perguruan_tinggi' ? 'bg-info' : 
                                ($accreditation->type == 'perguruan_tinggi_old' ? 'bg-secondary' : 
                                ($accreditation->type == 'program_studi' ? 'bg-success' : 'bg-warning'))
                            }}">
                                {{ Str::limit($accreditation->type_label, 12) }}
                            </span>
                            @if($accreditation->category)
                                <span class="badge bg-light text-dark type-badge d-block mt-1">{{ $accreditation->category }}</span>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                                    <i class="fas {{ $accreditation->type == 'perguruan_tinggi' || $accreditation->type == 'perguruan_tinggi_old' ? 'fa-university' : 'fa-graduation-cap' }} text-primary small"></i>
                                </div>
                                <div class="min-w-0">
                                    <p class="fw-semibold mb-0 small text-truncate">{{ $accreditation->study_program }}</p>
                                    @if($accreditation->certificate_number)
                                        <small class="text-muted" style="font-size: 0.7rem;">{{ Str::limit($accreditation->certificate_number, 20) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>

                        <td class="px-3 py-2">
                            <span class="badge {{ $accreditation->grade_badge_color }} rounded-pill">
                                {{ $accreditation->grade }}
                            </span>
                        </td>

                        <td class="px-3 py-2 d-none d-lg-table-cell">
                            <span class="text-muted small">{{ $accreditation->accreditation_body }}</span>
                        </td>

                        <td class="px-3 py-2">
                            <p class="fw-semibold mb-0 small">{{ $accreditation->valid_until->format('d M Y') }}</p>
                            @if(!$accreditation->isExpired())
                                <small class="text-muted" style="font-size: 0.7rem;">{{ $accreditation->remaining_days }} hari</small>
                            @endif
                        </td>

                        <td class="px-3 py-2">
                            <span class="badge {{ $accreditation->status_badge_color }} rounded-pill type-badge">
                                <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                                {{ $accreditation->status_label }}
                            </span>
                        </td>

                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                @if($accreditation->certificate_file)
                                <a href="{{ route('admin.accreditations.download', $accreditation) }}" 
                                   class="btn btn-sm btn-outline-primary" title="Download">
                                    <i class="fas fa-download"></i>
                                </a>
                                @endif

                                <a href="{{ route('admin.accreditations.edit', $accreditation) }}" 
                                   class="btn btn-sm btn-outline-warning" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.accreditations.destroy', $accreditation) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus?')">
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
                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                            <p class="text-muted mb-0">Tidak ada data akreditasi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($accreditations->hasPages())
        <div class="card-footer bg-light py-2">
            {{ $accreditations->links() }}
        </div>
        @endif
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($accreditations as $accreditation)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body p-3">
                <!-- Type Badge -->
                <div class="mb-2">
                    <span class="badge type-badge {{ 
                        $accreditation->type == 'perguruan_tinggi' ? 'bg-info' : 
                        ($accreditation->type == 'perguruan_tinggi_old' ? 'bg-secondary' : 
                        ($accreditation->type == 'program_studi' ? 'bg-success' : 'bg-warning'))
                    }}">
                        {{ $accreditation->type_label }}
                    </span>
                    @if($accreditation->category)
                        <span class="badge bg-light text-dark type-badge">{{ $accreditation->category }}</span>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-start mb-2">
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-bold mb-1 small">{{ $accreditation->study_program }}</h6>
                        @if($accreditation->certificate_number)
                            <small class="text-muted d-block" style="font-size: 0.7rem;">{{ $accreditation->certificate_number }}</small>
                        @endif
                    </div>
                    <span class="badge {{ $accreditation->grade_badge_color }} rounded-pill ms-2 flex-shrink-0">
                        {{ $accreditation->grade }}
                    </span>
                </div>

                <div class="row g-2 mb-2">
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Lembaga</small>
                        <span class="small fw-medium">{{ $accreditation->accreditation_body }}</span>
                    </div>
                    <div class="col-6">
                        <small class="text-muted d-block" style="font-size: 0.7rem;">Berlaku Sampai</small>
                        <span class="small fw-medium">{{ $accreditation->valid_until->format('d M Y') }}</span>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                    <span class="badge {{ $accreditation->status_badge_color }} rounded-pill type-badge">
                        <i class="fas fa-circle" style="font-size: 0.4rem;"></i>
                        {{ $accreditation->status_label }}
                    </span>

                    <div class="d-flex gap-1">
                        @if($accreditation->certificate_file)
                        <a href="{{ route('admin.accreditations.download', $accreditation) }}" 
                           class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-download"></i>
                        </a>
                        @endif

                        <a href="{{ route('admin.accreditations.edit', $accreditation) }}" 
                           class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <form action="{{ route('admin.accreditations.destroy', $accreditation) }}" 
                              method="POST" class="d-inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
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
                <i class="fas fa-inbox text-muted mb-3" style="font-size: 2rem;"></i>
                <p class="text-muted mb-0">Tidak ada data akreditasi</p>
            </div>
        </div>
        @endforelse

        @if($accreditations->hasPages())
        <div class="mt-3">
            {{ $accreditations->links() }}
        </div>
        @endif
    </div>
</div>
@endsection