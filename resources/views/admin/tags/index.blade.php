<x-admin-layout title="Manage Tags">

    <div class="bg-white dark:bg-[#0f1729] rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Hashtags & Keywords</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Manage platform topic tags, pill badge styling, trending status, and SEO settings.</p>
            </div>
            <a href="{{ route('admin.tags.create') }}" class="px-5 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all shadow-md shadow-blue-500/20 inline-flex items-center gap-2 self-start md:self-auto cursor-pointer">
                <span>+ Add New Tag</span>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Hashtag & Badge</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">URL Slug</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Tagged Stories</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($tags as $tag)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <span 
                                        class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black text-white shadow-xs"
                                        style="background-color: {{ $tag->color ?? '#3c83f6' }}"
                                    >
                                        <span>#</span>
                                        <span>{{ $tag->name }}</span>
                                    </span>
                                </div>
                                @if($tag->description)
                                    <p class="text-xs text-slate-400 font-medium truncate max-w-xs mt-1">{{ $tag->description }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-400 font-mono">
                                /tag/{{ $tag->slug }}
                            </td>
                            <td class="px-6 py-4">
                                @if($tag->is_trending)
                                    <span class="px-2.5 py-0.5 bg-purple-500/10 text-purple-600 dark:text-purple-400 text-[10px] font-black uppercase tracking-wider rounded-lg border border-purple-500/20">
                                        🔥 Trending
                                    </span>
                                @else
                                    <span class="px-2.5 py-0.5 bg-slate-100 dark:bg-slate-800 text-slate-400 text-[10px] font-extrabold uppercase tracking-wider rounded-lg">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-bold text-[#16a249] bg-emerald-50 dark:bg-emerald-950/40 rounded-xl border border-emerald-200/40 dark:border-emerald-800/40">
                                    {{ number_format($tag->posts_count) }} stories
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.tags.edit', $tag) }}" class="px-3.5 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-[#3c83f6] hover:text-white text-slate-700 dark:text-slate-200 text-xs font-bold rounded-xl transition-all inline-block cursor-pointer">Edit</a>
                                <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this tag?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3.5 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-xl transition-all cursor-pointer">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No tags found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tags->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $tags->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>
