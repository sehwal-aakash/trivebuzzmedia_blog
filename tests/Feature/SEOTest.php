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
    $response->assertSee('<title>TriveBuzz Media - Multi-Author Blog &amp; Publishing Platform</title>', false);
    $response->assertSee('<meta name="description" content="Discover breaking news, tech insights, lifestyle articles, and expert stories from multi-author creators around the world.">', false);
    $response->assertSee('<meta name="robots" content="index, follow">', false);
});

test('post page displays custom SEO tags and indexable robots', function () {
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
    $response->assertSee('<meta name="robots" content="index, follow">', false);
});

test('static public pages display indexable meta tags and robots', function () {
    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('<title>About Us - TriveBuzz Media</title>', false);
    $response->assertSee('<meta name="robots" content="index, follow">', false);

    $response = $this->get(route('contact'));
    $response->assertStatus(200);
    $response->assertSee('<title>Contact Us - TriveBuzz Media</title>', false);
    $response->assertSee('<meta name="robots" content="index, follow">', false);

    $response = $this->get(route('help'));
    $response->assertStatus(200);
    $response->assertSee('<title>Help &amp; Support Center - TriveBuzz Media</title>', false);
    $response->assertSee('<meta name="robots" content="index, follow">', false);
});

test('search query sets noindex robots tag', function () {
    $response = $this->get(route('home', ['q' => 'laravel']));

    $response->assertStatus(200);
    $response->assertSee('<meta name="robots" content="noindex, follow">', false);
});

test('admin pages render noindex nofollow robots tag', function () {
    $admin = User::factory()->create(['role' => 'admin']);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('<meta name="robots" content="noindex, nofollow">', false);
});

test('robots.txt disallows admin, author, search, and auth pages', function () {
    $response = $this->get(route('robots'));

    $response->assertStatus(200);
    $response->assertSee('Disallow: /admin/');
    $response->assertSee('Disallow: /author/');
    $response->assertSee('Disallow: /search');
    $response->assertSee('Disallow: /login');
    $response->assertSee('Allow: /posts/');
    $response->assertSee('Allow: /category/');
    $response->assertSee('Allow: /tag/');
});
