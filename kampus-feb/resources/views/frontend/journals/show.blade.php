@extends('layouts.app')

@section('title', $journal->name . ' - FEB UNSAP')

@section('content')
{{-- ================= HEADER SECTION ================= --}}
<div class="relative bg-slate-900 text-white pt-10 pb-20 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center text-xs md:text-sm font-medium mb-8 text-slate-400">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors flex items-center gap-2">
                <i class="fas fa-home text-orange-500"></i> Beranda
            </a>
            <span class="mx-3 text-slate-700">/</span>
            <a href="{{ route('journals.index') }}" class="hover:text-white transition-colors">Jurnal Ilmiah</a>
            <span class="mx-3 text-slate-700">/</span>
            <span class="text-orange-500 uppercase tracking-wider font-bold truncate">{{ $journal->name }}</span>
        </nav>

        <div class="max-w-4xl">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight uppercase animate-fade-in-left">
                Detail <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Jurnal</span>
            </h1>
            <div class="w-20 h-1.5 bg-orange-500 rounded-full"></div>
        </div>
    </div>
</div>

{{-- ================= MAIN CONTENT ================= --}}
<div class="bg-slate-50 py-16 relative z-20">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            {{-- === SIDEBAR KIRI: COVER & INFO === --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-xl shadow-xl overflow-hidden border border-slate-200 sticky top-24">
                    
                    {{-- Cover Image --}}
                    <div class="relative">
                        <img src="{{ $journal->cover_url }}" 
                             alt="{{ $journal->name }}"
                             class="w-full h-auto object-cover"
                             onerror="this.src='{{ asset('images/default-journal.png') }}'">
                        
                        {{-- Accreditation Badge --}}
                        @if($journal->accreditation_status)
                            <div class="absolute top-4 right-4">
                                <span class="px-4 py-2 rounded-full text-sm font-black uppercase tracking-wider shadow-lg {{ $journal->accreditation_badge_color }} text-white">
                                    {{ $journal->accreditation_status }}
                                </span>
                            </div>
                        @endif
                    </div>

                    {{-- Info Section --}}
                    <div class="p-6 space-y-4">
                        
                        {{-- Field --}}
                        @if($journal->field)
                        <div class="flex items-start gap-3">
                            <div class="w-8 flex justify-center text-orange-500 mt-1">
                                <i class="fas fa-tag"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-1">Bidang Fokus</p>
                                <p class="text-slate-900 font-bold">{{ $journal->field }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- Manager --}}
                        @if($journal->manager)
                        <div class="flex items-start gap-3">
                            <div class="w-8 flex justify-center text-blue-500 mt-1">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-widest text-slate-400 font-bold mb-1">Pengelola</p>
                                <p class="text-slate-900 font-bold">{{ $journal->manager }}</p>
                            </div>
                        </div>
                        @endif

                        {{-- ISSN --}}
                        @if($journal->issn || $journal->e_issn)
                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-xs uppercase tracking-widest text-slate-900 font-black mb-3">Identifikasi</p>
                            
                            @if($journal->issn)
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-8 flex justify-center text-slate-400">
                                    <i class="fas fa-barcode"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">ISSN</p>
                                    <p class="text-slate-900 font-bold">{{ $journal->issn }}</p>
                                </div>
                            </div>
                            @endif

                            @if($journal->e_issn)
                            <div class="flex items-center gap-3">
                                <div class="w-8 flex justify-center text-slate-400">
                                    <i class="fas fa-globe"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-slate-400">e-ISSN</p>
                                    <p class="text-slate-900 font-bold">{{ $journal->e_issn }}</p>
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Frequency & Editor --}}
                        @if($journal->frequency || $journal->editor_in_chief)
                        <div class="pt-4 border-t border-slate-200 space-y-3">
                            @if($journal->frequency)
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Frekuensi Terbit</p>
                                <p class="text-slate-900 font-bold">{{ $journal->frequency }}</p>
                            </div>
                            @endif

                            @if($journal->editor_in_chief)
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Pemimpin Redaksi</p>
                                <p class="text-slate-900 font-bold">{{ $journal->editor_in_chief }}</p>
                            </div>
                            @endif
                        </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="pt-4 border-t border-slate-200 space-y-2">
                            @if($journal->website_url)
                            <a href="{{ $journal->website_url }}" 
                               target="_blank"
                               class="block w-full bg-slate-900 text-white text-center py-3 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-orange-600 transition-all shadow-lg">
                                <i class="fas fa-external-link-alt mr-2"></i>Kunjungi Website
                            </a>
                            @endif

                            @if($journal->submit_url)
                            <a href="{{ $journal->submit_url }}" 
                               target="_blank"
                               class="block w-full bg-orange-600 text-white text-center py-3 rounded-lg font-bold text-xs uppercase tracking-wider hover:bg-orange-700 transition-all shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i>Submit Artikel
                            </a>
                            @endif
                        </div>

                        {{-- Quick Links --}}
                        @if($journal->sinta_url || $journal->garuda_url || $journal->scholar_url)
                        <div class="pt-4 border-t border-slate-200">
                            <p class="text-xs uppercase tracking-widest text-slate-900 font-black mb-3">Link Eksternal</p>
                            <div class="flex gap-2">
                                @if($journal->sinta_url)
                                <a href="{{ $journal->sinta_url }}" 
                                   target="_blank"
                                   class="flex-1 bg-slate-100 text-slate-700 py-2 rounded-lg text-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                   title="SINTA">
                                    <i class="fas fa-chart-line"></i>
                                </a>
                                @endif

                                @if($journal->garuda_url)
                                <a href="{{ $journal->garuda_url }}" 
                                   target="_blank"
                                   class="flex-1 bg-slate-100 text-slate-700 py-2 rounded-lg text-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                   title="Garuda">
                                    <i class="fas fa-book-open"></i>
                                </a>
                                @endif

                                @if($journal->scholar_url)
                                <a href="{{ $journal->scholar_url }}" 
                                   target="_blank"
                                   class="flex-1 bg-slate-100 text-slate-700 py-2 rounded-lg text-center hover:bg-orange-100 hover:text-orange-600 transition-all"
                                   title="Google Scholar">
                                    <i class="fab fa-google"></i>
                                </a>
                                @endif
                            </div>
                        </div>
                        @endif

                        {{-- View Count --}}
                        <div class="pt-4 border-t border-slate-200 text-center">
                            <p class="text-xs text-slate-400">
                                <i class="fas fa-eye mr-1"></i>
                                {{ number_format($journal->view_count) }} views
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- === KONTEN KANAN: DETAIL === --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Journal Title --}}
                <div class="bg-white rounded-xl shadow-xl p-8 border border-slate-200">
                    <h1 class="text-3xl md:text-4xl font-black text-slate-900 mb-4 uppercase leading-tight">
                        {{ $journal->name }}
                    </h1>
                    
                    @if($journal->publisher)
                    <p class="text-slate-600 flex items-center gap-2">
                        <i class="fas fa-university"></i>
                        <span>{{ $journal->publisher }}</span>
                    </p>
                    @endif
                </div>

                {{-- Description --}}
                @if($journal->description)
                <div class="bg-white rounded-xl shadow-xl p-8 border border-slate-200">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-orange-100 text-orange-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-info-circle"></i>
                        </span>
                        <h2 class="text-xl font-black text-slate-900 uppercase">Tentang Jurnal</h2>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-justify whitespace-pre-line">
                        {{ $journal->description }}
                    </p>
                </div>
                @endif

                {{-- Scope & Focus --}}
                <div class="bg-white rounded-xl shadow-xl p-8 border border-slate-200">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                            <i class="fas fa-bullseye"></i>
                        </span>
                        <h2 class="text-xl font-black text-slate-900 uppercase">Ruang Lingkup</h2>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                                <i class="fas fa-tag text-orange-500"></i> Bidang Fokus
                            </h3>
                            <p class="text-slate-600">{{ $journal->field }}</p>
                        </div>

                        @if($journal->frequency)
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-green-500"></i> Frekuensi
                            </h3>
                            <p class="text-slate-600">{{ $journal->frequency }}</p>
                        </div>
                        @endif

                        <div>
                            <h3 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                                <i class="fas fa-building text-blue-500"></i> Pengelola
                            </h3>
                            <p class="text-slate-600">{{ $journal->manager }}</p>
                        </div>

                        @if($journal->accreditation_status)
                        <div>
                            <h3 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                                <i class="fas fa-medal text-yellow-500"></i> Akreditasi
                            </h3>
                            <span class="inline-block px-4 py-2 rounded-lg {{ $journal->accreditation_badge_color }} text-white font-bold">
                                {{ $journal->accreditation_status }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

             
        {{-- Related Journals --}}
        @if($relatedJournals->count() > 0)
        <div class="mt-24 border-t border-slate-300 pt-12">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl md:text-3xl font-black text-slate-900 uppercase">Jurnal Terkait</h2>
                    <p class="text-slate-600 mt-2">Jurnal lain dari {{ $journal->manager }}</p>
                </div>
                <a href="{{ route('journals.index') }}" class="text-orange-600 font-bold uppercase text-xs tracking-widest hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($relatedJournals as $related)
                <a href="{{ route('journals.show', $related->slug) }}" class="group block">
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-slate-200 transition-all duration-300 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="relative h-64 overflow-hidden bg-slate-200">
                            <img src="{{ $related->cover_url }}" 
                                 alt="{{ $related->name }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 onerror="this.src='{{ asset('images/default-journal.png') }}'">
                            
                            @if($related->accreditation_status)
                            <span class="absolute top-3 right-3 px-3 py-1.5 rounded-full text-xs font-black uppercase {{ $related->accreditation_badge_color }} text-white">
                                {{ $related->accreditation_status }}
                            </span>
                            @endif
                        </div>

                        <div class="p-6">
                            <h3 class="font-black text-slate-900 mb-2 uppercase leading-tight group-hover:text-orange-600 transition-colors line-clamp-2">
                                {{ $related->name }}
                            </h3>
                            <p class="text-orange-600 text-xs font-bold uppercase tracking-wider">
                                {{ $related->field }}
                            </p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
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