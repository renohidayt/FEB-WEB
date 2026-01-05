@extends('admin.layouts.app')

@section('title', 'Detail Berita')

@push('styles')
<style>
    .gallery-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 1rem;
    }
    
    .gallery-grid img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #e5e7eb;
    }
    
    .gallery-grid img:hover {
        transform: scale(1.05);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        border-color: #0d6efd;
    }
    
    .prose {
        max-width: none;
    }
    
    .prose img {
        border-radius: 12px;
        margin: 1.5rem 0;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-4 gap-3">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('admin.news.index') }}" class="btn btn-light">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="h3 fw-bold mb-1">Detail Berita</h1>
                <p class="text-muted mb-0">Preview dan informasi lengkap berita</p>
            </div>
        </div>
        
        <div class="d-flex gap-2">
            <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary shadow-sm">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="btn btn-outline-secondary">
                <i class="fas fa-external-link-alt me-2"></i>Lihat
            </a>
        </div>
    </div>

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Article Card -->
            <div class="card border-0 shadow-sm mb-4">
                @if($news->featured_image)
                <div class="position-relative">
                    <img src="{{ asset('storage/' . $news->featured_image) }}" 
                         class="card-img-top" style="height:400px;object-fit:cover">
                    
                    <div class="position-absolute top-0 end-0 m-3">
                        @if($news->is_published)
                            <span class="badge bg-success px-3 py-2 fs-6">
                                <i class="fas fa-check-circle me-1"></i>Published
                            </span>
                        @else
                            <span class="badge bg-secondary px-3 py-2 fs-6">
                                <i class="fas fa-pencil-alt me-1"></i>Draft
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                <div class="card-body p-4">
                    <h2 class="display-6 fw-bold mb-4">{{ $news->title }}</h2>

                    <!-- Meta Info -->
                    <div class="d-flex flex-wrap gap-3 mb-4 pb-4 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="width:40px;height:40px">
                                <i class="fas fa-user text-primary"></i>
                            </div>
                            <div>
                                <strong>{{ $news->author_display_name }}</strong>
                                @if($news->author_name)
                                    <small class="d-block text-primary">Custom Author</small>
                                @endif
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-calendar text-muted"></i>
                            <span>{{ $news->published_at ? $news->published_at->format('d M Y, H:i') : 'Belum dipublikasi' }}</span>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-eye text-muted"></i>
                            <span>{{ number_format($news->views) }} views</span>
                        </div>
                        
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-clock text-muted"></i>
                            <span>{{ $news->reading_time }} menit</span>
                        </div>
                    </div>

                    <!-- Tags -->
                    <div class="d-flex flex-wrap gap-2 mb-4">
                        @if($news->category)
                            <span class="badge bg-primary bg-opacity-10 text-primary px-3 py-2">
                                <i class="fas fa-tag me-1"></i>{{ $news->category->name }}
                            </span>
                        @endif
                        
                        @if($news->show_on_homepage)
                            <span class="badge bg-warning text-dark px-3 py-2">
                                <i class="fas fa-star me-1"></i>Featured di Beranda
                            </span>
                        @endif
                        
                        @if($news->allow_comments)
                         
                        @endif
                    </div>

                    <!-- Excerpt -->
                    @if($news->excerpt)
                    <div class="alert alert-primary border-start border-4 border-primary mb-4">
                        <div class="d-flex gap-3">
                            <i class="fas fa-file-alt fs-5"></i>
                            <div>
                                <strong>Ringkasan</strong>
                                <p class="mb-0 mt-1">{{ $news->excerpt }}</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Content -->
                    <div class="prose">
                        {!! $news->content !!}
                    </div>
                </div>
            </div>

            <!-- Gallery -->
            @if($news->images && $news->images->count() > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-primary bg-opacity-10 rounded p-2">
                            <i class="fas fa-images text-primary fs-4"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-0">Galeri Foto</h3>
                            <small class="text-muted">{{ $news->images->count() }} foto</small>
                        </div>
                    </div>
                    
                    <div class="gallery-grid">
                        @foreach($news->images as $image)
                            <div>
                                <img src="{{ asset('storage/' . $image->image_path) }}" 
                                     alt="{{ $image->caption ?: 'Gallery Image' }}"
                                     onclick="window.open(this.src, '_blank')">
                                @if($image->caption)
                                    <p class="small text-muted mt-2 mb-0">{{ $image->caption }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- SEO Preview -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <div class="bg-success bg-opacity-10 rounded p-2">
                            <i class="fas fa-search text-success fs-4"></i>
                        </div>
                        <div>
                            <h3 class="h5 mb-0">SEO Preview</h3>
                            <small class="text-muted">Tampilan di hasil pencarian</small>
                        </div>
                    </div>
                    
                    <div class="border rounded p-3 bg-light">
                        <p class="text-primary h5 mb-2">{{ $news->meta_title ?: $news->title }}</p>
                        <p class="text-success small mb-2">
                            <i class="fas fa-link me-1"></i>{{ url('/news/' . $news->slug) }}
                        </p>
                        <p class="text-muted small mb-0">
                            {{ $news->meta_description ?: $news->excerpt ?: Str::limit(strip_tags($news->content), 160) }}
                        </p>
                        
                        @if($news->meta_keywords)
                        <div class="mt-3 pt-3 border-top">
                            <small class="text-muted fw-bold d-block mb-2">Keywords:</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach(explode(',', $news->meta_keywords) as $keyword)
                                    <span class="badge bg-white border text-dark">{{ trim($keyword) }}</span>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-bolt text-primary me-2"></i>Quick Actions
                    </h5>
                    
                    <div class="d-grid gap-2">
                        <form action="{{ route('admin.news.publish', $news) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-secondary w-100 text-start">
                                @if($news->is_published)
                                    <i class="fas fa-pencil-alt me-2"></i>Jadikan Draft
                                @else
                                    <i class="fas fa-check-circle me-2"></i>Publikasikan
                                @endif
                            </button>
                        </form>
                        
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-edit me-2"></i>Edit Berita
                        </a>
                        
                        <a href="{{ route('news.show', $news->slug) }}" target="_blank" class="btn btn-outline-secondary text-start">
                            <i class="fas fa-eye me-2"></i>Lihat di Website
                        </a>
                        
                        <hr>
                        
                        <form action="{{ route('admin.news.destroy', $news) }}" method="POST" 
                              onsubmit="return confirm('⚠️ Yakin ingin menghapus berita ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100 text-start">
                                <i class="fas fa-trash me-2"></i>Hapus Berita
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Statistics -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-chart-bar text-primary me-2"></i>Statistik
                    </h5>
                    
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted">Total Views</span>
                        <strong class="fs-4">{{ number_format($news->views) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted">Reading Time</span>
                        <strong class="fs-4">{{ $news->reading_time }}<small class="text-muted"> min</small></strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted">Words</span>
                        <strong class="fs-4">{{ number_format(str_word_count(strip_tags($news->content))) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3 border-bottom">
                        <span class="text-muted">Characters</span>
                        <strong class="fs-4">{{ number_format(strlen(strip_tags($news->content))) }}</strong>
                    </div>
                    <div class="d-flex justify-content-between align-items-center py-3">
                        <span class="text-muted">Gallery Images</span>
                        <strong class="fs-4">{{ $news->images->count() }}</strong>
                    </div>
                </div>
            </div>

            <!-- Timeline -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-clock text-primary me-2"></i>Timeline
                    </h5>
                    
                    <div class="position-relative ps-4 border-start border-2 border-primary">
                        <div class="mb-4">
                            <div class="position-absolute bg-primary rounded-circle" 
                                 style="width:12px;height:12px;left:-7px;top:4px"></div>
                            <small class="text-muted d-block">Dibuat</small>
                            <strong>{{ $news->created_at->format('d M Y, H:i') }}</strong>
                            <small class="text-muted d-block">{{ $news->created_at->diffForHumans() }}</small>
                        </div>
                        
                        <div class="mb-4">
                            <div class="position-absolute bg-primary rounded-circle" 
                                 style="width:12px;height:12px;left:-7px;top:auto"></div>
                            <small class="text-muted d-block">Terakhir Update</small>
                            <strong>{{ $news->updated_at->format('d M Y, H:i') }}</strong>
                            <small class="text-muted d-block">{{ $news->updated_at->diffForHumans() }}</small>
                        </div>
                        
                        @if($news->published_at)
                        <div>
                            <div class="position-absolute bg-success rounded-circle" 
                                 style="width:12px;height:12px;left:-7px;top:auto"></div>
                            <small class="text-muted d-block">Dipublikasikan</small>
                            <strong>{{ $news->published_at->format('d M Y, H:i') }}</strong>
                            <small class="text-muted d-block">{{ $news->published_at->diffForHumans() }}</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Author Info -->
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h5 class="fw-bold mb-3">
                        <i class="fas fa-user text-primary me-2"></i>Penulis
                    </h5>
                    
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-gradient rounded-circle text-white d-flex align-items-center justify-center fw-bold" 
                             style="width:60px;height:60px;background:linear-gradient(135deg,#667eea 0%,#764ba2 100%)">
                            {{ substr($news->author_display_name, 0, 1) }}
                        </div>
                        <div class="flex-grow-1">
                            <strong class="d-block">{{ $news->author_display_name }}</strong>
                            @if($news->author_name)
                                <span class="badge bg-primary bg-opacity-10 text-primary small">
                                    <i class="fas fa-check-circle me-1"></i>Custom Author
                                </span>
                            @elseif($news->author)
                                <small class="text-muted">{{ $news->author->email }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection