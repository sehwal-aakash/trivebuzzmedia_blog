@props(['seoTags' => [], 'title' => null, 'description' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ $seoTags['title'] ?? $title ?? config('app.name', 'TriveBuzz Media') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/jpeg" href="{{ asset('trivebuzzmedia-favicon.jpg') }}">
        <link rel="shortcut icon" href="{{ asset('trivebuzzmedia-favicon.jpg') }}">
        <link rel="apple-touch-icon" href="{{ asset('trivebuzzmedia-favicon.jpg') }}">

        <!-- SEO -->
        <meta name="description" content="{{ $seoTags['description'] ?? $description ?? 'Discover breaking news, tech insights, lifestyle articles, and expert stories on TriveBuzz Media.' }}">
        <meta name="keywords" content="{{ $seoTags['keywords'] ?? 'trivebuzz, blog, news, articles, publishing, stories' }}">
        <meta name="robots" content="{{ $seoTags['robots'] ?? $robots ?? 'index, follow' }}">
        <link rel="canonical" href="{{ $seoTags['canonical_url'] ?? Request::url() }}">

        <!-- Open Graph / Facebook -->
        <meta property="og:type" content="website">
        <meta property="og:url" content="{{ $seoTags['canonical_url'] ?? Request::url() }}">
        <meta property="og:title" content="{{ $seoTags['og_title'] ?? $seoTags['title'] ?? config('app.name') }}">
        <meta property="og:description" content="{{ $seoTags['og_description'] ?? $seoTags['description'] ?? '' }}">
        @if(isset($seoTags['og_image']) && $seoTags['og_image'])
            <meta property="og:image" content="{{ $seoTags['og_image'] }}">
        @endif

        <!-- Twitter -->
        <meta property="twitter:card" content="{{ $seoTags['twitter_card'] ?? 'summary_large_image' }}">
        <meta property="twitter:url" content="{{ $seoTags['canonical_url'] ?? Request::url() }}">
        <meta property="twitter:title" content="{{ $seoTags['og_title'] ?? $seoTags['title'] ?? config('app.name') }}">
        <meta property="twitter:description" content="{{ $seoTags['og_description'] ?? $seoTags['description'] ?? '' }}">
        @if(isset($seoTags['og_image']) && $seoTags['og_image'])
            <meta property="twitter:image" content="{{ $seoTags['og_image'] }}">
        @endif

        @if(isset($seoTags['schema']))
            <script type="application/ld+json">
                {!! json_encode($seoTags['schema'], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
            </script>
        @endif

        @if(isset($meta)) {{ $meta }} @endif


        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />

        <!-- Styles / Scripts -->
        <style>[x-cloak] { display: none !important; }</style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script>
            if (localStorage.getItem('darkMode') === 'true' || (!('darkMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        </script>
        @stack('styles')
    </head>
    <body 
        class="bg-surface-50 dark:bg-global-primary text-global-text dark:text-slate-200 font-sans antialiased min-h-screen flex flex-col selection:bg-secondary selection:text-white"
        x-data="{ readingProgress: 0 }"
        @scroll.window="readingProgress = (window.pageYOffset / (document.documentElement.scrollHeight - window.innerHeight)) * 100"
    >
        {{-- Reading Progress Bar --}}
        @if(Request::is('posts/*'))
            <div class="fixed top-0 left-0 w-full h-1 z-[100] pointer-events-none">
                <div class="h-full bg-secondary transition-all duration-150 ease-out" :style="`width: ${readingProgress}%`"></div>
            </div>
        @endif
        <x-nav />

        <main class="flex-grow">
            {{ $slot }}
        </main>

        <x-footer />
        
        @stack('scripts')
    </body>
</html>
