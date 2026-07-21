<x-admin-layout title="Activity Logs">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">System Audit Trail</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Track system events, user actions, and administrative logs</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Action Event</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">IP Address</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Timestamp</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4 text-sm font-extrabold text-[#0f1729] dark:text-slate-100">
                                {{ $log->user ? $log->user->name : 'System' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg bg-blue-50 text-[#3c83f6] dark:bg-blue-950/50">
                                    {{ $log->action }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400 max-w-xs truncate">
                                {{ $log->description }}
                            </td>
                            <td class="px-6 py-4 text-xs font-mono text-slate-400">
                                {{ $log->ip_address }}
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ $log->created_at->diffForHumans() }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No activity logs found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

