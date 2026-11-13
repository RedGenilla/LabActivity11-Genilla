<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        // Retrieve the seeded users.
        $users = User::all();

        // Give each regular published post 0 to 5 comments.
        $posts = Post::where('is_published', true)
            ->where('is_pinned', false)
            ->get();

        foreach ($posts as $post) {
            $commentCount = rand(0, 5);

            for ($i = 0; $i < $commentCount; $i++) {
                Comment::factory()
                    ->for($post)
                    ->for($users->random())
                    ->create();
            }
        }

        // Find the personalized pinned post.
        $pinnedPost = Post::where('is_pinned', true)
            ->where('is_published', true)
            ->firstOrFail();

        // Find Lola Genilla's account.
        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        // Lola must comment on the pinned announcement.
        Comment::factory()
            ->for($pinnedPost)
            ->for($lola)
            ->create();

        // Add two other comments to the pinned post.
        $otherUsers = $users
            ->where('id', '!=', $lola->id)
            ->values();

        for ($i = 0; $i < 2; $i++) {
            Comment::factory()
                ->for($pinnedPost)
                ->for($otherUsers->random())
                ->create();
        }
    }
}


