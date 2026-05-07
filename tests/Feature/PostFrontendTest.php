<?php

use App\Enums\PostStatus;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('homepage displays published posts', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();

    $publishedPost = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'title' => 'Published Post',
        'published_at' => now(),
    ]);

    $draftPost = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::DRAFT,
        'title' => 'Draft Post',
    ]);

    $response = $this->get(route('home'));

    $response->assertStatus(200);
    $response->assertSee('Published Post');
    $response->assertDontSee('Draft Post');
});

test('post show page displays content', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'title' => 'Unique Post Title',
        'content' => 'This is the unique post content.',
        'published_at' => now(),
    ]);

    $response = $this->get(route('posts.show', $post->slug));

    $response->assertStatus(200);
    $response->assertSee('Unique Post Title');
    $response->assertSee('This is the unique post content.');
    $response->assertSee($author->name);
});
