@extends('layouts.app')

@section('title', 'Beranda - Fakultas Ekonomi dan Bisnis')

{{-- 
    KITA GUNAKAN @push('preloader') 
    Agar kode ini 'dilempar' ke posisi paling atas di layout (sebelum Navbar)
--}}
@push('preloader')
    <div id="feb-preloader" 
         class="fixed inset-0 flex items-center justify-center bg-white"
         style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #fff; z-index: 99999;">
         
        <div class="text-center relative">
            <div class="relative w-24 h-24 mx-auto mb-6 flex items-center justify-center">
                
                <svg class="animate-spin-fast" viewBox="0 0 100 100" width="100" height="100" style="width: 100px; height: 100px;">
                    <circle cx="50" cy="50" r="42" stroke="#f3f4f6" stroke-width="6" fill="none"></circle>
                    
                    <circle cx="50" cy="50" r="42" stroke="#D32F2F" stroke-width="6" fill="none" 
                            stroke-dasharray="264" stroke-dashoffset="200" stroke-linecap="round">
                    </circle>
                </svg>
                
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-orange-500 to-red-600" 
                          style="font-family: 'Merriweather', serif;">
                        FEB
                    </span>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2 tracking-wide animate-pulse" 
                style="font-family: 'Poppins', sans-serif;">
                Fakultas Ekonomi & Bisnis
            </h2>
            <p class="text-gray-500 text-sm tracking-[0.2em] uppercase" 
               style="font-family: 'Poppins', sans-serif;">
                UNSAP
            </p>
        </div>
    </div>

    <style>
        @keyframes spin-svg {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        /* REVISI KECEPATAN DI SINI */
        .animate-spin-fast {
            /* Ubah 1s menjadi 0.7s agar lebih ngebut */
            animation: spin-svg 0.7s linear infinite; 
            transform-origin: center;
        }
    </style>
@endpush

@section('content')
    @include('frontend.home.partials.hero')

    @include('frontend.home.partials.whatsapp-float')

    @include('frontend.home.partials.search-bar')

    @include('frontend.home.partials.quick-access')

    @include('frontend.home.partials.stats-counter')

    @include('frontend.home.partials.dean-welcome', ['dean_profile' => $dean_profile])

    @include('frontend.home.partials.latest-news', ['featured_news' => $featured_news])
    
    @include('frontend.home.partials.lecturers-profile', ['lecturers' => $lecturers])

    @include('frontend.home.partials.join-section')
    
    <div class="w-full bg-slate-50 py-12"></div>
    
    @include('frontend.home.partials.upcoming-events', ['events' => $events])

    @include('frontend.home.partials.journals-section')

    @include('frontend.home.partials.closing-banner')
@endsection

@push('head')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@700;900&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* Mengunci scroll bar SEJAK AWAL load */
    body {
        overflow: hidden; 
    }

    /* Mengembalikan scroll bar setelah loading selesai */
    body.loaded {
        overflow: auto !important;
        overflow-x: hidden !important;
    }

    #feb-preloader {
        transition: transform 0.8s cubic-bezier(0.77, 0, 0.175, 1);
    }
    
    .preloader-hidden {
        transform: translateY(-100%);
    }
    
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
@endpush

@push('scripts')
<script>
    window.addEventListener('load', function() {
        const preloader = document.getElementById('feb-preloader');
        
        // Delay 1.5 detik agar animasi sempat terlihat keren
        setTimeout(function() {
            preloader.classList.add('preloader-hidden');
            document.body.classList.add('loaded');
            
            setTimeout(() => {
                preloader.remove();
            }, 800);
        }, 1500); 
    });
</script>
@endpush