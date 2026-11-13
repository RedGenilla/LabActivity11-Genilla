<?php

namespace App\Http\Controllers;

use App\Models\Author;

class AuthorController extends Controller
{
    // Display an author's profile and published posts.
    public function show(Author $author)
    {
        // Count all comments received on this author's posts.
        $commentsCount = $author->comments()->count();

        // Retrieve only published posts by this author.
        $posts = $author->posts()
            ->where('is_published', true)
            ->with('tags')
            ->withCount('comments')
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7);

        return view('authors.show', compact(
            'author',
            'posts',
            'commentsCount'
        ));
    }
}

