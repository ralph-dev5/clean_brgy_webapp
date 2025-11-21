<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clean Brgy App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- Main Content -->
    <main class="flex-1 p-6">
        @if(session('success'))
            
        @endif

        @yield('content')
    </main>

    <!-- Footer (only on welcome page) -->
    @if(Request::is('/'))
        <footer class="bg-gray-200 text-gray-700 p-4 text-center">
            &copy; {{ date('Y') }} Clean Brgy App. All rights reserved.
        </footer>
    @endif

</body>
</html>
