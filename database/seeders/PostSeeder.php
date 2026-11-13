<?php

namespace Database\Seeders;

use App\Models\Author;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Get the five existing authors.
        $authors = Author::all();

        // Generate 40 published bulletin posts.
        Post::factory()->count(40)
            ->sequence(fn ($sequence) => [
                'author_id' => $authors->random()->id,
            ])
            ->create();

        // Generate 10 unpublished draft posts.
        Post::factory()->count(10)->draft()
            ->sequence(fn ($sequence) => [
                'author_id' => $authors->random()->id,
            ])
            ->create();

        // Find the personalized Kagawad.
        $kagawad = Author::where(
            'email',
            'kagawad.genilla@bulletin.test'
        )->firstOrFail();

        // Create the personalized pinned announcement.
        Post::create([
            'author_id' => $kagawad->id,
            'title' => 'Purok Genilla Clean-up Drive',
            'category' => 'Announcement',
            'body' => 'In celebration of Kagawad Red Genilla\'s birthday on September 15, 2026, residents of Purok Genilla are invited to join a community clean-up drive. Everyone is encouraged to participate and help keep our neighborhood clean and safe.',
            'is_published' => true,
            'is_pinned' => true,
            'published_at' => '2026-09-15 08:00:00',
            'views' => 0,
        ]);
    }
}
