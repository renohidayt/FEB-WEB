@extends('layouts.app')

@section('title', 'Kontak - FEB UNSAP')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<div style="font-family: 'Poppins', sans-serif;" class="bg-white min-h-screen">
    
    {{-- HERO SECTION --}}
    <div class="bg-slate-50 min-h-screen">
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
                    <span class="text-orange-500 font-semibold cursor-default uppercase tracking-wider text-xs">Kontak Kami</span>
                </nav>

                <div class="grid lg:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in-left">
                        <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
                            Hubungi <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Kami</span>
                        </h1>
                        <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>
                        <p class="text-lg text-slate-300 font-light leading-relaxed max-w-xl">
                            Punya pertanyaan mengenai akademik atau layanan di FEB UNSAP? Tim kami siap membantu Anda memberikan informasi yang dibutuhkan.
                        </p>
                    </div>

                    <div class="hidden lg:flex justify-center relative">
                        <div class="absolute w-64 h-64 bg-orange-500/10 rounded-full blur-[80px]"></div>
                        <div class="relative w-72 h-72 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl flex items-center justify-center transform rotate-3 hover:rotate-0 transition-all duration-700 group">
                            <i class="fas fa-headset text-8xl text-slate-700 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                            <div class="absolute -top-6 -left-6 bg-slate-800 border border-orange-500/50 p-5 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                                <i class="fas fa-comments text-orange-500 text-3xl"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- CONTACT CARDS SECTION --}}
        <div class="bg-slate-50 py-16 border-b border-slate-200">
            <div class="container mx-auto px-6">
                <div class="grid md:grid-cols-3 gap-6">

                    {{-- Phone Card --}}
                    <div class="bg-white rounded-xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-6 
                                    group-hover:bg-blue-600 transition-colors duration-300">
                            <i class="fas fa-phone-alt text-xl text-blue-600 group-hover:text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Telepon</h3>
                        <p class="text-slate-500 text-sm mb-4">
                            Hubungi kami pada jam kerja untuk informasi resmi.
                        </p>
                        <a href="tel:{{ setting('contact_phone') }}"
                           class="text-blue-600 font-bold text-sm hover:underline">
                            {{ setting('contact_phone', '(+62) xxx') }}
                        </a>
                    </div>

                    {{-- Email Card --}}
                    <div class="bg-white rounded-xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                        <div class="w-12 h-12 bg-orange-50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-orange-500 transition-colors duration-300">
                            <i class="fas fa-envelope text-xl text-orange-600 group-hover:text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Email Resmi</h3>
                        <p class="text-slate-500 text-sm mb-4">Pertanyaan formal atau pengiriman dokumen.</p>
                        <a href="mailto:{{ setting('contact_email') }}" 
                           class="text-orange-600 font-bold text-sm hover:underline">
                            {{ setting('contact_email', 'email@unsap.ac.id') }}
                        </a>
                    </div>

                    {{-- Location Card --}}
                    <div class="bg-white rounded-xl p-8 border border-slate-200 shadow-sm hover:shadow-md transition-all group">
                        <div class="w-12 h-12 bg-blue-50 rounded-lg flex items-center justify-center mb-6 group-hover:bg-blue-600 transition-colors duration-300">
                            <i class="fas fa-map-marker-alt text-xl text-blue-600 group-hover:text-white"></i>
                        </div>
                        <h3 class="text-lg font-bold text-slate-800 mb-2">Lokasi Kampus</h3>
                        <p class="text-slate-500 text-sm mb-4">{{ Str::limit(setting('contact_address', 'Alamat kampus'), 50) }}</p>
                        <span class="text-blue-600 font-bold text-sm">Lihat Detail Peta di Bawah</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- MAIN CONTENT --}}
        <div class="container mx-auto px-6 py-16">
            <div class="grid lg:grid-cols-3 gap-12">
                
                {{-- LEFT: Working Hours & Social --}}
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-slate-900 rounded-xl p-8 text-white shadow-lg overflow-hidden relative">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-orange-500/10 rounded-full -mr-10 -mt-10"></div>
                        <h3 class="text-xl font-bold mb-6 flex items-center gap-3 border-b border-white/10 pb-4">
                            <i class="fas fa-clock text-orange-500"></i> Jam Operasional
                        </h3>
                        <div class="space-y-4">
                            @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                            <div class="flex justify-between items-center text-sm">
                                <span class="text-slate-400">{{ $hari }}</span>
                                <span class="font-medium">{{ setting('hours_weekday', '07.00 - 16.00') }}</span>
                            </div>
                            @endforeach
                            <div class="flex justify-between items-center text-red-400 pt-2 font-bold text-sm">
                                <span>Minggu</span>
                                <span class="bg-red-500/10 px-2 py-1 rounded">{{ setting('hours_sunday', 'TUTUP') }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-xl p-8 border border-slate-200 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-6">Media Sosial</h3>
                        <div class="flex gap-4">
                            @if(setting('social_instagram') && setting('social_instagram') != '#')
                            <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-orange-500 hover:text-white transition-all">
                                <i class="fab fa-instagram"></i>
                            </a>
                            @endif
                            @if(setting('social_facebook') && setting('social_facebook') != '#')
                            <a href="{{ setting('social_facebook') }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-blue-600 hover:text-white transition-all">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                            @if(setting('social_youtube') && setting('social_youtube') != '#')
                            <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener noreferrer"
                               class="w-10 h-10 rounded-lg bg-slate-100 flex items-center justify-center text-slate-600 hover:bg-red-600 hover:text-white transition-all">
                                <i class="fab fa-youtube"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- RIGHT: WhatsApp Form & Map --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white rounded-xl p-8 md:p-10 border border-slate-200 shadow-sm">
                        <div class="mb-8">
                            <h2 class="text-2xl font-bold text-slate-800 mb-2">Kirim Pesan Langsung</h2>
                            <p class="text-slate-500 text-sm">Lengkapi data berikut untuk terhubung ke WhatsApp Admin kami.</p>
                        </div>

                        <form class="space-y-6">
                            <div class="grid md:grid-cols-2 gap-6">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1">Nama Lengkap</label>
                                    <input type="text" id="nama" required placeholder="Masukkan nama..." 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all text-sm">
                                </div>
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase ml-1">Email</label>
                                    <input type="email" id="email" placeholder="email@contoh.com" 
                                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all text-sm">
                                </div>
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase ml-1">Pesan</label>
                                <textarea id="pesan" rows="4" required placeholder="Tuliskan pesan Anda..." 
                                    class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:bg-white outline-none transition-all text-sm resize-none"></textarea>
                            </div>
                            <button type="button" onclick="kirimKeWA()" 
                                class="w-full md:w-auto px-8 py-4 bg-slate-900 hover:bg-green-600 text-white font-bold rounded-lg transition-all flex items-center justify-center gap-3 text-sm">
                                KIRIM KE WHATSAPP <i class="fab fa-whatsapp"></i>
                            </button>
                        </form>
                    </div>

                    {{-- Map --}}
                    <div class="bg-white rounded-xl overflow-hidden shadow-xl border border-slate-100 h-80 relative group">
                        <iframe 
                            src="{{ setting('contact_map_embed', 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3961.437233140183!2d107.9218514!3d-6.8380724') }}"
                            class="w-full h-full grayscale hover:grayscale-0 transition-all duration-1000"
                            style="border:0;"
                            allowfullscreen
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>

                        <div class="absolute bottom-6 left-6">
                            <a href="{{ setting('contact_map_link', '#') }}"
                               target="_blank"
                               class="bg-white/90 backdrop-blur px-6 py-3 rounded-2xl text-xs font-bold text-slate-800 shadow-xl flex items-center gap-3 hover:bg-orange-500 hover:text-white transition-all">
                                <i class="fas fa-directions text-orange-500 group-hover:text-white"></i>
                                PETUNJUK LOKASI
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- WhatsApp Script --}}
<script>
function kirimKeWA() {
    const nama = document.getElementById('nama').value;
    const email = document.getElementById('email').value;
    const pesan = document.getElementById('pesan').value;
    const nomorWA = "{{ setting('contact_whatsapp', '6285315654194') }}"; 

    if (!nama || !pesan) {
        alert("Mohon lengkapi Nama dan Pesan.");
        return;
    }

    const text = `Halo Admin FEB UNSAP,%0a%0aNama: ${encodeURIComponent(nama)}%0aEmail: ${encodeURIComponent(email || '-')}%0aPesan: ${encodeURIComponent(pesan)}`;
    window.open(`https://wa.me/${nomorWA}?text=${text}`, '_blank');
}
</script>
@endsection