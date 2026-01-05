{{-- resources/views/layouts/admin/navbar.blade.php --}}
<header class="bg-white border-b shadow-sm sticky top-0 z-20">
    <div class="max-w-7xl mx-auto px-4 lg:px-6 py-3 flex items-center justify-between">
        <!-- Left Section -->
        <div class="flex items-center gap-3">
            <!-- Hamburger Menu (Mobile) -->
            <button id="sidebar-toggle" class="md:hidden p-2 rounded-lg hover:bg-gray-100 transition-colors" aria-label="Toggle Sidebar">
                <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <!-- Page Title -->
            <div>
                <h1 class="font-bold text-lg md:text-xl text-gray-900">@yield('title', 'Dashboard')</h1>
                <p class="text-xs md:text-sm text-gray-500 hidden sm:block">@yield('subtitle', 'Selamat datang di panel admin')</p>
            </div>
        </div>

        <!-- Right Section -->
        <div class="flex items-center gap-2 md:gap-4">
            <!-- Notification Button -->
            <button class="p-2 rounded-lg hover:bg-gray-100 transition-colors relative" title="Notifikasi" aria-label="Notifications">
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <!-- Notification Badge -->
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            <!-- User Info & Logout -->
            <div class="flex items-center gap-3 pl-3 border-l border-gray-200">
                <!-- User Name (Desktop Only) -->
                <span class="text-sm text-gray-600 hidden md:inline font-medium">
                    {{ auth()->user()->name ?? 'Admin' }}
                </span>

                <!-- Logout Button -->
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="px-3 py-1.5 rounded-lg bg-red-600 text-white hover:bg-red-700 text-sm font-medium transition-colors flex items-center gap-2" title="Logout">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="hidden sm:inline">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>