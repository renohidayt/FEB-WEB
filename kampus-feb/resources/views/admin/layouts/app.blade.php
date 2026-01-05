<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Admin FEB UNSAP</title>
    
    <link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    @stack('styles')
    
    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;      /* Slate 900 */
            --sidebar-hover: #1e293b;   /* Slate 800 */
            --primary-color: #3b82f6;   /* Blue 500 */
            --text-muted: #94a3b8;      /* Slate 400 */
            --text-light: #f1f5f9;      /* Slate 100 */
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: #f8fafc; /* Slate 50 */
            color: #334155;
        }

        /* --- SIDEBAR CUSTOMIZATION --- */
        #admin-sidebar {
            background-color: var(--sidebar-bg);
            border-right: 1px solid rgba(255,255,255,0.08);
            width: var(--sidebar-width);
            z-index: 1050;
        }

        /* Scrollbar Styling (Minimalist) */
        .sidebar-scroll {
            scrollbar-width: thin;
            scrollbar-color: #334155 transparent;
        }
        .sidebar-scroll::-webkit-scrollbar { width: 4px; }
        .sidebar-scroll::-webkit-scrollbar-track { background: transparent; }
        .sidebar-scroll::-webkit-scrollbar-thumb { background-color: #334155; border-radius: 20px; }

        /* Kategori Menu (Header Kecil) */
        .nav-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #475569;
            margin: 24px 0 12px 18px;
        }

        /* Nav Link Utama */
        .nav-link-custom {
            display: flex;
            align-items: center;
            width: 100%;
            padding: 12px 16px;
            font-size: 0.9rem;
            font-weight: 500;
            color: var(--text-muted);
            border-left: 3px solid transparent;
            transition: all 0.25s ease;
            text-decoration: none;
            background: transparent;
            border-radius: 0; /* Flat style professional */
        }

        /* Icon Styling */
        .nav-link-custom i.icon-main {
            width: 24px;
            text-align: center;
            margin-right: 12px;
            font-size: 1.1rem;
            transition: color 0.2s;
            color: #64748b;
        }

        /* Hover State */
        .nav-link-custom:hover,
        .nav-link-custom[aria-expanded="true"] {
            background-color: rgba(255, 255, 255, 0.03);
            color: #e2e8f0;
        }
        .nav-link-custom:hover i.icon-main,
        .nav-link-custom[aria-expanded="true"] i.icon-main {
            color: #ffffff;
        }

        /* Active State (Halaman yang sedang dibuka) */
        .nav-link-custom.active {
            background: linear-gradient(90deg, rgba(59, 130, 246, 0.1) 0%, transparent 100%);
            color: #ffffff;
            border-left-color: var(--primary-color);
        }
        .nav-link-custom.active i.icon-main {
            color: var(--primary-color);
        }

        /* Chevron (Panah) */
        .chevron { 
            margin-left: auto; 
            font-size: 0.75rem; 
            transition: transform 0.3s ease; 
            color: #475569;
        }
        .nav-link-custom[aria-expanded="true"] .chevron { 
            transform: rotate(-180deg); 
            color: #94a3b8;
        }

        /* --- SUBMENU --- */
        .submenu-wrapper {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.35s cubic-bezier(0.4, 0, 0.2, 1);
            background-color: rgba(0, 0, 0, 0.2);
        }
        .submenu-wrapper.open { 
            max-height: 800px; /* Cukup tinggi untuk menampung menu */
        }
        
        .submenu-link {
            display: flex;
            align-items: center;
            padding: 10px 20px 10px 54px; /* Indentasi rapi */
            font-size: 0.85rem;
            color: #94a3b8;
            text-decoration: none;
            transition: all 0.2s;
            position: relative;
        }
        
        /* Indikator Submenu (Titik/Garis) */
        .submenu-link::before {
            content: '';
            position: absolute;
            left: 36px;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 4px;
            background-color: #475569;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .submenu-link:hover { 
            color: #ffffff;
            padding-left: 58px; /* Efek geser sedikit saat hover */
        }
        .submenu-link:hover::before { background-color: #cbd5e1; }
        
        .submenu-link.active { 
            color: var(--primary-color); 
            background-color: rgba(59, 130, 246, 0.05);
            font-weight: 600;
        }
        .submenu-link.active::before { 
            background-color: var(--primary-color);
            width: 6px; height: 6px; /* Titik membesar jika aktif */
        }

        /* --- HEADER & LAYOUT --- */
        .header-main {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            height: 64px;
        }
        
        .logo-area {
            height: 64px;
            background-color: var(--sidebar-bg); /* Match sidebar */
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        /* Mobile Overlay */
        #sidebar-overlay {
            backdrop-filter: blur(2px);
        }
        
        @media (min-width: 768px) {
            .content-wrapper { margin-left: var(--sidebar-width); }
        }
    </style>
</head>
<body class="bg-slate-50">

    <div id="sidebar-overlay" class="fixed inset-0 bg-slate-900/80 z-40 hidden transition-opacity" onclick="closeSidebar()"></div>

    <div class="min-h-screen flex flex-col">

        <aside id="admin-sidebar" class="h-screen fixed top-0 left-0 flex flex-col transform transition-transform duration-300 ease-in-out -translate-x-full md:translate-x-0 shadow-xl">
            
            <div class="logo-area flex items-center px-6 flex-shrink-0">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 no-underline w-full group">
                    <img src="{{ asset('assets/img/logo/logo.png') }}" alt="logo" class="w-9 h-9 object-contain group-hover:scale-105 transition-transform">
                    <div class="flex flex-col">
                        <span class="font-bold text-white text-[15px] leading-tight tracking-wide">Admin Panel</span>
                        <span class="text-[11px] text-slate-400 uppercase tracking-widest">FEB UNSAP</span>
                    </div>
                </a>
                <button onclick="closeSidebar()" class="md:hidden ml-auto text-slate-400 hover:text-white transition-colors">
                    <i class="fas fa-times text-lg"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto sidebar-scroll pb-10">
                
                <div class="mt-4">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-custom {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-pie icon-main"></i>
                        <span>Dashboard</span>
                    </a>
                </div>

                <div class="nav-section-title">Main Content</div>

                @php $activeKonten = request()->routeIs('admin.news.*', 'admin.categories.*', 'admin.scholarships.*'); @endphp
                <div>
                    <button class="nav-link-custom w-full" onclick="toggleSubmenu('menu-konten', this)" aria-expanded="{{ $activeKonten ? 'true' : 'false' }}">
                        <i class="fa-solid fa-layer-group icon-main"></i>
                        <span class="flex-1 text-left">Kelola Konten</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div id="menu-konten" class="submenu-wrapper {{ $activeKonten ? 'open' : '' }}">
                        <a href="{{ route('admin.news.index') }}" class="submenu-link {{ request()->routeIs('admin.news.*') ? 'active' : '' }}">Berita & Artikel</a>
                        <a href="{{ route('admin.categories.index') }}" class="submenu-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">Kategori</a>
                        <a href="{{ route('admin.scholarships.index') }}" class="submenu-link {{ request()->routeIs('admin.scholarships.*') ? 'active' : '' }}">Beasiswa</a>
                    </div>
                </div>

                @php $activeAkad = request()->routeIs('admin.lecturers.*', 'admin.profiles.*', 'admin.accreditations.*', 'admin.journals.*', 'admin.academic-files.*', 'admin.events.*', 'admin.organizational-structures.*', 'admin.students.*'); @endphp
                <div>
                    <button class="nav-link-custom w-full" onclick="toggleSubmenu('menu-akademik', this)" aria-expanded="{{ $activeAkad ? 'true' : 'false' }}">
                        <i class="fa-solid fa-graduation-cap icon-main"></i>
                        <span class="flex-1 text-left">Akademik</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div id="menu-akademik" class="submenu-wrapper {{ $activeAkad ? 'open' : '' }}">
                        <a href="{{ route('admin.lecturers.index') }}" class="submenu-link {{ request()->routeIs('admin.lecturers.*') ? 'active' : '' }}">Data Dosen</a>
                        <a href="{{ route('admin.students.index') }}" class="submenu-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">Data Mahasiswa</a>
                        <a href="{{ route('admin.students.import-form') }}" class="submenu-link {{ request()->routeIs('admin.students.import-form') ? 'active' : '' }}">Import Mahasiswa</a>
                        <a href="{{ route('admin.profiles.index') }}" class="submenu-link {{ request()->routeIs('admin.profiles.*') ? 'active' : '' }}">Profil Fakultas</a>
                        <a href="{{ route('admin.organizational-structures.index') }}" class="submenu-link {{ request()->routeIs('admin.organizational-structures.*') ? 'active' : '' }}">Struktur Organisasi</a>
                        <a href="{{ route('admin.accreditations.index') }}" class="submenu-link {{ request()->routeIs('admin.accreditations.*') ? 'active' : '' }}">Akreditasi</a>
                        <a href="{{ route('admin.events.index') }}" class="submenu-link {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">Event / Agenda</a>
                        <a href="{{ route('admin.journals.index') }}" class="submenu-link {{ request()->routeIs('admin.journals.*') ? 'active' : '' }}">Jurnal Ilmiah</a>
                        <a href="{{ route('admin.academic-files.index') }}" class="submenu-link {{ request()->routeIs('admin.academic-files.*') ? 'active' : '' }}">File Akademik</a>
                    </div>
                </div>

                <div class="nav-section-title">Media & Assets</div>

                @php $activeMedia = request()->routeIs('admin.facilities.*', 'admin.albums.*', 'admin.documents.*', 'admin.hero-sliders.*', 'admin.stats.*', 'admin.settings.*'); @endphp
                <div>
                    <button class="nav-link-custom w-full" onclick="toggleSubmenu('menu-media', this)" aria-expanded="{{ $activeMedia ? 'true' : 'false' }}">
                        <i class="fa-solid fa-images icon-main"></i>
                        <span class="flex-1 text-left">Media & Sarana</span>
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div id="menu-media" class="submenu-wrapper {{ $activeMedia ? 'open' : '' }}">
                        <a href="{{ route('admin.facilities.index') }}" class="submenu-link {{ request()->routeIs('admin.facilities.*') ? 'active' : '' }}">Fasilitas</a>
                        <a href="{{ route('admin.albums.index') }}" class="submenu-link {{ request()->routeIs('admin.albums.*') ? 'active' : '' }}">Galeri Album</a>
                        <a href="{{ route('admin.documents.index') }}" class="submenu-link {{ request()->routeIs('admin.documents.*') ? 'active' : '' }}">Dokumen</a>
                        <a href="{{ route('admin.hero-sliders.index') }}" class="submenu-link {{ request()->routeIs('admin.hero-sliders.*') ? 'active' : '' }}">Banner Slider</a>
                        <a href="{{ route('admin.stats.index') }}" class="submenu-link {{ request()->routeIs('admin.stats.*') ? 'active' : '' }}">Statistik</a>
                        <a href="{{ route('admin.settings.index') }}" class="submenu-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">Setting</a>
                    </div>
                </div>

                <div class="nav-section-title">System & Admin</div>
                
                @php $activeSurat = request()->routeIs('admin.letter-*'); @endphp
                <div>
                    <button class="nav-link-custom w-full" onclick="toggleSubmenu('menu-surat', this)" aria-expanded="{{ $activeSurat ? 'true' : 'false' }}">
                        <i class="fa-solid fa-envelope-open-text icon-main"></i>
                        <span class="flex-1 text-left">Layanan Surat</span>
                         @if(isset($pendingSubmissions) && $pendingSubmissions > 0)
                             <span class="bg-blue-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full ml-2 shadow-sm">{{ $pendingSubmissions }}</span>
                        @endif
                        <i class="fa-solid fa-chevron-down chevron"></i>
                    </button>
                    <div id="menu-surat" class="submenu-wrapper {{ $activeSurat ? 'open' : '' }}">
                        <a href="{{ route('admin.letter-templates.index') }}" class="submenu-link {{ request()->routeIs('admin.letter-templates.*') ? 'active' : '' }}">Template Surat</a>
                        <a href="{{ route('admin.letter-submissions.index') }}" class="submenu-link {{ request()->routeIs('admin.letter-submissions.*') ? 'active' : '' }}">Permohonan Surat</a>
                    </div>
                </div>

                <a href="{{ route('admin.users.index') }}" class="nav-link-custom {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users-gear icon-main"></i>
                    <span>Manajemen User</span>
                </a>

            </nav>

            <div class="p-4 bg-slate-950 border-t border-white/5">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="flex items-center gap-3 w-full text-slate-400 hover:text-red-400 hover:bg-white/5 transition-all px-4 py-2.5 rounded-md group">
                        <i class="fa-solid fa-right-from-bracket group-hover:translate-x-1 transition-transform"></i>
                        <span class="text-sm font-medium">Log Out</span>
                    </button>
                </form>
            </div>
        </aside>


        <div class="content-wrapper flex flex-col min-h-screen transition-all duration-300">
            
            <header class="header-main sticky top-0 z-30 flex items-center justify-between px-4 md:px-8 shadow-sm">
                <div class="flex items-center gap-4">
                    <button onclick="openSidebar()" class="md:hidden text-slate-500 hover:text-slate-800 p-1">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <h2 class="text-slate-800 font-semibold text-lg hidden md:block tracking-tight">@yield('page-title', 'Dashboard')</h2>
                </div>

                <div class="flex items-center gap-5">
                     <a href="{{ route('home') }}" target="_blank" class="text-slate-500 hover:text-blue-600 transition-colors flex items-center gap-2 text-sm font-medium" title="Lihat Website">
                        <span class="hidden sm:inline">Lihat Web</span>
                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    </a>
                    
                    <div class="h-6 w-[1px] bg-slate-200"></div>
                    
                    <div class="flex items-center gap-3">
                        <div class="text-right hidden sm:block">
                            <div class="text-sm font-bold text-slate-700 leading-none">{{ auth()->user()->name }}</div>
                            <div class="text-[11px] text-slate-500 mt-1">Administrator</div>
                        </div>
                        <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 flex items-center justify-center text-slate-500 shadow-sm overflow-hidden">
                             <i class="fa-solid fa-user text-lg"></i>
                        </div>
                    </div>
                </div>
            </header>

            <main class="p-4 md:p-8 flex-1">
                @if(session('success'))
                    <div class="alert alert-success border-0 shadow-sm mb-6 flex items-center gap-3 bg-emerald-50 text-emerald-800 border-s-4 border-emerald-500 rounded-e-lg px-4 py-3">
                         <i class="fa-solid fa-circle-check text-xl"></i> 
                         <span class="font-medium">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger border-0 shadow-sm mb-6 flex items-center gap-3 bg-red-50 text-red-800 border-s-4 border-red-500 rounded-e-lg px-4 py-3">
                         <i class="fa-solid fa-circle-exclamation text-xl"></i>
                         <span class="font-medium">{{ session('error') }}</span>
                    </div>
                @endif

                @yield('content')
            </main>

            <footer class="mt-auto py-6 text-center text-slate-400 text-xs border-t border-slate-200 bg-white">
                <div class="container mx-auto">
                    &copy; {{ date('Y') }} <strong class="text-slate-600">FEB UNSAP</strong>. 
                </div>
            </footer>

        </div>
    </div>

    <script>
        const sidebar = document.getElementById('admin-sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        function openSidebar() {
            sidebar.classList.remove('-translate-x-full');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.remove('opacity-0'), 10); // Fade in effect
        }

        function closeSidebar() {
            sidebar.classList.add('-translate-x-full');
            overlay.classList.add('opacity-0');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }

        function toggleSubmenu(id, button) {
            const submenu = document.getElementById(id);
            const isExpanded = button.getAttribute('aria-expanded') === 'true';
            
            // Close other submenus (Optional - Uncomment jika ingin mode accordion ketat)
            /* document.querySelectorAll('.submenu-wrapper').forEach(el => {
                if (el.id !== id) el.classList.remove('open');
            });
            document.querySelectorAll('.nav-link-custom[aria-expanded="true"]').forEach(el => {
                if (el !== button) el.setAttribute('aria-expanded', 'false');
            }); 
            */

            if (isExpanded) {
                submenu.classList.remove('open');
                button.setAttribute('aria-expanded', 'false');
            } else {
                submenu.classList.add('open');
                button.setAttribute('aria-expanded', 'true');
            }
        }
    </script>
    
    @stack('scripts')
</body>
</html>