<?php

namespace App\Domains\Blog\Services;

use App\Domains\Blog\Repositories\PostRepository;
use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Post;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use App\Notifications\PostSubmittedForReviewNotification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostService
{
    public function __construct(
        protected PostRepository $repository
    ) {}

    public function createPost(array $data): Post
    {
        $data['slug'] = $this->generateUniqueSlug($data['title']);

        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            $data['featured_image'] = $data['featured_image']->store('posts', 'public');
        }

        // If status is published and published_at is not set or empty, set it to now
        if ($data['status'] === PostStatus::PUBLISHED->value && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = $this->repository->create($data);

        $this->handleSEO($post, $data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        $this->sendPostNotifications($post, null);

        return $post;
    }

    public function updatePost(Post $post, array $data): Post
    {
        $oldStatus = $post->status;

        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
        }

        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $data['featured_image']->store('posts', 'public');
        } else {
            unset($data['featured_image']);
        }

        // Handle publishing logic
        if (isset($data['status']) && $data['status'] === PostStatus::PUBLISHED->value) {
            $data['published_at'] = ! empty($data['published_at']) ? $data['published_at'] : ($post->published_at ?? now());
        }

        // Ensure boolean values
        if (isset($data['is_sponsored'])) {
            $data['is_sponsored'] = (bool) $data['is_sponsored'];
        }

        $this->repository->update($post, $data);

        $this->handleSEO($post, $data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        $updatedPost = $post->fresh();
        $this->sendPostNotifications($updatedPost, $oldStatus);

        return $updatedPost;
    }

    protected function sendPostNotifications(Post $post, ?PostStatus $oldStatus = null): void
    {
        if ($post->status === PostStatus::PUBLISHED && ($oldStatus === null || $oldStatus !== PostStatus::PUBLISHED)) {
            if ($post->author) {
                $post->author->notify(new PostPublishedNotification($post));
            }
        } elseif ($post->status === PostStatus::PENDING_REVIEW && ($oldStatus === null || $oldStatus !== PostStatus::PENDING_REVIEW)) {
            User::whereIn('role', [UserRole::ADMIN, UserRole::SUPER_ADMIN, UserRole::EDITOR])
                ->get()
                ->each(fn (User $user) => $user->notify(new PostSubmittedForReviewNotification($post)));
        }
    }

    protected function handleSEO(Post $post, array $data): void
    {
        $seoData = [];

        if (isset($data['meta_title'])) {
            $seoData['title'] = $data['meta_title'];
        }
        if (isset($data['meta_description'])) {
            $seoData['description'] = $data['meta_description'];
        }
        if (isset($data['meta_keywords'])) {
            $seoData['keywords'] = $data['meta_keywords'];
        }
        if (isset($data['og_title'])) {
            $seoData['og_title'] = $data['og_title'];
        }
        if (isset($data['og_description'])) {
            $seoData['og_description'] = $data['og_description'];
        }
        if (isset($data['canonical_url'])) {
            $seoData['canonical_url'] = $data['canonical_url'];
        }

        if (! empty($seoData)) {
            $post->updateSEO($seoData);
        }
    }

    protected function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $count = 1;

        while (Post::where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}
