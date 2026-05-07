<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AuthorApplicationStatus;
use App\Enums\CommentStatus;
use App\Enums\PostStatus;
use App\Http\Controllers\Controller;
use App\Models\AuthorApplication;
use App\Models\Comment;
use App\Models\Newsletter;
use App\Models\Post;
use App\Models\PostView;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_views' => Post::sum('view_count'),
            'total_users' => User::count(),
            'total_subscribers' => Newsletter::where('is_active', true)->count(),
            'pending_applications' => AuthorApplication::where('status', AuthorApplicationStatus::PENDING)->count(),
            'pending_posts' => Post::where('status', PostStatus::PENDING_REVIEW)->count(),
            'pending_comments' => Comment::where('status', CommentStatus::PENDING)->count(),
        ];

        // Analytics: Views for last 30 days
        $viewsData = PostView::select(
            DB::raw('DATE(viewed_at) as date'),
            DB::raw('count(*) as views')
        )
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('views', 'date')
            ->toArray();

        // Fill missing dates with 0
        $analytics = [];
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $analytics['labels'][] = now()->subDays($i)->format('M d');
            $analytics['data'][] = $viewsData[$date] ?? 0;
        }

        $recentPosts = Post::with('author', 'category')->latest()->take(5)->get();
        $recentApplications = AuthorApplication::with('user')->where('status', AuthorApplicationStatus::PENDING)->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentApplications', 'analytics'));
    }
}
