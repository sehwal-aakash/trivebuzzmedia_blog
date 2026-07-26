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
            $seoTags = $this->seoService->generateTags(null, [
                'title' => 'Search: "'.$query.'" - TriveBuzz Media',
                'description' => 'Search results for "'.$query.'" on TriveBuzz Media.',
                'robots' => 'noindex, follow',
            ]);
        } else {
            $posts = $this->postRepository->getPublishedPosts();
            $seoTags = $this->seoService->generateTags(null, [
                'title' => 'TriveBuzz Media - Multi-Author Blog & Publishing Platform',
                'description' => 'Discover breaking news, tech insights, lifestyle articles, and expert stories from multi-author creators around the world.',
                'robots' => 'index, follow',
            ]);
        }

        $trendingPosts = $this->postRepository->getTrendingPosts();

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
        $seoTags = $this->seoService->generateTags($post, [
            'robots' => 'index, follow',
        ]);

        return view('posts.show', compact('post', 'relatedPosts', 'seoTags'));
    }
}
