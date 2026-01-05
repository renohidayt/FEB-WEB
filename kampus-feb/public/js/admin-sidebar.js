// Admin Sidebar Toggle Script
(function() {
    'use strict';

    const sidebar = document.getElementById('admin-sidebar');
    const toggle = document.getElementById('sidebar-toggle');
    const closeBtn = document.getElementById('sidebar-close');
    const overlay = document.getElementById('sidebar-overlay');

    let touchStartX = 0;
    let touchEndX = 0;
    
    // Open Sidebar
    function openSidebar() {
        sidebar?.classList.remove('-translate-x-full');
        overlay?.classList.remove('hidden');
        document.body.classList.add('sidebar-open');
    }

    // Close Sidebar
    function closeSidebar() {
        sidebar?.classList.add('-translate-x-full');
        overlay?.classList.add('hidden');
        document.body.classList.remove('sidebar-open');
    }

    // Toggle Sidebar
    function toggleSidebar() {
        if (sidebar?.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }
    }

    // Event Listeners - Button Clicks
    toggle?.addEventListener('click', toggleSidebar);
    closeBtn?.addEventListener('click', closeSidebar);
    overlay?.addEventListener('click', closeSidebar);

    // Keyboard Support (ESC to close)
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && !sidebar?.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    });

    // Touch/Swipe Support for Mobile
    document.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    }, { passive: true });

    document.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    }, { passive: true });

    function handleSwipe() {
        const swipeThreshold = 75;
        const swipeDistance = touchEndX - touchStartX;

        // Swipe right to open (only from left edge)
        if (swipeDistance > swipeThreshold && touchStartX < 50 && window.innerWidth < 768) {
            openSidebar();
        }
        
        // Swipe left to close
        if (swipeDistance < -swipeThreshold && !sidebar?.classList.contains('-translate-x-full')) {
            closeSidebar();
        }
    }

    // Auto-close sidebar on navigation click (mobile only)
    const sidebarLinks = sidebar?.querySelectorAll('a') || [];
    sidebarLinks.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth < 768) {
                setTimeout(closeSidebar, 150);
            }
        });
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth >= 768) {
                // Desktop: ensure body scroll is enabled
                document.body.classList.remove('sidebar-open');
                overlay?.classList.add('hidden');
            } else {
                // Mobile: close sidebar if open
                if (!sidebar?.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            }
        }, 250);
    });

    // Prevent scroll on body when sidebar is open (mobile)
    const mediaQuery = window.matchMedia('(max-width: 768px)');
    function handleMediaChange(e) {
        if (!e.matches) {
            // Desktop view - remove mobile restrictions
            document.body.classList.remove('sidebar-open');
            overlay?.classList.add('hidden');
        }
    }
    
    mediaQuery.addEventListener('change', handleMediaChange);

})();