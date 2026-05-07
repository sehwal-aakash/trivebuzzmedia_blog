<x-layout>
    <x-slot:title>
        Admin: Manage All Posts - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">All Posts</h1>
            <div class="flex gap-4">
                <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Review Applications
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-400 rounded-md text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Title / Author</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Published At</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($posts as $post)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $post->title }}</div>
                                    <div class="text-xs text-zinc-500">by {{ $post->author->name }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-xs text-zinc-600 dark:text-zinc-400">{{ $post->category->name }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $post->status->value === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400' }}">
                                        {{ $post->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-500">
                                    {{ $post->published_at?->format('Y-m-d') ?? '-' }}
                                </td>
                                <td class="px-6 py-4 text-right space-x-3">
                                    <a href="{{ route('admin.posts.edit', $post) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 text-sm font-medium">Edit</a>
                                    <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-500 text-sm font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400 italic">
                                    No posts found in the system.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($posts->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
