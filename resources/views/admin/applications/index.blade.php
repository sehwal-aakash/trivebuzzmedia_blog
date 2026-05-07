<x-layout>
    <x-slot:title>
        Admin: Author Applications - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Author Applications</h1>
            <a href="{{ route('admin.posts.index') }}" class="text-sm text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                &larr; Back to all posts
            </a>
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
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Applied At</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($applications as $application)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-zinc-900 dark:text-white">{{ $application->user->name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $application->user->email }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full {{ $application->status->value === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($application->status->value === 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400') }}">
                                        {{ $application->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500 dark:text-zinc-500">
                                    {{ $application->created_at->format('Y-m-d H:i') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('admin.applications.show', $application) }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 text-sm font-medium">Review</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400 italic">
                                    No applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($applications->hasPages())
                <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                    {{ $applications->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layout>
