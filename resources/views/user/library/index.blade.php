<x-layout>
    <x-slot:title>
        My Library - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <h1 class="text-4xl font-black text-surface-900 dark:text-white uppercase tracking-tight">My Library</h1>
            <p class="text-surface-500 dark:text-surface-400 mt-2">Stories you've bookmarked for later reading.</p>
        </div>

        @if($posts->isEmpty())
            <div class="bg-white dark:bg-surface-900 rounded-2xl border border-surface-200 dark:border-surface-800 p-12 text-center">
                <div class="w-16 h-16 bg-surface-100 dark:bg-surface-800 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-surface-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-surface-900 dark:text-white">Your library is empty</h2>
                <p class="text-surface-500 dark:text-surface-400 mt-2 mb-6">Start exploring stories and bookmark them to read later.</p>
                <x-form.button href="{{ route('home') }}" tag="a" variant="primary" size="lg">
                    Explore Stories
                </x-form.button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($posts as $post)
                    <x-post-card :post="$post" />
                @endforeach
            </div>

            <div class="mt-12">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-layout>
