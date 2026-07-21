<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostApiController extends Controller
{
    public function index(Request $request): AnonymousResourceCollection
    {
        $posts = Post::published()
            ->with(['author', 'category', 'tags'])
            ->latest('published_at')
            ->paginate($request->integer('per_page', 15));

        return PostResource::collection($posts);
    }

    public function show(string $slug): PostResource
    {
        $post = Post::published()
            ->where('slug', $slug)
            ->with(['author', 'category', 'tags'])
            ->firstOrFail();

        $post->incrementViewCount();

        return new PostResource($post);
    }
}
