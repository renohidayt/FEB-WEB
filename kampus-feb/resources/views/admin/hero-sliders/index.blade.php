@extends('admin.layouts.app')

@section('title', 'Kelola Hero Slider')

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

    .sortable-row {
        cursor: move;
        transition: background-color 0.2s;
    }

    .sortable-row:hover {
        background-color: #f8f9fa;
    }

    .sortable-ghost {
        opacity: 0.4;
        background-color: #e3f2fd;
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
            <h1 class="h4 fw-bold mb-1">Hero Slider Homepage</h1>
            <p class="text-muted small mb-0">Kelola slider banner utama di homepage</p>
        </div>
        <a href="{{ route('admin.hero-sliders.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Tambah Slider
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total Sliders</p>
                            <h3 class="h5 fw-bold mb-0">{{ $sliders->count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-images text-primary" style="font-size: 1.25rem;"></i>
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
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $sliders->where('is_active', true)->count() }}</h3>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Image Sliders</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $sliders->where('media_type', 'image')->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-image text-info" style="font-size: 1.25rem;"></i>
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
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Video Sliders</p>
                            <h3 class="h5 fw-bold mb-0 text-danger">{{ $sliders->where('media_type', 'video')->count() }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 p-2 rounded flex-shrink-0">
                            <i class="fas fa-video text-danger" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Drag Info Alert -->
    @if($sliders->count() > 1)
    <div class="alert alert-info border-0 mb-3" role="alert">
        <div class="d-flex align-items-start">
            <i class="fas fa-hand-pointer me-2 mt-1"></i>
            <div class="small">
                <strong>💡 Tips:</strong> Drag & drop baris slider untuk mengatur urutan tampil di homepage. Urutan akan otomatis tersimpan.
            </div>
        </div>
    </div>
    @endif

    <!-- Desktop Table -->
    <div class="card border-0 shadow-sm d-none d-md-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="px-3 py-2 fw-semibold text-muted small" style="width: 50px;">
                            <i class="fas fa-grip-vertical"></i>
                        </th>
                        <th class="px-3 py-2 fw-semibold text-muted small">PREVIEW</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">JUDUL</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">TIPE</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">ORDER</th>
                        <th class="px-3 py-2 fw-semibold text-muted small">STATUS</th>
                        <th class="px-3 py-2 fw-semibold text-muted small text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody id="sortable-sliders">
                    @forelse($sliders as $slider)
                    <tr data-id="{{ $slider->id }}" class="sortable-row">
                        <td class="px-3 py-2 text-center text-muted">
                            <i class="fas fa-grip-vertical" style="cursor: move;"></i>
                        </td>
                        <td class="px-3 py-2">
                            @if($slider->media_type === 'image' && $slider->media_path)
                                <img src="{{ asset('storage/' . $slider->media_path) }}" 
                                     alt="{{ $slider->title }}"
                                     class="rounded shadow-sm"
                                     style="width: 80px; height: 50px; object-fit: cover;">
                            @elseif($slider->media_type === 'video')
                                <div class="bg-gradient-danger rounded shadow-sm d-flex align-items-center justify-content-center"
                                     style="width: 80px; height: 50px;">
                                    <i class="fas fa-play-circle text-white" style="font-size: 1.5rem;"></i>
                                </div>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            <div class="fw-semibold small">{{ $slider->title }}</div>
                            @if($slider->subtitle)
                                <small class="text-muted text-truncate d-block" style="font-size: 0.75rem; max-width: 250px;">
                                    {{ Str::limit($slider->subtitle, 50) }}
                                </small>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            @if($slider->media_type === 'video')
                                <span class="badge bg-danger" style="font-size: 0.7rem;">
                                    <i class="fas fa-video me-1"></i>Video
                                </span>
                                @if($slider->video_platform)
                                    <br><small class="text-muted" style="font-size: 0.65rem;">{{ ucfirst($slider->video_platform) }}</small>
                                @endif
                            @else
                                <span class="badge bg-primary" style="font-size: 0.7rem;">
                                    <i class="fas fa-image me-1"></i>Gambar
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-2 text-center">
                            <span class="badge bg-secondary" style="font-size: 0.7rem;">{{ $slider->order }}</span>
                        </td>
                        <td class="px-3 py-2">
                            @if($slider->is_active)
                                <span class="badge bg-success" style="font-size: 0.7rem;">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.7rem;">
                                    <i class="fas fa-times-circle me-1"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td class="px-3 py-2">
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.hero-sliders.edit', $slider) }}" 
                                   class="btn btn-sm btn-outline-warning" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <form action="{{ route('admin.hero-sliders.destroy', $slider) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus slider {{ $slider->title }}?')">
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
                        <td colspan="7" class="text-center py-5">
                            <i class="fas fa-images text-muted mb-3" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mb-2 fw-semibold">Belum ada slider</p>
                            <p class="text-muted small">Tambah slider pertama untuk memulai</p>
                            <a href="{{ route('admin.hero-sliders.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>Tambah Slider
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
        @forelse($sliders as $slider)
        <div class="card border-0 shadow-sm mb-2">
            <div class="card-body p-3">
                <div class="d-flex gap-2 mb-2">
                    <div class="flex-shrink-0">
                        @if($slider->media_type === 'image' && $slider->media_path)
                            <img src="{{ asset('storage/' . $slider->media_path) }}" 
                                 alt="{{ $slider->title }}"
                                 class="rounded shadow-sm"
                                 style="width: 80px; height: 50px; object-fit: cover;">
                        @elseif($slider->media_type === 'video')
                            <div class="bg-gradient-danger rounded shadow-sm d-flex align-items-center justify-content-center"
                                 style="width: 80px; height: 50px;">
                                <i class="fas fa-play-circle text-white" style="font-size: 1.5rem;"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <h6 class="fw-semibold mb-1 small">{{ $slider->title }}</h6>
                        @if($slider->subtitle)
                            <p class="text-muted mb-2 text-truncate" style="font-size: 0.75rem;">{{ Str::limit($slider->subtitle, 40) }}</p>
                        @endif
                        
                        <div class="d-flex flex-wrap gap-1 mb-2">
                            @if($slider->media_type === 'video')
                                <span class="badge bg-danger" style="font-size: 0.65rem;">
                                    <i class="fas fa-video me-1"></i>Video
                                </span>
                            @else
                                <span class="badge bg-primary" style="font-size: 0.65rem;">
                                    <i class="fas fa-image me-1"></i>Gambar
                                </span>
                            @endif
                            
                            @if($slider->is_active)
                                <span class="badge bg-success" style="font-size: 0.65rem;">Aktif</span>
                            @else
                                <span class="badge bg-secondary" style="font-size: 0.65rem;">Nonaktif</span>
                            @endif
                            
                            <span class="badge bg-secondary" style="font-size: 0.65rem;">Order: {{ $slider->order }}</span>
                        </div>
                    </div>
                </div>

                <div class="d-flex gap-1 pt-2 border-top">
                    <a href="{{ route('admin.hero-sliders.edit', $slider) }}" 
                       class="btn btn-sm btn-outline-warning flex-grow-1">
                        <i class="fas fa-edit"></i><span class="d-none d-sm-inline ms-1">Edit</span>
                    </a>

                    <form action="{{ route('admin.hero-sliders.destroy', $slider) }}" 
                          method="POST" 
                          class="d-inline"
                          onsubmit="return confirm('Yakin hapus slider?')">
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
                <i class="fas fa-images text-muted mb-3" style="font-size: 2.5rem;"></i>
                <p class="text-muted mb-2 fw-semibold">Belum ada slider</p>
                <p class="text-muted small">Tambah slider pertama untuk memulai</p>
                <a href="{{ route('admin.hero-sliders.create') }}" class="btn btn-primary btn-sm mt-2">
                    <i class="fas fa-plus me-1"></i>Tambah Slider
                </a>
            </div>
        </div>
        @endforelse
    </div>
</div>

{{-- SortableJS CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

{{-- Drag & Drop Script --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const el = document.getElementById('sortable-sliders');
    
    if (el && el.children.length > 0) {
        Sortable.create(el, {
            animation: 150,
            handle: '.sortable-row', // Entire row is draggable
            ghostClass: 'sortable-ghost',
            onEnd: function (evt) {
                // Get new order
                const order = Array.from(el.children)
                    .filter(row => row.dataset.id) // Filter out empty state row
                    .map(row => row.dataset.id);
                
                if (order.length > 0) {
                    // Send AJAX request to update order
                    fetch('{{ route("admin.hero-sliders.update-order") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ order: order })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success feedback (optional)
                            console.log('Order updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error updating order:', error);
                        // Optionally show error message to user
                    });
                }
            }
        });
    }
});
</script>

<style>
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}
</style>
@endsection