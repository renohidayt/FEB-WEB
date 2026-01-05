@extends('layouts.app')

@section('title', 'Sejarah FEB - UNSAP')

@section('content')
{{-- Hero Section: Professional & Corporate Look --}}
<div class="relative bg-slate-900 text-white pt-12 pb-20 overflow-hidden border-b border-orange-500/20">
    {{-- Subtle Pattern Overlay --}}
    <div class="absolute inset-0 opacity-20 bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')] z-0"></div>
    
    <div class="container mx-auto px-6 relative z-10">
        <nav class="flex items-center text-xs font-semibold tracking-widest uppercase mb-12 font-poppins">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2">
                <i class="fas fa-home text-orange-500"></i> Beranda
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500">Sejarah</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div class="animate-fade-in-left"> 
                <span class="text-orange-500 font-bold tracking-widest uppercase text-xs mb-2 block">Established 1993</span>
                <h1 class="text-4xl md:text-5xl font-bold mb-6 leading-tight font-poppins">
                    Transformasi & <br>
                    <span class="text-orange-500">Dedikasi Pendidikan</span>
                </h1>
                <div class="w-16 h-1 bg-orange-500 mb-8"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-xl">
                    Dari STIE Sebelas April menuju Fakultas Ekonomi dan Bisnis (FEB) Universitas Sebelas April. Tiga dekade mencetak lulusan kompeten di Sumedang.
                </p>
            </div>

            <div class="hidden lg:flex justify-end relative">
                {{-- Geometric Decoration --}}
                <div class="relative p-1 border border-white/10 rounded-2xl bg-slate-800/30 backdrop-blur-sm">
                    <div class="w-full h-full border border-orange-500/20 rounded-xl p-8 bg-slate-900/50">
                        <i class="fas fa-university text-6xl text-orange-500/20 absolute -top-8 -right-8"></i>
                        <div class="flex flex-col gap-4">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-orange-500/10 border border-orange-500/30 flex items-center justify-center text-orange-500 rounded-lg">
                                    <i class="fas fa-chart-line"></i>
                                </div>
                                <span class="font-poppins font-semibold text-sm tracking-wider uppercase">Continuous Growth</span>
                            </div>
                            <div class="h-px bg-gradient-to-r from-orange-500/50 to-transparent w-full"></div>
                            <p class="text-xs text-slate-400 leading-relaxed italic">
                                "Langkah demi langkah dengan penuh kepastian mengejar kemajuan akademik dan fasilitas."
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Main Content --}}
<div class="bg-white py-24">
    <div class="container mx-auto px-6">
        <div class="max-w-6xl mx-auto">
            
            {{-- Introduction Section --}}
            <div class="grid lg:grid-cols-12 gap-16 mb-28">
                <div class="lg:col-span-5">
                    <span class="text-orange-600 font-bold text-xs uppercase tracking-widest mb-4 block">Historical Context</span>
                    <h2 class="text-3xl font-bold text-slate-900 leading-tight font-poppins mb-6">
                        Fondasi Kuat <br>
                        <span class="text-slate-500">Sejak 1993</span>
                    </h2>
                    <p class="text-slate-600 leading-relaxed font-light mb-6 text-justify">
                        Fakultas Ekonomi dan Bisnis (FEB) Universitas Sebelas April berdiri tahun 2021, merupakan transformasi dari Sekolah Tinggi Ilmu Ekonomi (STIE) Sebelas April Sumedang yang telah berdiri sejak 1 Juli 1993. Selama kurun waktu 26 tahun dari STIE ke FEB, institusi ini mampu mempertahankan eksistensinya dan terus berkembang.
                    </p>
                    <div class="inline-flex items-center gap-4 p-4 border-l-4 border-orange-500 bg-slate-50 rounded-r-xl">
                        <span class="text-3xl font-bold text-slate-900">30+</span>
                        <span class="text-xs text-slate-500 font-semibold uppercase leading-tight">Tahun <br> Pengalaman</span>
                    </div>
                </div>
                
                <div class="lg:col-span-7 space-y-6">
                    <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:border-orange-200 transition-all duration-300">
                        <h3 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-3 font-poppins">
                            <span class="text-orange-500 text-sm">01.</span> Program Studi Unggulan
                        </h3>
                        <p class="text-slate-600 leading-relaxed text-sm mb-4">
                            Saat ini FEB memiliki program studi yang terakreditasi dan relevan dengan kebutuhan industri:
                        </p>
                        <ul class="space-y-2">
                            <li class="flex items-center gap-2 text-sm text-slate-700 font-semibold"><i class="fas fa-check text-orange-500 text-xs"></i> S1 Manajemen</li>
                            <li class="flex items-center gap-2 text-sm text-slate-700 font-semibold"><i class="fas fa-check text-orange-500 text-xs"></i> S1 Akuntansi</li>
                            <li class="flex items-center gap-2 text-sm text-slate-700 font-semibold"><i class="fas fa-check text-orange-500 text-xs"></i> Pasca Sarjana Magister Manajemen</li>
                        </ul>
                    </div>

                    <div class="bg-slate-50 p-8 rounded-2xl border border-slate-100 hover:border-orange-200 transition-all duration-300">
                        <h3 class="text-lg font-bold text-slate-900 mb-3 flex items-center gap-3 font-poppins">
                            <span class="text-orange-500 text-sm">02.</span> Pengembangan Fasilitas
                        </h3>
                        <p class="text-slate-600 leading-relaxed text-sm">
                            Peningkatan sarana prasarana terus dilakukan secara signifikan, meliputi penambahan jumlah kelas, <strong>1 lokal bangunan Laboratorium Komputer</strong>, <strong>1 lokal bangunan Senat Mahasiswa</strong>, dan <strong>1 lokal bangunan Kegiatan Mahasiswa</strong>.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Growth Stats / Vision Box --}}
            <section class="mb-32">
                <div class="bg-slate-900 rounded-2xl p-10 md:p-16 relative overflow-hidden shadow-xl border border-white/5">
                    <div class="absolute top-0 right-0 w-64 h-64 bg-orange-500/5 rotate-45 translate-x-32 -translate-y-32 border border-orange-500/10"></div>
                    
                    <div class="relative z-10">
                        <div class="text-center max-w-3xl mx-auto mb-16">
                            <h2 class="text-2xl font-bold text-white mb-4 font-poppins tracking-wide uppercase">Dinamika Perkembangan</h2>
                            <p class="text-slate-400 font-light italic leading-relaxed text-lg">
                                "Tahap pengembangan Fakultas Ekonomi dan Bisnis dari tahun ke tahun mengalami peningkatan yang konsisten dalam mengejar kualitas akademik."
                            </p>
                        </div>

                        <div class="grid md:grid-cols-3 gap-8 text-center">
                            <div class="bg-white/5 border border-white/10 p-6 rounded-xl hover:bg-white/10 transition-all">
                                <div class="text-orange-500 text-3xl mb-3"><i class="fas fa-users"></i></div>
                                <h4 class="text-white font-bold mb-2 font-poppins text-sm">Sumber Daya Manusia</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">Jumlah dosen tetap dan mahasiswa terus bertambah setiap tahun akademik.</p>
                            </div>
                            <div class="bg-white/5 border border-white/10 p-6 rounded-xl hover:bg-white/10 transition-all">
                                <div class="text-blue-500 text-3xl mb-3"><i class="fas fa-award"></i></div>
                                <h4 class="text-white font-bold mb-2 font-poppins text-sm">Akreditasi</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">Peningkatan status akreditasi sebagai bukti komitmen mutu pendidikan.</p>
                            </div>
                            <div class="bg-white/5 border border-white/10 p-6 rounded-xl hover:bg-white/10 transition-all">
                                <div class="text-green-500 text-3xl mb-3"><i class="fas fa-building"></i></div>
                                <h4 class="text-white font-bold mb-2 font-poppins text-sm">Infrastruktur</h4>
                                <p class="text-slate-400 text-xs leading-relaxed">Peningkatan fisik bangunan kuliah dan fasilitas penunjang kegiatan mahasiswa.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            {{-- Timeline Section --}}
            <section class="mb-10">
                <div class="text-center mb-20">
                    <span class="text-orange-600 font-bold tracking-[0.3em] uppercase text-xs font-poppins">Milestones</span>
                    <h2 class="text-3xl font-bold text-slate-900 mt-3 font-poppins uppercase">Jejak Waktu</h2>
                    <div class="h-1 w-12 bg-orange-500 mx-auto mt-4"></div>
                </div>

                <div class="relative max-w-4xl mx-auto">
                    {{-- Professional Vertical Line --}}
                    <div class="absolute left-6 md:left-1/2 top-0 bottom-0 w-px bg-slate-200"></div>

                    {{-- Milestone 1: 1993 --}}
                    <div class="relative mb-16 group">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="flex-1 md:text-right pr-0 md:pr-12 pl-16 md:pl-0 mb-4 md:mb-0">
                                <span class="text-blue-600 font-bold text-sm font-poppins">1 Juli 1993</span>
                                <h3 class="text-xl font-bold text-slate-900 mt-1 font-poppins">Pendirian STIE</h3>
                                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                                    Sekolah Tinggi Ilmu Ekonomi (STIE) Sebelas April Sumedang resmi berdiri dan berkedudukan di Kabupaten Sumedang.
                                </p>
                            </div>
                            <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-white border-2 border-blue-600 rounded-sm -translate-x-1/2 z-10 rotate-45 group-hover:bg-blue-600 transition-all duration-300 shadow-sm"></div>
                            <div class="flex-1 hidden md:block"></div>
                        </div>
                    </div>

                    {{-- Milestone 2: 1993 - 2021 --}}
                    <div class="relative mb-16 group">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="flex-1 hidden md:block"></div>
                            <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-white border-2 border-green-500 rounded-sm -translate-x-1/2 z-10 rotate-45 group-hover:bg-green-500 transition-all duration-300 shadow-sm"></div>
                            <div class="flex-1 pl-16 md:pl-12 text-left">
                                <span class="text-green-600 font-bold text-sm font-poppins">1993 - 2020</span>
                                <h3 class="text-xl font-bold text-slate-900 mt-1 font-poppins">Era Pengembangan</h3>
                                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                                    Langkah pasti mengejar ketertinggalan. Pembenahan sistem pelayanan, pembinaan akademik, dan kemahasiswaan. Pembangunan Lab Komputer dan Gedung Senat Mahasiswa.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Milestone 3: 2021 --}}
                    <div class="relative group">
                        <div class="flex flex-col md:flex-row items-center">
                            <div class="flex-1 md:text-right pr-0 md:pr-12 pl-16 md:pl-0 mb-4 md:mb-0">
                                <span class="text-orange-600 font-bold text-sm font-poppins">2021 - Sekarang</span>
                                <h3 class="text-xl font-bold text-slate-900 mt-1 font-poppins uppercase">Transformasi Universitas</h3>
                                <p class="text-slate-500 mt-2 text-sm leading-relaxed">
                                    Resmi bertransformasi menjadi Fakultas Ekonomi dan Bisnis (FEB) Universitas Sebelas April (UNSAP).
                                </p>
                            </div>
                            <div class="absolute left-4 md:left-1/2 w-4 h-4 bg-orange-600 border-2 border-white rounded-sm -translate-x-1/2 z-10 rotate-45 shadow-lg animate-pulse"></div>
                            <div class="flex-1 hidden md:block"></div>
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</div>

<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap');

    .font-poppins { font-family: 'Poppins', sans-serif; }

    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-30px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out forwards; }
</style>
@endsection