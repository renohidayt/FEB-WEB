{{-- File: resources/views/components/seo-meta.blade.php --}}

@props(['news'])

<!-- Basic Meta Tags -->
<title>{{ $news->meta_title }} | {{ config('app.name') }}</title>
<meta name="description" content="{{ $news->meta_description }}">
@if($news->meta_keywords)
<meta name="keywords" content="{{ $news->meta_keywords }}">
@endif
<meta name="author" content="{{ $news->author->name ?? config('app.name') }}">
<link rel="canonical" href="{{ url()->current() }}">

<!-- Open Graph / Facebook -->
<meta property="og:type" content="article">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="{{ $news->meta_title }}">
<meta property="og:description" content="{{ $news->meta_description }}">
@if($news->og_image)
<meta property="og:image" content="{{ asset('storage/' . $news->og_image) }}">
@endif
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="article:published_time" content="{{ $news->published_at->toIso8601String() }}">
<meta property="article:modified_time" content="{{ $news->updated_at->toIso8601String() }}">
<meta property="article:author" content="{{ $news->author->name ?? '' }}">
<meta property="article:section" content="{{ $news->category->name ?? '' }}">

<!-- Twitter Card -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ url()->current() }}">
<meta name="twitter:title" content="{{ $news->meta_title }}">
<meta name="twitter:description" content="{{ $news->meta_description }}">
@if($news->og_image)
<meta name="twitter:image" content="{{ asset('storage/' . $news->og_image) }}">
@endif

<!-- JSON-LD Structured Data -->
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "NewsArticle",
  "headline": "{{ $news->title }}",
  "description": "{{ $news->meta_description }}",
  "image": "{{ $news->og_image ? asset('storage/' . $news->og_image) : '' }}",
  "datePublished": "{{ $news->published_at->toIso8601String() }}",
  "dateModified": "{{ $news->updated_at->toIso8601String() }}",
  "author": {
    "@type": "Person",
    "name": "{{ $news->author->name ?? '' }}"
  },
  "publisher": {
    "@type": "Organization",
    "name": "{{ config('app.name') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('images/logo.png') }}"
    }
  },
  "mainEntityOfPage": {
    "@type": "WebPage",
    "@id": "{{ url()->current() }}"
  }
}
</script>

{{-- 
Usage di view berita:
@section('head')
    <x-seo-meta :news="$news" />
@endsection
--}}