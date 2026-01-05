<a href="{{ route('news.show', $news->slug) }}" 
   class="group block relative overflow-hidden rounded-lg shadow-xl w-64 h-80 bg-gray-900 transition-all duration-300 transform hover:scale-[1.02] flex-shrink-0">
    
    <div class="absolute inset-0 overflow-hidden">
        @if($news->featured_image)
            <img src="{{ Storage::url($news->featured_image) }}" 
                 alt="{{ $news->title }}"
                 class="w-full h-full object-cover transition-transform duration-500 ease-in-out group-hover:scale-110 group-hover:opacity-90">
        @else
            <div class="w-full h-full bg-gradient-to-br from-gray-700 to-gray-600 flex items-center justify-center">
                <i class="fas fa-newspaper text-6xl text-gray-400"></i>
            </div>
        @endif
    </div>

    <div class="absolute inset-x-0 bottom-0 h-full z-10"
         style="
            background: linear-gradient(
                to top,
                rgba(0,0,0,0.95) 0%,
                rgba(0,0,0,0.7) 30%,
                rgba(0,0,0,0.4) 60%,
                transparent 100%
            );
         ">
    </div>

    <div class="relative h-full flex flex-col justify-end p-6 text-left z-20 
                transition-transform duration-300 group-hover:-translate-y-6"> 
        
        <h3 class="text-white font-semibold text-lg mb-2 line-clamp-4"
            style="font-family: 'Poppins', sans-serif; line-height: 1.3;">
            {{ $news->title }}
        </h3>

        <p class="text-white text-xs opacity-75 mb-4"
           style="font-family: 'Poppins', sans-serif;">
            Update Terakhir {{ optional($news->published_at)->format('d F Y') ?? $news->created_at->format('d F Y') }}
        </p>
<div class="absolute inset-x-0 bottom-0 px-6 pt-4 
            opacity-0 group-hover:opacity-100 transition-opacity duration-300">
     <span class="inline-block px-3 py-1.5 rounded-md shadow-lg text-left"
         style="
            background: linear-gradient(90deg, #FF8C00, #D32F2F); 
            font-family: 'Poppins', sans-serif;
         ">
        <span class="text-white font-medium text-xs tracking-wide flex items-center gap-1">
            Selengkapnya <span>→</span>
        </span>
    </span>
</div>
        
    </div>
</a>