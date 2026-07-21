@props(['post'])

@php
    $hasImage = !empty($post->featured_image);
    $imageUrl = $hasImage ? (str_starts_with($post->featured_image, 'http') ? $post->featured_image : Storage::url($post->featured_image)) : null;
@endphp

<article class="group relative rounded-2xl bg-white dark:bg-[#0f1729] border border-slate-200/80 dark:border-slate-800/80 p-6 shadow-sm hover:shadow-xl hover:border-[#3c83f6]/40 transition-all duration-300 transform hover:-translate-y-0.5 overflow-hidden mb-6">
    {{-- Hover Gradient Top Highlight Bar --}}
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-[#3c83f6] to-[#16a249] opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
        {{-- Text Content Column --}}
        <div class="{{ $hasImage ? 'md:col-span-8 order-2 md:order-1' : 'md:col-span-12' }}">
            {{-- Author Header --}}
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0f1729] via-[#1e293b] to-[#3c83f6] text-white flex items-center justify-center font-extrabold text-xs shadow-sm border border-slate-700/30">
                        {{ substr($post->author->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-2">
                        <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100 hover:text-[#3c83f6] dark:hover:text-[#3c83f6] transition-colors leading-tight">
                            {{ $post->author->name }}
                        </a>
                        <span class="hidden sm:inline text-slate-300 dark:text-slate-700">&bull;</span>
                        <time datetime="{{ $post->published_at?->toW3cString() }}" class="text-xs font-semibold text-slate-400">
                            {{ $post->published_at?->format('M d, Y') }}
                        </time>
                    </div>
                </div>

                @if($post->is_sponsored)
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider text-[#16a249] bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200/60 dark:border-emerald-800/60 rounded-full">
                        <svg class="w-3 h-3 text-[#16a249]" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        Sponsored
                    </span>
                @endif
            </div>

            {{-- Post Title --}}
            <h2 class="text-xl md:text-2xl font-black text-[#0f1729] dark:text-white mb-2.5 leading-snug tracking-tight group-hover:text-[#3c83f6] transition-colors font-sans">
                <a href="{{ route('posts.show', $post->slug) }}" class="focus:outline-none">
                    {{ $post->title }}
                </a>
            </h2>

            {{-- Post Excerpt --}}
            <p class="text-[#344256] dark:text-slate-300 text-sm md:text-base line-clamp-2 mb-6 font-normal leading-relaxed">
                {{ $post->excerpt }}
            </p>

            {{-- Post Footer / Meta Bar --}}
            <div class="flex items-center justify-between pt-2 border-t border-slate-100 dark:border-slate-800/80">
                <div class="flex items-center gap-3 flex-wrap">
                    <a href="{{ route('category.show', $post->category) }}" class="px-3 py-1 bg-emerald-50 dark:bg-emerald-950/40 text-[#16a249] dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/50 text-[10px] font-extrabold uppercase tracking-wider rounded-lg hover:bg-[#16a249] hover:text-white transition-all">
                        {{ $post->category->name }}
                    </a>
                    <span class="text-xs font-semibold text-slate-400 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        {{ $post->reading_time }} min read
                    </span>
                </div>

                <div class="flex items-center gap-2">
                    @auth
                        <form action="{{ route('posts.bookmark', $post) }}" method="POST">
                            @csrf
                            <button type="submit" title="Bookmark story" class="p-2 rounded-xl hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors {{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'text-[#3c83f6]' : 'text-slate-400 hover:text-[#3c83f6]' }}">
                                <svg class="w-5 h-5" fill="{{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" title="Sign in to bookmark" class="p-2 text-slate-400 hover:text-[#3c83f6] hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Featured Image Column --}}
        @if($hasImage)
            <div class="md:col-span-4 order-1 md:order-2 w-full">
                <a href="{{ route('posts.show', $post->slug) }}" class="block overflow-hidden rounded-xl border border-slate-200/80 dark:border-slate-800 shadow-sm group-hover:shadow-md transition-all">
                    <img 
                        src="{{ $imageUrl }}" 
                        alt="{{ $post->title }}" 
                        onerror="this.onerror=null; this.closest('.md\\:col-span-4').style.display='none';"
                        class="w-full aspect-[4/3] object-cover transform group-hover:scale-105 transition-transform duration-500"
                    >
                </a>
            </div>
        @endif
    </div>
</article>


