<x-admin-layout title="Email Tracking Logs" active="email-logs">

    <div class="space-y-6" x-data="{ selectedLog: null, showModal: false, showPurgeModal: false }">

        {{-- Header & Actions --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Email Sent Monitor & Tracking Logs</h2>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Super Admin dashboard to monitor all outgoing emails dispatched across the platform.</p>
            </div>
            
            @if($logs->total() > 0)
                <button 
                    @click="showPurgeModal = true"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-600 dark:text-rose-400 font-bold text-xs border border-rose-500/20 transition-all cursor-pointer"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Purge All Email Logs
                </button>
            @endif
        </div>

        {{-- Stats Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Total Sent Card --}}
            <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 p-5 rounded-2xl shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Total Dispatched</span>
                    <div class="w-8 h-8 rounded-xl bg-blue-500/10 text-[#3c83f6] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ number_format($stats['total_sent']) }}</p>
                <span class="text-[11px] font-semibold text-slate-400">Lifetime email records</span>
            </div>

            {{-- Sent Today Card --}}
            <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 p-5 rounded-2xl shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Dispatched Today</span>
                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-[#16a249] flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ number_format($stats['sent_today']) }}</p>
                <span class="text-[11px] font-semibold text-[#16a249]">Active today</span>
            </div>

            {{-- Failed Count Card --}}
            <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 p-5 rounded-2xl shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Failed Delivery</span>
                    <div class="w-8 h-8 rounded-xl bg-rose-500/10 text-rose-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ number_format($stats['failed_count']) }}</p>
                <span class="text-[11px] font-semibold text-rose-500">Requires attention</span>
            </div>

            {{-- Delivery Rate Card --}}
            <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 p-5 rounded-2xl shadow-xs">
                <div class="flex items-center justify-between">
                    <span class="text-xs font-bold text-slate-500 dark:text-slate-400">Success Rate</span>
                    <div class="w-8 h-8 rounded-xl bg-cyan-500/10 text-cyan-500 flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-2xl font-black text-slate-900 dark:text-white mt-2">{{ $stats['success_rate'] }}%</p>
                <span class="text-[11px] font-semibold text-cyan-500">Overall health</span>
            </div>
        </div>

        {{-- Search & Filters --}}
        <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 p-4 rounded-2xl shadow-xs">
            <form method="GET" action="{{ route('admin.email-logs.index') }}" class="flex flex-col md:flex-row gap-3">
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search by recipient email or subject..."
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-blue-500 transition-all"
                    >
                    <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>

                <div class="w-full md:w-48">
                    <select 
                        name="status" 
                        onchange="this.form.submit()"
                        class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white focus:outline-none focus:border-blue-500 transition-all"
                    >
                        <option value="">All Statuses</option>
                        <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>

                <button type="submit" class="px-5 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white font-bold text-xs rounded-xl transition-all shadow-md shadow-blue-500/20">
                    Filter
                </button>

                @if(request('search') || request('status'))
                    <a href="{{ route('admin.email-logs.index') }}" class="px-4 py-2.5 bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-xl hover:bg-slate-200 transition-all text-center flex items-center justify-center">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        {{-- Email Logs Table --}}
        <div class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800/80 rounded-2xl overflow-hidden shadow-xs">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                            <th class="px-5 py-3.5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Sent Date & Time</th>
                            <th class="px-5 py-3.5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Recipient</th>
                            <th class="px-5 py-3.5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Subject</th>
                            <th class="px-5 py-3.5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400">Status</th>
                            <th class="px-5 py-3.5 text-[11px] font-extrabold uppercase tracking-wider text-slate-400 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 dark:divide-slate-800/60 text-xs">
                        @forelse($logs as $log)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="px-5 py-4 font-medium text-slate-600 dark:text-slate-300 whitespace-nowrap">
                                    {{ $log->created_at->format('M d, Y • h:i A') }}
                                    <span class="block text-[10px] text-slate-400 font-mono mt-0.5">{{ $log->created_at->diffForHumans() }}</span>
                                </td>
                                <td class="px-5 py-4 font-bold text-slate-900 dark:text-white">
                                    {{ $log->recipient }}
                                </td>
                                <td class="px-5 py-4 font-medium text-slate-700 dark:text-slate-200 max-w-xs truncate">
                                    {{ $log->subject }}
                                </td>
                                <td class="px-5 py-4 whitespace-nowrap">
                                    @if($log->status === 'sent')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-emerald-500/10 text-[#16a249] border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-[#16a249]"></span>
                                            Sent
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[10px] font-extrabold bg-rose-500/10 text-rose-500 border border-rose-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Failed
                                        </span>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-right whitespace-nowrap space-x-2">
                                    <button 
                                        @click="selectedLog = {{ json_encode($log) }}; showModal = true"
                                        class="px-3 py-1.5 bg-blue-500/10 hover:bg-blue-500/20 text-[#3c83f6] rounded-xl font-bold text-[11px] transition-all cursor-pointer"
                                    >
                                        View Details
                                    </button>

                                    <form method="POST" action="{{ route('admin.email-logs.destroy', $log) }}" class="inline-block" onsubmit="return confirm('Delete this log entry?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-slate-400 hover:text-rose-500 rounded-lg transition-colors cursor-pointer" title="Delete Log">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-5 py-12 text-center text-slate-400 font-medium">
                                    No email logs recorded yet. Outgoing emails will automatically appear here.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($logs->hasPages())
                <div class="px-5 py-4 border-t border-slate-200 dark:border-slate-800">
                    {{ $logs->links() }}
                </div>
            @endif
        </div>

        {{-- Log Detail Modal --}}
        <div x-show="showModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs" x-cloak>
            <div @click.away="showModal = false" class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-xl w-full space-y-4 shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 pb-3">
                    <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Email Log Details</h3>
                    <button @click="showModal = false" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <template x-if="selectedLog">
                    <div class="space-y-3 text-xs">
                        <div>
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Recipient:</span>
                            <p class="font-bold text-slate-900 dark:text-white" x-text="selectedLog.recipient"></p>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Subject:</span>
                            <p class="font-bold text-slate-900 dark:text-white" x-text="selectedLog.subject"></p>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Sent At:</span>
                            <p class="font-semibold text-slate-600 dark:text-slate-300" x-text="selectedLog.created_at"></p>
                        </div>
                        <div>
                            <span class="text-slate-400 font-bold uppercase text-[10px]">Body Excerpt:</span>
                            <div class="p-3 mt-1 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl font-mono text-[11px] text-slate-700 dark:text-slate-300 whitespace-pre-wrap max-h-48 overflow-y-auto" x-text="selectedLog.body_snippet || 'No text snippet available.'"></div>
                        </div>
                        <template x-if="selectedLog.error_message">
                            <div>
                                <span class="text-rose-500 font-bold uppercase text-[10px]">Error Details:</span>
                                <div class="p-3 mt-1 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800/60 rounded-xl font-mono text-[11px] text-rose-600 whitespace-pre-wrap" x-text="selectedLog.error_message"></div>
                            </div>
                        </template>
                    </div>
                </template>

                <div class="flex justify-end pt-2 border-t border-slate-200 dark:border-slate-800">
                    <button @click="showModal = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-200 transition-all">
                        Close
                    </button>
                </div>
            </div>
        </div>

        {{-- Purge Modal --}}
        <div x-show="showPurgeModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs" x-cloak>
            <div @click.away="showPurgeModal = false" class="bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800 rounded-2xl p-6 max-w-md w-full space-y-4 shadow-2xl">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Purge All Email Logs?</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">This action will permanently delete all recorded email delivery logs. This action cannot be undone.</p>
                <div class="flex justify-end gap-2 pt-2">
                    <button @click="showPurgeModal = false" class="px-4 py-2 bg-slate-100 dark:bg-slate-800 font-bold text-xs text-slate-700 dark:text-slate-300 rounded-xl hover:bg-slate-200 transition-all">
                        Cancel
                    </button>
                    <form method="POST" action="{{ route('admin.email-logs.purge') }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl shadow-md transition-all">
                            Confirm Purge
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</x-admin-layout>
