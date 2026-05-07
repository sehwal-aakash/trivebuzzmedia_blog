<?php

namespace App\Http\Controllers\Author;

use App\Domains\Blog\Services\PostService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Blog\StorePostRequest;
use App\Http\Requests\Blog\UpdatePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PostController extends Controller
{
    public function __construct(
        protected PostService $postService
    ) {}

    public function index(): View
    {
        $posts = auth()->user()->posts()->latest()->paginate(10);

        return view('author.posts.index', compact('posts'));
    }

    public function create(): View
    {
        Gate::authorize('create', Post::class);
        $categories = Category::all();
        $tags = Tag::all();

        return view('author.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {
        Gate::authorize('create', Post::class);

        $data = $request->validated();
        $data['author_id'] = auth()->id();

        $this->postService->createPost($data);

        return redirect()->route('author.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post): View
    {
        Gate::authorize('update', $post);
        $categories = Category::all();
        $tags = Tag::all();

        return view('author.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        Gate::authorize('update', $post);

        $this->postService->updatePost($post, $request->validated());

        return redirect()->route('author.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post): RedirectResponse
    {
        Gate::authorize('delete', $post);
        $post->delete();

        return redirect()->route('author.posts.index')->with('success', 'Post deleted successfully.');
    }
}
