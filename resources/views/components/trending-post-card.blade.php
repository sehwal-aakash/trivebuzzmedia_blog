@props(['post', 'index'])

<div class="flex gap-4 group items-start p-3 rounded-xl hover:bg-slate-100/60 dark:hover:bg-slate-800/50 transition-colors">
    <span class="text-2xl font-black text-slate-300 dark:text-slate-700 leading-none group-hover:text-[#3c83f6] transition-colors">0{{ $index + 1 }}</span>
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-1.5">
            <div class="w-5 h-5 rounded-full bg-gradient-to-tr from-[#0f1729] to-[#3c83f6] text-white flex items-center justify-center text-[8px] font-bold shadow-xs">
                {{ substr($post->author->name, 0, 1) }}
            </div>
            <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-xs font-bold text-[#0f1729] dark:text-slate-300 hover:text-[#3c83f6] transition-colors">
                {{ $post->author->name }}
            </a>
        </div>
        <h4 class="text-sm font-extrabold text-[#0f1729] dark:text-white leading-snug group-hover:text-[#3c83f6] transition-colors">
            <a href="{{ route('posts.show', $post->slug) }}">{{ $post->title }}</a>
        </h4>
        <div class="text-[11px] font-semibold text-slate-400 mt-2 flex items-center gap-2">
            <span>{{ $post->published_at?->format('M d') }}</span>
            <span>&bull;</span>
            <span>{{ $post->reading_time }} min read</span>
        </div>
    </div>
</div>

