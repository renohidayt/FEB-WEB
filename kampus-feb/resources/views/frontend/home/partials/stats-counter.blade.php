{{-- Stats Counter Section - Sleek & Compact Horizontal (Mobile Responsive Revised) --}}
@php
    $stats = \App\Models\Stat::active()->ordered()->get();
@endphp

@if($stats->count() > 0)
<section class="py-12 lg:py-10 bg-[#090722] relative overflow-hidden stats-counter-section">

    {{-- Subtle Decorative Line --}}
    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-orange-500/50 to-transparent"></div>
    <div class="absolute bottom-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-orange-500/50 to-transparent"></div>

    <div class="container mx-auto px-6 max-w-6xl">
        <div class="flex flex-col lg:flex-row items-center lg:justify-between">
            
            {{-- Title Area --}}
            {{-- Mobile: Center text, border bottom, margin bottom --}}
            {{-- Desktop: Left text, border right, no margin bottom --}}
            <div class="w-full lg:w-auto text-center lg:text-left lg:pr-10 border-b lg:border-b-0 lg:border-r border-white/10 pb-6 lg:pb-0 mb-8 lg:mb-0 shrink-0">
                <h2 class="text-white font-bold text-2xl tracking-tight leading-tight">
                    Fakta <span class="text-orange-500">FEB UNSAP</span>
                </h2>
                <p class="text-white/40 text-xs uppercase tracking-[0.25em] font-medium mt-2 lg:mt-1">
                    Dalam Angka
                </p>
            </div>

            {{-- Stats Grid --}}
            {{-- Mobile: Grid 2 Columns (Rapi & Seimbang) --}}
            {{-- Desktop: Flex Row (Memanjang ke samping) --}}
            <div class="w-full lg:w-auto grid grid-cols-2 md:flex md:flex-wrap justify-center lg:justify-end items-start gap-x-6 gap-y-8 md:gap-x-12">
                @foreach($stats as $stat)
                    <div class="flex flex-col items-center lg:items-start group col-span-1">
                        <div class="flex items-baseline gap-1">
                            <span
                                class="text-3xl sm:text-4xl font-black text-white counter tabular-nums leading-none tracking-tighter group-hover:text-orange-400 transition-colors"
                                data-target="{{ $stat->value }}"
                            >
                                0
                            </span>
                            <span class="text-orange-500 font-bold text-xl">+</span>
                        </div>
                        {{-- Text label stat responsive text size --}}
                        <span class="text-white/60 text-[10px] sm:text-xs md:text-sm font-medium uppercase tracking-wider mt-1 text-center lg:text-left">
                            {{ $stat->label }}
                        </span>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</section>

{{-- Counter Animation Script --}}
@push('scripts')
<script>
    function animateCounter(element) {
        const target = parseInt(element.getAttribute('data-target'));
        const duration = 2000; 
        const frameRate = 1000 / 60;
        const totalFrames = Math.round(duration / frameRate);
        let currentFrame = 0;

        const easeOutQuad = (t) => t * (2 - t);

        const updateCounter = () => {
            currentFrame++;
            const progress = easeOutQuad(currentFrame / totalFrames);
            const currentValue = Math.round(target * progress);

            // Format angka lokal (ID)
            element.textContent = currentValue.toLocaleString('id-ID');

            if (currentFrame < totalFrames) {
                requestAnimationFrame(updateCounter);
            } else {
                element.textContent = target.toLocaleString('id-ID');
            }
        };

        requestAnimationFrame(updateCounter);
    }

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.querySelectorAll('.counter').forEach(counter => {
                    if (!counter.classList.contains('animated')) {
                        counter.classList.add('animated');
                        animateCounter(counter);
                    }
                });
            }
        });
    }, { 
        // Threshold diturunkan ke 0.2 agar di HP (layar vertikal) 
        // animasi lebih cepat muncul tanpa harus scroll sampai tengah elemen persis
        threshold: 0.2 
    });

    document.addEventListener('DOMContentLoaded', () => {
        const section = document.querySelector('.stats-counter-section');
        if (section) observer.observe(section);
    });
</script>
@endpush

<style>
    .tabular-nums {
        font-variant-numeric: tabular-nums;
    }
</style>
@endif