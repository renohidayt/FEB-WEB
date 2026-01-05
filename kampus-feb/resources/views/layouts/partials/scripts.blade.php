<script>
    // Navbar Scroll Handler
    const navbar = document.getElementById('navbar');
    const mobileMenu = document.getElementById('mobile-menu');
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const socialIcons = document.getElementById('social-icons');
    const desktopMenu = document.getElementById('desktop-menu');

    // Update kondisi navbar berdasarkan scroll
    function updateNavbarState() {
        const scrolled = window.pageYOffset > 50;

        if (scrolled) {
            navbar.classList.add('navbar-scrolled');
            navbar.classList.remove('navbar-not-scrolled');
        } else {
            navbar.classList.add('navbar-not-scrolled');
            navbar.classList.remove('navbar-scrolled');
        }
    }

    // Jalankan pertama kali + setiap scroll
    window.addEventListener('load', updateNavbarState);
    window.addEventListener('scroll', updateNavbarState);

    // Mobile dropdown toggle
    document.querySelectorAll('.mobile-dropdown > button').forEach(button => {
        button.addEventListener('click', () => {
            const dropdown = button.nextElementSibling;
            const icon = button.querySelector('.fa-chevron-down');
            dropdown.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        });
    });

    // Open/Close mobile menu
    mobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
            mobileMenu.classList.add('hidden');
        }
    });

    // Alternative scroll handler (backup)
    document.addEventListener("DOMContentLoaded", function () {
        function handleScroll() {
            if (window.scrollY > 50) {
                navbar.classList.add("navbar-scrolled");
                navbar.classList.remove("navbar-not-scrolled");
            } else {
                navbar.classList.remove("navbar-scrolled");
                navbar.classList.add("navbar-not-scrolled");
            }
        }

        // Run saat pertama kali halaman dibuka
        handleScroll();

        // Run tiap scroll
        window.addEventListener("scroll", handleScroll);
    });
</script>