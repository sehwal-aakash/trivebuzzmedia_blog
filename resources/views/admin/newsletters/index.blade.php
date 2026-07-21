<x-admin-layout title="Newsletter Broadcasting">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Audience Subscribers</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Manage email newsletter subscribers and broadcast digests</p>
            </div>
            <a href="{{ route('admin.newsletters.create') }}" class="px-4 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white rounded-xl text-xs font-bold uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 inline-flex items-center gap-1.5 self-start md:self-auto">
                + Send Broadcast Email
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Subscriber Email</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Subscribed Date</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($subscribers as $sub)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-extrabold text-[#0f1729] dark:text-slate-100 font-mono">
                                {{ $sub->email }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $sub->is_active ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : 'bg-rose-50 text-rose-600 dark:bg-rose-950/50' }}">
                                    {{ $sub->is_active ? 'Active' : 'Unsubscribed' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ $sub->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <form action="{{ route('admin.newsletters.destroy', $sub) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to remove this subscriber?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 hover:text-white text-rose-600 text-xs font-bold rounded-lg transition-all">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No newsletter subscribers found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($subscribers->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $subscribers->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

