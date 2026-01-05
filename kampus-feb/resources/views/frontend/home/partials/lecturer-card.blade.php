<a href="{{ route('lecturers.show', $lecturer->slug) }}"
   class="group block w-60 hover:-translate-y-2 transition-transform duration-300">

    <div class="relative overflow-hidden shadow-lg bg-[#0E1035] w-60 border border-white rounded-lg">

        <!-- LEFT PANEL GRADIENT -->
        <div class="absolute inset-y-0 left-0 w-20 z-20"
             style="
                background: linear-gradient(
                    to right,
                    rgba(0,0,0,1) 0%,
                    rgba(0,0,0,0.9) 30%,
                    rgba(0,0,0,0.6) 60%,
                    rgba(0,0,0,0.3) 80%,
                    transparent 100%
                );
             ">

            <div class="absolute inset-y-0 left-3 flex flex-col justify-between py-3">
                <span class="text-white font-serif font-bold text-[1.75rem]"
                      style="
                        writing-mode: vertical-rl;
                        text-orientation: upright;
                        letter-spacing: -0.05em;
                        line-height: 1.05;
                        transform: translateX(2px);
                      ">
                    Lecturer
                </span>
            </div>
        </div>

        <!-- PHOTO -->
        <div class="relative h-64 overflow-hidden">
            @if($lecturer->photo)
                <img src="{{ Storage::url($lecturer->photo) }}"
                     class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110">
            @else
                <div class="w-full h-full bg-gray-600 flex items-center justify-center transition-transform duration-500 ease-in-out group-hover:scale-110">
                    <i class="fas fa-user text-5xl text-gray-300"></i>
                </div>
            @endif
        </div>

        <!-- BOTTOM INFORMATION -->
        <div class="px-4 py-2 text-center border-t border-gray-700 bg-[#0B0D2A] z-40">
            <h3 class="font-serif font-semibold text-white text-sm">
                {{ $lecturer->name }}
            </h3>
            <p class="text-gray-300 text-[11px] font-serif mt-0.5">
                {{ $lecturer->nidn }}
            </p>
        </div>

    </div>
</a>
