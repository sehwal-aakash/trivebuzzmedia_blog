<nav 
    x-data="{ mobileMenuOpen: false }" 
    class="sticky top-0 z-50 w-full border-b border-surface-200/60 dark:border-slate-800/80 bg-white/85 dark:bg-[#0f1729]/85 backdrop-blur-md transition-all duration-300"
>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center gap-10">
                {{-- Logo --}}
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="group flex items-center gap-3">
                        <div class="relative">
                            <div class="w-10 h-10 bg-[#0f1729] dark:bg-slate-800 border border-slate-700/50 rounded-xl flex items-center justify-center text-white shadow-md shadow-blue-500/10 transform group-hover:scale-105 group-hover:rotate-3 transition-all duration-300">
                                <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-[#3c83f6] to-[#16a249]">T</span>
                            </div>
                            <span class="absolute -top-1 -right-1 flex h-3 w-3">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#16a249] opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-3 w-3 bg-[#16a249]"></span>
                            </span>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-xl font-black tracking-tight text-[#0f1729] dark:text-white leading-none font-sans">TRIVEBUZZ</span>
                            <span class="text-[10px] font-bold text-[#3c83f6] dark:text-[#60a5fa] tracking-[0.22em] leading-none uppercase mt-1">Media Group</span>
                        </div>
                    </a>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden lg:flex items-center gap-8">
                    @foreach(\App\Models\Category::take(5)->get() as $category)
                        <a href="{{ route('category.show', $category) }}" class="text-sm font-semibold text-[#344256] hover:text-[#3c83f6] dark:text-slate-300 dark:hover:text-[#3c83f6] transition-colors relative py-2 group">
                            {{ $category->name }}
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-[#3c83f6] rounded-full group-hover:w-full transition-all duration-300"></span>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Dark Mode Toggle --}}
                <button 
                    @click="document.documentElement.classList.toggle('dark'); localStorage.setItem('darkMode', document.documentElement.classList.contains('dark'))"
                    class="p-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 hover:text-[#3c83f6] dark:text-slate-300 dark:hover:text-[#3c83f6] rounded-xl transition-all active:scale-95 border border-slate-200/50 dark:border-slate-700/50"
                    title="Toggle Theme"
                >
                    <svg class="w-5 h-5 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
                    <svg class="w-5 h-5 hidden dark:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 18v1m9-9h1M3 9h1m12.728-4.728l-.707.707M6.343 17.657l-.707.707M16.95 16.95l.707.707M5.657 5.657l.707.707M12 7a5 5 0 100 10 5 5 0 000-10z"></path></svg>
                </button>

                <div class="hidden md:flex items-center gap-5 border-l border-slate-200 dark:border-slate-800 ml-2 pl-6">
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-xs font-extrabold uppercase tracking-widest text-[#3c83f6] hover:text-[#0f1729] dark:hover:text-white transition-colors">
                                Admin
                            </a>
                        @endif
                        
                        @if(auth()->user()->isAuthor() || auth()->user()->isAdmin())
                            <a href="{{ route('author.posts.create') }}" class="px-4 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-blue-500/20 active:scale-95">
                                + Create Story
                            </a>
                        @endif

                        <div class="relative group">
                            <button class="flex items-center gap-2 group focus:outline-none">
                                <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center font-bold text-sm shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div class="absolute right-0 top-full mt-2 w-52 bg-white dark:bg-[#0f1729] border border-slate-200 dark:border-slate-800 rounded-2xl shadow-2xl py-2 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                                <div class="px-4 py-2 border-b border-slate-100 dark:border-slate-800 mb-1">
                                    <p class="text-xs text-slate-400 font-medium">Signed in as</p>
                                    <p class="text-sm font-bold text-[#0f1729] dark:text-white truncate">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="{{ route('author.dashboard') }}" class="flex items-center px-4 py-2.5 text-xs font-bold text-[#344256] dark:text-slate-200 hover:bg-[#F8FAFC99] dark:hover:bg-slate-800 hover:text-[#3c83f6] transition-colors">Author Dashboard</a>
                                <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-2.5 text-xs font-bold text-[#344256] dark:text-slate-200 hover:bg-[#F8FAFC99] dark:hover:bg-slate-800 hover:text-[#3c83f6] transition-colors">User Dashboard</a>
                                <a href="{{ route('profile', ['user' => auth()->user()->username]) }}" class="flex items-center px-4 py-2.5 text-xs font-bold text-[#344256] dark:text-slate-200 hover:bg-[#F8FAFC99] dark:hover:bg-slate-800 hover:text-[#3c83f6] transition-colors">My Profile</a>
                                <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2.5 text-xs font-bold text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/30 transition-colors">Log Out</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-[#344256] dark:text-slate-200 hover:text-[#3c83f6] transition-colors">
                            Sign In
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 active:scale-95">
                                Join Now
                            </a>
                        @endif
                    @endauth
                </div>

                {{-- Mobile Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden p-2 text-slate-600 dark:text-slate-300">
                    <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    <svg x-show="mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" x-transition class="lg:hidden bg-white dark:bg-[#0f1729] border-b border-slate-200 dark:border-slate-800 p-6 space-y-6">
        <div class="grid grid-cols-2 gap-4">
            @foreach(\App\Models\Category::all() as $category)
                <a href="{{ route('category.show', $category) }}" class="text-sm font-bold text-[#344256] dark:text-slate-200 hover:text-[#3c83f6] py-2">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
        <div class="h-px bg-slate-100 dark:bg-slate-800"></div>
        @auth
            <a href="{{ route('dashboard') }}" class="block text-sm font-bold text-[#0f1729] dark:text-white">Dashboard</a>
            <a href="{{ route('author.posts.create') }}" class="block text-sm font-bold text-[#3c83f6]">+ Create Story</a>
        @else
            <a href="{{ route('login') }}" class="block text-sm font-bold text-[#344256] dark:text-white">Sign In</a>
            <a href="{{ route('register') }}" class="block text-sm font-bold text-[#16a249]">Join Now</a>
        @endauth
    </div>
</nav>

