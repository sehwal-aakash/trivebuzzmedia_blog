<?php

use App\Enums\UserRole;
use App\Models\User;

test('admin dashboard is accessible to super admin', function () {
    $admin = User::factory()->create(['role' => UserRole::SUPER_ADMIN]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertSee('Admin Dashboard');
});

test('admin dashboard is not accessible to visitor', function () {
    $visitor = User::factory()->create(['role' => UserRole::VISITOR]);

    $response = $this->actingAs($visitor)->get(route('admin.dashboard'));

    $response->assertStatus(403);
});

test('sitemap.xml is accessible', function () {
    $response = $this->get('/sitemap.xml');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/xml; charset=utf-8');
});

test('robots.txt is accessible', function () {
    $response = $this->get('/robots.txt');

    $response->assertStatus(200);
    $response->assertHeader('Content-Type', 'text/plain; charset=UTF-8');
    $response->assertSee('Sitemap:');
});
