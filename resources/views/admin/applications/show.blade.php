<x-layout>
    <x-slot:title>
        Admin: Review Application - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('admin.applications.index') }}" class="text-sm text-zinc-500 hover:text-indigo-600 dark:hover:text-indigo-400">
                &larr; Back to applications
            </a>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mt-2">Review Application</h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 overflow-hidden">
            <div class="p-6 md:p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 pb-8 border-b border-zinc-200 dark:border-zinc-800">
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Applicant</h3>
                        <div class="text-lg font-bold text-zinc-900 dark:text-white">{{ $authorApplication->user->name }}</div>
                        <div class="text-zinc-600 dark:text-zinc-400">{{ $authorApplication->user->email }}</div>
                    </div>
                    <div>
                        <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-2">Status</h3>
                        <span class="px-2 py-1 text-xs font-bold uppercase rounded-full {{ $authorApplication->status->value === 'approved' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' : ($authorApplication->status->value === 'rejected' ? 'bg-red-100 text-red-700 dark:bg-red-900/30 dark:text-red-400' : 'bg-zinc-100 text-zinc-700 dark:bg-zinc-800 dark:text-zinc-400') }}">
                            {{ $authorApplication->status->value }}
                        </span>
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-4">Biography</h3>
                    <div class="text-zinc-700 dark:text-zinc-300 bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-lg border border-zinc-200 dark:border-zinc-700 whitespace-pre-wrap">
                        {{ $authorApplication->bio }}
                    </div>
                </div>

                <div class="mb-8">
                    <h3 class="text-sm font-semibold text-zinc-500 uppercase tracking-wider mb-4">Portfolio Links</h3>
                    @if(is_array($authorApplication->portfolio_links) && count($authorApplication->portfolio_links) > 0)
                        <ul class="space-y-2">
                            @foreach($authorApplication->portfolio_links as $link)
                                <li>
                                    <a href="{{ $link }}" target="_blank" class="text-indigo-600 dark:text-indigo-400 hover:underline flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                        {{ $link }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-zinc-500 italic text-sm">No links provided.</p>
                    @endif
                </div>

                @if($authorApplication->status->value === 'pending')
                    <div class="pt-8 border-t border-zinc-200 dark:border-zinc-800 flex gap-4">
                        <form action="{{ route('admin.applications.approve', $authorApplication) }}" method="POST">
                            @csrf
                            <x-form.button size="sm">
                                Approve
                            </x-form.button>
                        </form>
                        <form action="{{ route('admin.applications.reject', $authorApplication) }}" method="POST">
                            @csrf
                            <x-form.button variant="danger" size="sm">
                                Reject
                            </x-form.button>
                        </form>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout>
