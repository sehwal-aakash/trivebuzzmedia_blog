@props(['title' => 'Admin Dashboard', 'active' => 'dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }} - {{ config('app.name', 'TriveBuzz Media') }}</title>
    <meta name="robots" content="noindex, nofollow">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

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
<body class="bg-surface-50 dark:bg-[#0f1729] text-[#344256] dark:text-slate-200 font-sans antialiased min-h-screen flex" x-data="{ sidebarOpen: false }">

    {{-- Mobile Overlay --}}
    <div x-show="sidebarOpen" @click="sidebarOpen = false" x-transition.opacity class="fixed inset-0 z-40 bg-black/60 backdrop-blur-xs lg:hidden"></div>

    {{-- Sidebar --}}
    <aside 
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        class="fixed top-0 left-0 bottom-0 z-50 w-64 bg-[#0f1729] text-white border-r border-slate-800 flex flex-col transition-transform duration-300 ease-in-out shadow-2xl"
    >
        {{-- Sidebar Brand --}}
        <div class="h-20 flex items-center px-6 border-b border-slate-800 justify-between">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                <div class="w-9 h-9 bg-slate-800 border border-slate-700/60 rounded-xl flex items-center justify-center text-white shadow-md">
                    <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-[#3c83f6] to-[#16a249]">T</span>
                </div>
                <div class="flex flex-col">
                    <span class="text-lg font-black tracking-tight leading-none text-white font-sans">TRIVEBUZZ</span>
                    <span class="text-[9px] font-extrabold text-[#3c83f6] tracking-[0.2em] uppercase mt-1">Admin Panel</span>
                </div>
            </a>
            <button @click="sidebarOpen = false" class="lg:hidden p-1 text-slate-400 hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        {{-- Sidebar Menu --}}
        <div class="flex-1 overflow-y-auto px-4 py-6 space-y-8 custom-scrollbar">
            {{-- Main Navigation --}}
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Main Overview</p>
                <nav class="space-y-1">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.dashboard') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                        Dashboard
                    </a>
                </nav>
            </div>

            {{-- Content Management --}}
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">Content Moderation</p>
                <nav class="space-y-1">
                    <a href="{{ route('admin.posts.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.posts.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <div class="flex items-center gap-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            Posts
                        </div>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.categories.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                        Categories
                    </a>
                    <a href="{{ route('admin.tags.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.tags.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        Tags
                    </a>
                    <a href="{{ route('admin.comments.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.comments.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        Comments
                    </a>
                </nav>
            </div>

            {{-- Platform Administration --}}
            <div>
                <p class="px-3 text-[10px] font-black uppercase tracking-widest text-slate-400 mb-3">User & Access</p>
                <nav class="space-y-1">
                    <a href="{{ route('admin.applications.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.applications.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Author Applications
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.users.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        Users Management
                    </a>
                    <a href="{{ route('admin.newsletters.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.newsletters.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        Newsletter Broadcasting
                    </a>
                    <a href="{{ route('admin.activity-logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.activity-logs.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Activity Logs
                    </a>
                    @if(auth()->user()->isSuperAdmin() && Route::has('admin.email-logs.index'))
                        <a href="{{ route('admin.email-logs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition-all {{ Request::routeIs('admin.email-logs.*') ? 'bg-[#3c83f6] text-white shadow-md shadow-blue-500/20' : 'text-slate-300 hover:bg-slate-800/70 hover:text-white' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            Email Tracking Logs
                        </a>
                    @endif
                </nav>
            </div>
        </div>

        {{-- Sidebar Footer --}}
        <div class="p-4 border-t border-slate-800">
            <a href="{{ route('home') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                <svg class="w-4 h-4 text-[#16a249]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                View Live Site
            </a>
        </div>
    </aside>

    {{-- Main Area --}}
    <div class="flex-1 lg:pl-64 flex flex-col min-w-0">
        {{-- Admin Topbar --}}
        <header class="h-20 bg-white/90 dark:bg-[#0f1729]/90 border-b border-slate-200/80 dark:border-slate-800 backdrop-blur-md sticky top-0 z-30 px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <button @click="sidebarOpen = true" class="lg:hidden p-2 text-slate-600 dark:text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                </button>
                <h1 class="text-xl font-extrabold text-[#0f1729] dark:text-white font-sans tracking-tight">{{ $title }}</h1>
            </div>

            <div class="flex items-center gap-4">
                {{-- Theme Toggle --}}
                <button 
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))"
                    class="p-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-[#3c83f6] rounded-xl transition-all border border-slate-200/60 dark:border-slate-700/60"
                    title="Toggle Theme"
                >
                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-4 h-4 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 18v1m9-9h1M3 9h1m12.728-4.728l-.707.707M6.343 17.657l-.707.707M16.95 16.95l.707.707M5.657 5.657l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                </button>

                {{-- User Badge --}}
                <div class="flex items-center gap-3 border-l border-slate-200 dark:border-slate-800 pl-4">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center font-bold text-xs shadow-sm">
                        {{ substr(auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="hidden sm:block">
                        <p class="text-xs font-bold text-[#0f1729] dark:text-white leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] font-semibold text-[#16a249] uppercase">Super Admin</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Page Content --}}
        <main class="flex-1 p-6 md:p-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/60 text-[#16a249] rounded-2xl text-xs font-bold flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-[#16a249]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 text-rose-600 rounded-2xl text-xs font-bold flex items-center gap-3">
                    <svg class="w-5 h-5 shrink-0 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            {{ $slot }}
        </main>
    </div>

    @stack('scripts')
</body>
</html>
