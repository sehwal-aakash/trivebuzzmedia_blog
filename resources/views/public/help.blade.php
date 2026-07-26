<x-layout :seoTags="$seoTags">

    <div class="max-w-4xl mx-auto px-4 py-12 md:py-16 space-y-10">
        <div class="text-center space-y-4">
            <span class="px-3 py-1 bg-brand/10 text-brand text-xs font-black uppercase tracking-wider rounded-full border border-brand/20">Support & FAQ</span>
            <h1 class="text-3xl md:text-5xl font-black text-slate-900 dark:text-white tracking-tight">Help & Support Center</h1>
            <p class="text-slate-600 dark:text-slate-400 max-w-xl mx-auto text-sm md:text-base leading-relaxed">
                Everything you need to know about reading, publishing, and contributing on TriveBuzz Media.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-3">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">How do I become an author?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Register a free account, complete your profile, and submit an author application from your account dashboard. Our editorial team reviews all applications within 24-48 hours.
                </p>
            </div>

            <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-3">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">What topics can I publish?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    TriveBuzz Media accepts high-quality articles across Technology, AI, Finance, Business, Health, Culture, and News. All content must follow our editorial publishing guidelines.
                </p>
            </div>

            <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-3">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Is publishing free?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Yes! Publishing on TriveBuzz Media is 100% free for approved authors. Approved authors gain access to our rich editor and AI writing tools.
                </p>
            </div>

            <div class="bg-white dark:bg-[#151f32] border border-slate-200/80 dark:border-slate-800 rounded-3xl p-6 shadow-xs space-y-3">
                <h3 class="text-base font-extrabold text-slate-900 dark:text-white">Need additional help?</h3>
                <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                    Have questions or need technical support? Visit our <a href="{{ route('contact') }}" class="text-[#3c83f6] font-bold hover:underline">Contact Page</a> to reach out directly to our support team.
                </p>
            </div>
        </div>
    </div>

</x-layout>
