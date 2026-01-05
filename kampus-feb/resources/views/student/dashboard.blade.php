@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')
{{-- LOGIKA HITUNG SEMESTER OTOMATIS --}}
@php
    // Hitung selisih bulan dari Tanggal Masuk sampai Sekarang
    $selisihBulan = $student->tanggal_masuk->diffInMonths(now());
    
    // Rumus: (Selisih Bulan / 6) dibulatkan ke atas. 
    // Contoh: Masuk Sept, Sekarang Des (3 bulan) -> 3/6 = 0.5 -> Ceil = Semester 1
    $semesterBerjalan = ceil(($selisihBulan + 1) / 6);

    // Pastikan tidak ada semester 0
    if ($semesterBerjalan < 1) { $semesterBerjalan = 1; }
@endphp

<div class="min-h-screen bg-slate-50 font-poppins text-slate-800 pb-12">
    
    {{-- Top Navigation Bar --}}
    <div class="bg-white border-b border-slate-200 sticky top-0 z-30">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="h-16 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-orange-600 rounded flex items-center justify-center text-white shadow-sm">
                        <i class="fas fa-university text-sm"></i>
                    </div>
                    <span class="font-bold text-lg tracking-tight text-slate-900">Portal Akademik</span>
                </div>
                <div class="text-xs font-medium text-slate-500 bg-slate-100 px-3 py-1 rounded-full">
                    {{ now()->translatedFormat('l, d F Y') }}
                </div>
            </div>
        </div>
    </div>

    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        
        {{-- HEADER SECTION --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-sm p-6 mb-6 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-1 h-full bg-orange-600"></div>
            
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900 flex items-center gap-2">
                        {{ $student->nama }}
                        @if($student->status === 'AKTIF')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-50 text-green-700 border border-green-200 tracking-wide uppercase align-middle">
                                Aktif
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-50 text-red-700 border border-red-200 tracking-wide uppercase align-middle">
                                Non-Aktif
                            </span>
                        @endif
                    </h1>
                    <div class="mt-1 flex items-center gap-4 text-sm text-slate-500">
                        <span class="flex items-center gap-1.5">
                            <i class="far fa-id-card text-slate-400"></i> {{ $student->nim }}
                        </span>
                        <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                        <span class="flex items-center gap-1.5">
                            <i class="fas fa-graduation-cap text-slate-400"></i> {{ $student->program_studi }}
                        </span>
                    </div>
                </div>
                
                {{-- Quick Stats (REVISI BAGIAN INI) --}}
                <div class="flex items-center gap-6 border-l border-slate-100 pl-8">
                    
                    {{-- Info Angkatan --}}
                    <div class="text-right hidden sm:block">
                        <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Angkatan</p>
                        <p class="font-semibold text-slate-700">{{ $student->tanggal_masuk->format('Y') }}</p>
                    </div>

                    {{-- Info Semester (BARU) --}}
                    <div class="text-center">
                        <div class="bg-orange-50 border border-orange-100 text-orange-700 px-4 py-2 rounded-lg">
                            <p class="text-[10px] uppercase tracking-wider font-bold text-orange-800/60 mb-0.5">Semester</p>
                            <p class="font-bold text-xl leading-none">{{ $semesterBerjalan }}</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        {{-- ALERTS --}}
        @if(session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-lg mb-6 flex items-start gap-3 shadow-sm" role="alert">
            <i class="fas fa-check-circle mt-0.5 text-emerald-600"></i>
            <span class="text-sm font-medium">{{ session('success') }}</span>
        </div>
        @endif

        {{-- MAIN GRID --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            {{-- COLUMN 1: Academic Data --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 rounded-t-lg flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 text-xs uppercase tracking-wider">Data Akademik</h3>
                    <i class="fas fa-book text-slate-300"></i>
                </div>
                <div class="p-5">
                    <ul class="space-y-4">
                        <li class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <span class="text-sm text-slate-500">Jenis Pendaftaran</span>
                            <span class="text-sm font-semibold text-slate-700">{{ $student->jenis }}</span>
                        </li>
                        <li class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <span class="text-sm text-slate-500">Tanggal Masuk</span>
                            <span class="text-sm font-semibold text-slate-700">{{ $student->tanggal_masuk->format('d/m/Y') }}</span>
                        </li>
                        {{-- Tambahan Info Semester di List juga --}}
                        <li class="flex justify-between items-center pb-3 border-b border-slate-50 last:border-0 last:pb-0">
                            <span class="text-sm text-slate-500">Masa Studi</span>
                            <span class="text-sm font-semibold text-slate-700">Semester {{ $semesterBerjalan }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- COLUMN 2: Account Info --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full flex flex-col">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 rounded-t-lg flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 text-xs uppercase tracking-wider">Status Akun</h3>
                    <i class="fas fa-shield-alt text-slate-300"></i>
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between">
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Status User</span>
                            <span class="text-xs font-bold {{ $user->is_active ? 'text-green-600' : 'text-red-600' }}">
                                {{ $user->is_active ? 'ACTIVE' : 'RESTRICTED' }}
                            </span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-slate-500">Last Login</span>
                            <span class="text-xs font-mono text-slate-700 bg-slate-100 px-2 py-1 rounded">
                                {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '-' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- COLUMN 3: Quick Actions --}}
            <div class="bg-white border border-slate-200 rounded-lg shadow-sm h-full">
                <div class="px-5 py-3 border-b border-slate-100 bg-slate-50 rounded-t-lg flex justify-between items-center">
                    <h3 class="font-bold text-slate-700 text-xs uppercase tracking-wider">Akses Cepat</h3>
                    <i class="fas fa-rocket text-slate-300"></i>
                </div>
                <div class="p-4 grid grid-cols-2 gap-3">
                    
                    {{-- 1. Kalender Akademik --}}
                    <a href="{{ route('academic.calendar') }}" class="flex flex-col items-center justify-center p-3 rounded-lg border border-slate-100 bg-slate-50 hover:bg-white hover:border-blue-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group h-24">
                        <i class="fas fa-calendar-day text-2xl text-slate-400 group-hover:text-blue-500 mb-2 transition-colors"></i>
                        <span class="text-[11px] font-semibold text-slate-600 group-hover:text-slate-800 text-center leading-tight">Kalender<br>Akademik</span>
                    </a>
                    
                    {{-- 2. Jadwal Matkul --}}
                    <a href="{{ route('academic.schedule') }}" class="flex flex-col items-center justify-center p-3 rounded-lg border border-slate-100 bg-slate-50 hover:bg-white hover:border-orange-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group h-24">
                        <i class="fas fa-clock text-2xl text-slate-400 group-hover:text-orange-500 mb-2 transition-colors"></i>
                        <span class="text-[11px] font-semibold text-slate-600 group-hover:text-slate-800 text-center leading-tight">Jadwal<br>Matkul</span>
                    </a>

                    {{-- 3. Pengajuan Surat --}}
                    <a href="{{ route('letters.index') }}" class="flex flex-col items-center justify-center p-3 rounded-lg border border-slate-100 bg-slate-50 hover:bg-white hover:border-emerald-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group h-24">
                        <i class="fas fa-file-signature text-2xl text-slate-400 group-hover:text-emerald-500 mb-2 transition-colors"></i>
                        <span class="text-[11px] font-semibold text-slate-600 group-hover:text-slate-800 text-center leading-tight">Pengajuan<br>Surat</span>
                    </a>

                    {{-- 4. Logout --}}
                    <form action="{{ route('student.logout') }}" method="POST" class="w-full h-full">
                        @csrf
                        <button type="submit" class="w-full h-full flex flex-col items-center justify-center p-3 rounded-lg border border-red-50 bg-red-50/30 hover:bg-red-50 hover:border-red-200 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group h-24">
                            <i class="fas fa-sign-out-alt text-2xl text-red-300 group-hover:text-red-500 mb-2 transition-colors"></i>
                            <span class="text-[11px] font-semibold text-slate-600 group-hover:text-red-700 text-center">Logout</span>
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection