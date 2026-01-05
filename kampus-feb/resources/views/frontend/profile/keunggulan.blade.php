@extends('layouts.app')

@section('title', 'Keunggulan Kompetitif - FEB UNSAP')

@section('content')
{{-- Hero Section: Professional & Corporate --}}
{{-- Hero Section: Gaya Konsisten dengan Sarana & Prasarana --}}
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5 font-poppins">
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
            <span class="text-orange-500 font-semibold cursor-default">Keunggulan Kompetitif</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            {{-- Text Content --}}
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Keunggulan <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Strategis</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Membangun kompetensi melalui ekosistem pendidikan yang relevan, adaptif, dan terintegrasi dengan dunia kerja nyata.
                </p>
            </div>

            {{-- 3D Visual Element --}}
            <div class="hidden md:block relative h-[320px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                {{-- Main Card --}}
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-rocket text-5xl text-slate-600 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                    </div>
                    <div class="space-y-2">
                        <div class="h-2 bg-slate-600/30 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-2/3"></div>
                    </div>
                </div>

                {{-- Floating Badge 1 --}}
                <div class="absolute -top-6 right-6 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3.5s;">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-400 mb-1">
                            <i class="fas fa-chart-line text-lg"></i>
                        </div>
                        <span class="text-[9px] font-bold text-white tracking-widest uppercase text-center leading-tight">Future<br>Ready</span>
                    </div>
                </div>

                {{-- Floating Badge 2 --}}
                <div class="absolute -bottom-6 left-6 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4.5s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-user-tie text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase leading-none mb-1">Karier</p>
                            <p class="text-xs font-bold text-white leading-none">Global Path</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Section 1: Value Proposition & Campus Image --}}
<section class="bg-white py-24">
    <div class="container mx-auto px-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-start">
            
            {{-- Keunggulan Utama --}}
            <div class="space-y-12">
                <div>
                    <h2 class="text-sm font-bold text-orange-600 uppercase tracking-[0.3em] mb-4">Value Proposition</h2>
                    <p class="text-2xl font-bold text-slate-900 leading-snug font-poppins">Efisiensi Investasi Pendidikan & Lokasi Strategis</p>
                    <p class="mt-4 text-slate-600 leading-relaxed">
                        Kami menyadari bahwa akses pendidikan harus inklusif. FEB UNSAP menawarkan biaya studi yang kompetitif tanpa mengurangi standar mutu, didukung lokasi kampus di pusat kota Sumedang yang memudahkan akses transportasi dan integrasi dengan pusat bisnis lokal.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fas fa-map-marker-alt text-orange-500 text-xl mb-4"></i>
                        <h4 class="font-bold text-slate-900 mb-2 font-poppins">Pusat Kota</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Terletak di area strategis untuk memudahkan riset lapangan mahasiswa.</p>
                    </div>
                    <div class="p-6 bg-slate-50 rounded-xl border border-slate-100">
                        <i class="fas fa-hand-holding-usd text-orange-500 text-xl mb-4"></i>
                        <h4 class="font-bold text-slate-900 mb-2 font-poppins">Biaya Kompetitif</h4>
                        <p class="text-sm text-slate-500 leading-relaxed">Skema pembiayaan yang fleksibel untuk mendukung keberlanjutan studi.</p>
                    </div>
                </div>
            </div>

            {{-- Image Visual --}}
            <div class="relative">
                <div class="aspect-video rounded-2xl overflow-hidden shadow-2xl relative z-10 group bg-slate-200">
                    <img src="{{ asset('assets/img/kampus-feb-unsap.jpg') }}"
                         alt="Gedung Kampus FEB UNSAP Sumedang" 
                         class="absolute inset-0 w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-[#090722]/80 via-[#090722]/20 to-transparent z-10"></div>
                    
                    <div class="absolute bottom-6 left-6 text-white z-20">
                        <p class="text-xs uppercase tracking-widest opacity-80 mb-1">Kampus Utama</p>
                        <h4 class="text-xl font-bold font-poppins leading-tight">FEB UNSAP - Sumedang</h4>
                    </div>
                </div>
                <div class="absolute -bottom-5 -right-5 w-full h-full border-2 border-slate-200/70 rounded-2xl -z-0"></div>
            </div>
        </div>
    </div>
</section>

{{-- Section 2: Practitioners & Entrepreneurship --}}
<section class="bg-slate-50 py-24 border-y border-slate-200">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-slate-900 font-poppins">Kurikulum Berbasis Realita</h2>
            <p class="text-slate-500 mt-4 max-w-2xl mx-auto">Menggabungkan kekuatan akademik dengan pengalaman praktis dari para ahli di bidangnya.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center sm:text-left">
            {{-- Dosen Praktisi --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-200 group hover:border-orange-500 transition-all duration-300">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mb-6 mx-auto sm:mx-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-4 font-poppins">Dosen Praktisi</h4>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Staf pengajar kami adalah kombinasi akademisi dan praktisi aktif di dunia bisnis serta pemerintahan, memberikan wawasan fenomena praktis yang nyata di kelas.
                </p>
            </div>

            {{-- Dual Career Path --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-200 group hover:border-orange-500 transition-all duration-300">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mb-6 mx-auto sm:mx-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-route"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-4 font-poppins">Alternatif Karier Ganda</h4>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Lulusan disiapkan untuk dua jalur sukses: sebagai profesional kompeten di korporasi atau sebagai wirausaha mandiri dengan bekal ilmu ekonomi yang kuat.
                </p>
            </div>

            {{-- PMW --}}
            <div class="bg-white p-8 rounded-2xl border border-slate-200 group hover:border-orange-500 transition-all duration-300">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-lg flex items-center justify-center mb-6 mx-auto sm:mx-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                    <i class="fas fa-seedling"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-4 font-poppins">Pembinaan Wirausaha</h4>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Melalui program **PMW**, mahasiswa mendapatkan bimbingan intensif dan akses modal untuk mulai membangun unit bisnis mereka sejak bangku kuliah.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Section 3: Business Ecosystem --}}
<section class="py-24 bg-white">
    <div class="container mx-auto px-6">
        <div class="bg-[#090722] rounded-2xl overflow-hidden flex flex-col lg:flex-row shadow-2xl border border-white/5">
            <div class="lg:w-1/2 p-12 lg:p-16 flex flex-col justify-center">
                <span class="text-orange-500 font-bold tracking-[0.2em] text-xs uppercase mb-4">Business Ecosystem</span>
                <h2 class="text-3xl font-bold text-white mb-6 font-poppins">Inkubator Bisnis & Kemitraan Strategis</h2>
                <p class="text-slate-400 leading-relaxed mb-8">
                    Kami membangun jembatan antara ide kreatif mahasiswa dengan dunia industri melalui Inkubator Bisnis. Dapatkan akses ke mentoring, kemitraan strategis, dan jaringan investor untuk mengakselerasi ide bisnis Anda.
                </p>
                <div class="flex items-center gap-6">
                    <div class="text-white">
                        <p class="text-2xl font-bold">10+</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">Mitra Industri</p>
                    </div>
                    <div class="w-px h-10 bg-slate-800"></div>
                    <div class="text-white">
                        <p class="text-2xl font-bold">24/7</p>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest">Support Sistem</p>
                    </div>
                </div>
            </div>
            <div class="lg:w-1/2 bg-slate-800 relative min-h-[350px]">
                <div class="absolute inset-0 flex items-center justify-center opacity-20">
                    <i class="fas fa-handshake text-[15rem] text-white"></i>
                </div>
                <div class="absolute inset-0 bg-gradient-to-l from-orange-500/10 to-transparent"></div>
            </div>
        </div>
    </div>
</section>

{{-- Section 4: Sharp CTA --}}


<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap');
    .font-poppins { font-family: 'Poppins', sans-serif; }
</style>
@endsection