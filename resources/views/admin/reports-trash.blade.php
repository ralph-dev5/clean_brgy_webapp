<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trash | Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition">Dashboard</a>
                <a href="{{ route('admin.reports.index') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition">Reports</a>
                <a href="{{ route('admin.reports.trash') }}" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition font-semibold bg-gray-200">Trash</a>
                <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition">Trash</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">Logout</button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-4">Trash</h1>
        <p class="text-gray-700 mb-6">These reports have been deleted. You can restore or permanently delete them.</p>

        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">User</th>
                        <th class="px-4 py-2 text-left">Deleted At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2">{{ $report->title }}</td>
                            <td class="px-4 py-2">{{ $report->user->name }}</td>
                            <td class="px-4 py-2">{{ $report->deleted_at->format('F d, Y H:i') }}</td>
                            <td class="px-4 py-2 flex gap-2">
                                <!-- Restore Button -->
                                <form method="POST" action="{{ route('admin.reports.restore', $report->id) }}">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">Restore</button>
                                </form>

                                <!-- Force Delete Button -->
                                <form method="POST" action="{{ route('admin.reports.forceDelete', $report->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-2 text-gray-600 text-center">Trash is empty.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
