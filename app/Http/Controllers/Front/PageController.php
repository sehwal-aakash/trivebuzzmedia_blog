<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use App\Services\SEOService;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected SEOService $seoService
    ) {}

    public function category(Category $category): View
    {
        $posts = Post::published()
            ->where('category_id', $category->id)
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(10);

        $seoTags = $this->seoService->generateTags($category, [
            'title' => $category->meta_title ?: ($category->name.' - TriveBuzz Media'),
            'description' => $category->meta_description ?: ($category->description ?: 'Explore top stories, breaking news, and insights in '.$category->name.' on TriveBuzz Media.'),
            'keywords' => $category->meta_keywords ?: ($category->name.', blog, news, articles'),
            'robots' => 'index, follow',
        ]);

        return view('welcome', [
            'posts' => $posts,
            'trendingPosts' => Post::published()->trending()->take(5)->get(),
            'query' => null,
            'seoTags' => $seoTags,
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

        $seoTags = $this->seoService->generateTags($tag, [
            'title' => $tag->meta_title ?: ('#'.$tag->name.' Stories - TriveBuzz Media'),
            'description' => $tag->meta_description ?: ($tag->description ?: 'Read all latest articles and news tagged #'.$tag->name.' on TriveBuzz Media.'),
            'keywords' => $tag->meta_keywords ?: ('#'.$tag->name.', '.$tag->name.', topics, articles'),
            'robots' => 'index, follow',
        ]);

        return view('welcome', [
            'posts' => $posts,
            'trendingPosts' => Post::published()->trending()->take(5)->get(),
            'query' => null,
            'seoTags' => $seoTags,
        ]);
    }

    public function profile(User $user): View
    {
        $posts = Post::published()
            ->where('author_id', $user->id)
            ->with(['category'])
            ->latest('published_at')
            ->paginate(10);

        $seoTags = $this->seoService->generateTags(null, [
            'title' => $user->name.' - Author Profile & Articles | TriveBuzz Media',
            'description' => 'Read all latest published articles and stories by '.$user->name.' on TriveBuzz Media.',
            'robots' => 'index, follow',
        ]);

        return view('public.profile', compact('user', 'posts', 'seoTags'));
    }

    public function about(): View
    {
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'About Us - TriveBuzz Media',
            'description' => 'Learn about TriveBuzz Media - our mission, vision, multi-author blogging platform, and editorial standards.',
            'robots' => 'index, follow',
        ]);

        return view('public.about', compact('seoTags'));
    }

    public function contact(): View
    {
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'Contact Us - TriveBuzz Media',
            'description' => 'Get in touch with the TriveBuzz Media team. Send feedback, editorial inquiries, or author application questions.',
            'robots' => 'index, follow',
        ]);

        return view('public.contact', compact('seoTags'));
    }

    public function help(): View
    {
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'Help & Support Center - TriveBuzz Media',
            'description' => 'Find answers, publishing guides, and support resources for readers, authors, and contributors on TriveBuzz Media.',
            'robots' => 'index, follow',
        ]);

        return view('public.help', compact('seoTags'));
    }

    public function privacy(): View
    {
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'Privacy Policy - TriveBuzz Media',
            'description' => 'Read the TriveBuzz Media Privacy Policy to understand how we collect, protect, and handle your data.',
            'robots' => 'index, follow',
        ]);

        return view('public.privacy', compact('seoTags'));
    }

    public function terms(): View
    {
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'Terms of Service - TriveBuzz Media',
            'description' => 'Review the Terms of Service and publishing rules for readers, authors, and contributors on TriveBuzz Media.',
            'robots' => 'index, follow',
        ]);

        return view('public.terms', compact('seoTags'));
    }
}
