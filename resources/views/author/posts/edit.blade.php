<x-layout>
    <x-slot:title>
        Edit Post: {{ $post->title }} - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    {{-- Head for Trix & Custom Editor Styling --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <style>
            trix-editor { 
                min-height: 450px !important; 
                border: none !important;
                outline: none !important;
                box-shadow: none !important;
                font-size: 1.05rem;
                line-height: 1.75;
            }
            .trix-button-group--file-tools { display: none !important; }
            trix-toolbar {
                position: sticky;
                top: 5rem;
                z-index: 30;
                background-color: rgba(255, 255, 255, 0.95);
                backdrop-filter: blur(12px);
                border-radius: 1rem;
                padding: 0.6rem;
                margin-bottom: 1.5rem;
                border: 1px solid rgba(226, 232, 240, 0.8);
                box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
            }
            .dark trix-toolbar {
                background-color: rgba(19, 28, 49, 0.95);
                border-color: rgba(30, 41, 59, 0.8);
                box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.3);
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ ...aiAssistant(), ...imagePreview('{{ $post->featured_image ? Storage::url($post->featured_image) : '' }}'), ...postEditor() }" x-init="initEditor()">
        <form action="{{ route('author.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            {{-- Header Action Bar --}}
            <div class="sticky top-0 z-40 bg-surface-50/90 dark:bg-[#0f1729]/90 backdrop-blur-md py-4 mb-8 border-b border-surface-200/70 dark:border-surface-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all">
                <div class="flex items-center gap-3">
                    <a href="{{ route('author.posts.index') }}" class="p-2 rounded-xl text-surface-500 hover:text-surface-900 dark:hover:text-white hover:bg-surface-200/60 dark:hover:bg-surface-800/60 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-blue-500"></span>
                            <span class="text-[11px] font-black uppercase tracking-widest text-surface-400">Editing Story #{{ $post->id }}</span>
                        </div>
                        <h1 class="text-xl font-black text-surface-900 dark:text-white tracking-tight truncate max-w-md">{{ $post->title }}</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <select name="status" class="appearance-none pl-3.5 pr-8 py-2 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-xs font-bold text-surface-700 dark:text-surface-200 focus:outline-none focus:border-brand transition-all cursor-pointer">
                            @foreach(\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status', $post->status->value) == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-surface-400 absolute right-2.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <x-form.button size="sm" class="px-6 py-2.5 bg-gradient-to-r from-brand to-blue-600 hover:from-blue-600 hover:to-brand text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-blue-500/25 transition-all">
                        Update Story
                    </x-form.button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                
                {{-- Left Column: Writing Canvas --}}
                <div class="lg:col-span-8 space-y-6">
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                        
                        {{-- Title Field --}}
                        <div class="space-y-2">
                            <label class="block text-[11px] font-black uppercase tracking-wider text-surface-400">Article Title</label>
                            <div class="px-5 py-4 bg-surface-50/80 dark:bg-slate-900/60 border border-surface-200/80 dark:border-surface-800 rounded-2xl focus-within:border-brand focus-within:bg-white dark:focus-within:bg-slate-900 transition-all">
                                <textarea 
                                    name="title" 
                                    rows="1" 
                                    required
                                    class="w-full text-2xl md:text-3xl lg:text-4xl font-black border-none outline-none focus:outline-none focus:ring-0 p-0 text-surface-900 dark:text-white placeholder-surface-300 dark:placeholder-surface-600 resize-none tracking-tight leading-snug"
                                    placeholder="Enter article title..."
                                    oninput="this.style.height = ''; this.style.height = this.scrollHeight + 'px'"
                                >{{ old('title', $post->title) }}</textarea>
                            </div>
                            @error('title')
                                <p class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        {{-- Subtitle / Excerpt Field --}}
                        <div class="space-y-2">
                            <label class="block text-[11px] font-black uppercase tracking-wider text-surface-400">Summary / Subhead</label>
                            <div class="px-5 py-3.5 bg-surface-50/80 dark:bg-slate-900/60 border border-surface-200/80 dark:border-surface-800 rounded-2xl focus-within:border-brand focus-within:bg-white dark:focus-within:bg-slate-900 transition-all">
                                <textarea 
                                    name="excerpt" 
                                    rows="2" 
                                    class="w-full text-base md:text-lg font-medium border-none outline-none focus:outline-none focus:ring-0 p-0 text-surface-700 dark:text-surface-300 placeholder-surface-300 dark:placeholder-surface-600 resize-none leading-relaxed"
                                    placeholder="Write a short subhead or summary that captures reader attention..."
                                >{{ old('excerpt', $post->excerpt) }}</textarea>
                            </div>
                            @error('excerpt')
                                <p class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Main Editor with Visual / HTML Switcher --}}
                        <div class="space-y-3 pt-2">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                <div>
                                    <label class="block text-[11px] font-black uppercase tracking-wider text-surface-400">Story Body</label>
                                    <p class="text-[10px] text-surface-500 dark:text-surface-400 font-medium">Switch between Visual Rich Text Editor and Raw HTML Code view.</p>
                                </div>

                                {{-- Switcher Button Group --}}
                                <div class="inline-flex p-1 bg-surface-100 dark:bg-slate-900 border border-surface-200 dark:border-surface-800 rounded-xl shadow-inner self-start sm:self-auto">
                                    <button 
                                        type="button"
                                        @click="switchMode('editor')"
                                        :class="editorMode === 'editor' ? 'bg-white dark:bg-[#151f32] text-brand dark:text-white shadow-xs font-black' : 'text-surface-500 hover:text-surface-900 dark:hover:text-white font-bold'"
                                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs transition-all duration-150 cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        <span>Visual Editor</span>
                                    </button>
                                    <button 
                                        type="button"
                                        @click="switchMode('html')"
                                        :class="editorMode === 'html' ? 'bg-white dark:bg-[#151f32] text-brand dark:text-white shadow-xs font-black' : 'text-surface-500 hover:text-surface-900 dark:hover:text-white font-bold'"
                                        class="flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs transition-all duration-150 cursor-pointer"
                                    >
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path>
                                        </svg>
                                        <span>HTML Code</span>
                                    </button>
                                </div>
                            </div>

                            {{-- Hidden Content Input for Form Submission --}}
                            <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">

                            {{-- Visual Editor Container --}}
                            <div x-show="editorMode === 'editor'" x-cloak class="p-4 md:p-6 bg-surface-50/40 dark:bg-slate-900/40 border border-surface-200/80 dark:border-surface-800 rounded-2xl prose prose-lg dark:prose-invert max-w-none min-h-[450px]">
                                <trix-editor input="content" placeholder="Tell your story... Write insights, format headings, or add quotes."></trix-editor>
                            </div>

                            {{-- Main Big Box for HTML Editor --}}
                            <div x-show="editorMode === 'html'" x-cloak class="rounded-2xl overflow-hidden border border-slate-800 shadow-xl bg-slate-950">
                                {{-- Code Editor Control Bar --}}
                                <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-2.5 bg-slate-900 border-b border-slate-800 text-xs font-mono">
                                    <div class="flex items-center gap-2">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500 inline-block"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500 inline-block"></span>
                                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 inline-block"></span>
                                        </div>
                                        <span class="ml-2 text-[11px] font-bold text-slate-300 uppercase tracking-widest flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"></path></svg>
                                            HTML Source Code Box
                                        </span>
                                    </div>

                                    {{-- Quick Tag Inserts --}}
                                    <div class="flex items-center flex-wrap gap-1">
                                        <span class="text-[10px] text-slate-500 font-sans uppercase font-bold mr-1">Insert:</span>
                                        <button type="button" @click="insertTag('<p>', '</p>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;p&gt;</button>
                                        <button type="button" @click="insertTag('<h2>', '</h2>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;h2&gt;</button>
                                        <button type="button" @click="insertTag('<h3>', '</h3>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;h3&gt;</button>
                                        <button type="button" @click="insertTag('<strong>', '</strong>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;b&gt;</button>
                                        <button type="button" @click="insertTag('<a href=\'#\'>', '</a>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;a&gt;</button>
                                        <button type="button" @click="insertTag('<img src=\'\' alt=\'\' />')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;img&gt;</button>
                                        <button type="button" @click="insertTag('<blockquote>', '</blockquote>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;quote&gt;</button>
                                        <button type="button" @click="insertTag('<pre><code>', '</code></pre>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;code&gt;</button>
                                    </div>

                                    <div class="flex items-center gap-3 ml-auto sm:ml-0">
                                        <span class="text-[10px] text-slate-400 font-mono" x-text="htmlContent.length + ' chars'"></span>
                                        <button type="button" @click="formatHtml()" class="px-2.5 py-1 bg-brand/20 hover:bg-brand/30 text-brand-light border border-brand/30 rounded-lg text-[10px] font-sans font-bold transition-all cursor-pointer">
                                            ✨ Format HTML
                                        </button>
                                    </div>
                                </div>

                                {{-- Main Big Textarea --}}
                                <textarea
                                    x-ref="htmlTextArea"
                                    x-model="htmlContent"
                                    @input="onHtmlInput($event)"
                                    rows="18"
                                    spellcheck="false"
                                    class="w-full p-5 bg-slate-950 text-emerald-400 font-mono text-sm leading-relaxed border-none outline-none focus:outline-none focus:ring-0 min-h-[480px] resize-y placeholder-slate-600 selection:bg-brand/40"
                                    placeholder="<!-- Write or paste raw HTML markup here -->&#10;<p>Add your story content directly in HTML...</p>"
                                ></textarea>
                            </div>

                            @error('content')
                                <p class="mt-2 text-xs font-bold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Right Column: Settings & AI Copilot --}}
                <div class="lg:col-span-4 space-y-6">

                    {{-- AI Writing Assistant Widget --}}
                    <div class="bg-gradient-to-br from-blue-600/10 via-purple-600/5 to-emerald-500/10 dark:from-blue-500/15 dark:via-purple-500/10 dark:to-emerald-500/15 border border-brand/20 dark:border-brand/30 rounded-3xl p-6 shadow-xs relative overflow-hidden backdrop-blur-xs">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-xl bg-gradient-to-tr from-brand to-purple-600 text-white flex items-center justify-center shadow-md shadow-blue-500/20">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <div>
                                    <h3 class="text-xs font-black text-surface-900 dark:text-white uppercase tracking-wider">AI Content Copilot</h3>
                                    <p class="text-[10px] font-semibold text-brand">Powered by Gemini CLI</p>
                                </div>
                            </div>
                            <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase tracking-wider bg-brand/10 text-brand border border-brand/20">Smart Helper</span>
                        </div>

                        <p class="text-xs text-surface-600 dark:text-surface-300 font-medium mb-4">Select an AI action to generate title ideas, create outlines, or suggest meta tags:</p>
                        
                        <div class="grid grid-cols-2 gap-2.5">
                            <button 
                                type="button" 
                                @click="generateTitles()"
                                :disabled="loading"
                                class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-[10px] font-black uppercase tracking-wider text-surface-800 dark:text-surface-200 hover:border-brand hover:text-brand transition-all shadow-2xs disabled:opacity-50 cursor-pointer"
                            >
                                <span>✨ Titles</span>
                            </button>

                            <button 
                                type="button" 
                                @click="generateOutline()"
                                :disabled="loading"
                                class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-[10px] font-black uppercase tracking-wider text-surface-800 dark:text-surface-200 hover:border-brand hover:text-brand transition-all shadow-2xs disabled:opacity-50 cursor-pointer"
                            >
                                <span>📋 Outline</span>
                            </button>

                            <button 
                                type="button" 
                                @click="suggestKeywords()"
                                :disabled="loading"
                                class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-[10px] font-black uppercase tracking-wider text-surface-800 dark:text-surface-200 hover:border-brand hover:text-brand transition-all shadow-2xs disabled:opacity-50 cursor-pointer"
                            >
                                <span>🏷️ Keywords</span>
                            </button>

                            <button 
                                type="button" 
                                @click="generateSummary()"
                                :disabled="loading"
                                class="flex items-center justify-center gap-1.5 px-3 py-2.5 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-[10px] font-black uppercase tracking-wider text-surface-800 dark:text-surface-200 hover:border-brand hover:text-brand transition-all shadow-2xs disabled:opacity-50 cursor-pointer"
                            >
                                <span>⚡ Summary</span>
                            </button>
                        </div>

                        {{-- Loading indicator --}}
                        <div x-show="loading" class="mt-4 p-3 bg-white/80 dark:bg-surface-900/80 rounded-xl flex items-center justify-center gap-2 border border-brand/20" x-cloak>
                            <svg class="animate-spin h-4 w-4 text-brand" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span class="text-xs font-bold text-brand" x-text="currentTask + '...'"></span>
                        </div>

                        {{-- Result Output Modal/Area --}}
                        <div x-show="result" x-transition class="mt-4 p-4 bg-white dark:bg-[#151f32] rounded-2xl border border-brand/30 shadow-md space-y-3" x-cloak>
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] font-black uppercase tracking-widest text-brand" x-text="currentTask"></span>
                                <button type="button" @click="result = null" class="text-surface-400 hover:text-surface-600 font-bold">&times;</button>
                            </div>
                            <div class="text-xs text-surface-700 dark:text-surface-300 font-medium max-h-48 overflow-y-auto leading-relaxed" x-html="result"></div>
                            
                            <div class="flex items-center gap-2 pt-2 border-t border-surface-100 dark:border-surface-800">
                                <button 
                                    type="button" 
                                    @click="applySuggestion()"
                                    class="px-3 py-1.5 bg-brand hover:bg-blue-600 text-white rounded-lg text-[10px] font-black uppercase tracking-wider transition-all cursor-pointer"
                                >
                                    Apply
                                </button>
                                <button 
                                    type="button" 
                                    @click="copyToClipboard(result)"
                                    class="px-3 py-1.5 bg-surface-100 dark:bg-surface-800 text-surface-600 dark:text-surface-300 rounded-lg text-[10px] font-black uppercase tracking-wider hover:bg-surface-200 transition-all cursor-pointer"
                                >
                                    Copy
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- Featured Image Box --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Featured Cover Image</h3>
                            <span class="text-[10px] font-bold text-surface-400">16:9 Aspect</span>
                        </div>

                        <div class="relative border-2 border-dashed border-surface-200 dark:border-surface-800 rounded-2xl p-4 text-center hover:border-brand transition-all group cursor-pointer bg-surface-50/50 dark:bg-surface-900/50">
                            <template x-if="imageUrl">
                                <div class="relative group/img">
                                    <img :src="imageUrl" class="w-full h-36 object-cover rounded-xl shadow-xs">
                                    <div class="absolute inset-0 bg-black/40 opacity-0 group-hover/img:opacity-100 transition-opacity rounded-xl flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">Change Image</span>
                                    </div>
                                </div>
                            </template>
                            <template x-if="!imageUrl">
                                <div class="py-4 space-y-2">
                                    <div class="w-10 h-10 mx-auto rounded-xl bg-brand/10 text-brand flex items-center justify-center group-hover:scale-110 transition-transform">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <p class="text-xs font-bold text-surface-700 dark:text-surface-300">Click to upload cover image</p>
                                    <p class="text-[10px] font-medium text-surface-400">PNG, JPG, WebP up to 5MB</p>
                                </div>
                            </template>
                            <input type="file" name="featured_image" @change="previewImage($event)" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        </div>
                    </div>

                    {{-- Topic / Category --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Topic / Category</label>
                        <select name="category_id" required class="w-full px-3.5 py-2.5 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs font-bold text-surface-900 dark:text-white focus:outline-none focus:border-brand transition-all cursor-pointer">
                            <option value="">Select a Category...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tags Selection --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Article Tags</label>
                        <div class="flex flex-wrap gap-2 pt-1">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-surface-200 dark:border-surface-800 bg-surface-50 dark:bg-surface-900 text-xs font-bold text-surface-600 dark:text-surface-400 hover:border-brand hover:text-brand cursor-pointer transition-all has-checked:bg-brand/10 has-checked:border-brand has-checked:text-brand">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden" {{ (is_array(old('tags')) && in_array($tag->id, old('tags'))) || (!old('tags') && $post->tags->contains($tag->id)) ? 'checked' : '' }}>
                                    <span>#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Schedule Publishing --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Publish Schedule</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at ? $post->published_at->format('Y-m-d\TH:i') : '') }}" class="w-full px-3.5 py-2.5 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs font-medium text-surface-900 dark:text-white focus:outline-none focus:border-brand transition-all">
                        <p class="text-[10px] font-semibold text-surface-400 italic">Leave empty to publish immediately.</p>
                    </div>

                    {{-- Monetization --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <h3 class="text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Monetization & Links</h3>
                        
                        <label class="flex items-center justify-between p-3 bg-surface-50 dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-800 cursor-pointer">
                            <span class="text-xs font-bold text-surface-800 dark:text-surface-200">Sponsored Content</span>
                            <input type="hidden" name="is_sponsored" value="0">
                            <input type="checkbox" name="is_sponsored" value="1" {{ old('is_sponsored', $post->is_sponsored) ? 'checked' : '' }} class="w-4 h-4 rounded text-brand focus:ring-brand/20 cursor-pointer">
                        </label>

                        <div>
                            <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1.5">Affiliate / Promo Link</label>
                            <input type="url" name="affiliate_link" value="{{ old('affiliate_link', $post->affiliate_link) }}" placeholder="https://example.com/promo" class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
                        </div>
                    </div>

                    {{-- SEO Suite --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">SEO Optimization</h3>
                            <span class="px-2 py-0.5 bg-emerald-500/10 text-[#16a249] text-[9px] font-black uppercase tracking-wider rounded-md border border-emerald-500/20">SEO Ready</span>
                        </div>

                        <div class="space-y-3">
                            <div>
                                <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1">Meta Title</label>
                                <input type="text" name="meta_title" value="{{ old('meta_title', $post->seoMeta?->meta_title) }}" placeholder="Optimized SEO Title..." class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3" placeholder="Search engine description summary..." class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all resize-none">{{ old('meta_description', $post->seoMeta?->meta_description) }}</textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1">Keywords</label>
                                <input type="text" name="meta_keywords" value="{{ old('meta_keywords', is_array($post->seoMeta?->meta_keywords) ? implode(', ', $post->seoMeta->meta_keywords) : $post->seoMeta?->meta_keywords) }}" placeholder="tech, news, updates" class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <script>
            function postEditor() {
                return {
                    editorMode: 'editor',
                    htmlContent: '',

                    initEditor() {
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            this.htmlContent = contentInput.value || '';
                        }

                        document.addEventListener('trix-change', () => {
                            const contentInput = document.getElementById('content');
                            if (contentInput && this.editorMode === 'editor') {
                                this.htmlContent = contentInput.value;
                            }
                        });
                    },

                    switchMode(mode) {
                        if (this.editorMode === mode) return;

                        const contentInput = document.getElementById('content');
                        const trixEl = document.querySelector('trix-editor');

                        if (mode === 'html') {
                            if (contentInput) {
                                this.htmlContent = contentInput.value;
                            }
                            this.editorMode = 'html';
                        } else if (mode === 'editor') {
                            if (contentInput) {
                                contentInput.value = this.htmlContent;
                            }
                            if (trixEl && trixEl.editor) {
                                trixEl.editor.loadHTML(this.htmlContent || '');
                            }
                            this.editorMode = 'editor';
                        }
                    },

                    onHtmlInput(event) {
                        this.htmlContent = event.target.value;
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = this.htmlContent;
                        }
                    },

                    insertTag(openTag, closeTag = '') {
                        const textarea = this.$refs.htmlTextArea;
                        if (!textarea) {
                            this.htmlContent += openTag + closeTag;
                            return;
                        }
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const selectedText = this.htmlContent.substring(start, end);
                        const replacement = openTag + (selectedText || '') + closeTag;
                        this.htmlContent = this.htmlContent.substring(0, start) + replacement + this.htmlContent.substring(end);
                        
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = this.htmlContent;
                        }

                        this.$nextTick(() => {
                            textarea.focus();
                            const newCursorPos = start + openTag.length + (selectedText ? selectedText.length : 0);
                            textarea.setSelectionRange(newCursorPos, newCursorPos);
                        });
                    },

                    formatHtml() {
                        if (!this.htmlContent) return;
                        try {
                            let formatted = '';
                            let reg = /(>)(<)(\/*)/g;
                            let xml = this.htmlContent.replace(reg, '$1\r\n$2$3');
                            let pad = 0;
                            xml.split('\r\n').forEach((node) => {
                                let indent = 0;
                                if (node.match(/.+<\/\w[^>]*>$/)) {
                                    indent = 0;
                                } else if (node.match(/^<\/\w/)) {
                                    if (pad !== 0) pad -= 1;
                                } else if (node.match(/^<\w[^>]*[^\/]>.*$/)) {
                                    indent = 1;
                                } else {
                                    indent = 0;
                                }
                                let padding = '';
                                for (let i = 0; i < pad; i++) {
                                    padding += '  ';
                                }
                                formatted += padding + node + '\r\n';
                                pad += indent;
                            });
                            this.htmlContent = formatted.trim();
                            const contentInput = document.getElementById('content');
                            if (contentInput) {
                                contentInput.value = this.htmlContent;
                            }
                        } catch (e) {
                            console.error(e);
                        }
                    }
                }
            }

            function imagePreview(initialUrl = '') {
                return {
                    imageUrl: initialUrl || null,
                    previewImage(event) {
                        const file = event.target.files[0];
                        if (file) {
                            this.imageUrl = URL.createObjectURL(file);
                        }
                    }
                }
            }

            function aiAssistant() {
                return {
                    loading: false,
                    result: null,
                    currentTask: '',
                    rawContent: '',
                    
                    async generateTitles() {
                        const topic = document.querySelector('textarea[name="title"]').value;
                        if (!topic) return alert('Please enter a topic in the title field first.');
                        
                        this.startTask('Generating Titles');
                        const response = await this.callAI('{{ route('author.ai.titles') }}', { topic });
                        this.finishTask(response);
                    },

                    async generateOutline() {
                        const topic = document.querySelector('textarea[name="title"]').value;
                        if (!topic) return alert('Please enter a topic in the title field first.');
                        
                        this.startTask('Creating Outline');
                        const response = await this.callAI('{{ route('author.ai.outline') }}', { topic });
                        this.finishTask(response);
                    },

                    async suggestKeywords() {
                        const topic = document.querySelector('textarea[name="title"]').value;
                        if (!topic) return alert('Please enter a topic in the title field first.');
                        
                        this.startTask('Suggesting Keywords');
                        const response = await this.callAI('{{ route('author.ai.keywords') }}', { topic });
                        this.finishTask(response);
                    },

                    async generateSummary() {
                        const content = document.querySelector('input[name="content"]').value;
                        if (!content) return alert('Please write some content first.');
                        
                        this.startTask('Generating Summary');
                        const response = await this.callAI('{{ route('author.ai.summary') }}', { content });
                        this.finishTask(response);
                    },

                    startTask(name) {
                        this.loading = true;
                        this.currentTask = name;
                        this.result = null;
                        this.rawContent = '';
                    },

                    finishTask(response) {
                        this.loading = false;
                        if (response && response.content) {
                            this.rawContent = response.content;
                            this.result = response.content.replace(/\n/g, '<br>');
                        } else {
                            this.result = 'Failed to generate content. Please check your AI setup or retry.';
                        }
                    },

                    applySuggestion() {
                        if (this.currentTask === 'Generating Titles') {
                            const matches = this.rawContent.match(/\d\.\s*(.+)/);
                            if (matches && matches[1]) {
                                document.querySelector('textarea[name="title"]').value = matches[1].trim();
                            } else if (this.rawContent) {
                                document.querySelector('textarea[name="title"]').value = this.rawContent.split('\n')[0].trim();
                            }
                        } else if (this.currentTask === 'Generating Summary') {
                            document.querySelector('textarea[name="meta_description"]').value = this.rawContent.trim();
                            document.querySelector('textarea[name="excerpt"]').value = this.rawContent.trim();
                        } else if (this.currentTask === 'Suggesting Keywords') {
                            document.querySelector('input[name="meta_keywords"]').value = this.rawContent.trim();
                        }
                        
                        this.result = null;
                        alert('Suggestion applied!');
                    },

                    async callAI(url, data) {
                        try {
                            const response = await fetch(url, {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify(data)
                            });
                            return await response.json();
                        } catch (e) {
                            console.error(e);
                            return null;
                        }
                    },

                    copyToClipboard(text) {
                        const cleanText = text.replace(/<br>/g, '\n');
                        navigator.clipboard.writeText(cleanText);
                        alert('Copied to clipboard!');
                    }
                }
            }
        </script>
    @endpush
</x-layout>
