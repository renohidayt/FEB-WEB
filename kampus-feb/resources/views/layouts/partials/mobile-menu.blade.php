<div id="mobile-menu-overlay" class="fixed inset-0 z-[9999] hidden">
    
    <div id="mobile-backdrop" class="absolute inset-0 bg-black/60 opacity-0 transition-opacity duration-300 backdrop-blur-sm"></div>

    <div id="mobile-sidebar" class="absolute right-0 top-0 h-full w-[85%] max-w-[320px] bg-white shadow-2xl transform translate-x-full transition-transform duration-300 ease-in-out flex flex-col font-[Poppins]">
        
        <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between bg-gray-50">
            <span class="text-lg font-bold text-gray-800">Menu Utama</span>
            <button id="close-mobile-menu" class="w-8 h-8 flex items-center justify-center rounded-full bg-white text-gray-500 hover:text-red-500 hover:bg-red-50 shadow-sm transition-all">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="px-5 py-4">
            <form action="{{ route('global.search') }}" method="GET" class="relative">
                <input type="text" 
                       name="search"
                       placeholder="Cari informasi..." 
                       class="w-full pl-10 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-700 focus:outline-none focus:border-orange-500 focus:ring-1 focus:ring-orange-500 transition-all">
                <i class="fas fa-search absolute left-3.5 top-3 text-gray-400 text-xs"></i>
            </form>
        </div>

        <div class="flex-1 overflow-y-auto px-5 py-2 space-y-1 custom-scrollbar">
            
            <a href="{{ route('home') }}" class="block px-3 py-3 rounded-lg text-[15px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors {{ request()->routeIs('home') ? 'bg-orange-50 text-orange-600' : '' }}">
                <div class="flex items-center">
                    <i class="fas fa-home w-8 text-center text-sm"></i> Beranda
                </div>
            </a>

            <div class="mobile-dropdown group">
                <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-[15px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-university w-8 text-center text-sm"></i> Profil
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-gray-400 transition-transform duration-300 group-[.active]:rotate-90"></i>
                </button>
                <div class="hidden pl-11 pr-2 pb-2 space-y-1 border-l-2 border-gray-100 ml-4 mt-1 group-[.active]:block animate-slideDown">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-2">Tentang Kami</div>
                    <a href="{{ route('profile.history') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Sejarah</a>
                    <a href="{{ route('profile.visi-misi') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Visi & Misi</a>
                    <a href="{{ route('profile.keunggulan') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Keunggulan Kompetitif</a>
                    <a href="{{ route('profile.dean') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Sambutan Dekan</a>
                    <a href="{{ route('profile.struktur') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Struktur Organisasi</a>
                    
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-3">Fasilitas</div>
                    <a href="{{ route('profile.sarana') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Sarana Prasarana</a>
                    <a href="{{ route('profile.kemahasiswaan') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Kemahasiswaan</a>
                    <a href="{{ route('profile.accreditation.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Akreditasi</a>
                    <a href="{{ route('facilities.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Fasilitas Umum</a>
                </div>
            </div>

            <div class="mobile-dropdown group">
                <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-[15px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-graduation-cap w-8 text-center text-sm"></i> Akademik
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-gray-400 transition-transform duration-300 group-[.active]:rotate-90"></i>
                </button>
                <div class="hidden pl-11 pr-2 pb-2 space-y-1 border-l-2 border-gray-100 ml-4 mt-1 group-[.active]:block animate-slideDown">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-2">Perkuliahan</div>
                    <a href="{{ route('study-programs.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Program Studi</a>
                    <a href="https://lms.unsap.ac.id" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">LMS (E-Learning)
                                </a></a>
                    <a href="{{ route('lecturers.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Daftar Dosen</a>
                    <a href="{{ route('scholarships.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Beasiswa</a>
                    
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-3">Jadwal</div>
                    <a href="{{ route('academic.schedule') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Jadwal Kuliah</a>
                    <a href="{{ route('academic.calendar') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Kalender Akademik</a>
                </div>
            </div>

            <div class="mobile-dropdown group">
                <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-[15px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-flask w-8 text-center text-sm"></i> Riset & Publikasi
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-gray-400 transition-transform duration-300 group-[.active]:rotate-90"></i>
                </button>
                <div class="hidden pl-11 pr-2 pb-2 space-y-1 border-l-2 border-gray-100 ml-4 mt-1 group-[.active]:block animate-slideDown">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-2">Publikasi</div>
                    <a href="{{ route('journals.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Jurnal Fakultas</a>
                    <a href="https://ejournal.unsap.ac.id" target="_blank" rel="noopener noreferrer" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">E-Journal</a>
                    
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-3">Lembaga</div>
                    <a href="https://lppm.unsap.ac.id" target="_blank" rel="noopener noreferrer" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">LPPM</a>
                    <a href="https://spm.unsap.ac.id/" target="_blank" rel="noopener noreferrer" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">LPM</a>
                    <a href="https://kemahasiswaan.unsap.ac.id/" target="_blank" rel="noopener noreferrer" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">KAKSI</a>
                </div>
            </div>

            <div class="mobile-dropdown group">
                <button class="w-full flex items-center justify-between px-3 py-3 rounded-lg text-[15px] font-medium text-gray-700 hover:bg-orange-50 hover:text-orange-600 transition-colors">
                    <div class="flex items-center">
                        <i class="fas fa-layer-group w-8 text-center text-sm"></i> Lainnya
                    </div>
                    <i class="fas fa-chevron-right text-[10px] text-gray-400 transition-transform duration-300 group-[.active]:rotate-90"></i>
                </button>
                <div class="hidden pl-11 pr-2 pb-2 space-y-1 border-l-2 border-gray-100 ml-4 mt-1 group-[.active]:block animate-slideDown">
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-2">Media</div>
                    <a href="{{ route('news.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Berita Terkini</a>
                    <a href="{{ route('events.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Event & Agenda</a>
                    <a href="{{ route('galleries.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Galeri Foto</a>
                    <a href="{{ route('documents.index') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">Dokumen</a>
                    
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-2 mt-3">Pengguna</div>
                    <a href="{{ route('contact') }}" class="block py-2 text-[13px] text-gray-600 hover:text-orange-600">
                        <i class="fas fa-phone mr-2"></i>Kontak Kami
                    </a>
                    
                    {{-- PENGAJUAN SURAT - PUBLIK (SELALU TAMPIL) --}}
                    <a href="{{ route('letters.index') }}" class="block py-2 text-[13px] text-orange-600 hover:text-orange-700 font-semibold">
                        <i class="fas fa-envelope mr-2"></i>Pengajuan Surat
                        <span class="ml-2 text-[9px] bg-orange-100 text-orange-600 px-1.5 py-0.5 rounded-full uppercase">Publik</span>
                    </a>
                    
                    {{-- USER MENU (HANYA UNTUK YANG LOGIN) --}}
                    @auth
                        <div class="h-px bg-gray-100 my-3"></div>
                        
                        {{-- User Info Card --}}
                        <div class="bg-gradient-to-br from-slate-50 to-slate-100 rounded-lg p-3 mb-2 border border-slate-200 shadow-sm">
                            <div class="flex items-center gap-3 mb-2">
                                <div class="w-10 h-10 rounded-full bg-white flex items-center justify-center text-slate-600 border-2 border-slate-200 shadow-sm">
                                    <i class="fas fa-user text-sm"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-sm font-bold text-slate-800 truncate">{{ auth()->user()->name }}</p>
                                </div>
                            </div>
                            
                            {{-- Role Badge --}}
                            @if(auth()->user()->isSuperAdmin())
                                <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-purple-50 text-purple-700 text-[10px] font-bold rounded-md border border-purple-100">
                                    <i class="fas fa-crown text-[9px]"></i> SUPER ADMIN
                                </div>
                            @elseif(auth()->user()->isAdmin())
                                <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-blue-50 text-blue-700 text-[10px] font-bold rounded-md border border-blue-100">
                                    <i class="fas fa-shield-halved text-[9px]"></i> ADMIN
                                </div>
                            @elseif(auth()->user()->student)
                                <div class="inline-flex items-center gap-1.5 px-2 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold rounded-md border border-emerald-100">
                                    <i class="fas fa-id-card text-[9px]"></i> {{ auth()->user()->student->nim }}
                                </div>
                            @else
                                <div class="inline-flex items-center px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-medium rounded-md border border-slate-200">
                                    User
                                </div>
                            @endif
                        </div>
                        
                        {{-- Dashboard Link --}}
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 py-2 px-2 text-[13px] text-blue-600 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-all font-medium">
                                <div class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center">
                                    <i class="fas fa-gauge-high text-xs"></i>
                                </div>
                                Dashboard Admin
                            </a>
                        @elseif(auth()->user()->student)
                            <a href="{{ route('student.dashboard') }}" class="flex items-center gap-2 py-2 px-2 text-[13px] text-emerald-600 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition-all font-medium">
                                <div class="w-6 h-6 rounded bg-emerald-100 flex items-center justify-center">
                                    <i class="fas fa-user-graduate text-xs"></i>
                                </div>
                                Dashboard Mahasiswa
                            </a>
                        @endif
                        
                        {{-- Logout --}}
                        <form method="POST" action="{{ auth()->user()->isAdmin() ? route('logout') : route('student.logout') }}">
                            @csrf
                            <button type="submit" class="flex items-center gap-2 w-full text-left py-2 px-2 text-[13px] text-red-600 hover:text-red-700 hover:bg-red-50 rounded-lg transition-all font-medium mt-1">
                                <div class="w-6 h-6 rounded bg-red-100 flex items-center justify-center">
                                    <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                                </div>
                                Sign Out
                            </button>
                        </form>
                    @else
                        {{-- Guest Menu (Belum Login) --}}
                        <div class="h-px bg-gray-100 my-3"></div>
                        
                        <a href="{{ route('student.login') }}" class="flex items-center gap-2 py-2 px-2 text-[13px] text-green-600 hover:text-green-700 hover:bg-green-50 rounded-lg transition-all font-medium">
                            <div class="w-6 h-6 rounded bg-green-100 flex items-center justify-center">
                                <i class="fas fa-user-graduate text-xs"></i>
                            </div>
                            Login Mahasiswa
                        </a>
                    @endauth
                </div>
            </div>

        </div>

        <div class="p-5 border-t border-gray-100 bg-gray-50">
            <div class="flex items-center justify-center space-x-6">
                <a href="https://www.instagram.com/febsascredible?igsh=MTYxNG9zOXEyOHQ0cA==" class="text-gray-400 hover:text-pink-600 transition-colors"><i class="fab fa-instagram text-lg"></i></a>
                <a href="https://youtube.com/@febunsap?si=QT00xSOo1jeYtXxd" class="text-gray-400 hover:text-red-600 transition-colors"><i class="fab fa-youtube text-lg"></i></a>
            </div>
            <p class="text-[10px] text-center text-gray-400 mt-3">&copy; 2026 Fakultas Ekonomi Bisnis UNSAP</p>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // === Logic untuk Mobile Menu Sidebar ===
    const mobileBtn = document.getElementById('mobile-menu-btn');
    const closeBtn = document.getElementById('close-mobile-menu');
    const overlay = document.getElementById('mobile-menu-overlay');
    const sidebar = document.getElementById('mobile-sidebar');
    const backdrop = document.getElementById('mobile-backdrop');

    // Fungsi Buka Menu
    function openMenu() {
        overlay.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            backdrop.classList.remove('opacity-0');
            sidebar.classList.remove('translate-x-full');
        }, 10);
    }

    // Fungsi Tutup Menu
    function closeMenu() {
        backdrop.classList.add('opacity-0');
        sidebar.classList.add('translate-x-full');
        
        setTimeout(() => {
            overlay.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    // Event Listeners
    if(mobileBtn) mobileBtn.addEventListener('click', openMenu);
    if(closeBtn) closeBtn.addEventListener('click', closeMenu);
    if(backdrop) backdrop.addEventListener('click', closeMenu);

    // Tutup menu dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && !overlay.classList.contains('hidden')) {
            closeMenu();
        }
    });

    // === Logic untuk Accordion Dropdown di dalam Mobile Menu ===
    const dropdowns = document.querySelectorAll('.mobile-dropdown button');
    
    dropdowns.forEach(btn => {
        btn.addEventListener('click', function() {
            const parent = this.parentElement;
            parent.classList.toggle('active');
        });
    });
});
</script>

<style>
/* Custom Scrollbar untuk Mobile Sidebar */
.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: #f1f1f1;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #cbd5e1;
    border-radius: 4px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #94a3b8;
}

/* Animasi Slide Down untuk Dropdown Content */
@keyframes slideDown {
    from {
        opacity: 0;
        max-height: 0;
    }
    to {
        opacity: 1;
        max-height: 500px;
    }
}

.animate-slideDown {
    animation: slideDown 0.3s ease-out;
}
</style>