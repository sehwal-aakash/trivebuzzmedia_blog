<x-layout>
    <x-slot:title>
        Admin Dashboard - {{ config('app.name', 'TriveBuzz Media') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-white">Admin Dashboard</h1>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('admin.users.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Users
                </a>
                <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Categories
                </a>
                <a href="{{ route('admin.tags.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Tags
                </a>
                <a href="{{ route('admin.comments.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Comments
                </a>
                <a href="{{ route('admin.newsletters.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Newsletter
                </a>
                <a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-zinc-100 dark:bg-zinc-800 border border-zinc-300 dark:border-zinc-700 rounded-md font-semibold text-xs text-zinc-700 dark:text-zinc-300 uppercase tracking-widest hover:bg-zinc-200 dark:hover:bg-zinc-700 transition ease-in-out duration-150">
                    Activity Logs
                </a>
            </div>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-6 mb-12">
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Total Posts</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_posts']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Total Views</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_views']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Users</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_users']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1">Subscribers</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['total_subscribers']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1 text-amber-600">Pending Apps</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['pending_applications']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1 text-amber-600">Pending Posts</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['pending_posts']) }}</div>
            </div>
            <div class="bg-white dark:bg-zinc-900 p-6 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="text-zinc-500 text-xs font-bold uppercase mb-1 text-amber-600">Pending Comms</div>
                <div class="text-3xl font-extrabold text-zinc-900 dark:text-white">{{ number_format($stats['pending_comments']) }}</div>
            </div>
        </div>

        {{-- Analytics Chart --}}
        <div class="bg-white dark:bg-zinc-900 p-8 rounded-2xl border border-zinc-200 dark:border-zinc-800 shadow-sm mb-12">
            <h3 class="text-lg font-black text-zinc-900 dark:text-white mb-8 uppercase tracking-tight">Platform Growth (Last 30 Days)</h3>
            <div class="h-[300px]">
                <canvas id="analyticsChart"></canvas>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            {{-- Recent Posts --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                    <h3 class="font-bold text-zinc-900 dark:text-white">Recent Posts</h3>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs text-indigo-600 font-bold hover:underline">View All</a>
                </div>
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($recentPosts as $post)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-zinc-900 dark:text-white">{{ $post->title }}</div>
                                <div class="text-xs text-zinc-500">by {{ $post->author->name }} &bull; {{ $post->created_at->diffForHumans() }}</div>
                            </div>
                            <span class="px-2 py-0.5 text-[10px] font-bold uppercase rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                {{ $post->status->value }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-zinc-500 text-sm italic">No posts yet.</div>
                    @endforelse
                </div>
            </div>

            {{-- Pending Applications --}}
            <div class="bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-zinc-200 dark:border-zinc-700 flex justify-between items-center">
                    <h3 class="font-bold text-zinc-900 dark:text-white">Pending Applications</h3>
                    <a href="{{ route('admin.applications.index') }}" class="text-xs text-indigo-600 font-bold hover:underline">View All</a>
                </div>
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @forelse($recentApplications as $app)
                        <div class="px-6 py-4 flex items-center justify-between">
                            <div>
                                <div class="text-sm font-bold text-zinc-900 dark:text-white">{{ $app->user->name }}</div>
                                <div class="text-xs text-zinc-500">{{ $app->user->email }} &bull; {{ $app->created_at->diffForHumans() }}</div>
                            </div>
                            <a href="{{ route('admin.applications.show', $app) }}" class="px-3 py-1 bg-indigo-600 text-white text-[10px] font-bold rounded hover:bg-indigo-700 transition-colors">Review</a>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-zinc-500 text-sm italic">No pending applications.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($analytics['labels']) !!},
                    datasets: [{
                        label: 'Page Views',
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
