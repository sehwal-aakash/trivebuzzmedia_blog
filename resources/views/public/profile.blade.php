<x-layout :seoTags="$seoTags">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-4xl mx-auto">
            <header class="mb-16 text-center">
                <div class="w-24 h-24 rounded-[2rem] bg-brand/10 dark:bg-brand-light/10 flex items-center justify-center font-black text-brand text-4xl mx-auto mb-8 shadow-xl shadow-brand/10 border-2 border-brand/20">
                    {{ substr($user->name, 0, 1) }}
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-surface-900 dark:text-white mb-4 tracking-tight">
                    {{ $user->name }}
                </h1>
                <p class="text-surface-500 dark:text-surface-400 font-bold uppercase tracking-widest text-sm mb-6">
                    {{ $user->role->label() }} &bull; {{ $posts->total() }} Stories
                </p>
                <div class="flex items-center justify-center gap-4">
                    <x-form.button size="sm" class="px-8">
                        Follow
                    </x-form.button>
                    <button class="w-10 h-10 rounded-full border border-surface-200 dark:border-surface-800 flex items-center justify-center text-surface-400 hover:text-brand hover:border-brand transition-all">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.84 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                    </button>
                </div>
            </header>

            <div class="space-y-4">
                <div class="flex items-center justify-between border-b border-surface-100 dark:border-surface-800 pb-4 mb-8">
                    <h2 class="text-sm font-black text-surface-900 dark:text-white uppercase tracking-widest">Stories</h2>
                    <div class="h-px flex-1 bg-surface-100 dark:bg-surface-800 ml-8"></div>
                </div>

                <div class="divide-y divide-surface-100 dark:divide-surface-800">
                    @forelse($posts as $post)
                        <x-post-card :post="$post" />
                    @empty
                        <div class="py-24 text-center bg-surface-50 dark:bg-surface-900/50 rounded-[2rem] border border-dashed border-surface-200 dark:border-surface-800">
                            <p class="text-xl font-bold text-surface-900 dark:text-white">No stories yet</p>
                            <p class="text-surface-500 font-medium mt-2">This author hasn't published any stories yet.</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $posts->links() }}
                </div>
            </div>
        </div>
    </div>
</x-layout>
