<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
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

        // Search posts by title.
        if ($request->filled('q')) {
            $query->where(
                'title',
                'LIKE',
                '%' . $request->input('q') . '%'
            );
        }

        // Filter by category.
        if ($request->filled('category')) {
            $query->where(
                'category',
                $request->input('category')
            );
        }

        // Filter by tag name.
        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($tagQuery) use ($request) {
                $tagQuery->where(
                    'name',
                    $request->input('tag')
                );
            });
        }

        // Keep pinned posts first and newest posts after.
        // Genilla has 7 letters, so display 7 per page.
        $posts = $query
            ->orderByDesc('is_pinned')
            ->latest('published_at')
            ->paginate(7)
            ->withQueryString();

        // Categories for the filter dropdown.
        $categories = Post::query()
            ->where('is_published', true)
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        // Tags for the filter dropdown.
        $tags = Tag::orderBy('name')->get();

        return view('posts.index', compact(
            'posts',
            'categories',
            'tags'
        ));
    }

    // Show the new post form.
    public function create(Request $request)
    {
        // Residents cannot access the creation page.
        if (!$request->user()->author()->exists()) {
            abort(403);
        }

        // Use the five existing Lab 10 categories.
        $categories = [
            'Announcement',
            'Health',
            'Peace & Order',
            'Ayuda',
            'Events',
        ];

        // Get tags for the checkbox list.
        $tags = Tag::orderBy('name')->get();

        return view('posts.create', compact(
            'categories',
            'tags'
        ));
    }

    // Save a new bulletin post.
    public function store(StorePostRequest $request)
    {
        // Use only validated fields, excluding tags.
        $data = $request->safe()->except(['tags']);

        // Unchecked checkbox means the post is a draft.
        $data['is_published'] = (bool) (
            $data['is_published'] ?? false
        );

        // Set the date only for published posts.
        $data['published_at'] = $data['is_published']
            ? now()
            : null;

        // Create through the logged-in user's author.
        $author = $request->user()
            ->author()
            ->firstOrFail();

        $post = $author->posts()->create($data);

        // Save selected tags in the pivot table.
        $post->tags()->sync(
            $request->validated('tags')
        );

        // Published posts can be viewed immediately.
        if ($post->is_published) {
            return redirect()
                ->route('posts.show', $post->id)
                ->with('status', 'Post published.');
        }

        // Draft posts are hidden from the public listing.
        return redirect()
            ->route('posts.index')
            ->with('status', 'Draft saved successfully.');
    }

    // Display an individual published post.
    public function show($id)
    {
        $post = Post::findOrFail($id);

        // Hide draft posts from public viewing.
        if (!$post->is_published) {
            abort(404);
        }

        // Keep the Lab 10 view counter.
        $post->views = $post->views + 1;
        $post->save();

        // Load related author, tags, and comments.
        $post->load([
            'author',
            'tags',
            'comments' => fn ($query) => $query->latest(),
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }
}

