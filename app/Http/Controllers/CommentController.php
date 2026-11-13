<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;

class CommentController extends Controller
{
    // Save a comment on a published bulletin post.
    public function store(
        StoreCommentRequest $request,
        Post $post
    ) {
        // Do not allow comments on draft posts.
        if (!$post->is_published) {
            abort(404);
        }

        // Create the comment using validated data.
        $post->comments()->create([
            ...$request->validated(),
            'user_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('posts.show', $post->id)
            ->with('status', 'Comment posted.');
    }
}

