<section class="relative overflow-hidden">
    <div class="swiper heroSwiper">
        <div class="swiper-wrapper">
            @forelse($heroSliders as $index => $slider)
                <div class="swiper-slide">
                    <div class="hero-slide-container">
                        <!-- Background Layer -->
                        @if($slider->media_type === 'image' && $slider->media_path)
                            <!-- IMAGE -->
                            <div class="hero-background">
                                <img src="{{ asset('storage/' . $slider->media_path) }}" 
                                     alt="{{ $slider->title }}"
                                     class="hero-bg-image">
                                <div class="hero-overlay"></div>
                            </div>

                        @elseif($slider->media_type === 'video')
                            @if($slider->video_platform === 'upload' && $slider->video_file)
                                <!-- UPLOADED VIDEO -->
                                <div class="hero-background">
                                    <!-- Loading Black Background -->
                                    <div class="video-loading-bg"></div>
                                    <video class="hero-bg-video"
                                           autoplay 
                                           muted 
                                           loop 
                                           playsinline
                                           preload="auto">
                                        <source src="{{ asset('storage/' . $slider->video_file) }}" type="video/mp4">
                                    </video>
                                    <div class="hero-overlay"></div>
                                </div>

                            @elseif($slider->video_platform === 'youtube' && $slider->getYouTubeVideoId())
                                <!-- YOUTUBE VIDEO -->
                                <div class="hero-background">
                                    <!-- Loading Black Background -->
                                    <div class="video-loading-bg"></div>
                                    <div class="youtube-player-wrapper">
                                        <div id="player-{{ $index }}" 
                                             class="youtube-player"
                                             data-video-id="{{ $slider->getYouTubeVideoId() }}"
                                             data-player-id="player-{{ $index }}">
                                        </div>
                                    </div>
                                    <div class="hero-overlay"></div>
                                </div>

                            @elseif($slider->video_platform === 'vimeo' && $slider->getVimeoVideoId())
                               <div class="hero-background">
    <div class="video-loading-bg"></div>
    
    <div class="vimeo-wrapper">
        <iframe src="https://player.vimeo.com/video/{{ $slider->getVimeoVideoId() }}?background=1&autoplay=1&loop=1&muted=1&byline=0&title=0"
                frameborder="0"
                allow="autoplay; fullscreen"
                webkitallowfullscreen mozallowfullscreen allowfullscreen>
        </iframe>
    </div>
    
    <div class="hero-overlay"></div>
</div>

@elseif($slider->video_platform === 'wistia')
    @php
        // Logic pembersih ID (Tetap dipertahankan karena sudah berhasil)
        $wistiaId = $slider->video_embed;
        if (strpos($wistiaId, '/medias/') !== false) {
            $parts = explode('/medias/', $wistiaId);
            $wistiaId = end($parts);
        }
        $wistiaId = trim($wistiaId);
    @endphp

    <div class="hero-background" style="background-color: #000;">
        <div class="wistia-wrapper">
            <iframe src="https://fast.wistia.net/embed/iframe/{{ $wistiaId }}?seo=false&videoFoam=false&autoPlay=true&muted=true&loop=true&controlsVisibleOnLoad=false&playbar=false&fullscreenButton=false&smallPlayButton=false&volumeControl=false&endVideoBehavior=loop"
                    title="Wistia video player"
                    allow="autoplay; fullscreen"
                    allowtransparency="true"
                    frameborder="0"
                    scrolling="no"
                    name="wistia_embed"
                    width="100%" 
                    height="100%">
            </iframe>
        </div>
        <div class="hero-overlay"></div>
    </div>
                            @else
                                <!-- FALLBACK -->
                                <div class="hero-background">
                                    <div class="hero-bg-gradient"></div>
                                </div>
                            @endif
                        @else
                            <!-- FALLBACK -->
                            <div class="hero-background">
                                <div class="hero-bg-gradient"></div>
                            </div>
                        @endif

                        <!-- Content Layer - CENTER BOTTOM ALIGNMENT -->
                        <div class="hero-content">
                            <div class="hero-text-container">
                                <!-- TITLE: Nama Universitas - Font Besar & Tegas -->
                                <h1 class="hero-title">
                                    {!! nl2br(e($slider->title)) !!}
                                </h1>
                                
                                <!-- SUBTITLE: Nama Fakultas - Font Small Regular -->
                                @if($slider->subtitle)
                                    <p class="hero-subtitle">
                                        {{ $slider->subtitle }}
                                    </p>
                                @endif

                                <!-- TAGLINE: Deskripsi - Font Small Regular -->
                                @if($slider->tagline)
                                    <p class="hero-tagline">
                                        {{ $slider->tagline }}
                                    </p>
                                @endif

                                @if($slider->button_text && $slider->button_link)
                                    <a href="{{ $slider->button_link }}" class="hero-button">
                                        {{ $slider->button_text }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Scroll Down Indicator -->
                        <div class="scroll-down-indicator">
                            <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2">
                                <path d="M12 5v14M19 12l-7 7-7-7"/>
                            </svg>
                        </div>
                    </div>
                </div>
            @empty
                <!-- Fallback -->
                <div class="swiper-slide">
                    <div class="hero-slide-container">
                        <div class="hero-background">
                            <div class="hero-bg-gradient"></div>
                        </div>
                        <div class="hero-content">
                            <div class="hero-text-container">
                                <h1 class="hero-title">
                                    UNIVERSITAS SEBELAS APRIL
                                </h1>
                                <p class="hero-subtitle">
                                    FAKULTAS EKONOMI DAN BISNIS
                                </p>
                                <p class="hero-tagline">
                                    Shaping Future Leaders in Business & Economics
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        
        @if($heroSliders->count() > 1)
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
            <div class="swiper-pagination"></div>
        @endif
    </div>

    <!-- Wave SVG -->
    <div class="hero-wave">
        <svg viewBox="0 0 1200 120" preserveAspectRatio="none">
            <path d="M0,0 L600,80 L1200,0 L1200,120 L0,120 Z" fill="white"></path>
        </svg>
    </div>
</section>

<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">

<!-- Google Fonts - Montserrat (Similar to Telkom) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

<style>
/* Hero Container */
.hero-slide-container {
    position: relative;
    width: 100%;
    height: 100vh;
    overflow: hidden;
}

.wistia-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    
    /* Ukuran Paksa Full Screen */
    width: 100vw; 
    height: 56.25vw; /* Rasio 16:9 */
    
    /* Agar tidak ada bar hitam */
    min-height: 100vh;
    min-width: 177.77vh;
    
    pointer-events: none;
    z-index: 1;
    background: #000; /* Hitam pekat lebih baik daripada abu-abu */
}

.wistia-wrapper iframe {
    width: 100%;
    height: 100%;
    /* Pastikan iframe mengisi wrapper */
    position: absolute; 
    top: 0;
    left: 0;
}

/* Wrapper Khusus Vimeo agar Full Screen (Cover) */
.vimeo-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    
    /* Logika ZOOM: Memastikan rasio 16:9 selalu menutupi layar */
    width: 100vw; 
    height: 56.25vw; /* 100 * 9 / 16 = 56.25 */
    
    /* Jika layar terlalu tinggi (potrait), paksa tinggi minimal */
    min-height: 100vh;
    min-width: 177.77vh; /* 100 * 16 / 9 = 177.77 */
    
    pointer-events: none; /* Agar user tidak bisa klik video */
    z-index: 1;
}

.vimeo-wrapper iframe {
    width: 100%;
    height: 100%;
}
/* Background Layer */
.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
    background: #000;
}

/* Video Loading Background */
.video-loading-bg {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #000;
    z-index: 1;
    animation: fadeOutLoading 0.5s ease-out 1s forwards;
}

@keyframes fadeOutLoading {
    to {
        opacity: 0;
        visibility: hidden;
    }
}

.hero-bg-image,
.hero-bg-video {
    position: absolute;
    top: 50%;
    left: 50%;
    min-width: 100%;
    min-height: 100%;
    width: auto;
    height: auto;
    transform: translate(-50%, -50%);
    object-fit: cover;
    z-index: 2;
}

.hero-bg-gradient {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);
}

.hero-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.45);
    z-index: 3;
}

/* YouTube Player Wrapper */
.youtube-player-wrapper {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 100vw;
    height: 56.25vw;
    min-height: 100vh;
    min-width: 177.77vh;
    transform: translate(-50%, -50%);
    z-index: 2;
}

.youtube-player {
    width: 100%;
    height: 100%;
}

/* Content Layer - CENTER BOTTOM ALIGNMENT */
.hero-content {
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 100%;
    max-width: 1200px;
    padding: 0 2rem;
    padding-bottom: 140px;
    z-index: 10;
}

.hero-text-container {
    width: 100%;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

/* Typography - Telkom Style */

/* TITLE - Like "TELKOM UNIVERSITY" */
.hero-title {
    font-family: 'Montserrat', sans-serif;
    font-size: 2.75rem;
    font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.7);
    animation: fadeInUp 0.8s ease-out;
}

/* SUBTITLE - Like "BEST PRIVATE UNIVERSITY" */
.hero-subtitle {
    font-family: 'Montserrat', sans-serif;
    font-size: 1rem;
   font-weight: 800;
    color: white;
    line-height: 1.2;
    margin-bottom: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 2px;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.7);
    animation: fadeInUp 0.8s ease-out;
}

/* TAGLINE - Like "National Excellence..." */
.hero-tagline {
    font-family: 'Montserrat', sans-serif;
    font-size: 1.125rem;
    font-weight: 400;
    font-style: normal;
    color: rgba(255, 255, 255, 0.95);
    line-height: 1.6;
    margin-bottom: 1.75rem;
    letter-spacing: 0.3px;
    text-shadow: 2px 2px 6px rgba(0,0,0,0.6);
    animation: fadeInUp 0.8s ease-out 0.4s backwards;
}

/* Button - Orange/Red Style */
.hero-button {
    display: inline-block;
    background: linear-gradient(135deg, #ff6b35 0%, #f7931e 100%);
    color: white;
    padding: 0.65rem 2rem;
    border-radius: 25px;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    font-size: 0.875rem;
    text-decoration: none;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
    animation: fadeInUp 0.8s ease-out 0.6s backwards;
}

.hero-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 107, 53, 0.6);
    background: linear-gradient(135deg, #f7931e 0%, #ff6b35 100%);
}

/* Scroll Down Indicator */
.scroll-down-indicator {
    position: absolute;
    bottom: 40px;
    left: 50%;
    transform: translateX(-50%);
    z-index: 20;
    animation: bounce 2s infinite;
}

@keyframes bounce {
    0%, 20%, 50%, 80%, 100% {
        transform: translateX(-50%) translateY(0);
    }
    40% {
        transform: translateX(-50%) translateY(-10px);
    }
    60% {
        transform: translateX(-50%) translateY(-5px);
    }
}

/* Wave */
.hero-wave {
    position: absolute;
    bottom: 0;
    left: 0;
    width: 100%;
    z-index: 20;
    line-height: 0;
}

.hero-wave svg {
    display: block;
    width: 100%;
    height: 80px;
}

/* Swiper */
.heroSwiper {
    width: 100%;
    height: 100vh;
}

.swiper-button-next,
.swiper-button-prev {
    color: white;
    background: rgba(0,0,0,0.4);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    backdrop-filter: blur(10px);
}

.swiper-button-next:after,
.swiper-button-prev:after {
    font-size: 20px;
    font-weight: bold;
}

.swiper-button-next:hover,
.swiper-button-prev:hover {
    background: rgba(0,0,0,0.6);
}

.swiper-pagination-bullet {
    background: white;
    opacity: 0.6;
    width: 12px;
    height: 12px;
}

.swiper-pagination-bullet-active {
    opacity: 1;
    background: white;
}

/* Animation */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive */
@media (max-width: 1024px) {
    .hero-title {
        font-size: 3rem;
        letter-spacing: 1.5px;
    }
    
    .hero-subtitle {
        font-size: 0.9rem;
    }
    
    .hero-tagline {
        font-size: 1rem;
    }

    .hero-content {
        padding-bottom: 120px;
    }
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.25rem;
        letter-spacing: 1px;
    }
    
    .hero-subtitle {
        font-size: 0.875rem;
    }
    
    .hero-tagline {
        font-size: 0.9rem;
    }
    
    .hero-button {
        padding: 0.6rem 1.75rem;
        font-size: 0.8rem;
    }

    .hero-content {
        padding-bottom: 100px;
    }

    .swiper-button-next,
    .swiper-button-prev {
        width: 40px;
        height: 40px;
    }

    .swiper-button-next:after,
    .swiper-button-prev:after {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.75rem;
        letter-spacing: 0.5px;
    }
    
    .hero-subtitle {
        font-size: 0.8rem;
    }
    
    .hero-tagline {
        font-size: 0.85rem;
    }

    .hero-content {
        padding-bottom: 80px;
    }
    
    .hero-button {
        padding: 0.5rem 1.5rem;
        font-size: 0.75rem;
    }
}
</style>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<!-- YouTube API -->
<script src="https://www.youtube.com/iframe_api"></script>

<script>
// YouTube Players
let YTPlayers = {};
let YTReady = false;

// YouTube API callback
window.onYouTubeIframeAPIReady = function() {
    console.log('YouTube API Ready');
    YTReady = true;
    initAllYouTubePlayers();
};

function initAllYouTubePlayers() {
    document.querySelectorAll('.youtube-player').forEach(element => {
        const videoId = element.dataset.videoId;
        const playerId = element.dataset.playerId;
        
        if (videoId && playerId) {
            try {
                YTPlayers[playerId] = new YT.Player(playerId, {
                    videoId: videoId,
                    playerVars: {
                        autoplay: 1,
                        mute: 1,
                        controls: 0,
                        showinfo: 0,
                        modestbranding: 1,
                        loop: 1,
                        playlist: videoId,
                        rel: 0,
                        playsinline: 1,
                        enablejsapi: 1,
                        origin: window.location.origin
                    },
                    events: {
                        onReady: function(event) {
                            console.log('YouTube player ready:', playerId);
                            event.target.mute();
                            event.target.playVideo();
                            
                            const loadingBg = event.target.getIframe().closest('.hero-background').querySelector('.video-loading-bg');
                            if (loadingBg) {
                                setTimeout(() => {
                                    loadingBg.style.opacity = '0';
                                    setTimeout(() => loadingBg.remove(), 300);
                                }, 500);
                            }
                        },
                        onStateChange: function(event) {
                            if (event.data === YT.PlayerState.ENDED) {
                                event.target.playVideo();
                            }
                            if (event.data === YT.PlayerState.PLAYING) {
                                const loadingBg = event.target.getIframe().closest('.hero-background').querySelector('.video-loading-bg');
                                if (loadingBg) {
                                    loadingBg.style.opacity = '0';
                                    setTimeout(() => loadingBg.remove(), 300);
                                }
                            }
                        },
                        onError: function(event) {
                            console.error('YouTube player error:', event.data);
                        }
                    }
                });
            } catch (error) {
                console.error('Error creating YouTube player:', error);
            }
        }
    });
}

// Initialize when API loads
if (typeof YT !== 'undefined' && YT.loaded) {
    YTReady = true;
    initAllYouTubePlayers();
}

// Swiper initialization with video cache
const swiper = new Swiper('.heroSwiper', {
    loop: {{ $heroSliders->count() > 1 ? 'true' : 'false' }},
    autoplay: {
        delay: 7000, // 7 detik per slide
        disableOnInteraction: false,
    },
    speed: 1000,
    effect: 'fade',
    fadeEffect: {
        crossFade: true
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    on: {
        init: function() {
            console.log('Swiper initialized');
            setTimeout(() => {
                const activeSlide = this.slides[this.activeIndex];
                const video = activeSlide?.querySelector('video');
                if (video) {
                    video.load();
                    video.play().then(() => {
                        const loadingBg = video.closest('.hero-background').querySelector('.video-loading-bg');
                        if (loadingBg) {
                            loadingBg.style.opacity = '0';
                            setTimeout(() => loadingBg.remove(), 300);
                        }
                    }).catch(e => console.log('Video play:', e));
                }
            }, 100);
        },
        slideChangeTransitionStart: function() {
            // Pause non-active YouTube videos smoothly
            const slides = this.slides;
            slides.forEach((slide, index) => {
                if (index !== this.activeIndex) {
                    const ytPlayer = slide.querySelector('.youtube-player');
                    if (ytPlayer && YTPlayers[ytPlayer.dataset.playerId]) {
                        try {
                            YTPlayers[ytPlayer.dataset.playerId].pauseVideo();
                        } catch(e) {}
                    }
                }
            });
        },
        slideChangeTransitionEnd: function() {
            // Resume YouTube video from cache (not from start)
            const activeSlide = this.slides[this.activeIndex];
            const ytPlayer = activeSlide?.querySelector('.youtube-player');
            if (ytPlayer && YTPlayers[ytPlayer.dataset.playerId]) {
                try {
                    // Don't seekTo(0), just play to resume from cache
                    YTPlayers[ytPlayer.dataset.playerId].playVideo();
                } catch(e) {}
            }
            
            // Resume HTML5 video
            const video = activeSlide?.querySelector('video');
            if (video && video.paused) {
                video.play().catch(e => console.log('Video play:', e));
            }
        }
    }
});

// HTML5 video setup with cache
document.querySelectorAll('video').forEach(video => {
    video.load();
    
    video.addEventListener('loadeddata', function() {
        const loadingBg = this.closest('.hero-background').querySelector('.video-loading-bg');
        if (loadingBg) {
            loadingBg.style.opacity = '0';
            setTimeout(() => loadingBg.remove(), 300);
        }
    });
    
    video.addEventListener('ended', function() {
        this.currentTime = 0;
        this.play();
    });
    
    video.addEventListener('canplay', function() {
        if (this.closest('.swiper-slide-active')) {
            this.play().catch(e => console.log('Autoplay blocked:', e));
        }
    });
});

console.log('Hero slider loaded - Telkom style with video cache');
</script>
<script src="https://fast.wistia.com/assets/external/E-v1.js" async></script>