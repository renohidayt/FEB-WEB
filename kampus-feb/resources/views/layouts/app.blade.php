<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

   
    
    <title>{{ config('app.name', 'FEB UNSAP') }} - @yield('title', 'Fakultas Ekonomi & Bisnis')</title>
    <!-- Favicon / Icon di tab browser -->
<link rel="icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">
<link rel="shortcut icon" href="{{ asset('assets/img/logo/logo.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @include('layouts.partials.styles')
    
    @stack('styles')

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-[#1a1a2e] antialiased">
    
    @stack('preloader') 

    @include('layouts.partials.navbar')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    @include('layouts.partials.scripts')
    
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Fix untuk Mobile Menu Button
            const mobileMenuBtn = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (mobileMenuBtn && mobileMenu) {
                mobileMenuBtn.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // 2. Fix untuk Close Modal (jika ada sisa script lama)
            window.closeModal = function(event) {
                const modal = document.getElementById('detailModal');
                if (modal) {
                    if (!event || event.target.id === 'detailModal') {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }
                }
            };
        });
    </script>
</body>
</html>