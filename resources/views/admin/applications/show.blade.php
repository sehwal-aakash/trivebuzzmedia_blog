<x-admin-layout title="Review Author Application">

    <div class="max-w-4xl">
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ route('admin.applications.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline flex items-center gap-1.5">
                &larr; Back to all applications
            </a>
        </div>

        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Applicant Profile</h3>
                    <div class="text-lg font-extrabold text-[#0f1729] dark:text-white">{{ $authorApplication->user->name }}</div>
                    <div class="text-xs font-medium text-slate-400 mt-1">{{ $authorApplication->user->email }}</div>
                </div>
                <div>
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-2">Application Status</h3>
                    <span class="px-3 py-1 text-xs font-black uppercase tracking-wider rounded-lg {{ $authorApplication->status->value === 'approved' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : ($authorApplication->status->value === 'rejected' ? 'bg-rose-50 text-rose-600 dark:bg-rose-950/50' : 'bg-amber-50 text-amber-600 dark:bg-amber-950/50') }}">
                        {{ $authorApplication->status->value }}
                    </span>
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3">Writer Biography</h3>
                <div class="text-sm text-[#344256] dark:text-slate-200 bg-slate-50 dark:bg-slate-900/60 p-5 rounded-xl border border-slate-200/60 dark:border-slate-800/80 whitespace-pre-wrap leading-relaxed">
                    {{ $authorApplication->bio }}
                </div>
            </div>

            <div class="mb-8">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 mb-3">Portfolio Links</h3>
                @if(is_array($authorApplication->portfolio_links) && count($authorApplication->portfolio_links) > 0)
                    <ul class="space-y-2">
                        @foreach($authorApplication->portfolio_links as $link)
                            <li>
                                <a href="{{ $link }}" target="_blank" class="text-xs font-bold text-[#3c83f6] hover:underline inline-flex items-center gap-2">
                                    <svg class="w-4 h-4 text-[#3c83f6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                    {{ $link }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-slate-400 italic text-xs">No portfolio links provided.</p>
                @endif
            </div>

            @if($authorApplication->status->value === 'pending')
                <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center gap-4">
                    <form action="{{ route('admin.applications.approve', $authorApplication) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-md shadow-emerald-600/20 active:scale-95">
                            Approve Application
                        </button>
                    </form>
                    <form action="{{ route('admin.applications.reject', $authorApplication) }}" method="POST">
                        @csrf
                        <button type="submit" class="px-5 py-2.5 bg-rose-600 hover:bg-rose-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-md shadow-rose-600/20 active:scale-95">
                            Reject Application
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>

</x-admin-layout>

