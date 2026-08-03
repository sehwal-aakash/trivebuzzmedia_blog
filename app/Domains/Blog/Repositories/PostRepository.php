<?php

namespace App\Domains\Blog\Repositories;

use App\Enums\CommentStatus;
use App\Models\Post;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    public function getPublishedPosts(int $perPage = 10): LengthAwarePaginator
    {
        return Post::published()
            ->with(['author', 'category', 'tags'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate($perPage);
    }

    public function search(string $query, int $perPage = 10): LengthAwarePaginator
    {
        return Post::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%");
            })
            ->with(['author', 'category'])
            ->orderByRaw('COALESCE(published_at, created_at) DESC')
            ->paginate($perPage);
    }

    public function getTrendingPosts(int $limit = 5): Collection
    {
        return Post::published()
            ->trending()
            ->limit($limit)
            ->get();
    }

    public function getRelatedPosts(Post $post, int $limit = 3): Collection
    {
        return Post::published()
            ->where('id', '!=', $post->id)
            ->where(function ($query) use ($post) {
                $query->where('category_id', $post->category_id)
                    ->orWhereHas('tags', function ($q) use ($post) {
                        $q->whereIn('tags.id', $post->tags->pluck('id'));
                    });
            })
            ->limit($limit)
            ->get();
    }

    public function findBySlug(string $slug): ?Post
    {
        return Post::where('slug', $slug)
            ->with(['author', 'category', 'tags', 'comments' => function ($q) {
                $q->where('status', CommentStatus::APPROVED)->latest();
            }])
            ->first();
    }

    public function create(array $data): Post
    {
        return Post::create($data);
    }

    public function update(Post $post, array $data): bool
    {
        return $post->update($data);
    }

    public function delete(Post $post): bool
    {
        return $post->delete();
    }

    public function incrementViews(Post $post): void
    {
        $post->increment('view_count');

        $post->postViews()->create([
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'viewed_at' => now(),
        ]);
    }
}
