<?php

use App\Enums\CommentStatus;
use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guest can submit a comment with guest name and email', function () {
    $author = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'published_at' => now(),
    ]);

    $response = $this->post(route('comments.store'), [
        'post_id' => $post->id,
        'content' => 'Great article!',
        'guest_name' => 'John Guest',
        'guest_email' => 'guest@example.com',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'content' => 'Great article!',
        'guest_name' => 'John Guest',
        'guest_email' => 'guest@example.com',
        'status' => CommentStatus::PENDING->value,
    ]);
});

test('authenticated user can submit a comment without guest info', function () {
    $user = User::factory()->create();
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $user->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
        'published_at' => now(),
    ]);

    $response = $this->actingAs($user)->post(route('comments.store'), [
        'post_id' => $post->id,
        'content' => 'Insightful perspective from a member!',
    ]);

    $response->assertSessionHas('success');
    $this->assertDatabaseHas('comments', [
        'post_id' => $post->id,
        'user_id' => $user->id,
        'content' => 'Insightful perspective from a member!',
    ]);
});

test('admin can approve pending comments', function () {
    $admin = User::factory()->create(['role' => UserRole::SUPER_ADMIN]);
    $category = Category::factory()->create();
    $post = Post::factory()->create([
        'author_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    $comment = Comment::create([
        'post_id' => $post->id,
        'guest_name' => 'Bob',
        'guest_email' => 'bob@example.com',
        'content' => 'Needs approval',
        'status' => CommentStatus::PENDING,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.comments.approve', $comment));

    $response->assertSessionHas('success');
    expect($comment->fresh()->status)->toBe(CommentStatus::APPROVED);
});
