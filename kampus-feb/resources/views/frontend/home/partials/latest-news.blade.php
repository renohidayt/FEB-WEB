@if($featured_news && $featured_news->count() > 0)
<section class="py-16" style="font-family: 'Poppins', sans-serif; background-color: #090722;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row space-y-10 lg:space-y-0 lg:space-x-12">

        <!-- LEFT SIDE -->
        <div class="lg:w-1/3 flex-shrink-0">

            <h2 class="text-5xl font-extrabold text-white uppercase mb-4 leading-tight">
                BERITA<br>TERKINI
            </h2>

            <div class="w-20 h-1 bg-gradient-to-r from-[#C91818] to-[#FFCC00] mb-6"></div>

            <p class="text-lg text-gray-300 mb-8">
                Ikuti perkembangan berita dan pembaruan terbaru.
            </p>

            <a href="{{ route('news.index') }}" 
               class="inline-flex items-center text-lg font-semibold text-orange-500 hover:text-gray-100 transition duration-300">
                Lainnya <span class="ml-2">→</span>
            </a>

            <!-- SLIDER BUTTONS -->
            <div class="mt-20 flex space-x-4 relative z-50">
                <!-- Left -->
                <button id="news-left" class="text-gray-300 hover:text-white transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>

                <!-- Right -->
                <button id="news-right" class="text-white hover:text-gray-300 transition cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <div class="mt-4">
                <div class="w-32 h-1 bg-gray-600 relative overflow-hidden">
    <div id="news-progress" class="absolute left-0 top-0 h-full bg-gray-100 w-1/6"></div>
</div>

            </div>
        </div>

        <!-- RIGHT SIDE - SLIDER -->
        <div id="news-slider" class="lg:w-2/3 overflow-x-auto scrollbar-hide scroll-smooth">
            <div class="flex space-x-6 pb-2">
                @foreach($featured_news->take(8) as $news)
                    @include('frontend.home.partials.news-card', ['news' => $news])
                @endforeach
            </div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('#news-slider');
    const leftBtn = document.querySelector('#news-left');
    const rightBtn = document.querySelector('#news-right');
    const progress = document.querySelector('#news-progress');

    function updateProgress() {
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        const percentage = slider.scrollLeft / maxScroll; 
        progress.style.width = `${percentage * 100}%`;
    }

    // geser kiri
    leftBtn.addEventListener('click', () => {
        slider.scrollBy({ left: -300, behavior: 'smooth' });
        setTimeout(updateProgress, 350);
    });

    // geser kanan
    rightBtn.addEventListener('click', () => {
        slider.scrollBy({ left: 300, behavior: 'smooth' });
        setTimeout(updateProgress, 350);
    });

    // update progress saat scroll manual
    slider.addEventListener('scroll', updateProgress);

    // set awal
    updateProgress();
});
</script>


@endif
