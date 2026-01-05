<style>
    /* Social Icons & Menu Animation */
    .navbar-scrolled #social-icons {
        opacity: 1;
        pointer-events: auto;
        transform: translateX(0);
    }

    .navbar-scrolled #desktop-menu {
        margin-left: 0;
    }

    /* Kondisi default: sebelum scroll */
    .navbar-not-scrolled #social-icons {
        opacity: 0;
        pointer-events: none;
        transform: translateX(20px);
    }

    .navbar-not-scrolled #desktop-menu {
    padding-left: 270px;
        flex-wrap: nowrap;
    white-space: nowrap;
}


    /* Dropdown Styles */
  
    
   
    
    /* Smooth transitions for navbar */
    nav {
        transition: all 0.3s ease-in-out;
    }
    
    .logo-container {
        transition: all 0.3s ease-in-out;
    }
    
    .logo-container img {
        transition: all 0.3s ease-in-out;
    }
    
    .logo-text {
        transition: opacity 0.3s ease-in-out, max-width 0.3s ease-in-out, transform 0.3s ease-in-out;
        max-width: 300px;
        overflow: hidden;
    }
    
    /* Navbar scrolled state */
    .navbar-scrolled {
        height: 60px !important;
    }

    .navbar-scrolled .navbar-inner {
        height: 60px !important;
    }

    .navbar-scrolled .logo-container img {
        height: 2.5rem !important;
        width: 2.5rem !important;
    }

    /* Sembunyikan teks logo HANYA di desktop (md ke atas) */
    @media (min-width: 768px) {
        .navbar-scrolled .logo-text {
            opacity: 0;
            max-width: 0;
        }
    }

    /* Kecilkan teks logo di mobile saat scroll */
    @media (max-width: 767px) {
        .navbar-scrolled .logo-text {
            transform: scale(0.65);
            transform-origin: left center;
        }
    }
    
    /* Line Clamp Utilities */
    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>

