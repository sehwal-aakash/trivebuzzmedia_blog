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

    <div class="space-y-6" x-data="{ audience: '{{ old('audience', 'subscribers') }}' }">
        
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.newsletters.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline inline-flex items-center gap-1.5 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Subscribers List
                </a>
                <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Create & Send Broadcast</h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Compose newsletters, select target audience, and dispatch email campaigns.</p>
            </div>
        </div>

        @if(session('error'))
            <div class="p-4 bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 rounded-2xl text-xs font-bold text-rose-600 dark:text-rose-400">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.newsletters.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            {{-- Left Main Content Canvas --}}
            <div class="lg:col-span-8 space-y-6">
                
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                    
                    {{-- Subject Line --}}
                    <div class="space-y-2">
                        <label for="subject" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Broadcast Subject Line <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="subject" 
                            id="subject" 
                            value="{{ old('subject') }}"
                            required 
                            placeholder="e.g. 🚀 Weekly Tech Roundup: Breakthoughs in AI & Web Development"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                        >
                        @error('subject')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Rich Text Body Editor --}}
                    <div class="space-y-2 pt-2">
                        <label class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Email Body Content <span class="text-rose-500">*</span>
                        </label>
                        <div class="p-4 bg-slate-50/50 dark:bg-slate-900/40 border border-slate-200 dark:border-slate-800 rounded-2xl">
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                            <trix-editor input="content" placeholder="Compose your email message, add headings, links, or bullet points..."></trix-editor>
                        </div>
                        @error('content')
                            <p class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                </div>

            </div>

            {{-- Right Sidebar Audience & Dispatch Controls --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Target Audience Card --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 shadow-xs space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white pb-3 border-b border-slate-100 dark:border-slate-800">
                        Target Audience
                    </h3>

                    {{-- Audience Options --}}
                    <div class="space-y-3">
                        <label class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                            <input 
                                type="radio" 
                                name="audience" 
                                value="subscribers" 
                                x-model="audience"
                                class="mt-0.5 w-4 h-4 text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                            >
                            <div>
                                <span class="block text-xs font-extrabold text-slate-900 dark:text-white">Active Newsletter Subscribers</span>
                                <span class="text-[10px] font-medium text-slate-400">Total: {{ number_format($activeSubscribersCount) }} confirmed subscribers</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                            <input 
                                type="radio" 
                                name="audience" 
                                value="users" 
                                x-model="audience"
                                class="mt-0.5 w-4 h-4 text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                            >
                            <div>
                                <span class="block text-xs font-extrabold text-slate-900 dark:text-white">All Platform Users & Authors</span>
                                <span class="text-[10px] font-medium text-slate-400">Total: {{ number_format($usersCount) }} registered users</span>
                            </div>
                        </label>

                        <label class="flex items-start gap-3 p-3 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 cursor-pointer">
                            <input 
                                type="radio" 
                                name="audience" 
                                value="custom" 
                                x-model="audience"
                                class="mt-0.5 w-4 h-4 text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                            >
                            <div>
                                <span class="block text-xs font-extrabold text-slate-900 dark:text-white">Custom Email List / Test</span>
                                <span class="text-[10px] font-medium text-slate-400">Send to specific test email addresses</span>
                            </div>
                        </label>
                    </div>

                    {{-- Custom Emails Input --}}
                    <div x-show="audience === 'custom'" class="space-y-1.5 pt-2" x-transition>
                        <label for="custom_emails" class="block text-[11px] font-bold text-slate-600 dark:text-slate-300 uppercase tracking-wider">
                            Recipient Emails (Comma-separated)
                        </label>
                        <textarea 
                            name="custom_emails" 
                            id="custom_emails" 
                            rows="3" 
                            placeholder="admin@domain.com, test@domain.com"
                            class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all resize-none"
                        >{{ old('custom_emails') }}</textarea>
                    </div>

                    {{-- Direct Send Checkbox --}}
                    <label class="flex items-center justify-between p-3.5 bg-blue-50/60 dark:bg-blue-950/30 rounded-2xl border border-blue-200/60 dark:border-blue-900/40 cursor-pointer">
                        <div>
                            <span class="block text-xs font-extrabold text-[#3c83f6]">Send Immediately</span>
                            <span class="text-[10px] font-medium text-slate-500 dark:text-slate-400">Bypass background queue & deliver directly</span>
                        </div>
                        <input 
                            type="checkbox" 
                            name="send_now" 
                            value="1" 
                            checked
                            class="w-4 h-4 rounded text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                        >
                    </label>

                    {{-- Action Buttons --}}
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-3">
                        <a href="{{ route('admin.newsletters.index') }}" class="w-1/3 px-4 py-3 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-xl text-center transition-all">
                            Cancel
                        </a>
                        <button 
                            type="submit" 
                            class="w-2/3 px-5 py-3 bg-[#3c83f6] hover:bg-blue-600 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-lg shadow-blue-500/25 flex items-center justify-center gap-2 cursor-pointer"
                            onclick="return confirm('Are you sure you want to send this newsletter broadcast to the selected audience?')"
                        >
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                            <span>Send Broadcast</span>
                        </button>
                    </div>

                </div>

            </div>
        </form>
    </div>

</x-admin-layout>
