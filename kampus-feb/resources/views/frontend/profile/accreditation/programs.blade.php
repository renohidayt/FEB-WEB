@extends('layouts.app')

@section('title', 'Akreditasi Program Studi - STIE Sebelas April')

@section('content')

<!-- Hero Section dengan Icon Gesture -->
<div class="relative bg-slate-900 text-white pt-6 pb-20 overflow-hidden border-b border-white/5">
    {{-- Background Decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-12">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span>Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <a href="{{ route('profile.accreditation.index') }}" class="text-slate-400 hover:text-white transition-colors">Akreditasi</a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default uppercase tracking-wider text-xs">Program Studi</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Text Content --}}
            <div class="animate-fade-in-left">
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
                    Program <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Studi</span>
                </h1>
                
                <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>
                
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-xl">
                    Daftar lengkap status akreditasi program studi yang masih berlaku di Fakultas Ekonomi dan Bisnis Universitas Sebelas April.
                </p>
            </div>

            {{-- Illustration Area --}}
            <div class="hidden lg:flex justify-center relative">
                {{-- Glow Effect --}}
                <div class="absolute w-64 h-64 bg-orange-500/10 rounded-full blur-[80px]"></div>

                {{-- Main Icon Logic (Glassmorphism) --}}
                <div class="relative w-72 h-72 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl flex items-center justify-center transform -rotate-3 hover:rotate-0 transition-all duration-700 group">
                    {{-- Graduation Cap Icon --}}
                    <i class="fas fa-graduation-cap text-8xl text-slate-700 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>

                    {{-- Small Floating Badge (Top Right) --}}
                    <div class="absolute -top-6 -right-6 bg-slate-800 border border-orange-500/50 p-5 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                        <i class="fas fa-award text-orange-500 text-3xl"></i>
                    </div>

                    {{-- Small Floating Badge (Bottom Left) --}}
                    <div class="absolute -bottom-6 -left-6 bg-slate-800 border border-blue-500/30 p-4 rounded-2xl shadow-xl animate-pulse">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 text-xs">
                                <i class="fas fa-university"></i>
                            </div>
                            <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Resmi BAN-PT/LAMEMBA</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- Decorative Elements -->
    <div class="absolute bottom-0 left-0 right-0 h-32 bg-gradient-to-t from-gray-50 to-transparent"></div>
</div>

<!-- Main Content -->
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">

            @if($accreditations->count() > 0)

                @if($groupedByCategory->count() > 1)
                    <!-- Grouped by Category -->
                    @foreach($groupedByCategory as $category => $items)
                    <div class="mb-10">
                        <!-- Category Header -->
                        <div class="bg-gradient-to-r from-orange-600 to-red-600 rounded-2xl p-6 mb-6 shadow-md">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                                    <i class="fas fa-layer-group text-white text-xl"></i>
                                </div>
                                <div>
                                    <h2 class="text-2xl font-bold text-white">{{ $category ?: 'Umum' }}</h2>
                                    <p class="text-orange-100 text-sm">{{ $items->count() }} program studi</p>
                                </div>
                            </div>
                        </div>

                        <!-- Programs Grid - Centered -->
                        <div class="flex justify-center">
                            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">
                                @foreach($items as $accreditation)
                                    @include('frontend.profile.accreditation.partials.program-card', ['accreditation' => $accreditation])
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                @else
                    <!-- No Category / Single List - Centered -->
                    <div class="flex justify-center">
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 w-full max-w-6xl">
                            @foreach($accreditations as $accreditation)
                                @include('frontend.profile.accreditation.partials.program-card', ['accreditation' => $accreditation])
                            @endforeach
                        </div>
                    </div>
                @endif
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-20 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Data</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Saat ini belum ada data akreditasi program studi yang tersedia.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>

@endsection