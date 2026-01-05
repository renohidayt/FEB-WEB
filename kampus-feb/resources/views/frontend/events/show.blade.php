@extends('layouts.app')

@section('content')
{{-- Load External Assets --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Force Font Poppins */
    .font-poppins-all { font-family: 'Poppins', sans-serif !important; }
    
    /* Animasi Blob Background (untuk banner tanpa poster) */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }

    /* Sticky Sidebar Wrapper */
    .sticky-wrapper {
        position: -webkit-sticky; /* Safari */
        position: sticky;
        top: 2rem; /* Jarak dari atas layar */
        z-index: 30;
    }
</style>

<div class="font-poppins-all bg-slate-50 min-h-screen flex flex-col">

    {{-- 1. HERO SECTION (Banner) --}}
    <div class="relative h-[450px] lg:h-[500px] w-full bg-slate-900 overflow-hidden">
        {{-- Background Image / Pattern --}}
        <div class="absolute inset-0 z-0">
            @if($event->poster)
                <img src="{{ asset('storage/' . $event->poster) }}" alt="{{ $event->title }}" class="w-full h-full object-cover opacity-50 blur-[2px]">
            @else
                <div class="w-full h-full bg-slate-900 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-96 h-96 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                    <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
                </div>
            @endif
            {{-- Gradient agar teks terbaca --}}
            <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-slate-900/60 to-transparent"></div>
        </div>

        {{-- Content Hero --}}
        <div class="container mx-auto px-6 relative z-10 h-full flex flex-col justify-center pb-10">
            {{-- Breadcrumb --}}
            <nav class="absolute top-8 left-6 md:left-6 flex items-center text-xs font-medium text-slate-400">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <span class="mx-2">/</span>
                <a href="{{ route('events.index') }}" class="hover:text-white transition">Agenda</a>
                <span class="mx-2">/</span>
                <span class="text-orange-500 truncate max-w-[150px]">{{ $event->title }}</span>
            </nav>

            <div class="max-w-4xl mt-12">
                {{-- Status Badge --}}
                <div class="mb-6">
                    @if($event->isOngoing())
                        <span class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white text-[10px] font-bold uppercase tracking-widest rounded-full shadow-lg shadow-orange-900/50 animate-pulse">
                            <span class="w-2 h-2 bg-white rounded-full animate-ping"></span> Sedang Berlangsung
                        </span>
                    @elseif($event->start_date > now())
                        <span class="inline-block px-4 py-2 bg-white/10 backdrop-blur-md border border-white/20 text-white text-[10px] font-bold uppercase tracking-widest rounded-full">
                            Akan Datang
                        </span>
                    @else
                        <span class="inline-block px-4 py-2 bg-slate-800 text-slate-400 text-[10px] font-bold uppercase tracking-widest rounded-full border border-slate-700">
                            Telah Selesai
                        </span>
                    @endif
                </div>

                {{-- Title --}}
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-black text-white leading-tight mb-6 tracking-tight drop-shadow-sm">
                    {{ $event->title }}
                </h1>

                {{-- Meta Data --}}
                <div class="flex flex-wrap gap-6 text-slate-200">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-orange-600 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-calendar-day"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Tanggal</p>
                            <p class="font-bold">{{ $event->formatted_date }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 border-l border-white/10 pl-6">
                        <div class="w-10 h-10 rounded-xl bg-slate-700 flex items-center justify-center text-white shadow-lg">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider font-bold">Waktu</p>
                            <p class="font-bold">{{ date('H:i', strtotime($event->start_time)) }} WIB</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 2. MAIN CONTENT (Dibawah Banner) --}}
    <div class="container mx-auto px-4 py-12 relative z-20">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            {{-- LEFT COLUMN: Event Details & Description --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Info Grid --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Detail Informasi</h3>
                    
                    <div class="grid md:grid-cols-2 gap-6">
                        {{-- Location --}}
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-orange-200 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-orange-500 transition-colors shrink-0 shadow-sm">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Lokasi Kegiatan</p>
                                <p class="font-bold text-slate-800 leading-snug">{{ $event->location }}</p>
                                @if($event->url)
                                    <a href="{{ $event->url }}" target="_blank" class="text-xs text-orange-600 font-bold hover:underline mt-2 inline-block">
                                        Buka Peta <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>

                        {{-- Organizer --}}
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-orange-200 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-orange-500 transition-colors shrink-0 shadow-sm">
                                <i class="fas fa-user-tie"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Penyelenggara</p>
                                <p class="font-bold text-slate-800 leading-snug">{{ $event->organizer }}</p>
                            </div>
                        </div>

                        {{-- Participants --}}
                        @if($event->participants)
                        <div class="flex items-start gap-4 p-4 rounded-2xl bg-slate-50 border border-slate-100 group hover:border-orange-200 transition-colors">
                            <div class="w-10 h-10 rounded-full bg-white border border-slate-200 flex items-center justify-center text-slate-400 group-hover:text-orange-500 transition-colors shrink-0 shadow-sm">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <p class="text-xs text-slate-400 mb-1">Target Peserta</p>
                                <p class="font-bold text-slate-800 leading-snug">{{ $event->participants }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                {{-- Description --}}
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 md:p-10">
                    <div class="flex items-center gap-4 mb-8 pb-6 border-b border-slate-100">
                        <div class="w-12 h-12 bg-slate-900 rounded-xl flex items-center justify-center text-white text-xl">
                            <i class="fas fa-align-left"></i>
                        </div>
                        <h2 class="text-2xl font-black text-slate-900">Deskripsi Lengkap</h2>
                    </div>
                    
                    <div class="prose prose-slate prose-lg max-w-none prose-headings:font-bold prose-p:text-slate-600 prose-a:text-orange-600">
                        {!! nl2br(e($event->description)) !!}
                    </div>

                    {{-- Keywords --}}
                    @if($event->keywords)
                        <div class="mt-10 pt-6 border-t border-slate-100">
                            <div class="flex flex-wrap gap-2">
                                @foreach(explode(',', $event->keywords) as $keyword)
                                    <span class="px-4 py-2 bg-slate-100 text-slate-600 rounded-lg text-xs font-bold uppercase tracking-wider hover:bg-orange-50 hover:text-orange-600 transition cursor-default">
                                        #{{ trim($keyword) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

            </div>

            {{-- RIGHT COLUMN: Sticky Sidebar (Aksi & Share) --}}
            <div class="lg:col-span-4 relative">
                
                {{-- Wrapper Sticky --}}
                <div class="sticky-wrapper space-y-6">

                    {{-- 1. Poster Preview (Mini) --}}
                    @if($event->poster)
                    <div class="bg-white p-2 rounded-3xl shadow-sm border border-slate-200">
                        <img src="{{ asset('storage/' . $event->poster) }}" alt="Poster" class="w-full rounded-2xl cursor-pointer hover:opacity-90 transition" onclick="window.open(this.src)">
                    </div>
                    @endif

                    {{-- 2. Card Aksi (Sticky) --}}
                    <div class="bg-slate-900 rounded-xl shadow-2xl p-8 text-center relative overflow-hidden">
                        {{-- Decor --}}
                        <div class="absolute top-0 right-0 w-32 h-32 bg-orange-500 rounded-full mix-blend-overlay filter blur-3xl opacity-20"></div>

                        <h3 class="text-lg font-bold text-white mb-6 uppercase tracking-widest relative z-10">Menu Aksi</h3>

                        <div class="space-y-4 relative z-10">
                            @if($event->url)
                                <a href="{{ $event->url }}" target="_blank" class="flex items-center justify-center w-full py-4 bg-orange-600 hover:bg-orange-700 text-white rounded-xl font-bold transition-all hover:-translate-y-1 shadow-lg shadow-orange-900/50">
                                    @if($event->isOngoing())
                                        <i class="fas fa-play-circle mr-2 animate-pulse"></i> Gabung Live
                                    @elseif($event->start_date > now())
                                        <i class="fas fa-ticket-alt mr-2"></i> Daftar Sekarang
                                    @else
                                        <i class="fas fa-external-link-alt mr-2"></i> Info Lanjut
                                    @endif
                                </a>
                            @endif

                            <button onclick="addToCalendar()" class="flex items-center justify-center w-full py-4 bg-white/10 hover:bg-white/20 text-white rounded-xl font-bold transition-all border border-white/10">
                                <i class="fas fa-calendar-plus mr-2"></i> Simpan ke Kalender
                            </button>
                        </div>

                        {{-- Countdown --}}
                        @if($event->start_date > now())
                            <div class="mt-8 pt-6 border-t border-white/10">
                                <p class="text-xs text-slate-400 uppercase tracking-widest mb-2">Menuju Acara</p>
                                <div class="text-3xl font-black text-white">
                                    {{ $event->start_date->diffInDays(now()) }} <span class="text-sm font-medium text-orange-500">Hari Lagi</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    {{-- 3. Card Share (Sticky) --}}
                    <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-6">
                        <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 text-center">Bagikan Event</h3>
                        <div class="flex justify-center gap-4">
                            <button onclick="shareToWhatsApp()" class="w-12 h-12 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#25D366] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-whatsapp text-xl"></i>
                            </button>
                            <button onclick="shareToFacebook()" class="w-12 h-12 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#1877F2] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-facebook-f text-xl"></i>
                            </button>
                            <button onclick="shareToTwitter()" class="w-12 h-12 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-[#1DA1F2] hover:text-white transition-all shadow-sm">
                                <i class="fab fa-twitter text-xl"></i>
                            </button>
                            <button onclick="copyLink()" class="w-12 h-12 rounded-full bg-slate-50 text-slate-600 flex items-center justify-center hover:bg-slate-800 hover:text-white transition-all shadow-sm">
                                <i class="fas fa-link text-xl"></i>
                            </button>
                        </div>
                    </div>

                </div> {{-- End Sticky Wrapper --}}
            </div>
        </div>

        {{-- 3. RELATED EVENTS --}}
        @if($relatedEvents->count() > 0)
            <div class="mt-24 pt-10 border-t border-slate-200">
                <div class="flex items-center justify-between mb-10">
                    <div>
                        <span class="text-orange-600 font-bold uppercase tracking-widest text-xs">Rekomendasi</span>
                        <h2 class="text-3xl font-black text-slate-900 mt-1">Agenda Serupa</h2>
                    </div>
                    <a href="{{ route('events.index') }}" class="group flex items-center gap-2 text-slate-500 hover:text-orange-600 transition font-bold text-sm">
                        Lihat Semua <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedEvents as $related)
                        <a href="{{ route('events.show', $related->slug) }}" class="group bg-white rounded-xl border border-slate-200 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden">
                            <div class="relative h-48 overflow-hidden">
                                @if($related->poster)
                                    <img src="{{ asset('storage/' . $related->poster) }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                                @else
                                    <div class="w-full h-full bg-slate-100 flex items-center justify-center">
                                        <i class="fas fa-calendar-alt text-4xl text-slate-300"></i>
                                    </div>
                                @endif
                                
                                {{-- Date Badge Mini --}}
                                <div class="absolute bottom-3 left-3 bg-white/95 backdrop-blur-sm rounded-xl p-2 px-3 text-center shadow-lg border border-slate-100">
                                    <p class="text-lg font-black text-slate-900 leading-none">{{ $related->start_date->format('d') }}</p>
                                    <p class="text-[9px] font-bold text-orange-600 uppercase">{{ $related->start_date->format('M') }}</p>
                                </div>
                            </div>
                            <div class="p-6">
                                <h3 class="font-bold text-lg text-slate-900 mb-2 group-hover:text-orange-600 transition line-clamp-2 leading-tight">
                                    {{ $related->title }}
                                </h3>
                                <div class="flex items-center text-xs text-slate-500 font-medium mt-3">
                                    <i class="fas fa-map-marker-alt mr-2 text-slate-300"></i>
                                    <span class="truncate">{{ $related->location }}</span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-3 rounded-full shadow-2xl opacity-0 transition-all duration-300 z-50 flex items-center gap-3 border border-orange-500 pointer-events-none transform translate-y-10">
    <i class="fas fa-check-circle text-orange-500"></i>
    <span class="text-sm font-bold tracking-wide">Link tersalin!</span>
</div>

{{-- JAVASCRIPT FUNCTIONS --}}
<script>
// --- Logic Share Social Media ---
function shareToWhatsApp() {
    // Format teks untuk WA: "Judul Event" (baris baru) "Tanggal" (baris baru) "Lokasi" (baris baru) Link
    const text = encodeURIComponent(
        '*{{ $event->title }}*\n' + 
        '📅 {{ $event->formatted_date }}\n' + 
        '📍 {{ $event->location }}\n\n' + 
        'Lihat detail: ' + window.location.href
    );
    window.open('https://wa.me/?text=' + text, '_blank');
}

function shareToFacebook() {
    window.open('https://www.facebook.com/sharer/sharer.php?u=' + encodeURIComponent(window.location.href), '_blank');
}

function shareToTwitter() {
    const text = encodeURIComponent('Ikuti event {{ $event->title }} di FEB UNSAP!');
    window.open('https://twitter.com/intent/tweet?text=' + text + '&url=' + encodeURIComponent(window.location.href), '_blank');
}

// --- Logic Copy Link ---
function copyLink() {
    navigator.clipboard.writeText(window.location.href).then(() => {
        const toast = document.getElementById('toast');
        // Tampilkan toast
        toast.classList.remove('opacity-0', 'translate-y-10');
        // Sembunyikan setelah 3 detik
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-10');
        }, 3000);
    });
}

// --- Logic Add to Calendar (Google) ---
function addToCalendar() {
    const title = encodeURIComponent('{{ $event->title }}');
    const location = encodeURIComponent('{{ $event->location }}');
    // Bersihkan tag HTML dari deskripsi
    const description = encodeURIComponent('{{ strip_tags($event->description) }} \n\nLink Event: ' + window.location.href);
    
    // Format tanggal untuk Google Calendar: YYYYMMDDTHHmmss
    const startDate = '{{ $event->start_date->format("Ymd") }}T{{ date("His", strtotime($event->start_time)) }}';
    const endDate = '{{ $event->end_date->format("Ymd") }}T{{ date("His", strtotime($event->end_time)) }}';
    
    const url = `https://calendar.google.com/calendar/render?action=TEMPLATE&text=${title}&dates=${startDate}/${endDate}&details=${description}&location=${location}`;
    window.open(url, '_blank');
}
</script>
@endsection