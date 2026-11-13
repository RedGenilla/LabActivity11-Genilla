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
        // Get all available users.
        $users = User::all();

        // Give published non-pinned posts 0 to 5 comments.
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

        // Find the pinned Clean-up Drive post.
        $pinnedPost = Post::where('is_pinned', true)
            ->where('is_published', true)
            ->firstOrFail();

        // Find Lola Genilla.
        $lola = User::where(
            'email',
            'lola.genilla@bulletin.test'
        )->firstOrFail();

        // Lola must comment on the pinned post.
        Comment::factory()
            ->for($pinnedPost)
            ->for($lola)
            ->create();

        // Add two more comments to the pinned post.
        for ($i = 0; $i < 2; $i++) {
            Comment::factory()
                ->for($pinnedPost)
                ->for($users->random())
                ->create();
        }
    }
}

