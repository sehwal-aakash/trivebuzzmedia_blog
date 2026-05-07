<x-layout>
    <x-slot:title>
        Dashboard - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="bg-white dark:bg-surface-900 overflow-hidden shadow-xl sm:rounded-2xl border border-surface-200 dark:border-surface-800">
            <div class="p-8 text-surface-900 dark:text-surface-100">
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-surface-500 dark:text-surface-400 mb-10">
                    Your current account level is <span class="px-2 py-0.5 bg-brand/10 text-brand dark:text-brand-light rounded font-bold uppercase text-[10px] tracking-widest">{{ auth()->user()->role->value }}</span>.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="group p-8 bg-brand/5 dark:bg-brand-light/5 rounded-2xl border border-brand/20 hover:border-brand transition-all">
                            <h3 class="font-black text-lg mb-2 text-brand dark:text-brand-light uppercase tracking-widest">Admin Control</h3>
                            <p class="text-sm text-surface-500 group-hover:text-surface-700 dark:group-hover:text-surface-300">Access platform statistics, author applications, and global moderation tools.</p>
                        </a>
                    @endif

                    @if(auth()->user()->isAuthor() || auth()->user()->isAdmin())
                        <a href="{{ route('author.posts.index') }}" class="group p-8 bg-surface-50 dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 hover:border-brand transition-all">
                            <h3 class="font-black text-lg mb-2 text-surface-900 dark:text-white uppercase tracking-widest group-hover:text-brand">Manage Posts</h3>
                            <p class="text-sm text-surface-500 group-hover:text-surface-700 dark:group-hover:text-surface-300">Create, edit, and orchestrate your storytelling workflow with AI assistance.</p>
                        </a>
                    @endif

                    @if(!auth()->user()->isAuthor() && !auth()->user()->isAdmin())
                        <a href="{{ route('apply.create') }}" class="group p-8 bg-surface-50 dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 hover:border-brand transition-all">
                            <h3 class="font-black text-lg mb-2 text-brand uppercase tracking-widest">Become Author</h3>
                            <p class="text-sm text-surface-500 group-hover:text-surface-700 dark:group-hover:text-surface-300">Submit your application to join our world-class community of writers.</p>
                        </a>
                    @endif

                    <a href="{{ route('account.edit') }}" class="group p-8 bg-surface-50 dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 hover:border-brand transition-all">
                        <h3 class="font-black text-lg mb-2 text-surface-900 dark:text-white uppercase tracking-widest group-hover:text-brand">Account</h3>
                        <p class="text-sm text-surface-500 group-hover:text-surface-700 dark:group-hover:text-surface-300">Update your security settings and personal profile information.</p>
                    </a>

                    <a href="{{ route('library') }}" class="group p-8 bg-surface-50 dark:bg-surface-800 rounded-2xl border border-surface-200 dark:border-surface-700 hover:border-brand transition-all">
                        <h3 class="font-black text-lg mb-2 text-surface-900 dark:text-white uppercase tracking-widest group-hover:text-brand">Library</h3>
                        <p class="text-sm text-surface-500 group-hover:text-surface-700 dark:group-hover:text-surface-300">Quickly access the stories you've bookmarked for later reading.</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layout>
