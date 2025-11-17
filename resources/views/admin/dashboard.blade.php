<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Panel</h2>
            <nav class="flex flex-col gap-4">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Dashboard</a>
                <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Users</a>
                <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Reports</a>
                <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded">Settings</a>

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
        <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }} (Admin)!</h1>
        <p class="text-gray-700 mb-6">This is the admin dashboard. You can manage users, view reports, and configure settings.</p>
    </main>

</body>
</html>
