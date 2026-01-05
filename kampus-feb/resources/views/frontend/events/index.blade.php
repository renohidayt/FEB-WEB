@extends('layouts.app')

@section('content')
{{-- Hero Section --}}
<div class="relative bg-slate-900 text-white pt-6 pb-20 overflow-hidden border-b border-white/5">
    {{-- Animated Background Elements --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">Event & Agenda</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-12 items-center">
            <div class="text-left animate-fade-in-left"> 
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-500/10 border border-orange-500/20 text-orange-400 text-xs font-bold uppercase tracking-wider mb-6">
                </div>
                <h1 class="text-4xl md:text-6xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
                    Event & <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Agenda</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Jangan lewatkan momen berharga. Temukan berbagai seminar, workshop, dan kegiatan akademik menarik di Fakultas Ekonomi dan Bisnis UNSAP.
                </p>
            </div>

            {{-- Decorative Calendar Element --}}
            <div class="hidden md:flex justify-center relative">
                <div class="relative w-64 h-64 bg-slate-800/40 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl flex flex-col items-center justify-center transform rotate-3 hover:rotate-0 transition-all duration-500">
                    <i class="fas fa-calendar-check text-7xl text-orange-500 mb-4"></i>
                    <span class="text-3xl font-black text-white">2025</span>
                    <span class="text-slate-400 uppercase tracking-widest text-sm">Academic Year</span>
                </div>
                <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-2xl shadow-xl transform -rotate-12 animate-bounce" style="animation-duration: 5s">
                    <i class="fas fa-ticket-alt text-2xl text-blue-600"></i>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 2. MAIN CONTENT AREA (Start from here) --}}
<div class="bg-slate-50 min-h-screen pb-20">
    
    {{-- Section Statistik (Dibawah Hero) --}}
    <div class="container mx-auto px-4 py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $statItems = [
                    ['label' => 'Total Agenda', 'val' => $stats['total'], 'icon' => 'fa-calendar-alt', 'color' => 'blue'],
                    ['label' => 'Segera Hadir', 'val' => $stats['upcoming'], 'icon' => 'fa-clock', 'color' => 'emerald'],
                    ['label' => 'Sedang Jalan', 'val' => $stats['ongoing'], 'icon' => 'fa-play-circle', 'color' => 'orange'],
                    ['label' => 'Telah Selesai', 'val' => $stats['past'], 'icon' => 'fa-check-circle', 'color' => 'slate'],
                ];
            @endphp
            @foreach($statItems as $item)
            <div class="bg-white border border-slate-200 rounded-3xl p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
                <div class="w-14 h-14 bg-slate-50 text-slate-700 rounded-2xl flex items-center justify-center text-2xl border border-slate-100">
                    <i class="fas {{ $item['icon'] }}"></i>
                </div>
                <div>
                    <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ $item['label'] }}</p>
                    <p class="text-3xl font-black text-slate-900">{{ $item['val'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
{{-- Filter & Search Section --}}
<div class="container mx-auto px-4 mb-12">
    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-5">
        <form method="GET" action="{{ route('events.index') }}" class="flex flex-wrap md:flex-nowrap gap-4">
            <div class="relative flex-grow">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari agenda atau kegiatan..." 
                    class="w-full pl-12 pr-4 py-4 bg-slate-50 border-none rounded-lg focus:ring-2 focus:ring-orange-500/20 transition-all text-slate-700">
            </div>

            <select name="filter" 
                class="w-full md:w-56 py-4 bg-slate-50 border-none rounded-lg focus:ring-2 focus:ring-orange-500/20 cursor-pointer text-slate-600 font-medium">
                <option value="">Semua Status</option>
                <option value="upcoming" {{ request('filter') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                <option value="ongoing" {{ request('filter') == 'ongoing' ? 'selected' : '' }}>Sedang Berlangsung</option>
                <option value="past" {{ request('filter') == 'past' ? 'selected' : '' }}>Telah Selesai</option>
            </select>

            <button type="submit" 
                class="w-full md:w-auto px-10 py-4 bg-slate-900 text-white rounded-lg font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                Terapkan
            </button>
        </form>
    </div>
</div>

{{-- Event Grid Section --}}
<div class="container mx-auto px-4">
    @if($events->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
            @foreach($events as $event)
                <div class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col overflow-hidden">
                    
                    {{-- Image Header --}}
                    <div class="relative h-72 overflow-hidden">
                        @if($event->poster)
                            <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-slate-800 flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-6xl text-white/10"></i>
                            </div>
                        @endif

                        {{-- Absolute Overlay Info --}}
                        <div class="absolute top-6 right-6">
                            @if($event->isOngoing())
                                <span class="px-4 py-2 bg-orange-600 text-white text-[10px] font-black uppercase tracking-widest rounded-lg shadow-xl flex items-center gap-2 animate-pulse">
                                    <span class="w-2 h-2 bg-white rounded-full"></span> LIVE
                                </span>
                            @endif
                        </div>

                        <div class="absolute bottom-6 left-6 bg-white rounded-lg p-4 shadow-xl border border-slate-100 min-w-[70px] text-center">
                            <p class="text-3xl font-black text-slate-900 leading-none">{{ $event->start_date->format('d') }}</p>
                            <p class="text-xs font-bold text-orange-500 uppercase mt-1">{{ $event->start_date->format('M Y') }}</p>
                        </div>
                    </div>

                    {{-- Body Content --}}
                    <div class="p-6 md:p-8 flex flex-col flex-1 bg-white">
                        {{-- Title --}}
                        <h3 class="text-xl font-bold text-slate-900 mb-5 group-hover:text-orange-600 transition-colors duration-300 line-clamp-2 leading-snug">
                            {{ $event->title }}
                        </h3>

                        {{-- Detailed Info Grid --}}
                        <div class="space-y-3 mb-8">
                            {{-- Tanggal --}}
                            <div class="flex items-center group/info">
                                <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center mr-3 border border-slate-100 group-hover/info:bg-orange-50 group-hover/info:text-orange-600 transition-all duration-300">
                                    <i class="far fa-calendar-alt text-sm"></i>
                                </div>
                                <span class="text-sm text-slate-600 font-medium tracking-wide">{{ $event->formatted_date }}</span>
                            </div>

                            {{-- Waktu --}}
                            <div class="flex items-center group/info">
                                <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center mr-3 border border-slate-100 group-hover/info:bg-orange-50 group-hover/info:text-orange-600 transition-all duration-300">
                                    <i class="far fa-clock text-sm"></i>
                                </div>
                                <span class="text-sm text-slate-600 font-medium tracking-wide">
                                    {{ date('H:i', strtotime($event->start_time)) }} - {{ date('H:i', strtotime($event->end_time)) }} WIB
                                </span>
                            </div>

                            {{-- Lokasi --}}
                            <div class="flex items-start group/info">
                                <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center mr-3 border border-slate-100 group-hover/info:bg-orange-50 group-hover/info:text-orange-600 transition-all duration-300 shrink-0">
                                    <i class="fas fa-map-marker-alt text-sm"></i>
                                </div>
                                <span class="text-sm text-slate-600 font-medium tracking-wide line-clamp-2 pt-1.5">{{ $event->location }}</span>
                            </div>

                            {{-- Penyelenggara --}}
                            <div class="flex items-center group/info">
                                <div class="w-9 h-9 rounded-lg bg-slate-50 text-slate-500 flex items-center justify-center mr-3 border border-slate-100 group-hover/info:bg-orange-50 group-hover/info:text-orange-600 transition-all duration-300">
                                    <i class="fas fa-user-tie text-sm"></i>
                                </div>
                                <span class="text-sm text-slate-500 font-medium tracking-wide line-clamp-1">{{ $event->organizer }}</span>
                            </div>
                        </div>

                        {{-- Action Button --}}
                        <a href="{{ route('events.show', $event->slug) }}" class="mt-auto flex items-center justify-center gap-2 w-full py-4 bg-slate-900 text-white rounded-xl font-semibold text-sm tracking-wide hover:bg-orange-600 transition-all duration-300 shadow-md active:scale-[0.98] group/btn">
                            <span>Lihat Detail Agenda</span>
                            <i class="fas fa-chevron-right text-[10px] group-hover/btn:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-16">
            {{ $events->links() }}
        </div>
    @else
        <div class="py-24 text-center bg-white rounded-xl border-2 border-dashed border-slate-200 max-w-4xl mx-auto">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-calendar-times text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-2xl font-bold text-slate-900 mb-2">Agenda Tidak Ditemukan</h3>
            <p class="text-slate-500">Coba gunakan kata kunci lain atau ubah filter status.</p>
        </div>
    @endif
</div>
{{-- 3. CALL TO ACTION SECTION --}}
<div class="bg-white py-16">
    <div class="container mx-auto px-4">
        <div class="relative bg-slate-900 rounded-[2rem] p-10 md:p-16 text-center overflow-hidden shadow-2xl">
            <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-black text-white mb-6 uppercase tracking-tight">Informasi <span class="text-orange-500">Kemitraan?</span></h2>
                
                <p class="text-slate-400 max-w-2xl mx-auto mb-10 text-base md:text-lg leading-relaxed">
                    Ingin berkolaborasi atau mengadakan event bersama Fakultas Ekonomi dan Bisnis UNSAP?
                </p>
                
               <div class="flex flex-wrap justify-center gap-4">
    {{-- Tombol WhatsApp --}}
    <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP." 
       target="_blank" 
       class="px-8 py-3.5 bg-orange-500 text-white rounded-xl font-bold hover:bg-orange-600 transition-all hover:-translate-y-1 shadow-xl shadow-orange-500/20 text-sm md:text-base flex items-center">
        <i class="fab fa-whatsapp mr-2 text-xl"></i> Hubungi Admin via WhatsApp
    </a>
</div>
            </div>
        </div>
    </div>
</div>
<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
</style>
@endsection