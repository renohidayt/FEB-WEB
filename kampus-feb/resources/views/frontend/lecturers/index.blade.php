@extends('layouts.app')

@section('title', 'Daftar Dosen - FEB UNSAP')

@section('content')
{{-- BAGIAN HEADER --}}
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">Daftar Dosen</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="text-left animate-fade-in-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Tenaga <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Pengajar</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Dukung perkembangan akademik Anda dengan bimbingan dari para ahli dan akademisi profesional di bidang Ekonomi dan Bisnis.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 transition-transform duration-700 hover:rotate-y-0">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-user-tie text-5xl text-slate-500 group-hover:text-orange-500 transition-all"></i>
                    </div>
                    <div class="space-y-2 px-2 text-center">
                        <div class="h-2 bg-orange-500/40 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-2/3 mx-auto"></div>
                    </div>
                </div>

                <div class="absolute -top-6 right-6 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <i class="fas fa-star text-orange-500 text-2xl"></i>
                </div>
                <div class="absolute -bottom-6 left-6 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-2 font-bold text-xs">
                        <i class="fas fa-users text-blue-400"></i> Akademisi Profesional
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- BAGIAN MAIN CONTENT --}}
<div class="bg-slate-50 py-10 md:py-16">
    <div class="container mx-auto px-4">
        
        {{-- SEARCH & FILTER --}}
        <div class="max-w-6xl mx-auto mb-10">
            <div class="bg-white rounded-2xl shadow-lg p-5 border border-slate-100">
                <form method="GET" action="{{ route('lecturers.index') }}" class="flex flex-col md:grid md:grid-cols-12 gap-4">
                    <div class="md:col-span-5 relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." 
                               class="w-full pl-10 pr-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 text-sm text-slate-900 placeholder-slate-400 font-medium">
                        <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    </div>
                    
                    <div class="md:col-span-4 relative">
                        <select name="study_program" class="w-full px-4 py-3 bg-slate-50 border-none rounded-xl focus:ring-2 focus:ring-orange-500 text-sm appearance-none text-slate-900 font-medium cursor-pointer">
                            <option value="" class="text-slate-400">Semua Prodi</option>
                            @foreach($studyPrograms as $program)
                                <option value="{{ $program }}" {{ request('study_program') == $program ? 'selected' : '' }}>{{ $program }}</option>
                            @endforeach
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
                    </div>

                    <div class="md:col-span-3 flex gap-2">
                        <button type="submit" class="flex-1 bg-slate-900 text-white font-bold py-3 rounded-xl hover:bg-orange-600 transition-all text-xs uppercase tracking-widest shadow-md">Filter</button>
                        <a href="{{ route('lecturers.index') }}" class="px-5 bg-slate-100 text-slate-500 hover:text-red-500 hover:bg-red-50 transition-colors rounded-xl flex items-center justify-center" title="Reset">
                            <i class="fas fa-redo-alt"></i>
                        </a>
                    </div>
                </form>
            </div>
        </div>

        {{-- GRID DOSEN --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-10 gap-x-6 max-w-7xl mx-auto justify-items-center lg:justify-items-start">
            @forelse($lecturers as $lecturer)
                <a href="{{ route('lecturers.show', $lecturer->slug) }}" class="group block w-64">
                    <div class="relative overflow-hidden shadow-xl bg-[#0E1035] rounded-xl border border-white/10 transition-all duration-300">

                        <div class="absolute inset-y-0 left-0 w-20 md:w-24 z-20 pointer-events-none"
                             style="background: linear-gradient(to right, rgba(0,0,0,1) 0%, rgba(0,0,0,0.8) 40%, rgba(0,0,0,0.5) 70%, transparent 100%);">
                            <div class="absolute inset-y-0 left-3 md:left-4 flex flex-col justify-between py-5">
                                <span class="text-white font-serif font-bold text-[1.5rem] md:text-[1.8rem] opacity-90 group-hover:text-orange-500 transition-all duration-500"
                                      style="writing-mode: vertical-rl; text-orientation: upright; letter-spacing: -0.05em; line-height: 1.05;">
                                    LECTURER
                                </span>
                            </div>
                        </div>

                        <div class="relative h-64 md:h-72 overflow-hidden bg-slate-800">
                            @if($lecturer->photo_url)
                                <img src="{{ $lecturer->photo_url }}"
                                     class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110 grayscale-[30%] group-hover:grayscale-0"
                                     onerror="this.src='{{ asset('images/default-lecturer.png') }}'">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-user text-5xl text-slate-600"></i>
                                </div>
                            @endif
                            
                            <div class="absolute top-3 right-3 z-30 opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                                <span class="bg-orange-600 text-white text-[8px] font-bold px-2 py-1 rounded uppercase">
                                    {{ Str::limit($lecturer->study_program, 15) }}
                                </span>
                            </div>
                        </div>

                        <div class="px-4 py-4 text-center border-t border-white/5 bg-[#0B0D2A] relative z-30">
                            <h3 class="font-serif font-bold text-white text-[12px] md:text-[13px] leading-tight group-hover:text-orange-400 transition-colors line-clamp-1 uppercase">
                                @php
                                    // LOGIKA PENGHAPUSAN S1/S2/S3
                                    $cleanName = preg_replace('/^S[1-3]\.?\s*/i', '', $lecturer->full_name);
                                @endphp
                                
                                {{-- Tampilkan Nama Bersih --}}
                                {{ $cleanName }}
                            </h3>
                            <p class="text-slate-400 text-[9px] font-serif mt-1 tracking-widest">
                                NIDN: {{ $lecturer->nidn ?? '-' }}
                            </p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full text-center py-20 bg-white rounded-3xl w-full border border-slate-200">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-search text-slate-300 text-4xl mb-3"></i>
                        <p class="text-slate-500 font-medium">Data dosen tidak ditemukan.</p>
                        <p class="text-slate-400 text-sm mt-1">Coba ubah kata kunci atau filter pencarian.</p>
                    </div>
                </div>
            @endforelse
        </div>

        {{-- PAGINATION --}}
        <div class="mt-12 flex justify-center overflow-x-auto pb-4">
            <div class="pagination-wrapper px-4">
                {{ $lecturers->appends(request()->query())->links() }}
            </div>
        </div>

    </div>
</div>

<style>
    /* Custom Pagination Styling */
    .pagination-wrapper nav {
        @apply flex flex-wrap justify-center gap-1;
    }
    .pagination-wrapper nav svg {
        width: 16px;
        display: inline;
    }
    .pagination-wrapper nav div:first-child {
        display: none; /* Sembunyikan summary text bawaan Laravel */
    }
    .pagination-wrapper span, .pagination-wrapper a {
        @apply px-3 py-2 text-xs rounded-lg border border-slate-200 bg-white text-slate-600 transition-all hover:bg-slate-50;
    }
    .pagination-wrapper .active span {
        @apply bg-orange-500 border-orange-500 text-white font-bold;
    }
</style>
@endsection