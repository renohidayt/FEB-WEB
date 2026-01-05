<aside id="admin-sidebar" class="w-64 bg-white border-r min-h-screen fixed z-40 transform transition-transform duration-300 -translate-x-full md:translate-x-0 flex flex-col">
    <!-- Sidebar Header -->
    <div class="p-4 border-b flex items-center justify-between bg-white flex-shrink-0 sticky top-0 z-10">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3">
            <img src="{{ asset('favicon.png') }}" alt="logo" class="w-8 h-8">
            <span class="font-bold text-sm">{{ config('app.name') }}</span>
        </a>
        <button id="sidebar-close" class="md:hidden p-1 rounded hover:bg-gray-100">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <!-- Scrollable Navigation -->
    <nav class="p-4 overflow-y-auto flex-1 sidebar-scroll">
        <ul class="space-y-1">
            <!-- Dashboard -->
            @include('admin.partials.menu-item', [
                'route' => 'admin.dashboard',
                'icon' => 'fas fa-home',
                'label' => 'Dashboard',
                'routeMatch' => 'admin.dashboard'
            ])

            <!-- Content Management Section -->
            @include('admin.partials.menu-section', ['title' => 'Content'])

            @include('admin.partials.menu-item', [
                'route' => 'admin.news.index',
                'icon' => 'fas fa-newspaper',
                'label' => 'Berita',
                'routeMatch' => 'admin.news.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.categories.index',
                'icon' => 'fas fa-tags',
                'label' => 'Kategori',
                'routeMatch' => 'admin.categories.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.scholarships.index',
                'icon' => 'fas fa-graduation-cap',
                'label' => 'Beasiswa',
                'routeMatch' => 'admin.scholarships.*'
            ])

            <!-- Academic Section -->
            @include('admin.partials.menu-section', ['title' => 'Academic'])

            @include('admin.partials.menu-item', [
                'route' => 'admin.lecturers.index',
                'icon' => 'fas fa-chalkboard-teacher',
                'label' => 'Dosen',
                'routeMatch' => 'admin.lecturers.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.organizational-structures.index',
                'icon' => 'fas fa-sitemap',
                'label' => 'Struktur Organisasi',
                'routeMatch' => 'admin.organizational-structures.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.profiles.index',
                'icon' => 'fas fa-user-circle',
                'label' => 'Profil',
                'routeMatch' => 'admin.profiles.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.accreditations.index',
                'icon' => 'fas fa-certificate',
                'label' => 'Akreditasi',
                'routeMatch' => 'admin.accreditations.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.events.index',
                'icon' => 'fas fa-calendar-alt',
                'label' => 'Events',
                'routeMatch' => 'admin.events.*'
            ])

            <!-- Facilities Section -->
            @include('admin.partials.menu-section', ['title' => 'Facilities'])

            @include('admin.partials.menu-item', [
                'route' => 'admin.facilities.index',
                'icon' => 'fas fa-building',
                'label' => 'Fasilitas',
                'routeMatch' => 'admin.facilities.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.albums.index',
                'icon' => 'fas fa-images',
                'label' => 'Album',
                'routeMatch' => 'admin.albums.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.documents.index',
                'icon' => 'fas fa-file-alt',
                'label' => 'Dokumen',
                'routeMatch' => 'admin.documents.*'
            ])

            <!-- Letter Management Section -->
            @include('admin.partials.menu-section', ['title' => 'Letter Management'])

            @include('admin.partials.menu-item', [
                'route' => 'admin.letter-templates.index',
                'icon' => 'fas fa-file-invoice',
                'label' => 'Template Surat',
                'routeMatch' => 'admin.letter-templates.*'
            ])

            @include('admin.partials.menu-item', [
                'route' => 'admin.letter-submissions.index',
                'icon' => 'fas fa-envelope',
                'label' => 'Pengajuan Surat',
                'routeMatch' => 'admin.letter-submissions.*',
                'badge' => $pendingSubmissions ?? 0
            ])
        </ul>
    </nav>
</aside>