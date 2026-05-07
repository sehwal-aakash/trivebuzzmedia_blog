@props(['post', 'index'])

<div class="flex gap-5 group">
    <span class="text-3xl font-black text-surface-100 dark:text-surface-800 leading-none">0{{ $index + 1 }}</span>
    <div class="flex-1">
        <div class="flex items-center gap-2 mb-2">
            <div class="w-5 h-5 rounded-full bg-surface-200 dark:bg-surface-800 flex items-center justify-center text-[8px] font-bold text-surface-500 border border-surface-100 dark:border-surface-700">
                {{ substr($post->author->name, 0, 1) }}
            </div>
            <a href="{{ route('profile', ['user' => $post->author->username]) }}" class="text-[10px] font-black text-surface-900 dark:text-surface-200 hover:text-brand transition-colors">
                {{ $post->author->name }}
            </a>
        </div>
        <h4 class="text-sm font-black text-surface-900 dark:text-white leading-tight group-hover:text-brand transition-colors">
            <a href="{{ route('posts.show', $post->slug) }}" class="hover:underline">{{ $post->title }}</a>
        </h4>
        <div class="text-[10px] font-bold text-surface-400 mt-2 flex items-center gap-2">
            <span>{{ $post->published_at?->format('M d') }}</span>
            <span>&bull;</span>
            <span>{{ $post->reading_time }} min read</span>
        </div>
    </div>
</div>
