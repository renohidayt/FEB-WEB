@extends('admin.layouts.app')

@section('title', 'Struktur Organisasi')

@push('styles')
<style>
    .org-chart-container {
        min-height: 300px;
    }
    
    .senat-toggle {
        transition: all 0.3s ease;
    }
    
    .senat-toggle:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(234, 88, 12, 0.2);
    }
    
    .org-header-card {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
    }
    
    .legend-item {
        transition: transform 0.2s;
    }
    
    .legend-item:hover {
        transform: scale(1.05);
    }
    
    .photo-circle {
        width: 48px;
        height: 48px;
        object-fit: cover;
        border: 2px solid #e5e7eb;
    }
    
    .action-btn {
        transition: all 0.2s;
    }
    
    .action-btn:hover {
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .mobile-org-card {
            border-left: 4px solid #3b82f6;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Struktur Organisasi</h1>
            <p class="text-muted mb-0">Fakultas Ekonomi dan Bisnis - Universitas Sebelas April</p>
        </div>
        <div class="d-flex gap-2">
            <button onclick="toggleSenat()" 
                    class="btn btn-warning senat-toggle">
                <i class="fas fa-users me-2"></i>SENAT
            </button>
            <a href="{{ route('admin.organizational-structures.create') }}" 
               class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Tambah Struktur
            </a>
        </div>
    </div>

    <!-- Senat Info -->
    <div id="senatInfo" class="alert alert-warning border-start border-warning border-4 d-none mb-4" role="alert">
        <h5 class="alert-heading fw-bold">
            <i class="fas fa-users me-2"></i>Senat Fakultas
        </h5>
        <p class="mb-0 small">
            Senat fakultas adalah badan normatif dan perwakilan tertinggi di tingkat fakultas.
        </p>
    </div>

    <!-- Organization Chart -->
    <div class="card border-0 shadow-lg mb-4 org-header-card">
        <div class="card-body p-4 p-md-5">
            <div class="text-center mb-4">
                <h3 class="h4 fw-bold text-white mb-3">STRUKTUR ORGANISASI</h3>
                <div class="d-inline-block bg-white bg-opacity-25 px-4 py-2 rounded-3">
                    <span class="text-white fw-semibold">Fakultas Ekonomi dan Bisnis</span>
                </div>
            </div>

            @if($structures->count() > 0)
                <div class="org-chart-container overflow-auto">
                    <div class="d-flex justify-content-center">
                        @foreach($structures->where('parent_id', null) as $root)
                            @include('admin.organizational-structures.partials.tree-node-v2', [
                                'node' => $root,
                                'level' => 0
                            ])
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <div class="text-white opacity-50 mb-3" style="font-size: 4rem;">
                        <i class="fas fa-sitemap"></i>
                    </div>
                    <p class="text-white opacity-75 fs-5">Belum ada struktur organisasi</p>
                    <a href="{{ route('admin.organizational-structures.create') }}" 
                       class="btn btn-light mt-3">
                        <i class="fas fa-plus me-2"></i>Tambah Struktur Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Legend -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body p-4">
            <h5 class="fw-bold mb-3">
                <i class="fas fa-info-circle text-primary me-2"></i>Keterangan
            </h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 legend-item">
                        <div class="rounded" style="width: 32px; height: 32px; background: linear-gradient(135deg, #3b82f6, #2563eb);"></div>
                        <span class="small fw-semibold">Struktural</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 legend-item">
                        <div class="rounded" style="width: 32px; height: 32px; background: linear-gradient(135deg, #10b981, #059669);"></div>
                        <span class="small fw-semibold">Akademik</span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 legend-item">
                        <div class="rounded" style="width: 32px; height: 32px; background: linear-gradient(135deg, #8b5cf6, #7c3aed);"></div>
                        <span class="small fw-semibold">Administratif</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table View - Desktop -->
    <div class="card border-0 shadow-sm d-none d-md-block">
        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0">
                    <i class="fas fa-list me-2 text-primary"></i>Daftar Semua Struktur
                </h5>
                
                <!-- Search -->
                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           id="searchInput"
                           placeholder="Cari nama, jabatan, NIP..." 
                           class="form-control"
                           onkeyup="searchTable()">
                </div>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="orgTable">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Nama & Jabatan</th>
                            <th class="px-4 py-3">Atasan</th>
                            <th class="px-4 py-3">Tipe</th>
                            <th class="px-4 py-3">Status</th>
                            <th class="px-4 py-3 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($allStructures as $item)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    @if($item->photo)
                                        <img src="{{ Storage::url($item->photo) }}" 
                                             class="rounded-circle photo-circle me-3"
                                             alt="{{ $item->name }}">
                                    @else
                                        <div class="rounded-circle photo-circle me-3 bg-gradient d-flex align-items-center justify-content-center"
                                             style="background: linear-gradient(135deg, #e5e7eb, #d1d5db);">
                                            <i class="fas fa-user text-muted"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ $item->name }}</div>
                                        <div class="text-muted small">{{ $item->position }}</div>
                                        @if($item->nip)
                                            <div class="text-muted" style="font-size: 0.75rem;">NIP: {{ $item->nip }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3">
                                @if($item->parent)
                                    <span class="text-primary fw-medium">{{ $item->parent->position }}</span>
                                @else
                                    <span class="badge bg-primary">ROOT</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->type == 'structural')
                                    <span class="badge bg-primary">Struktural</span>
                                @elseif($item->type == 'academic')
                                    <span class="badge bg-success">Akademik</span>
                                @else
                                    <span class="badge bg-purple" style="background-color: #8b5cf6;">Administratif</span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                @if($item->is_active)
                                    <span class="badge bg-success-subtle text-success" style="background-color: #d1f2eb; color: #0f5132;">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary" style="background-color: #e9ecef; color: #495057;">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-3">
                                <div class="d-flex justify-content-center gap-1">
                                    <a href="{{ route('admin.organizational-structures.show', $item) }}" 
                                       class="btn btn-sm btn-outline-success action-btn"
                                       title="Detail">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.organizational-structures.edit', $item) }}" 
                                       class="btn btn-sm btn-outline-primary action-btn"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.organizational-structures.destroy', $item) }}" 
                                          method="POST" 
                                          class="d-inline"
                                          onsubmit="return confirm('⚠️ Yakin hapus {{ $item->name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-outline-danger action-btn"
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
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-25"></i>
                                    <p class="mb-3">Tidak ada data struktur organisasi</p>
                                    <a href="{{ route('admin.organizational-structures.create') }}" 
                                       class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Tambah Struktur Pertama
                                    </a>
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
        <!-- Search Mobile -->
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="input-group">
                    <span class="input-group-text bg-white">
                        <i class="fas fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           id="searchInputMobile"
                           placeholder="Cari nama, jabatan, NIP..." 
                           class="form-control"
                           onkeyup="searchMobileCards()">
                </div>
            </div>
        </div>

        <!-- Mobile Cards -->
        <div id="mobileCardsContainer">
            @forelse($allStructures as $item)
            <div class="card border-0 shadow-sm mb-3 mobile-org-card mobile-card-item">
                <div class="card-body">
                    <div class="d-flex gap-3 mb-3">
                        @if($item->photo)
                            <img src="{{ Storage::url($item->photo) }}" 
                                 class="rounded-circle photo-circle"
                                 alt="{{ $item->name }}">
                        @else
                            <div class="rounded-circle photo-circle bg-gradient d-flex align-items-center justify-content-center"
                                 style="background: linear-gradient(135deg, #e5e7eb, #d1d5db);">
                                <i class="fas fa-user text-muted"></i>
                            </div>
                        @endif
                        
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $item->name }}</h6>
                            <div class="text-muted small mb-2">{{ $item->position }}</div>
                            @if($item->nip)
                                <div class="text-muted" style="font-size: 0.75rem;">NIP: {{ $item->nip }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @if($item->type == 'structural')
                                <span class="badge bg-primary" style="font-size: 0.7rem;">Struktural</span>
                            @elseif($item->type == 'academic')
                                <span class="badge bg-success" style="font-size: 0.7rem;">Akademik</span>
                            @else
                                <span class="badge" style="background-color: #8b5cf6; font-size: 0.7rem;">Administratif</span>
                            @endif

                            @if($item->is_active)
                                <span class="badge" style="background-color: #d1f2eb; color: #0f5132; font-size: 0.7rem;">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge" style="background-color: #e9ecef; color: #495057; font-size: 0.7rem;">
                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </div>

                        @if($item->parent)
                            <div class="small">
                                <i class="fas fa-level-up-alt text-muted me-2"></i>
                                <span class="text-muted">Atasan:</span>
                                <span class="fw-semibold text-primary">{{ $item->parent->position }}</span>
                            </div>
                        @else
                            <div class="small">
                                <span class="badge bg-primary" style="font-size: 0.7rem;">ROOT</span>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.organizational-structures.show', $item) }}" 
                           class="btn btn-sm btn-outline-success flex-grow-1">
                            <i class="fas fa-eye me-1"></i>Detail
                        </a>
                        <a href="{{ route('admin.organizational-structures.edit', $item) }}" 
                           class="btn btn-sm btn-outline-primary flex-grow-1">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.organizational-structures.destroy', $item) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('⚠️ Yakin hapus {{ $item->name }}?')">
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
                    <i class="fas fa-inbox fa-3x text-muted opacity-25 mb-3"></i>
                    <p class="text-muted mb-3">Tidak ada data struktur organisasi</p>
                    <a href="{{ route('admin.organizational-structures.create') }}" 
                       class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Tambah Struktur Pertama
                    </a>
                </div>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Pagination -->
    @if($allStructures->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $allStructures->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
    function toggleSenat() {
        const senatInfo = document.getElementById('senatInfo');
        senatInfo.classList.toggle('d-none');
    }
    
    function searchTable() {
        const input = document.getElementById('searchInput');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('orgTable');
        const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
        
        for (let i = 0; i < rows.length; i++) {
            const row = rows[i];
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        }
    }

    function searchMobileCards() {
        const input = document.getElementById('searchInputMobile');
        const filter = input.value.toLowerCase();
        const cards = document.getElementsByClassName('mobile-card-item');
        
        for (let i = 0; i < cards.length; i++) {
            const card = cards[i];
            const text = card.textContent.toLowerCase();
            card.style.display = text.includes(filter) ? '' : 'none';
        }
    }
</script>
@endpush
@endsection