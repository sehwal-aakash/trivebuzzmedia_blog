<x-admin-layout title="Author Applications">

    <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Author Onboarding Requests</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Review and approve requests from writers applying for author status</p>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/70 dark:bg-slate-900/50 border-b border-slate-200/60 dark:border-slate-800">
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Applicant Name & Email</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider">Submitted Date</th>
                        <th class="px-6 py-3.5 text-xs font-black text-slate-400 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($applications as $application)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <td class="px-6 py-4">
                                <div class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100">{{ $application->user->name }}</div>
                                <div class="text-xs font-medium text-slate-400 mt-0.5">{{ $application->user->email }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $application->status->value === 'approved' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : ($application->status->value === 'rejected' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/50' : 'bg-amber-50 text-amber-600 dark:bg-amber-950/50') }}">
                                    {{ $application->status->value }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-xs font-medium text-slate-400">
                                {{ $application->created_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('admin.applications.show', $application) }}" class="px-3.5 py-1.5 bg-[#3c83f6] hover:bg-blue-600 text-white text-xs font-bold rounded-xl transition-all shadow-xs">Review Application</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-slate-400 text-xs italic">
                                No applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($applications->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $applications->links() }}
            </div>
        @endif
    </div>

</x-admin-layout>

