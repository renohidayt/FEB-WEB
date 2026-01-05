@extends('layouts.app')

@section('title', 'Program Studi - FEB UNSAP')

@section('content')
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
            <span class="text-orange-500 font-semibold cursor-default">Program Studi</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="text-left animate-fade-in-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Program <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Akademik</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Temukan program studi yang tepat untuk membangun kompetensi bisnis, kepemimpinan, dan profesionalisme di era global.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-graduation-cap text-5xl text-slate-500 group-hover:text-orange-500 transition-all"></i>
                    </div>
                    <div class="space-y-2 px-2">
                        <div class="h-2 bg-orange-500/40 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-2/3"></div>
                    </div>
                </div>

                <div class="absolute -top-6 right-6 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <i class="fas fa-award text-orange-500 text-2xl"></i>
                </div>
                <div class="absolute -bottom-6 left-6 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-2 font-bold text-xs">
                        <div class="w-2 h-2 rounded-full bg-blue-500"></div> Terakreditasi
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="bg-slate-50 py-20">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-black text-slate-900 mb-2 uppercase tracking-tight">Pilihan Program Studi</h2>
            <div class="h-1.5 w-12 bg-orange-600 mx-auto rounded-full"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-7xl mx-auto">
            
            <div class="group bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col overflow-hidden">
                <div class="relative p-8 bg-gradient-to-br from-blue-600 to-blue-800 text-white overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-[0.1] rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-[0.1] rounded-full -ml-10 -mb-10 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-inner transition-colors group-hover:bg-white group-hover:text-blue-600 duration-500">
                            <i class="fas fa-chart-line text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-1">S1 Manajemen</h3>
                        <p class="text-blue-100 font-bold text-xs uppercase tracking-widest">Program Sarjana</p>
                    </div>
                </div>
                
                <div class="p-8 flex flex-col flex-1">
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Mencetak manajer masa depan dengan kompetensi bisnis dan kewirausahaan yang tangguh.</p>
                    <div class="mb-8 flex-1">
                        <ul class="space-y-3">
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Manajemen Digital Marketing
                            </li>
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Fokus Kewirausahaan
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    <a href="https://feb.unsap.ac.id/manajemen/" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-blue-600 transition-all shadow-lg active:scale-95">
                        Detail Website <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="group bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col overflow-hidden">
                <div class="relative p-8 bg-gradient-to-br from-orange-500 to-red-600 text-white overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-[0.1] rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-[0.1] rounded-full -ml-10 -mb-10 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-inner transition-colors group-hover:bg-white group-hover:text-orange-600 duration-500">
                            <i class="fas fa-calculator text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-1">S1 Akuntansi</h3>
                        <p class="text-orange-100 font-bold text-xs uppercase tracking-widest">Program Sarjana</p>
                    </div>
                </div>

                <div class="p-8 flex flex-col flex-1">
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Mencetak tenaga profesional di bidang audit, perpajakan, dan sistem informasi akuntansi.</p>
                    <div class="mb-8 flex-1">
                        <ul class="space-y-3">
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Audit & Perpajakan
                            </li>
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Akuntansi Sektor Publik
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    <a href="https://feb.unsap.ac.id/ak/" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                        Detail Website <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
            </div>

            <div class="group bg-white rounded-xl border border-slate-100 shadow-sm hover:shadow-2xl transition-all duration-500 flex flex-col overflow-hidden">
                <div class="relative p-8 bg-gradient-to-br from-purple-600 to-indigo-800 text-white overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-white opacity-[0.1] rounded-full -mr-16 -mt-16 transition-transform group-hover:scale-110 duration-700"></div>
                    <div class="absolute bottom-0 left-0 w-20 h-20 bg-white opacity-[0.1] rounded-full -ml-10 -mb-10 transition-transform group-hover:scale-110 duration-700"></div>
                    
                    <div class="relative z-10">
                        <div class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-inner transition-colors group-hover:bg-white group-hover:text-purple-600 duration-500">
                            <i class="fas fa-user-graduate text-2xl"></i>
                        </div>
                        <h3 class="text-2xl font-bold mb-1">Magister Manajemen</h3>
                        <p class="text-purple-100 font-bold text-xs uppercase tracking-widest">Pascasarjana</p>
                    </div>
                </div>

                <div class="p-8 flex flex-col flex-1">
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">Meningkatkan kapasitas kepemimpinan strategis dan inovasi bisnis bagi para profesional.</p>
                    <div class="mb-8 flex-1">
                        <ul class="space-y-3">
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Strategic Leadership
                            </li>
                            <li class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-check-circle text-orange-500 mr-3"></i> Inovasi Bisnis Modern
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="p-6 bg-slate-50 border-t border-slate-100">
                    <a href="https://feb.unsap.ac.id" target="_blank" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-purple-600 transition-all shadow-lg active:scale-95">
                        Detail Website <i class="fas fa-external-link-alt text-xs"></i>
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
<style>
    .perspective-1000 { perspective: 1000px; }
    .rotate-y-6 { transform: rotateY(6deg); }
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
</style>
@endsection