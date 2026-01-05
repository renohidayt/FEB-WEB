<header class="bg-white shadow-sm sticky top-0 z-20">
    <div class="flex justify-between items-center px-4 md:px-6 py-4">
        <!-- Mobile Menu Toggle -->
        <button id="sidebar-toggle" class="md:hidden p-2 rounded hover:bg-gray-100 transition-colors">
            <i class="fas fa-bars text-xl"></i>
        </button>

        <!-- Page Title -->
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800">
            @yield('page-title', 'Dashboard')
        </h1>
        
        <!-- User Actions -->
        <div class="flex items-center gap-3 md:gap-4">
            <span class="text-sm text-gray-700 hidden md:inline font-medium">
                {{ auth()->user()->name }}
            </span>
            
            <a href="{{ route('home') }}" 
               class="text-blue-600 hover:text-blue-800 transition-colors" 
               target="_blank" 
               title="Lihat Website">
                <i class="fas fa-external-link-alt text-lg"></i>
            </a>
            
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" 
                        class="text-red-600 hover:text-red-800 transition-colors" 
                        title="Logout">
                    <i class="fas fa-sign-out-alt text-lg"></i>
                </button>
            </form>
        </div>
    </div>
</header>