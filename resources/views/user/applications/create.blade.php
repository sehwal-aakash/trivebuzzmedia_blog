<x-layout>
    <x-slot:title>
        Apply for Author - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="mb-10">
            <a href="{{ route('dashboard') }}" class="text-xs font-black uppercase tracking-widest text-surface-500 hover:text-brand transition-colors">
                &larr; Back to dashboard
            </a>
            <h1 class="text-4xl font-black text-surface-900 dark:text-white mt-4 uppercase tracking-tighter">Apply for Author</h1>
            <p class="text-surface-600 dark:text-surface-400 mt-2 font-medium leading-relaxed">
                Share your expertise with our readers. Join our world-class community of writers and start publishing.
            </p>
        </div>

        <div class="bg-white dark:bg-surface-900 shadow-2xl sm:rounded-[2rem] border border-surface-100 dark:border-surface-800 p-8 md:p-12">
            <form action="{{ route('apply.store') }}" method="POST" class="space-y-8">
                @csrf

                <div>
                    <x-form.label for="bio" value="Professional Bio" />
                    <x-form.textarea
                        name="bio"
                        id="bio"
                        rows="5"
                        required
                        placeholder="Tell us about your expertise and what you'd like to write about..."
                    >{{ old('bio') }}</x-form.textarea>
                    <x-input-error :messages="$errors->get('bio')" class="mt-2" />
                </div>

                <div>
                    <x-form.label value="Portfolio & Social Links" />
                    <p class="text-[10px] font-black uppercase tracking-widest text-surface-400 mb-6 italic">Share your previous work or social profiles</p>
                    <div id="links-container" class="space-y-4">
                        <x-form.input
                            type="url"
                            name="portfolio_links[]"
                            placeholder="https://yourportfolio.com"
                        />
                    </div>
                    <button type="button" onclick="addLink()" class="mt-6 text-[10px] font-black uppercase tracking-widest text-brand hover:underline flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Add Another Link
                    </button>
                    <x-input-error :messages="$errors->get('portfolio_links')" class="mt-2" />
                </div>

                <div class="pt-10 border-t border-surface-100 dark:border-surface-800">
                    <x-form.button size="lg">
                        Submit Application
                    </x-form.button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function addLink() {
            const container = document.getElementById('links-container');
            const div = document.createElement('div');
            div.className = 'mt-4';
            div.innerHTML = `
                <input 
                    type="url" 
                    name="portfolio_links[]" 
                    class="w-full px-5 py-3.5 bg-white dark:bg-surface-950 border border-surface-200 dark:border-surface-800 rounded-2xl text-sm dark:text-white placeholder-surface-400 dark:placeholder-surface-600 focus:border-brand focus:ring-4 focus:ring-brand/5 outline-none transition-all shadow-sm hover:border-surface-300 dark:hover:border-surface-700 font-medium"
                    placeholder="https://example.com"
                >
            `;
            container.appendChild(div);
        }
    </script>
</x-layout>
