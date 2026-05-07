<footer class="bg-surface-50 dark:bg-surface-950 border-t border-surface-200 dark:border-surface-900 pt-24 pb-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Top Section: Newsletter & Branding --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 mb-24">
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="group flex items-center gap-2 mb-6">
                    <div class="w-10 h-10 bg-surface-900 dark:bg-white rounded-xl flex items-center justify-center text-white dark:text-surface-900">
                        <span class="text-xl font-black">T</span>
                    </div>
                    <span class="text-xl font-black tracking-tight text-surface-900 dark:text-white uppercase leading-none">TRIVEBUZZ</span>
                </a>
                <p class="text-surface-500 dark:text-surface-400 text-sm leading-relaxed mb-8 max-w-sm">
                    Empowering the next generation of storytellers with AI-assisted insights and a world-class publishing experience. Join the community today.
                </p>
                <div class="flex gap-4">
                    {{-- Social Placeholders --}}
                    @foreach(['twitter', 'github', 'linkedin', 'instagram'] as $social)
                        <a href="#" class="w-10 h-10 rounded-full border border-surface-200 dark:border-surface-800 flex items-center justify-center text-surface-400 hover:text-surface-900 dark:hover:text-white hover:border-surface-900 dark:hover:border-white transition-all">
                            <span class="sr-only">{{ $social }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 3.261 8.077 7.5 8.875v-6.273H7.227v-2.602H9.5V9.75c0-2.25 1.341-3.5 3.398-3.5.984 0 2.016.176 2.016.176v2.211h-1.133c-1.117 0-1.465.693-1.465 1.406v1.68h2.492l-.398 2.602h-2.094v6.273C18.739 20.077 22 16.418 22 12c0-5.523-4.477-10-10-10z"></path></svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-12">
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-surface-900 dark:text-white mb-6">Discover</h4>
                    <ul class="space-y-4">
                        @foreach(\App\Models\Category::take(5)->get() as $category)
                            <li><a href="{{ route('category.show', $category) }}" class="text-sm text-surface-500 hover:text-surface-900 dark:hover:text-white transition-colors">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-surface-900 dark:text-white mb-6">Platform</h4>
                    <ul class="space-y-4 text-sm text-surface-500">
                        <li><a href="{{ route('about') }}" class="hover:text-surface-900 dark:hover:text-white transition-colors">About Us</a></li>
                        <li><a href="{{ route('author.posts.create') }}" class="hover:text-surface-900 dark:hover:text-white transition-colors">Write for us</a></li>
                        <li><a href="{{ route('newsletter.subscribe') }}" class="hover:text-surface-900 dark:hover:text-white transition-colors">Newsletter</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-surface-900 dark:hover:text-white transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-xs font-black uppercase tracking-widest text-surface-900 dark:text-white mb-6">Join the loop</h4>
                    <p class="text-xs text-surface-500 mb-4 leading-relaxed">Weekly curated insights delivered straight to your inbox. No spam, ever.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" required placeholder="email@example.com" class="w-full bg-white dark:bg-surface-900 border-surface-200 dark:border-surface-800 rounded-xl px-4 py-3 text-xs focus:ring-brand dark:focus:ring-brand dark:text-white outline-none transition-all shadow-sm font-medium">
                        <x-form.button type="submit" class="w-full">
                            Subscribe
                        </x-form.button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bottom Section: Credits --}}
        <div class="pt-8 border-t border-surface-200 dark:border-surface-900 flex flex-col md:flex-row justify-between items-center gap-6">
            <div class="text-[10px] font-bold uppercase tracking-widest text-surface-400">
                &copy; {{ date('Y') }} TRIVEBUZZ MEDIA GROUP. All rights reserved.
            </div>
            <div class="flex gap-8">
                <a href="{{ route('privacy') }}" class="text-[10px] font-bold uppercase tracking-widest text-surface-400 hover:text-surface-900 dark:hover:text-white transition-colors">
                    Privacy
                </a>
                <a href="{{ route('terms') }}" class="text-[10px] font-bold uppercase tracking-widest text-surface-400 hover:text-surface-900 dark:hover:text-white transition-colors">
                    Terms
                </a>
                <a href="#" class="text-[10px] font-bold uppercase tracking-widest text-surface-400 hover:text-surface-900 dark:hover:text-white transition-colors">
                    Cookies
                </a>
            </div>
        </div>
    </div>
</footer>
