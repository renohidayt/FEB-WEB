@extends('admin.layouts.app')

@section('title', 'Detail Event')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.events.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div class="flex-grow-1">
            <h1 class="h3 fw-bold mb-1">Detail Event</h1>
            <p class="text-muted mb-0">Informasi lengkap event</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i>Edit
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <h2 class="h4 mb-2">{{ $event->title }}</h2>
                            <span class="badge {{ $event->status == 'published' ? 'bg-success' : 'bg-secondary' }} px-3 py-2">
                                <i class="fas fa-{{ $event->status == 'published' ? 'check-circle' : 'edit' }} me-1"></i>
                                {{ ucfirst($event->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card-body p-4">
                    <!-- Info Grid -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-primary bg-opacity-10 rounded p-3">
                                            <i class="fas fa-calendar text-primary fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-1">Tanggal</p>
                                            <p class="fw-bold mb-0">{{ $event->formatted_date }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-info bg-opacity-10 rounded p-3">
                                            <i class="fas fa-clock text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-1">Jam</p>
                                            <p class="fw-bold mb-0">{{ $event->formatted_time }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-danger bg-opacity-10 rounded p-3">
                                            <i class="fas fa-map-marker-alt text-danger fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-1">Tempat</p>
                                            <p class="fw-bold mb-0">{{ $event->location }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-success bg-opacity-10 rounded p-3">
                                            <i class="fas fa-users text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <p class="text-muted small mb-1">Penyelenggara</p>
                                            <p class="fw-bold mb-0">{{ $event->organizer }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Peserta -->
                    @if($event->participants)
                    <div class="mb-4">
                        <label class="small text-muted fw-semibold mb-2">
                            <i class="fas fa-user-friends me-1"></i>Peserta
                        </label>
                        <p class="mb-0">{{ $event->participants }}</p>
                    </div>
                    @endif

                    <!-- URL -->
                    @if($event->url)
                    <div class="mb-4">
                        <label class="small text-muted fw-semibold mb-2">
                            <i class="fas fa-link me-1"></i>URL/Link
                        </label>
                        <p class="mb-0">
                            <a href="{{ $event->url }}" target="_blank" class="text-decoration-none">
                                {{ $event->url }} <i class="fas fa-external-link-alt small"></i>
                            </a>
                        </p>
                    </div>
                    @endif

                    <!-- Keywords -->
                    @if($event->keywords)
                    <div class="mb-4">
                        <label class="small text-muted fw-semibold mb-2">
                            <i class="fas fa-tags me-1"></i>Kata Kunci
                        </label>
                        <div>
                            @foreach(explode(',', $event->keywords) as $keyword)
                                <span class="badge bg-info me-1 mb-1">{{ trim($keyword) }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    <!-- Deskripsi -->
                    <div class="mb-4">
                        <label class="small text-muted fw-semibold mb-2">
                            <i class="fas fa-align-left me-1"></i>Deskripsi
                        </label>
                        <div class="card bg-light border-0">
                            <div class="card-body">
                                <p class="mb-0" style="white-space: pre-wrap;">{{ $event->description }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Status Event -->
                    <div class="mb-4">
                        <label class="small text-muted fw-semibold mb-2">
                            <i class="fas fa-info-circle me-1"></i>Status Event
                        </label>
                        <div>
                            @if($event->isOngoing())
                                <span class="badge bg-primary px-3 py-2">
                                    <i class="fas fa-circle-notch fa-spin me-1"></i>Sedang Berlangsung
                                </span>
                            @elseif($event->start_date > now())
                                <span class="badge bg-warning text-dark px-3 py-2">
                                    <i class="fas fa-clock me-1"></i>Akan Datang
                                </span>
                            @else
                                <span class="badge bg-secondary px-3 py-2">
                                    <i class="fas fa-check me-1"></i>Sudah Selesai
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Meta Info -->
                    <div class="row g-3 pt-3 border-top">
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar-plus me-1"></i>
                                Dibuat: {{ $event->created_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">
                                <i class="fas fa-calendar-check me-1"></i>
                                Diupdate: {{ $event->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Poster -->
            @if($event->poster)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-image text-primary me-2"></i>Poster Event
                    </h5>
                </div>
                <div class="card-body p-0">
                    <img src="{{ Storage::url($event->poster) }}" alt="{{ $event->title }}" class="img-fluid w-100">
                </div>
            </div>
            @endif

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>Aksi Cepat
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit Event
                        </a>
                        @if(isset($event->slug))
                        <a href="{{ route('events.show', $event->slug) }}" target="_blank" class="btn btn-info">
                            <i class="fas fa-eye me-2"></i>Lihat di Website
                        </a>
                        @endif
                        <hr class="my-2">
                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" 
                              onsubmit="return confirm('⚠️ Yakin ingin menghapus event ini?\n\nTindakan tidak dapat dibatalkan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Event
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection