<x-layout>
    <x-slot:title>
        Create New Post - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>



    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" x-data="{ ...aiAssistant(), ...imagePreview(), ...postEditor() }" x-init="initEditor()">
        <form action="{{ route('author.posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            {{-- Header Action Bar --}}
            <div class="sticky top-0 z-40 bg-surface-50/90 dark:bg-[#0f1729]/90 backdrop-blur-md py-4 mb-8 border-b border-surface-200/70 dark:border-surface-800/80 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-all">
                <div class="flex items-center gap-3">
                    <a href="{{ route('author.posts.index') }}" class="p-2 rounded-xl text-surface-500 hover:text-surface-900 dark:hover:text-white hover:bg-surface-200/60 dark:hover:bg-surface-800/60 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    </a>
                    <div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            <span class="text-[11px] font-black uppercase tracking-widest text-surface-400">Drafting Story</span>
                        </div>
                        <h1 class="text-xl font-black text-surface-900 dark:text-white tracking-tight">Create New Article</h1>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div class="relative">
                        <select name="status" class="appearance-none pl-3.5 pr-8 py-2 bg-white dark:bg-[#151f32] border border-surface-200 dark:border-surface-800 rounded-xl text-xs font-bold text-surface-700 dark:text-surface-200 focus:outline-none focus:border-brand transition-all cursor-pointer">
                            @foreach(\App\Enums\PostStatus::cases() as $status)
                                <option value="{{ $status->value }}" {{ old('status') == $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        <svg class="w-4 h-4 text-surface-400 absolute right-2.5 top-3 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <x-form.button size="sm" class="px-6 py-2.5 bg-gradient-to-r from-brand to-blue-600 hover:from-blue-600 hover:to-brand text-white font-black text-xs uppercase tracking-wider rounded-xl shadow-lg shadow-blue-500/25 transition-all">
                        Publish Story
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
                                >{{ old('title') }}</textarea>
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
                                >{{ old('excerpt') }}</textarea>
                            </div>
                            @error('excerpt')
                                <p class="mt-1 text-xs font-bold text-rose-500">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Direct 3 Code Boxes for HTML, CSS, and JS --}}
                        <div class="space-y-6 pt-2">
                            <div>
                                <label class="block text-[11px] font-black uppercase tracking-wider text-surface-400">Story Body Code</label>
                                <p class="text-[10px] text-surface-500 dark:text-surface-400 font-medium">Directly add your custom HTML markup, CSS styling, and JavaScript code below.</p>
                            </div>

                            {{-- Hidden Content Input for Form Submission --}}
                            <input id="content" type="hidden" name="content" value="{{ old('content') }}">

                            {{-- Header Info Banner --}}
                            <div class="p-4 bg-slate-900 border border-slate-800 rounded-2xl flex flex-wrap items-center justify-between gap-3 text-xs font-mono">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center font-bold text-sm">
                                        &lt;/&gt;
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-200 uppercase tracking-wider text-[11px]">HTML / CSS / JS Editor</h4>
                                        <p class="text-[10px] text-slate-400 font-sans">Separate dedicated boxes for CSS styles, HTML content body, and JavaScript logic.</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    <button type="button" @click="formatHtml()" class="px-3 py-1.5 bg-slate-800 hover:bg-slate-700 text-slate-200 rounded-xl text-xs font-sans font-bold border border-slate-700 transition-all cursor-pointer">
                                        ✨ Format HTML
                                    </button>
                                </div>
                            </div>

                            {{-- Box 1: Styles (CSS) --}}
                            <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-lg bg-slate-950">
                                <div class="flex items-center justify-between px-4 py-2.5 bg-slate-900 border-b border-slate-800 text-xs font-mono">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-sky-400"></span>
                                        <span class="font-bold text-sky-300 uppercase tracking-widest text-[11px]">1. Styles (CSS)</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500 font-sans">Embedded inside &lt;style&gt;&lt;/style&gt;</span>
                                </div>
                                <textarea
                                    x-model="htmlStyles"
                                    @input="onHtmlChange()"
                                    rows="6"
                                    spellcheck="false"
                                    class="w-full p-4 bg-slate-950 text-sky-300 font-mono text-sm leading-relaxed border-none outline-none focus:outline-none focus:ring-0 min-h-[140px] resize-y placeholder-slate-600 selection:bg-sky-500/30"
                                    placeholder="/* Enter custom CSS rules here (without <style> tags) */&#10;.my-custom-card { padding: 20px; background: #1e293b; border-radius: 12px; }&#10;.my-heading { color: #38bdf8; font-weight: 800; }"
                                ></textarea>
                            </div>

                            {{-- Box 2: Content (HTML) --}}
                            <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-lg bg-slate-950">
                                <div class="flex flex-wrap items-center justify-between gap-2 px-4 py-2.5 bg-slate-900 border-b border-slate-800 text-xs font-mono">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-400"></span>
                                        <span class="font-bold text-emerald-300 uppercase tracking-widest text-[11px]">2. Content (HTML Body)</span>
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
                                        <button type="button" @click="insertTag('<div class=\'my-card\'>', '</div>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;div&gt;</button>
                                        <button type="button" @click="insertTag('<blockquote>', '</blockquote>')" class="px-2 py-0.5 bg-slate-800 hover:bg-slate-700 text-slate-300 rounded text-[11px] font-mono transition-all hover:text-white cursor-pointer">&lt;quote&gt;</button>
                                    </div>
                                </div>
                                <textarea
                                    x-ref="htmlContentTextArea"
                                    x-model="htmlContent"
                                    @input="onHtmlChange()"
                                    rows="12"
                                    spellcheck="false"
                                    class="w-full p-4 bg-slate-950 text-emerald-400 font-mono text-sm leading-relaxed border-none outline-none focus:outline-none focus:ring-0 min-h-[300px] resize-y placeholder-slate-600 selection:bg-emerald-500/30"
                                    placeholder="<!-- Write HTML body markup here -->&#10;<div class=&quot;my-custom-card&quot;>&#10;  <h2 class=&quot;my-heading&quot;>Hello World</h2>&#10;  <p>Write your article HTML content here...</p>&#10;</div>"
                                ></textarea>
                            </div>

                            {{-- Box 3: Scripts (JavaScript) --}}
                            <div class="rounded-2xl overflow-hidden border border-slate-800 shadow-lg bg-slate-950">
                                <div class="flex items-center justify-between px-4 py-2.5 bg-slate-900 border-b border-slate-800 text-xs font-mono">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-amber-400"></span>
                                        <span class="font-bold text-amber-300 uppercase tracking-widest text-[11px]">3. Scripts (JavaScript)</span>
                                    </div>
                                    <span class="text-[10px] text-slate-500 font-sans">Embedded inside &lt;script&gt;&lt;/script&gt;</span>
                                </div>
                                <textarea
                                    x-model="htmlScripts"
                                    @input="onHtmlChange()"
                                    rows="6"
                                    spellcheck="false"
                                    class="w-full p-4 bg-slate-950 text-amber-300 font-mono text-sm leading-relaxed border-none outline-none focus:outline-none focus:ring-0 min-h-[140px] resize-y placeholder-slate-600 selection:bg-amber-500/30"
                                    placeholder="// Enter custom JavaScript code here (without <script> tags)&#10;document.addEventListener('DOMContentLoaded', function() {&#10;  console.log('Post custom script executing...');&#10;});"
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
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
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
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" class="hidden" {{ is_array(old('tags')) && in_array($tag->id, old('tags')) ? 'checked' : '' }}>
                                    <span>#{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Schedule Publishing --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-3">
                        <label class="block text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Publish Schedule</label>
                        <input type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="w-full px-3.5 py-2.5 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs font-medium text-surface-900 dark:text-white focus:outline-none focus:border-brand transition-all">
                        <p class="text-[10px] font-semibold text-surface-400 italic">Leave empty to publish immediately.</p>
                    </div>

                    {{-- Monetization --}}
                    <div class="bg-white dark:bg-[#151f32] border border-surface-200/80 dark:border-surface-800/80 rounded-3xl p-6 shadow-xs space-y-4">
                        <h3 class="text-xs font-black uppercase tracking-wider text-surface-900 dark:text-white">Monetization & Links</h3>
                        
                        <label class="flex items-center justify-between p-3 bg-surface-50 dark:bg-surface-900 rounded-xl border border-surface-200 dark:border-surface-800 cursor-pointer">
                            <span class="text-xs font-bold text-surface-800 dark:text-surface-200">Sponsored Content</span>
                            <input type="hidden" name="is_sponsored" value="0">
                            <input type="checkbox" name="is_sponsored" value="1" {{ old('is_sponsored') ? 'checked' : '' }} class="w-4 h-4 rounded text-brand focus:ring-brand/20 cursor-pointer">
                        </label>

                        <div>
                            <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1.5">Affiliate / Promo Link</label>
                            <input type="url" name="affiliate_link" value="{{ old('affiliate_link') }}" placeholder="https://example.com/promo" class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
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
                                <input type="text" name="meta_title" value="{{ old('meta_title') }}" placeholder="Optimized SEO Title..." class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1">Meta Description</label>
                                <textarea name="meta_description" rows="3" placeholder="Search engine description summary..." class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all resize-none">{{ old('meta_description') }}</textarea>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-surface-500 uppercase tracking-wider mb-1">Keywords</label>
                                <input type="text" name="meta_keywords" value="{{ old('meta_keywords') }}" placeholder="tech, news, updates" class="w-full px-3.5 py-2 bg-surface-50 dark:bg-surface-900 border border-surface-200 dark:border-surface-800 rounded-xl text-xs text-surface-900 dark:text-white placeholder-surface-400 focus:outline-none focus:border-brand transition-all">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>

    @push('scripts')
        <script>
            function postEditor() {
                return {
                    htmlStyles: '',
                    htmlContent: '',
                    htmlScripts: '',

                    initEditor() {
                        const contentInput = document.getElementById('content');
                        const initialVal = contentInput ? contentInput.value || '' : '';

                        if (initialVal) {
                            this.parseHtmlContent(initialVal);
                        }
                    },

                    parseHtmlContent(raw) {
                        let styles = '';
                        let scripts = '';
                        let body = raw;

                        const styleRegex = new RegExp('<style[\\s\\S]*?>([\\s\\S]*?)<\\/style>', 'gi');
                        const scriptRegex = new RegExp('<script[\\s\\S]*?>([\\s\\S]*?)<\\/script>', 'gi');

                        body = body.replace(styleRegex, (match, p1) => {
                            styles += p1.trim() + '\n';
                            return '';
                        });

                        body = body.replace(scriptRegex, (match, p1) => {
                            scripts += p1.trim() + '\n';
                            return '';
                        });

                        this.htmlStyles = styles.trim();
                        this.htmlContent = body.trim();
                        this.htmlScripts = scripts.trim();
                    },

                    getComposedHtml() {
                        let result = '';
                        if (this.htmlStyles && this.htmlStyles.trim()) {
                            result += '<style>\n' + this.htmlStyles.trim() + '\n</style>\n\n';
                        }
                        if (this.htmlContent) {
                            result += this.htmlContent;
                        }
                        if (this.htmlScripts && this.htmlScripts.trim()) {
                            result += '\n\n<script>\n' + this.htmlScripts.trim() + '\n<' + '/script>';
                        }
                        return result;
                    },

                    onHtmlChange() {
                        const contentInput = document.getElementById('content');
                        if (contentInput) {
                            contentInput.value = this.getComposedHtml();
                        }
                    },

                    insertTag(openTag, closeTag = '') {
                        const textarea = this.$refs.htmlContentTextArea;
                        if (!textarea) {
                            this.htmlContent += openTag + closeTag;
                            this.onHtmlChange();
                            return;
                        }
                        const start = textarea.selectionStart;
                        const end = textarea.selectionEnd;
                        const selectedText = this.htmlContent.substring(start, end);
                        const replacement = openTag + (selectedText || '') + closeTag;
                        this.htmlContent = this.htmlContent.substring(0, start) + replacement + this.htmlContent.substring(end);
                        
                        this.onHtmlChange();

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
                            this.onHtmlChange();
                        } catch (e) {
                            console.error(e);
                        }
                    }
                }
            }

            function imagePreview() {
                return {
                    imageUrl: null,
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
