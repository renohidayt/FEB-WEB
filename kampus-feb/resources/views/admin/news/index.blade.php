@extends('admin.layouts.app')

@section('title', 'Kelola Berita')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Kelola Berita</h1>
            <p class="text-muted mb-0">Kelola dan publikasikan konten berita Anda</p>
        </div>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Tambah Berita
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Berita</p>
                            <h3 class="mb-0">{{ \App\Models\News::count() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="bi bi-newspaper text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Terbit</p>
                            <h3 class="mb-0">{{ \App\Models\News::where('is_published', true)->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="bi bi-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Draft</p>
                            <h3 class="mb-0">{{ \App\Models\News::where('is_published', false)->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 rounded p-3">
                            <i class="bi bi-pencil text-warning fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Views</p>
                            <h3 class="mb-0">{{ number_format(\App\Models\News::sum('views')) }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 rounded p-3">
                            <i class="bi bi-eye text-info fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.news.index') }}" method="GET">
                <div class="row g-3">
                    <div class="col-12 col-md-6 col-lg-3">
                        <label class="form-label small fw-semibold">Cari Berita</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                   class="form-control" placeholder="Cari berita...">
                        </div>
                    </div>
                    <div class="col-6 col-md-6 col-lg-2">
                        <label class="form-label small fw-semibold">Kategori</label>
                        <select name="category" class="form-select">
                            <option value="">Semua</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6 col-md-4 col-lg-2">
                        <label class="form-label small fw-semibold">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="published" {{ request('status') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-lg-3">
                        <label class="form-label small fw-semibold">Periode</label>
                        <select name="archive" class="form-select">
                            <option value="">Semua Waktu</option>
                            @foreach($archives as $arc)
                                @php
                                    $months = ['','Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'];
                                    $val = $arc->year . '-' . str_pad($arc->month, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <option value="{{ $val }}" {{ request('archive') == $val ? 'selected' : '' }}>
                                    {{ $months[$arc->month] }} {{ $arc->year }} ({{ $arc->count }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-4 col-lg-2">
                        <label class="form-label small fw-semibold d-none d-md-block">&nbsp;</label>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-grow-1">
                                <i class="bi bi-funnel me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Desktop -->
    <div class="card border-0 shadow-sm d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="fw-semibold">Berita</th>
                        <th class="fw-semibold">Kategori</th>
                        <th class="fw-semibold">Penulis</th>
                        <th class="fw-semibold text-center">Stats</th>
                        <th class="fw-semibold text-center">Status</th>
                        <th class="fw-semibold">Tanggal</th>
                        <th class="fw-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                @if($item->featured_image)
                                    <img src="{{ asset('storage/' . $item->featured_image) }}" 
                                         class="rounded" style="width:60px;height:60px;object-fit:cover">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                         style="width:60px;height:60px">
                                        <i class="bi bi-image text-muted fs-4"></i>
                                    </div>
                                @endif
                                <div style="max-width:300px">
                                    <a href="{{ route('admin.news.edit', $item) }}" 
                                       class="fw-semibold text-decoration-none text-dark d-block text-truncate">
                                        {{ $item->title }}
                                    </a>
                                    @if($item->excerpt)
                                        <small class="text-muted d-block text-truncate">{{ Str::limit($item->excerpt, 60) }}</small>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td><span class="badge bg-primary bg-opacity-10 text-primary">{{ $item->category->name ?? '-' }}</span></td>
                        <td>
                            <div>{{ $item->author_display_name }}</div>
                            @if($item->author_name)
                                <small class="text-muted">Custom</small>
                            @endif
                        </td>
                        <td class="text-center">
                            <div><i class="bi bi-eye me-1"></i>{{ number_format($item->views) }}</div>
                            <small class="text-muted">{{ $item->reading_time }} min</small>
                        </td>
                        <td class="text-center">
                            @if($item->is_published)
                                <span class="badge bg-success">Terbit</span>
                            @else
                                <span class="badge bg-secondary">Draft</span>
                            @endif
                            @if($item->show_on_homepage)
                                <span class="badge bg-warning text-dark mt-1">Home</span>
                            @endif
                        </td>
                        <td>
                            <div>{{ $item->published_at ? $item->published_at->format('d M Y') : '-' }}</div>
                            <small class="text-muted">{{ $item->published_at ? $item->published_at->format('H:i') : '' }}</small>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.news.show', $item) }}" class="btn btn-sm btn-outline-primary" title="Detail">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" 
                                      onsubmit="return confirm('Hapus berita ini?')" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <i class="bi bi-inbox text-muted" style="font-size:3rem"></i>
                            <p class="text-muted mt-3 mb-0">Tidak ada berita</p>
                            <small class="text-muted">Mulai dengan membuat berita baru</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards Mobile -->
    <div class="d-lg-none">
        @forelse($news as $item)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    @if($item->featured_image)
                        <img src="{{ asset('storage/' . $item->featured_image) }}" 
                             class="rounded" style="width:80px;height:80px;object-fit:cover">
                    @else
                        <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                             style="width:80px;height:80px">
                            <i class="bi bi-image text-muted fs-3"></i>
                        </div>
                    @endif
                    <div class="flex-grow-1">
                        <a href="{{ route('admin.news.edit', $item) }}" 
                           class="fw-semibold text-decoration-none text-dark d-block mb-1">
                            {{ $item->title }}
                        </a>
                        <span class="badge bg-primary bg-opacity-10 text-primary small">{{ $item->category->name ?? '-' }}</span>
                    </div>
                </div>
                
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <small class="text-muted">
                        <i class="bi bi-person me-1"></i>{{ $item->author_display_name }}
                    </small>
                    <small class="text-muted">
                        <i class="bi bi-eye me-1"></i>{{ number_format($item->views) }}
                    </small>
                </div>
                
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        @if($item->is_published)
                            <span class="badge bg-success small">Terbit</span>
                        @else
                            <span class="badge bg-secondary small">Draft</span>
                        @endif
                        @if($item->show_on_homepage)
                            <span class="badge bg-warning text-dark small">Home</span>
                        @endif
                    </div>
                    <div class="btn-group btn-group-sm">
                        <a href="{{ route('admin.news.show', $item) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-outline-info">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('admin.news.destroy', $item) }}" method="POST" 
                              onsubmit="return confirm('Hapus berita ini?')" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="bi bi-inbox text-muted" style="font-size:3rem"></i>
                <p class="text-muted mt-3 mb-0">Tidak ada berita</p>
                <small class="text-muted">Mulai dengan membuat berita baru</small>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $news->links() }}
    </div>
</div>

<style>
.card { transition: transform 0.2s; }
.card:hover { transform: translateY(-2px); }
.btn { transition: all 0.2s; }
</style>
@endsection