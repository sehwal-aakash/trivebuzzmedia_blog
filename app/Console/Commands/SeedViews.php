<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\PostView;
use Illuminate\Console\Command;

class SeedViews extends Command
{
    protected $signature = 'db:seed-views';

    protected $description = 'Seed sample views for analytics';

    public function handle()
    {
        $posts = Post::all();
        $this->info('Seeding views for '.$posts->count().' posts...');

        foreach ($posts as $post) {
            $data = [];
            for ($i = 0; $i < 30; $i++) {
                $count = rand(10, 100);
                $date = now()->subDays($i);
                for ($j = 0; $j < $count; $j++) {
                    $data[] = [
                        'post_id' => $post->id,
                        'viewed_at' => (clone $date)->subHours(rand(0, 23))->subMinutes(rand(0, 59)),
                        'ip_address' => '127.0.0.1',
                        'user_agent' => 'Sample/1.0',
                    ];
                }
            }
            // Chunked insert for efficiency
            foreach (array_chunk($data, 500) as $chunk) {
                PostView::insert($chunk);
            }
            $this->line("Seeded views for: {$post->title}");
        }

        $this->info('Done seeding views!');
    }
}
