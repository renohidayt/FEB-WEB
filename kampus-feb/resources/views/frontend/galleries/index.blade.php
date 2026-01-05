@extends('layouts.app')

@section('content')
{{-- Load Font Poppins --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
    .font-poppins { font-family: 'Poppins', sans-serif; }
    /* Animasi Blob Background (Sama persis dengan halaman Beasiswa) */
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out; }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<div class="font-poppins bg-white min-h-screen antialiased selection:bg-orange-500 selection:text-white">

    {{-- 1. HERO SECTION --}}
    <div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
        {{-- Background Elements --}}
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
                <span class="text-orange-500 font-semibold cursor-default">Galeri</span>
            </nav>

            <div class="grid md:grid-cols-2 gap-8 items-center">
                <div class="text-left animate-fade-in-left"> 
                    <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                        Galeri <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Kegiatan</span>
                    </h1>
                    <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                    <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                        Arsip dokumentasi visual dari berbagai kegiatan akademik, kemahasiswaan, dan acara seremonial di Fakultas Ekonomi dan Bisnis UNSAP.
                    </p>
                </div>

                <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                    <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>
                    {{-- 3D Card Effect --}}
                    <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-700">
                        <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                            <i class="fas fa-camera text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-end mb-1">
                                <div class="h-1.5 bg-orange-500 rounded-full w-2/3"></div>
                                <span class="text-[10px] text-orange-500 font-bold leading-none">Dokumentasi</span>
                            </div>
                            <div class="h-1.5 bg-slate-600/30 rounded-full w-full"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. STATISTIC CARDS --}}
   <div class="container mx-auto px-4 mt-16 relative z-20">
    {{-- Grid disesuaikan untuk 3 item (md:grid-cols-3) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @php
            $statItems = [
                // Warna dihapus karena style target menggunakan warna seragam (Slate)
                ['label' => 'Total Album', 'val' => $stats['total_albums'] ?? 0, 'icon' => 'fa-folder-open'],
                ['label' => 'Foto Tersimpan', 'val' => $stats['total_photos'] ?? 0, 'icon' => 'fa-camera'],
                ['label' => 'Video Liputan', 'val' => $stats['total_videos'] ?? 0, 'icon' => 'fa-video'],
            ];
        @endphp
        @foreach($statItems as $item)
        {{-- Container Card: Menggunakan style bg-white, rounded-3xl, dan shadow-sm --}}
        <div class="bg-white border border-slate-200 rounded-3xl p-6 flex items-center gap-5 shadow-sm hover:shadow-md transition-shadow">
            {{-- Icon Wrapper: Menggunakan style abu-abu netral (slate) --}}
            <div class="w-14 h-14 bg-slate-50 text-slate-700 rounded-2xl flex items-center justify-center text-2xl border border-slate-100">
                <i class="fas {{ $item['icon'] }}"></i>
            </div>
            <div>
                {{-- Typography: Disesuaikan dengan text-[10px] dan tracking-widest --}}
                <p class="text-slate-500 text-[10px] font-bold uppercase tracking-widest">{{ $item['label'] }}</p>
                <p class="text-3xl font-black text-slate-900">{{ number_format($item['val']) }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

    {{-- 3. FILTER SECTION --}}
    <div class="container mx-auto px-4 pt-16 pb-8">
        <div class="bg-slate-50 rounded-xl shadow-md border border-slate-200 p-4">
            <form method="GET" action="{{ route('galleries.index') }}" class="flex flex-wrap md:flex-nowrap gap-3">
                
                <div class="relative flex-grow">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari album kegiatan..." 
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 transition-all">
                </div>

                <select name="year" 
                    class="w-full md:w-48 py-3.5 bg-white border border-slate-200 rounded-xl focus:ring-2 focus:ring-orange-500/20 cursor-pointer">
                    <option value="">Semua Tahun</option>
                    <option value="2024">2024</option>
                    <option value="2023">2023</option>
                </select>

                <button type="submit" 
                    class="w-full md:w-auto px-8 py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                    Filter
                </button>
                
                @if(request('search') || request('year'))
                <a href="{{ route('galleries.index') }}" 
                    class="flex items-center justify-center w-12 h-12 bg-white border border-slate-200 text-slate-500 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-colors">
                    <i class="fas fa-redo"></i>
                </a>
                @endif
            </form>
        </div>
    </div>

    {{-- 4. ALBUM GRID (Setema dengan Beasiswa Card) --}}
    <div class="container mx-auto px-4 pb-20">
        @if($albums->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($albums as $album)
                    <div class="group bg-slate-50 rounded-xl border border-slate-200 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col overflow-hidden">

                        <div class="relative h-52 overflow-hidden bg-slate-200">
                            <img src="{{ $album->cover_url }}" alt="{{ $album->name }}" 
                                class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700"
                                onerror="this.src='https://via.placeholder.com/600x400?text=No+Image'">
                            
                            {{-- Overlay & Badge --}}
                            <div class="absolute top-5 left-5 right-5 flex justify-between items-start">
                                <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">
                                    {{ $album->date ? $album->date->format('Y') : 'UMUM' }}
                                </span>
                                <div class="bg-orange-500 text-white text-[10px] font-bold px-2 py-1 rounded-md shadow-lg">
                                    <i class="fas fa-camera mr-1"></i> {{ $album->photos_count }} Foto
                                </div>
                            </div>
                        </div>

                        <div class="p-8 flex flex-col flex-1">
                            <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                                {{ $album->name }}
                            </h3>
                            
                            <div class="flex items-center gap-2 text-slate-400 text-sm mb-4">
                                <i class="fas fa-calendar-alt text-orange-500/70"></i>
                                <span class="truncate">{{ $album->date ? $album->date->format('d F Y') : 'Tanggal tidak tersedia' }}</span>
                            </div>

                            <div class="mb-6 flex-1">
                                <p class="text-slate-500 text-sm line-clamp-3">
                                    {{ $album->description ?? 'Dokumentasi kegiatan resmi Fakultas Ekonomi dan Bisnis UNSAP.' }}
                                </p>
                            </div>

                            <a href="{{ route('galleries.show', $album->slug) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                                Lihat Album <i class="fas fa-arrow-right text-xs"></i>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-12">
                {{ $albums->links() }}
            </div>
        @else
            <div class="py-20 text-center bg-white rounded-xl border-2 border-dashed border-slate-200">
                <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-3xl text-slate-300"></i>
                </div>
                <h3 class="text-xl font-bold text-slate-900">Belum Ada Album</h3>
                <p class="text-slate-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
            </div>
        @endif
    </div>

   {{-- 5. FOOTER CTA --}}
   <div class="container mx-auto px-4 pb-20">
    <div class="relative bg-slate-900 rounded-[2rem] p-8 md:p-12 text-center overflow-hidden shadow-xl border border-white/5">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-60 h-60 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-60 h-60 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>

        <div class="relative z-10">
            
            <h2 class="text-2xl md:text-4xl font-black text-white mb-4 leading-tight uppercase tracking-tight">
                Punya Dokumentasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Kegiatan?</span>
            </h2>
            
            <p class="text-slate-400 max-w-xl mx-auto mb-8 text-base font-light leading-relaxed">
                Hubungi BEM atau admin fakultas untuk mengarsipkan foto/video kegiatan agar tersimpan di galeri resmi FEB UNSAP.
            </p>

            <div class="flex flex-wrap justify-center gap-3">
                <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP." class="group relative px-8 py-3.5 bg-orange-500 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-orange-500/40 hover:-translate-y-1 active:scale-95 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i> Kirim Dokumentasi
                    </span>
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a>
            </div>
        </div>
    </div>
</div>

</div>
@endsection