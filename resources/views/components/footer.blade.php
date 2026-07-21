<footer class="bg-white dark:bg-[#0f1729] border-t border-slate-200/80 dark:border-slate-800/80 pt-20 pb-12 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        {{-- Top Section: Newsletter & Branding --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 mb-16">
            <div class="lg:col-span-4">
                <a href="{{ route('home') }}" class="group flex items-center gap-3 mb-5">
                    <div class="w-10 h-10 bg-[#0f1729] dark:bg-slate-800 border border-slate-700/50 rounded-xl flex items-center justify-center text-white shadow-md">
                        <span class="text-xl font-black text-transparent bg-clip-text bg-gradient-to-tr from-[#3c83f6] to-[#16a249]">T</span>
                    </div>
                    <span class="text-xl font-black tracking-tight text-[#0f1729] dark:text-white uppercase leading-none font-sans">TRIVEBUZZ</span>
                </a>
                <p class="text-[#344256] dark:text-slate-400 text-sm leading-relaxed mb-6 max-w-sm">
                    Empowering the next generation of storytellers with AI-assisted insights and a world-class publishing experience. Join the community today.
                </p>
                <div class="flex gap-3">
                    {{-- Social Placeholders --}}
                    @foreach(['twitter', 'github', 'linkedin', 'instagram'] as $social)
                        <a href="#" class="w-9 h-9 rounded-xl border border-slate-200 dark:border-slate-800 flex items-center justify-center text-slate-400 hover:text-[#3c83f6] dark:hover:text-[#3c83f6] hover:border-[#3c83f6] dark:hover:border-[#3c83f6] transition-all hover:scale-105">
                            <span class="sr-only">{{ $social }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.477 2 2 6.477 2 12c0 4.418 3.261 8.077 7.5 8.875v-6.273H7.227v-2.602H9.5V9.75c0-2.25 1.341-3.5 3.398-3.5.984 0 2.016.176 2.016.176v2.211h-1.133c-1.117 0-1.465.693-1.465 1.406v1.68h2.492l-.398 2.602h-2.094v6.273C18.739 20.077 22 16.418 22 12c0-5.523-4.477-10-10-10z"></path></svg>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="lg:col-span-8 grid grid-cols-2 md:grid-cols-3 gap-10">
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#0f1729] dark:text-white mb-5">Discover</h4>
                    <ul class="space-y-3">
                        @foreach(\App\Models\Category::take(5)->get() as $category)
                            <li><a href="{{ route('category.show', $category) }}" class="text-sm font-medium text-[#344256] hover:text-[#3c83f6] dark:text-slate-400 dark:hover:text-[#3c83f6] transition-colors">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#0f1729] dark:text-white mb-5">Platform</h4>
                    <ul class="space-y-3 text-sm font-medium text-[#344256] dark:text-slate-400">
                        <li><a href="{{ route('about') }}" class="hover:text-[#3c83f6] dark:hover:text-[#3c83f6] transition-colors">About Us</a></li>
                        <li><a href="{{ route('author.posts.create') }}" class="hover:text-[#3c83f6] dark:hover:text-[#3c83f6] transition-colors">Write for us</a></li>
                        <li><a href="{{ route('contact') }}" class="hover:text-[#3c83f6] dark:hover:text-[#3c83f6] transition-colors">Contact</a></li>
                    </ul>
                </div>
                <div class="col-span-2 md:col-span-1">
                    <h4 class="text-xs font-black uppercase tracking-widest text-[#0f1729] dark:text-white mb-5">Join the newsletter</h4>
                    <p class="text-xs text-[#344256] dark:text-slate-400 mb-4 leading-relaxed">Weekly curated insights delivered straight to your inbox.</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST" class="space-y-3">
                        @csrf
                        <input type="email" name="email" required placeholder="email@example.com" class="w-full bg-[#F8FAFC99] dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl px-4 py-2.5 text-xs focus:ring-2 focus:ring-[#3c83f6] focus:border-[#3c83f6] dark:text-white outline-none transition-all font-medium">
                        <button type="submit" class="w-full py-2.5 px-4 bg-[#16a249] hover:bg-emerald-700 text-white rounded-xl text-xs font-extrabold uppercase tracking-wider transition-all shadow-md shadow-emerald-600/20 active:scale-95">
                            Subscribe Now
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bottom Section: Credits --}}
        <div class="pt-8 border-t border-slate-200/80 dark:border-slate-800/80 flex flex-col md:flex-row justify-between items-center gap-4">
            <div class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400">
                &copy; {{ date('Y') }} TRIVEBUZZ MEDIA GROUP. All rights reserved.
            </div>
            <div class="flex gap-6">
                <a href="{{ route('privacy') }}" class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 hover:text-[#3c83f6] dark:hover:text-white transition-colors">
                    Privacy
                </a>
                <a href="{{ route('terms') }}" class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 hover:text-[#3c83f6] dark:hover:text-white transition-colors">
                    Terms
                </a>
            </div>
        </div>
    </div>
</footer>

