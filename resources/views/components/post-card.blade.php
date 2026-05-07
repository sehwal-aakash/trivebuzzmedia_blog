@props(['post'])

<article class="group grid grid-cols-1 md:grid-cols-12 gap-6 items-start py-8 first:pt-0 border-b border-surface-100 dark:border-surface-800 last:border-0">
    <div class="md:col-span-8 order-2 md:order-1">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-7 h-7 rounded-full bg-surface-200 dark:bg-surface-800 flex items-center justify-center text-[10px] font-bold text-surface-600 dark:text-surface-400 border border-surface-100 dark:border-surface-700">
                {{ substr($post->author->name, 0, 1) }}
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-sm font-bold text-surface-900 dark:text-surface-100 hover:text-brand transition-colors">
                    {{ $post->author->name }}
                </a>
                <span class="text-surface-300 dark:text-surface-700">&bull;</span>
                <time datetime="{{ $post->published_at?->toW3cString() }}" class="text-xs font-medium text-surface-500">
                    {{ $post->published_at?->format('M d, Y') }}
                </time>
            </div>
        </div>

        <h2 class="text-2xl font-black text-surface-900 dark:text-white mb-3 leading-tight tracking-tight group-hover:text-brand transition-colors">
            <a href="{{ route('posts.show', $post->slug) }}">
                {{ $post->title }}
            </a>
        </h2>

        <p class="text-surface-600 dark:text-surface-400 text-base line-clamp-2 mb-6 font-medium leading-relaxed">
            {{ $post->excerpt }}
        </p>

        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('category.show', $post->category) }}" class="px-3 py-1 bg-surface-100 dark:bg-surface-800/50 text-surface-600 dark:text-surface-400 text-[10px] font-black uppercase tracking-widest rounded-full hover:bg-brand hover:text-white dark:hover:bg-brand transition-all">
                    {{ $post->category->name }}
                </a>
                <span class="text-xs font-bold text-surface-400">{{ $post->reading_time }} min read</span>
                @if($post->is_sponsored)
                    <span class="flex items-center gap-1 text-[10px] font-black text-brand uppercase tracking-tighter">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Sponsored
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2">
                @auth
                    <form action="{{ route('posts.bookmark', $post) }}" method="POST">
                        @csrf
                        <button type="submit" class="transition-colors {{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'text-brand' : 'text-surface-400 hover:text-surface-900 dark:hover:text-white' }}">
                            <svg class="w-5 h-5" fill="{{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-surface-400 hover:text-surface-900 dark:hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                        </svg>
                    </a>
                @endauth
            </div>
        </div>
    </div>

    @if($post->featured_image)
        <div class="md:col-span-4 order-1 md:order-2">
            <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden rounded-2xl shadow-sm border border-surface-100 dark:border-surface-800">
                <img 
                    src="{{ Storage::url($post->featured_image) }}" 
                    alt="{{ $post->title }}" 
                    class="w-full aspect-[4/3] object-cover transform group-hover:scale-105 transition-transform duration-500"
                >
            </a>
        </div>
    @endif
</article>
