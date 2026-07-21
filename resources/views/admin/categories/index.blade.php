<x-admin-layout title="Manage Categories">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Content Topics & Categories</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Organize platform content into structured topics</p>
            </div>
            <a href="{{ route('admin.categories.create') }}" class="px-4 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 inline-flex items-center gap-1.5 self-start md:self-auto">
                + Add New Category
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Category Name</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">URL Slug</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Total Posts</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-extrabold text-[#0f1729] dark:text-slate-100">
                                {{ $category->name }}
                            </td>
                            <td class="px-6 py-4 text-xs font-semibold text-slate-400 font-mono">
                                /category/{{ $category->slug }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 text-xs font-bold text-[#3c83f6] bg-blue-50 dark:bg-blue-950/40 rounded-lg border border-blue-200/40 dark:border-blue-800/40">
                                    {{ number_format($category->posts_count) }} stories
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right space-x-2">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="px-3 py-1.5 bg-slate-100 dark:bg-slate-800 hover:bg-[#3c83f6] hover:text-white text-[#0f1729] dark:text-slate-200 text-xs font-bold rounded-lg transition-all inline-block">Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-lg transition-all">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No categories found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($categories->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $categories->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

