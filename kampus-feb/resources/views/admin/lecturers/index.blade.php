@extends('admin.layouts.app')

@section('title', 'Kelola Dosen')

@push('styles')
<style>
    .lecturer-photo {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
        flex-shrink: 0; /* Prevent shrinking */
    }
    
    .stat-card {
        transition: transform 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
    }
    
    .table-actions {
        white-space: nowrap;
    }
    
    .completeness-bar {
        height: 6px;
        border-radius: 3px;
        overflow: hidden;
        background-color: #e9ecef;
        min-width: 60px; /* Ensure minimum width */
    }
    
    .completeness-fill {
        height: 100%;
        transition: width 0.3s;
    }

    /* Table responsiveness fixes */
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        min-width: 900px; /* Reduced from 1000px untuk fit dengan sidebar */
        width: 100%;
    }

    .table td {
        white-space: nowrap; /* Changed from normal to prevent wrapping */
        vertical-align: middle;
    }

    /* Specific column width controls - More compact */
    .table th:nth-child(1),
    .table td:nth-child(1) { width: 60px; } /* Photo - reduced */
    
    .table th:nth-child(2),
    .table td:nth-child(2) { min-width: 160px; max-width: 180px; } /* Nama & Info - controlled */
    
    .table th:nth-child(3),
    .table td:nth-child(3) { min-width: 120px; max-width: 140px; } /* Jabatan - controlled */
    
    .table th:nth-child(4),
    .table td:nth-child(4) { width: 110px; } /* Program Studi - reduced */
    
    .table th:nth-child(5),
    .table td:nth-child(5) { min-width: 140px; max-width: 160px; } /* Kontak - controlled */
    
    .table th:nth-child(6),
    .table td:nth-child(6) { width: 100px; } /* Kelengkapan - reduced */
    
    .table th:nth-child(7),
    .table td:nth-child(7) { width: 90px; } /* Status - reduced */
    
    .table th:nth-child(8),
    .table td:nth-child(8) { width: 90px; text-align: center; } /* Aksi - reduced */

    /* Badge wrapping fix */
    .badge-wrapper {
        display: flex;
        flex-wrap: wrap;
        gap: 0.25rem;
    }
    
    @media (max-width: 768px) {
        .mobile-card {
            border-left: 4px solid #0d6efd;
        }
        
        .mobile-card.hidden {
            border-left-color: #6c757d;
        }

        /* Mobile photo fix */
        .lecturer-photo {
            width: 56px;
            height: 56px;
        }
    }

    /* Ensure text doesn't overflow badges */
    .badge {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Kelola Dosen</h1>
            <p class="text-muted mb-0">Manajemen data dosen dan tenaga pengajar</p>
        </div>
        <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Dosen
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
                                <i class="fas fa-users fa-2x text-primary"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Total Dosen</div>
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
                                <i class="fas fa-user-check fa-2x text-info"></i>
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
                                <i class="fas fa-user-tie fa-2x text-warning"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <div class="text-muted small mb-1">Dosen Tetap</div>
                            <div class="h3 fw-bold mb-0 text-warning">{{ $stats['tetap'] ?? 0 }}</div>
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
            <form method="GET" action="{{ route('admin.lecturers.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="Cari nama, NIDN, email..." 
                               class="form-control">
                    </div>
                    
                    <div class="col-md-2">
                        <select name="study_program" class="form-select">
                            <option value="">Semua Prodi</option>
                            <option value="Manajemen" {{ request('study_program') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                            <option value="Akutansi" {{ request('study_program') == 'Akutansi' ? 'selected' : '' }}>Akutansi</option>
                            <option value="Magister Manajemen" {{ request('study_program') == 'Magister Manajemen' ? 'selected' : '' }}>Magister Manajemen</option>
                        </select>
                    </div>

                    <div class="col-md-2">
                        <select name="employment_status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="Tetap" {{ request('employment_status') == 'Tetap' ? 'selected' : '' }}>Dosen Tetap</option>
                            <option value="Tidak Tetap" {{ request('employment_status') == 'Tidak Tetap' ? 'selected' : '' }}>Tidak Tetap</option>
                        </select>
                    </div>
                    
                    <div class="col-md-2">
                        <select name="is_visible" class="form-select">
                            <option value="">Semua Visibility</option>
                            <option value="1" {{ request('is_visible') === '1' ? 'selected' : '' }}>Tampil</option>
                            <option value="0" {{ request('is_visible') === '0' ? 'selected' : '' }}>Tersembunyi</option>
                        </select>
                    </div>
                    
                    <div class="col-md-3">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-dark flex-grow-1">
                                <i class="fas fa-search me-2"></i>Cari
                            </button>
                            
                            @if(request()->hasAny(['search', 'study_program', 'employment_status', 'is_visible']))
                                <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline-secondary" title="Reset Filter">
                                    <i class="fas fa-redo"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Desktop Table View -->
    <div class="card border-0 shadow-sm d-none d-md-block">
        <div class="card-body p-0">
            {{-- Scroll hint for small desktop screens --}}
            <div class="alert alert-info alert-dismissible fade show m-3 mb-0 d-xl-none" role="alert" style="font-size: 0.85rem;">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Info:</strong> Geser tabel ke kanan untuk melihat kolom lainnya
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Foto</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Nama & Info</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Jabatan</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Program Studi</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Kontak</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Kelengkapan</th>
                            <th class="px-3 py-3" style="font-size: 0.85rem;">Status</th>
                            <th class="px-3 py-3 text-center" style="font-size: 0.85rem;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lecturers as $lecturer)
                        <tr>
                            <td class="px-3 py-3">
                                <img src="{{ $lecturer->photo_url }}" 
                                     class="rounded-circle lecturer-photo"
                                     alt="{{ $lecturer->name }}"
                                     onerror="this.src='{{ asset('images/default-lecturer.png') }}'">
                            </td>
                            <td class="px-3 py-3">
                                <div class="fw-semibold text-truncate" style="max-width: 130px;" title="{{ $lecturer->name }}">
                                    {{ $lecturer->name }}
                                </div>
                                <div class="text-muted small text-truncate" style="max-width: 130px;">NIDN: {{ $lecturer->nidn }}</div>
                                <div class="badge-wrapper mt-1">
                                    @if($lecturer->academic_degree)
                                        <span class="badge bg-purple-subtle text-purple" style="background-color: #f3e8ff; color: #7c3aed; font-size: 0.6rem;">
                                            {{ $lecturer->academic_degree }}
                                        </span>
                                    @endif
                                    
                                    @if($lecturer->employment_status)
                                        <span class="badge {{ $lecturer->employment_status == 'Tetap' ? 'bg-success' : 'bg-warning' }}" style="font-size: 0.6rem;">
                                            {{ $lecturer->employment_status }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="small">
                                    <div class="fw-semibold text-truncate" style="max-width: 100px;" title="{{ $lecturer->position ?? '-' }}">
                                        {{ $lecturer->position ?? '-' }}
                                    </div>
                                    @if($lecturer->structural_position)
                                        <div class="text-muted text-truncate" style="font-size: 0.7rem; max-width: 100px;" title="{{ $lecturer->structural_position }}">
                                            <i class="fas fa-user-tie me-1"></i>{{ $lecturer->structural_position }}
                                        </div>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                @if($lecturer->study_program)
                                    @php
                                        $badgeClass = match($lecturer->study_program) {
                                            'Manajemen' => 'bg-primary',
                                            'Akutansi' => 'bg-success',
                                            'Magister Manajemen' => 'bg-purple',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $badgeClass }}">
                                        {{ $lecturer->study_program }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 small">
                                @if($lecturer->email)
                                    <div class="mb-1 text-truncate" style="max-width: 120px;">
                                        <i class="fas fa-envelope text-muted me-1"></i>
                                        <span title="{{ $lecturer->email }}">{{ $lecturer->email }}</span>
                                    </div>
                                @endif
                                @if($lecturer->phone)
                                    <div class="text-truncate" style="max-width: 120px;">
                                        <i class="fas fa-phone text-muted me-1"></i>
                                        {{ $lecturer->phone }}
                                    </div>
                                @endif
                                @if(!$lecturer->email && !$lecturer->phone)
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td class="px-3 py-3">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="completeness-bar flex-grow-1" style="width: 50px;">
                                        <div class="completeness-fill {{ $lecturer->profile_completeness >= 80 ? 'bg-success' : ($lecturer->profile_completeness >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                             style="width: {{ $lecturer->profile_completeness }}%">
                                        </div>
                                    </div>
                                    <span class="small fw-semibold" style="font-size: 0.75rem;">{{ $lecturer->profile_completeness }}%</span>
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="d-flex flex-column gap-1">
                                    @if($lecturer->is_visible)
                                        <span class="badge bg-success-subtle text-success" style="background-color: #d1f2eb; color: #0f5132; font-size: 0.6rem;">
                                            <i class="fas fa-eye me-1"></i>Tampil
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary" style="background-color: #e9ecef; color: #495057; font-size: 0.6rem;">
                                            <i class="fas fa-eye-slash me-1"></i>Tersembunyi
                                        </span>
                                    @endif
                                    
                                    @if($lecturer->is_active)
                                        <span class="badge bg-info-subtle text-info" style="background-color: #cff4fc; color: #055160; font-size: 0.6rem;">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger" style="background-color: #f8d7da; color: #842029; font-size: 0.6rem;">
                                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-3 py-3">
                                <div class="d-flex justify-content-center gap-2 table-actions">
                                    <a href="{{ route('admin.lecturers.edit', $lecturer) }}" 
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    
                                    <form action="{{ route('admin.lecturers.destroy', $lecturer) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('Yakin ingin menghapus dosen {{ $lecturer->name }}?')">
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
                            <td colspan="8" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-3">
                                        @if(request()->hasAny(['search', 'study_program', 'employment_status', 'is_visible']))
                                            Tidak ada hasil yang ditemukan
                                        @else
                                            Belum ada data dosen
                                        @endif
                                    </p>
                                    @if(!request()->hasAny(['search', 'study_program', 'employment_status', 'is_visible']))
                                        <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Tambah Dosen Pertama
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Mobile Card View -->
    <div class="d-md-none">
        @forelse($lecturers as $lecturer)
        <div class="card border-0 shadow-sm mb-3 mobile-card {{ !$lecturer->is_visible ? 'hidden' : '' }}">
            <div class="card-body">
                <div class="d-flex gap-3 mb-3 align-items-start">
                    <div class="flex-shrink-0">
                        <img src="{{ $lecturer->photo_url }}" 
                             class="rounded-circle lecturer-photo"
                             alt="{{ $lecturer->name }}"
                             onerror="this.src='{{ asset('images/default-lecturer.png') }}'">
                    </div>
                    
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-bold mb-1 text-truncate">{{ $lecturer->name }}</h6>
                        <div class="text-muted small mb-2">NIDN: {{ $lecturer->nidn }}</div>
                        
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @if($lecturer->academic_degree)
                                <span class="badge" style="background-color: #f3e8ff; color: #7c3aed; font-size: 0.7rem;">
                                    {{ $lecturer->academic_degree }}
                                </span>
                            @endif
                            
                            @if($lecturer->employment_status)
                                <span class="badge {{ $lecturer->employment_status == 'Tetap' ? 'bg-success' : 'bg-warning' }}" style="font-size: 0.7rem;">
                                    {{ $lecturer->employment_status }}
                                </span>
                            @endif
                            
                            @if($lecturer->study_program)
                                @php
                                    $badgeClass = match($lecturer->study_program) {
                                        'Manajemen' => 'bg-primary',
                                        'Akutansi' => 'bg-success',
                                        'Magister Manajemen' => 'bg-purple',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                                <span class="badge {{ $badgeClass }}" style="font-size: 0.7rem;">
                                    {{ $lecturer->study_program }}
                                </span>
                            @endif
                        </div>

                        {{-- Profile Completeness --}}
                        <div class="mb-0">
                            <div class="d-flex align-items-center gap-2">
                                <div class="completeness-bar flex-grow-1">
                                    <div class="completeness-fill {{ $lecturer->profile_completeness >= 80 ? 'bg-success' : ($lecturer->profile_completeness >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                         style="width: {{ $lecturer->profile_completeness }}%">
                                    </div>
                                </div>
                                <span class="small text-muted flex-shrink-0">{{ $lecturer->profile_completeness }}%</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-3 small">
                    @if($lecturer->position)
                        <div class="mb-2 text-truncate">
                            <i class="fas fa-briefcase text-muted me-2"></i>
                            <span class="fw-semibold">{{ $lecturer->position }}</span>
                        </div>
                    @endif

                    @if($lecturer->structural_position)
                        <div class="mb-2 text-truncate">
                            <i class="fas fa-user-tie text-muted me-2"></i>
                            <span>{{ $lecturer->structural_position }}</span>
                        </div>
                    @endif
                    
                    @if($lecturer->email)
                        <div class="mb-1">
                            <i class="fas fa-envelope text-muted me-2"></i>
                            <a href="mailto:{{ $lecturer->email }}" class="text-decoration-none text-truncate d-inline-block" style="max-width: calc(100% - 30px);">
                                {{ $lecturer->email }}
                            </a>
                        </div>
                    @endif
                    
                    @if($lecturer->phone)
                        <div>
                            <i class="fas fa-phone text-muted me-2"></i>
                            <a href="tel:{{ $lecturer->phone }}" class="text-decoration-none">
                                {{ $lecturer->phone }}
                            </a>
                        </div>
                    @endif
                </div>

                <div class="d-flex flex-wrap gap-1 mb-3">
                    @if($lecturer->is_visible)
                        <span class="badge" style="background-color: #d1f2eb; color: #0f5132; font-size: 0.7rem;">
                            <i class="fas fa-eye me-1"></i>Tampil
                        </span>
                    @else
                        <span class="badge" style="background-color: #e9ecef; color: #495057; font-size: 0.7rem;">
                            <i class="fas fa-eye-slash me-1"></i>Tersembunyi
                        </span>
                    @endif
                    
                    @if($lecturer->is_active)
                        <span class="badge" style="background-color: #cff4fc; color: #055160; font-size: 0.7rem;">
                            <i class="fas fa-check-circle me-1"></i>Aktif
                        </span>
                    @else
                        <span class="badge" style="background-color: #f8d7da; color: #842029; font-size: 0.7rem;">
                            <i class="fas fa-times-circle me-1"></i>Nonaktif
                        </span>
                    @endif
                </div>

                <div class="d-flex gap-2">
                    <a href="{{ route('admin.lecturers.edit', $lecturer) }}" 
                       class="btn btn-sm btn-outline-primary flex-grow-1">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    
                    <form action="{{ route('admin.lecturers.destroy', $lecturer) }}" 
                          method="POST" 
                          class="flex-grow-1"
                          onsubmit="return confirm('Yakin ingin menghapus dosen {{ $lecturer->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger w-100">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-users fa-3x text-muted opacity-25 mb-3"></i>
                <p class="text-muted mb-3">
                    @if(request()->hasAny(['search', 'study_program', 'employment_status', 'is_visible']))
                        Tidak ada hasil yang ditemukan
                    @else
                        Belum ada data dosen
                    @endif
                </p>
                @if(!request()->hasAny(['search', 'study_program', 'employment_status', 'is_visible']))
                    <a href="{{ route('admin.lecturers.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Dosen Pertama
                    </a>
                @endif
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($lecturers->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $lecturers->links() }}
    </div>
    @endif
</div>

<style>
/* Custom purple badge color for Magister Manajemen */
.bg-purple {
    background-color: #9333ea !important;
}
</style>
@endsection