<x-admin-layout title="Send Newsletter Broadcast">

    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <style>
            trix-editor { 
                min-height: 400px !important; 
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                font-size: 0.95rem;
                line-height: 1.7;
            }
            .trix-button-group--file-tools { display: none !important; }
            trix-toolbar {
                position: sticky;
                top: 0;
                z-index: 20;
                background-color: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                border-radius: 0.85rem;
                padding: 0.5rem;
                margin-bottom: 1.25rem;
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.04);
            }
            .dark trix-toolbar {
                background-color: rgba(19, 28, 49, 0.95);
                border-color: rgba(30, 41, 59, 0.8);
                box-shadow: 0 4px 12px -2px rgba(0, 0, 0, 0.3);
            }
            .dark trix-toolbar .trix-button {
                filter: invert(0.85);
            }
            .dark trix-toolbar .trix-button--active {
                filter: invert(1);
                background-color: rgba(60, 131, 246, 0.4) !important;
            }
            .dark trix-editor {
                color: #e2e8f0;
            }
            trix-editor:empty:not(:focus)::before {
                color: #94a3b8;
            }
        </style>
    @endpush

    <div class="max-w-5xl space-y-6">
        
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.newsletters.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline inline-flex items-center gap-1.5 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Subscriber Audience
                </a>
                <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Compose Newsletter Broadcast</h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Draft and send rich email updates to all active newsletter subscribers.</p>
            </div>

            <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-500/10 text-[#16a249] rounded-xl border border-emerald-500/20 text-xs font-bold self-start sm:self-auto">
                <span class="w-2 h-2 rounded-full bg-[#16a249] animate-pulse"></span>
                <span>Active Audience Ready</span>
            </div>
        </div>

        {{-- Form Container --}}
        <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
            <form action="{{ route('admin.newsletters.broadcast') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Email Subject Field --}}
                <div class="space-y-2">
                    <label for="subject" class="block text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider">
                        Email Subject Line
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            name="subject" 
                            id="subject" 
                            value="{{ old('subject') }}" 
                            required 
                            class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all" 
                            placeholder="e.g. Weekly Digest: Top Stories You Can't Miss This Week"
                        >
                        <svg class="w-4 h-4 text-slate-400 absolute left-3.5 top-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    @error('subject')
                        <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Rich Message Body --}}
                <div class="space-y-2">
                    <label for="content" class="block text-xs font-black text-slate-900 dark:text-white uppercase tracking-wider">
                        Broadcast Message Body
                    </label>
                    <div class="bg-slate-50/50 dark:bg-slate-900/50 border border-slate-200 dark:border-slate-800 rounded-2xl p-4 min-h-[420px]">
                        <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                        <trix-editor input="content" placeholder="Compose your broadcast update... Write rich copy, add links, or include bullet points."></trix-editor>
                    </div>
                    @error('content')
                        <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Bar & Confirmation Notice --}}
                <div class="pt-6 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-center gap-2.5 text-slate-500 dark:text-slate-400 text-xs font-medium">
                        <svg class="w-4 h-4 text-amber-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <span>Broadcasts will be queued and sent to all active subscribers asynchronously.</span>
                    </div>

                    <button 
                        type="submit" 
                        class="px-8 py-3 bg-gradient-to-r from-[#16a249] to-emerald-600 hover:from-emerald-600 hover:to-[#16a249] text-white text-xs font-black uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-emerald-600/25 flex items-center justify-center gap-2 cursor-pointer"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                        <span>Dispatch Broadcast</span>
                    </button>
                </div>
            </form>
        </div>

    </div>

    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
    @endpush

</x-admin-layout>
