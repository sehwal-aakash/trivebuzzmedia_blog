<x-layout>
    <x-slot:title>
        Create New Post - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    {{-- Head for Trix --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <style>
            trix-editor { min-height: 400px !important; }
            .trix-button-group--file-tools { display: none !important; }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-surface-100 dark:border-surface-800">
                <div class="flex items-center gap-4">
                    <a href="{{ route('author.posts.index') }}" class="text-surface-500 hover:text-surface-900 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h1 class="text-2xl font-black text-surface-900 dark:text-white uppercase tracking-tighter">Draft a story</h1>
                </div>
                <div class="flex items-center gap-4">
                    <select name="status" class="bg-transparent border-none text-surface-500 text-sm font-bold focus:ring-0 cursor-pointer hover:text-surface-900 dark:hover:text-white transition-colors">
                        @foreach(\App\Enums\PostStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-form.button size="sm" class="px-8">
                        Publish
                    </x-form.button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                <div class="lg:col-span-8 space-y-8">
                    {{-- Title --}}
                    <textarea 
                        name="title" 
                        rows="1" 
                        required
                        class="w-full text-4xl md:text-5xl font-black border-none bg-transparent focus:ring-0 p-0 dark:text-white placeholder-surface-200 dark:placeholder-surface-800 resize-none tracking-tight leading-tight"
                        placeholder="Title"
                    >{{ old('title') }}</textarea>
                    
                    {{-- Excerpt --}}
                    <textarea 
                        name="excerpt" 
                        rows="2" 
                        class="w-full text-xl font-medium border-none bg-transparent focus:ring-0 p-0 text-surface-500 placeholder-surface-100 dark:placeholder-surface-900 resize-none leading-relaxed"
                        placeholder="Tell your story's summary..."
                    >{{ old('excerpt') }}</textarea>

                    {{-- Content --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <input id="content" type="hidden" name="content" value="{{ old('content') }}">
                        <trix-editor input="content" placeholder="Share your insights..."></trix-editor>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-8">
                    {{-- AI Assistant --}}
                    <div x-data="aiAssistant()" class="bg-gradient-to-br from-brand/5 to-purple-500/5 dark:from-brand/10 dark:to-purple-500/10 border border-brand/10 dark:border-brand/20 rounded-[2rem] p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="p-2.5 bg-brand rounded-xl text-white shadow-lg shadow-brand/30">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-sm font-black text-surface-900 dark:text-white uppercase tracking-widest">AI Writing Assistant</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <button 
                                type="button" 
                                @click="generateTitles()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-5 py-3 bg-white dark:bg-surface-900 border border-brand/10 dark:border-brand/20 rounded-xl text-[10px] font-black uppercase tracking-widest text-brand hover:bg-brand hover:text-white transition-all disabled:opacity-50"
                            >
                                <span>Generate Titles</span>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <svg x-show="loading" class="animate-spin h-4 w-4" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>

                            <button 
                                type="button" 
                                @click="generateOutline()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-5 py-3 bg-white dark:bg-surface-900 border border-brand/10 dark:border-brand/20 rounded-xl text-[10px] font-black uppercase tracking-widest text-brand hover:bg-brand hover:text-white transition-all disabled:opacity-50"
                            >
                                <span>Create Outline</span>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <button 
                                type="button" 
                                @click="suggestKeywords()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-5 py-3 bg-white dark:bg-surface-900 border border-brand/10 dark:border-brand/20 rounded-xl text-[10px] font-black uppercase tracking-widest text-brand hover:bg-brand hover:text-white transition-all disabled:opacity-50"
                            >
                                <span>Suggest Keywords</span>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <button 
                                type="button" 
                                @click="generateSummary()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-5 py-3 bg-white dark:bg-surface-900 border border-brand/10 dark:border-brand/20 rounded-xl text-[10px] font-black uppercase tracking-widest text-brand hover:bg-brand hover:text-white transition-all disabled:opacity-50"
                            >
                                <span>Summarize for Meta</span>
                                <svg x-show="!loading" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>

                        {{-- AI Output Modal/Area --}}
                        <div x-show="result" x-transition class="mt-6 p-6 bg-white dark:bg-surface-950 rounded-2xl border border-brand/20">
                            <div class="flex items-center justify-between mb-4">
                                <span class="text-[10px] font-black uppercase tracking-widest text-brand" x-text="currentTask"></span>
                                <button type="button" @click="result = null" class="text-surface-400 hover:text-surface-600">&times;</button>
                            </div>
                            <div class="text-xs text-surface-600 dark:text-surface-400 prose prose-sm dark:prose-invert font-medium" x-html="result"></div>
                            <button 
                                type="button" 
                                @click="copyToClipboard(result)"
                                class="mt-4 text-[10px] font-black uppercase tracking-widest text-brand hover:underline"
                            >
                                Copy result
                            </button>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <h3 class="text-xs font-black uppercase tracking-widest text-surface-900 dark:text-white mb-6">Featured Image</h3>
                        <label class="block">
                            <span class="sr-only">Choose featured image</span>
                            <input type="file" name="featured_image" class="block w-full text-sm text-surface-500 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:tracking-widest file:bg-brand file:text-white hover:file:bg-brand-dark cursor-pointer transition-all">
                        </label>
                        <p class="mt-4 text-[10px] font-bold text-surface-400 uppercase tracking-widest italic">High-quality images (16:9) work best.</p>
                    </div>

                    {{-- Categories --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <x-form.label value="Topic / Category" />
                        <x-form.select name="category_id" required>
                            <option value="">Select a category</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    {{-- Tags --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <x-form.label value="Tags" />
                        <div class="grid grid-cols-2 gap-4 mt-6">
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded-lg text-brand focus:ring-brand/20 dark:bg-surface-950 dark:border-surface-800" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                    <span class="text-xs font-black uppercase tracking-widest text-surface-400 group-hover:text-surface-900 dark:group-hover:text-white transition-colors">#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Scheduling --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <x-form.label value="Schedule Publishing" />
                        <x-form.input type="datetime-local" name="published_at" />
                        <p class="mt-4 text-[10px] font-bold text-surface-400 uppercase tracking-widest italic">Leave blank for immediate</p>
                    </div>

                    {{-- Monetization --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <x-form.label value="Monetization" />
                        <div class="space-y-6 mt-6">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="hidden" name="is_sponsored" value="0">
                                <input type="checkbox" name="is_sponsored" value="1" {{ old('is_sponsored') ? 'checked' : '' }} class="rounded-lg text-brand focus:ring-brand/20 dark:bg-surface-950 dark:border-surface-800">
                                <span class="text-[10px] font-black uppercase tracking-[0.1em] text-surface-400 group-hover:text-surface-900 dark:group-hover:text-white transition-colors">Mark as Sponsored</span>
                            </label>
                            <div>
                                <x-form.label value="Affiliate / Promo Link" class="text-surface-400 opacity-70" />
                                <x-form.input type="url" name="affiliate_link" value="{{ old('affiliate_link') }}" placeholder="https://example.com/promo" />
                            </div>
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="bg-surface-50 dark:bg-surface-900 border border-surface-100 dark:border-surface-800 rounded-[2rem] p-8">
                        <div class="flex items-center justify-between mb-6">
                            <x-form.label value="SEO Optimization" class="mb-0" />
                            <span class="px-2 py-0.5 bg-brand text-white text-[9px] font-black uppercase tracking-wider rounded">Strategic</span>
                        </div>
                        <div class="space-y-6">
                            <div>
                                <x-form.label value="Meta Title" class="text-surface-400 opacity-70" />
                                <x-form.input type="text" name="meta_title" value="{{ old('meta_title') }}" />
                            </div>
                            <div>
                                <x-form.label value="Meta Description" class="text-surface-400 opacity-70" />
                                <x-form.textarea name="meta_description" rows="3">{{ old('meta_description') }}</x-form.textarea>
                            </div>
                            <div>
                                <x-form.label value="Keywords" class="text-surface-400 opacity-70" />
                                <x-form.input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2" />
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
            function aiAssistant() {
                return {
                    loading: false,
                    result: null,
                    currentTask: '',
                    
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
                            this.result = 'Failed to generate content. Please check your API key.';
                        }
                    },

                    applySuggestion() {
                        if (this.currentTask === 'Generating Titles') {
                            // Take the first title from the numbered list
                            const matches = this.rawContent.match(/\d\.\s*(.+)/);
                            if (matches && matches[1]) {
                                document.querySelector('textarea[name="title"]').value = matches[1].trim();
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
