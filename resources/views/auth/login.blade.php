@extends('layouts.app')

@section('title', 'Login - Purok Genilla')

@section('content')

<div class="mx-auto max-w-md">

    <div class="rounded-lg bg-white p-8 shadow">

        <h1 class="mb-2 text-2xl font-bold text-blue-900">
            Barangay Bulletin Login
        </h1>

        <p class="mb-6 text-sm text-gray-600">
            Sign in to your Purok Genilla account.
        </p>

        <!-- Display login errors -->
        @if ($errors->any())
            <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div class="mb-4">
                <label for="email"
                       class="mb-1 block font-medium">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    class="w-full rounded border border-gray-300 px-4 py-2"
                >

                @error('email')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-6">
                <label for="password"
                       class="mb-1 block font-medium">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    required
                    class="w-full rounded border border-gray-300 px-4 py-2"
                >

                @error('password')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button
                type="submit"
                class="w-full rounded bg-blue-800 px-4 py-2 font-semibold text-white hover:bg-blue-900">
                Sign In
            </button>
        </form>

        <p class="mt-6 text-center text-sm">
            <a href="{{ route('posts.index') }}"
               class="text-blue-700 hover:underline">
                Back to Announcements
            </a>
        </p>

    </div>

</div>

@endsection
