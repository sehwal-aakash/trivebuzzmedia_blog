<x-layout>
    <x-slot:title>
        Admin: Activity Logs - {{ config('app.name') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mb-8">Activity Logs</h1>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800 border-b border-zinc-200 dark:border-zinc-700">
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Action</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Details</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">IP Address</th>
                            <th class="px-6 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider">Time</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @forelse($logs as $log)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                <td class="px-6 py-4 text-sm font-medium text-zinc-900 dark:text-white">
                                    {{ $log->user ? $log->user->name : 'System' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-[10px] font-bold uppercase rounded-full bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                        {{ $log->action }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500 max-w-xs truncate">
                                    {{ $log->description }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500">
                                    {{ $log->ip_address }}
                                </td>
                                <td class="px-6 py-4 text-sm text-zinc-500">
                                    {{ $log->created_at->diffForHumans() }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-zinc-500 dark:text-zinc-400 italic">
                                    No activity logs found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-zinc-200 dark:border-zinc-700">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</x-layout>
