<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Latest technology trends, gadgets, software development, and digital innovations.'],
            ['name' => 'Business', 'slug' => 'business', 'description' => 'Entrepreneurship, market insights, startup growth strategies, and finance.'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle', 'description' => 'Travel, productivity, personal development, culture, and design.'],
            ['name' => 'Entertainment', 'slug' => 'entertainment', 'description' => 'Movies, music, streaming trends, gaming, and media pop culture.'],
            ['name' => 'Science & AI', 'slug' => 'science-ai', 'description' => 'Artificial intelligence developments, space exploration, and scientific discoveries.'],
            ['name' => 'Health & Wellness', 'slug' => 'health-wellness', 'description' => 'Fitness routines, mental health advice, nutrition, and healthy living.'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
