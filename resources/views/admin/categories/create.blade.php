<x-admin-layout title="Add New Category">

    <div class="space-y-6" x-data="{ 
        name: '{{ old('name', '') }}',
        color: '{{ old('color', '#3c83f6') }}',
        icon: '{{ old('icon', '📂') }}',
        isFeatured: {{ old('is_featured') ? 'true' : 'false' }}
    }">
        
        {{-- Header Bar --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <a href="{{ route('admin.categories.index') }}" class="text-xs font-bold text-[#3c83f6] hover:underline inline-flex items-center gap-1.5 mb-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Categories List
                </a>
                <h1 class="text-xl font-black text-slate-900 dark:text-white tracking-tight">Create Content Category</h1>
                <p class="text-xs font-medium text-slate-500 dark:text-slate-400 mt-1">Configure category identity, color branding, display order, and SEO settings.</p>
            </div>

            {{-- Live Badge Preview --}}
            <div class="px-4 py-2 bg-white dark:bg-[#151f32] border border-slate-200 dark:border-slate-800 rounded-2xl flex items-center gap-3 shadow-xs">
                <span class="text-[10px] font-black uppercase tracking-wider text-slate-400">Live Preview:</span>
                <span 
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-xl text-xs font-black text-white shadow-xs transition-all"
                    :style="`background-color: ${color}`"
                >
                    <span x-text="icon"></span>
                    <span x-text="name || 'Category Name'"></span>
                </span>
            </div>
        </div>

        <form action="{{ route('admin.categories.store') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            @csrf

            {{-- Left Main Settings --}}
            <div class="lg:col-span-8 space-y-6">
                
                {{-- General Details Card --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-6">
                    <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white pb-3 border-b border-slate-100 dark:border-slate-800">
                        General Identity
                    </h3>

                    {{-- Category Name --}}
                    <div class="space-y-1.5">
                        <label for="name" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Category Name <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            x-model="name"
                            required 
                            placeholder="e.g. Technology, AI & Machine Learning, Finance"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                        >
                        @error('name')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Icon / Emoji Selector --}}
                    <div class="space-y-2">
                        <label for="icon" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Category Icon / Emoji
                        </label>
                        <div class="flex items-center gap-3">
                            <input 
                                type="text" 
                                name="icon" 
                                id="icon" 
                                x-model="icon"
                                placeholder="📂"
                                class="w-24 px-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-center text-lg font-bold text-slate-900 dark:text-white focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                            <div class="flex flex-wrap gap-1.5">
                                <template x-for="e in ['📂', '⚡', '💻', '🚀', '📈', '💡', '🎨', '🔥', '🌐', '🛡️', '📊']">
                                    <button 
                                        type="button" 
                                        @click="icon = e"
                                        class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 hover:border-[#3c83f6] flex items-center justify-center text-sm transition-all cursor-pointer"
                                        x-text="e"
                                    ></button>
                                </template>
                            </div>
                        </div>
                    </div>

                    {{-- Color Accent Picker --}}
                    <div class="space-y-2">
                        <label for="color" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Brand Color Accent
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
                                <template x-for="c in ['#3c83f6', '#16a249', '#8b5cf6', '#f59e0b', '#ec4899', '#06b6d4', '#ef4444']">
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
                            Category Description
                        </label>
                        <textarea 
                            name="description" 
                            id="description" 
                            rows="4" 
                            placeholder="Provide a comprehensive summary of what topics and articles are grouped under this category..."
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all resize-none leading-relaxed"
                        >{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-xs font-bold text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- SEO Optimization Suite --}}
                <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800/80 rounded-3xl p-6 md:p-8 shadow-xs space-y-4">
                    <div class="flex items-center justify-between pb-3 border-b border-slate-100 dark:border-slate-800">
                        <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white">
                            Category SEO Optimization
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
                                value="{{ old('meta_title') }}" 
                                placeholder="Custom SEO Title for category landing page..."
                                class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all"
                            >
                        </div>

                        <div class="space-y-1">
                            <label for="meta_description" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Meta Description</label>
                            <textarea 
                                name="meta_description" 
                                id="meta_description" 
                                rows="3" 
                                placeholder="Search engine snippet summary for this category..."
                                class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:border-[#3c83f6] transition-all resize-none"
                            >{{ old('meta_description') }}</textarea>
                        </div>

                        <div class="space-y-1">
                            <label for="meta_keywords" class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Keywords</label>
                            <input 
                                type="text" 
                                name="meta_keywords" 
                                id="meta_keywords" 
                                value="{{ old('meta_keywords') }}" 
                                placeholder="technology, software, news"
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
                        Visibility & Settings
                    </h3>

                    {{-- Featured Switch --}}
                    <label class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 cursor-pointer group">
                        <div>
                            <span class="block text-xs font-extrabold text-slate-800 dark:text-slate-200">Featured Category</span>
                            <span class="text-[10px] font-medium text-slate-400">Promote on home hero & mega menu</span>
                        </div>
                        <input 
                            type="checkbox" 
                            name="is_featured" 
                            value="1" 
                            x-model="isFeatured"
                            class="w-4 h-4 rounded text-[#3c83f6] focus:ring-[#3c83f6]/20 cursor-pointer"
                        >
                    </label>

                    {{-- Sort Order --}}
                    <div class="space-y-1.5">
                        <label for="sort_order" class="block text-xs font-extrabold text-slate-700 dark:text-slate-200 uppercase tracking-wider">
                            Display Sort Order
                        </label>
                        <input 
                            type="number" 
                            name="sort_order" 
                            id="sort_order" 
                            value="{{ old('sort_order', 0) }}" 
                            min="0"
                            class="w-full px-3.5 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-xs font-bold text-slate-900 dark:text-white focus:outline-none focus:border-[#3c83f6] transition-all"
                        >
                        <p class="text-[10px] font-medium text-slate-400">Lower numbers appear first in navigation.</p>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center gap-3">
                        <a href="{{ route('admin.categories.index') }}" class="w-1/2 px-4 py-2.5 bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 text-slate-600 dark:text-slate-300 font-bold text-xs rounded-xl text-center transition-all">
                            Cancel
                        </a>
                        <button type="submit" class="w-1/2 px-4 py-2.5 bg-[#16a249] hover:bg-emerald-700 text-white font-black text-xs uppercase tracking-wider rounded-xl transition-all shadow-md shadow-emerald-600/20">
                            Save Category
                        </button>
                    </div>
                </div>

            </div>
        </form>
    </div>

</x-admin-layout>
