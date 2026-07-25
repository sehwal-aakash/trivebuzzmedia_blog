<?php

use App\Domains\Blog\Services\PostService;
use App\Domains\Interaction\Services\CommentService;
use App\Domains\User\Services\AuthorApplicationService;
use App\Enums\PostStatus;
use App\Enums\UserRole;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use App\Notifications\NewAuthorApplicationSubmittedNotification;
use App\Notifications\NewCommentNotification;
use App\Notifications\PostPublishedNotification;
use App\Notifications\WelcomeUserNotification;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Notification;

uses(LazilyRefreshDatabase::class);

test('welcome email notification is sent to user upon registration', function () {
    Notification::fake();

    $response = $this->post(route('register'), [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'Password123!',
        'password_confirmation' => 'Password123!',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'john@example.com')->first();
    expect($user)->not->toBeNull();

    Notification::assertSentTo($user, WelcomeUserNotification::class);
});

test('admin is notified when author application is submitted', function () {
    Notification::fake();

    $admin = User::factory()->create(['role' => UserRole::ADMIN]);
    $applicant = User::factory()->create(['role' => UserRole::VISITOR]);

    $service = app(AuthorApplicationService::class);
    $service->submitApplication($applicant, [
        'bio' => 'Experienced tech journalist with 5 years writing experience.',
        'portfolio_links' => ['https://example.com/portfolio'],
    ]);

    Notification::assertSentTo($admin, NewAuthorApplicationSubmittedNotification::class);
});

test('author is notified when their post is published', function () {
    Notification::fake();

    $author = User::factory()->create(['role' => UserRole::APPROVED_AUTHOR]);
    $category = Category::factory()->create();
    $service = app(PostService::class);

    $service->createPost([
        'title' => 'Innovative AI Publishing Platforms',
        'content' => 'Full article content body...',
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED->value,
    ]);

    Notification::assertSentTo($author, PostPublishedNotification::class);
});

test('author is notified when a new comment is posted on their article', function () {
    Notification::fake();

    $author = User::factory()->create(['role' => UserRole::APPROVED_AUTHOR]);
    $commenter = User::factory()->create(['role' => UserRole::VISITOR]);
    $category = Category::factory()->create();

    $post = Post::factory()->create([
        'author_id' => $author->id,
        'category_id' => $category->id,
        'status' => PostStatus::PUBLISHED,
    ]);

    $service = app(CommentService::class);
    $service->createComment([
        'post_id' => $post->id,
        'user_id' => $commenter->id,
        'content' => 'Insightful article! Loved the perspective on AI.',
    ]);

    Notification::assertSentTo($author, NewCommentNotification::class);
});
