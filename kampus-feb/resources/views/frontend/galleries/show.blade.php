@extends('layouts.app')

@section('title', $album->name . ' - Galeri FEB UNSAP')

@section('content')
{{-- Load External Assets --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Force Font Poppins */
    .font-poppins-all { font-family: 'Poppins', sans-serif !important; }
    
    /* Animasi Blob Background */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }

    /* Sticky Sidebar Wrapper */
    .sticky-wrapper {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 2rem; /* Jarak dari atas layar */
        z-index: 30;
    }

    /* Hide Scrollbar for filter overflow */
    .no-scrollbar::-webkit-scrollbar { display: none; }
    .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<div class="font-poppins-all bg-slate-50 min-h-screen flex flex-col">

    {{-- 1. HERO SECTION (Banner Style) --}}
    <div class="relative h-[400px] lg:h-[450px] w-full bg-slate-900 overflow-hidden">
        {{-- Background Image / Pattern --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $album->cover_url }}" alt="{{ $album->name }}" class="w-full h-full object-cover opacity-40 blur-[4px] scale-105">
            {{-- Gradient agar teks terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/50 to-transparent"></div>
            {{-- Decorative Blobs --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
        </div>

        {{-- Content Hero --}}
       <div class="container mx-auto px-6 relative z-10 h-full flex flex-col justify-center pb-8">
    {{-- Breadcrumb --}}
    <nav class="absolute top-8 left-6 md:left-6 flex items-center text-sm font-medium">
        
        {{-- Level 1: Beranda --}}
        <a href="{{ route('home') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
            <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
            <span class=" decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
        </a>

        {{-- Separator --}}
        <span class="mx-3 text-slate-600">/</span>

        {{-- Level 2: Galeri (Link Kembali) --}}
        <a href="{{ route('galleries.index') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
            <span class=" decoration-orange-500 decoration-2 underline-offset-4">Galeri</span>
        </a>

        {{-- Separator --}}
        <span class="mx-3 text-slate-600">/</span>

        {{-- Level 3: Nama Album (Aktif) --}}
        <span class="text-orange-500 font-semibold cursor-default truncate max-w-[200px]" title="{{ $album->name }}">
            {{ $album->name }}
        </span>
        
    </nav>

    {{-- Sisa konten hero section Anda di sini... --}}


            <div class="max-w-4xl mt-12">
                {{-- Date Badge --}}
                @if($album->date)
                <div class="mb-4">
                     <span class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600/90 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg border border-orange-500/50 backdrop-blur-md">
                        <i class="far fa-calendar-alt"></i> {{ $album->date->format('d F Y') }}
                    </span>
                </div>
                @endif

                {{-- Title --}}
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-4 tracking-tight drop-shadow-sm">
                    {{ $album->name }}
                </h1>

                {{-- Description (Short) --}}
                @if($album->description)
                    <p class="text-slate-300 text-sm md:text-base max-w-2xl leading-relaxed line-clamp-2">
                        {{ $album->description }}
                    </p>
                @endif
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT --}}
    <div class="container mx-auto px-4 py-12 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT COLUMN: Media Grid (8 Cols) --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Filter Tabs --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-2 flex overflow-x-auto no-scrollbar">
                    <button onclick="filterMedia('all')" class="filter-btn active flex-1 min-w-[100px] px-6 py-3 rounded-xl text-sm font-bold transition-all text-center">
                        <i class="fas fa-th mr-2"></i>Semua
                    </button>
                    <button onclick="filterMedia('photo')" class="filter-btn flex-1 min-w-[100px] px-6 py-3 rounded-xl text-sm font-bold transition-all text-center">
                        <i class="fas fa-camera mr-2"></i>Foto
                    </button>
                    <button onclick="filterMedia('video')" class="filter-btn flex-1 min-w-[100px] px-6 py-3 rounded-xl text-sm font-bold transition-all text-center">
                        <i class="fas fa-video mr-2"></i>Video
                    </button>
                </div>

                {{-- Media Grid --}}
                @if($album->media->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4" id="mediaGrid">
                        @foreach($album->media as $media)
                            <div class="media-item group {{ $media->type }} relative aspect-square" data-type="{{ $media->type }}">
                                <div class="w-full h-full rounded-xl overflow-hidden bg-slate-200 shadow-sm border border-slate-100 hover:shadow-xl hover:shadow-orange-500/20 transition-all duration-500 relative cursor-pointer"
                                     onclick="{{ $media->type === 'photo' ? 'openLightbox('.$loop->index.')' : '' }}">
                                    
                                    @if($media->type === 'photo')
                                        <img 
                                            src="{{ asset('storage/' . $media->file_path) }}" 
                                            alt="{{ $media->title }}"
                                            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                            loading="lazy"
                                        >
                                        {{-- Overlay Hover --}}
                                        <div class="absolute inset-0 bg-slate-900/40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[1px]">
                                            <i class="fas fa-search-plus text-white text-2xl transform scale-0 group-hover:scale-100 transition-transform"></i>
                                        </div>
                                    @else
                                        <video 
                                            src="{{ asset('storage/' . $media->file_path) }}"
                                            class="absolute inset-0 w-full h-full object-cover"
                                            controls
                                        ></video>
                                    @endif

                                    {{-- Type Icon Badge --}}
                                    <div class="absolute top-2 right-2">
                                        @if($media->type === 'photo')
                                            <span class="w-7 h-7 bg-black/50 backdrop-blur rounded-full flex items-center justify-center text-white text-[10px]">
                                                <i class="fas fa-camera"></i>
                                            </span>
                                        @else
                                            <span class="w-7 h-7 bg-red-600 rounded-full flex items-center justify-center text-white text-[10px] animate-pulse">
                                                <i class="fas fa-play"></i>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white rounded-xl p-12 text-center border border-dashed border-slate-300">
                        <i class="fas fa-images text-4xl text-slate-300 mb-4"></i>
                        <p class="text-slate-500 font-medium">Belum ada media di album ini.</p>
                    </div>
                @endif
            </div>

            {{-- RIGHT COLUMN: Sticky Sidebar (4 Cols) --}}
            <div class="lg:col-span-4 relative">
                <div class="sticky-wrapper space-y-6">

                    {{-- 2. Stats Card (Sticky) --}}
                    <div class="bg-slate-900 rounded-xl shadow-2xl p-6 text-center relative overflow-hidden">
                        {{-- Decor --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500 rounded-full mix-blend-overlay filter blur-3xl opacity-20"></div>
                        <h3 class="text-sm font-bold text-slate-400 mb-6 uppercase tracking-widest relative z-10">Statistik Album</h3>

                        <div class="grid grid-cols-2 gap-4 relative z-10">
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <i class="fas fa-camera text-orange-500 text-xl mb-2"></i>
                                <p class="text-2xl font-black text-white">{{ $album->photos_count }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Foto</p>
                            </div>
                            <div class="p-4 rounded-xl bg-white/5 border border-white/10">
                                <i class="fas fa-video text-orange-500 text-xl mb-2"></i>
                                <p class="text-2xl font-black text-white">{{ $album->videos_count }}</p>
                                <p class="text-[10px] text-slate-400 uppercase font-bold">Video</p>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Share Card --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 text-center">Bagikan Album</h3>
                        <div class="flex justify-center gap-3">
                            <button onclick="shareLink('wa')" class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-whatsapp"></i>
                            </button>
                            <button onclick="shareLink('fb')" class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-facebook-f"></i>
                            </button>
                            <button onclick="shareLink('tw')" class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-twitter"></i>
                            </button>
                            <button onclick="shareLink('copy')" class="w-10 h-10 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- 3. RELATED ALBUMS --}}
        @if($relatedAlbums->count() > 0)
            <div class="mt-24 pt-10 border-t border-slate-200">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-xs">Dokumentasi Lain</span>
                        <h2 class="text-3xl font-black text-slate-900 mt-1">Album Serupa</h2>
                    </div>
                    <a href="{{ route('galleries.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-orange-600 transition font-bold text-sm">
                        Lihat Semua <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedAlbums as $related)
                        <a href="{{ route('galleries.show', $related->slug) }}" class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ $related->cover_url }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                <div class="absolute top-3 right-3 flex gap-2">
                                     <span class="px-2 py-1 bg-black/50 backdrop-blur rounded-lg text-white text-[10px] font-bold">
                                        <i class="fas fa-camera mr-1"></i>{{ $related->photos_count }}
                                    </span>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-slate-900 mb-2 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                    {{ $related->name }}
                                </h3>
                                <p class="text-xs text-slate-400 line-clamp-2">{{ $related->description }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-3 rounded-full shadow-2xl opacity-0 transition-all duration-300 z-50 flex items-center gap-3 border border-orange-500 pointer-events-none transform translate-y-10">
    <i class="fas fa-check-circle text-orange-500"></i>
    <span class="text-sm font-bold tracking-wide">Link tersalin!</span>
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 bg-slate-950/95 backdrop-blur-sm z-[9999] hidden flex items-center justify-center opacity-0 transition-opacity duration-300">
    <button onclick="closeLightbox()" class="absolute top-6 right-6 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-50">
        <i class="fas fa-times text-xl"></i>
    </button>
    <button onclick="prevImage()" class="absolute left-4 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-50 hidden md:flex">
        <i class="fas fa-chevron-left text-xl"></i>
    </button>
    <button onclick="nextImage()" class="absolute right-4 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition-all z-50 hidden md:flex">
        <i class="fas fa-chevron-right text-xl"></i>
    </button>
    <div class="max-w-6xl w-full h-full flex flex-col items-center justify-center p-4">
        <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl transform scale-95 transition-transform duration-300">
        <p id="lightboxCaption" class="text-slate-300 text-center mt-4 text-lg font-medium"></p>
    </div>
</div>

<script>
    // --- Filter Styling Logic ---
    function filterMedia(type) {
        const items = document.querySelectorAll('.media-item');
        const buttons = document.querySelectorAll('.filter-btn');
        
        // Reset styles
        buttons.forEach(btn => {
            btn.classList.remove('active', 'bg-slate-900', 'text-white', 'shadow-lg');
            btn.classList.add('bg-white', 'text-slate-600', 'hover:bg-slate-50');
        });
        
        // Active Style
        event.currentTarget.classList.remove('bg-white', 'text-slate-600', 'hover:bg-slate-50');
        event.currentTarget.classList.add('active', 'bg-slate-900', 'text-white', 'shadow-lg');
        
        // Show/Hide Items
        items.forEach(item => {
            if (type === 'all' || item.dataset.type === type) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    // --- Share Logic ---
    function shareLink(platform) {
        const url = encodeURIComponent(window.location.href);
        const text = encodeURIComponent('Lihat album dokumentasi: {{ $album->name }}');
        
        if(platform === 'wa') window.open(`https://wa.me/?text=${text}%0A${url}`, '_blank');
        if(platform === 'fb') window.open(`https://www.facebook.com/sharer/sharer.php?u=${url}`, '_blank');
        if(platform === 'tw') window.open(`https://twitter.com/intent/tweet?text=${text}&url=${url}`, '_blank');
        if(platform === 'copy') {
            navigator.clipboard.writeText(window.location.href).then(() => {
                const toast = document.getElementById('toast');
                toast.classList.remove('opacity-0', 'translate-y-10');
                setTimeout(() => toast.classList.add('opacity-0', 'translate-y-10'), 3000);
            });
        }
    }

    // --- Lightbox Data & Logic ---
    const photos = @json($album->media->where('type', 'photo')->values()->map(function($media) {
        return ['url' => asset('storage/' . $media->file_path), 'title' => $media->title];
    }));
    let currentIndex = 0;
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImage');

    function openLightbox(index) {
        if (!photos.length) return;
        currentIndex = index;
        updateLightboxContent();
        lightbox.classList.remove('hidden');
        setTimeout(() => {
            lightbox.classList.remove('opacity-0');
            lightboxImg.classList.remove('scale-95');
            lightboxImg.classList.add('scale-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeLightbox() {
        lightbox.classList.add('opacity-0');
        lightboxImg.classList.remove('scale-100');
        lightboxImg.classList.add('scale-95');
        setTimeout(() => lightbox.classList.add('hidden'), 300);
        document.body.style.overflow = 'auto';
    }

    function updateLightboxContent() {
        if (photos[currentIndex]) {
            lightboxImg.src = photos[currentIndex].url;
            document.getElementById('lightboxCaption').textContent = photos[currentIndex].title || '';
        }
    }

    function nextImage() { currentIndex = (currentIndex + 1) % photos.length; updateLightboxContent(); }
    function prevImage() { currentIndex = (currentIndex - 1 + photos.length) % photos.length; updateLightboxContent(); }

    document.addEventListener('keydown', e => {
        if (!lightbox.classList.contains('hidden')) {
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === 'Escape') closeLightbox();
        }
    });

    // Init: Set first filter active
    document.addEventListener('DOMContentLoaded', () => {
        const firstBtn = document.querySelector('.filter-btn');
        if(firstBtn) firstBtn.classList.add('bg-slate-900', 'text-white', 'shadow-lg');
    });
</script>
@endsection