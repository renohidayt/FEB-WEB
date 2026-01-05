@extends('layouts.app')

@section('title', 'Fasilitas - Fakultas Ekonomi dan Bisnis')

@section('content')
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="/" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">Fasilitas</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight">
                    Fasilitas <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Unggulan</span>
                </h1>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Menunjang kegiatan akademik dan kreativitas mahasiswa dengan infrastruktur modern serta lingkungan kampus yang nyaman dan kondusif.
                </p>
            </div>
            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="flex items-center gap-1.5 mb-4 opacity-50">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    </div>
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-24 rounded-lg mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-building text-4xl text-slate-600 group-hover:text-orange-500 transition-colors duration-500"></i>
                    </div>
                    <div class="space-y-2">
                        <div class="h-2 bg-slate-600/30 rounded-full w-3/4"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2"></div>
                    </div>
                </div>
                <div class="absolute top-4 right-8 bg-slate-800/80 backdrop-blur-md border border-orange-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-400">
                            <i class="fas fa-wifi text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Koneksi</p>
                            <p class="text-xs font-bold leading-none">High Speed</p>
                        </div>
                    </div>
                </div>
                <div class="absolute bottom-4 left-8 bg-slate-800/80 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-book-reader text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Akses</p>
                            <p class="text-xs font-bold leading-none">Smart Library</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="sticky top-0 z-40 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm transition-all duration-300" id="navbar-filter">
    <div class="container mx-auto px-4 py-4">
        <form method="GET" action="{{ route('facilities.index') }}" class="flex flex-col md:flex-row gap-4 items-center justify-between">
            <div class="flex overflow-x-auto hide-scrollbar gap-2 w-full md:w-auto pb-2 md:pb-0">
                <a href="{{ route('facilities.index') }}" 
                   class="px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 border
                   {{ !request('category') 
                       ? 'bg-slate-900 text-white border-slate-900 shadow-md' 
                       : 'bg-white text-slate-600 border-slate-200 hover:border-orange-500 hover:text-orange-600' }}">
                    Semua
                </a>
                @foreach(\App\Models\Facility::categories() as $key => $label)
                    <a href="{{ route('facilities.index', ['category' => $key]) }}" 
                       class="px-5 py-2.5 rounded-full text-sm font-medium whitespace-nowrap transition-all duration-200 border
                       {{ request('category') == $key 
                           ? 'bg-slate-900 text-white border-slate-900 shadow-md' 
                           : 'bg-white text-slate-600 border-slate-200 hover:border-orange-500 hover:text-orange-600' }}">
                        {{ $label }}
                    </a>
                @endforeach
            </div>
            <div class="flex items-center gap-3 text-sm ml-auto">
                @if(request('category'))
                    <a href="{{ route('facilities.index') }}" 
                       class="text-slate-500 hover:text-red-600 font-medium transition-colors flex items-center">
                        <i class="fas fa-times-circle mr-1"></i> Reset Filter
                    </a>
                    <div class="h-4 w-px bg-slate-300"></div>
                @endif
                <div class="text-slate-600 bg-slate-100 px-3 py-1 rounded-md">
                    <span class="font-bold text-slate-900">{{ $facilities->total() }}</span> Fasilitas
                </div>
            </div>
        </form>
    </div>
</div>

<div class="py-12 bg-slate-50 min-h-screen">
    <div class="container mx-auto px-4">
        @if($facilities->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($facilities as $facility)
                <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-slate-100 overflow-hidden flex flex-col h-full">
                    <div class="relative h-60 overflow-hidden bg-slate-200">
                        @if($facility->photos->count() > 0)
                            <img src="{{ asset('storage/' . $facility->photos->first()->photo) }}" 
                                 alt="{{ $facility->name }}"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute top-4 left-4 z-10">
                                <span class="bg-orange-600/90 backdrop-blur-sm text-white px-3 py-1 rounded-lg text-xs font-bold uppercase tracking-wider shadow-lg">
                                    {{ $facility->category }}
                                </span>
                            </div>
                            @if($facility->photos->count() > 1)
                                <div class="absolute bottom-4 right-4 z-10">
                                    <span class="bg-black/60 backdrop-blur-sm text-white px-3 py-1 rounded-full text-xs flex items-center gap-1">
                                        <i class="fas fa-camera"></i> {{ $facility->photos->count() }}
                                    </span>
                                </div>
                            @endif
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-slate-400 bg-slate-100">
                                <i class="fas fa-image text-4xl mb-2 opacity-50"></i>
                                <span class="text-xs">No Image</span>
                            </div>
                        @endif
                        <div class="absolute inset-0 bg-slate-900/20 opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3 class="text-xl font-bold text-slate-800 mb-2 group-hover:text-orange-600 transition-colors line-clamp-1">
                                {{ $facility->name }}
                            </h3>
                            @if($facility->capacity)
                                <div class="flex items-center text-slate-500 text-sm">
                                    <i class="fas fa-user-friends w-5 text-center text-orange-500 mr-2"></i>
                                    <span>Kapasitas: <span class="font-semibold text-slate-700">{{ $facility->capacity }}</span> orang</span>
                                </div>
                            @endif
                        </div>
                        @if($facility->description)
                            <p class="text-slate-600 text-sm leading-relaxed line-clamp-2 mb-6 flex-1">
                                {{ $facility->description }}
                            </p>
                        @endif
                        <button type="button" data-facility-id="{{ $facility->id }}" class="facility-open-btn w-full py-3 px-4 rounded-xl border border-slate-200 text-slate-700 font-semibold text-sm hover:bg-slate-900 hover:text-white hover:border-slate-900 transition-all duration-300 flex items-center justify-center gap-2 group-hover:shadow-md">
                            <span>Lihat Detail</span>
                            <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-12 flex justify-center">
                {{ $facilities->links() }}
            </div>
        @else
            <div class="flex flex-col items-center justify-center py-20 text-center">
                <div class="w-24 h-24 bg-orange-50 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-search text-orange-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-slate-800 mb-2">Data Tidak Ditemukan</h3>
                <p class="text-slate-500 max-w-md mx-auto mb-8">
                    Maaf, kami tidak dapat menemukan fasilitas yang sesuai dengan kategori atau pencarian Anda.
                </p>
                <a href="{{ route('facilities.index') }}" class="px-6 py-3 bg-slate-900 text-white rounded-lg hover:bg-slate-800 transition-colors shadow-lg shadow-slate-900/20">
                    Tampilkan Semua Fasilitas
                </a>
            </div>
        @endif
    </div>
</div>

<!-- MODAL DENGAN POINTER-EVENTS -->
<div id="facilityModal" class="fixed inset-0 hidden" style="z-index: 99999;">
    <!-- Backdrop -->
    <div id="facilityBackdrop" class="fixed inset-0 bg-slate-900/90 backdrop-blur-sm opacity-0 transition-opacity duration-300" style="pointer-events: auto;"></div>

    <!-- Container -->
    <div class="fixed inset-0 overflow-y-auto" style="pointer-events: none;">
        <div class="flex min-h-full items-center justify-center p-4">
            
            <!-- Panel -->
            <div id="facilityPanel" class="relative bg-white rounded-2xl shadow-2xl w-full max-w-4xl transform scale-95 opacity-0 transition-all duration-300" style="pointer-events: auto;">
                
                <!-- Tombol Close dengan style inline -->
                <button type="button" id="facilityCloseBtn" 
                        style="position: absolute; top: 1rem; right: 1rem; z-index: 100; width: 2.5rem; height: 2.5rem; background: white; border: 2px solid #e2e8f0; border-radius: 9999px; display: flex; align-items: center; justify-content: center; cursor: pointer; pointer-events: auto;"
                        onmouseover="this.style.background='#fee2e2'; this.style.borderColor='#dc2626'; this.style.color='#dc2626';"
                        onmouseout="this.style.background='white'; this.style.borderColor='#e2e8f0'; this.style.color='#475569';">
                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <!-- Content Area -->
                <div class="max-h-[85vh] overflow-y-auto">
                    <div id="facilityContent" class="p-8 text-center">
                        <i class="fas fa-circle-notch fa-spin text-orange-500 text-4xl"></i>
                        <p class="text-slate-500 mt-4">Memuat...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hide-scrollbar::-webkit-scrollbar { display: none; }
    .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
</style>

<script>
(function() {
    'use strict';
    
    console.log('🟢 Facility Modal Script Started');

    const facilitiesData = @json($facilities->items());
    console.log('📦 Facilities Data:', facilitiesData.length, 'items');

    const modal = document.getElementById('facilityModal');
    const backdrop = document.getElementById('facilityBackdrop');
    const panel = document.getElementById('facilityPanel');
    const closeBtn = document.getElementById('facilityCloseBtn');
    const contentDiv = document.getElementById('facilityContent');

    console.log('🔍 Elements Found:', {
        modal: !!modal,
        backdrop: !!backdrop,
        panel: !!panel,
        closeBtn: !!closeBtn,
        contentDiv: !!contentDiv
    });

    function openModal(facilityId) {
        console.log('🔵 Opening Modal for Facility ID:', facilityId);
        
        const item = facilitiesData.find(f => f.id === facilityId);
        if (!item) {
            console.error('❌ Facility not found:', facilityId);
            return;
        }

        console.log('✅ Facility Found:', item.name);

        // Render Content
        let galleryHtml = '';
        if (item.photos && item.photos.length > 0) {
            const mainPhoto = `/storage/${item.photos[0].photo}`;
            
            let thumbnails = '';
            if (item.photos.length > 1) {
                thumbnails = `
                    <div class="flex gap-2 mt-4 overflow-x-auto pb-2 hide-scrollbar">
                        ${item.photos.map((p, idx) => `
                            <button type="button" class="facility-thumb-btn flex-shrink-0 w-16 h-16 rounded-lg overflow-hidden border-2 border-transparent hover:border-orange-500 transition-all" data-image="/storage/${p.photo}" data-index="${idx}">
                                <img src="/storage/${p.photo}" class="w-full h-full object-cover">
                            </button>
                        `).join('')}
                    </div>`;
            }

            galleryHtml = `
                <div class="relative bg-slate-900 aspect-video w-full">
                    <img id="facilityMainImage" src="${mainPhoto}" class="w-full h-full object-contain">
                </div>
                ${thumbnails}
            `;
        } else {
            galleryHtml = `
                <div class="aspect-video w-full bg-slate-100 flex items-center justify-center text-slate-400">
                    <div class="text-center">
                        <i class="fas fa-image text-5xl mb-3 opacity-50"></i>
                        <p>Tidak ada foto</p>
                    </div>
                </div>`;
        }

        contentDiv.innerHTML = `
            ${galleryHtml}
            <div class="p-6">
                <div class="flex flex-wrap items-center gap-3 mb-4">
                    <span class="px-3 py-1 rounded-full bg-orange-100 text-orange-700 text-xs font-bold uppercase tracking-wider">
                        ${item.category}
                    </span>
                    ${item.capacity ? `
                        <span class="flex items-center text-slate-500 text-sm font-medium">
                            <i class="fas fa-users text-orange-500 mr-2"></i> ${item.capacity} Orang
                        </span>` : ''}
                </div>
                
                <h2 class="text-2xl font-bold text-slate-800 mb-4">${item.name}</h2>
                
                <div class="prose prose-sm prose-slate max-w-none text-slate-600">
                    ${item.description || 'Tidak ada deskripsi.'}
                </div>
            </div>
        `;

        // Attach thumbnail listeners
        const thumbBtns = contentDiv.querySelectorAll('.facility-thumb-btn');
        thumbBtns.forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const newImage = this.getAttribute('data-image');
                console.log('🖼️ Changing image to:', newImage);
                document.getElementById('facilityMainImage').src = newImage;
            });
        });

        // Show modal
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';

        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            backdrop.classList.add('opacity-100');
            panel.classList.remove('scale-95', 'opacity-0');
            panel.classList.add('scale-100', 'opacity-100');
        }, 10);

        console.log('✅ Modal Opened');
    }

    function closeModal() {
        console.log('🔴 Closing Modal');
        
        backdrop.classList.remove('opacity-100');
        backdrop.classList.add('opacity-0');
        panel.classList.remove('scale-100', 'opacity-100');
        panel.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            console.log('✅ Modal Closed');
        }, 300);
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', function() {
        console.log('🟢 DOM Content Loaded');

        // 1. Open buttons
        const openBtns = document.querySelectorAll('.facility-open-btn');
        console.log('🔘 Found', openBtns.length, 'open buttons');
        
        openBtns.forEach((btn, idx) => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                const facilityId = parseInt(this.getAttribute('data-facility-id'));
                console.log(`🔘 Button ${idx + 1} clicked, Facility ID:`, facilityId);
                openModal(facilityId);
            });
        });

        // 2. Close button
        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                console.log('❌ Close Button Clicked');
                e.preventDefault();
                e.stopPropagation();
                closeModal();
            });
            console.log('✅ Close button listener attached');
        } else {
            console.error('❌ Close button not found!');
        }

        // 3. Backdrop
        if (backdrop) {
            backdrop.addEventListener('click', function(e) {
                console.log('🌑 Backdrop Clicked');
                e.preventDefault();
                closeModal();
            });
            console.log('✅ Backdrop listener attached');
        }

        // 4. ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                console.log('⌨️ ESC Key Pressed');
                closeModal();
            }
        });
        console.log('✅ ESC listener attached');

        // 5. Prevent panel clicks from closing
        if (panel) {
            panel.addEventListener('click', function(e) {
                console.log('📦 Panel Clicked - Preventing propagation');
                e.stopPropagation();
            });
        }

        console.log('✅ All Event Listeners Attached');
    });
})();
</script>
@endsection