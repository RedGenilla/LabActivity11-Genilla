<?php

namespace Database\Seeders;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        // Required tags plus my personalized tag.
        $tagNames = [
            'Purok Genilla',
            'Urgent',
            'Libre',
            'Schedule',
            'Events',
        ];

        foreach ($tagNames as $name) {
            Tag::firstOrCreate([
                'name' => $name,
            ]);
        }

        // Retrieve the five tags.
        $tags = Tag::all();

        // Assign one to three tags to every post.
        foreach (Post::all() as $post) {
            $randomTags = $tags
                ->random(rand(1, 3))
                ->pluck('id')
                ->all();

            $post->tags()->sync($randomTags);
        }

        // Give the pinned post exactly two required tags.
        $pinnedPost = Post::where(
            'is_pinned',
            true
        )->firstOrFail();

        $pinnedTags = Tag::whereIn('name', [
            'Purok Genilla',
            'Urgent',
        ])->pluck('id')->all();

        $pinnedPost->tags()->sync($pinnedTags);
    }
}

