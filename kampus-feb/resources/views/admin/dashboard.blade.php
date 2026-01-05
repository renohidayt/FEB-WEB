@extends('admin.layouts.app')

@section('title', 'Dashboard')

@push('styles')
<style>
    .stat-card {
        border-radius: 16px;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    
    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 24px rgba(0,0,0,0.1);
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    .activity-card {
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        transition: all 0.2s ease;
    }
    
    .activity-card:hover {
        border-color: #3b82f6;
        background: #f8fafc;
    }
    
    .quick-action-btn {
        border-radius: 12px;
        padding: 1.25rem;
        transition: all 0.3s ease;
        border: 2px dashed #e5e7eb;
        background: white;
    }
    
    .quick-action-btn:hover {
        border-color: #3b82f6;
        border-style: solid;
        background: #eff6ff;
        transform: translateY(-2px);
    }
    
    .welcome-banner {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        min-height: 200px;
    }
    
    .welcome-banner::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
       background: linear-gradient(135deg, rgba(17, 22, 43, 0.42) 0%, rgba(24, 15, 32, 0.18) 100%);
        z-index: 1;
    }
    
    .welcome-banner-bg {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
    }
    
    .welcome-content {
        position: relative;
        z-index: 2;
    }
    
    @media (max-width: 768px) {
        .stat-card {
            padding: 1rem !important;
        }
        .stat-icon {
            width: 48px;
            height: 48px;
        }
        .welcome-banner {
            min-height: 160px;
        }
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    <!-- Welcome Banner with Background Image -->
    <div class="welcome-banner text-white mb-4 shadow">
        <div class="welcome-banner-bg" style="background-image: url('{{ asset('images/dashboard-bg.jpg') }}');"></div>
        <div class="welcome-content p-4 p-md-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="h3 fw-bold mb-2">
                        Selamat Datang, {{ auth()->user()->name }}!
                    </h1>
                    <p class="mb-0 opacity-90">
                        {{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY') }} • 
                        Semoga hari Anda menyenangkan
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-3 g-md-4 mb-4">
        <!-- Total Berita -->
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-white p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2 fw-medium">Total Berita</p>
                        <h2 class="h3 fw-bold mb-1">{{ $stats['news'] ?? 0 }}</h2>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>
                            {{ $stats['news_published'] ?? 0 }} Terbit
                        </small>
                    </div>
                    <div class="stat-icon bg-primary bg-opacity-10">
                        <i class="fas fa-newspaper text-primary fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Events -->
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-white p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2 fw-medium">Total Events</p>
                        <h2 class="h3 fw-bold mb-1">{{ $stats['events'] ?? 0 }}</h2>
                        <small class="text-warning">
                            <i class="fas fa-calendar me-1"></i>
                            {{ $stats['events_upcoming'] ?? 0 }} Akan Datang
                        </small>
                    </div>
                    <div class="stat-icon bg-warning bg-opacity-10">
                        <i class="fas fa-calendar-alt text-warning fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Users -->
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-white p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2 fw-medium">Total Users</p>
                        <h2 class="h3 fw-bold mb-1">{{ $stats['users'] ?? 0 }}</h2>
                        <small class="text-success">
                            <i class="fas fa-user-check me-1"></i>
                            {{ $stats['users_active'] ?? 0 }} Aktif
                        </small>
                    </div>
                    <div class="stat-icon bg-success bg-opacity-10">
                        <i class="fas fa-users text-success fs-4"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Dokumen -->
        <div class="col-6 col-lg-3">
            <div class="stat-card bg-white p-3 p-md-4 h-100">
                <div class="d-flex justify-content-between align-items-start">
                    <div>
                        <p class="text-muted small mb-2 fw-medium">Total Dokumen</p>
                        <h2 class="h3 fw-bold mb-1">{{ $stats['documents'] ?? 0 }}</h2>
                        <small class="text-info">
                            <i class="fas fa-download me-1"></i>
                            {{ $stats['downloads'] ?? 0 }} Downloads
                        </small>
                    </div>
                    <div class="stat-icon bg-info bg-opacity-10">
                        <i class="fas fa-file-alt text-info fs-4"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Actions -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Quick Actions
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.news.create') }}" class="quick-action-btn text-decoration-none">
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-plus text-primary fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Tambah Berita</div>
                                    <small class="text-muted">Buat artikel baru</small>
                                </div>
                            </div>
                        </a>

                        <a href="{{ route('admin.events.create') }}" class="quick-action-btn text-decoration-none">
                            <div class="d-flex align-items-center">
                                <div class="bg-warning bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-calendar-plus text-warning fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Tambah Event</div>
                                    <small class="text-muted">Buat event baru</small>
                                </div>
                            </div>
                        </a>

                        @if(auth()->user()->isSuperAdmin())
                        <a href="{{ route('admin.users.create') }}" class="quick-action-btn text-decoration-none">
                            <div class="d-flex align-items-center">
                                <div class="bg-success bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-user-plus text-success fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Tambah User</div>
                                    <small class="text-muted">Buat akun baru</small>
                                </div>
                            </div>
                        </a>
                        @endif

                        <a href="{{ route('admin.documents.create') }}" class="quick-action-btn text-decoration-none">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 rounded p-3 me-3">
                                    <i class="fas fa-upload text-info fs-5"></i>
                                </div>
                                <div>
                                    <div class="fw-semibold text-dark">Upload Dokumen</div>
                                    <small class="text-muted">Upload file baru</small>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent News -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-newspaper text-primary me-2"></i>
                            Berita Terbaru
                        </h5>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-sm btn-outline-primary">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($recentNews ?? [] as $news)
                    <a href="{{ route('admin.news.edit', $news) }}" class="activity-card p-3 mb-3 d-block text-decoration-none">
                        <div class="d-flex gap-3">
                            @if($news->featured_image)
                                <img src="{{ asset('storage/' . $news->featured_image) }}" 
                                     class="rounded" style="width: 60px; height: 60px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                            <div class="flex-grow-1 min-w-0">
                                <p class="fw-semibold text-dark mb-1 text-truncate">
                                    {{ $news->title }}
                                </p>
                                <small class="text-muted d-block">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $news->published_at?->diffForHumans() ?? 'Draft' }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-eye me-1"></i>
                                    {{ $news->views }} views
                                </small>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-inbox text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted small mb-0">Belum ada berita</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Upcoming Events -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-0 pt-4 pb-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-calendar-alt text-warning me-2"></i>
                            Event Mendatang
                        </h5>
                        <a href="{{ route('admin.events.index') }}" class="btn btn-sm btn-outline-warning">
                            Lihat Semua
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @forelse($upcomingEvents ?? [] as $event)
                    <a href="{{ route('admin.events.edit', $event) }}" class="activity-card p-3 mb-3 d-block text-decoration-none">
                        <div class="d-flex gap-3">
                            <div class="bg-warning bg-opacity-10 rounded p-3 d-flex flex-column align-items-center justify-content-center" 
                                 style="min-width: 60px;">
                                <div class="fw-bold text-warning" style="font-size: 1.5rem; line-height: 1;">
                                    {{ $event->start_date->format('d') }}
                                </div>
                                <small class="text-warning fw-semibold">
                                    {{ $event->start_date->format('M') }}
                                </small>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <p class="fw-semibold text-dark mb-1 text-truncate">
                                    {{ $event->title }}
                                </p>
                                <small class="text-muted d-block">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $event->start_time }} - {{ $event->end_time }}
                                </small>
                                <small class="text-muted d-block text-truncate">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $event->location }}
                                </small>
                            </div>
                        </div>
                    </a>
                    @empty
                    <div class="text-center py-4">
                        <i class="fas fa-calendar-times text-muted mb-2" style="font-size: 2rem;"></i>
                        <p class="text-muted small mb-0">Belum ada event</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection