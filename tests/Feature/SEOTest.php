<?php

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('posts can have SEO meta tags', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'title' => 'Post with SEO',
        'published_at' => now(),
    ]);

    $post->updateSEO([
        'title' => 'Custom SEO Title',
        'description' => 'Custom SEO Description',
        'keywords' => 'seo, test, laravel',
    ]);

    expect($post->seoMeta)->not->toBeNull();
    expect($post->seoMeta->title)->toBe('Custom SEO Title');
    expect($post->seoMeta->description)->toBe('Custom SEO Description');
    expect($post->seoMeta->keywords)->toBe('seo, test, laravel');
});

test('homepage displays default SEO tags', function () {
    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('<title>TriveBuzz Media - Discover the latest stories</title>', false);
    $response->assertSee('<meta name="description" content="TriveBuzz Media is a multi-author blog platform focused on news, insights, and stories from around the world.">', false);
});

test('post page displays custom SEO tags', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'title' => 'SEO Post',
        'published_at' => now(),
    ]);

    $post->updateSEO([
        'title' => 'SEO Title for Post',
        'description' => 'SEO Description for Post',
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200);
    $response->assertSee('<title>SEO Title for Post</title>', false);
    $response->assertSee('<meta name="description" content="SEO Description for Post">', false);
});
