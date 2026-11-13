@extends('layouts.app')

@section('title', 'New Post - Purok Genilla')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    <!-- Page heading -->
    <div>
        <h1 class="text-3xl font-bold text-blue-900">
            Create New Bulletin Post
        </h1>

        <p class="mt-2 text-gray-600">
            Publish an announcement for Purok Genilla residents.
        </p>
    </div>

    <div class="rounded-lg bg-white p-6 shadow">

        <!-- Validation error summary -->
        @if ($errors->any())
            <div class="mb-6 rounded bg-red-100 p-4 text-red-700">

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

        <form method="POST" action="{{ route('posts.store') }}">
            @csrf

            <!-- Post title -->
            <div class="mb-5">

                <label for="title"
                       class="mb-2 block font-medium">
                    Post Title
                </label>

                <input
                    type="text"
                    id="title"
                    name="title"
                    value="{{ old('title') }}"
                    maxlength="120"
                    required
                    class="w-full rounded border border-gray-300 px-4 py-2"
                    placeholder="Enter announcement title"
                >

                @error('title')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Post body -->
            <div class="mb-5">

                <label for="body"
                       class="mb-2 block font-medium">
                    Announcement Details
                </label>

                <textarea
                    id="body"
                    name="body"
                    rows="7"
                    minlength="20"
                    required
                    class="w-full rounded border border-gray-300 px-4 py-2"
                    placeholder="Write the announcement details..."
                >{{ old('body') }}</textarea>

                @error('body')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <p class="mt-1 text-xs text-gray-500">
                    Minimum of 20 characters.
                </p>

            </div>

            <!-- Category dropdown -->
            <div class="mb-5">

                <label for="category"
                       class="mb-2 block font-medium">
                    Category
                </label>

                <select
                    id="category"
                    name="category"
                    required
                    class="w-full rounded border border-gray-300 px-4 py-2"
                >
                    <option value="">Select a category</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category }}"
                            @selected(old('category') == $category)
                        >
                            {{ $category }}
                        </option>
                    @endforeach

                </select>

                @error('category')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Tags -->
            <div class="mb-5">

                <p class="mb-2 font-medium">
                    Tags
                </p>

                <p class="mb-3 text-sm text-gray-500">
                    Select at least one tag.
                </p>

                <div class="space-y-2">

                    @foreach ($tags as $tag)
                        <label class="flex items-center gap-3">

                            <input
                                type="checkbox"
                                name="tags[]"
                                value="{{ $tag->id }}"
                                @checked(in_array($tag->id, old('tags', [])))
                                class="h-4 w-4 rounded border-gray-300"
                            >

                            <span class="text-gray-700">
                                {{ $tag->name }}
                            </span>

                        </label>
                    @endforeach

                </div>

                @error('tags')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

                <!-- Individual tag validation errors -->
                @foreach ($errors->get('tags.*') as $message)
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @endforeach

            </div>

            <!-- Publish checkbox -->
            <div class="mb-6">

                <label class="flex items-center gap-3">

                    <input
                        type="checkbox"
                        name="is_published"
                        value="1"
                        @checked(old('is_published', false))
                        class="h-4 w-4 rounded border-gray-300"
                    >

                    <span class="font-medium text-gray-700">
                        Publish now
                    </span>

                </label>

                <p class="mt-2 text-sm text-gray-500">
                    Leave unchecked to save as a draft.
                </p>

                @error('is_published')
                    <p class="mt-2 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <!-- Form buttons -->
            <div class="flex flex-wrap gap-3">

                <button
                    type="submit"
                    class="rounded bg-blue-800 px-6 py-2 font-semibold text-white hover:bg-blue-900"
                >
                    Save Post
                </button>

                <a href="{{ route('posts.index') }}"
                   class="rounded bg-gray-200 px-6 py-2 font-medium text-gray-700 hover:bg-gray-300">
                    Cancel
                </a>

            </div>

        </form>

    </div>

</div>

@endsection

