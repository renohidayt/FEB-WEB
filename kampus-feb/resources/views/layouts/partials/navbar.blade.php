<nav id="navbar" class="navbar-not-scrolled bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="navbar-inner flex justify-between items-center h-20">
            <!-- Left Section: Logo + Menu Fitur -->
            <div class="flex items-center space-x-4">
                <!-- Logo -->
                @include('layouts.partials.logo')
                
                <!-- Desktop Navigation -->
                <div id="desktop-menu" class="hidden xl:flex items-center space-x-1 transition-all duration-300">
                    @include('layouts.partials.desktop-menu')
                </div>
            </div>

            <!-- Right Section: Social Media Icons + Mobile Menu Button -->
            <div class="flex items-center space-x-4">
                <!-- Social Media Icons -->
                @include('layouts.partials.social-icons')

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" type="button" class="xl:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-orange-600 focus:outline-none transition-colors">
    <i class="fas fa-bars text-2xl"></i>
</button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation -->
    @include('layouts.partials.mobile-menu')
</nav>