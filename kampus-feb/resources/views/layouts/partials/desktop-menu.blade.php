<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    .nav-container {
        font-family: 'Poppins', sans-serif;
    }
    
    /* Efek hover icon di dalam dropdown */
    .nav-link-item:hover .nav-icon {
        color: #ea580c; /* orange-600 */
        transform: scale(1.1);
    }
    
    /* Custom Scrollbar untuk dropdown jika konten panjang */
    .dropdown-scroll::-webkit-scrollbar { width: 4px; }
    .dropdown-scroll::-webkit-scrollbar-track { background: transparent; }
    .dropdown-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
</style>

<div class="nav-container h-full flex items-center gap-1">

    <a href="{{ route('home') }}" 
       class="px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors relative group h-full flex items-center {{ request()->routeIs('home') ? 'text-orange-600' : '' }}">
        Beranda
        <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-orange-600 group-hover:w-full transition-all duration-300 rounded-t-md"></span>
    </a>

    <div class="dropdown static h-full flex items-center">
        <button type="button" class="dropdown-toggle px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors flex items-center h-full group relative">
            Profil
            <i class="fas fa-chevron-down dropdown-arrow ml-1.5 text-[10px] transition-transform duration-300"></i>
            <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-orange-600 group-hover:w-full transition-all duration-300 rounded-t-md"></span>
        </button>
        
        <div class="dropdown-menu absolute left-0 top-full w-full bg-white shadow-xl border-t border-gray-100 hidden z-[999] transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4 border-r border-gray-100 pr-6">
                        <h3 class="text-2xl font-bold text-gray-800 leading-tight mb-2">Profil<br>Fakultas</h3>
                        <div class="w-8 h-1 bg-orange-600 rounded-full mb-4"></div>
                       <p class="text-sm text-gray-500 leading-relaxed mb-4">
                            Mengenal sejarah, visi misi, dan pimpinan<br>Fakultas.
                        </p>
                        <a href="{{ route('profile.history') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700 flex items-center group/link">
                            Selengkapnya <i class="fas fa-arrow-right ml-2 text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    <div class="lg:w-1/2 px-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Tentang Kami</h4>
                                <a href="{{ route('profile.history') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-book-open nav-icon w-5 text-gray-400 transition-all duration-300"></i> Sejarah
                                </a>
                                <a href="{{ route('profile.visi-misi') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-eye nav-icon w-5 text-gray-400 transition-all duration-300"></i> Visi & Misi
                                </a>
                                <a href="{{ route('profile.keunggulan') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-star nav-icon w-5 text-gray-400 transition-all duration-300"></i> Keunggulan Kompetitif
                                </a>
                                <a href="{{ route('profile.dean') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-handshake nav-icon w-5 text-gray-400 transition-all duration-300"></i> Sambutan Dekan
                                </a>
                                <a href="{{ route('profile.struktur') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-sitemap nav-icon w-5 text-gray-400 transition-all duration-300"></i> Struktur Organisasi
                                </a>
                            </div>
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Fasilitas</h4>
                                <a href="{{ route('profile.sarana') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-tools nav-icon w-5 text-gray-400 transition-all duration-300"></i> Sarana Prasarana
                                </a>
                                <a href="{{ route('profile.kemahasiswaan') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-graduation-cap nav-icon w-5 text-gray-400 transition-all duration-300"></i> Kemahasiswaan
                                </a>
                                <a href="{{ route('profile.accreditation.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-certificate nav-icon w-5 text-gray-400 transition-all duration-300"></i> Akreditasi
                                </a>
                                <a href="{{ route('facilities.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-building nav-icon w-5 text-gray-400 transition-all duration-300"></i> Fasilitas Umum
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/4 hidden lg:block border-l border-gray-100 pl-6">
                        <div class="relative w-full h-48 rounded-lg overflow-hidden group shadow-md">
                            <img src="{{ asset('assets/img/gambar2.jpg') }}" alt="Suasana Akademik" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4 z-10">
                                <span class="text-[10px] font-bold text-orange-400 tracking-wider block mb-1">FEATURED</span>
                                <p class="text-white text-xs font-semibold leading-tight">Kampus Inovatif</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown static h-full flex items-center">
        <button type="button" class="dropdown-toggle px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors flex items-center h-full group relative">
            Akademik
            <i class="fas fa-chevron-down dropdown-arrow ml-1.5 text-[10px] transition-transform duration-300"></i>
            <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-orange-600 group-hover:w-full transition-all duration-300 rounded-t-md"></span>
        </button>
        
        <div class="dropdown-menu absolute left-0 top-full w-full bg-white shadow-xl border-t border-gray-100 hidden z-[999] transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4 border-r border-gray-100 pr-6">
                        <h3 class="text-2xl font-bold text-gray-800 leading-tight mb-2">Info<br>Akademik</h3>
                        <div class="w-8 h-1 bg-orange-600 rounded-full mb-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">Informasi perkuliahan, dosen, dan jadwal.</p>
                        <a href="{{ route('study-programs.index') }}" class="text-sm font-semibold text-orange-600 hover:text-orange-700 flex items-center group/link">
                            Info Prodi <i class="fas fa-arrow-right ml-2 text-xs transform group-hover/link:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    <div class="lg:w-1/2 px-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Perkuliahan</h4>
                                <a href="{{ route('study-programs.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-th-large nav-icon w-5 text-gray-400 transition-all duration-300"></i> Program Studi
                                </a>
                                <a href="https://lms.unsap.ac.id" target="_blank" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-laptop-code nav-icon w-5 text-gray-400 transition-all duration-300"></i> LMS (E-Learning)
                                </a>
                                <a href="{{ route('lecturers.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-chalkboard-teacher nav-icon w-5 text-gray-400 transition-all duration-300"></i> Daftar Dosen
                                </a>
                                <a href="{{ route('scholarships.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-hand-holding-usd nav-icon w-5 text-gray-400 transition-all duration-300"></i> Beasiswa
                                </a>
                            </div>
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Jadwal</h4>
                                <a href="{{ route('academic.schedule') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-clock nav-icon w-5 text-gray-400 transition-all duration-300"></i> Jadwal Kuliah
                                </a>
                                <a href="{{ route('academic.calendar') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-calendar-alt nav-icon w-5 text-gray-400 transition-all duration-300"></i> Kalender Akademik
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/4 hidden lg:block border-l border-gray-100 pl-6">
                        <div class="relative w-full h-48 rounded-lg overflow-hidden group shadow-md">
                            <img src="{{ asset('assets/img/gambar6.jpg') }}" alt="Suasana Akademik" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4 z-10">
                                <span class="text-[10px] font-bold text-orange-400 tracking-wider block mb-1">KEGIATAN</span>
                                <p class="text-white text-xs font-semibold leading-tight">Suasana Akademik</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown static h-full flex items-center">
        <button type="button" class="dropdown-toggle px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors flex items-center h-full group relative">
            Riset & Publikasi
            <i class="fas fa-chevron-down dropdown-arrow ml-1.5 text-[10px] transition-transform duration-300"></i>
            <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-orange-600 group-hover:w-full transition-all duration-300 rounded-t-md"></span>
        </button>
        
        <div class="dropdown-menu absolute left-0 top-full w-full bg-white shadow-xl border-t border-gray-100 hidden z-[999] transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4 border-r border-gray-100 pr-6">
                        <h3 class="text-2xl font-bold text-gray-800 leading-tight mb-2">Riset &<br>Pengabdian</h3>
                        <div class="w-8 h-1 bg-orange-600 rounded-full mb-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">Inovasi, penelitian ilmiah, dan pengabdian <br> masyarakat.</p>
                    </div>
                    <div class="lg:w-1/2 px-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Publikasi</h4>
                                <a href="{{ route('journals.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-trophy nav-icon w-5 text-gray-400 transition-all duration-300"></i> Jurnal Fakultas
                                </a>
                                <a href="https://ejournal.unsap.ac.id" target="_blank" rel="noopener noreferrer" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-journal-whills nav-icon w-5 text-gray-400 transition-all duration-300"></i> E-Journal
                                </a>

                            </div>
                            <div class="space-y-3">
    <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Lembaga</h4>
    
    <a href="https://lppm.unsap.ac.id" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
        <i class="fas fa-flask nav-icon w-5 text-gray-400 transition-all duration-300"></i> LPPM
    </a>

    <a href="https://spm.unsap.ac.id/" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
        <i class="fas fa-clipboard-check nav-icon w-5 text-gray-400 transition-all duration-300"></i> LPM
    </a>

    <a href="https://kemahasiswaan.unsap.ac.id/" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
        <i class="fas fa-user-graduate nav-icon w-5 text-gray-400 transition-all duration-300"></i> KAKSI
    </a>
</div>
                        </div>
                    </div>
                    <div class="lg:w-1/4 hidden lg:block border-l border-gray-100 pl-6">
                        <div class="relative w-full h-48 overflow-hidden rounded-lg group">
                            <img src="{{ asset('assets/img/gambar5.jpg') }}" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/30 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 z-20 p-4">
                                <span class="text-[10px] font-bold text-orange-400 tracking-wider">INOVASI</span>
                                <p class="text-white text-xs font-semibold leading-tight">Pengembangan Ilmu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="dropdown static h-full flex items-center">
        <button type="button" class="dropdown-toggle px-3 py-2 text-sm font-medium text-gray-700 hover:text-orange-600 transition-colors flex items-center h-full group relative">
            Lainnya
            <i class="fas fa-chevron-down dropdown-arrow ml-1.5 text-[10px] transition-transform duration-300"></i>
            <span class="absolute bottom-0 left-0 w-0 h-[3px] bg-orange-600 group-hover:w-full transition-all duration-300 rounded-t-md"></span>
        </button>
        
        <div class="dropdown-menu absolute left-0 top-full w-full bg-white shadow-xl border-t border-gray-100 hidden z-[999] transition-all duration-300">
            <div class="max-w-7xl mx-auto px-6 lg:px-8 py-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <div class="lg:w-1/4 border-r border-gray-100 pr-6">
                        <h3 class="text-2xl font-bold text-gray-800 leading-tight mb-2">Layanan &<br>Info</h3>
                        <div class="w-8 h-1 bg-orange-600 rounded-full mb-4"></div>
                        <p class="text-sm text-gray-500 leading-relaxed mb-4">Berita terkini, galeri, kontak, dan portal <br> pengguna.</p>
                    </div>
                    <div class="lg:w-1/2 px-4">
                        <div class="grid grid-cols-2 gap-x-8 gap-y-4">
                            <div class="space-y-3">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Media</h4>
                                <a href="{{ route('news.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-newspaper nav-icon w-5 text-gray-400 transition-all duration-300"></i> Berita Terkini
                                </a>
                                <a href="{{ route('events.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-calendar-check nav-icon w-5 text-gray-400 transition-all duration-300"></i> Event & Agenda
                                </a>
                                <a href="{{ route('galleries.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-images nav-icon w-5 text-gray-400 transition-all duration-300"></i> Galeri Foto
                                </a>
                                <a href="{{ route('documents.index') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-file-alt nav-icon w-5 text-gray-400 transition-all duration-300"></i> Dokumen
                                </a>
                            </div>

                            <div class="space-y-3 relative z-10">
                                <h4 class="text-[11px] font-bold text-gray-400 uppercase tracking-widest mb-1">Pengguna</h4>
                                
                                <a href="{{ route('contact') }}" class="nav-link-item flex items-center text-[13px] text-gray-600 hover:text-orange-600 transition-colors">
                                    <i class="fas fa-phone nav-icon w-5 text-gray-400 transition-all duration-300"></i> Kontak Kami
                                </a>
                                
                                <a href="{{ route('letters.index') }}" class="nav-link-item flex items-center text-[13px] text-orange-600 hover:text-orange-700 transition-colors font-semibold">
                                    <i class="fas fa-envelope nav-icon w-5 text-orange-500 transition-all duration-300"></i> 
                                    Pengajuan Surat
                                    <span class="ml-2 text-[9px] bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full uppercase tracking-tighter">Publik</span>
                                </a>

                                @auth
                                    <div class="relative group mt-2 w-full">
                                        <button type="button" class="flex items-center gap-2 w-full text-left px-2 py-1.5 -ml-2 rounded hover:bg-gray-50 transition-colors">
                                            <div class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center text-slate-600 border border-slate-200 shadow-sm">
                                                <i class="fas fa-user text-xs"></i>
                                            </div>
                                            <div class="flex flex-col">
                                                <span class="text-[13px] font-bold text-gray-700 leading-tight">{{ auth()->user()->name }}</span>
                                                <span class="text-[10px] text-gray-400">Akun Anda</span>
                                            </div>
                                            <i class="fas fa-chevron-right ml-auto text-[10px] text-gray-300"></i>
                                        </button>

                                        <div class="absolute left-0 mt-2 w-56 bg-white rounded-xl shadow-[0_4px_20px_-4px_rgba(0,0,0,0.1)] border border-slate-100 overflow-hidden transform opacity-0 scale-95 group-hover:opacity-100 group-hover:scale-100 transition-all duration-200 origin-top-left z-50 pointer-events-none group-hover:pointer-events-auto">
                                            
                                            <div class="px-5 py-4 bg-slate-50/50 border-b border-slate-100">
                                                <p class="text-sm font-bold text-slate-800 truncate leading-tight mb-2">
                                                    {{ auth()->user()->name }}
                                                </p>
                                                <div class="flex items-center">
                                                    @if(auth()->user()->isSuperAdmin())
                                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-purple-50 text-purple-600 border border-purple-100">
                                                            <i class="fas fa-crown text-[9px]"></i> SUPER ADMIN
                                                        </span>
                                                    @elseif(auth()->user()->isAdmin())
                                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-blue-50 text-blue-600 border border-blue-100">
                                                            <i class="fas fa-shield-halved text-[9px]"></i> ADMIN
                                                        </span>
                                                    @elseif(auth()->user()->student)
                                                        <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-100">
                                                            <i class="fas fa-id-card text-[9px]"></i> 
                                                            {{ auth()->user()->student->nim }}
                                                        </span>
                                                    @else
                                                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-[10px] font-medium bg-slate-100 text-slate-500 border border-slate-200">
                                                            User
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="p-1.5">
                                                @if(auth()->user()->isAdmin())
                                                    <a href="{{ route('admin.dashboard') }}" 
                                                       class="flex items-center gap-3 w-full px-3 py-2 text-[13px] font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-blue-600 transition-all group">
                                                        <div class="w-6 h-6 rounded flex items-center justify-center bg-slate-50 text-slate-400 group-hover:bg-blue-100 group-hover:text-blue-600 transition-colors">
                                                            <i class="fas fa-gauge-high text-xs"></i>
                                                        </div>
                                                        Dashboard
                                                    </a>
                                                @elseif(auth()->user()->student)
                                                    <a href="{{ route('student.dashboard') }}" 
                                                       class="flex items-center gap-3 w-full px-3 py-2 text-[13px] font-medium text-slate-600 rounded-lg hover:bg-slate-50 hover:text-emerald-600 transition-all group">
                                                        <div class="w-6 h-6 rounded flex items-center justify-center bg-slate-50 text-slate-400 group-hover:bg-emerald-100 group-hover:text-emerald-600 transition-colors">
                                                            <i class="fas fa-user-graduate text-xs"></i>
                                                        </div>
                                                        Dashboard Mhs
                                                    </a>
                                                @endif

                                                <form method="POST" action="{{ auth()->user()->isAdmin() ? route('logout') : route('student.logout') }}">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="flex items-center gap-3 w-full px-3 py-2 text-[13px] font-medium text-slate-600 rounded-lg hover:bg-red-50 hover:text-red-600 transition-all group mt-1">
                                                        <div class="w-6 h-6 rounded flex items-center justify-center bg-slate-50 text-slate-400 group-hover:bg-red-100 group-hover:text-red-500 transition-colors">
                                                            <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                                                        </div>
                                                        Sign Out
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    {{-- Guest Menu (Untuk yang belum login) --}}
                                    <div class="flex flex-col gap-2 mt-2 pt-2 border-t border-gray-100">
                                        <a href="{{ route('student.login') }}" class="nav-link-item flex items-center text-[13px] text-green-600 hover:text-green-700 transition-colors font-medium">
                                            <i class="fas fa-user-graduate nav-icon w-5 text-green-400 transition-all duration-300"></i> 
                                            Login Mahasiswa
                                        </a>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    <div class="lg:w-1/4 hidden lg:block border-l border-gray-100 pl-6">
                        <div class="relative w-full h-48 rounded-lg overflow-hidden group shadow-md">
                            <img src="{{ asset('assets/img/gambar3.jpg') }}" alt="Suasana Akademik" class="w-full h-full object-cover transition-transform duration-700 ease-out group-hover:scale-110" />
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-0 left-0 p-4 z-10">
                                <span class="text-[10px] font-bold text-orange-400 tracking-wider block mb-1">JARINGAN</span>
                                <p class="text-white text-xs font-semibold leading-tight">Kolaborasi & Layanan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="h-5 w-px bg-gray-300 mx-1"></div>

    <button type="button" 
            onclick="toggleSearchModal()" 
            class="px-3 py-2 text-gray-500 hover:text-orange-600 transition-colors group relative" 
            title="Cari">
        <i class="fas fa-search text-sm transform group-hover:scale-110 transition-transform"></i>
    </button>
</div>

<div id="searchModal" class="fixed inset-0 z-[9999] hidden flex items-center justify-center">
    
    <div id="searchBackdrop" 
         class="absolute inset-0 bg-gray-900/95 transition-opacity duration-300 opacity-0 backdrop-blur-sm"
         onclick="toggleSearchModal()">
    </div>
    
    <div id="searchContent" 
         class="relative w-full max-w-4xl px-4 transform transition-all duration-300 scale-90 opacity-0">
        
        <div class="absolute -top-16 right-4 md:-right-4">
            <button onclick="toggleSearchModal()" class="text-gray-400 hover:text-white transition-colors p-2 group">
                <span class="text-sm mr-2 opacity-0 group-hover:opacity-100 transition-opacity duration-200">Tutup</span>
                <i class="fas fa-times text-3xl md:text-4xl transform group-hover:rotate-90 transition-transform duration-300"></i>
            </button>
        </div>

        <form action="{{ route('global.search') }}" method="GET" class="relative group">
            <input type="text" 
                   name="search" 
                   id="globalSearchInput"
                   class="w-full bg-transparent border-b-2 border-gray-600 text-3xl md:text-5xl text-white py-6 px-2 focus:outline-none focus:border-orange-500 placeholder-gray-600 transition-all duration-300 font-['Poppins'] text-center"
                   placeholder="Ketik Pencarian..." 
                   autocomplete="off">
            
            <p class="text-center text-gray-500 mt-6 font-['Poppins'] text-sm md:text-base tracking-wide animate-pulse">
                Tekan <span class="text-orange-500 font-bold bg-white/10 px-2 py-0.5 rounded">Enter</span> untuk mencari
            </p>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // --- JS Dropdown (Logic Dropdown Utama) ---
    const dropdowns = document.querySelectorAll('.dropdown');
    dropdowns.forEach(dropdown => {
        const toggle = dropdown.querySelector('.dropdown-toggle');
        const menu = dropdown.querySelector('.dropdown-menu');
        const arrow = dropdown.querySelector('.dropdown-arrow');
        if (toggle && menu) { 
            toggle.addEventListener('click', function(e) {
                e.stopPropagation();
                const isOpen = !menu.classList.contains('hidden');
                document.querySelectorAll('.dropdown').forEach(d => {
                    const m = d.querySelector('.dropdown-menu');
                    const a = d.querySelector('.dropdown-arrow');
                    const btn = d.querySelector('.dropdown-toggle');
                    if (d !== dropdown && m) {
                        m.classList.add('hidden');
                        if(a) a.classList.remove('rotate-180');
                        if(btn) btn.classList.remove('text-orange-600');
                    }
                });
                if (isOpen) {
                    menu.classList.add('hidden');
                    if(arrow) arrow.classList.remove('rotate-180');
                    toggle.classList.remove('text-orange-600');
                } else {
                    menu.classList.remove('hidden');
                    if(arrow) arrow.classList.add('rotate-180');
                    toggle.classList.add('text-orange-600');
                }
            });
        }
    });
    
    document.addEventListener('click', function(e) {
        document.querySelectorAll('.dropdown').forEach(d => {
            const menu = d.querySelector('.dropdown-menu');
            const arrow = d.querySelector('.dropdown-arrow');
            const toggle = d.querySelector('.dropdown-toggle');
            if (menu && !menu.contains(e.target)) {
                menu.classList.add('hidden');
                if(arrow) arrow.classList.remove('rotate-180');
                if(toggle) toggle.classList.remove('text-orange-600');
            }
        });
    });
    
    document.querySelectorAll('.dropdown-menu').forEach(menu => {
        menu.addEventListener('click', function(e) { e.stopPropagation(); });
    });

    // --- JS Search Overlay ---
    window.toggleSearchModal = function() {
        const modal = document.getElementById('searchModal');
        const backdrop = document.getElementById('searchBackdrop');
        const content = document.getElementById('searchContent');
        const input = document.getElementById('globalSearchInput');
        
        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                content.classList.remove('scale-90', 'opacity-0');
                content.classList.add('scale-100', 'opacity-100');
                input.focus();
            }, 10);
            document.body.style.overflow = 'hidden';
        } else {
            backdrop.classList.add('opacity-0');
            content.classList.remove('scale-100', 'opacity-100');
            content.classList.add('scale-90', 'opacity-0');
            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = 'auto';
                input.value = '';
            }, 300);
        }
    }
});
</script>