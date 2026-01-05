@extends('layouts.app')

@section('title', 'Hasil Pencarian - ' . $keyword)

@section('content')
{{-- Load Font Poppins --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<style>
    .font-poppins-all { font-family: 'Poppins', sans-serif !important; }
    
    /* Animation Keyframes */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }

    /* Fade In Animation */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeIn 0.8s ease-out forwards;
    }
</style>

<div class="font-poppins-all bg-white min-h-screen">

  {{-- ========================================================================
   HERO SECTION: CLEAN MINIMALIST (No Card Background)
   ======================================================================== --}}
<div class="relative bg-[#0B1120] text-white py-16 md:py-24 border-b border-white/5 overflow-hidden">
    
    {{-- Background Grid Halus (Tetap dipertahankan agar tidak terlalu kosong, tapi sangat tipis) --}}
    <div class="absolute inset-0 bg-[linear-gradient(to_right,#1f2937_1px,transparent_1px),linear-gradient(to_bottom,#1f2937_1px,transparent_1px)] bg-[size:4rem_4rem] [mask-image:radial-gradient(ellipse_60%_50%_at_50%_0%,#000_70%,transparent_100%)] opacity-10 pointer-events-none"></div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="grid lg:grid-cols-12 gap-12 items-center">
            
            {{-- KOLOM KIRI: Teks & Judul --}}
            <div class="lg:col-span-6 text-left">
                
                {{-- BREADCRUMB: Posisi di atas judul, tidak terlalu mojok ke atas --}}
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-6 -mt-16">

                    <a href="{{ url('/') }}" class="hover:text-white transition-colors flex items-center gap-2">
                <i class="fas fa-home text-orange-500"></i> Beranda
            </a>
                    <span class="text-slate-700">/</span>
                    <span class="text-orange-500">Pencarian</span>
                </nav>

                <h1 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
                    Layanan Pencarian <br>
                    <span class="text-orange-500">Informasi</span>
                </h1>

                <p class="text-slate-400 text-lg leading-relaxed max-w-lg font-light">
                    Telusuri seluruh data dosen, berita kampus, agenda kegiatan, hingga jurnal ilmiah dalam satu akses mudah.
                </p>
            </div>

            {{-- KOLOM KANAN: Search Bar (Floating & Clean) --}}
            <div class="lg:col-span-6">
                
                {{-- TAB KATEGORI (Tanpa Kotak, Hanya Teks/Pill) --}}
             
                {{-- INPUT PENCARIAN UTAMA (Solid White) --}}
                {{-- Tanpa pembungkus card besar, inputnya sendiri yang jadi fokus --}}
                <form action="{{ route('global.search') }}" method="GET" class="relative group">
                    <div class="relative flex items-center">
                        {{-- Icon di dalam input --}}
                        <div class="absolute left-5 text-slate-400">
                            <i class="fas fa-search text-lg"></i>
                        </div>

                        {{-- Input Field --}}
                        <input type="text" name="search" value="{{ $keyword ?? '' }}" 
                               class="w-full pl-14 pr-32 py-5 rounded-xl bg-white text-slate-900 placeholder:text-slate-400 font-medium text-lg shadow-2xl shadow-black/50 border-0 focus:ring-4 focus:ring-orange-500/30 transition-all"
                               placeholder="Cari sesuatu di sini...">

                        {{-- Tombol Cari (Menempel di dalam input sebelah kanan) --}}
                        <div class="absolute right-2">
                            <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-lg font-bold uppercase tracking-wider text-sm transition-all shadow-md">
                                Cari
                            </button>
                        </div>
                    </div>
                </form>

                {{-- TAGS / COBA CARI (Minimalis di bawah input) --}}
              

            </div>

        </div>
    </div>
</div>
    {{-- ========================================================================
       2. MAIN CONTENT (TETAP SAMA SEPERTI SEBELUMNYA)
       ======================================================================== --}}
    <div class="py-16 px-4 container mx-auto">
        
        @php
            $isEmpty = $news->isEmpty() && $lecturers->isEmpty() && $events->isEmpty() && $journals->isEmpty();
        @endphp

        @if($isEmpty)
            {{-- EMPTY STATE --}}
            <div class="text-center py-20 bg-white rounded-2xl w-full border border-slate-100 shadow-sm max-w-4xl mx-auto">
                <div class="flex flex-col items-center">
                    <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                        <i class="fas fa-search text-slate-300 text-4xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">Oops, Hasil Tidak Ditemukan</h3>
                    <p class="text-slate-500 font-medium">Kami tidak menemukan data yang cocok dengan "{{ $keyword }}".</p>
                </div>
            </div>
        @else

            {{-- 
                SECTION A: DOSEN & STAFF
                (Card Dark Mode Premium - Tetap)
            --}}
            @if($lecturers->count() > 0)
            <div class="mb-20 animate-fade-in-up">
                <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-chalkboard-teacher text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Dosen & Staff</h2>
                    </div>
                    <span class="text-xs font-bold bg-slate-100 text-slate-600 px-3 py-1 rounded-full border border-slate-200">{{ $lecturers->count() }} Ditemukan</span>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-8 gap-x-6 justify-items-center">
                    @foreach($lecturers as $lecturer)
                    <a href="{{ route('lecturers.show', $lecturer->slug) }}" class="group block w-full max-w-[280px]">
                        <div class="relative overflow-hidden shadow-xl bg-[#0E1035] rounded-xl border border-white/10 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                            {{-- Vertical Text --}}
                            <div class="absolute inset-y-0 left-0 w-20 z-20 pointer-events-none"
                                 style="background: linear-gradient(to right, rgba(0,0,0,1) 0%, rgba(0,0,0,0.8) 40%, rgba(0,0,0,0.5) 70%, transparent 100%);">
                                <div class="absolute inset-y-0 left-3 flex flex-col justify-between py-4">
                                    <span class="text-white font-serif font-bold text-[1.25rem] opacity-90 group-hover:text-orange-500 transition-all duration-500"
                                          style="writing-mode: vertical-rl; text-orientation: upright; letter-spacing: -0.05em; line-height: 1.05;">
                                        LECTURER
                                    </span>
                                </div>
                            </div>
                            {{-- Image --}}
                            <div class="relative h-64 overflow-hidden bg-slate-800">
                                @if($lecturer->photo_url)
                                    <img src="{{ $lecturer->photo_url }}"
                                         class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110 grayscale-[30%] group-hover:grayscale-0"
                                         onerror="this.src='{{ asset('images/default-lecturer.png') }}'">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-user text-5xl text-slate-600"></i>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                    <span class="bg-orange-600 text-white text-[9px] font-bold px-2 py-1 rounded uppercase">
                                        {{ Str::limit($lecturer->study_program ?? 'Fakultas', 15) }}
                                    </span>
                                </div>
                            </div>
                            {{-- Info --}}
                            <div class="px-4 py-4 text-center border-t border-white/5 bg-[#0B0D2A] relative z-30">
                                <h3 class="font-serif font-bold text-white text-[12px] leading-tight group-hover:text-orange-400 transition-colors line-clamp-1 uppercase">
                                    {{ preg_replace('/^S[1-3]\.?\s*/i', '', $lecturer->full_name ?? $lecturer->name) }}
                                </h3>
                                <p class="text-slate-400 text-[9px] font-serif mt-1 tracking-widest">
                                    NIDN: {{ $lecturer->nidn ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 
                SECTION B: BERITA
                (Card Putih - Tetap)
            --}}
            @if($news->count() > 0)
            <div class="mb-20 animate-fade-in-up">
                <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-orange-600 rounded-lg flex items-center justify-center text-white shadow-md">
                            <i class="far fa-newspaper text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Berita</h2>
                    </div>
                    <span class="text-xs font-bold bg-slate-100 text-slate-600 px-3 py-1 rounded-full border border-slate-200">{{ $news->count() }} Artikel</span>
                </div>

                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($news as $item)
                    <article class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full">
                        <div class="relative h-48 overflow-hidden flex-shrink-0">
                            <img src="{{ $item->featured_image ? Storage::url($item->featured_image) : 'https://via.placeholder.com/400x250' }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute top-3 left-3">
                                <span class="bg-orange-600 text-white text-[9px] font-bold px-2 py-1 rounded shadow-lg uppercase">
                                    {{ $item->category->name ?? 'Umum' }}
                                </span>
                            </div>
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            <div class="flex items-center gap-3 text-[10px] text-slate-400 mb-2 font-medium uppercase">
                                <span><i class="far fa-calendar-alt text-orange-500 mr-1"></i> {{ \Carbon\Carbon::parse($item->published_at)->translatedFormat('d M Y') }}</span>
                            </div>
                            <h3 class="text-base font-bold text-slate-800 mb-2 line-clamp-2 leading-tight group-hover:text-orange-600 transition-colors">
                                <a href="{{ route('news.show', $item->slug) }}">{{ $item->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-xs line-clamp-3 mb-4 leading-relaxed flex-1">
                                {{ $item->excerpt ?? Str::limit(strip_tags($item->content), 100) }}
                            </p>
                            <a href="{{ route('news.show', $item->slug) }}" class="mt-auto text-orange-600 font-bold text-[10px] uppercase tracking-widest flex items-center gap-2 hover:gap-3 transition-all">
                                Baca Selengkapnya <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 
                SECTION C: EVENT
                (Card Event Date Box - Tetap)
            --}}
            @if($events->count() > 0)
            <div class="mb-20 animate-fade-in-up">
                 <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-calendar-alt text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Event</h2>
                    </div>
                    <span class="text-xs font-bold bg-slate-100 text-slate-600 px-3 py-1 rounded-full border border-slate-200">{{ $events->count() }} Kegiatan</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($events as $event)
                    <div class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col overflow-hidden hover:-translate-y-1">
                        <div class="relative h-56 overflow-hidden">
                            @if($event->poster)
                                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                                    <i class="fas fa-calendar-alt text-5xl text-white/10"></i>
                                </div>
                            @endif
                            {{-- Date Box --}}
                            <div class="absolute bottom-3 left-3 bg-white rounded-lg p-2 shadow-xl border border-slate-100 min-w-[50px] text-center">
                                <p class="text-xl font-black text-slate-900 leading-none">{{ \Carbon\Carbon::parse($event->start_date)->format('d') }}</p>
                                <p class="text-[9px] font-bold text-orange-500 uppercase mt-1">{{ \Carbon\Carbon::parse($event->start_date)->format('M') }}</p>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="text-base font-bold text-slate-900 mb-3 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 leading-snug">
                                <a href="{{ route('events.show', $event->slug) }}">{{ $event->title }}</a>
                            </h3>
                            <div class="space-y-1 mb-5 text-xs text-slate-600">
                                <div class="flex items-center gap-2">
                                    <i class="far fa-clock text-orange-500 w-3"></i>
                                    <span>{{ date('H:i', strtotime($event->start_time)) }} WIB</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-orange-500 w-3"></i>
                                    <span class="line-clamp-1">{{ $event->location }}</span>
                                </div>
                            </div>
                            <a href="{{ route('events.show', $event->slug) }}" class="mt-auto flex items-center justify-center gap-2 w-full py-2 bg-slate-900 text-white rounded-lg font-bold text-[10px] tracking-wide hover:bg-orange-600 transition-all shadow-md">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- 
                SECTION D: JURNAL
                (Card Jurnal - Tetap)
            --}}
            @if($journals->count() > 0)
            <div class="mb-10 animate-fade-in-up">
                 <div class="flex items-center justify-between mb-8 border-b border-slate-100 pb-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-purple-600 rounded-lg flex items-center justify-center text-white shadow-md">
                            <i class="fas fa-book text-lg"></i>
                        </div>
                        <h2 class="text-2xl font-bold text-slate-800">Jurnal</h2>
                    </div>
                    <span class="text-xs font-bold bg-slate-100 text-slate-600 px-3 py-1 rounded-full border border-slate-200">{{ $journals->count() }} Jurnal</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($journals as $journal)
                    <div class="group h-full">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                            <div class="relative h-56 overflow-hidden bg-slate-200">
                                <img src="{{ $journal->cover_url }}" 
                                     alt="{{ $journal->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     onerror="this.src='{{ asset('images/default-journal.png') }}'">
                                @if($journal->accreditation_status)
                                    <div class="absolute top-2 right-2">
                                        <span class="px-2 py-1 rounded-full text-[9px] font-black uppercase tracking-wider shadow-lg {{ $journal->accreditation_badge_color ?? 'bg-slate-800' }} text-white">
                                            {{ $journal->accreditation_status }}
                                        </span>
                                    </div>
                                @endif
                            </div>
                            <div class="p-5 flex-1 flex flex-col">
                                <h3 class="font-black text-slate-900 mb-2 text-sm uppercase leading-tight group-hover:text-orange-600 transition-colors line-clamp-2">
                                    <a href="{{ route('journals.show', $journal->slug) }}">{{ $journal->name }}</a>
                                </h3>
                                <p class="text-orange-600 text-[9px] font-bold uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i class="fas fa-tag"></i> {{ $journal->field ?? 'Ilmiah' }}
                                </p>
                                <div class="mt-auto pt-3 border-t border-slate-100 space-y-2">
                                    <a href="{{ route('journals.show', $journal->slug) }}" 
                                       class="block w-full bg-slate-900 text-white text-center py-2 rounded-lg font-bold text-[10px] uppercase tracking-wider hover:bg-orange-600 transition-all">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        @endif
    </div>
</div>
@endsection