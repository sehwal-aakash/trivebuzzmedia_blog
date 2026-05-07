<x-layout :seoTags="$seoTags">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <header class="mb-16">
            <div class="flex items-center gap-4 mb-4">
                <span class="text-sm font-black text-brand uppercase tracking-widest">Topic</span>
                <div class="h-px w-12 bg-surface-100 dark:bg-surface-800"></div>
            </div>
            <h1 class="text-5xl md:text-7xl font-black text-surface-900 dark:text-white mb-6 tracking-tight">
                {{ $category->name }}
            </h1>
            @if($category->description)
                <p class="text-xl text-surface-500 dark:text-surface-400 max-w-2xl font-medium leading-relaxed">
                    {{ $category->description }}
                </p>
            @endif
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">
            <div class="lg:col-span-8">
                <div class="divide-y divide-surface-100 dark:divide-surface-800">
                    @forelse($posts as $post)
                        <x-post-card :post="$post" />
                    @empty
                        <div class="py-24 text-center bg-surface-50 dark:bg-surface-900/50 rounded-[2rem] border border-dashed border-surface-200 dark:border-surface-800">
                            <p class="text-xl font-bold text-surface-900 dark:text-white">No stories yet</p>
                            <p class="text-surface-500 font-medium mt-2">There are no stories published in this topic yet.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $posts->links() }}
                </div>
            </div>

            <aside class="lg:col-span-4">
                <div class="sticky top-32 space-y-12">
                    <section>
                        <h3 class="text-sm font-black text-surface-900 dark:text-white uppercase tracking-widest mb-6">Other Topics</h3>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach(\App\Models\Category::where('id', '!=', $category->id)->get() as $other)
                                <a href="{{ route('category.show', $other) }}" class="px-4 py-2 bg-white dark:bg-surface-950 text-surface-800 dark:text-surface-200 text-xs font-black uppercase tracking-wider rounded-xl border border-surface-100 dark:border-surface-800 hover:border-brand hover:text-brand dark:hover:border-brand dark:hover:text-brand transition-all shadow-sm">
                                    {{ $other->name }}
                                </a>
                            @endforeach
                        </div>
                    </section>
                </div>
            </aside>
        </div>
    </div>
</x-layout>
