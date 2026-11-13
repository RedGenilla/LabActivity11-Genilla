@extends('layouts.app')

@section('title', $post->title . ' - Purok Genilla')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    <!-- Back to bulletin -->
    <a href="{{ route('posts.index') }}"
       class="inline-block text-blue-700 hover:underline">
        &larr; Back to Announcements
    </a>

    <!-- Full post -->
    <article class="rounded-lg bg-white p-6 shadow">

        <!-- Category and pinned status -->
        <div class="mb-4 flex flex-wrap gap-2">

            <span class="rounded bg-blue-100 px-3 py-1 text-sm text-blue-800">
                {{ $post->category }}
            </span>

            @if ($post->is_pinned)
                <span class="rounded bg-yellow-100 px-3 py-1 text-sm text-yellow-800">
                    Pinned Announcement
                </span>
            @endif

        </div>

        <!-- Post title -->
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $post->title }}
        </h1>

        <!-- Post information -->
        <div class="mt-4 border-b pb-4 text-sm text-gray-500">

            <p>
                Published:
                {{ $post->published_at?->format('F d, Y') ?? 'N/A' }}
            </p>

            <p class="mt-2">
                Author:

                @if ($post->author)
                    <a href="{{ route('authors.show', $post->author->id) }}"
                       class="font-semibold text-blue-700 hover:underline">
                        {{ $post->author->name }}
                    </a>
                @else
                    Unknown Author
                @endif
            </p>

            <p class="mt-2">
                Views: {{ $post->views }}
            </p>

        </div>

        <!-- Post tags -->
        <div class="mt-4 flex flex-wrap gap-2">

            @foreach ($post->tags as $tag)
                <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                   class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-800 hover:bg-green-200">
                    {{ $tag->name }}
                </a>
            @endforeach

        </div>

        <!-- Post body -->
        <div class="mt-6 whitespace-pre-line leading-relaxed text-gray-700">{{ $post->body }}</div>

    </article>

    <!-- Comments section -->
    <section class="rounded-lg bg-white p-6 shadow">

        <h2 class="mb-5 text-xl font-bold text-blue-900">
            Comments ({{ $post->comments->count() }})
        </h2>

        <!-- Display existing comments -->
        @forelse ($post->comments as $comment)

            <div class="border-b border-gray-200 py-4">

                <p class="font-semibold text-gray-900">
                    {{ $comment->user?->name ?? 'Unknown Resident' }}
                </p>

                <p class="mt-1 text-xs text-gray-500">
                    {{ $comment->created_at?->format('M d, Y g:i A') }}
                </p>

                <p class="mt-3 whitespace-pre-line text-gray-700">{{ $comment->body }}</p>

            </div>

        @empty

            <p class="text-gray-500">
                No comments yet.
            </p>

        @endforelse

    </section>

    <!-- Comment form for logged-in users -->
    @auth

        <section class="rounded-lg bg-white p-6 shadow">

            <h2 class="mb-4 text-xl font-bold text-blue-900">
                Leave a Comment
            </h2>

            <!-- Validation error summary -->
            @if ($errors->any())
                <div class="mb-4 rounded bg-red-100 p-4 text-red-700">

                    <p class="mb-2 font-semibold">
                        Please correct the following errors:
                    </p>

                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>

                </div>
            @endif

            <form method="POST"
                  action="{{ route('comments.store', $post->id) }}">

                @csrf

                <!-- Comment field -->
                <div class="mb-4">

                    <label for="body"
                           class="mb-2 block font-medium text-gray-700">
                        Your Comment
                    </label>

                    <textarea
                        id="body"
                        name="body"
                        rows="4"
                        minlength="3"
                        maxlength="1000"
                        required
                        placeholder="Write your comment here..."
                        class="w-full rounded border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none"
                    >{{ old('body') }}</textarea>

                    <!-- Field-level error -->
                    @error('body')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                    <p class="mt-2 text-xs text-gray-500">
                        Comments must contain 3 to 1000 characters.
                    </p>

                </div>

                <!-- Submit comment -->
                <button
                    type="submit"
                    class="rounded bg-blue-800 px-6 py-2 font-semibold text-white hover:bg-blue-900">
                    Post Comment
                </button>

            </form>

        </section>

    @endauth

    <!-- Guests must sign in -->
    @guest

        <div class="rounded-lg bg-white p-6 text-center shadow">

            <p class="text-gray-600">
                Sign in to comment
            </p>

            <a href="{{ route('login') }}"
               class="mt-3 inline-block rounded bg-blue-800 px-5 py-2 text-white hover:bg-blue-900">
                Login
            </a>

        </div>

    @endguest

</div>

@endsection



