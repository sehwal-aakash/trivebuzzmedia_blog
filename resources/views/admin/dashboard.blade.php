<x-admin-layout title="Admin Dashboard">

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-8">
        {{-- Total Posts --}}
        <div class="bg-white dark:bg-[#0f1729] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Posts</span>
                <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-[#3c83f6] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-[#0f1729] dark:text-white font-sans">{{ number_format($stats['total_posts']) }}</div>
            <div class="mt-2 flex items-center text-xs font-bold text-[#16a249] gap-1">
                <span>Published Content</span>
            </div>
        </div>

        {{-- Total Views --}}
        <div class="bg-white dark:bg-[#0f1729] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Views</span>
                <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-[#16a249] flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-[#0f1729] dark:text-white font-sans">{{ number_format($stats['total_views']) }}</div>
            <div class="mt-2 flex items-center text-xs font-bold text-[#16a249] gap-1">
                <span>Overall Pageviews</span>
            </div>
        </div>

        {{-- Registered Users --}}
        <div class="bg-white dark:bg-[#0f1729] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Total Users</span>
                <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-500 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-[#0f1729] dark:text-white font-sans">{{ number_format($stats['total_users']) }}</div>
            <div class="mt-2 flex items-center text-xs font-bold text-[#3c83f6] gap-1">
                <span>Community Members</span>
            </div>
        </div>

        {{-- Newsletter Subscribers --}}
        <div class="bg-white dark:bg-[#0f1729] p-6 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm relative overflow-hidden group hover:shadow-lg transition-all">
            <div class="flex items-center justify-between mb-4">
                <span class="text-xs font-black uppercase tracking-wider text-slate-400">Subscribers</span>
                <div class="w-10 h-10 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-500 flex items-center justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
            </div>
            <div class="text-3xl font-black text-[#0f1729] dark:text-white font-sans">{{ number_format($stats['total_subscribers']) }}</div>
            <div class="mt-2 flex items-center text-xs font-bold text-purple-500 gap-1">
                <span>Newsletter Audience</span>
            </div>
        </div>
    </div>

    {{-- Pending Moderation Queue Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-amber-50/70 dark:bg-amber-950/20 p-5 rounded-2xl border border-amber-200/60 dark:border-amber-900/40 flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-amber-700 dark:text-amber-400 mb-1">Pending Author Apps</p>
                <p class="text-2xl font-black text-amber-900 dark:text-amber-200 font-sans">{{ number_format($stats['pending_applications']) }}</p>
            </div>
            <a href="{{ route('admin.applications.index') }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-extrabold shadow-sm transition-all">Review</a>
        </div>

        <div class="bg-amber-50/70 dark:bg-amber-950/20 p-5 rounded-2xl border border-amber-200/60 dark:border-amber-900/40 flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-amber-700 dark:text-amber-400 mb-1">Pending Post Drafts</p>
                <p class="text-2xl font-black text-amber-900 dark:text-amber-200 font-sans">{{ number_format($stats['pending_posts']) }}</p>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-extrabold shadow-sm transition-all">Moderate</a>
        </div>

        <div class="bg-amber-50/70 dark:bg-amber-950/20 p-5 rounded-2xl border border-amber-200/60 dark:border-amber-900/40 flex items-center justify-between">
            <div>
                <p class="text-xs font-black uppercase tracking-wider text-amber-700 dark:text-amber-400 mb-1">Pending Comments</p>
                <p class="text-2xl font-black text-amber-900 dark:text-amber-200 font-sans">{{ number_format($stats['pending_comments']) }}</p>
            </div>
            <a href="{{ route('admin.comments.index') }}" class="px-3.5 py-2 bg-amber-600 hover:bg-amber-700 text-white rounded-xl text-xs font-extrabold shadow-sm transition-all">Approve</a>
        </div>
    </div>

    {{-- Analytics Chart --}}
    <div class="bg-white dark:bg-[#0f1729] p-6 md:p-8 rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm mb-8">
        <div class="flex items-center justify-between mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
            <div>
                <h3 class="text-base font-black text-[#0f1729] dark:text-white uppercase tracking-wider font-sans">Platform Growth (Last 30 Days)</h3>
                <p class="text-xs font-medium text-slate-400 mt-1">Aggregated daily readership & engagement traffic analytics</p>
            </div>
        </div>
        <div class="h-[280px]">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>

    {{-- Recent Items Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Recent Posts --}}
        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/40">
                    <h3 class="text-xs font-black uppercase tracking-wider text-[#0f1729] dark:text-white font-sans">Recent Content Submissions</h3>
                    <a href="{{ route('admin.posts.index') }}" class="text-xs text-[#3c83f6] font-bold hover:underline">View All &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentPosts as $post)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <div class="pr-4">
                                <a href="{{ route('posts.show', $post->slug) }}" class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100 hover:text-[#3c83f6] transition-colors line-clamp-1">
                                    {{ $post->title }}
                                </a>
                                <p class="text-xs font-medium text-slate-400 mt-0.5">by {{ $post->author->name }} &bull; {{ $post->created_at->diffForHumans() }}</p>
                            </div>
                            <span class="shrink-0 px-2.5 py-1 text-[10px] font-black uppercase tracking-wider rounded-lg {{ $post->status->value === 'published' ? 'bg-emerald-50 text-[#16a249] dark:bg-emerald-950/50' : 'bg-amber-50 text-amber-600 dark:bg-amber-950/50' }}">
                                {{ $post->status->value }}
                            </span>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-slate-400 text-xs italic">No posts submitted yet.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Pending Author Applications --}}
        <div class="bg-white dark:bg-[#0f1729] rounded-2xl border border-slate-200/80 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col justify-between">
            <div>
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center bg-slate-50/50 dark:bg-slate-900/40">
                    <h3 class="text-xs font-black uppercase tracking-wider text-[#0f1729] dark:text-white font-sans">Pending Author Applications</h3>
                    <a href="{{ route('admin.applications.index') }}" class="text-xs text-[#3c83f6] font-bold hover:underline">View All &rarr;</a>
                </div>
                <div class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recentApplications as $app)
                        <div class="px-6 py-4 flex items-center justify-between hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            <div>
                                <p class="text-sm font-extrabold text-[#0f1729] dark:text-slate-100">{{ $app->user->name }}</p>
                                <p class="text-xs font-medium text-slate-400 mt-0.5">{{ $app->user->email }} &bull; {{ $app->created_at->diffForHumans() }}</p>
                            </div>
                            <a href="{{ route('admin.applications.show', $app) }}" class="px-3.5 py-1.5 bg-[#3c83f6] hover:bg-blue-600 text-white text-xs font-bold rounded-xl transition-all shadow-xs">
                                Review App
                            </a>
                        </div>
                    @empty
                        <div class="px-6 py-8 text-center text-slate-400 text-xs italic">No pending applications right now.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('analyticsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($analytics['labels']) !!},
                    datasets: [{
                        label: 'Page Views',
                        data: {!! json_encode($analytics['data']) !!},
                        borderColor: '#3c83f6',
                        backgroundColor: 'rgba(60, 131, 246, 0.12)',
                        fill: true,
                        tension: 0.35,
                        borderWidth: 3,
                        pointBackgroundColor: '#3c83f6',
                        pointBorderColor: '#ffffff',
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
                            grid: { color: 'rgba(226, 232, 240, 0.4)' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>

