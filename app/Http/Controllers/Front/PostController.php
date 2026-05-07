<?php

namespace App\Http\Controllers\Front;

use App\Domains\Blog\Repositories\PostRepository;
use App\Http\Controllers\Controller;
use App\Services\SEOService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostRepository $postRepository,
        protected SEOService $seoService
    ) {}

    public function index(Request $request): View
    {
        $query = $request->get('q');

        if ($query) {
            $posts = $this->postRepository->search($query);
        } else {
            $posts = $this->postRepository->getPublishedPosts();
        }

        $trendingPosts = $this->postRepository->getTrendingPosts();
        $seoTags = $this->seoService->generateTags(null, [
            'title' => 'TriveBuzz Media - Discover the latest stories',
            'description' => 'TriveBuzz Media is a multi-author blog platform focused on news, insights, and stories from around the world.',
        ]);

        return view('welcome', compact('posts', 'trendingPosts', 'query', 'seoTags'));
    }

    public function show(string $slug): View
    {
        $post = $this->postRepository->findBySlug($slug);

        if (! $post || ($post->status->value !== 'published' && ! auth()->check())) {
            abort(404);
        }

        $this->postRepository->incrementViews($post);
        $relatedPosts = $this->postRepository->getRelatedPosts($post);
        $seoTags = $this->seoService->generateTags($post);

        return view('posts.show', compact('post', 'relatedPosts', 'seoTags'));
    }
}
