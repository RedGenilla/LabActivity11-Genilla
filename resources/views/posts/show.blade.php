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

        <!-- Title -->
        <h1 class="text-3xl font-bold text-gray-900">
            {{ $post->title }}
        </h1>

        <!-- Author and post information -->
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

        <!-- Tags -->
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

    <!-- Comments -->
    <section class="rounded-lg bg-white p-6 shadow">

        <h2 class="mb-5 text-xl font-bold text-blue-900">
            Comments ({{ $post->comments->count() }})
        </h2>

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

        @guest
            <p class="mt-6 text-sm text-gray-600">
                <a href="{{ route('login') }}"
                   class="font-medium text-blue-700 hover:underline">
                    Sign in to comment
                </a>
            </p>
        @endguest

    </section>

</div>

@endsection


