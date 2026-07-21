<x-admin-layout title="Moderate Comments">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Community Comments</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Review, approve and moderate user responses on stories</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Comment & Author</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Target Story</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($comments as $comment)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 max-w-md">
                                <div class="text-xs font-bold text-[#0f1729] dark:text-slate-200 mb-1">
                                    by {{ $comment->user ? $comment->user->name : $comment->guest_name }} &bull; <span class="text-slate-400 font-normal">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <div class="text-sm text-[#344256] dark:text-slate-300 line-clamp-2 leading-relaxed font-normal">{{ $comment->content }}</div>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <a href="{{ route('posts.show', $comment->post->slug) }}" class="text-xs font-extrabold text-[#3c83f6] hover:underline line-clamp-1">
                                    "{{ $comment->post->title }}"
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg 
                                    {{ $comment->status->value === 'approved' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : 
                                       ($comment->status->value === 'pending' ? 'bg-amber-50 text-amber-600 dark:bg-amber-950/50' : 'bg-rose-50 text-rose-600 dark:bg-rose-950/50') }}">
                                    {{ $comment->status->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                @if($comment->status->value === 'pending')
                                    <form action="{{ route('admin.comments.approve', $comment) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold rounded-lg transition-all shadow-xs">Approve</button>
                                    </form>
                                    <form action="{{ route('admin.comments.reject', $comment) }}" method="POST" class="inline-block">
                                        @csrf
                                        <button type="submit" class="px-3 py-1.5 bg-amber-500 hover:bg-amber-600 text-white text-xs font-bold rounded-lg transition-all shadow-xs">Reject</button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.comments.destroy', $comment) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-lg transition-all">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No comments found to display.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($comments->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $comments->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

