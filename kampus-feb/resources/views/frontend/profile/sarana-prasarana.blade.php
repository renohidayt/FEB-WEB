@extends('layouts.app')

@section('title', 'Sarana & Prasarana - Fakultas Ekonomi dan Bisnis')

@section('content')

<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5 font-poppins">
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
            <span class="text-orange-500 font-semibold cursor-default">Sarana & Prasarana</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase font-poppins">
                    Sarana & <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Prasarana</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg font-poppins">
                    Dukungan fasilitas fisik dan perangkat teknologi modern untuk menjamin kenyamanan dan kelancaran seluruh proses akademik.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-tools text-5xl text-slate-600 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                    </div>

                    <div class="space-y-2">
                        <div class="h-2 bg-slate-600/30 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-2/3"></div>
                    </div>
                </div>

                <div class="absolute -top-6 right-6 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex flex-col items-center">
                        <div class="w-10 h-10 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-400 mb-1">
                            <i class="fas fa-microchip text-lg"></i>
                        </div>
                        <span class="text-[9px] font-bold text-white tracking-wider uppercase font-poppins">Modern Lab</span>
                    </div>
                </div>

                <div class="absolute -bottom-6 left-6 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-laptop text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase leading-none mb-1 font-poppins">Fasilitas</p>
                            <p class="text-xs font-bold text-white leading-none font-poppins">Smart Class</p>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

<div class="bg-[#F8F9FA] min-h-screen py-16 font-poppins">
    <div class="container mx-auto px-6">
        
        @if($sarana)
            <div class="grid lg:grid-cols-12 gap-12 items-start relative">
                
                <div class="lg:col-span-4 space-y-8">
                    <div class="sticky top-24" style="position: -webkit-sticky; position: sticky;">
                        <div class="relative bg-white p-2 rounded-2xl shadow-lg border border-gray-100 transform hover:-translate-y-1 transition-transform duration-300 group">
                            <div class="absolute top-3 left-3 w-full h-full bg-orange-500 
                                rounded-2xl -z-10 transition-transform duration-500
                                group-hover:translate-x-1 group-hover:translate-y-1">
                            </div>
                            
                            @if($sarana->photo_url)
                                <div class="relative overflow-hidden rounded-xl">
                                    <img src="{{ $sarana->photo_url }}" 
                                         alt="Sarana & Prasarana" 
                                         class="w-full h-auto object-contain">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                                    <div class="absolute bottom-4 left-4 text-white">
                                        <p class="text-xs font-bold uppercase tracking-widest text-orange-400 mb-1 font-poppins">Fasilitas</p>
                                        <p class="font-semibold text-sm font-poppins">Fakultas Ekonomi & Bisnis</p>
                                    </div>
                                </div>
                            @else
                                <div class="bg-gradient-to-br from-orange-50 to-red-50 h-64 rounded-xl flex items-center justify-center text-gray-400">
                                    <div class="text-center">
                                        <i class="fas fa-building text-6xl text-orange-300 mb-3"></i>
                                        <p class="text-sm font-semibold text-orange-400 font-poppins">Sarana & Prasarana FEB</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl shadow-xl border border-gray-100 p-8 md:p-12 relative overflow-hidden group">
                        
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-50 rounded-bl-full -mr-8 -mt-8 z-0"></div>
                        <i class="fas fa-quote-right absolute top-8 right-8 text-orange-100 text-7xl pointer-events-none z-0 group-hover:scale-110 transition-transform duration-700"></i>

                        <div class="relative z-10">
                            <span class="inline-block py-1 px-3 rounded-full bg-orange-100 text-orange-600 text-xs font-bold uppercase tracking-wider mb-4 font-poppins">
                                Fasilitas & Infrastruktur
                            </span>
                            
                            <h2 class="text-3xl md:text-4xl font-bold text-[#1a1a2e] mb-8 leading-tight font-poppins">
                                {{ $sarana->name ?? 'Sarana & Prasarana' }}
                            </h2>

                            @if($sarana->content)
                                <article class="prose prose-lg prose-slate max-w-none 
                                                font-poppins
                                                prose-headings:text-[#1a1a2e] prose-headings:font-bold prose-headings:font-poppins
                                                prose-p:text-gray-600 prose-p:leading-relaxed prose-p:text-justify prose-p:font-poppins
                                                prose-li:marker:text-orange-500 prose-li:text-gray-600 prose-li:text-justify prose-li:font-poppins
                                                prose-strong:text-orange-600 prose-strong:font-bold
                                                prose-blockquote:border-l-orange-500 prose-blockquote:bg-orange-50 prose-blockquote:py-2 prose-blockquote:px-4 prose-blockquote:not-italic prose-blockquote:text-gray-700 prose-blockquote:rounded-r-lg prose-blockquote:text-justify"
                                     style="text-align: justify;">
                                    {!! nl2br(e($sarana->content)) !!}
                                </article>
                            @else
                                <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mb-4">
                                        <i class="fas fa-file-alt text-gray-400 text-2xl"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium font-poppins">Konten sarana & prasarana belum tersedia saat ini.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-12 pt-8 border-t border-gray-100">
                            <a href="{{ url('/fasilitas') }}" class="group relative w-full flex items-center justify-between p-6 bg-slate-50 hover:bg-orange-50 border border-gray-200 hover:border-orange-200 rounded-xl transition-all duration-300">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-full bg-white shadow-sm flex items-center justify-center text-orange-500 group-hover:scale-110 transition-transform">
                                        <i class="fas fa-images text-xl"></i>
                                    </div>
                                    <div class="text-left">
                                        <h4 class="font-bold text-[#1a1a2e] text-lg font-poppins group-hover:text-orange-600 transition-colors">Galeri Fasilitas Lengkap</h4>
                                        <p class="text-sm text-gray-500 font-poppins">Lihat foto ruang kuliah, laboratorium, dan perpustakaan.</p>
                                    </div>
                                </div>
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center shadow-sm group-hover:bg-orange-500 group-hover:text-white transition-all duration-300">
                                    <i class="fas fa-arrow-right transform group-hover:translate-x-1 transition-transform"></i>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        @else
            <div class="max-w-lg mx-auto text-center py-20">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100">
                    <img src="https://illustrations.popsy.co/amber/surveillance.svg" alt="No Data" class="h-40 mx-auto mb-6 opacity-80">
                    <h3 class="text-xl font-bold text-gray-800 mb-2 font-poppins">Data Belum Tersedia</h3>
                    <p class="text-gray-500 mb-6 font-poppins">Informasi Sarana & Prasarana sedang dalam proses pembaruan oleh administrator.</p>
                    <a href="{{ url('/') }}" class="inline-flex items-center px-6 py-3 bg-[#1a1a2e] text-white rounded-lg hover:bg-orange-600 transition-colors font-poppins">
                        <i class="fas fa-arrow-left mr-2"></i> Kembali ke Beranda
                    </a>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection