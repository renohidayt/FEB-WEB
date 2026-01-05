@extends('layouts.app')

@section('title', $category->name . ' - Berita Universitas XYZ')

@section('meta')
    <meta name="description" content="Berita kategori {{ $category->name }} dari Universitas XYZ. Informasi terkini seputar {{ strtolower($category->name) }}.">
    <meta name="keywords" content="{{ $category->name }}, berita, universitas xyz">
    <link rel="canonical" href="{{ route('news.category', $category->slug) }}">
@endsection

@section('content')
<!-- Category Header -->
<div class="bg-gradient-to-r from-blue-600 to-blue-800 text-white py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl">
            <nav class="mb-4">
                <ol class="flex items-center space-x-2 text-sm text-blue-100">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li>
                    <li>/</li>
                    <li><a href="{{ route('news.index') }}" class="hover:text-white">Berita</a></li>
                    <li>/</li>
                    <li class="text-white font-semibold">{{ $category->name }}</li>
                </ol>
            </nav>
            
            <div class="flex items-center gap-4 mb-4">
                <div class="w-16 h-16 bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-4xl md:text-5xl font-bold mb-2">{{ $category->name }}</h1>
                    <p class="text-blue-100 text-lg">{{ $news->total() }} berita tersedia</p>
                </div>
            </div>
            
            @if($category->description)
            <p class="text-blue-50 text-lg leading-relaxed">
                {{ $category->description }}
            </p>
            @endif
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-6">
            <!-- Back to All News -->
            <div class="bg-white rounded-xl shadow-md p-5">
                <a href="{{ route('news.index') }}" 
                   class="flex items-center gap-3 text-gray-700 hover:text-blue-600 font-semibold transition group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Semua Berita
                </a>
            </div>
            
            <!-- Other Categories -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-5 py-4">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Kategori Lainnya
                    </h3>
                </div>
                <div class="p-3">
                    <ul class="space-y-1">
                        @foreach($categories as $cat)
                        @if($cat->id != $category->id)
                        <li>
                            <a href="{{ route('news.category', $cat->slug) }}" 
                               class="flex items-center justify-between px-4 py-2.5 rounded-lg text-gray-700 hover:bg-blue-50 hover:text-blue-700 transition group">
                                <span class="flex items-center gap-2">
                                    <span class="w-2 h-2 rounded-full bg-gray-400 group-hover:bg-blue-600 transition"></span>
                                    {{ $cat->name }}
                                </span>
                                <span class="text-xs px-2 py-1 rounded-full bg-gray-200 text-gray-600 group-hover:bg-blue-100 group-hover:text-blue-700 transition">
                                    {{ $cat->news_count }}
                                </span>
                            </a>
                        </li>
                        @endif
                        @endforeach
                    </ul>
                </div>
            </div>
            
            <!-- Popular in Category -->
            @if($popularNews && $popularNews->count() > 0)
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-4">
                    <h3 class="font-bold text-white flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Populer di {{ $category->name }}
                    </h3>
                </div>
                <div class="divide-y divide-gray-100">
                    @foreach($popularNews as $popular)
                    <a href="{{ route('news.show', $popular->slug) }}" 
                       class="flex gap-3 p-4 hover:bg-orange-50 transition group">
                        @if($popular->featured_image)
                        <img src="{{ Storage::url($popular->featured_image) }}" 
                             alt="{{ $popular->title }}" 
                             class="w-16 h-16 object-cover rounded-lg flex-shrink-0"
                             loading="lazy">
                        @else
                        <div class="w-16 h-16 bg-gradient-to-br from-orange-400 to-orange-500 rounded-lg flex-shrink-0"></div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-sm text-gray-900 line-clamp-2 group-hover:text-orange-600 transition mb-1">
                                {{ $popular->title }}
                            </h4>
                            <div class="flex items-center gap-2 text-xs text-gray-500">
                                <span>👁 {{ number_format($popular->views) }}</span>
                                <span>•</span>
                                <span>{{ $popular->published_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif
        </aside>
        
        <!-- Main Content -->
        <div class="lg:col-span-3">
            @if($news->count() > 0)
                <!-- Sort & Count -->
                <div class="flex items-center justify-between mb-6">
                    <p class="text-sm text-gray-600">
                        Menampilkan <span class="font-semibold text-gray-900">{{ $news->firstItem() }}-{{ $news->lastItem() }}</span> dari <span class="font-semibold text-gray-900">{{ $news->total() }}</span> berita
                    </p>
                    <select onchange="window.location.href=this.value" 
                            class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="{{ route('news.category', [$category->slug, 'sort' => 'latest']) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ route('news.category', [$category->slug, 'sort' => 'popular']) }}" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler</option>
                        <option value="{{ route('news.category', [$category->slug, 'sort' => 'oldest']) }}" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                    </select>
                </div>
                
                <!-- News Grid -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                    @foreach($news as $item)
                    <article class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 group">
                        <a href="{{ route('news.show', $item->slug) }}" class="block">
                            <div class="relative overflow-hidden h-48">
                                @if($item->featured_image)
                                <img src="{{ Storage::url($item->featured_image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                                     loading="lazy">
                                @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                    <svg class="w-16 h-16 text-white opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                    </svg>
                                </div>
                                @endif
                                <div class="absolute top-3 right-3 bg-black bg-opacity-60 backdrop-blur-sm text-white px-2.5 py-1 rounded-lg flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                    <span class="text-xs font-semibold">{{ number_format($item->views) }}</span>
                                </div>
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-3 text-xs text-gray-500 mb-3">
                                    <time>📅 {{ $item->published_at->translatedFormat('d M Y') }}</time>
                                    <span>•</span>
                                    <span>⏱ {{ ceil(str_word_count(strip_tags($item->content)) / 200) }} min</span>
                                </div>
                                <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition leading-snug">
                                    {{ $item->title }}
                                </h3>
                                @if($item->excerpt)
                                <p class="text-gray-600 text-sm line-clamp-2 mb-4 leading-relaxed">
                                    {{ $item->excerpt }}
                                </p>
                                @endif
                                <div class="flex items-center justify-between pt-3 border-t border-gray-100">
                                    <span class="text-blue-600 font-semibold text-sm group-hover:gap-2 inline-flex items-center gap-1 transition-all">
                                        Baca Selengkapnya
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </span>
                                    @if($item->author)
                                    <div class="w-6 h-6 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        {{ strtoupper(substr($item->author->name ?? 'A', 0, 1)) }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </article>
                    @endforeach
                </div>
                
                <!-- Pagination -->
                <div class="mt-8">
                    {{ $news->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white rounded-xl shadow-md p-12 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Berita</h3>
                    <p class="text-gray-500 mb-6">
                        Belum ada berita yang dipublikasikan dalam kategori {{ $category->name }}
                    </p>
                    <a href="{{ route('news.index') }}" 
                       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-semibold transition">
                        Lihat Semua Berita
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection