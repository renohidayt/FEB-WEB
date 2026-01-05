@if($lecturers && $lecturers->count() > 0)
<section class="py-20"
         style="background-color: #F8FAFC; font-family: 'Poppins', sans-serif;">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row-reverse 
                space-y-10 lg:space-y-0 lg:space-x-reverse lg:space-x-12">

        <!-- Bagian Judul -->
        <div class="lg:w-1/3 flex-shrink-0">
            <h2 class="text-5xl font-extrabold text-black uppercase mb-4 leading-tight">
                PROFILE<br>DOSEN
            </h2>

            <div class="w-20 h-1 bg-gradient-to-r from-[#C91818] to-[#FFCC00] mb-6"></div>

            <p class="text-lg text-gray-500 mb-8">
                Kenali lebih dekat para tenaga pendidik profesional kami.
            </p>

            <a href="{{ route('lecturers.index') }}" 
               class="inline-flex items-center text-lg font-semibold text-orange-500 hover:text-black transition duration-300">
                Lainnya <span class="ml-2">→</span>
            </a>

            <!-- Tombol Navigasi -->
            <div class="mt-16 flex space-x-4">
                <button id="lecturer-left" class="text-gray-500 hover:text-black transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                </button>

                <button id="lecturer-right" class="text-gray-500 hover:text-black transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </button>
            </div>

            <!-- Progress bar -->
            <div class="mt-4">
                <div class="w-32 h-1 bg-gray-300 relative overflow-hidden">
                    <div id="lecturer-progress" class="absolute left-0 top-0 h-full bg-gray-700 w-1/6"></div>
                </div>
            </div>
        </div>

        <!-- CARD SLIDER -->
        <div class="lg:w-2/3 overflow-x-auto scrollbar-hide" id="lecturer-slider">
            <div class="flex space-x-6 pb-2">
                @foreach($lecturers->take(6) as $lecturer)
                    @include('frontend.home.partials.lecturer-card', ['lecturer' => $lecturer])
                @endforeach
            </div>
        </div>

    </div>
</section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('#lecturer-slider');
    const leftBtn = document.querySelector('#lecturer-left');
    const rightBtn = document.querySelector('#lecturer-right');
    const progress = document.querySelector('#lecturer-progress');

    function updateProgress() {
        const maxScroll = slider.scrollWidth - slider.clientWidth;
        const percentage = slider.scrollLeft / maxScroll;
        progress.style.width = `${percentage * 100}%`;
    }

    leftBtn.addEventListener('click', () => {
        slider.scrollBy({ left: -280, behavior: 'smooth' });
        setTimeout(updateProgress, 350);
    });

    rightBtn.addEventListener('click', () => {
        slider.scrollBy({ left: 280, behavior: 'smooth' });
        setTimeout(updateProgress, 350);
    });

    slider.addEventListener('scroll', updateProgress);

    updateProgress();
});
</script>


<style>
    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
@endif
