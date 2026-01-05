@extends('layouts.app')

@section('title', 'Jurnal Ilmiah - FEB UNSAP')

@section('content')
{{-- ================= HEADER SECTION ================= --}}
{{-- 1. HERO SECTION --}}
 <div class="bg-slate-50">
    {{-- Hero Header Section --}}
    <div class="relative bg-slate-900 text-white pt-6 pb-20 overflow-hidden border-b border-white/5">
        
        {{-- Background Decorations --}}
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
        {{-- Blob Kanan Atas (Orange) --}}
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        {{-- Blob Kiri Bawah (Blue) --}}
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
        
        <div class="container mx-auto px-4 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="w-full flex items-center text-sm font-medium mb-12">
                <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                    <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                    <span>Beranda</span>
                </a>
                <span class="mx-3 text-slate-600">/</span>
                <span class="text-orange-500 font-semibold cursor-default uppercase tracking-wider text-xs">Jurnal Ilmiah</span>
            </nav>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Text Content --}}
                <div class="animate-fade-in-left">
                    <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
    Direktori <br>
    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">
        Jurnal Ilmiah
    </span>
</h1>

                    <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>
                    <p class="text-lg text-slate-300 font-light leading-relaxed max-w-xl">
                        Direktori jurnal ilmiah yang dikelola oleh Fakultas Ekonomi dan Bisnis UNSAP sebagai sarana akses informasi publikasi ilmiah dan pengembangan ilmu pengetahuan.
                    </p>
                </div>

                {{-- Illustration Area (Glassmorphism) --}}
                <div class="hidden lg:flex justify-center relative">
                    {{-- Glow Effect belakang card --}}
                    <div class="absolute w-64 h-64 bg-orange-500/10 rounded-full blur-[80px]"></div>
                    
                    {{-- Card Utama --}}
                    <div class="relative w-72 h-72 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl flex items-center justify-center transform rotate-3 hover:rotate-0 transition-all duration-700 group">
                        {{-- Icon Utama (Buku / Jurnal) --}}
                        <i class="fas fa-book-open text-8xl text-slate-700 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                        
                        {{-- Floating Badge (Pena / Scroll) --}}
                        <div class="absolute -top-6 -left-6 bg-slate-800 border border-orange-500/50 p-5 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                            <i class="fas fa-scroll text-orange-500 text-3xl"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ================= MAIN CONTENT ================= --}}
<div class="bg-slate-50 py-16 relative z-20">
    <div class="container mx-auto px-4">
        
        {{-- Search & Filter --}}
        <div class="bg-white rounded-xl shadow-lg p-6 mb-10 border border-slate-200">
            <form method="GET" action="{{ route('journals.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                {{-- Search --}}
                <div class="md:col-span-2">
                    <input type="text" 
                           name="search" 
                           value="{{ request('search') }}"
                           placeholder="Cari jurnal..." 
                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                </div>
                
                {{-- Manager Filter --}}
                <div>
                    <select name="manager" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="">Semua Pengelola</option>
                        @foreach($managers as $manager)
                            <option value="{{ $manager }}" {{ request('manager') == $manager ? 'selected' : '' }}>
                                {{ $manager }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Accreditation Filter --}}
                <div>
                    <select name="accreditation" class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent transition">
                        <option value="">Semua Akreditasi</option>
                        @foreach($accreditationStatuses as $key => $label)
                            <option value="{{ $key }}" {{ request('accreditation') == $key ? 'selected' : '' }}>
                                {{ $key }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                {{-- Submit Button --}}
                <div class="md:col-span-4 flex gap-2">
                    <button type="submit" class="flex-1 md:flex-none bg-slate-900 text-white px-8 py-3 rounded-lg font-bold uppercase tracking-wider hover:bg-orange-600 transition-all shadow-lg">
                        <i class="fas fa-search mr-2"></i>Cari
                    </button>
                    
                    @if(request()->hasAny(['search', 'manager', 'accreditation']))
                        <a href="{{ route('journals.index') }}" class="bg-slate-200 text-slate-700 px-6 py-3 rounded-lg font-bold hover:bg-slate-300 transition-all">
                            <i class="fas fa-redo"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Journals Grid --}}
        @if($journals->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach($journals as $journal)
                <div class="group">
                    <a href="{{ route('journals.show', $journal->slug) }}" class="block">
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl h-full flex flex-col">
                            
                            {{-- Cover Image --}}
                            <div class="relative h-72 overflow-hidden bg-slate-200">
                                <img src="{{ $journal->cover_url }}" 
                                     alt="{{ $journal->name }}"
                                     class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                     onerror="this.src='{{ asset('images/default-journal.png') }}'">
                                
                                {{-- Accreditation Badge --}}
                                @if($journal->accreditation_status)
                                    <div class="absolute top-3 right-3">
                                        <span class="px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider shadow-lg {{ $journal->accreditation_badge_color }} text-white">
                                            {{ $journal->accreditation_status }}
                                        </span>
                                    </div>
                                @endif
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex-1 flex flex-col">
                                {{-- Journal Name --}}
                                <h3 class="font-black text-slate-900 mb-2 text-lg uppercase leading-tight group-hover:text-orange-600 transition-colors line-clamp-2">
                                    {{ $journal->name }}
                                </h3>

                                {{-- Field --}}
                                <p class="text-orange-600 text-xs font-bold uppercase tracking-wider mb-3 flex items-center gap-2">
                                    <i class="fas fa-tag"></i>
                                    <span class="line-clamp-1">{{ $journal->field }}</span>
                                </p>

                                {{-- Manager --}}
                                <p class="text-slate-600 text-sm mb-4 flex items-start gap-2">
                                    <i class="fas fa-building mt-0.5 flex-shrink-0"></i>
                                    <span class="line-clamp-2">{{ $journal->manager }}</span>
                                </p>

                                {{-- ISSN Info --}}
                                @if($journal->issn || $journal->e_issn)
                                <div class="text-xs text-slate-500 mb-4 space-y-1">
                                    @if($journal->issn)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-barcode"></i>
                                            <span>ISSN: {{ $journal->issn }}</span>
                                        </div>
                                    @endif
                                    @if($journal->e_issn)
                                        <div class="flex items-center gap-2">
                                            <i class="fas fa-globe"></i>
                                            <span>e-ISSN: {{ $journal->e_issn }}</span>
                                        </div>
                                    @endif
                                </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="mt-auto pt-4 border-t border-slate-100 space-y-2">
                                    @if($journal->website_url)
                                        <a href="{{ $journal->website_url }}" 
                                           target="_blank"
                                           onclick="event.stopPropagation()"
                                           class="block w-full bg-slate-900 text-white text-center py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-orange-600 transition-all">
                                            <i class="fas fa-external-link-alt mr-2"></i>Website Jurnal
                                        </a>
                                    @endif
                                    
                                    @if($journal->submit_url)
                                        <a href="{{ $journal->submit_url }}" 
                                           target="_blank"
                                           onclick="event.stopPropagation()"
                                           class="block w-full bg-orange-600 text-white text-center py-2.5 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-orange-700 transition-all">
                                            <i class="fas fa-paper-plane mr-2"></i>Submit Artikel
                                        </a>
                                    @endif
                                </div>

                                {{-- Quick Links --}}
                                @if($journal->sinta_url || $journal->garuda_url || $journal->scholar_url)
                                <div class="mt-3 pt-3 border-t border-slate-100 flex gap-2 justify-center">
                                    @if($journal->sinta_url)
                                        <a href="{{ $journal->sinta_url }}" 
                                           target="_blank"
                                           onclick="event.stopPropagation()"
                                           class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                           title="SINTA">
                                            <i class="fas fa-chart-line"></i>
                                        </a>
                                    @endif
                                    @if($journal->garuda_url)
                                        <a href="{{ $journal->garuda_url }}" 
                                           target="_blank"
                                           onclick="event.stopPropagation()"
                                           class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                           title="Garuda">
                                            <i class="fas fa-book-open"></i>
                                        </a>
                                    @endif
                                    @if($journal->scholar_url)
                                        <a href="{{ $journal->scholar_url }}" 
                                           target="_blank"
                                           onclick="event.stopPropagation()"
                                           class="w-10 h-10 bg-slate-100 rounded-full flex items-center justify-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                           title="Google Scholar">
                                            <i class="fab fa-google"></i>
                                        </a>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            @if($journals->hasPages())
            <div class="mt-12 flex justify-center">
                {{ $journals->links() }}
            </div>
            @endif
        @else
            {{-- Empty State --}}
            <div class="bg-white rounded-xl shadow-lg p-16 text-center border border-slate-200">
                <i class="fas fa-book fa-4x text-slate-300 mb-6"></i>
                <h3 class="text-2xl font-bold text-slate-900 mb-3">
                    @if(request()->hasAny(['search', 'manager', 'accreditation']))
                        Jurnal Tidak Ditemukan
                    @else
                        Belum Ada Jurnal
                    @endif
                </h3>
                <p class="text-slate-600 mb-6">
                    @if(request()->hasAny(['search', 'manager', 'accreditation']))
                        Coba ubah filter atau kata kunci pencarian Anda.
                    @else
                        Jurnal ilmiah akan segera ditambahkan.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'manager', 'accreditation']))
                    <a href="{{ route('journals.index') }}" class="inline-block bg-orange-600 text-white px-8 py-3 rounded-lg font-bold uppercase tracking-wider hover:bg-orange-700 transition-all shadow-lg">
                        <i class="fas fa-redo mr-2"></i>Reset Filter
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>

<style>
@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
.animate-blob { animation: blob 7s infinite; }

@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}
.animate-fade-in-left { animation: fadeInLeft 1s ease-out forwards; }
</style>
@endsection