@extends('admin.layouts.app')

@section('title', 'Template Surat')

@push('styles')
<style>
    .stat-card {
        border-radius: 10px;
        transition: all 0.2s;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    .template-card {
        transition: all 0.2s;
        border: 2px solid #e5e7eb;
    }

    .template-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 8px 16px rgba(0,0,0,0.15);
        border-color: #0d6efd;
    }

    .add-card {
        transition: all 0.2s;
        border: 2px dashed #d1d5db;
        cursor: pointer;
    }

    .add-card:hover {
        transform: translateY(-4px);
        border-color: #0d6efd;
        background-color: #f8f9fa;
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
            <h1 class="h4 fw-bold mb-1">Sistem Pengajuan Surat</h1>
            <p class="text-muted small mb-0">Kelola template surat dan lihat pengajuan mahasiswa</p>
        </div>
        <a href="{{ route('admin.letter-templates.create') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus me-2"></i>Buat Template Baru
        </a>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body p-2 p-md-3 text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-white mb-1 fw-medium opacity-75" style="font-size: 0.7rem;">Total Template</p>
                            <h3 class="h5 fw-bold mb-0">{{ $templates->total() }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 p-2 rounded flex-shrink-0">
                            <i class="fas fa-file-alt text-white" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                <div class="card-body p-2 p-md-3 text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-white mb-1 fw-medium opacity-75" style="font-size: 0.7rem;">Total Pengajuan</p>
                            <h3 class="h5 fw-bold mb-0">{{ $templates->sum('submissions_count') }}</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 p-2 rounded flex-shrink-0">
                            <i class="fas fa-paper-plane text-white" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
                <div class="card-body p-2 p-md-3 text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-white mb-1 fw-medium opacity-75" style="font-size: 0.7rem;">Menunggu</p>
                            <h3 class="h5 fw-bold mb-0">0</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 p-2 rounded flex-shrink-0">
                            <i class="fas fa-clock text-white" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 shadow-sm stat-card" style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                <div class="card-body p-2 p-md-3 text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="flex-grow-1 min-w-0">
                            <p class="text-white mb-1 fw-medium opacity-75" style="font-size: 0.7rem;">Selesai</p>
                            <h3 class="h5 fw-bold mb-0">0</h3>
                        </div>
                        <div class="bg-white bg-opacity-25 p-2 rounded flex-shrink-0">
                            <i class="fas fa-check-circle text-white" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TEMPLATE LIST --}}
    <div class="card border-0 shadow-sm">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-file-alt me-2"></i>Template Surat Tersedia
            </h6>
        </div>
        <div class="card-body">
            <div class="row g-3">
                @forelse($templates as $template)
                    <div class="col-md-6 col-lg-4">
                        <div class="card template-card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="bg-primary bg-opacity-10 rounded p-3 flex-shrink-0">
                                        <i class="fas fa-file-alt text-primary" style="font-size: 1.5rem;"></i>
                                    </div>
                                    @if($template->is_active)
                                        <span class="badge bg-success" style="font-size: 0.7rem;">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary" style="font-size: 0.7rem;">Nonaktif</span>
                                    @endif
                                </div>
                                
                                <h6 class="fw-bold mb-2" style="font-size: 0.95rem;">{{ $template->title }}</h6>
                                
                                @if($template->description)
                                    <p class="text-muted small mb-3" style="font-size: 0.8rem;">
                                        {{ Str::limit($template->description, 80) }}
                                    </p>
                                @endif
                                
                                <div class="d-flex align-items-center text-muted small mb-3">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span style="font-size: 0.8rem;">{{ $template->submissions_count ?? 0 }} pengajuan</span>
                                </div>
                                
                                <div class="d-flex gap-1 pt-2 border-top">
                                    <a href="{{ route('admin.letter-submissions.index', ['template' => $template->id]) }}" 
                                       class="btn btn-sm btn-primary flex-fill" 
                                       style="font-size: 0.75rem;">
                                        <i class="fas fa-eye"></i><span class="d-none d-sm-inline ms-1">Data</span>
                                    </a>
                                    <a href="{{ route('admin.letter-templates.edit', $template) }}" 
                                       class="btn btn-sm btn-outline-warning"
                                       style="font-size: 0.75rem;">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.letter-templates.destroy', $template) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('⚠️ Yakin hapus template {{ $template->title }}?')">
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
                        <div class="text-center py-5">
                            <i class="fas fa-inbox text-muted mb-3" style="font-size: 3rem;"></i>
                            <p class="text-muted mb-2 fw-semibold">Belum ada template surat</p>
                            <p class="text-muted small">Klik tombol "Buat Template Baru" untuk memulai</p>
                            <a href="{{ route('admin.letter-templates.create') }}" class="btn btn-primary btn-sm mt-2">
                                <i class="fas fa-plus me-1"></i>Buat Template
                            </a>
                        </div>
                    </div>
                @endforelse

                {{-- ADD NEW CARD --}}
                @if($templates->count() > 0)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('admin.letter-templates.create') }}" 
                           class="card add-card h-100 text-decoration-none">
                            <div class="card-body d-flex flex-column align-items-center justify-content-center text-center" style="min-height: 240px;">
                                <div class="bg-light rounded-circle p-4 mb-3">
                                    <i class="fas fa-plus text-muted" style="font-size: 2rem;"></i>
                                </div>
                                <h6 class="fw-bold text-dark mb-2">Buat Template Baru</h6>
                                <p class="text-muted small mb-0">Tambah jenis surat baru</p>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if($templates->hasPages())
        <div class="mt-4">
            {{ $templates->links() }}
        </div>
    @endif
</div>
@endsection