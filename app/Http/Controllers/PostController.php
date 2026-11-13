<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;

class PostController extends Controller
{
    // Display published bulletin posts.
    public function index(Request $request)
    {
        // Load authors, tags, and comment counts.
        $query = Post::query()
            ->with(['author', 'tags'])
            ->withCount('comments')
            ->where('is_published', true);

        // Search post titles.
        if ($request->filled('q')) {
            $query->where(
                'title',
                'LIKE',
                '%' . $request->input('q') . '%'
            );
        }

        // Filter posts by category.
        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->input('category')
            );
        }

        // Filter posts by tag name.
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tagQuery) use ($request) {
                $tagQuery->where(
                    'name',
                    $request->input('tag')
                );
            });
        }

        // Keep pinned posts first and show 7 per page.
        $posts = $query
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7)
            ->withQueryString();

        // Categories available for filtering.
        $categories = Post::query()
            ->where('is_published', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Available tags for filtering.
        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact(
            'posts',
            'categories',
            'tags'
        ));
    }

    // Display a single published post.
    public function show($id)
    {
        $post = Post::findOrFail($id);

        // Hide draft posts.
        if (!$post->is_published) {
            abort(404);
        }

        // Keep the Lab 10 view counter.
        $post->views = $post->views + 1;
        $post->save();

        // Load related data after finding the post.
        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest(),
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}
