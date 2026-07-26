<x-layout>
    <x-slot:title>
        Edit Post: {{ $post->title }} - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    {{-- Head for Trix --}}
    @push('styles')
        <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
        <script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
        <style>
            trix-editor { min-height: 400px !important; }
            .trix-button-group--file-tools { display: none !important; }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <form action="{{ route('author.posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="flex items-center justify-between mb-8 pb-4 border-b border-zinc-200 dark:border-zinc-800">
                <div class="flex items-center gap-4">
                    <a href="{{ route('author.posts.index') }}" class="text-zinc-500 hover:text-zinc-900 dark:hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <h1 class="text-2xl font-bold text-zinc-900 dark:text-white">Edit your story</h1>
                </div>
                <div class="flex items-center gap-4">
                    <select name="status" class="bg-transparent border-none text-zinc-500 text-sm font-bold focus:ring-0 cursor-pointer hover:text-zinc-900 dark:hover:text-white transition-colors">
                        @foreach(\App\Enums\PostStatus::cases() as $status)
                            <option value="{{ $status->value }}" {{ old('status', $post->status->value) == $status->value ? 'selected' : '' }}>
                                {{ $status->label() }}
                            </option>
                        @endforeach
                    </select>
                    <x-form.button size="sm" class="px-8">
                        Update
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
                        class="w-full text-4xl md:text-5xl font-extrabold border-none bg-transparent focus:ring-0 p-0 dark:text-white placeholder-zinc-300 dark:placeholder-zinc-700 resize-none"
                        placeholder="Title"
                    >{{ old('title', $post->title) }}</textarea>
                    
                    {{-- Excerpt --}}
                    <textarea 
                        name="excerpt" 
                        rows="2" 
                        class="w-full text-xl font-medium border-none bg-transparent focus:ring-0 p-0 text-zinc-500 placeholder-zinc-200 dark:placeholder-zinc-800 resize-none"
                        placeholder="Tell your story's summary..."
                    >{{ old('excerpt', $post->excerpt) }}</textarea>

                    {{-- Content --}}
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <input id="content" type="hidden" name="content" value="{{ old('content', $post->content) }}">
                        <trix-editor input="content" placeholder="Share your insights..."></trix-editor>
                    </div>
                </div>

                <div class="lg:col-span-4 space-y-8">
                    {{-- AI Assistant --}}
                    <div x-data="aiAssistant()" class="bg-gradient-to-br from-indigo-50 to-purple-50 dark:from-indigo-950/30 dark:to-purple-950/30 border border-indigo-100 dark:border-indigo-900 rounded-xl p-6 shadow-sm">
                        <div class="flex items-center gap-2 mb-4">
                            <div class="p-2 bg-indigo-600 rounded-lg text-white">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-zinc-900 dark:text-white">AI Writing Assistant</h3>
                        </div>
                        
                        <div class="space-y-3">
                            <button 
                                type="button" 
                                @click="generateTitles()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-4 py-2 bg-white dark:bg-zinc-800 border border-indigo-200 dark:border-indigo-900 rounded-lg text-xs font-bold text-indigo-700 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 transition-colors disabled:opacity-50"
                            >
                                <span>Refine Title</span>
                                <svg x-show="!loading" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                <svg x-show="loading" class="animate-spin h-3 w-3" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            </button>

                            <button 
                                type="button" 
                                @click="generateSummary()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-4 py-2 bg-white dark:bg-zinc-800 border border-indigo-200 dark:border-indigo-900 rounded-lg text-xs font-bold text-indigo-700 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 transition-colors disabled:opacity-50"
                            >
                                <span>Update Meta Summary</span>
                                <svg x-show="!loading" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>

                            <button 
                                type="button" 
                                @click="suggestKeywords()"
                                :disabled="loading"
                                class="w-full flex items-center justify-between px-4 py-2 bg-white dark:bg-zinc-800 border border-indigo-200 dark:border-indigo-900 rounded-lg text-xs font-bold text-indigo-700 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-indigo-900/50 transition-colors disabled:opacity-50"
                            >
                                <span>New Keywords</span>
                                <svg x-show="!loading" class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                            </button>
                        </div>

                        {{-- AI Output Modal/Area --}}
                        <div x-show="result" x-transition class="mt-4 p-4 bg-white dark:bg-zinc-900 rounded-lg border border-indigo-100 dark:border-indigo-800">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-bold uppercase text-zinc-400" x-text="currentTask"></span>
                                <button type="button" @click="result = null" class="text-zinc-400 hover:text-zinc-600">&times;</button>
                            </div>
                            <div class="text-xs text-zinc-600 dark:text-zinc-400 prose prose-sm dark:prose-invert" x-html="result"></div>
                            <button 
                                type="button" 
                                @click="copyToClipboard(result)"
                                class="mt-3 text-[10px] font-bold text-indigo-600 hover:underline"
                            >
                                Copy result
                            </button>
                        </div>
                    </div>

                    {{-- Featured Image --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <h3 class="text-sm font-bold text-zinc-900 dark:text-white mb-4">Featured Image</h3>
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="Current" class="w-full aspect-video object-cover rounded-lg mb-4">
                        @endif
                        <label class="block">
                            <span class="sr-only">Choose featured image</span>
                            <input type="file" name="featured_image" class="block w-full text-sm text-zinc-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-bold file:bg-zinc-100 dark:file:bg-zinc-800 file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 dark:hover:file:bg-zinc-700 cursor-pointer">
                        </label>
                    </div>

                    {{-- Categories --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <x-form.label value="Topic / Category" />
                        <x-form.select name="category_id" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                    </div>

                    {{-- Tags --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <x-form.label value="Tags" />
                        <div class="grid grid-cols-2 gap-2 mt-4">
                            @php $postTags = $post->tags->pluck('id')->toArray(); @endphp
                            @foreach($tags as $tag)
                                <label class="flex items-center gap-2 cursor-pointer group">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="rounded-lg text-indigo-600 focus:ring-indigo-500/20 dark:bg-zinc-800 dark:border-zinc-700" {{ is_array(old('tags', $postTags)) && in_array($tag->id, old('tags', $postTags)) ? 'checked' : '' }}>
                                    <span class="text-xs font-bold text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Scheduling --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <x-form.label value="Schedule Publishing" />
                        <x-form.input type="datetime-local" name="published_at" value="{{ old('published_at', $post->published_at?->format('Y-m-d\TH:i')) }}" />
                    </div>

                    {{-- Monetization --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <x-form.label value="Monetization" />
                        <div class="space-y-4 mt-4">
                            <label class="flex items-center gap-3 cursor-pointer group">
                                <input type="hidden" name="is_sponsored" value="0">
                                <input type="checkbox" name="is_sponsored" value="1" {{ old('is_sponsored', $post->is_sponsored) ? 'checked' : '' }} class="rounded-lg text-indigo-600 focus:ring-indigo-500/20 dark:bg-zinc-800 dark:border-zinc-700">
                                <span class="text-xs font-bold uppercase tracking-widest text-zinc-500 group-hover:text-zinc-900 dark:group-hover:text-white transition-colors">Mark as Sponsored</span>
                            </label>
                            <div>
                                <x-form.label value="Affiliate / Promo Link" class="text-zinc-400" />
                                <x-form.input type="url" name="affiliate_link" value="{{ old('affiliate_link', $post->affiliate_link) }}" placeholder="https://example.com/promo" />
                            </div>
                        </div>
                    </div>

                    {{-- SEO --}}
                    <div class="bg-zinc-50 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-xl p-6">
                        <div class="flex items-center justify-between mb-4">
                            <x-form.label value="SEO Optimization" class="mb-0" />
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[9px] font-black uppercase tracking-wider rounded">Live</span>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <x-form.label value="Meta Title" class="text-zinc-400" />
                                <x-form.input type="text" name="meta_title" value="{{ old('meta_title', $post->seoMeta?->title) }}" placeholder="{{ $post->title }}" />
                            </div>
                            <div>
                                <x-form.label value="Meta Description" class="text-zinc-400" />
                                <x-form.textarea name="meta_description" rows="3" placeholder="{{ $post->excerpt }}">{{ old('meta_description', $post->seoMeta?->description) }}</x-form.textarea>
                            </div>
                            <div>
                                <x-form.label value="Keywords" class="text-zinc-400" />
                                <x-form.input type="text" name="meta_keywords" value="{{ old('meta_keywords', $post->seoMeta?->keywords) }}" placeholder="keyword1, keyword2" />
                            </div>
                            
                            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <h4 class="text-[10px] font-black uppercase tracking-widest text-zinc-400 mb-3 text-center">Social Graph</h4>
                                <div class="space-y-4">
                                    <div>
                                        <x-form.label value="Social Title" class="text-zinc-400" />
                                        <x-form.input type="text" name="og_title" value="{{ old('og_title', $post->seoMeta?->og_title) }}" />
                                    </div>
                                    <div>
                                        <x-form.label value="Social Description" class="text-zinc-400" />
                                        <x-form.textarea name="og_description" rows="2">{{ old('og_description', $post->seoMeta?->og_description) }}</x-form.textarea>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800">
                                <div>
                                    <x-form.label value="Canonical URL" class="text-zinc-400" />
                                    <x-form.input type="url" name="canonical_url" value="{{ old('canonical_url', $post->seoMeta?->canonical_url) }}" />
                                </div>
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
                        
                        this.startTask('Refining Title');
                        const response = await this.callAI('{{ route('author.ai.titles') }}', { topic });
                        this.finishTask(response);
                    },

                    async suggestKeywords() {
                        const topic = document.querySelector('textarea[name="title"]').value;
                        if (!topic) return alert('Please enter a topic in the title field first.');
                        
                        this.startTask('Suggesting New Keywords');
                        const response = await this.callAI('{{ route('author.ai.keywords') }}', { topic });
                        this.finishTask(response);
                    },

                    async generateSummary() {
                        const content = document.querySelector('input[name="content"]').value;
                        if (!content) return alert('Please write some content first.');
                        
                        this.startTask('Updating Summary');
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
                        if (this.currentTask === 'Refining Title') {
                            const matches = this.rawContent.match(/\d\.\s*(.+)/);
                            if (matches && matches[1]) {
                                document.querySelector('textarea[name="title"]').value = matches[1].trim();
                            }
                        } else if (this.currentTask === 'Updating Summary') {
                            document.querySelector('textarea[name="meta_description"]').value = this.rawContent.trim();
                            document.querySelector('textarea[name="excerpt"]').value = this.rawContent.trim();
                        } else if (this.currentTask === 'Suggesting New Keywords') {
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
