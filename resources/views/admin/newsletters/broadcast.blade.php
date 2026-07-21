<x-admin-layout title="Send Newsletter Broadcast">

    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <style>
            trix-editor { min-height: 350px !important; }
        </style>
    @endpush

    <div class="max-w-4xl">
        <div class="mb-6">
            <a href="{{ route('admin.newsletters.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline flex items-center gap-1.5">
                &larr; Back to Subscribers
            </a>
        </div>

        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden p-6 md:p-8">
            <div class="mb-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                <h2 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">New Audience Broadcast</h2>
                <p class="text-xs font-medium text-slate-400 mt-0.5">Compose an email update for all active newsletter subscribers</p>
            </div>

            <form action="{{ route('admin.newsletters.broadcast') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="subject" class="block text-xs font-black text-[#0f1729] dark:text-slate-200 uppercase tracking-wider mb-2">Email Subject</label>
                    <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="w-full rounded-xl border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 text-sm text-[#0f1729] dark:text-white p-3 focus:border-[#3c83f6] focus:ring-[#3c83f6] font-bold" placeholder="e.g. Weekly Digest: Top Stories You Missed">
                    @error('subject')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="content" class="block text-xs font-black text-[#0f1729] dark:text-slate-200 uppercase tracking-wider mb-2">Message Body</label>
                    <div class="prose prose-sm dark:prose-invert max-w-none">
                        <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                        <trix-editor input="content" class="bg-white dark:bg-slate-900 text-sm dark:text-white border-slate-200 dark:border-slate-800 rounded-xl p-3" placeholder="Write your newsletter update here..."></trix-editor>
                    </div>
                    @error('content')
                        <p class="mt-1 text-xs text-rose-600 font-bold uppercase tracking-tight">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-6 flex flex-col md:flex-row md:items-center justify-between gap-4 border-t border-slate-100 dark:border-slate-800">
                    <p class="text-xs text-slate-400 font-medium italic">
                        This email broadcast will be dispatched to all active subscribers via background queues.
                    </p>
                    <button type="submit" class="px-6 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-md shadow-emerald-600/20">
                        Send Broadcast
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    @endpush

</x-admin-layout>

