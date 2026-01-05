@extends('admin.layouts.app')

@section('title', 'Kelola Profil')

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

    .bg-purple { background-color: #8b5cf6 !important; }
    .text-purple { color: #8b5cf6 !important; }

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
            <h1 class="h4 fw-bold mb-1">Kelola Profil</h1>
            <p class="text-muted small mb-0">Kelola informasi profil institusi</p>
        </div>
        <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Profil
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Profil</p>
                            <h3 class="h5 fw-bold mb-0">{{ $profiles->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-users text-primary" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Dengan Foto</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $profiles->where('photo', '!=', null)->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-camera text-success" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Tanpa Foto</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $profiles->where('photo', null)->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-image-slash text-warning" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Tipe Unik</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $profiles->pluck('type')->unique()->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-tags text-info" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Desktop Table -->
    <div class="card border-0 shadow-sm d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 fw-semibold text-muted small">TIPE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">NAMA/JUDUL</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">FOTO</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">UPDATE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($profiles as $profile)
                    <tr>
                        <td class="px-3 py-2">
                            @php
                                $badgeMap = [
                                    'dekan' => 'bg-purple',
                                    'kemahasiswaan' => 'bg-primary',
                                    'struktur' => 'bg-success',
                                    'sarana' => 'bg-warning',
                                    'visi_misi' => 'bg-danger'
                                ];
                                $badge = $badgeMap[$profile->type] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $badge }}" style="font-size: 0.7rem;">
                                {{ \App\Models\Profile::TYPES[$profile->type] ?? $profile->type }}
                            </span>
                        </td>
                        <td class="px-3 py-2">
                            <div class="fw-semibold small">{{ $profile->name ?: '-' }}</div>
                            @if($profile->content)
                                <small class="text-muted text-truncate d-block" style="font-size: 0.75rem; max-width: 300px;">
                                    {{ Str::limit(strip_tags($profile->content), 60) }}
                                </small>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if($profile->photo)
                                <img src="{{ $profile->photo_url }}" 
                                     alt="{{ $profile->name }}"
                                     class="rounded shadow-sm" 
                                     style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                    <i class="fas fa-image-slash me-1"></i>Tidak ada
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            <div class="small">{{ $profile->updated_at->format('d M Y') }}</div>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $profile->updated_at->diffForHumans() }}</small>
                        </td>
                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.profiles.edit', $profile) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.profiles.destroy', $profile) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus profil {{ $profile->name ?: 'ini' }}?')">
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
                        <td colspan="5" class="text-center py-5">
                            <i class="fas fa-user-circle text-muted mb-3" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-2 fw-semibold">Belum ada profil</p>
                            <p class="text-muted small">Tambah profil pertama untuk memulai</p>
                            <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>Tambah Profil
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Mobile Cards -->
    <div class="d-md-none">
        @forelse($profiles as $profile)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body p-3">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    @php
                        $badgeMap = [
                            'dekan' => 'bg-purple',
                            'kemahasiswaan' => 'bg-primary',
                            'struktur' => 'bg-success',
                            'sarana' => 'bg-warning',
                            'visi_misi' => 'bg-danger'
                        ];
                        $badge = $badgeMap[$profile->type] ?? 'bg-secondary';
                    @endphp
                    <span class="badge {{ $badge }}" style="font-size: 0.65rem;">
                        {{ \App\Models\Profile::TYPES[$profile->type] ?? $profile->type }}
                    </span>
                    <small class="text-muted" style="font-size: 0.7rem;">{{ $profile->updated_at->diffForHumans() }}</small>
                </div>

                <div class="d-flex gap-3 mb-3">
                    @if($profile->photo)
                        <div class="flex-shrink-0">
                            <img src="{{ $profile->photo_url }}" 
                                 alt="{{ $profile->name }}"
                                 class="rounded shadow-sm" 
                                 style="width: 70px; height: 70px; object-fit: cover;">
                        </div>
                    @endif
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-semibold mb-1 small">{{ $profile->name ?: 'Tanpa Judul' }}</h6>
                        @if($profile->content)
                            <p class="text-muted mb-0 text-truncate" style="font-size: 0.75rem;">
                                {{ Str::limit(strip_tags($profile->content), 80) }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="d-flex gap-1 pt-2 border-top">
                    <a href="{{ route('admin.profiles.edit', $profile) }}" 
                       class="btn btn-sm btn-outline-warning flex-grow-1">
                        <i class="fas fa-edit"></i><span class="d-none d-sm-inline ms-1">Edit</span>
                    </a>

                    <form action="{{ route('admin.profiles.destroy', $profile) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus profil?')">
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
                <i class="fas fa-user-circle text-muted mb-3" style="font-size: 2.5rem;"></i>
                <p class="text-muted mb-2 fw-semibold">Belum ada profil</p>
                <p class="text-muted small">Tambah profil pertama untuk memulai</p>
                <a href="{{ route('admin.profiles.create') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-plus me-1"></i>Tambah Profil
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection