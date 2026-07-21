<x-layout :seoTags="$seoTags">
    {{-- Hero / Featured Section --}}
    @if(!$query && $posts->count() > 0 && $posts->currentPage() == 1)
        <div class="border-b border-slate-200/60 dark:border-slate-800/80 bg-gradient-to-b from-[#F8FAFC99] via-white to-surface-50 dark:from-[#0f1729] dark:via-[#111a2e] dark:to-[#0f1729] py-16 transition-colors">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-blue-50 dark:bg-blue-950/40 border border-blue-200/60 dark:border-blue-800/40 rounded-full mb-6">
                            <span class="w-2 h-2 rounded-full bg-[#3c83f6] animate-pulse"></span>
                            <span class="text-[#3c83f6] dark:text-[#60a5fa] text-xs font-black uppercase tracking-widest">Featured Story</span>
                        </div>
                        <h1 class="text-4xl md:text-6xl font-black text-[#0f1729] dark:text-white mb-6 leading-[1.08] tracking-tight font-sans">
                            {{ $posts->first()->title }}
                        </h1>
                        <p class="text-lg text-[#344256] dark:text-slate-300 mb-8 line-clamp-3 font-normal leading-relaxed">
                            {{ $posts->first()->excerpt }}
                        </p>
                        <div class="flex flex-wrap items-center gap-6">
                            <a href="{{ route('posts.show', $posts->first()->slug) }}" class="px-8 py-4 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl font-extrabold text-xs uppercase tracking-wider transition-all shadow-lg shadow-blue-500/25 active:scale-95 flex items-center gap-2">
                                Read Full Story
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </a>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center font-bold text-sm shadow-sm">
                                    {{ substr($posts->first()->author->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-[#0f1729] dark:text-white">{{ $posts->first()->author->name }}</div>
                                    <div class="text-xs font-semibold text-slate-400">{{ $posts->first()->reading_time }} min read</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($posts->first()->featured_image)
                        <div class="relative">
                            <div class="absolute -inset-4 bg-gradient-to-r from-[#3c83f6]/20 to-[#16a249]/20 rounded-[2rem] blur-2xl dark:from-[#3c83f6]/10 dark:to-[#16a249]/10"></div>
                            <img src="{{ Storage::url($posts->first()->featured_image) }}" alt="{{ $posts->first()->title }}" class="relative w-full aspect-video lg:aspect-4/3 object-cover rounded-2xl shadow-2xl border border-slate-200/80 dark:border-slate-800">
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            
            {{-- Main Content --}}
            <div class="lg:col-span-8">
                <header class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-6 pb-6 border-b border-slate-200/60 dark:border-slate-800">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-black text-[#0f1729] dark:text-white tracking-tight">
                            @if($query)
                                Search: "{{ $query }}"
                            @else
                                Latest Articles
                            @endif
                        </h2>
                        <div class="h-1 w-16 bg-[#3c83f6] mt-2 rounded-full"></div>
                    </div>
                    
                    <form action="{{ route('home') }}" method="GET" class="relative w-full md:w-80">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}"
                            placeholder="Search articles, topics..." 
                            class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 dark:border-slate-800 bg-[#F8FAFC99] dark:bg-slate-900 focus:border-[#3c83f6] focus:ring-2 focus:ring-[#3c83f6]/20 dark:text-white transition-all text-sm font-medium outline-none"
                        >
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </header>

                <div class="space-y-6">
                    @forelse ($posts as $post)
                        {{-- Skip the first post on page 1 if not searching, as it's featured above --}}
                        @if(!$query && $posts->currentPage() == 1 && $loop->first)
                            @continue
                        @endif
                        <x-post-card :post="$post" />
                    @empty
                        <div class="py-20 text-center bg-[#F8FAFC99] dark:bg-slate-900/50 rounded-2xl border border-dashed border-slate-200 dark:border-slate-800">
                            <div class="w-16 h-16 bg-slate-100 dark:bg-slate-800 rounded-2xl flex items-center justify-center mx-auto mb-5 text-slate-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                            <p class="text-xl font-bold text-[#0f1729] dark:text-white mb-2">No stories found</p>
                            <p class="text-[#344256] dark:text-slate-400 mb-6 font-medium text-sm">Try adjusting your search terms or browse categories.</p>
                            @if($query)
                                <a href="{{ route('home') }}" class="px-6 py-3 bg-[#3c83f6] text-white font-extrabold text-xs uppercase tracking-wider rounded-xl hover:bg-blue-600 transition-all inline-block shadow-md">Clear search filter</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-12">
                {{-- Trending Section --}}
                <section class="bg-white/80 dark:bg-[#0f1729]/80 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
                    <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#16a249]"></span>
                            Trending Stories
                        </h3>
                    </div>
                    <div class="space-y-4">
                        @foreach($trendingPosts as $index => $trending)
                            <x-trending-post-card :post="$trending" :index="$index" />
                        @endforeach
                    </div>
                </section>

                {{-- Recommended Topics --}}
                <section class="bg-[#F8FAFC99] dark:bg-slate-900/60 p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800/80">
                    <h3 class="text-xs font-black text-[#0f1729] dark:text-white uppercase tracking-widest mb-5">Explore Topics</h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(\App\Models\Category::all() as $category)
                            <a href="{{ route('category.show', $category) }}" class="px-3.5 py-2 bg-white dark:bg-[#0f1729] text-[#344256] dark:text-slate-200 text-xs font-bold rounded-xl border border-slate-200 dark:border-slate-800 hover:border-[#3c83f6] hover:text-[#3c83f6] dark:hover:border-[#3c83f6] dark:hover:text-[#3c83f6] transition-all shadow-xs">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- Newsletter Card --}}
                <section class="bg-[#0f1729] p-8 rounded-2xl relative overflow-hidden group shadow-xl border border-slate-800">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#3c83f6]/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <div class="inline-block px-3 py-1 bg-emerald-950/60 text-[#16a249] border border-emerald-800/40 text-[10px] font-black uppercase tracking-widest rounded-lg mb-4">
                            Weekly Digest
                        </div>
                        <h3 class="text-2xl font-black text-white mb-3 leading-tight font-sans">Get top stories delivered to your inbox.</h3>
                        <p class="text-slate-400 text-xs font-normal mb-6">Join thousands of readers staying ahead of trends.</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            @csrf
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Enter your email" 
                                class="w-full px-4 py-3 bg-slate-900 border border-slate-700/60 rounded-xl text-white placeholder-slate-500 font-medium text-xs focus:ring-2 focus:ring-[#3c83f6] outline-none"
                                required
                            >
                            <button type="submit" class="w-full py-3 px-4 bg-[#16a249] hover:bg-emerald-600 text-white rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all shadow-lg shadow-emerald-900/30 active:scale-95">
                                Join Newsletter
                            </button>
                        </form>
                    </div>
                </section>

                {{-- Trending Tags --}}
                <section class="p-6 rounded-2xl bg-white/60 dark:bg-[#0f1729]/60 border border-slate-200/60 dark:border-slate-800">
                    <div class="flex items-center justify-between mb-5">
                        <h3 class="text-xs font-black text-[#0f1729] dark:text-white uppercase tracking-wider">
                            Popular Tags
                        </h3>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach(\App\Models\Tag::take(10)->get() as $tag)
                            <a href="{{ route('tag.show', $tag) }}" class="text-xs font-bold text-[#344256] dark:text-slate-400 hover:text-[#3c83f6] transition-colors bg-slate-100 dark:bg-slate-800 px-3 py-1.5 rounded-lg flex items-center gap-1">
                                <span class="text-[#3c83f6]">#</span>{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            </aside>

        </div>
    </div>
</x-layout>

