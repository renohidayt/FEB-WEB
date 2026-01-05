@extends('layouts.app')

@section('title', 'Akreditasi - FEB Sebelas April')

@section('content')

<style>
    * {
        font-family: 'Poppins', sans-serif;
    }
</style>



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
            
            <span class="text-orange-500 font-semibold cursor-default">Akreditasi</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Akreditasi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Program Studi</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Informasi resmi mengenai status akreditasi dan penjaminan mutu akademik Fakultas Ekonomi dan Bisnis Universitas Sebelas April.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform -rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-certificate text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                    </div>

                    <div class="space-y-2">
                        <div class="h-2 bg-orange-500/40 rounded-full w-full"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-3/4"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2"></div>
                    </div>
                </div>

                <div class="absolute -top-4 right-4 bg-slate-800/90 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex flex-col items-center">
                        <i class="fas fa-award text-orange-500 text-2xl mb-1"></i>
                        <span class="text-xs font-bold text-white tracking-widest uppercase">Unggul</span>
                    </div>
                </div>

                <div class="absolute -bottom-4 left-4 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 5s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-check-circle text-sm"></i>
                        </div>
                        <p class="text-xs font-bold text-slate-200">Terverifikasi BAN-PT</p>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

  

<!-- Main Content -->
<div class="bg-[#F8F9FA] py-12">
    <div class="container mx-auto px-4 md:px-6">
        <div class="max-w-6xl mx-auto">
            
            <div class="bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.05)] border border-gray-100 overflow-hidden relative">
                
                <div class="h-1.5 w-full bg-gradient-to-r from-blue-700 via-indigo-600 to-blue-500"></div>

                <div class="p-6 md:p-8 flex flex-col md:flex-row gap-6 items-start">
                    
                    <div class="flex-shrink-0">
                        <div class="w-14 h-14 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-indigo-700 shadow-sm">
                            <i class="fas fa-certificate text-2xl"></i>
                        </div>
                    </div>

                    <div class="flex-1">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-3">
                            <h3 class="text-xl md:text-2xl font-bold text-gray-800 tracking-tight">
                                Akreditasi & Penjaminan Mutu
                            </h3>
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-100">
                                <i class="fas fa-check-circle text-[10px]"></i> Terverifikasi LAMEMBA
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-[15px] leading-relaxed mb-4">
                            Program Studi di lingkungan Fakultas Ekonomi dan Bisnis (FEB) dikelola dengan standar mutu tinggi dan telah terakreditasi oleh 
                            <strong class="text-gray-900 font-semibold">LAMEMBA</strong> (Lembaga Akreditasi Mandiri Ekonomi Manajemen Bisnis dan Akuntansi). 
                            Pengakuan ini menjamin kurikulum yang relevan dengan kebutuhan industri dan standar nasional pendidikan tinggi.
                        </p>

                        <div class="h-px bg-gray-100 my-4 w-full"></div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-4 text-sm">
                            <div class="flex items-center text-gray-500 bg-gray-50 px-3 py-2 rounded-lg border border-gray-100">
                                <i class="fas fa-building text-gray-400 mr-2"></i>
                                <span class="text-xs">
                                    Institusi Universitas: <span class="font-medium text-gray-700">BAN-PT</span>
                                </span>
                            </div>

                            <a href="https://unsap.ac.id/dokumen-akreditasi/" class="group flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition-colors text-xs sm:text-sm">
                                Cek Sertifikat Akreditasi
                                <i class="fas fa-arrow-right text-xs ml-1.5 transform group-hover:translate-x-1 transition-transform"></i>
                            </a>
                            
                            <a href="https://lamemba.or.id" target="_blank" class="hidden sm:flex items-center text-gray-400 hover:text-gray-600 transition-colors text-xs ml-auto" title="Kunjungi Website LAMEMBA">
                                lamemba.or.id <i class="fas fa-external-link-alt ml-1 text-[10px]"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="max-w-6xl mx-auto">
    <div class="grid md:grid-cols-2 gap-8 mb-20">
        
        <a href="{{ route('profile.accreditation.programs') }}" class="group relative bg-gray-50 rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 flex flex-col h-full">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-orange-400 to-red-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            
            <div class="p-8 flex-1">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center group-hover:bg-orange-600 transition-colors duration-300 shadow-sm border border-gray-100">
                        <i class="fas fa-university text-2xl text-orange-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="bg-white border border-gray-100 px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 shadow-sm">
                        {{ $stats['program_studi_count'] ?? '0' }} Prodi Aktif
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-orange-600 transition-colors">
                    Akreditasi Program Studi
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Lihat status akreditasi terkini untuk seluruh program studi Sarjana (S1) dan Pascasarjana. Termasuk masa berlaku SK.
                </p>

                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-white rounded-lg p-3 text-center border border-gray-100 shadow-sm">
                        <span class="block text-lg font-bold text-green-600">{{ $stats['grade_a'] ?? '-' }}</span>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Unggul / A</span>
                    </div>
                    <div class="bg-white rounded-lg p-3 text-center border border-gray-100 shadow-sm">
                        <span class="block text-lg font-bold text-blue-600">{{ $stats['grade_b'] ?? '-' }}</span>
                        <span class="text-[10px] text-gray-400 uppercase font-semibold">Baik Sekali / B</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white px-8 py-4 border-t border-gray-200 flex justify-between items-center group-hover:bg-orange-50 transition-colors">
                <span class="text-sm font-semibold text-gray-600 group-hover:text-orange-700">Buka Data Prodi</span>
                <i class="fas fa-arrow-right text-orange-500 transform group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

        <a href="{{ route('profile.accreditation.history') }}" class="group relative bg-gray-50 rounded-2xl shadow-sm hover:shadow-2xl transition-all duration-300 overflow-hidden border border-gray-200 flex flex-col h-full">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-purple-400 to-indigo-500 transform origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></div>
            
            <div class="p-8 flex-1">
                <div class="flex justify-between items-start mb-6">
                    <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center group-hover:bg-purple-600 transition-colors duration-300 shadow-sm border border-gray-100">
                        <i class="fas fa-folder-open text-2xl text-purple-600 group-hover:text-white transition-colors"></i>
                    </div>
                    <div class="bg-white border border-gray-100 px-3 py-1 rounded-lg text-xs font-semibold text-gray-500 shadow-sm">
                        Arsip Digital
                    </div>
                </div>

                <h3 class="text-2xl font-bold text-gray-800 mb-3 group-hover:text-purple-600 transition-colors">
                    Riwayat & Arsip SK
                </h3>
                <p class="text-gray-500 text-sm leading-relaxed mb-6">
                    Database sertifikat akreditasi terdahulu. Akses dokumen kadaluarsa untuk keperluan administrasi alumni atau legalisir.
                </p>

                <div class="bg-white rounded-lg p-3 border border-purple-100 flex items-center gap-3 shadow-sm">
                    <div class="w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-database text-purple-600 text-xs"></i>
                    </div>
                    <div>
                        <span class="block text-xs font-bold text-purple-700">{{ $stats['history_count'] ?? '0' }} Dokumen</span>
                        <span class="text-[10px] text-gray-500">Tersimpan dalam database</span>
                    </div>
                </div>
            </div>
            
            <div class="bg-white px-8 py-4 border-t border-gray-200 flex justify-between items-center group-hover:bg-purple-50 transition-colors">
                <span class="text-sm font-semibold text-gray-600 group-hover:text-purple-700">Buka Arsip</span>
                <i class="fas fa-arrow-right text-purple-500 transform group-hover:translate-x-1 transition-transform"></i>
            </div>
        </a>

    </div>
</div>

            <div class="text-center mb-10">
                <span class="text-orange-600 font-bold text-sm tracking-wider uppercase mb-2 block">Panduan</span>
                <h3 class="text-2xl font-bold text-gray-800">Peringkat Akreditasi</h3>
            </div>

            <div class="grid md:grid-cols-3 gap-6 mb-20">  <!-- Tambah mb-20 -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 mx-auto bg-green-100 text-green-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">A</div>
                    <h4 class="font-bold text-gray-800 mb-2">Unggul</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Melampaui Standar Nasional Pendidikan Tinggi baik kuantitatif maupun kualitatif.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 mx-auto bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">B</div>
                    <h4 class="font-bold text-gray-800 mb-2">Baik Sekali</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Melampaui Standar Nasional Pendidikan Tinggi dan menunjukkan peningkatan mutu.</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                    <div class="w-12 h-12 mx-auto bg-orange-100 text-orange-600 rounded-full flex items-center justify-center text-xl font-bold mb-4">C</div>
                    <h4 class="font-bold text-gray-800 mb-2">Baik</h4>
                    <p class="text-xs text-gray-500 leading-relaxed">Memenuhi Standar Nasional Pendidikan Tinggi (SN-Dikti).</p>
                </div>
            </div>

        </div>
    </div>
</div>


@endsection