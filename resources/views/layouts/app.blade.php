<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Barangay Bulletin - Purok Genilla')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-gray-100 text-gray-800">

    <!-- Main navigation -->
    <header class="bg-blue-800 text-white shadow">

        <nav class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-4 py-5">

            <a href="{{ route('posts.index') }}"
               class="text-xl font-bold">
                Barangay Bulletin - Purok Genilla
            </a>

            <div class="flex flex-wrap items-center gap-4">

                @guest
                    <a href="{{ route('login') }}"
                       class="rounded bg-white px-4 py-2 font-medium text-blue-800 hover:bg-gray-100">
                        Login
                    </a>
                @endguest

                @auth

                    <!-- New Post: authors only -->
                    @if (Auth::user()->author()->exists())

                        <a href="{{ route('posts.create') }}"
                           class="rounded bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                            New Post
                        </a>

                    @endif

                    <span class="text-sm">
                        Welcome, {{ Auth::user()->name }}
                    </span>

                    <!-- Logout form -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button
                            type="submit"
                            class="rounded bg-red-600 px-4 py-2 text-white hover:bg-red-700">
                            Logout
                        </button>
                    </form>

                @endauth

            </div>

        </nav>

    </header>

    <!-- Main page content -->
    <main class="mx-auto max-w-6xl px-4 py-8">

        <!-- Flash success message -->
        @if (session('status'))
            <div class="mb-6 rounded bg-green-100 p-4 text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')

    </main>

    <!-- Footer -->
    <footer class="mt-10 bg-gray-200 py-5 text-center text-sm">
        <p>&copy; {{ date('Y') }} Purok Genilla Bulletin</p>
    </footer>

</body>
</html>

