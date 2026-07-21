<x-admin-layout title="Manage All Posts">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Posts Repository</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Manage, review and moderate all platform stories</p>
            </div>
            <a href="{{ route('author.posts.create') }}" class="px-4 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-blue-500/20 inline-flex items-center gap-1.5 self-start md:self-auto">
                + Create New Post
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Title / Author</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Published At</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($posts as $post)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100 hover:text-[#3c83f6] transition-colors line-clamp-1">
                                    {{ $post->title }}
                                </a>
                                <div class="text-xs font-medium text-slate-400 mt-0.5">by {{ $post->author->name }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-extrabold uppercase tracking-wider text-[#16a249] bg-emerald-50 dark:bg-emerald-950/40 rounded-lg border border-emerald-200/40 dark:border-emerald-800/40">
                                    {{ $post->category->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $post->status->value === 'published' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : 'bg-amber-50 text-amber-600 dark:bg-amber-950/50' }}">
                                    {{ $post->status->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ $post->published_at?->format('M d, Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.posts.edit', $post) }}" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-[#3c83f6] hover:text-white dark:hover:bg-[#3c83f6] text-[#0f1729] dark:text-slate-200 text-xs font-bold rounded-lg transition-all inline-block">Edit</a>
                                <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-lg transition-all">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No posts found in the system.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($posts->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

