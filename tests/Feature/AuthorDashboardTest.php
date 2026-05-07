<?php

use App\Enums\UserRole;
use App\Models\User;

test('author dashboard is accessible to approved author', function () {
    $author = User::factory()->create(['role' => UserRole::APPROVED_AUTHOR]);

    $response = $this->actingAs($author)->get(route('author.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Author Dashboard');
});

test('author dashboard is not accessible to pending author', function () {
    $author = User::factory()->create(['role' => UserRole::PENDING_AUTHOR]);

    $response = $this->actingAs($author)->get(route('author.dashboard'));

    $response->assertStatus(403);
});
