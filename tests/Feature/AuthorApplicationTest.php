<?php

use App\Enums\AuthorApplicationStatus;
use App\Enums\UserRole;
use App\Models\AuthorApplication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can submit author application', function () {
    $user = User::factory()->create(['role' => UserRole::VISITOR]);

    $response = $this->actingAs($user)->post(route('apply.store'), [
        'bio' => 'Experienced technical writer with 5 years experience in Laravel & AI.',
        'portfolio_links' => ['https://github.com', 'https://medium.com'],
    ]);

    $response->assertRedirect(route('dashboard'));
    $this->assertDatabaseHas('author_applications', [
        'user_id' => $user->id,
        'status' => AuthorApplicationStatus::PENDING->value,
    ]);
});

test('existing approved author cannot submit duplicate application', function () {
    $author = User::factory()->create(['role' => UserRole::APPROVED_AUTHOR]);

    $response = $this->actingAs($author)->get(route('apply.create'));

    $response->assertRedirect(route('dashboard'));
    $response->assertSessionHas('info');
});

test('admin can approve author application and role updates', function () {
    $admin = User::factory()->create(['role' => UserRole::SUPER_ADMIN]);
    $applicant = User::factory()->create(['role' => UserRole::VISITOR]);

    $application = AuthorApplication::create([
        'user_id' => $applicant->id,
        'bio' => 'Sample writer bio',
        'portfolio_links' => [],
        'status' => AuthorApplicationStatus::PENDING,
    ]);

    $response = $this->actingAs($admin)->post(route('admin.applications.approve', $application));

    $response->assertRedirect();
    expect($application->fresh()->status)->toBe(AuthorApplicationStatus::APPROVED);
    expect($applicant->fresh()->role)->toBe(UserRole::APPROVED_AUTHOR);
});
