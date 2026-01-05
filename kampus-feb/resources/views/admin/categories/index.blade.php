@extends('admin.layouts.app')

@section('title', 'Kelola Kategori')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div>
            <h1 class="h3 fw-bold mb-1">Kelola Kategori</h1>
            <p class="text-muted mb-0">Kelola kategori berita Anda</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus me-2"></i>Tambah Kategori
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Kategori</p>
                            <h3 class="mb-0">{{ $categories->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded p-3">
                            <i class="fas fa-tags text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <p class="text-muted small mb-1">Total Berita</p>
                            <h3 class="mb-0">{{ $categories->sum('news_count') }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded p-3">
                            <i class="fas fa-newspaper text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Desktop -->
    <div class="card border-0 shadow-sm d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="fw-semibold" style="width:60px">No</th>
                        <th class="fw-semibold">Nama</th>
                        <th class="fw-semibold">Slug</th>
                        <th class="fw-semibold">Deskripsi</th>
                        <th class="fw-semibold text-center">Jumlah Berita</th>
                        <th class="fw-semibold text-center" style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $index => $category)
                    <tr>
                        <td>{{ $categories->firstItem() + $index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-primary bg-opacity-10 rounded p-2">
                                    <i class="fas fa-tag text-primary"></i>
                                </div>
                                <strong>{{ $category->name }}</strong>
                            </div>
                        </td>
                        <td><code class="text-muted">{{ $category->slug }}</code></td>
                        <td>
                            @if($category->description)
                                <span class="text-muted">{{ Str::limit($category->description, 60) }}</span>
                            @else
                                <span class="text-muted fst-italic">(Tidak ada deskripsi)</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                {{ $category->news_count }} berita
                            </span>
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                <a href="{{ route('admin.categories.edit', $category) }}" 
                                   class="btn btn-sm btn-outline-info" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button type="button" onclick="confirmDelete({{ $category->id }})" 
                                        class="btn btn-sm btn-outline-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                                <form id="delete-form-{{ $category->id }}" 
                                      action="{{ route('admin.categories.destroy', $category) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-inbox text-muted" style="font-size:3rem"></i>
                            <p class="text-muted mt-3 mb-0">Belum ada kategori</p>
                            <small class="text-muted">Mulai dengan membuat kategori baru</small>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards Mobile -->
    <div class="d-lg-none">
        @forelse($categories as $index => $category)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div class="d-flex align-items-center gap-2">
                        <div class="bg-primary bg-opacity-10 rounded p-2">
                            <i class="fas fa-tag text-primary"></i>
                        </div>
                        <div>
                            <strong class="d-block">{{ $category->name }}</strong>
                            <code class="small text-muted">{{ $category->slug }}</code>
                        </div>
                    </div>
                    <span class="badge bg-primary">{{ $category->news_count }}</span>
                </div>
                
                @if($category->description)
                    <p class="text-muted small mb-3">{{ Str::limit($category->description, 80) }}</p>
                @else
                    <p class="text-muted fst-italic small mb-3">(Tidak ada deskripsi)</p>
                @endif
                
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.categories.edit', $category) }}" 
                       class="btn btn-sm btn-outline-info flex-grow-1">
                        <i class="fas fa-edit me-1"></i>Edit
                    </a>
                    <button type="button" onclick="confirmDelete({{ $category->id }})" 
                            class="btn btn-sm btn-outline-danger flex-grow-1">
                        <i class="fas fa-trash me-1"></i>Hapus
                    </button>
                    <form id="delete-form-{{ $category->id }}" 
                          action="{{ route('admin.categories.destroy', $category) }}" 
                          method="POST" class="d-none">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="card border-0 shadow-sm">
            <div class="card-body text-center py-5">
                <i class="fas fa-inbox text-muted" style="font-size:3rem"></i>
                <p class="text-muted mt-3 mb-0">Belum ada kategori</p>
                <small class="text-muted">Mulai dengan membuat kategori baru</small>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $categories->links() }}
    </div>
</div>

<style>
.card { transition: transform 0.2s; }
.card:hover { transform: translateY(-2px); }
.btn { transition: all 0.2s; }
</style>
@endsection

@push('scripts')
<script>
function confirmDelete(id) {
    if (confirm('⚠️ Yakin ingin menghapus kategori ini?\n\nKategori yang dihapus tidak dapat dikembalikan!')) {
        document.getElementById('delete-form-' + id).submit();
    }
}
</script>
@endpush