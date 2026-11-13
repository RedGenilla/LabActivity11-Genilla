@extends('layouts.app')

@section('title', $author->name . ' - Purok Genilla')

@section('content')

<div class="space-y-6">

    <!-- Author information -->
    <div class="rounded-lg bg-white p-6 shadow">

        <a href="{{ route('posts.index') }}"
           class="text-blue-700 hover:underline">
            &larr; Back to Announcements
        </a>

        <h1 class="mt-4 text-3xl font-bold text-blue-900">
            {{ $author->name }}
        </h1>

        <p class="mt-2 text-gray-600">
            Position: {{ $author->position }}
        </p>

        <p class="mt-3 font-semibold text-gray-700">
            {{ $commentsCount }} comments received
        </p>

    </div>

    <h2 class="text-2xl font-bold text-blue-900">
        Published Posts
    </h2>

    <!-- Author's published posts -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

        @forelse ($posts as $post)

            <article class="rounded-lg bg-white p-5 shadow">

                <div class="mb-3 flex flex-wrap gap-2">

                    <span class="rounded bg-blue-100 px-3 py-1 text-sm text-blue-800">
                        {{ $post->category }}
                    </span>

                    @if ($post->is_pinned)
                        <span class="rounded bg-yellow-100 px-3 py-1 text-sm text-yellow-800">
                            Pinned
                        </span>
                    @endif

                </div>

                <h3 class="text-xl font-bold text-gray-900">

                    <a href="{{ route('posts.show', $post->id) }}"
                       class="hover:text-blue-700">
                        {{ $post->title }}
                    </a>

                </h3>

                <!-- Tags -->
                <div class="mt-3 flex flex-wrap gap-2">

                    @foreach ($post->tags as $tag)

                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                           class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-800">
                            {{ $tag->name }}
                        </a>

                    @endforeach

                </div>

                <p class="mt-3 text-sm text-gray-500">
                    Published:
                    {{ $post->published_at?->format('M d, Y') ?? 'N/A' }}
                </p>

                <p class="mt-2 text-sm text-gray-500">
                    Comments: {{ $post->comments_count }}
                </p>

                <a href="{{ route('posts.show', $post->id) }}"
                   class="mt-4 inline-block font-medium text-blue-700 hover:underline">
                    Read Announcement
                </a>

            </article>

        @empty

            <p class="text-gray-600">
                This author has no published posts.
            </p>

        @endforelse

    </div>

    <!-- Pagination -->
    <div>
        {{ $posts->links() }}
    </div>

</div>

@endsection
