<x-layout :seoTags="$seoTags">
    <article class="max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl mx-auto">
            {{-- Category & Reading Time --}}
            <div class="flex items-center gap-4 mb-8">
                <a href="{{ route('category.show', $post->category) }}" class="px-4 py-1.5 bg-brand/10 text-brand text-xs font-black uppercase tracking-widest rounded-full hover:bg-brand hover:text-white transition-all">
                    {{ $post->category->name }}
                </a>
                <span class="text-surface-400 text-sm font-bold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ $post->reading_time }} min read
                </span>
            </div>
            
            <h1 class="text-4xl md:text-4xl font-bold text-surface-900 dark:text-white mb-10 leading-[1.25]">
                {{ $post->title }}
            </h1>

            <div class="flex items-center justify-between py-8 border-y border-surface-100 dark:border-surface-800 mb-16">
                <div class="flex items-center gap-4">
                    <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="w-14 h-14 rounded-full bg-surface-200 dark:bg-surface-800 flex items-center justify-center font-black text-surface-500 text-xl border-2 border-surface-100 dark:border-surface-700 hover:border-brand transition-all">
                        {{ substr($post->author->name, 0, 1) }}
                    </a>
                    <div>
                        <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-lg font-black text-surface-900 dark:text-white hover:text-brand transition-colors">
                            {{ $post->author->name }}
                        </a>
                        <div class="text-sm font-bold text-surface-500 mt-0.5">
                            Published on {{ $post->published_at?->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <button class="w-10 h-10 rounded-full border border-surface-200 dark:border-surface-800 flex items-center justify-center text-surface-400 hover:text-brand hover:border-brand transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                    </button>
                    @auth
                        <form action="{{ route('posts.bookmark', $post) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-10 h-10 rounded-full border {{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'bg-brand text-white border-brand' : 'border-surface-200 dark:border-surface-800 text-surface-400' }} flex items-center justify-center hover:text-brand hover:border-brand transition-all">
                                <svg class="w-5 h-5" fill="{{ auth()->user()->bookmarkedPosts()->where('post_id', $post->id)->exists() ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="w-10 h-10 rounded-full border border-surface-200 dark:border-surface-800 flex items-center justify-center text-surface-400 hover:text-brand hover:border-brand transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                            </svg>
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        @if($post->featured_image)
            <div class="max-w-6xl mx-auto mb-20">
                <div class="relative group">
                    <div class="absolute -inset-4 bg-brand/5 rounded-[3rem] blur-3xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" class="relative w-full aspect-[21/9] object-cover rounded-[2rem] shadow-2xl border border-surface-100 dark:border-surface-800">
                </div>
            </div>
        @endif
<div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-16">
    {{-- Table of Contents (Sidebar) --}}
    <aside class="hidden lg:block lg:w-64 shrink-0">
        <div class="sticky top-32 space-y-8">
            <div x-data="{ 
                headings: [],
                init() {
                    const elements = Array.from(document.querySelectorAll('.post-content h2, .post-content h3'));
                    this.headings = elements.map(h => ({
                        text: h.innerText,
                        id: h.id || h.innerText.toLowerCase().replace(/[^a-z0-9]+/g, '-')
                    }));
                    this.headings.forEach((h, i) => {
                        elements[i].id = h.id;
                    });
                }
            }" x-show="headings.length > 0">
                <h3 class="text-xs font-black uppercase tracking-widest text-surface-400 mb-6">Table of Contents</h3>
                <nav class="space-y-4">
                    <template x-for="heading in headings" :key="heading.id">
                        <a :href="'#' + heading.id" class="block text-sm font-bold text-surface-500 hover:text-brand transition-colors" x-text="heading.text"></a>
                    </template>
                </nav>
            </div>

            {{-- Sidebar Ad Placeholder --}}
            <div class="p-6 bg-surface-100 dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 text-center">
                <div class="text-[10px] font-black text-surface-400 uppercase tracking-widest mb-4">Advertisement</div>
                <div class="aspect-[4/5] bg-surface-200 dark:bg-surface-800 rounded-xl flex items-center justify-center border border-dashed border-surface-300 dark:border-surface-700">
                    <span class="text-xs font-bold text-surface-400">Ad Space</span>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1">
        <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 md:p-10 shadow-xs mb-16">
            <div class="post-content prose prose-lg md:prose-xl max-w-none">
                {!! $post->content !!}
            </div>
        </div>

        {{-- Sponsored Footer --}}
        @if($post->is_sponsored && $post->affiliate_link)
            <div class="p-8 bg-brand/5 dark:bg-brand/10 rounded-[2rem] border border-brand/20 mb-16">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-10 h-10 rounded-full bg-brand text-white flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <h4 class="text-xl font-black text-surface-900 dark:text-white uppercase tracking-tighter">Partner Spotlight</h4>
                </div>
                <p class="text-surface-600 dark:text-surface-400 font-medium mb-6 leading-relaxed">This article was brought to you in partnership with our sponsors. Check out their latest offerings below.</p>
                <a href="{{ $post->affiliate_link }}" target="_blank" rel="nofollow sponsored" class="inline-flex items-center gap-2 px-8 py-4 bg-brand text-white rounded-full font-black text-sm uppercase tracking-widest hover:bg-brand-dark transition-all">
                    Visit Sponsor
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </a>
            </div>
        @endif

        @if($post->tags->count() > 0)
...
                <div class="flex flex-wrap gap-3 mb-24 pb-16 border-b border-surface-100 dark:border-surface-800">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('tag.show', $tag) }}" class="px-5 py-2.5 bg-surface-50 dark:bg-surface-900 text-surface-600 dark:text-surface-400 text-sm font-black uppercase tracking-widest rounded-full hover:bg-brand hover:text-white dark:hover:bg-brand transition-all border border-surface-100 dark:border-surface-800">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            <section id="responses" class="mt-16">
                <div class="flex items-center justify-between mb-12">
                    <h3 class="text-3xl font-black text-surface-900 dark:text-white">
                        Responses <span class="text-surface-400 text-xl font-bold ml-2">({{ $post->comments->count() }})</span>
                    </h3>
                </div>

                {{-- Comment Form --}}
                @auth
                    <div class="mb-16 bg-surface-50 dark:bg-surface-900/50 rounded-[2rem] p-8 border border-surface-100 dark:border-surface-800">
                        <form action="{{ route('comments.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="post_id" value="{{ $post->id }}">
                            <div class="flex gap-4 mb-6">
                                <div class="w-10 h-10 rounded-full bg-brand/10 dark:bg-brand-light/10 flex items-center justify-center font-black text-brand text-xs uppercase">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <div class="flex-1">
                                    <div class="font-black text-surface-900 dark:text-white text-sm mb-1">{{ auth()->user()->name }}</div>
                                    <div class="text-[10px] font-bold text-surface-400 uppercase tracking-widest">Writing as author</div>
                                </div>
                            </div>
                            <textarea
                                id="content"
                                name="content"
                                rows="4"
                                class="block w-full border-surface-200 dark:border-surface-800 rounded-2xl focus:ring-brand focus:border-brand sm:text-lg dark:bg-surface-950 dark:text-white p-6 placeholder-surface-400 font-medium"
                                placeholder="What are your thoughts?"
                                required
                            ></textarea>
                            <div class="mt-6 flex justify-end">
                                <x-form.button type="submit" size="lg">
                                    Post Comment
                                </x-form.button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-surface-50 dark:bg-surface-900/50 rounded-[2rem] p-12 mb-16 border border-dashed border-surface-200 dark:border-surface-800 text-center">
                        <div class="w-16 h-16 bg-white dark:bg-surface-950 rounded-2xl flex items-center justify-center mx-auto mb-6 text-brand shadow-sm">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                        <h4 class="text-xl font-black text-surface-900 dark:text-white mb-2">Join the conversation</h4>
                        <p class="text-surface-500 dark:text-surface-400 mb-8 font-medium">Log in to share your thoughts on this story.</p>
                        <x-form.button href="{{ route('login') }}" tag="a" size="lg">
                            Sign In to Respond
                        </x-form.button>
                    </div>
                @endauth

                {{-- Comments List --}}
                <div class="space-y-12">
                    @forelse($post->comments as $comment)
                        <div class="group">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-10 h-10 rounded-full bg-surface-100 dark:bg-surface-800 flex items-center justify-center font-black text-surface-400 text-xs border border-surface-200 dark:border-surface-700">
                                    {{ substr($comment->user ? $comment->user->name : $comment->guest_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-black text-surface-900 dark:text-white text-sm">
                                        {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                                    </div>
                                    <div class="text-xs font-bold text-surface-400 uppercase tracking-tighter">
                                        {{ $comment->created_at->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                            <div class="text-surface-700 dark:text-surface-300 text-lg leading-relaxed pl-14 font-medium">
                                {{ $comment->content }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-12">
                            <p class="text-surface-400 font-bold italic">Be the first to share your thoughts.</p>
                        </div>
                    @endforelse
                </div>
            </section>
        </div>

        {{-- More from TriveBuzz --}}
        @if($relatedPosts->count() > 0)
            <section class="mt-32 pt-24 border-t border-surface-100 dark:border-surface-800">
                <div class="flex items-center justify-between mb-10">
                    <h3 class="text-2xl md:text-3xl font-black text-[#0f1729] dark:text-white tracking-tight">Recommended Stories</h3>
                    <div class="h-px flex-1 bg-slate-200 dark:bg-slate-800 ml-8"></div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @foreach($relatedPosts as $related)
                        @php
                            $hasRelatedImg = !empty($related->featured_image);
                            $relatedImgUrl = $hasRelatedImg ? (str_starts_with($related->featured_image, 'http') ? $related->featured_image : Storage::url($related->featured_image)) : null;
                        @endphp
                        <article class="group rounded-2xl bg-white dark:bg-[#0f1729] border border-slate-200/80 dark:border-slate-800 p-5 shadow-sm hover:shadow-xl hover:border-[#3c83f6]/40 transition-all duration-300 flex flex-col justify-between">
                            <div>
                                @if($hasRelatedImg)
                                    <a href="{{ route('posts.show', $related->slug) }}" class="block overflow-hidden rounded-xl mb-4 border border-slate-200/60 dark:border-slate-800">
                                        <img 
                                            src="{{ $relatedImgUrl }}" 
                                            alt="{{ $related->title }}" 
                                            onerror="this.onerror=null; this.parentElement.style.display='none';"
                                            class="w-full aspect-video object-cover transform group-hover:scale-105 transition-transform duration-500"
                                        >
                                    </a>
                                @endif
                                <div class="flex items-center gap-2 mb-3">
                                    <div class="w-6 h-6 rounded-lg bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center text-[10px] font-bold shadow-xs">
                                        {{ substr($related->author->name, 0, 1) }}
                                    </div>
                                    <span class="text-xs font-bold text-[#0f1729] dark:text-slate-200 truncate">{{ $related->author->name }}</span>
                                    <span class="text-slate-300 dark:text-slate-700">&bull;</span>
                                    <span class="text-[11px] font-semibold text-slate-400">{{ $related->reading_time }}m</span>
                                </div>
                                <h4 class="text-lg font-black text-[#0f1729] dark:text-white leading-snug group-hover:text-[#3c83f6] transition-colors mb-4 font-sans line-clamp-2">
                                    <a href="{{ route('posts.show', $related->slug) }}">{{ $related->title }}</a>
                                </h4>
                            </div>
                            <div class="pt-3 border-t border-slate-100 dark:border-slate-800/80 flex items-center justify-between">
                                <a href="{{ route('category.show', $related->category) }}" class="text-[10px] font-extrabold uppercase tracking-wider text-[#16a249] bg-emerald-50 dark:bg-emerald-950/40 px-2.5 py-1 rounded-md border border-emerald-200/40 dark:border-emerald-800/40">
                                    {{ $related->category->name }}
                                </a>
                                <span class="text-xs font-bold text-[#3c83f6] group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                                    Read &rarr;
                                </span>
                            </div>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif
    </article>
</x-layout>
