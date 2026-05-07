<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\View\View;

class PageController extends Controller
{
    public function category(Category $category): View
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(10);

        return view('welcome', [
            'posts' => $posts,
            'trendingPosts' => Post::published()->trending()->take(5)->get(),
            'query' => null,
            'seoTags' => [
                'title' => $category->name.' - TriveBuzz Media',
                'description' => $category->description,
            ],
        ]);
    }

    public function tag(Tag $tag): View
    {
        $posts = Post::published()
            ->whereHas('tags', function ($query) use ($tag) {
                $query->where('tags.id', $tag->id);
            })
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(10);

        return view('welcome', [
            'posts' => $posts,
            'trendingPosts' => Post::published()->trending()->take(5)->get(),
            'query' => null,
            'seoTags' => [
                'title' => '#'.$tag->name.' - TriveBuzz Media',
            ],
        ]);
    }

    public function profile(User $user): View
    {
        $posts = Post::published()
            ->where('author_id', $user->id)
            ->with(['category'])
            ->latest('published_at')
            ->paginate(10);

        $seoTags = [
            'title' => $user->name.' - Author Profile',
            'description' => 'Read the latest stories and insights from '.$user->name.' on TriveBuzz Media.',
        ];

        return view('public.profile', compact('user', 'posts', 'seoTags'));
    }

    public function about(): View
    {
        return view('public.about');
    }

    public function contact(): View
    {
        return view('public.contact');
    }

    public function privacy(): View
    {
        return view('public.privacy');
    }

    public function terms(): View
    {
        return view('public.terms');
    }
}
