<nav 
    x-data="{ mobileMenuOpen: false }" 
    class="sticky top-0 z-50 w-full border-b border-surface-200/50 dark:border-surface-800/50 bg-white/80 dark:bg-surface-950/80 backdrop-blur-xl"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-10">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-2">
                        <div class="w-10 h-10 bg-surface-900 dark:bg-white rounded-xl flex items-center justify-center text-white dark:text-surface-900 transform group-hover:rotate-6 transition-transform duration-300">
                            <span class="text-xl font-black">T</span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-lg font-black tracking-tight text-surface-900 dark:text-white leading-none">TRIVEBUZZ</span>
                            <span class="text-[10px] font-bold text-brand dark:text-brand-light tracking-[0.2em] leading-none uppercase">Media Group</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-8">
                    @foreach(\App\Models\Category::take(4)->get() as $category)
                        <a href="{{ route('category.show', $category) }}" class="text-sm font-bold text-surface-500 hover:text-surface-900 dark:text-surface-400 dark:hover:text-white transition-colors">
                            {{ $category->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Dark Mode Toggle --}}
                <button 
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))"
                    class="p-2.5 bg-surface-100 dark:bg-surface-900 text-surface-500 hover:text-surface-900 dark:text-surface-400 dark:hover:text-white rounded-full transition-all active:scale-95"
                >
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 18v1m9-9h1M3 9h1m12.728-4.728l-.707.707M6.343 17.657l-.707.707M16.95 16.95l.707.707M5.657 5.657l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                </button>

                <div class="hidden md:flex items-center gap-6 border-l border-surface-200 dark:border-surface-800 ml-2 pl-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs font-black uppercase tracking-widest text-brand dark:text-brand-light hover:text-brand-dark transition-colors">
                                Admin
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAuthor() || auth()->user()->isAdmin())
                            <a href="{{ route('author.posts.create') }}" class="px-5 py-2.5 bg-surface-900 dark:bg-white text-white dark:text-surface-900 rounded-full text-xs font-black uppercase tracking-widest hover:opacity-90 transition-opacity">
                                Create Story
                            </a>
                        @endif

                        <div class="relative group">
                            <button class="flex items-center gap-2 group">
                                <div class="w-8 h-8 rounded-full bg-brand/10 dark:bg-brand-light/10 flex items-center justify-center text-brand dark:text-brand-light font-bold text-xs uppercase tracking-tighter">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-48 bg-white dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl shadow-xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all">
                                <a href="{{ route('author.dashboard') }}" class="block px-4 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 font-bold">Author Dashboard</a>
                                <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 font-medium">Dashboard</a>
                                <a href="{{ route('profile', ['user' => auth()->user()->username]) }}" class="block px-4 py-2 text-sm text-surface-700 dark:text-surface-300 hover:bg-surface-50 dark:hover:bg-surface-800 font-medium">My Profile</a>
                                <div class="h-px bg-surface-100 dark:border-surface-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-950/30 font-medium">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-surface-900 dark:text-white hover:text-brand transition-colors">
                            Sign In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-surface-900 dark:bg-white text-white dark:text-surface-900 rounded-full text-xs font-black uppercase tracking-widest hover:opacity-90 transition-opacity">
                                Join Now
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Mobile Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-surface-500">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition class="lg:hidden bg-white dark:bg-surface-950 border-b border-surface-200 dark:border-surface-800 p-6 space-y-6">
        <div class="grid grid-cols-2 gap-4">
            @foreach(\App\Models\Category::all() as $category)
                <a href="{{ route('category.show', $category) }}" class="text-sm font-bold text-surface-900 dark:text-white py-2">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        <div class="h-px bg-surface-100 dark:bg-surface-800"></div>
        @auth
            <a href="{{ route('dashboard') }}" class="block text-sm font-bold text-surface-900 dark:text-white">Dashboard</a>
            <a href="{{ route('author.posts.create') }}" class="block text-sm font-bold text-brand">Create Story</a>
        @else
            <a href="{{ route('login') }}" class="block text-sm font-bold text-surface-900 dark:text-white">Sign In</a>
            <a href="{{ route('register') }}" class="block text-sm font-bold text-brand">Join Now</a>
        @endauth
    </div>
</nav>
