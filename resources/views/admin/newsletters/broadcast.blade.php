<x-layout>
    <x-slot:title>
        Send Newsletter Broadcast - {{ config('app.name') }}
    </x-slot>

    {{-- Head for Trix --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <style>
            trix-editor { min-height: 400px !important; }
        </style>
    @endpush

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-8">
            <a href="{{ route('admin.newsletters.index') }}" class="text-sm text-zinc-500 hover:text-zinc-700 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Back to Subscribers
            </a>
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white mt-4">New Broadcast</h1>
        </div>

        <div class="bg-white dark:bg-zinc-900 shadow-sm sm:rounded-lg border border-zinc-200 dark:border-zinc-800 p-8">
            <form action="{{ route('admin.newsletters.broadcast') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <div>
                        <label for="subject" class="block text-sm font-black text-zinc-700 dark:text-zinc-300 uppercase tracking-widest mb-2">Email Subject</label>
                        <input type="text" name="subject" id="subject" value="{{ old('subject') }}" required class="w-full rounded-xl border-zinc-300 dark:border-zinc-700 dark:bg-zinc-950 dark:text-white shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold" placeholder="e.g. Weekly Digest: Top Stories You Missed">
                        @error('subject')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="content" class="block text-sm font-black text-zinc-700 dark:text-zinc-300 uppercase tracking-widest mb-2">Message Content</label>
                        <div class="prose prose-lg dark:prose-invert max-w-none">
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" class="bg-white dark:bg-zinc-950 dark:text-white border-zinc-300 dark:border-zinc-700 rounded-xl" placeholder="Write your newsletter here..."></trix-editor>
                        </div>
                        @error('content')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="pt-4 flex items-center justify-between border-t border-zinc-100 dark:border-zinc-800">
                        <p class="text-xs text-zinc-500 italic">
                            This will be sent to all active subscribers via the system queue.
                        <div class="flex justify-end pt-4">
                            <x-form.button size="lg">
                                Send Broadcast
                            </x-form.button>
                        </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    @endpush
</x-layout>
