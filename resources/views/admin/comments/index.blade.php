<x-layout>
    <x-slot:title>
        Admin: Manage Comments - {{ config('app.name') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-8">Comments</h1>

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
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Comment</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Post</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach($comments as $comment)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-xs text-zinc-500 mb-1">by {{ $comment->user ? $comment->user->name : $comment->guest_name }} &bull; {{ $comment->created_at->diffForHumans() }}</div>
                                    <div class="text-sm text-zinc-900 dark:text-zinc-200 line-clamp-2">{{ $comment->content }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-zinc-600 dark:text-zinc-400 italic">"{{ $comment->post->title }}"</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full 
                                        {{ $comment->status->value === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : 
                                           ($comment->status->value === 'pending' ? 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-400' : 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400') }}">
                                        {{ $comment->status->value }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    @if($comment->status->value === 'pending')
                                        <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-green-600 dark:text-green-400 hover:text-green-500 text-sm font-medium">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline-block">
                                            @csrf
                                            <button type="submit" class="text-amber-600 dark:text-amber-400 hover:text-amber-500 text-sm font-medium">Reject</button>
                                        </form>
                                    @endif
                                    <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-500 text-sm font-medium">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $comments->links() }}
            </div>
        </div>
    </div>
</x-layout>
