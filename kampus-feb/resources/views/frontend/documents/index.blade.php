@extends('layouts.app')

@section('content')

{{-- ========================================================================
   HERO SECTION (DESAIN AWAL / 3D & BLOBS)
   ======================================================================== --}}
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
    
    {{-- Background Decorations --}}
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
            <span class="text-orange-500 font-semibold cursor-default">Dokumen & Berkas</span>
        </nav>

        {{-- Grid Content --}}
        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            {{-- Left Side: Text --}}
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Dokumen & <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Berkas</span>
                </h1>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Akses cepat ke seluruh dokumen resmi, formulir akademik, dan berkas penting dalam format digital yang mudah diunduh.
                </p>
            </div>

            {{-- Right Side: 3D Visual Mockup --}}
            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                {{-- Glow Effect --}}
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                {{-- Mockup Window --}}
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="flex items-center gap-1.5 mb-4 opacity-50">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-24 rounded-lg mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-file-alt text-4xl text-slate-600 group-hover:text-orange-500 transition-colors duration-500"></i>
                    </div>

                    <div class="space-y-2">
                        <div class="h-2 bg-slate-600/30 rounded-full w-3/4"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2"></div>
                    </div>
                </div>

                {{-- Floating Badge --}}
                <div class="absolute top-4 right-8 bg-slate-800/80 backdrop-blur-md border border-orange-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-400">
                            <i class="fas fa-download text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Total</p>
                            <p class="text-xs font-bold leading-none">{{ $documents->total() }} Files</p>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>

{{-- ========================================================================
   MAIN CONTENT (UI LEBIH TEGAS & DI BAWAH BANNER)
   ======================================================================== --}}
<div class="bg-slate-50 min-h-screen py-12">
    <div class="container mx-auto px-4">
        
        {{-- 1. Filter Section (Desain Box Tegas, tidak bulat banget) --}}
        <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6 mb-8">
            <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100">
                <div class="w-10 h-10 bg-slate-900 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-filter"></i>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Filter & Pencarian</h3>
                    <p class="text-xs text-slate-500">Temukan dokumen yang Anda butuhkan</p>
                </div>
            </div>

            <form action="{{ route('documents.index') }}" method="GET">
                <div class="grid md:grid-cols-12 gap-5 items-end">
                    {{-- Search Input --}}
                    <div class="md:col-span-6">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Kata Kunci</label>
                        <div class="relative">
                            <input type="text" 
                                   name="search" 
                                   class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-300 rounded-lg text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-all placeholder:text-slate-400" 
                                   placeholder="Contoh: Kalender Akademik, SK..."
                                   value="{{ request('search') }}">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none text-slate-400">
                                <i class="fas fa-search"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Category Dropdown --}}
                    <div class="md:col-span-4">
                        <label class="block text-xs font-bold text-slate-700 mb-2 uppercase tracking-wide">Kategori</label>
                        <div class="relative">
                            <select name="category" class="w-full pl-3 pr-10 py-3 bg-slate-50 border border-slate-300 rounded-lg text-sm font-medium focus:ring-2 focus:ring-orange-500 focus:border-orange-500 appearance-none cursor-pointer">
                                <option value="">Semua Kategori</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat }}" {{ request('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-500">
                                <i class="fas fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Button --}}
                    <div class="md:col-span-2">
                        <button type="submit" class="w-full bg-slate-900 hover:bg-orange-600 text-white font-bold py-3 px-4 rounded-lg transition-all shadow-md active:translate-y-0.5 text-sm flex items-center justify-center gap-2">
                            <i class="fas fa-search"></i> Cari
                        </button>
                    </div>
                </div>

                @if(request('search') || request('category'))
                <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                    <span class="text-xs text-slate-500">Menampilkan hasil filter aktif</span>
                    <a href="{{ route('documents.index') }}" class="text-xs font-bold text-red-600 hover:text-red-800 hover:underline">
                        <i class="fas fa-undo mr-1"></i> Reset Filter
                    </a>
                </div>
                @endif
            </form>
        </div>

        {{-- 2. Content / Table Section --}}
        @if($documents->isEmpty())
            <div class="bg-white rounded-xl border border-dashed border-slate-300 p-12 text-center">
                <div class="w-16 h-16 bg-slate-50 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-folder-open text-3xl text-slate-400"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-800">Tidak Ada Dokumen</h3>
                <p class="text-slate-500 text-sm mt-1">Belum ada dokumen yang sesuai dengan pencarian Anda.</p>
            </div>
        @else
            <div class="bg-white rounded-xl shadow-sm border border-slate-200 overflow-hidden mb-12">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200">
                                <th class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider w-[40%]">Nama Dokumen</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider hidden md:table-cell">Kategori</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider text-center hidden sm:table-cell">Tipe</th>
                                <th class="px-6 py-4 text-xs font-bold text-slate-600 uppercase tracking-wider text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($documents as $document)
                            @php
                                $ext = strtolower(pathinfo($document->file_path, PATHINFO_EXTENSION));
                                // Konfigurasi Icon Box (Kotak/Rounded-lg)
                                $style = match($ext) {
                                    'pdf' => ['icon' => 'fa-file-pdf', 'text' => 'text-red-600', 'bg' => 'bg-red-50 border-red-100'],
                                    'doc', 'docx' => ['icon' => 'fa-file-word', 'text' => 'text-blue-600', 'bg' => 'bg-blue-50 border-blue-100'],
                                    'xls', 'xlsx' => ['icon' => 'fa-file-excel', 'text' => 'text-green-600', 'bg' => 'bg-green-50 border-green-100'],
                                    'ppt', 'pptx' => ['icon' => 'fa-file-powerpoint', 'text' => 'text-orange-600', 'bg' => 'bg-orange-50 border-orange-100'],
                                    default => ['icon' => 'fa-file-alt', 'text' => 'text-slate-600', 'bg' => 'bg-slate-50 border-slate-200']
                                };
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors group">
                                <td class="px-6 py-4 align-middle">
                                    <div class="flex items-start gap-4">
                                        {{-- Icon Box: Rounded-lg (bukan lingkaran) --}}
                                        <div class="flex-shrink-0 w-10 h-10 {{ $style['bg'] }} border rounded-lg flex items-center justify-center">
                                            <i class="fas {{ $style['icon'] }} {{ $style['text'] }} text-lg"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-bold text-slate-800 group-hover:text-orange-600 transition-colors mb-1">
                                                {{ $document->name }}
                                            </h4>
                                            <div class="flex items-center gap-3 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="far fa-calendar-alt"></i> {{ $document->created_at->format('d/m/Y') }}
                                                </span>
                                                <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fas fa-download"></i> {{ $document->downloads }}x
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 hidden md:table-cell align-middle">
                                    @if($document->category)
                                        <span class="inline-block px-2.5 py-1 text-[11px] font-bold text-slate-600 bg-slate-100 border border-slate-200 rounded-md uppercase tracking-wide">
                                            {{ $document->category }}
                                        </span>
                                    @else 
                                        <span class="text-slate-400 text-xs">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 hidden sm:table-cell text-center align-middle">
                                    <span class="text-[10px] font-extrabold text-slate-400 uppercase border border-slate-200 px-2 py-0.5 rounded bg-white">
                                        {{ $ext }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right align-middle">
                                    <a href="{{ route('documents.download', $document) }}" 
                                       class="inline-flex items-center justify-center gap-2 px-4 py-2 bg-white border border-slate-300 hover:border-orange-500 text-slate-700 hover:text-orange-600 text-xs font-bold rounded-lg transition-all shadow-sm hover:shadow-md group/btn">
                                        <span>Unduh</span>
                                        <i class="fas fa-arrow-down group-hover/btn:translate-y-0.5 transition-transform"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                {{-- Pagination Area --}}
                @if($documents->hasPages())
                <div class="px-6 py-4 border-t border-slate-200 bg-slate-50/50">
                    {{ $documents->links() }}
                </div>
                @endif
            </div>
        @endif

        {{-- 3. Contact / Help Box (SESUAI REQUEST ANDA) --}}
        <div class="container mx-auto px-4 pb-20">
            <div class="relative bg-slate-900 rounded-[2rem] p-8 md:p-12 text-center overflow-hidden shadow-xl border border-white/5">
                <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
                <div class="absolute top-0 right-0 -mr-16 -mt-16 w-60 h-60 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
                
                <div class="relative z-10">
                    
                    <h2 class="text-2xl md:text-3xl font-black text-white mb-4 uppercase tracking-tight">
                        Butuh <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Bantuan?</span>
                    </h2>
                    
                    <p class="text-slate-400 max-w-xl mx-auto mb-8 text-base font-light">
                        Jika Anda tidak menemukan dokumen yang dicari atau mengalami kendala saat mengunduh, hubungi tim support kami.
                    </p>

                    <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP." target="_blank" class="inline-flex items-center gap-2 px-8 py-3.5 bg-orange-500 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-orange-500/40 hover:-translate-y-1 active:scale-95">
                        <i class="fab fa-whatsapp text-xl"></i> Hubungi Support
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
.perspective-1000 { perspective: 1000px; }
</style>
@endsection