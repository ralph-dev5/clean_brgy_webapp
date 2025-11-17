<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clean Brgy App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-blue-600 text-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">Clean Brgy App</h1>
        @auth
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        @endauth
    </header>

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-200 text-gray-700 p-4 text-center">
        &copy; {{ date('Y') }} Clean Brgy App. All rights reserved.
    </footer>

</body>
</html>
