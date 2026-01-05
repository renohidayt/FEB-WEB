<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<script>
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    unsap: {
                        red: '#C91818',
                        yellow: '#FFCC00',
                        dark: '#0f172a', // Slate 900
                    }
                }
            }
        }
    }
</script>

<footer class="relative bg-unsap-dark text-slate-300 overflow-hidden font-sans border-t border-slate-800">
    
    <div class="absolute inset-0 z-0 opacity-[0.07]" 
         style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png'); background-repeat: repeat;">
    </div>

    <div class="absolute top-0 left-0 w-96 h-96 bg-unsap-red/20 rounded-full blur-[100px] -translate-x-1/2 -translate-y-1/2 pointer-events-none z-0"></div>
    <div class="absolute bottom-0 right-0 w-96 h-96 bg-unsap-yellow/10 rounded-full blur-[100px] translate-x-1/2 translate-y-1/2 pointer-events-none z-0"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-16 z-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8">
            
            {{-- LOGO & DESCRIPTION SECTION --}}
            <div class="lg:col-span-5 space-y-6">
                <div class="flex items-center gap-4">
                    <div class="relative group">
                        <div class="absolute -inset-2 bg-gradient-to-r from-unsap-red to-unsap-yellow rounded-full blur opacity-20 group-hover:opacity-40 transition duration-500"></div>
                        <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo UNSAP" class="relative h-20 w-20 object-contain bg-white/5 rounded-full p-1.5 backdrop-blur-sm border border-white/10 shadow-2xl">
                    </div>
                    <div>
                        <h3 class="text-white font-extrabold text-2xl leading-none tracking-tight font-heading">
                            FAKULTAS <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-unsap-yellow to-amber-500 drop-shadow-sm">EKONOMI & BISNIS</span>
                        </h3>
                        <p class="text-[10px] font-bold text-slate-400 mt-1 tracking-[0.2em] uppercase">Universitas Sebelas April</p>
                    </div>
                </div>
                
                <p class="text-slate-400 text-sm leading-relaxed max-w-md border-l-2 border-unsap-red/50 pl-4">
                    {{ setting('site_description', 'Mencetak lulusan unggul, mandiri, dan profesional dalam bidang ekonomi dan bisnis yang berlandaskan nilai-nilai kewirausahaan.') }}
                </p>

                {{-- ADDRESS SECTION - UPDATED WITH SETTING --}}
                <div class="flex items-start gap-3 text-sm text-slate-400 mt-4 bg-slate-900/60 backdrop-blur-md p-4 rounded-xl border border-white/5 shadow-lg">
                    <i class="fas fa-map-marker-alt text-unsap-red mt-1 shrink-0"></i>
                    <p class="leading-relaxed">{{ setting('contact_address', 'Jl. Angkrek Situ No.19, Kec. Sumedang Utara, Kabupaten Sumedang, Jawa Barat 45323') }}</p>
                </div>
            </div>

            {{-- QUICK LINKS SECTION --}}
<div class="lg:col-span-3 lg:pl-8">
    <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
        <span class="w-8 h-0.5 bg-unsap-yellow rounded-full shadow-[0_0_10px_rgba(255,204,0,0.5)]"></span>
        Quick Links
    </h3>

    {{-- INFORMASI FAKULTAS --}}
    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">
        Informasi Fakultas
    </h4>
    <ul class="space-y-3 mb-6">
        @foreach([
            ['label' => 'Beranda', 'route' => 'home'],
            ['label' => 'Profil Fakultas', 'route' => 'profile.history'],
            ['label' => 'Program Studi', 'route' => 'study-programs.index'],
            ['label' => 'Profil Dosen', 'route' => 'lecturers.index'],
        ] as $link)
        <li>
            <a href="{{ route($link['route']) }}"
               class="group flex items-center text-slate-400 hover:text-white transition-all duration-300">
                <i class="fas fa-chevron-right text-[10px] text-slate-600 group-hover:text-unsap-red mr-3 transition-colors"></i>
                <span class="group-hover:translate-x-1 transition-transform">
                    {{ $link['label'] }}
                </span>
            </a>
        </li>
        @endforeach
    </ul>

    {{-- AKADEMIK & PUBLIK --}}
    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">
        Akademik & Publik
    </h4>
    <ul class="space-y-3">
        @foreach([
            ['label' => 'Berita Terkini', 'route' => 'news.index'],
            ['label' => 'Agenda & Event', 'route' => 'events.index'],
            ['label' => 'Beasiswa', 'route' => 'scholarships.index'],
            ['label' => 'Galeri', 'route' => 'galleries.index'],
            ['label' => 'Dokumen', 'route' => 'documents.index'],
        ] as $link)
        <li>
            <a href="{{ route($link['route']) }}"
               class="group flex items-center text-slate-400 hover:text-white transition-all duration-300">
                <i class="fas fa-chevron-right text-[10px] text-slate-600 group-hover:text-unsap-yellow mr-3 transition-colors"></i>
                <span class="group-hover:translate-x-1 transition-transform">
                    {{ $link['label'] }}
                </span>
            </a>
        </li>
        @endforeach
    </ul>
</div>


            {{-- CONTACT & SOCIAL MEDIA SECTION --}}
            <div class="lg:col-span-4">
                <h3 class="text-white font-bold text-lg mb-6 flex items-center gap-2">
                    <span class="w-8 h-0.5 bg-unsap-red rounded-full shadow-[0_0_10px_rgba(201,24,24,0.5)]"></span>
                    Hubungi Kami
                </h3>
                
                {{-- CONTACT INFO - UPDATED WITH SETTING --}}
                <ul class="space-y-4 mb-8">
                    <li class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-slate-800/80 border border-white/5 flex items-center justify-center text-unsap-yellow group-hover:bg-unsap-yellow group-hover:text-slate-900 transition-all duration-300 shadow-lg">
                            <i class="fas fa-phone"></i>
                        </div>
                        <a href="tel:{{ setting('contact_phone') }}" class="text-slate-300 font-medium group-hover:text-white transition-colors">
                            {{ setting('contact_phone', '(+62) 852 1111 6071') }}
                        </a>
                    </li>
                    <li class="flex items-center gap-4 group">
                        <div class="w-10 h-10 rounded-lg bg-slate-800/80 border border-white/5 flex items-center justify-center text-unsap-yellow group-hover:bg-unsap-yellow group-hover:text-slate-900 transition-all duration-300 shadow-lg">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <a href="mailto:{{ setting('contact_email') }}" class="text-slate-300 font-medium group-hover:text-white transition-colors">
                            {{ setting('contact_email', 'feb@unsap.ac.id') }}
                        </a>
                    </li>
                </ul>

                {{-- SOCIAL MEDIA - UPDATED WITH SETTING --}}
                <div>
                    <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest mb-4">Social Media</h4>
                    <div class="flex gap-3">
                        @php
                            $socials = [
                                ['key' => 'social_instagram', 'icon' => 'fab fa-instagram', 'color' => 'hover:bg-gradient-to-tr hover:from-yellow-500 hover:to-pink-600'],
                                ['key' => 'social_youtube', 'icon' => 'fab fa-youtube', 'color' => 'hover:bg-black'],
                                ['key' => 'social_facebook', 'icon' => 'fab fa-facebook', 'color' => 'hover:bg-blue-600'],
                                ['key' => 'social_twitter', 'icon' => 'fab fa-twitter', 'color' => 'hover:bg-sky-500'],
                                ['key' => 'social_linkedin', 'icon' => 'fab fa-linkedin', 'color' => 'hover:bg-blue-700'],
                            ];
                        @endphp
                        
                        @foreach($socials as $social)
                            @if(setting($social['key']))
                            <a href="{{ setting($social['key']) }}"
                               target="_blank"
                               rel="noopener noreferrer"
                               class="w-10 h-10 rounded-full bg-slate-800 border border-white/5
                                      flex items-center justify-center text-slate-400 text-lg
                                      hover:text-white hover:-translate-y-1 transition-all duration-300
                                      {{ $social['color'] }} shadow-lg">
                                <i class="{{ $social['icon'] }}"></i>
                            </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- FOOTER BOTTOM --}}
        <div class="mt-16 pt-8 border-t border-slate-800/80 flex flex-col md:flex-row justify-between items-center gap-4 relative">
            <p class="text-sm text-slate-500 text-center md:text-left">
                &copy; {{ date('Y') }} <span class="text-slate-200 font-semibold tracking-wide">{{ setting('site_name', 'FEB UNSAP') }}</span>. All rights reserved.
            </p>
            
            <div class="flex gap-6 text-sm text-slate-500">
    <a href="{{ route('privacy.policy') }}" 
       class="hover:text-unsap-yellow transition-colors">
        Privacy Policy
    </a>
    <a href="{{ route('terms.service') }}" 
       class="hover:text-unsap-yellow transition-colors">
        Terms of Service
    </a>
</div>
        </div>
        
        <div class="absolute bottom-0 left-0 right-0 h-[2px] bg-gradient-to-r from-transparent via-unsap-red to-transparent opacity-80"></div>
    </div>
</footer>