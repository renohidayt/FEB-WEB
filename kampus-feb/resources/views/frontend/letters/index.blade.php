@extends('layouts.app')

@section('title', 'Pengajuan Surat')

@section('content')

{{-- 2. HERO BANNER --}}
<div class="relative bg-slate-900 text-white pt-10 pb-10 overflow-hidden border-b border-white/5 font-poppins">
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
            <span class="text-orange-500 font-semibold cursor-default">Pengajuan Surat</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            {{-- Text Content --}}
            <div class="text-left animate-fade-in-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Layanan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Administrasi</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Permudah kebutuhan akademik Anda melalui sistem pengajuan surat digital. Cepat, transparan, dan dapat diakses dari mana saja.
                </p>
            </div>

            {{-- 3D Visual Element (Adapted for Documents) --}}
            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                {{-- Main Card --}}
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 transition-transform duration-700 hover:rotate-y-0">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        {{-- Icon changed to Document --}}
                        <i class="fas fa-file-signature text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500"></i>
                    </div>
                    <div class="space-y-3 px-2">
                        <div class="h-2 bg-orange-500/40 rounded-full w-3/4 mx-auto"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2 mx-auto"></div>
                    </div>
                </div>

                {{-- Floating Badge 1 --}}
                <div class="absolute -top-4 right-8 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-3 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <i class="fas fa-bolt text-orange-500 text-xl"></i>
                </div>
                
                {{-- Floating Badge 2 --}}
                <div class="absolute -bottom-4 left-8 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-2 font-bold text-xs text-white">
                        <i class="fas fa-print text-blue-400"></i> Digital & Paperless
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 3. MAIN CONTENT (Clean White Background) --}}
{{-- 3. MAIN CONTENT (Clean White Background) --}}
{{-- Hapus min-h-screen, kurangi py-12 jadi py-8 agar bawahnya tidak terlalu lowong --}}
<div class="bg-slate-50 font-poppins text-slate-800 py-8">
    
    {{-- Hapus -mt-20, ganti jadi mt-0 atau mt-4 supaya benar-benar di bawah banner --}}
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4 relative z-20">
        {{-- FLASH MESSAGES --}}
        @if(session('success'))
        ...
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 flex items-start gap-3 shadow-sm">
            <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg mb-6 flex items-start gap-3 shadow-sm">
            <i class="fas fa-exclamation-circle mt-0.5 text-red-600"></i>
            <span class="text-sm font-medium">{{ session('error') }}</span>
        </div>
        @endif

        {{-- GUEST NOTICE --}}
        @guest
        <div class="bg-white border border-orange-200 rounded-lg p-6 mb-8 shadow-lg">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-orange-50 rounded-lg text-orange-600">
                    <i class="fas fa-lock"></i>
                </div>
                <div>
                    <h3 class="font-bold text-slate-900">Akses Terbatas</h3>
                    <p class="text-sm text-slate-600 mt-1 mb-4">
                        Anda dapat melihat daftar template, namun wajib login untuk melakukan pengajuan.
                    </p>
                    <div class="flex gap-3">
                        <a href="{{ route('student.login') }}" class="px-4 py-2 bg-orange-600 text-white text-sm font-medium rounded hover:bg-orange-700 transition">
                            Login Mahasiswa
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endguest

        {{-- MAIN LAYOUT GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            
            {{-- LEFT COLUMN: TEMPLATES LIST (Wider) --}}
            <div class="{{ auth()->check() ? 'lg:col-span-8' : 'lg:col-span-12' }}">
                <div class="flex items-center justify-between mb-4 px-1">
                    <h3 class="font-bold text-slate-700 text-xs uppercase tracking-wider">Pilih Dokumen ({{ $templates->count() }})</h3>
                </div>

                @if($templates->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        @foreach($templates as $template)
                        <div class="bg-white border border-slate-200 rounded-lg p-5 shadow-sm hover:border-orange-300 hover:shadow-lg hover:-translate-y-1 transition-all duration-300 group flex flex-col h-full relative overflow-hidden">
                            {{-- Decorative corner --}}
                            <div class="absolute top-0 right-0 w-16 h-16 bg-gradient-to-br from-slate-50 to-slate-100 rounded-bl-full -mr-8 -mt-8 z-0"></div>

                            <div class="flex items-start justify-between mb-4 relative z-10">
                                <div class="w-10 h-10 rounded bg-blue-50 text-blue-600 flex items-center justify-center group-hover:bg-orange-50 group-hover:text-orange-600 transition-colors border border-blue-100 group-hover:border-orange-100">
                                    <i class="fas fa-envelope-open-text"></i>
                                </div>
                                <span class="text-[10px] font-semibold bg-slate-100 text-slate-500 px-2 py-1 rounded border border-slate-200">
                                    Form Digital
                                </span>
                            </div>
                            
                            <h4 class="font-bold text-slate-800 text-base mb-2 group-hover:text-orange-600 transition-colors relative z-10">
                                {{ $template->title }}
                            </h4>
                            
                            <p class="text-sm text-slate-500 line-clamp-2 mb-6 flex-1 relative z-10">
                                {{ $template->description ?? 'Dokumen resmi akademik untuk keperluan mahasiswa.' }}
                            </p>
                            
                            @auth
                                <a href="{{ route('letters.create', $template) }}" class="relative z-10 w-full mt-auto flex items-center justify-center gap-2 py-2.5 rounded bg-slate-50 border border-slate-200 text-slate-600 text-sm font-medium hover:bg-orange-600 hover:text-white hover:border-orange-600 transition-all">
                                    Ajukan Dokumen <i class="fas fa-arrow-right text-xs"></i>
                                </a>
                            @else
                                <a href="{{ route('student.login') }}" class="relative z-10 w-full mt-auto block text-center py-2.5 rounded bg-slate-50 border border-slate-200 text-slate-400 text-sm font-medium cursor-not-allowed">
                                    <i class="fas fa-lock text-xs mr-1"></i> Login Required
                                </a>
                            @endauth
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-white border border-slate-200 border-dashed rounded-lg p-12 text-center shadow-sm">
                        <i class="fas fa-folder-open text-slate-300 text-4xl mb-3"></i>
                        <p class="text-slate-500 font-medium">Belum ada template surat tersedia saat ini.</p>
                    </div>
                @endif
            </div>

            {{-- RIGHT COLUMN: HISTORY (Sidebar) --}}
            @auth
            <div class="lg:col-span-4">
                <div class="flex items-center justify-between mb-4 px-1">
                    <h3 class="font-bold text-slate-700 text-xs uppercase tracking-wider">Aktivitas Terakhir</h3>
                    <a href="{{ route('letters.index') }}" class="text-xs text-orange-600 hover:underline">Semua</a>
                </div>

                <div class="bg-white border border-slate-200 rounded-lg shadow-lg overflow-hidden sticky top-24">
                    <div class="bg-slate-50 px-4 py-3 border-b border-slate-200">
                        <span class="text-xs font-semibold text-slate-500">Status Pengajuan</span>
                    </div>

                    @if($submissions->count() > 0)
                        <div class="divide-y divide-slate-100">
                            @foreach($submissions->take(5) as $submission)
                            <div class="p-4 hover:bg-slate-50 transition-colors group">
                                <div class="flex justify-between items-start mb-2">
                                    <span class="text-[10px] font-bold text-slate-400 bg-slate-100 px-1.5 py-0.5 rounded">
                                        {{ $submission->submitted_at->format('d/m/Y') }}
                                    </span>
                                    {{-- Status Badge Container --}}
                                    <div class="scale-90 origin-right">
                                        {!! $submission->status_badge !!}
                                    </div>
                                </div>
                                
                                <h5 class="text-sm font-bold text-slate-800 mb-1 truncate pr-2">
                                    {{ $submission->template->title ?? 'Template Dihapus' }}
                                </h5>

                                <a href="{{ route('letters.show', $submission) }}" class="inline-flex items-center text-xs text-blue-600 font-medium hover:text-orange-600 transition-colors mt-1">
                                    Lihat Detail <i class="fas fa-chevron-right text-[9px] ml-1"></i>
                                </a>
                            </div>
                            @endforeach
                        </div>
                        
                        @if($submissions->hasMorePages())
                        <div class="p-3 bg-slate-50 border-t border-slate-100 text-center hover:bg-slate-100 transition-colors cursor-pointer">
                            <a href="{{ route('letters.index') }}" class="text-xs font-bold text-slate-500 hover:text-orange-600 block w-full h-full">
                                Lihat Riwayat Lengkap
                            </a>
                        </div>
                        @endif
                    @else
                        <div class="p-8 text-center">
                            <div class="w-12 h-12 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-3 text-slate-300">
                                <i class="far fa-clock"></i>
                            </div>
                            <p class="text-sm text-slate-500">Belum ada riwayat pengajuan.</p>
                        </div>
                    @endif
                </div>
            </div>
            @endauth

        </div>
    </div>
</div>
@endsection