<div class="p-6 relative overflow-hidden bg-white transition-all duration-500 group card-box"
     style="width: 414px; height: 242px; font-family: 'Poppins', sans-serif;">

    <!-- Background Image + Overlay -->
    <div class="absolute inset-0 z-0">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
        <div class="absolute inset-0 bg-black opacity-40"></div>
    </div>

    <!-- White Sliding Cover -->
    <div class="absolute inset-0 bg-white transition-transform duration-700 ease-in-out z-10 group-hover:translate-x-full"></div>

    <!-- Content -->
    <div class="relative z-20 flex flex-col h-full">

        <!-- Title + Icon -->
        <div class="flex items-start justify-between mb-3">
            <!-- Title -->
            <h3 class="flex-1 pr-3 transition-colors duration-300 text-[#1a1a1a] group-hover:text-white"
                style="font-size:22px; font-weight:400; font-family:'Poppins', sans-serif;">
                {{ $title }}
            </h3>

            <!-- Icon PNG -->
            <div class="w-8 h-8 relative flex-shrink-0 mt-2">
                <img src="{{ $icon_default }}" class="absolute inset-0 w-full h-full object-contain transition-opacity duration-500 group-hover:opacity-0">
                <img src="{{ $icon_hover }}" class="absolute inset-0 w-full h-full object-contain opacity-0 transition-opacity duration-500 group-hover:opacity-100">
            </div>
        </div>

        <!-- Description -->
        <p class="leading-relaxed mb-6 transition-colors duration-300 text-[#6b7280] group-hover:text-white"
           style="font-size:12px; font-family:'Poppins', sans-serif;">
            {{ $description }}
        </p>

        <!-- Link -->
        <div class="mt-auto">
            <a href="{{ $link }}" class="inline-flex items-center font-semibold text-xs transition-all duration-300 group-hover:text-white" style="color:#FF6B35;">
                Selengkapnya
                <svg class="w-3 h-3 ml-1 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

    </div>
</div>


<style>
/* Border kotak penuh dengan gradient */
.card-box {
    border-width: 2px;                 /* ketebalan */
    border-style: solid;               /* wajib ada */
    border-image: linear-gradient(135deg, #C91818, #FFCC00) 1;  /* gradient */
    border-image-slice: 1;             /* pastikan gradient mengisi seluruh border */
    box-sizing: border-box;            /* agar width tetap sesuai container */
}


/* Responsif untuk mobile */
@media (max-width: 768px) {
    .card-box {
        width: 100% !important;
        max-width: 100%;
        border-width: 2px;
    }
}

@media (max-width: 480px) {
    .card-box {
        border-width: 2px;
    }
}
</style>