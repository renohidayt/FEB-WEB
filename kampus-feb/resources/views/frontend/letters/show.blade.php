@extends('layouts.app')

@section('title', 'Detail Pengajuan - ' . ($submission->template->title ?? 'Surat'))

@section('content')

{{-- HERO BANNER (Hidden on Print) --}}
<div class="relative bg-slate-900 text-white pt-12 pb-16 overflow-hidden border-b border-white/5 font-poppins print:hidden">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="w-full flex items-center text-sm font-medium mb-8">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500"></i> 
                <span>Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold">Detail Pengajuan</span>
        </nav>

        <div class="flex flex-col md:flex-row justify-between items-end gap-6">
            <div class="animate-fade-in-left"> 
                <span class="inline-block px-3 py-1 rounded-full bg-orange-500/20 text-orange-400 text-xs font-bold uppercase tracking-wider mb-4 border border-orange-500/30">
                    ID Pengajuan: #{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}
                </span>
                <h1 class="text-3xl md:text-5xl font-extrabold mb-3 tracking-tight leading-tight uppercase">
                    Detail <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600 font-outline-2">Informasi</span>
                </h1>
                <p class="text-lg text-slate-300 font-light flex items-center gap-2">
                    <i class="fas fa-file-alt text-orange-500"></i>
                    {{ $submission->template->title ?? 'Template Dihapus' }}
                </p>
            </div>
            
            <div class="flex gap-3 print:hidden">
                {{-- REVISI: Tombol Cetak HANYA muncul jika DISETUJUI --}}
                @if($submission->status === 'approved')
                    <button onclick="window.print()" class="bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 px-6 py-3 rounded-xl transition-all flex items-center gap-2 font-bold shadow-xl">
                        <i class="fas fa-print"></i> Cetak Dokumen
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-slate-50 font-poppins text-slate-800 py-10 print:bg-white print:py-0">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 print:max-w-none print:px-0">
        
        {{-- PRINT HEADER --}}
        @include('frontend.letters.components.print-header')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 print:block">
            
            {{-- LEFT COLUMN: DATA --}}
            <div class="lg:col-span-2 space-y-8">
                
                {{-- SECTION: INFORMASI PENGAJU --}}
                @include('frontend.letters.components.print-profile')

                {{-- SECTION: SOAL & JAWABAN --}}
                @include('frontend.letters.components.print-questions')

                {{-- ATTACHMENTS --}}
                @include('frontend.letters.components.print-attachments')
            </div>

            {{-- RIGHT COLUMN: SIDEBAR (Hidden on print) --}}
            <div class="space-y-6 print:hidden">
                
                {{-- 1. KOTAK INFO DITOLAK (Hanya muncul jika Status Rejected) --}}
                @if($submission->status === 'rejected')
                <div class="bg-red-50 border border-red-200 rounded-2xl p-5 shadow-sm animate-fade-in-up">
                    <div class="flex items-center gap-3 mb-3 text-red-700">
                        <i class="fas fa-exclamation-circle text-xl"></i>
                        <h3 class="font-bold text-sm uppercase tracking-wide">Pengajuan Ditolak</h3>
                    </div>
                    <div class="bg-white/50 rounded-xl p-3 border border-red-100">
                        <p class="text-xs font-bold text-red-400 mb-1">Catatan Admin:</p>
                        <p class="text-sm text-red-800 leading-relaxed italic">
                            "{{ $submission->admin_notes ?? 'Data tidak sesuai atau kurang lengkap.' }}"
                        </p>
                    </div>
                </div>
                @endif

                {{-- 2. STATUS TIMELINE --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">Progres Pengajuan</h3>
                    <div class="space-y-6 relative before:absolute before:inset-0 before:ml-4 before:-mt-2 before:w-0.5 before:h-[90%] before:bg-slate-100">
                        
                        {{-- Step 1: Diajukan --}}
                        <div class="relative flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-green-500 text-white flex items-center justify-center z-10 shadow-lg shadow-green-100 ring-4 ring-white">
                                <i class="fas fa-check text-[10px]"></i>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-900">Diajukan</p>
                                <p class="text-[10px] text-slate-500">{{ $submission->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        
                        {{-- Step 2: Status Dinamis --}}
                        <div class="relative flex gap-4">
                            @if($submission->status === 'approved')
                                {{-- Jika DISETUJUI --}}
                                <div class="w-8 h-8 rounded-full bg-green-600 text-white flex items-center justify-center z-10 shadow-lg shadow-green-100 ring-4 ring-white">
                                    <i class="fas fa-check-double text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-green-600">Disetujui Admin</p>
                                    <p class="text-[10px] text-slate-500">
                                        {{ $submission->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                            @elseif($submission->status === 'rejected')
                                {{-- Jika DITOLAK --}}
                                <div class="w-8 h-8 rounded-full bg-red-500 text-white flex items-center justify-center z-10 shadow-lg shadow-red-100 ring-4 ring-white">
                                    <i class="fas fa-times text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-red-600">Ditolak Admin</p>
                                    <p class="text-[10px] text-slate-500">
                                        {{ $submission->updated_at->format('d M Y, H:i') }}
                                    </p>
                                </div>

                            @else
                                {{-- Jika MENUNGGU (Pending) --}}
                                <div class="w-8 h-8 rounded-full bg-blue-500 text-white flex items-center justify-center z-10 shadow-lg shadow-blue-100 ring-4 ring-white animate-pulse">
                                    <i class="fas fa-spinner fa-spin text-[10px]"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-blue-600">Verifikasi Admin</p>
                                    <p class="text-[10px] text-slate-500">Sedang diperiksa...</p>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>

                {{-- 3. ACTION BUTTONS --}}
                <div class="bg-slate-800 rounded-2xl p-6 text-white shadow-xl shadow-slate-200">
                    <p class="text-xs font-bold text-slate-400 uppercase mb-4 tracking-widest text-center">Tindakan Cepat</p>
                    <div class="flex flex-col gap-3">
                        
                        {{-- Tombol Download (Hanya jika Approved) --}}
                        @if($submission->status === 'approved' && $submission->hasGeneratedLetter())
                        <a href="{{ route('letters.download', $submission) }}" class="w-full bg-orange-500 hover:bg-orange-600 py-3 rounded-xl flex items-center justify-center gap-2 font-bold transition-transform active:scale-95 shadow-lg shadow-orange-900/20">
                            <i class="fas fa-download"></i> Unduh Hasil Surat
                        </a>
                        @endif

                        {{-- Tombol Ajukan Ulang (Jika Rejected) --}}
                        @if($submission->status === 'rejected')
                        {{-- Pastikan parameter route sesuai kebutuhan controller Anda --}}
                        <a href="{{ route('letters.create', ['template' => $submission->letter_template_id]) }}"
                           class="w-full bg-red-600 hover:bg-red-700 py-3 rounded-xl flex items-center justify-center gap-2 font-bold transition">
                            <i class="fas fa-redo"></i> Ajukan Ulang
                        </a>
                        @endif

                        <a href="{{ route('letters.index') }}" class="w-full bg-white/10 hover:bg-white/20 py-3 rounded-xl flex items-center justify-center gap-2 font-bold border border-white/10 transition">
                            <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                        </a>
                    </div>
                </div>
            </div>

            {{-- FOOTER PRINT --}}
            @include('frontend.letters.components.print-footer')
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        @page { size: A4 portrait; margin: 2cm 2.5cm; }
        body * { visibility: hidden; }
        
        /* Hanya tampilkan konten utama saat print */
        .bg-slate-50.font-poppins.text-slate-800,
        .bg-slate-50.font-poppins.text-slate-800 * { visibility: visible; }
        
        .bg-slate-50.font-poppins.text-slate-800 {
            position: absolute; left: 0; top: 0; width: 100%;
            padding: 0 !important; background: white !important;
        }
        
        body { background: white !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
        
        /* Sembunyikan elemen non-cetak */
        .print\:hidden, nav, header, footer, .bg-slate-900, button, .shadow-xl, aside { display: none !important; }
        
        /* Layout Fixes */
        .lg\:col-span-3:not(.lg\:col-span-2) { display: none; } /* Hide Right Column if specific classes used */
        .grid.print\:block { display: block !important; }
        
        /* Styling Reset */
        .bg-white, .rounded-2xl, .shadow-sm { background: transparent !important; box-shadow: none !important; border: none !important; }
        
        /* Typography */
        * { color: black !important; }
    }
</style>
@endpush
@endsection