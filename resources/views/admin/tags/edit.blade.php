<x-admin-layout title="Edit Tag">

    <div class="space-y-6" x-data="{ 
        name: '{{ old('name', $tag->name) }}',
        color: '{{ old('color', $tag->color ?? '#3c83f6') }}',
        isTrending: {{ old('is_trending', $tag->is_trending) ? 'true' : 'false' }}
    }">
        
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.tags.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline inline-flex items-center gap-1.5 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Tags List
                </a>
                <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Edit Tag: <span class="text-[#3c83f6]">#{{ $tag->name }}</span></h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Configure hashtag identity, color pill badge, trending status, and SEO metadata.</p>
            </div>

            {{-- Live Badge Preview --}}
            <div class="px-4 py-2 bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center gap-3 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Pill Preview:</span>
                <span 
                    class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-black text-white shadow-xs transition-all"
                    :style="`background-color: ${color}`"
                >
                    <span>#</span>
                    <span x-text="name ? name.replace(/^#/, '') : 'tagname'"></span>
                </span>
            </div>
        </div>

        <form action="{{ route('admin.tags.update', $tag) }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf
            @method('PUT')

            {{-- Left Main Settings --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- General Details Card --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white pb-3 border-b border-slate-100 dark:border-slate-800">
                        Hashtag Details
                    </h3>

                    {{-- Tag Name --}}
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Tag Name <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-3 text-slate-400 font-black text-sm">#</span>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                x-model="name"
                                required 
                                placeholder="tech, ai, news"
                                class="w-full pl-8 pr-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                        </div>
                        @error('name')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Color Accent Picker --}}
                    <div class="space-y-2">
                        <label for="color" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Badge Accent Color
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="color" 
                                x-model="color" 
                                class="w-10 h-10 rounded-xl border border-slate-200 dark:border-slate-800 cursor-pointer p-0.5 bg-white dark:bg-slate-900"
                            >
                            <input 
                                type="text" 
                                name="color" 
                                id="color" 
                                x-model="color"
                                placeholder="#3c83f6"
                                class="w-32 px-3.5 py-2 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                            <div class="flex items-center gap-1.5">
                                <template x-for="c in ['#3c83f6', '#8b5cf6', '#16a249', '#f59e0b', '#ec4899', '#06b6d4', '#ef4444', '#64748b']">
                                    <button 
                                        type="button" 
                                        @click="color = c"
                                        class="w-6 h-6 rounded-lg transition-transform hover:scale-110 cursor-pointer border border-white/20 shadow-xs"
                                        :style="`background-color: ${c}`"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="space-y-1.5">
                        <label for="description" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Tag Description
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            placeholder="Provide a brief explanation of what articles should be tagged with this keyword..."
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all resize-none leading-relaxed"
                        >{{ old('description', $tag->description) }}</textarea>
                        @error('description')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- SEO Optimization Suite --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white">
                            Tag SEO Optimization
                        </h3>
                        <span class="px-2 py-0.5 bg-emerald-500/10 text-[#16a249] text-[9px] font-black uppercase tracking-wider rounded-md border border-emerald-500/20">Search Ready</span>
                    </div>

                    <div class="space-y-4">
                        <div class="space-y-1">
                            <label for="meta_title" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Meta Title</label>
                            <input 
                                type="text" 
                                name="meta_title" 
                                id="meta_title" 
                                value="{{ old('meta_title', $tag->meta_title) }}" 
                                placeholder="Custom SEO Title for tag archive page..."
                                class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="meta_description" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Meta Description</label>
                            <textarea 
                                name="meta_description" 
                                id="meta_description" 
                                rows="3" 
                                placeholder="Search engine snippet summary for this tag archive..."
                                class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all resize-none"
                            >{{ old('meta_description', $tag->meta_description) }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label for="meta_keywords" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keywords</label>
                            <input 
                                type="text" 
                                name="meta_keywords" 
                                id="meta_keywords" 
                                value="{{ old('meta_keywords', $tag->meta_keywords) }}" 
                                placeholder="tag, topic, articles"
                                class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Sidebar Controls --}}
            <div class="lg:col-span-4 space-y-6">
                
                {{-- Visibility & Promotion Card --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 shadow-xs space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white pb-3 border-b border-slate-100 dark:border-slate-800">
                        Status & Actions
                    </h3>

                    {{-- Trending Switch --}}
                    <label class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 cursor-pointer group">
                        <div>
                            <span class="block text-xs font-extrabold text-slate-800 dark:text-slate-200">Trending Tag</span>
                            <span class="text-[10px] font-medium text-slate-400">Highlight in trending hashtag widgets</span>
                        </div>
                        <input 
                            type="checkbox" 
                            name="is_trending" 
                            value="1" 
                            x-model="isTrending"
                            class="w-4 h-4 rounded text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                        >
                    </label>

                    {{-- Action Buttons --}}
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-3">
                        <a href="{{ route('admin.tags.index') }}" class="w-1/2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-xl text-center transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="w-1/2 px-4 py-2.5 bg-[#3c83f6] hover:bg-blue-600 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md shadow-blue-500/20">
                            Update Tag
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</x-admin-layout>
