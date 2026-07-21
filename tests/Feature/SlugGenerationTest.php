<?php

use App\Domains\Blog\Services\PostService;
use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('createPost generates unique slugs for identical titles', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $postService = app(PostService::class);

    $post1 = $postService->createPost([
        'title' => 'Building Scalable Laravel Web Apps',
        'content' => 'Content 1',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    $post2 = $postService->createPost([
        'title' => 'Building Scalable Laravel Web Apps',
        'content' => 'Content 2',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    expect($post1->slug)->toBe('building-scalable-laravel-web-apps');
    expect($post2->slug)->toBe('building-scalable-laravel-web-apps-1');
});

test('updatePost maintains existing slug when title is unchanged', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $postService = app(PostService::class);

    $post = $postService->createPost([
        'title' => 'Original Title',
        'content' => 'Content',
        'category_id' => $category->id,
        'author_id' => $author->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    $updatedPost = $postService->updatePost($post, [
        'title' => 'Original Title',
        'content' => 'Updated Content Body',
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    expect($updatedPost->slug)->toBe('original-title');
    expect($updatedPost->content)->toBe('Updated Content Body');
});
