@extends('layouts.app')

@section('title', $news->meta_title ?? $news->title . ' - FEB UNSAP')

@section('meta')
    {{-- SEO Meta Tags tetap sama seperti sebelumnya --}}
    <meta name="description" content="{{ $news->meta_description ?? Str::limit(strip_tags($news->excerpt ?? $news->content), 160) }}">
    <meta name="author" content="{{ $news->author?->name ?? $news->author_name ?? 'FEB UNSAP' }}">
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $news->meta_title ?? $news->title }}">
    <meta property="og:description" content="{{ $news->meta_description ?? Str::limit(strip_tags($news->excerpt ?? $news->content), 160) }}">
    @if($news->featured_image)
    <meta property="og:image" content="{{ Storage::url($news->featured_image) }}">
    @endif
@endsection

@section('content')
{{-- Load Font & Style (Sesuai dengan Index) --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    .font-poppins-all { font-family: 'Poppins', sans-serif !important; }
    
    /* FIX FORMAT TULISAN (Sangat Penting) */
    .prose { color: #334155; line-height: 1.8; }
    .prose strong { font-weight: 700; color: #0f172a; }
    .prose i, .prose em { font-style: italic; }
    
    /* Memunculkan kembali Titik (Bulleted List) dan Nomor */
    .prose ul { list-style-type: disc !important; margin-left: 1.5rem !important; margin-bottom: 1rem !important; }
    .prose ol { list-style-type: decimal !important; margin-left: 1.5rem !important; margin-bottom: 1rem !important; }
    .prose li { margin-bottom: 0.5rem !important; display: list-item !important; }

    /* Ukuran Heading */
    .prose h1 { font-size: 2.25rem; font-weight: 800; margin-bottom: 1.5rem; }
    .prose h2 { font-size: 1.875rem; font-weight: 700; margin-top: 2rem; margin-bottom: 1rem; }
    .prose h3 { font-size: 1.5rem; font-weight: 700; margin-top: 1.5rem; margin-bottom: 1rem; }

    /* Link & Blockquote */
    .prose blockquote { border-left: 4px solid #ea580c; background: #f8fafc; padding: 1rem 1.5rem; font-style: italic; border-radius: 0 0.5rem 0.5rem 0; margin: 1.5rem 0; }
    .prose a { color: #ea580c; font-weight: 600; text-decoration: underline; }
    .prose img { rounded-xl shadow-md my-8; width: 100%; height: auto; }

    /* Animasi Blob */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
</style>

<div class="font-poppins-all bg-slate-50 min-h-screen pb-20">
    
    {{-- BREADCRUMB SECTION --}}
    <div class="bg-white border-b border-slate-200 shadow-sm mb-8">
        <div class="container mx-auto px-4 py-4">
            <nav class="flex items-center text-sm font-medium">
                <a href="{{ url('/') }}" class="text-slate-400 hover:text-orange-600 transition-colors flex items-center gap-2">
                    <i class="fas fa-home"></i> 
                    <span>Beranda</span>
                </a>
                <span class="mx-3 text-slate-300">/</span>
                <a href="{{ route('news.index') }}" class="text-slate-400 hover:text-orange-600 transition-colors">Berita</a>
                <span class="mx-3 text-slate-300">/</span>
                <span class="text-orange-600 font-semibold truncate max-w-[200px] md:max-w-none">{{ $news->title }}</span>
            </nav>
        </div>
    </div>

    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-4 gap-10">
            
            {{-- 1. MAIN CONTENT (ARTIKEL) --}}
            <div class="lg:col-span-3">
                <article class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    
                    {{-- Featured Image --}}
                    @if($news->featured_image)
                    <div class="relative h-[300px] md:h-[500px] overflow-hidden">
                        <img src="{{ Storage::url($news->featured_image) }}" 
                             class="w-full h-full object-cover" 
                             alt="{{ $news->title }}">
                        <div class="absolute top-6 left-6">
                            <span class="bg-orange-600 text-white text-xs font-bold px-4 py-2 rounded-full shadow-lg uppercase tracking-wider">
                                {{ $news->category->name }}
                            </span>
                        </div>
                    </div>
                    @endif

                    <div class="p-6 md:p-12">
                        {{-- Meta Info --}}
                        <div class="flex flex-wrap items-center gap-6 text-xs font-bold text-slate-400 uppercase tracking-widest mb-6">
                            <span class="flex items-center gap-2">
                                <i class="far fa-calendar-alt text-orange-500 text-sm"></i> 
                                {{ $news->published_at->translatedFormat('d F Y') }}
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="far fa-eye text-orange-500 text-sm"></i> 
                                {{ number_format($news->views) }} Views
                            </span>
                            <span class="flex items-center gap-2">
                                <i class="far fa-clock text-orange-500 text-sm"></i> 
                                {{ ceil(str_word_count(strip_tags($news->content)) / 200) }} Menit Baca
                            </span>
                        </div>

                    {{-- Judul --}}
<h1 class="text-2xl md:text-4xl font-extrabold text-slate-900 leading-snug mb-6 text-left">
    {{ $news->title }}
</h1>



                        {{-- Author & Share --}}
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between border-y border-slate-100 py-6 mb-10 gap-6">
                            <div class="flex items-center gap-4">
                                <div class="w-12 h-12 bg-gradient-to-tr from-slate-800 to-slate-900 rounded-full flex items-center justify-center text-orange-500 font-bold shadow-inner">
                                    {{-- Inisial Nama --}}
                                    {{ strtoupper(substr($news->author_name ?? ($news->author?->name ?? 'A'), 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Penulis</p>
                                    <p class="text-slate-800 font-bold">
                                        {{ $news->author_name ?? ($news->author?->name ?? 'Redaksi FEB') }}
                                    </p>
                                </div>
                            </div>

                            <div class="flex items-center gap-3">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter mr-2">Bagikan:</p>
                                <a href="https://wa.me/?text={{ urlencode($news->title . ' - ' . route('news.show', $news->slug)) }}" class="w-9 h-9 bg-green-50 text-green-600 rounded-lg flex items-center justify-center hover:bg-green-600 hover:text-white transition-all shadow-sm" target="_blank">
                                    <i class="fab fa-whatsapp text-lg"></i>
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('news.show', $news->slug)) }}" class="w-9 h-9 bg-blue-50 text-blue-600 rounded-lg flex items-center justify-center hover:bg-blue-600 hover:text-white transition-all shadow-sm" target="_blank">
                                    <i class="fab fa-facebook-f text-lg"></i>
                                </a>
                                <button onclick="copyToClipboard()" class="w-9 h-9 bg-slate-50 text-slate-600 rounded-lg flex items-center justify-center hover:bg-slate-600 hover:text-white transition-all shadow-sm">
                                    <i class="fas fa-link text-lg"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Isi Konten --}}
                        <div class="prose prose-slate prose-lg max-w-none 
                                    prose-p:leading-relaxed prose-p:text-slate-600 
                                    prose-headings:text-slate-900 prose-headings:font-bold
                                    prose-strong:text-slate-900 prose-strong:font-bold">
                            {{-- Gunakan {!! $news->content !!} jika clean() terlalu banyak menghapus format --}}
                            {!! $news->content !!}
                        </div>

                        {{-- Galeri Foto --}}
                        @if($news->images && $news->images->count() > 0)
                        <div class="mt-16 pt-10 border-t border-slate-100">
                            <h3 class="text-xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                                <span class="w-8 h-1 bg-orange-500 rounded-full"></span>
                                Foto Terkait
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                @foreach($news->images as $image)
                                <div class="group relative overflow-hidden rounded-2xl bg-slate-100 border border-slate-200">
                                    <img src="{{ Storage::url($image->image_path) }}" 
                                         class="w-full h-72 object-cover group-hover:scale-110 transition duration-700">
                                    @if($image->caption)
                                    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent p-6 translate-y-2 group-hover:translate-y-0 transition duration-300">
                                        <p class="text-white text-sm font-medium">{{ $image->caption }}</p>
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- Tags Section --}}
                        @if($news->meta_keywords)
                            @php
                                $tags = is_string($news->meta_keywords) 
                                    ? array_map('trim', explode(',', $news->meta_keywords))
                                    : (is_array($news->meta_keywords) ? $news->meta_keywords : []);
                            @endphp
                            
                            @if(count($tags) > 0)
                            <div class="mt-12 pt-8 border-t border-slate-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fas fa-tags text-orange-500"></i>
                                    <h3 class="text-sm font-bold text-slate-800 uppercase tracking-wider">Topik Terkait</h3>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($tags as $tag)
                                    @if(!empty($tag))
                                    <a href="{{ route('news.index', ['search' => $tag]) }}" 
                                       class="bg-slate-100 hover:bg-orange-600 hover:text-white text-slate-600 px-4 py-2 rounded-lg text-xs transition-all duration-300 font-bold border border-slate-200">
                                        #{{ $tag }}
                                    </a>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        @endif
                    </div>
                </article>

                 

                {{-- Berita Terkait --}}
                @if($relatedNews && $relatedNews->count() > 0)
                <div class="mt-12">
                    <h3 class="text-2xl font-bold text-slate-900 mb-8 uppercase tracking-tight">Berita Terkait</h3>
                    <div class="grid md:grid-cols-2 gap-6">
                        @foreach($relatedNews as $related)
                        <a href="{{ route('news.show', $related->slug) }}" class="group flex gap-4 bg-white p-4 rounded-xl border border-slate-200 shadow-sm hover:shadow-md transition-all">
                            <div class="w-24 h-24 overflow-hidden rounded-lg flex-shrink-0">
                                <img src="{{ $related->featured_image ? Storage::url($related->featured_image) : 'https://via.placeholder.com/150' }}" class="w-full h-full object-cover group-hover:scale-110 transition duration-500">
                            </div>
                            <div class="flex flex-col justify-center">
                                <span class="text-orange-600 font-bold text-[10px] uppercase mb-1">{{ $related->category->name }}</span>
                                <h4 class="font-bold text-slate-800 text-sm line-clamp-2 group-hover:text-orange-600 transition-colors">
                                    {{ $related->title }}
                                </h4>
                                <span class="text-slate-400 text-[10px] mt-1">{{ $related->published_at->translatedFormat('d M Y') }}</span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- 2. SIDEBAR --}}
            <aside class="lg:col-span-1 space-y-8">
                {{-- Kategori (Slate Style) --}}
                <div class="bg-slate-900 rounded-2xl p-6 text-white shadow-xl relative overflow-hidden">
                    {{-- Blob pemanis --}}
                    <div class="absolute -top-10 -right-10 w-32 h-32 bg-orange-600/20 rounded-full blur-3xl animate-blob"></div>
                    
                    <h3 class="text-xs font-bold mb-6 uppercase tracking-widest text-orange-500 relative z-10">Kategori</h3>
                    <div class="space-y-1 relative z-10">
                        @foreach($categories as $category)
                        <a href="{{ route('news.index', ['category' => $category->id]) }}" 
                           class="flex justify-between items-center py-2.5 px-3 rounded-lg text-sm {{ $news->category_id == $category->id ? 'bg-orange-600 text-white font-bold' : 'text-slate-400 hover:text-white hover:bg-white/5 transition-all' }}">
                            <span>{{ $category->name }}</span>
                            <span class="text-xs opacity-50">{{ $category->news_count }}</span>
                        </a>
                        @endforeach
                    </div>
                </div>

                {{-- Populer (Sesuai Index) --}}
                @if($popularNews && $popularNews->count() > 0)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-5 py-4">
                        <h3 class="font-bold text-white flex items-center gap-2 text-xs uppercase tracking-widest">
                            <i class="fas fa-fire"></i> Terpopuler
                        </h3>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @foreach($popularNews as $popular)
                        <a href="{{ route('news.show', $popular->slug) }}" class="flex gap-3 p-4 hover:bg-orange-50 transition group">
                            <div class="w-14 h-14 bg-slate-100 rounded-lg overflow-hidden flex-shrink-0">
                                <img src="{{ $popular->featured_image ? Storage::url($popular->featured_image) : 'https://via.placeholder.com/100' }}" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-slate-800 line-clamp-2 group-hover:text-orange-600 transition mb-1">
                                    {{ $popular->title }}
                                </h4>
                                <div class="flex items-center gap-2 text-[10px] text-slate-400">
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

                {{-- Archive --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-slate-200">
                    <h3 class="text-xs font-bold text-slate-800 mb-4 uppercase tracking-widest">Arsip Berita</h3>
                    <select onchange="if(this.value) window.location.href=this.value" 
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-600 focus:ring-2 focus:ring-orange-500 appearance-none cursor-pointer">
                        <option value="">Pilih Bulan...</option>
                        @foreach($archives as $archive)
                        <option value="{{ route('news.archive', ['year' => $archive->year, 'month' => $archive->month]) }}">
                            {{ $archive->month_name }} {{ $archive->year }} ({{ $archive->count }})
                        </option>
                        @endforeach
                    </select>
                </div>
            </aside>
        </div>
    </div>
</div>

{{-- Toast Notification --}}
<div id="toast" class="fixed bottom-10 left-1/2 -translate-x-1/2 bg-slate-900 text-white px-6 py-3 rounded-full shadow-2xl opacity-0 transition-all duration-300 z-50 flex items-center gap-3 border border-orange-500">
    <i class="fas fa-check-circle text-orange-500"></i>
    <span class="text-sm font-bold tracking-wide">Link berhasil disalin!</span>
</div>

@push('scripts')
<script>
function copyToClipboard() {
    const url = window.location.href;
    navigator.clipboard.writeText(url).then(() => {
        const toast = document.getElementById('toast');
        toast.classList.remove('opacity-0', 'translate-y-10');
        toast.classList.add('opacity-100', '-translate-y-0');
        setTimeout(() => {
            toast.classList.add('opacity-0', 'translate-y-10');
            toast.classList.remove('opacity-100', '-translate-y-0');
        }, 3000);
    });
}
</script>
@endpush
@endsection



