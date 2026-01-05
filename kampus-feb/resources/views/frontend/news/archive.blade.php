@extends('layouts.app')

@section('title', 'Arsip Berita - FEB UNSAP')

@section('content')
{{-- Load Font & Icon --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div style="font-family: 'Poppins', sans-serif;" class="bg-slate-50 min-h-screen">
    
    {{-- 1. HERO SECTION (MENGIKUTI GAYA WARTA) --}}
    @php
        $firstNews = $news->first();
        $heroImage = ($firstNews && $firstNews->featured_image) 
                     ? Storage::url($firstNews->featured_image) 
                     : 'https://images.unsplash.com/photo-1506784919141-177b7ec30a6c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1470&q=80';
        
        $monthNames = [1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'];
    @endphp

    <div class="relative h-[550px] md:h-[700px] overflow-hidden flex items-center">
        
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <div class="absolute inset-0 bg-black/40"></div>

            <img src="{{ $heroImage }}" class="w-full h-full object-cover" alt="Hero Background">
            {{-- Gradient Gelap di kiri agar teks putih kontras --}}
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900 via-slate-900/60 to-transparent"></div>
            {{-- Gradient halus dari bawah --}}
            <div class="absolute inset-0 bg-gradient-to-t from-slate-50 via-transparent to-transparent opacity-50"></div>
        </div>

        {{-- Decor Blobs (Elemen Estetik) --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        <div class="absolute bottom-1/4 left-0 -ml-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
        
        <div class="container mx-auto px-6 md:px-12 relative z-10 h-full flex flex-col">
            
            {{-- NAVIGASI (BREADCRUMB) --}}
            <nav class="pt-10 mb-auto animate-fade-in"> 
                <div class="flex items-center text-sm font-medium">
                    <a href="{{ url('/') }}" class="text-slate-300 hover:text-white transition-colors flex items-center gap-2 group">
                        <i class="fas fa-home text-orange-500"></i> 
                        <span>Beranda</span>
                    </a>
                    <span class="mx-3 text-slate-500">/</span>
                    <a href="{{ route('news.index') }}" class="text-slate-300 hover:text-white transition-colors">Berita</a>
                    <span class="mx-3 text-slate-500">/</span>
                    <span class="text-orange-500 font-semibold uppercase tracking-wider text-xs">Arsip</span>
                </div>
            </nav>

            {{-- KONTEN UTAMA (KIRI) --}}
            <div class="mb-auto pb-20">
                <div class="max-w-3xl animate-fade-in-left">
                    <h1 class="text-5xl md:text-7xl font-extrabold text-white mb-6 tracking-tight leading-tight uppercase">
                        Arsip <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Berita Kami</span>
                    </h1>
                    
                    {{-- Decorative Bar --}}
                    <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>

                    @if($selectedYear && $selectedMonth)
                        <div class="inline-flex items-center px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-xl mb-4">
                            <i class="far fa-calendar-alt text-orange-400 mr-3"></i>
                            <p class="text-lg md:text-xl text-slate-100 font-light">
                                Periode: <span class="font-bold text-white">{{ $monthNames[$selectedMonth] }} {{ $selectedYear }}</span>
                            </p>
                        </div>
                    @else
                        <p class="text-lg md:text-xl text-slate-200 font-light leading-relaxed max-w-xl">
                            Menelusuri kembali jejak informasi dan dokumentasi kegiatan Fakultas Ekonomi dan Bisnis dari waktu ke waktu.
                        </p>
                    @endif
                </div>
            </div>

        </div>
    </div>

    {{-- 2. MAIN CONTENT AREA (DI BAWAH BANNER) --}}
    <div class="bg-slate-50 py-16">
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
                                class="w-full pl-4 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent text-sm">
                            <button class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <i class="fas fa-search"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Arsip Selector --}}
                    <div class="bg-white rounded-xl p-5 shadow-sm border border-slate-200">
                        <h3 class="text-xs font-bold text-slate-800 mb-4 uppercase tracking-widest">Pilih Periode</h3>
                        <select onchange="if(this.value) window.location.href=this.value" 
                                class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg text-sm text-slate-600 focus:ring-2 focus:ring-orange-500 appearance-none cursor-pointer">
                            <option value="">-- Pilih Bulan & Tahun --</option>
                            @foreach($archives as $archive)
                            <option value="{{ route('news.archive', ['year' => $archive->year, 'month' => $archive->month]) }}"
                                {{ ($selectedYear == $archive->year && $selectedMonth == $archive->month) ? 'selected' : '' }}>
                                {{ $monthNames[$archive->month] }} {{ $archive->year }} ({{ $archive->count }})
                            </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Kategori (Tema Dark) --}}
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
                </aside>

                {{-- LIST BERITA ARSIP --}}
                <div class="lg:col-span-3">
                    @if($news->count() > 0)
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($news as $item)
                        <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-md transition-all group flex flex-col h-full">
                            {{-- Image --}}
                            <div class="relative h-52 overflow-hidden">
                                <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                                    loading="lazy">
                                <div class="absolute top-4 left-4">
                                    <span class="bg-orange-600 text-white text-[10px] font-bold px-3 py-1 rounded shadow-lg uppercase">
                                        {{ $item->category->name }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-1">
                                <div class="flex items-center gap-3 text-[11px] text-slate-400 mb-3 font-medium uppercase">
                                    <span><i class="far fa-calendar-alt text-orange-500 mr-1"></i> {{ $item->published_at->translatedFormat('d M Y') }}</span>
                                    <span><i class="far fa-eye text-orange-500 mr-1"></i> {{ number_format($item->views) }}</span>
                                </div>
                                <h3 class="text-lg font-bold text-slate-800 mb-3 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">
                                    <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                                </h3>
                                <p class="text-slate-500 text-sm line-clamp-2 mb-5 leading-relaxed flex-1">
                                    {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 100) }}
                                </p>
                                <div class="pt-4 border-t border-slate-100 mt-auto">
                                    <a href="{{ route('news.show', $item->slug) }}" class="text-orange-600 font-bold text-xs uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
                                        Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    {{-- Pagination (Limit 10 per hal diatur via controller) --}}
                    <div class="mt-12 flex justify-center">
                        {{ $news->links() }}
                    </div>

                    @else
                    {{-- State Jika Kosong --}}
                    <div class="bg-white rounded-xl p-16 text-center border border-slate-200 shadow-sm">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="fas fa-archive text-3xl text-slate-300"></i>
                        </div>
                        <h2 class="text-xl font-bold text-slate-800 mb-2">Tidak Ada Berita</h2>
                        <p class="text-slate-500 font-medium max-w-xs mx-auto mb-6">Maaf, tidak ada berita yang ditemukan pada periode ini.</p>
                        <a href="{{ route('news.index') }}" class="bg-slate-900 text-white px-8 py-3 rounded-lg font-bold text-sm hover:bg-orange-600 transition-colors">Lihat Berita Terbaru</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Styling khusus untuk Laravel Pagination Tailwind */
    .pagination { @apply flex items-center gap-1; }
    nav[role="navigation"] svg { @apply w-5 h-5; }
    nav[role="navigation"] span, nav[role="navigation"] a { 
        @apply rounded-lg border border-slate-200 text-slate-600 font-bold px-4 py-2 hover:bg-orange-500 hover:text-white hover:border-orange-500 transition-all text-sm; 
    }
    nav[role="navigation"] .bg-white { @apply bg-orange-600 border-orange-600 text-white shadow-md; }
    
    .animate-fade-in { animation: fadeIn 1s ease-out forwards; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection