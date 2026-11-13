@extends('layouts.app')

@section('title', 'Barangay Bulletin - Purok Genilla')

@section('content')

<div class="space-y-6">

    <!-- Page heading -->
    <div>
        <h1 class="text-3xl font-bold text-blue-900">
            Barangay Bulletin
        </h1>

        <p class="mt-2 text-gray-600">
            Latest announcements from Purok Genilla.
        </p>
    </div>

    <!-- Search, category, and tag filters -->
    <form method="GET"
          action="{{ route('posts.index') }}"
          class="flex flex-col gap-3 rounded-lg bg-white p-4 shadow md:flex-row">

        <!-- Search -->
        <input
            type="text"
            name="q"
            value="{{ request('q') }}"
            placeholder="Search announcements..."
            class="w-full rounded border border-gray-300 px-4 py-2"
        >

        <!-- Category filter -->
        <select
            name="category"
            class="w-full rounded border border-gray-300 px-4 py-2"
        >
            <option value="">All Categories</option>

            @foreach ($categories as $category)
                <option value="{{ $category }}"
                    @selected(request('category') == $category)>
                    {{ $category }}
                </option>
            @endforeach
        </select>

        <!-- Tag filter -->
        <select
            name="tag"
            class="w-full rounded border border-gray-300 px-4 py-2"
        >
            <option value="">All Tags</option>

            @foreach ($tags as $tag)
                <option value="{{ $tag->name }}"
                    @selected(request('tag') == $tag->name)>
                    {{ $tag->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="rounded bg-blue-800 px-6 py-2 text-white hover:bg-blue-900">
            Filter
        </button>
    </form>

    <!-- Bulletin posts -->
    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

        @forelse ($posts as $post)

            <article class="rounded-lg bg-white p-5 shadow">

                <!-- Category and pinned status -->
                <div class="mb-3 flex flex-wrap gap-2">

                    <span class="rounded bg-blue-100 px-3 py-1 text-sm text-blue-800">
                        {{ $post->category }}
                    </span>

                    @if ($post->is_pinned)
                        <span class="rounded bg-yellow-100 px-3 py-1 text-sm font-semibold text-yellow-800">
                            Pinned
                        </span>
                    @endif

                </div>

                <!-- Post title -->
                <h2 class="text-xl font-bold text-gray-900">
                    <a href="{{ route('posts.show', $post->id) }}"
                       class="hover:text-blue-700">
                        {{ $post->title }}
                    </a>
                </h2>

                <!-- Author -->
                <p class="mt-3 text-sm text-gray-600">
                    Posted by:

                    @if ($post->author)
                        <a href="{{ route('authors.show', $post->author->id) }}"
                           class="font-semibold text-blue-700 hover:underline">
                            {{ $post->author->name }}
                        </a>
                    @else
                        Unknown Author
                    @endif
                </p>

                <!-- Tags -->
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                           class="rounded-full bg-green-100 px-3 py-1 text-xs text-green-800 hover:bg-green-200">
                            {{ $tag->name }}
                        </a>
                    @endforeach
                </div>

                <!-- Publication date -->
                <p class="mt-3 text-sm text-gray-500">
                    Published:
                    {{ $post->published_at?->format('M d, Y') ?? 'N/A' }}
                </p>

                <!-- Views and comments -->
                <div class="mt-2 flex gap-5 text-sm text-gray-500">
                    <span>Views: {{ $post->views }}</span>
                    <span>Comments: {{ $post->comments_count }}</span>
                </div>

                <!-- Read post -->
                <a href="{{ route('posts.show', $post->id) }}"
                   class="mt-4 inline-block font-medium text-blue-700 hover:underline">
                    Read Announcement
                </a>

            </article>

        @empty
            <p class="text-gray-600 md:col-span-2">
                No posts match your search.
            </p>
        @endforelse

    </div>

    <!-- Pagination -->
    <div class="mt-6">
        {{ $posts->links() }}
    </div>

    <p class="text-sm text-gray-600">
        Showing {{ $posts->firstItem() ?? 0 }}
        - {{ $posts->lastItem() ?? 0 }}
        of {{ $posts->total() }} posts
    </p>

</div>

@endsection
