<x-layout>
    <x-slot:title>
        Author Dashboard - {{ config('app.name') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Author Dashboard</h1>
            <a href="{{ route('author.posts.create') }}" class="inline-flex items-center px-6 py-3 bg-brand dark:bg-brand-light border border-transparent rounded-full font-bold text-sm text-white dark:text-zinc-900 uppercase tracking-widest hover:bg-brand-dark transition ease-in-out duration-150">
                Write a Story
            </a>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Total Stories</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_posts']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1 text-green-600">Published</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['published_posts']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1 text-amber-600">Drafts</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['draft_posts']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Total Reads</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_views']) }}</div>
            </div>
        </div>

        {{-- Analytics Chart --}}
        <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm mb-12">
            <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-8 uppercase tracking-tight">Your Audience Reach (Last 30 Days)</h3>
            <div class="h-[300px]">
                <canvas id="authorAnalyticsChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            {{-- Recent Posts --}}
            <div class="lg:col-span-2">
                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                    <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                        <h3 class="font-bold text-zinc-900 dark:text-white">Your Recent Stories</h3>
                        <a href="{{ route('author.posts.index') }}" class="text-xs text-indigo-600 font-bold hover:underline">View All</a>
                    </div>
                    <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                        @forelse($recentPosts as $post)
                            <div class="px-6 py-4 flex items-center justify-between">
                                <div class="flex-1 min-w-0 pr-4">
                                    <div class="text-sm font-bold text-zinc-900 dark:text-white truncate">{{ $post->title }}</div>
                                    <div class="text-xs text-zinc-500">{{ $post->category->name }} &bull; {{ $post->created_at->format('M d, Y') }}</div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                        {{ $post->status->value }}
                                    </span>
                                    <a href="{{ route('author.posts.edit', $post) }}" class="text-zinc-400 hover:text-zinc-900 dark:hover:text-white">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-5-5l5 5m0 0l5-5m-5 5V3"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-12 text-center text-zinc-500 text-sm italic">
                                You haven't written any stories yet. 
                                <a href="{{ route('author.posts.create') }}" class="text-indigo-600 font-bold hover:underline ml-1">Start writing now.</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar/Actions --}}
            <div class="space-y-6">
                <div class="bg-gradient-to-br from-[#0f1729] to-[#3c83f6] rounded-2xl p-6 text-white shadow-lg shadow-blue-500/10">
                    <h3 class="text-base font-extrabold mb-2 text-white">AI Writing Assistant</h3>
                    <p class="text-blue-100 text-xs leading-relaxed mb-6 font-medium">Need help with a title or an outline? Our AI tools are ready to help you craft your next viral story.</p>
                    <a href="{{ route('author.posts.create') }}" class="inline-block w-full text-center py-3 bg-white text-[#0f1729] rounded-xl text-xs font-black uppercase tracking-wider hover:bg-slate-100 transition-all shadow-sm">
                        Try AI Assistant
                    </a>
                </div>


                <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
                    <h3 class="font-bold text-zinc-900 dark:text-white mb-4">Quick Links</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="{{ route('profile', ['user' => auth()->user()->username]) }}" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-brand flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                View Your Profile
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="text-sm text-zinc-600 dark:text-zinc-400 hover:text-brand flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                General Dashboard
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('authorAnalyticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($analytics['labels']) !!},
                    datasets: [{
                        label: 'Your Views',
                        data: {!! json_encode($analytics['data']) !!},
                        borderColor: '#4f46e5',
                        backgroundColor: 'rgba(79, 70, 229, 0.1)',
                        fill: true,
                        tension: 0.4,
                        borderWidth: 3,
                        pointRadius: 0,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: 'rgba(0,0,0,0.05)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        </script>
    @endpush
</x-layout>
