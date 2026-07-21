<?php

namespace App\Domains\Blog\Services;

use App\Domains\Blog\Repositories\PostRepository;
use App\Enums\PostStatus;
use App\Models\Post;
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

        // If status is published and published_at is not set, set it to now
        if ($data['status'] === PostStatus::PUBLISHED->value && ! isset($data['published_at'])) {
            $data['published_at'] = now();
        }

        $post = $this->repository->create($data);

        $this->handleSEO($post, $data);

        if (isset($data['tags'])) {
            $post->tags()->sync($data['tags']);
        }

        return $post;
    }

    public function updatePost(Post $post, array $data): Post
    {
        if (isset($data['title']) && $data['title'] !== $post->title) {
            $data['slug'] = $this->generateUniqueSlug($data['title'], $post->id);
        }

        if (isset($data['featured_image']) && $data['featured_image'] instanceof UploadedFile) {
            // Delete old image if exists
            if ($post->featured_image) {
                Storage::disk('public')->delete($post->featured_image);
            }
            $data['featured_image'] = $data['featured_image']->store('posts', 'public');
        }

        // Handle publishing logic
        if (isset($data['status']) && $data['status'] === PostStatus::PUBLISHED->value && ! $post->published_at) {
            $data['published_at'] = $data['published_at'] ?? now();
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

        return $post->fresh();
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
