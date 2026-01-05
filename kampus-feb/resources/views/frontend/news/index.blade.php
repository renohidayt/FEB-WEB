@extends('layouts.app')

@section('title', 'Berita & Informasi - FEB UNSAP')

@section('content')
{{-- Load Font Poppins --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Memastikan seluruh elemen di dalam section ini menggunakan Poppins */
    .font-poppins-all {
        font-family: 'Poppins', sans-serif !important;
    }
    
    /* Pagination Styling agar sesuai tema */
    .pagination { @apply flex justify-center gap-2; }
    .page-item .page-link { @apply rounded-lg border-slate-200 text-slate-600 font-bold px-4 py-2 hover:bg-orange-500 hover:text-white transition-all; }
    .page-item.active .page-link { @apply bg-orange-600 border-orange-600 text-white shadow-md; }

    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
</style>

<div class="font-poppins-all bg-slate-50 min-h-screen">
    
    {{-- 1. DYNAMIC HERO SECTION --}}
    @php
        $firstNews = $news->first();
        $heroImage = ($firstNews && $firstNews->featured_image) 
                     ? Storage::url($firstNews->featured_image) 
                     : 'https://images.unsplash.com/photo-1523050335392-9bef8a56c46b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80';
    @endphp

    <div class="relative h-[550px] md:h-[700px] overflow-hidden flex items-center">
        
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/40"></div>
            <img src="{{ $heroImage }}" class="w-full h-full object-cover" alt="Hero Background">
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/40 to-transparent"></div>
           <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-transparent to-transparent opacity-50"></div>
        </div>

        {{-- Decor Blobs --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        <div class="absolute bottom-1/4 left-0 -ml-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10 h-full flex flex-col">
            
            {{-- NAVIGASI (BREADCRUMB) --}}
            <nav class="pt-10 mb-auto"> 
                <div class="flex items-center text-sm font-medium">
                    <a href="{{ url('/') }}" class="text-slate-300 hover:text-white transition-colors flex items-center gap-2 group">
                        <i class="fas fa-home text-orange-500"></i> 
                        <span>Beranda</span>
                    </a>
                    <span class="mx-3 text-slate-500">/</span>
                    <span class="text-orange-500 font-semibold uppercase tracking-wider text-xs">Berita & Informasi</span>
                </div>
            </nav>

            {{-- KONTEN UTAMA HERO --}}
            <div class="mb-auto pb-20">
                <div class="max-w-3xl">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight uppercase">
                        Warta <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">FEB UNSAP</span>
                    </h1>
                    
                    <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>

                    <p class="text-lg md:text-xl text-slate-200 font-light leading-relaxed max-w-xl">
                        Pusat informasi terkini mengenai kegiatan akademik, prestasi, dan berita resmi universitas di bawah naungan Fakultas Ekonomi dan Bisnis.
                    </p>
                </div>
            </div>
        </div>
    </div>

   {{-- 2. MAIN CONTENT AREA --}}
    <div class="py-16">
        <div class="container mx-auto px-4">
            <div class="grid lg:grid-cols-4 gap-8">
                
                {{-- SIDEBAR --}}
                <aside class="lg:col-span-1 space-y-6">
                    {{-- Search --}}
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                        <h3 class="text-xs font-bold text-slate-800 mb-4 uppercase tracking-widest">Cari Berita</h3>
                        <form action="{{ route('news.index') }}" method="GET" class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Cari..." 
                                class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 text-sm">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Arsip --}}
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                        <h3 class="text-xs font-bold text-slate-800 mb-4 uppercase tracking-widest">Arsip Berita</h3>
                        @php
                            $archives = \App\Models\News::selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as count')
                                ->published()->whereNotNull('published_at')->groupBy('year', 'month')
                                ->orderBy('year', 'desc')->orderBy('month', 'desc')->get();
                            $monthNames = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
                        @endphp
                        
                        <select onchange="if(this.value) window.location.href=this.value" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-orange-500 appearance-none cursor-pointer">
                            <option value="">Pilih Bulan...</option>
                            @foreach($archives as $archive)
                            <option value="{{ route('news.archive', ['year' => $archive->year, 'month' => $archive->month]) }}">
                                {{ $monthNames[$archive->month] }} {{ $archive->year }} ({{ $archive->count }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori --}}
                    <div class="bg-slate-900 rounded-xl p-6 text-white shadow-lg relative overflow-hidden">
                        <h3 class="text-sm font-bold mb-4 uppercase tracking-widest text-orange-500">Kategori</h3>
                        <div class="space-y-2 relative z-10">
                            @foreach($categories as $category)
                            <a href="{{ route('news.index', ['category' => $category->id]) }}" class="flex justify-between items-center py-2 text-sm border-b border-white/5 last:border-0 text-slate-400 hover:text-white transition-colors">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs opacity-50">{{ $category->news_count }}</span>
                            </a>
                            @endforeach
                        </div>
                    </div>

                    {{-- Populer --}}
                    @if($popularNews && $popularNews->count() > 0)
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden">
                        <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-4">
                            <h3 class="font-bold text-white flex items-center gap-2 text-sm uppercase tracking-wider">
                                <i class="fas fa-fire"></i> Populer
                            </h3>
                        </div>
                        <div class="divide-y divide-slate-100">
                            @foreach($popularNews as $popular)
                            <a href="{{ route('news.show', $popular->slug) }}" class="flex gap-3 p-4 hover:bg-orange-50 transition group">
                                @if($popular->featured_image)
                                <img src="{{ Storage::url($popular->featured_image) }}" class="w-14 h-14 object-cover rounded-lg flex-shrink-0">
                                @else
                                <div class="w-14 h-14 bg-slate-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                    <i class="fas fa-image text-slate-300"></i>
                                </div>
                                @endif
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-bold text-xs text-slate-800 line-clamp-2 group-hover:text-orange-600 transition mb-1">
                                        {{ $popular->title }}
                                    </h4>
                                    <div class="flex items-center gap-2 text-[10px] text-slate-400 font-medium">
                                        <span>👁 {{ number_format($popular->views) }}</span>
                                        <span>•</span>
                                        <span>{{ $popular->published_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </aside>

                {{-- LIST BERITA --}}
                <div class="lg:col-span-3">
                    @if($news->count() > 0)
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($news as $item)
                        <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all group">
                            <div class="relative h-52 overflow-hidden">
                                <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-orange-600 text-white text-[10px] font-bold px-3 py-1 rounded shadow-lg uppercase">
                                        {{ $item->category->name }}
                                    </span>
                                </div>
                            </div>

                            <div class="p-6">
                                <div class="flex items-center gap-3 text-[11px] text-slate-400 mb-3 font-medium uppercase">
                                    <span><i class="far fa-calendar-alt text-orange-500 mr-1"></i> {{ $item->published_at->translatedFormat('d M Y') }}</span>
                                    <span><i class="far fa-eye text-orange-500 mr-1"></i> {{ number_format($item->views) }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>
                                <p class="text-slate-500 text-sm line-clamp-2 mb-5 leading-relaxed">
                                    {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 100) }}
                                </p>
                                <a href="{{ route('news.show', $item->slug) }}" class="text-orange-600 font-bold text-xs uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
                                    Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    {{-- Pagination --}}
                    <div class="mt-10">
                        {{ $news->links() }}
                    </div>

                    @else
                    <div class="bg-white rounded-xl p-16 text-center border border-slate-200 shadow-sm">
                        <i class="fas fa-newspaper text-5xl text-slate-200 mb-4"></i>
                        <p class="text-slate-500 font-medium">Tidak ada berita yang ditemukan.</p>
                        <a href="{{ route('news.index') }}" class="text-orange-600 font-bold text-sm mt-4 inline-block underline">Lihat Semua Berita</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection