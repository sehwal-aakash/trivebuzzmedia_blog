<?php

namespace App\Http\Controllers\Api\Author;

use App\Domains\Blog\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePostRequest;
use App\Http\Requests\Blog\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Gate;

class PostApiController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(): AnonymousResourceCollection
    {
        $posts = auth()->user()->posts()->with(['category', 'tags'])->latest()->paginate(15);

        return PostResource::collection($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        Gate::authorize('create', Post::class);

        $data = $request->validated();
        $data['author_id'] = auth()->id();

        $post = $this->postService->createPost($data);

        return response()->json([
            'message' => 'Post created successfully.',
            'data' => new PostResource($post->load(['category', 'tags'])),
        ], 201);
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        Gate::authorize('update', $post);

        $updatedPost = $this->postService->updatePost($post, $request->validated());

        return response()->json([
            'message' => 'Post updated successfully.',
            'data' => new PostResource($updatedPost->load(['category', 'tags'])),
        ]);
    }

    public function destroy(Post $post): JsonResponse
    {
        Gate::authorize('delete', $post);

        $post->delete();

        return response()->json([
            'message' => 'Post deleted successfully.',
        ]);
    }
}
