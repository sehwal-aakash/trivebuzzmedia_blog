@props(['post'])

<article class="group grid grid-cols-1 md:grid-cols-12 gap-6 items-start p-6 rounded-2xl bg-white/70 dark:bg-[#0f1729]/70 border border-slate-200/70 dark:border-slate-800/80 shadow-sm hover:shadow-xl hover:border-[#3c83f6]/40 transition-all duration-300 backdrop-blur-sm mb-6">
    <div class="md:col-span-8 order-2 md:order-1">
        <div class="flex items-center gap-3 mb-3">
            <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center text-xs font-bold shadow-sm">
                {{ substr($post->author->name, 0, 1) }}
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-sm font-bold text-[#0f1729] dark:text-slate-200 hover:text-[#3c83f6] transition-colors">
                    {{ $post->author->name }}
                </a>
                <span class="text-slate-300 dark:text-slate-700">&bull;</span>
                <time datetime="{{ $post->published_at?->toW3cString() }}" class="text-xs font-medium text-slate-400">
                    {{ $post->published_at?->format('M d, Y') }}
                </time>
            </div>
        </div>

        <h2 class="text-xl md:text-2xl font-black text-[#0f1729] dark:text-white mb-2 leading-tight tracking-tight group-hover:text-[#3c83f6] transition-colors font-sans">
            <a href="{{ route('posts.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h2>

        <p class="text-[#344256] dark:text-slate-400 text-sm md:text-base line-clamp-2 mb-5 font-normal leading-relaxed">
            {{ $post->excerpt }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 flex-wrap">
                <a href="{{ route('category.show', $post->category) }}" class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/30 text-[#16a249] border border-emerald-200/50 dark:border-emerald-800/40 text-[10px] font-extrabold uppercase tracking-wider rounded-lg hover:bg-[#16a249] hover:text-white transition-all">
                    {{ $post->category->name }}
                </a>
                <span class="text-xs font-semibold text-slate-400 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $post->reading_time }} min read
                </span>
                @if($post->is_sponsored)
                    <span class="flex items-center gap-1 text-[10px] font-extrabold text-[#16a249] bg-emerald-100/60 dark:bg-emerald-900/30 px-2 py-0.5 rounded-full uppercase tracking-tighter">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Sponsored
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <form action="{{ route('posts.bookmark', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'text-[#3c83f6]' : 'text-slate-400 hover:text-[#3c83f6]' }}">
                            <svg class="w-5 h-5" fill="{{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="p-2 text-slate-400 hover:text-[#3c83f6] hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    @if($post->featured_image)
        <div class="md:col-span-4 order-1 md:order-2 w-full">
            <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden rounded-xl border border-slate-200/60 dark:border-slate-800 shadow-sm">
                <img 
                    src="{{ Storage::url($post->featured_image) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full aspect-[4/3] object-cover transform group-hover:scale-105 transition-transform duration-500"
                >
            </a>
        </div>
    @endif
</article>

