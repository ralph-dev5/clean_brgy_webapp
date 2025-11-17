<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Clean Barangay</h2>
            <nav class="flex flex-col gap-4">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Dashboard</a>
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Settings</a>
                
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-700 mb-6">This is your dashboard. You can view reports and manage your account here.</p>

        <!-- Dashboard Buttons -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
            <a href="#" class="bg-green-600 text-white p-6 rounded-xl shadow hover:bg-green-700 transition">
                <h3 class="font-semibold text-lg mb-2">Reports</h3>
                <p class="text-gray-100 text-sm">View your submitted reports.</p>
            </a>

            <a href="#" class="bg-yellow-500 text-white p-6 rounded-xl shadow hover:bg-yellow-600 transition">
                <h3 class="font-semibold text-lg mb-2">Pending Reports</h3>
                <p class="text-gray-100 text-sm">Check reports that need approval.</p>
            </a>
        </div>
    </main>

</body>
</html>
