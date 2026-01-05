<li>
    <a href="{{ route($route) }}" 
       class="flex items-center gap-3 p-2 rounded transition-colors hover:bg-gray-100 {{ request()->routeIs($routeMatch) ? 'bg-blue-50 text-blue-600 font-semibold' : 'text-gray-700' }}">
        <i class="{{ $icon }} w-5 h-5 flex-shrink-0 text-center" style="min-width: 1.25rem;"></i>
        <span class="text-sm flex-1">{{ $label }}</span>
        @if(isset($badge) && $badge > 0)
            <span class="bg-red-500 text-white text-xs rounded-full px-2 py-0.5 font-semibold">
                {{ $badge }}
            </span>
        @endif
    </a>
</li>