@extends('layouts.app')

@section('title', 'Struktur Organisasi - Fakultas Ekonomi dan Bisnis')

@section('content')

<!-- Header dengan Icon dan Gradient -->
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
            <span class="text-orange-500 font-semibold cursor-default">Struktur Organisasi</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Struktur <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Organisasi</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Susunan organisasi dan kepemimpinan Fakultas Ekonomi dan Bisnis yang solid, transparan, dan profesional.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-sitemap text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                    </div>

                    <div class="flex flex-col items-center gap-2">
                        <div class="h-1.5 bg-orange-500/50 rounded-full w-1/2"></div>
                        <div class="flex gap-4 w-full justify-center">
                            <div class="h-1.5 bg-slate-600/30 rounded-full w-1/4"></div>
                            <div class="h-1.5 bg-slate-600/30 rounded-full w-1/4"></div>
                        </div>
                    </div>
                </div>

                <div class="absolute -top-4 right-4 bg-slate-800/90 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3.5s;">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-user-tie text-orange-500 text-xl mb-1"></i>
                        <span class="text-[10px] font-bold text-white tracking-wider uppercase">Leadership</span>
                    </div>
                </div>

                <div class="absolute -bottom-4 left-4 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4.5s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-users text-sm"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-200 font-mono">Solid Team</p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>


<!-- Organization Chart Section dengan Background Gradient -->
<div class="py-16 bg-slate-50">

    <div class="container mx-auto px-4">
        @if($structures->count() > 0)

                <!-- Organization Tree -->
                <div class="org-chart-container overflow-x-auto pb-8">
                    <div class="flex justify-center min-w-max">
                        @foreach($structures->where('parent_id', null) as $root)
                            @include('frontend.profile.partials.tree-node', [
                                'node' => $root,
                                'level' => 0
                            ])
                        @endforeach
                    </div>
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="max-w-2xl mx-auto bg-white/10 backdrop-blur-md rounded-2xl p-12 text-center border border-white/20">
                <i class="fas fa-sitemap text-6xl text-white opacity-50 mb-4"></i>
                <h3 class="text-2xl font-bold text-white mb-2">Data Belum Tersedia</h3>
                <p class="text-white/90">Struktur organisasi sedang dalam proses penyusunan.</p>
            </div>
        @endif
    </div>
</div>
<div class="py-16 bg-[#F8F9FA]">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="text-center mb-12">
                <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 text-xs font-bold uppercase tracking-wider mb-4 font-poppins">
                    Keterangan
                </span>
                <h3 class="text-3xl font-bold text-[#1a1a2e] font-poppins">
                    Kategori Posisi
                </h3>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform"
                             style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);">
                            <i class="fas fa-user-tie text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 font-poppins">Struktural</h4>
                    </div>
                    <p class="text-gray-600 leading-relaxed">Pejabat struktural yang mengelola fakultas seperti Dekan dan Wakil Dekan</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform"
                             style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
                            <i class="fas fa-chalkboard-teacher text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 font-poppins">Akademik</h4>
                    </div>
                    <p class="text-gray-600 leading-relaxed">Unit yang menangani proses akademik seperti Program Studi dan Departemen</p>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100 hover:shadow-xl transition-all duration-300 group">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 rounded-xl flex items-center justify-center mr-4 group-hover:scale-110 transition-transform"
                             style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);">
                            <i class="fas fa-cogs text-white text-2xl"></i>
                        </div>
                        <h4 class="text-xl font-bold text-gray-800 font-poppins">Administratif</h4>
                    </div>
                    <p class="text-gray-600 leading-relaxed">Unit administrasi dan layanan pendukung operasional fakultas</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Additional Info from Profile Model (if exists) -->
@if($struktur && $struktur->content)
<div class="py-16 bg-white">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-12 relative overflow-hidden group">
                <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-8 -mt-8 z-0"></div>
                
                <div class="relative z-10">
                    @if($struktur->name)
                        <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 text-xs font-bold uppercase tracking-wider mb-4">
                            Informasi Tambahan
                        </span>
                        <h3 class="text-3xl font-bold text-[#1a1a2e] mb-6">{{ $struktur->name }}</h3>
                    @endif
                    
                    <article class="prose prose-lg prose-slate max-w-none 
                                    prose-headings:text-[#1a1a2e] prose-headings:font-bold
                                    prose-p:text-gray-600 prose-p:leading-relaxed prose-p:text-justify
                                    prose-li:marker:text-orange-500 prose-li:text-gray-600
                                    prose-strong:text-orange-600 prose-strong:font-bold"
                         style="text-align: justify;">
                        {!! nl2br(e($struktur->content)) !!}
                    </article>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<style>

    
    /* --- RESET & LAYOUT DASAR --- */
    .org-chart-container {
        padding: 20px 0;
    }

    .tree, .tree ul, .staff-tree {
        padding-top: 15px; 
        position: relative;
        transition: all 0.5s;
        display: flex;
        justify-content: center;
        margin: 0;
        padding-left: 0;
    }

    .tree li {
        float: left; 
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 15px 5px 0 5px;
        transition: all 0.5s;
    }

    /* --- LOGIKA GARIS (MAGIC LINES) --- */
    .tree li::before, .tree li::after {
        content: '';
        position: absolute; 
        top: 0; 
        right: 50%;
        border-top: 3px solid rgba(255,255,255,0.6);
        width: 50%; 
        height: 15px;
    }
    
    .tree li::after {
        right: auto; 
        left: 50%;
        border-left: 3px solid rgba(255,255,255,0.6);
    }

    .tree li:only-child::after, .tree li:only-child::before {
        display: none;
    }
    .tree li:only-child { 
        padding-top: 0;
    }

    .tree li:first-child::before, .tree li:last-child::after {
        border: 0 none;
    }
    
    .tree li:last-child::before {
        border-right: 3px solid rgba(255,255,255,0.6);
        border-radius: 0 5px 0 0;
    }
    .tree li:first-child::after {
        border-radius: 5px 0 0 0;
    }

    .tree ul::before {
        content: '';
        position: absolute; 
        top: 0; 
        left: 50%;
        border-left: 3px solid rgba(255,255,255,0.6);
        width: 0; 
        height: 15px;
    }

    /* --- STYLE STAFF KHUSUS (GARIS PUTUS-PUTUS KE DEKAN) --- */
    .staff-tree {
        position: relative;
    }

    .staff-tree::before {
        content: '';
        position: absolute;
        left: 50%;
        bottom: 100%;
        width: 3px;
        height: calc(100% + 15px);
        background: repeating-linear-gradient(
            to bottom,
            rgba(255,255,255,0.6) 0px,
            rgba(255,255,255,0.6) 5px,
            transparent 5px,
            transparent 10px
        );
        transform: translateX(-1.5px);
        z-index: 1;
    }

    .staff-tree li::before, 
    .staff-tree li::after {
        border-top: 3px solid rgba(255,255,255,0.6);
    }

    .staff-tree::after {
        content: '';
        position: absolute;
        left: 50%;
        top: 0;
        width: 3px;
        height: 15px;
        background: rgba(255,255,255,0.6);
        transform: translateX(-1.5px);
        z-index: 2;
    }

    /* --- KARTU (NODE) DESIGN --- */
    .node-content {
        border: 2px solid rgba(255,255,255,0.4);
        padding: 14px;
        text-decoration: none;
        color: white;
        display: inline-block;
        border-radius: 16px;
        transition: all 0.3s;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(12px);
        min-width: 150px;
        max-width: 170px;
        position: relative;
        z-index: 10;
        box-shadow: 0 8px 16px rgba(0,0,0,0.3);
    }

    .node-content-small {
        border: 2px solid rgba(255,255,255,0.4);
        padding: 12px;
        color: white;
        display: inline-block;
        border-radius: 14px;
        min-width: 130px;
        max-width: 145px;
        position: relative;
        z-index: 10;
        box-shadow: 0 6px 14px rgba(0,0,0,0.25);
        background: rgba(255, 255, 255, 0.12);
        backdrop-filter: blur(10px);
        transition: all 0.3s;
    }

    .node-content:hover, .node-content-small:hover {
        transform: translateY(-8px) scale(1.08);
        box-shadow: 0 12px 28px rgba(0,0,0,0.4);
        z-index: 20;
        background: rgba(255, 255, 255, 0.2);
    }

    /* --- TYPOGRAPHY & IMAGES --- */
    .node-photo {
        width: 70px; 
        height: 70px;
        border-radius: 50%; 
        border: 4px solid rgba(255,255,255,0.6);
        object-fit: cover; 
        margin: 0 auto 10px;
        display: block;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .node-photo-small {
        width: 55px; 
        height: 55px;
        border-radius: 50%; 
        border: 3px solid rgba(255,255,255,0.6);
        object-fit: cover; 
        margin: 0 auto 8px;
        display: block;
        box-shadow: 0 3px 10px rgba(0,0,0,0.25);
    }
    .node-placeholder, .node-placeholder-small {
        border-radius: 50%; 
        border: 4px solid rgba(255,255,255,0.4);
        background: rgba(255,255,255,0.25);
        display: flex; 
        align-items: center; 
        justify-content: center;
        margin: 0 auto 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    }
    .node-placeholder { 
        width: 70px; 
        height: 70px; 
        font-size: 28px; 
    }
    .node-placeholder-small { 
        width: 55px; 
        height: 55px; 
        font-size: 24px;
        border-width: 3px;
        margin-bottom: 8px;
    }

    .text-content h4 { 
        font-weight: bold; 
        font-size: 12px; 
        margin: 0; 
        line-height: 1.4; 
        text-transform: uppercase;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .text-content h5 { 
        font-weight: bold; 
        font-size: 11px; 
        margin: 0; 
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
    }
    .text-content p { 
        font-size: 10px; 
        margin: 5px 0 0; 
        opacity: 0.95; 
        text-transform: uppercase; 
        font-weight: 600;
        text-shadow: 0 1px 3px rgba(0,0,0,0.3);
    }
    .text-content small { 
        font-size: 9px; 
        opacity: 0.85; 
        display: block; 
        margin-top: 3px;
        text-shadow: 0 1px 2px rgba(0,0,0,0.3);
    }

    /* COLORS - Enhanced dengan backdrop blur */
    .structural { 
        background: linear-gradient(135deg, rgba(59, 130, 246, 0.95) 0%, rgba(37, 99, 235, 0.95) 100%);
        backdrop-filter: blur(12px);
    }
    .academic { 
        background: linear-gradient(135deg, rgba(16, 185, 129, 0.95) 0%, rgba(5, 150, 105, 0.95) 100%);
        backdrop-filter: blur(12px);
    }
    .administrative { 
        background: linear-gradient(135deg, rgba(139, 92, 246, 0.95) 0%, rgba(124, 58, 237, 0.95) 100%);
        backdrop-filter: blur(12px);
    }

    /* Responsive untuk layar kecil */
    @media (max-width: 768px) {
        .node-content {
            min-width: 120px;
            max-width: 130px;
            padding: 12px;
        }
        
        .node-content-small {
            min-width: 100px;
            max-width: 110px;
            padding: 10px;
        }
        
        .node-photo {
            width: 50px;
            height: 50px;
        }
        
        .node-photo-small {
            width: 42px;
            height: 42px;
        }
        
        .text-content h4 { font-size: 10px; }
        .text-content h5 { font-size: 9px; }
        .text-content p { font-size: 8px; }
        .text-content small { font-size: 7px; }
    }
</style>

<script>
    // Hitung jarak dinamis antara Dekan dan Staff Tree
    document.addEventListener('DOMContentLoaded', function() {
        const dekanNode = document.getElementById('dekan-node');
        const staffTree = document.getElementById('staff-tree');
        
        if (dekanNode && staffTree) {
            function updateStaffLine() {
                const dekanRect = dekanNode.getBoundingClientRect();
                const staffRect = staffTree.getBoundingClientRect();
                
                const dekanBottom = dekanRect.bottom;
                const staffTop = staffRect.top;
                const distance = staffTop - dekanBottom;
                
                const style = document.createElement('style');
                style.innerHTML = `
                    .staff-tree::before {
                        height: ${distance}px !important;
                        top: ${-distance}px !important;
                    }
                `;
                document.head.appendChild(style);
            }
            
            updateStaffLine();
            window.addEventListener('resize', updateStaffLine);
            setTimeout(updateStaffLine, 100);
        }
    });
</script>
@endsection