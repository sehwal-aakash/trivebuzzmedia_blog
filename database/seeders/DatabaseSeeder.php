<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Super Admin
        User::factory()->superAdmin()->create([
            'name' => 'Super Admin',
            'email' => 'superadmin@trivebuzz.com',
        ]);

        // Create Admin
        User::factory()->admin()->create([
            'name' => 'Admin User',
            'email' => 'admin@trivebuzz.com',
        ]);

        // Create Editor
        User::factory()->editor()->create([
            'name' => 'Editor User',
            'email' => 'editor@trivebuzz.com',
        ]);

        // Create Authors
        User::factory(3)->author()->create();

        // Create Categories
        $categories = Category::factory(5)->create();

        // Create Tags
        $tags = Tag::factory(10)->create();

        // Create Posts
        Post::factory(20)->recycle($categories)->create()->each(function ($post) use ($tags) {
            $post->tags()->attach($tags->random(3));
        });
    }
}
