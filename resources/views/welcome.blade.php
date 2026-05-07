<x-layout :seoTags="$seoTags">
    {{-- Hero/Featured Section --}}
    @if(!$query && $posts->count() > 0 && $posts->currentPage() == 1)
        <div class="border-b border-surface-100 dark:border-surface-800 bg-surface-50/50 dark:bg-surface-950/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div>
                        <span class="inline-block px-3 py-1 bg-brand/10 text-brand dark:text-brand-light text-[10px] font-black uppercase tracking-widest rounded-full mb-6">Featured Story</span>
                        <h1 class="text-5xl md:text-7xl font-black text-surface-900 dark:text-white mb-6 leading-[1.05] tracking-tight">
                            {{ $posts->first()->title }}
                        </h1>
                        <p class="text-xl text-surface-600 dark:text-surface-400 mb-10 line-clamp-3 font-medium leading-relaxed">
                            {{ $posts->first()->excerpt }}
                        </p>
                        <div class="flex items-center gap-6">
                            <a href="{{ route('posts.show', $posts->first()->slug) }}" class="px-8 py-4 bg-surface-900 dark:bg-white text-white dark:text-surface-900 rounded-full font-black text-sm uppercase tracking-widest hover:opacity-90 transition-opacity">
                                Read Full Story
                            </a>
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-surface-200 dark:bg-surface-800 flex items-center justify-center font-black text-surface-500">
                                    {{ substr($posts->first()->author->name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-black text-surface-900 dark:text-white">{{ $posts->first()->author->name }}</div>
                                    <div class="text-xs font-bold text-surface-500">{{ $posts->first()->reading_time }} min read</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($posts->first()->featured_image)
                        <div class="relative">
                            <div class="absolute -inset-4 bg-brand/10 rounded-[2rem] blur-2xl dark:bg-brand/5"></div>
                            <img src="{{ Storage::url($posts->first()->featured_image) }}" alt="{{ $posts->first()->title }}" class="relative w-full aspect-video lg:aspect-square object-cover rounded-[2rem] shadow-2xl border border-surface-100 dark:border-surface-800">
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
                <header class="mb-12 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div>
                        <h2 class="text-3xl font-black text-surface-900 dark:text-white tracking-tight">
                            @if($query)
                                Search: "{{ $query }}"
                            @else
                                Recent Stories
                            @endif
                        </h2>
                        <div class="h-1.5 w-12 bg-brand mt-2 rounded-full"></div>
                    </div>
                    
                    <form action="{{ route('home') }}" method="GET" class="relative w-full md:w-72">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ $query }}"
                            placeholder="Search..." 
                            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-surface-200 dark:border-surface-800 dark:bg-surface-900 focus:border-brand focus:ring-brand dark:text-white transition-all text-sm font-bold"
                        >
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-surface-400">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </form>
                </header>

                <div class="divide-y divide-surface-100 dark:divide-surface-800">
                    @forelse ($posts as $post)
                        {{-- Skip the first post on page 1 if not searching, as it's featured above --}}
                        @if(!$query && $posts->currentPage() == 1 && $loop->first)
                            @continue
                        @endif
                        <x-post-card :post="$post" />
                    @empty
                        <div class="py-24 text-center bg-surface-50 dark:bg-surface-900/50 rounded-[2rem] border border-dashed border-surface-200 dark:border-surface-800">
                            <div class="w-16 h-16 bg-surface-100 dark:bg-surface-800 rounded-2xl flex items-center justify-center mx-auto mb-6 text-surface-400">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                            </div>
                            <p class="text-xl font-bold text-surface-900 dark:text-white mb-2">No stories found</p>
                            <p class="text-surface-500 dark:text-surface-400 mb-8 font-medium">Try adjusting your search or check back later.</p>
                            @if($query)
                                <a href="{{ route('home') }}" class="px-6 py-3 bg-brand text-white font-black text-xs uppercase tracking-widest rounded-full hover:opacity-90 transition-opacity inline-block">Clear search</a>
                            @endif
                        </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $posts->links() }}
                </div>
            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-16">
                {{-- Trending Section --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-black text-surface-900 dark:text-white uppercase tracking-wider">
                            Trending
                        </h3>
                        <div class="h-px flex-1 bg-surface-100 dark:bg-surface-800 ml-4"></div>
                    </div>
                    <div class="space-y-10">
                        @foreach($trendingPosts as $index => $trending)
                            <x-trending-post-card :post="$trending" :index="$index" />
                        @endforeach
                    </div>
                </section>

                {{-- Recommended Topics --}}
                <section class="bg-surface-50 dark:bg-surface-900/50 p-8 rounded-[2rem] border border-surface-100 dark:border-surface-800">
                    <h3 class="text-sm font-black text-surface-900 dark:text-white uppercase tracking-widest mb-6">Topics to explore</h3>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach(\App\Models\Category::all() as $category)
                            <a href="{{ route('category.show', $category) }}" class="px-4 py-2 bg-white dark:bg-surface-950 text-surface-800 dark:text-surface-200 text-xs font-black uppercase tracking-wider rounded-xl border border-surface-100 dark:border-surface-800 hover:border-brand hover:text-brand dark:hover:border-brand dark:hover:text-brand transition-all shadow-sm">
                                {{ $category->name }}
                            </a>
                        @endforeach
                    </div>
                </section>

                {{-- Newsletter Card --}}
                <section class="bg-surface-900 dark:bg-white p-10 rounded-[2rem] relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-brand/20 rounded-full blur-3xl group-hover:scale-150 transition-transform duration-700"></div>
                    <div class="relative z-10">
                        <h3 class="text-2xl font-black text-white dark:text-surface-900 mb-4 leading-tight">Get the best stories in your inbox.</h3>
                        <p class="text-surface-400 dark:text-surface-500 text-sm font-medium mb-8">Join 10,000+ readers and never miss an update.</p>
                        <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                            @csrf
                            <input 
                                type="email" 
                                name="email" 
                                placeholder="Your email address" 
                                class="w-full px-5 py-4 bg-surface-800 dark:bg-surface-50 border-none rounded-2xl text-white dark:text-surface-900 placeholder-surface-500 dark:placeholder-surface-400 font-bold text-sm focus:ring-2 focus:ring-brand"
                                required
                            >
                            <x-form.button type="submit" class="w-full" size="lg">
                                Join the Inner Circle
                            </x-form.button>
                        </form>
                    </div>
                </section>

                {{-- Trending Tags --}}
                <section>
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-lg font-black text-surface-900 dark:text-white uppercase tracking-wider">
                            Popular Tags
                        </h3>
                        <div class="h-px flex-1 bg-surface-100 dark:bg-surface-800 ml-4"></div>
                    </div>
                    <div class="flex flex-wrap gap-x-6 gap-y-4">
                        @foreach(\App\Models\Tag::take(10)->get() as $tag)
                            <a href="{{ route('tag.show', $tag) }}" class="text-sm font-bold text-surface-500 hover:text-brand transition-colors flex items-center gap-1.5">
                                <span class="text-surface-300">#</span>{{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                </section>
            </aside>

        </div>
    </div>
</x-layout>
