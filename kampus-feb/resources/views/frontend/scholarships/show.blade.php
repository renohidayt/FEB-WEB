@extends('layouts.app')
@php
    use App\Models\Scholarship;
@endphp

@section('content')
{{-- HERO SECTION & BREADCRUMBS --}}
<div class="relative bg-slate-900 text-white pt-6 pb-12 overflow-hidden border-b border-white/5">
    {{-- Background Decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80"></i> 
                <span>Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <a href="{{ route('scholarships.index') }}" class="text-slate-400 hover:text-white transition-colors">Beasiswa</a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold truncate max-w-[200px] md:max-w-none cursor-default">{{ $scholarship->name }}</span>
        </nav>

        {{-- Title Area --}}
        <div class="max-w-4xl animate-fade-in-left">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
                {{ $scholarship->name }}
            </h1>
            <div class="flex flex-wrap items-center gap-6 text-slate-300">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center border border-white/10">
                        <i class="fas fa-building text-orange-500 text-sm"></i>
                    </div>
                    <span class="font-medium">{{ $scholarship->provider ?? 'FEB UNSAP' }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center border border-white/10">
                        <i class="fas fa-tag text-orange-500 text-sm"></i>
                    </div>
                    <span class="font-medium">{{ Scholarship::categories()[$scholarship->category] ?? $scholarship->category }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- MAIN CONTENT AREA (Mulai di bawah border) --}}
<div class="bg-white">
    <div class="container mx-auto px-4 py-12 pb-24 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
            
            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- POSTER --}}
                @if($scholarship->poster)
                <div class="bg-slate-50 rounded-xl border border-slate-200 shadow-sm overflow-hidden">
                    <div class="relative h-[450px] overflow-hidden group">
                        <img src="{{ asset('storage/' . $scholarship->poster) }}" alt="{{ $scholarship->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/40 via-transparent to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            {!! $scholarship->getStatusBadge() !!}
                        </div>
                    </div>
                </div>
                @endif

                {{-- QUICK INFO CARDS --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="p-8 bg-slate-50 rounded-xl border border-slate-200 shadow-sm group hover:border-orange-200 transition-colors">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Estimasi Bantuan</p>
                        <p class="text-3xl font-black text-slate-900 group-hover:text-orange-600 transition-colors">{{ $scholarship->getFormattedAmount() }}</p>
                    </div>
                    <div class="p-8 bg-slate-50 rounded-xl border border-slate-200 shadow-sm group hover:border-blue-200 transition-colors">
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Kuota Tersedia</p>
                        <p class="text-3xl font-black text-slate-900 group-hover:text-blue-600 transition-colors">{{ $scholarship->quota ?? '-' }} <span class="text-sm font-medium text-slate-400 tracking-normal">Mahasiswa</span></p>
                    </div>
                </div>

                {{-- DETAILS CONTENT --}}
                <div class="bg-white border border-slate-200 rounded-xl p-8 md:p-12 space-y-12">
                    <section>
                        <h3 class="flex items-center gap-4 text-xl font-black text-slate-900 uppercase tracking-tight mb-8">
                            <span class="w-12 h-12 bg-orange-500 text-white rounded-lg flex items-center justify-center shadow-lg shadow-orange-500/20">
                                <i class="fas fa-file-alt"></i>
                            </span>
                            Deskripsi Program
                        </h3>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-lg font-light">
                            {!! nl2br(e($scholarship->description)) !!}
                        </div>
                    </section>

                    <div class="h-px bg-slate-100 w-full"></div>

                    <section>
                        <h3 class="flex items-center gap-4 text-xl font-black text-slate-900 uppercase tracking-tight mb-8">
                            <span class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center shadow-lg shadow-blue-600/20">
                                <i class="fas fa-list-ul"></i>
                            </span>
                            Persyaratan Umum
                        </h3>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed text-lg font-light">
                            {!! nl2br(e($scholarship->requirements)) !!}
                        </div>
                    </section>
                </div>
            </div>

            {{-- SIDEBAR --}}
            <div class="space-y-8">
                {{-- TIMELINE CARD --}}
                <div class="bg-slate-900 rounded-xl p-8 text-white shadow-xl relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-5 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')]"></div>
                    <h4 class="text-xs font-bold uppercase tracking-[0.2em] mb-8 text-orange-500 flex items-center gap-2">
                        <span class="w-2 h-2 bg-orange-500 rounded-full animate-pulse"></span>
                        Waktu Pendaftaran
                    </h4>
                    
                    <div class="space-y-8 relative z-10">
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-slate-400 border border-white/10">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Pendaftaran Buka</p>
                                <p class="font-bold">{{ $scholarship->registration_start ? $scholarship->registration_start->format('d M Y') : '-' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-lg bg-white/5 flex items-center justify-center text-orange-500 border border-white/10">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest mb-1">Batas Akhir</p>
                                <p class="font-bold text-orange-400">{{ $scholarship->registration_end ? $scholarship->registration_end->format('d M Y') : 'TBA' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($scholarship->getRegistrationStatus() === 'open')
                        <a href="{{ $scholarship->website_url ?? '#' }}" target="_blank" class="block w-full mt-10 py-4 bg-orange-500 hover:bg-orange-600 text-white text-center rounded-xl font-bold transition-all shadow-lg shadow-orange-500/30 hover:-translate-y-1 active:scale-95">
                            Daftar Sekarang <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    @else
                        <div class="w-full mt-10 py-4 bg-slate-800 text-slate-500 text-center rounded-xl font-bold">
                            Sudah Ditutup
                        </div>
                    @endif
                </div>

                {{-- CONTACT CARD --}}
                <div class="bg-slate-50 rounded-xl border border-slate-200 p-8 shadow-sm">
                    <h4 class="text-xs font-bold uppercase tracking-widest mb-6 text-slate-900 flex items-center gap-2">
                        <i class="fas fa-headset text-orange-500"></i> Informasi Kontak
                    </h4>
                    <div class="space-y-6">
                        @if($scholarship->contact_person)
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-white border border-slate-200 flex items-center justify-center text-slate-400">
                                <i class="fas fa-user"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Penanggung Jawab</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ $scholarship->contact_person }}</p>
                            </div>
                        </div>
                        @endif

                        @if($scholarship->contact_phone)
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $scholarship->contact_phone) }}" target="_blank" class="flex items-center gap-4 group">
                            <div class="w-12 h-12 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center border border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                                <i class="fab fa-whatsapp text-lg"></i>
                            </div>
                            <div>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">WhatsApp Admin</p>
                                <p class="text-sm font-bold text-slate-800 group-hover:text-emerald-600 transition-colors">{{ $scholarship->contact_phone }}</p>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>

                {{-- SHARE LINK --}}
                <button onclick="copyLink()" class="w-full py-4 bg-white border-2 border-dashed border-slate-200 hover:border-orange-500 hover:text-orange-600 text-slate-500 rounded-xl font-bold transition-all flex items-center justify-center gap-3 group">
                    <i class="fas fa-share-alt text-slate-300 group-hover:text-orange-500"></i>
                    Salin Tautan Beasiswa
                </button>
            </div>
        </div>

        {{-- RELATED --}}
        @if($relatedScholarships->count() > 0)
        <div class="mt-24 pt-20 border-t border-slate-100">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 uppercase tracking-tight">Beasiswa <span class="text-orange-500">Lainnya</span></h2>
                    <div class="w-16 h-1.5 bg-orange-500 mt-3 rounded-full"></div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                @foreach($relatedScholarships as $related)
                    <div class="group bg-slate-50 rounded-xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-500 overflow-hidden">
                        <div class="relative h-48 overflow-hidden bg-slate-200">
                            @if($related->poster)
                                <img src="{{ asset('storage/' . $related->poster) }}" alt="{{ $related->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @endif
                        </div>
                        <div class="p-8">
                            <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors line-clamp-2 leading-tight">
                                {{ $related->name }}
                            </h3>
                            <p class="text-orange-600 font-black mb-6">{{ $related->getFormattedAmount() }}</p>
                            <a href="{{ route('scholarships.show', $related->id) }}" class="inline-flex items-center text-xs font-bold text-slate-900 uppercase tracking-[0.2em] border-b-2 border-orange-500 pb-1">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(20px, -30px) scale(1.05); }
        66% { transform: translate(-10px, 10px) scale(0.95); }
    }
    .animate-blob { animation: blob 10s infinite; }
    .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out; }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

<script>
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        alert('Tautan berhasil disalin ke clipboard!');
    });
}
</script>
@endsection