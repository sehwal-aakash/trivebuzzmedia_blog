<?php

namespace App\Http\Controllers\Author;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostView;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $stats = [
            'total_posts' => Post::where('author_id', $user->id)->count(),
            'published_posts' => Post::where('author_id', $user->id)->published()->count(),
            'draft_posts' => Post::where('author_id', $user->id)->draft()->count(),
            'total_views' => Post::where('author_id', $user->id)->sum('view_count'),
        ];

        // Analytics: Views for author's posts last 30 days
        $viewsData = PostView::join('posts', 'post_views.post_id', '=', 'posts.id')
            ->select(
                DB::raw('DATE(post_views.viewed_at) as date'),
                DB::raw('count(*) as views')
            )
            ->where('posts.author_id', $user->id)
            ->where('post_views.viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('views', 'date')
            ->toArray();

        $analytics = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $analytics['labels'][] = now()->subDays($i)->format('M d');
            $analytics['data'][] = $viewsData[$date] ?? 0;
        }

        $recentPosts = Post::where('author_id', $user->id)
            ->with('category')
            ->latest()
            ->take(5)
            ->get();

        return view('author.dashboard', compact('stats', 'recentPosts', 'analytics'));
    }
}
