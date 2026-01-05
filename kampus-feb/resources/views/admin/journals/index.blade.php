@extends('admin.layouts.app')

@section('title', 'Kelola Jurnal Ilmiah')

@push('styles')
<style>
    .journal-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }
    
    .journal-card {
        transition: transform 0.2s, box-shadow 0.2s;
        height: 100%;
    }
    
    .journal-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .stat-card {
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }

    .completeness-bar {
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background-color: #e9ecef;
    }
    
    .completeness-fill {
        height: 100%;
        transition: width 0.3s;
    }

    .badge-accreditation {
        font-size: 0.7rem;
        font-weight: 600;
    }

    .bg-purple {
        background-color: #9333ea !important;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Kelola Jurnal Ilmiah</h1>
            <p class="text-muted mb-0">Manajemen jurnal dan publikasi ilmiah</p>
        </div>
        <a href="{{ route('admin.journals.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Jurnal
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Statistics -->
    @if(isset($stats))
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-primary bg-opacity-10 p-3 rounded">
                                <i class="fas fa-book fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Total Jurnal</div>
                            <div class="h3 fw-bold mb-0">{{ $stats['total'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-success bg-opacity-10 p-3 rounded">
                                <i class="fas fa-eye fa-2x text-success"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Ditampilkan</div>
                            <div class="h3 fw-bold mb-0 text-success">{{ $stats['visible'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-info bg-opacity-10 p-3 rounded">
                                <i class="fas fa-check-circle fa-2x text-info"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Aktif</div>
                            <div class="h3 fw-bold mb-0 text-info">{{ $stats['active'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm stat-card">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="bg-warning bg-opacity-10 p-3 rounded">
                                <i class="fas fa-medal fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Terakreditasi SINTA</div>
                            <div class="h3 fw-bold mb-0 text-warning">{{ $stats['sinta'] ?? 0 }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Search & Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.journals.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama, bidang, ISSN..." 
                               class="form-control">
                    </div>
                    
                    <div class="col-md-3">
                        <select name="manager" class="form-select">
                            <option value="">Semua Pengelola</option>
                            <option value="Fakultas Ekonomi dan Bisnis" {{ request('manager') == 'Fakultas Ekonomi dan Bisnis' ? 'selected' : '' }}>Fakultas Ekonomi dan Bisnis</option>
                            <option value="Prodi Manajemen" {{ request('manager') == 'Prodi Manajemen' ? 'selected' : '' }}>Prodi Manajemen</option>
                            <option value="Prodi Akuntansi" {{ request('manager') == 'Prodi Akuntansi' ? 'selected' : '' }}>Prodi Akuntansi</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="accreditation_status" class="form-select">
                            <option value="">Semua Akreditasi</option>
                            @foreach(\App\Models\Journal::accreditationStatuses() as $key => $label)
                                <option value="{{ $key }}" {{ request('accreditation_status') == $key ? 'selected' : '' }}>
                                    {{ $key }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select name="is_visible" class="form-select">
                            <option value="">Semua Visibility</option>
                            <option value="1" {{ request('is_visible') === '1' ? 'selected' : '' }}>Tampil</option>
                            <option value="0" {{ request('is_visible') === '0' ? 'selected' : '' }}>Tersembunyi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-grow-1">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            
                            @if(request()->hasAny(['search', 'manager', 'accreditation_status', 'is_visible']))
                                <a href="{{ route('admin.journals.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                    <i class="fas fa-redo"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Journals Grid -->
    <div class="row g-4">
        @forelse($journals as $journal)
        <div class="col-md-6 col-lg-4 col-xl-3">
            <div class="card border-0 shadow-sm journal-card">
                <!-- Cover Image -->
                <div class="position-relative">
                    <img src="{{ $journal->cover_url }}" 
                         class="card-img-top journal-cover"
                         alt="{{ $journal->name }}"
                         onerror="this.src='{{ asset('images/default-journal.png') }}'">
                    
                    <!-- Accreditation Badge -->
                    @if($journal->accreditation_status)
                        <span class="badge position-absolute top-0 end-0 m-2 badge-accreditation {{ $journal->accreditation_badge_color }}">
                            {{ $journal->accreditation_status }}
                        </span>
                    @endif

                    <!-- Status Badges -->
                    <div class="position-absolute bottom-0 start-0 m-2 d-flex gap-1">
                        @if($journal->is_visible)
                            <span class="badge bg-success" style="font-size: 0.65rem;">
                                <i class="fas fa-eye me-1"></i>Tampil
                            </span>
                        @else
                            <span class="badge bg-secondary" style="font-size: 0.65rem;">
                                <i class="fas fa-eye-slash me-1"></i>Tersembunyi
                            </span>
                        @endif
                        
                        @if($journal->is_active)
                            <span class="badge bg-info" style="font-size: 0.65rem;">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <!-- Journal Name -->
                    <h5 class="card-title fw-bold mb-2 text-truncate" title="{{ $journal->name }}">
                        {{ $journal->name }}
                    </h5>

                    <!-- Field & Manager -->
                    <div class="mb-2">
                        <div class="small text-muted mb-1 text-truncate" title="{{ $journal->field }}">
                            <i class="fas fa-tag me-1"></i>{{ $journal->field }}
                        </div>
                        <div class="small text-muted text-truncate" title="{{ $journal->manager }}">
                            <i class="fas fa-building me-1"></i>{{ $journal->manager }}
                        </div>
                    </div>

                    <!-- ISSN -->
                    @if($journal->issn || $journal->e_issn)
                    <div class="mb-2 small">
                        @if($journal->issn)
                            <div class="text-muted">
                                <i class="fas fa-barcode me-1"></i>ISSN: {{ $journal->issn }}
                            </div>
                        @endif
                        @if($journal->e_issn)
                            <div class="text-muted">
                                <i class="fas fa-globe me-1"></i>e-ISSN: {{ $journal->e_issn }}
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Completeness -->
                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <div class="completeness-bar flex-grow-1">
                                <div class="completeness-fill {{ $journal->completeness >= 80 ? 'bg-success' : ($journal->completeness >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                     style="width: {{ $journal->completeness }}%">
                                </div>
                            </div>
                            <span class="small text-muted flex-shrink-0">{{ $journal->completeness }}%</span>
                        </div>
                        <small class="text-muted">Kelengkapan Data</small>
                    </div>

                    <!-- Action Buttons -->
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.journals.edit', $journal) }}" 
                           class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        
                        <form action="{{ route('admin.journals.destroy', $journal) }}" 
                              method="POST" 
                              class="flex-grow-1"
                              onsubmit="return confirm('Yakin ingin menghapus jurnal {{ $journal->name }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                                <i class="fas fa-trash me-1"></i>Hapus
                            </button>
                        </form>
                    </div>

                    <!-- Quick Links -->
                    @if($journal->website_url || $journal->submit_url)
                    <div class="mt-2 pt-2 border-top">
                        <div class="d-flex gap-1 flex-wrap">
                            @if($journal->website_url)
                                <a href="{{ $journal->website_url }}" target="_blank" class="btn btn-sm btn-light" title="Website Jurnal">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                            @if($journal->submit_url)
                                <a href="{{ $journal->submit_url }}" target="_blank" class="btn btn-sm btn-light" title="Submit Artikel">
                                    <i class="fas fa-paper-plane"></i>
                                </a>
                            @endif
                            @if($journal->sinta_url)
                                <a href="{{ $journal->sinta_url }}" target="_blank" class="btn btn-sm btn-light" title="SINTA">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-book fa-3x text-muted opacity-25 mb-3"></i>
                    <p class="text-muted mb-3">
                        @if(request()->hasAny(['search', 'manager', 'accreditation_status', 'is_visible']))
                            Tidak ada hasil yang ditemukan
                        @else
                            Belum ada data jurnal
                        @endif
                    </p>
                    @if(!request()->hasAny(['search', 'manager', 'accreditation_status', 'is_visible']))
                        <a href="{{ route('admin.journals.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Tambah Jurnal Pertama
                        </a>
                    @endif
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($journals->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $journals->links() }}
    </div>
    @endif
</div>
@endsection