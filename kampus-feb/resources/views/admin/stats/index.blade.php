@extends('admin.layouts.app')

@section('title', 'Kelola Statistik')

@push('styles')
<style>
    .stat-card {
        transition: all 0.2s;
        cursor: move;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    .sortable-ghost {
        opacity: 0.4;
    }
</style>
@endpush

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Statistik Website</h1>
            <p class="text-muted small mb-0">Kelola statistik yang ditampilkan di homepage</p>
        </div>
        <a href="{{ route('admin.stats.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Statistik
        </a>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- STATS GRID --}}
    <div class="card shadow-sm">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-chart-bar me-2"></i>Daftar Statistik
                <span class="badge bg-primary ms-2">{{ $stats->count() }}</span>
            </h6>
        </div>
        <div class="card-body">
            @if($stats->count() > 0)
                <div class="alert alert-info border-0 mb-3">
                    <small><i class="fas fa-info-circle me-1"></i>Drag & drop kartu untuk mengubah urutan</small>
                </div>

                <div class="row g-3" id="sortable-stats">
                    @foreach($stats as $stat)
                        <div class="col-md-6 col-lg-4" data-id="{{ $stat->id }}">
                            <div class="card stat-card border-2 h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="fas fa-grip-vertical text-muted" style="cursor: move;"></i>
                                            <span class="badge bg-{{ $stat->color }}">{{ $stat->key }}</span>
                                        </div>
                                        @if($stat->is_active)
                                            <span class="badge bg-success" style="font-size: 0.7rem;">Aktif</span>
                                        @else
                                            <span class="badge bg-secondary" style="font-size: 0.7rem;">Nonaktif</span>
                                        @endif
                                    </div>

                                    <div class="text-center mb-3">
                                        <div class="bg-{{ $stat->color }} bg-opacity-10 rounded-circle p-3 d-inline-flex mb-3">
                                            <i class="fas {{ $stat->icon ?: 'fa-chart-line' }} text-{{ $stat->color }}" style="font-size: 2rem;"></i>
                                        </div>
                                        <h2 class="h3 fw-bold mb-1">{{ $stat->formatted_value }}</h2>
                                        <p class="text-muted mb-0 small">{{ $stat->label }}</p>
                                    </div>

                                    <div class="d-flex gap-1">
                                        <a href="{{ route('admin.stats.edit', $stat) }}" 
                                           class="btn btn-sm btn-outline-warning flex-fill">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.stats.destroy', $stat) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus statistik {{ $stat->label }}?')">
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
                    @endforeach
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-chart-bar text-muted mb-3" style="font-size: 3rem;"></i>
                    <p class="text-muted mb-2">Belum ada statistik</p>
                    <a href="{{ route('admin.stats.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-1"></i>Tambah Statistik Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
    // Sortable for drag & drop
    const sortable = document.getElementById('sortable-stats');
    if (sortable) {
        new Sortable(sortable, {
            animation: 150,
            ghostClass: 'sortable-ghost',
            handle: '.fas.fa-grip-vertical',
            onEnd: function(evt) {
                // Get new order
                const order = Array.from(sortable.children).map(el => el.dataset.id);
                
                // Send AJAX request
                fetch('{{ route("admin.stats.update-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ order: order })
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Order updated successfully');
                })
                .catch(error => {
                    console.error('Error updating order:', error);
                });
            }
        });
    }
</script>
@endpush