<?php

use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('public posts api returns published posts', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'title' => 'API Test Post',
        'published_at' => now(),
    ]);

    $response = $this->getJson(route('api.posts.index'));

    $response->assertStatus(200);
    $response->assertJsonFragment(['title' => 'API Test Post']);
});

test('public categories api returns categories list', function () {
    Category::factory()->create(['name' => 'Technology']);

    $response = $this->getJson(route('api.categories.index'));

    $response->assertStatus(200);
    $response->assertJsonFragment(['name' => 'Technology']);
});

test('public tags api returns tags list', function () {
    Tag::factory()->create(['name' => 'laravel']);

    $response = $this->getJson(route('api.tags.index'));

    $response->assertStatus(200);
    $response->assertJsonFragment(['name' => 'laravel']);
});

test('author api allows creating posts via authentication', function () {
    $author = User::factory()->create(['role' => UserRole::APPROVED_AUTHOR]);
    $category = Category::factory()->create();

    $response = $this->actingAs($author)->postJson(route('api.author.posts.store'), [
        'title' => 'Post via API',
        'content' => 'API content body',
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    $response->assertStatus(201);
    $this->assertDatabaseHas('posts', ['title' => 'Post via API']);
});
