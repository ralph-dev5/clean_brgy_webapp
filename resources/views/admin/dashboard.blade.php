<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Panel</h2>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.dashboard') ? 'font-semibold bg-gray-200' : '' }}">
                   Dashboard
                </a>

                <!-- Reports Link -->
                <a href="{{ route('admin.reports.index') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.reports.*') ? 'font-semibold bg-gray-200' : '' }}">
                   Reports
                </a>

                <!-- Trash Link -->
                <a href="{{ route('admin.reports.trash') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.reports.trash') ? 'font-semibold bg-gray-200' : '' }}">
                   Deleted reports
                </a>

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" 
                            class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-4">Welcome, {{ Auth::user()->name }} (Admin)!</h1>
        <p class="text-gray-700 mb-6">This is your admin dashboard. Manage users, view reports, and configure settings.</p>

        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-6">
            <div class="p-6 bg-blue-100 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-blue-700">Total Users</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="p-6 bg-green-100 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-green-700">Total Reports</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalReports ?? 0 }}</p>
            </div>
            <div class="p-6 bg-yellow-100 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-yellow-800">Pending Reports ⏳</h2>
                <p class="text-2xl font-bold mt-2">{{ $pendingReports ?? 0 }}</p>
            </div>
            <div class="p-6 bg-purple-100 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-purple-800">In Progress Reports 🔄</h2>
                <p class="text-2xl font-bold mt-2">{{ $inProgressReports ?? 0 }}</p>
            </div>
            <div class="p-6 bg-gray-200 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800">Processed Reports ✅</h2>
                <p class="text-2xl font-bold mt-2">{{ $resolvedReports ?? 0 }}</p>
            </div>
        </div>

        <!-- Recent Reports Table -->
        <div class="mt-10 bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Recent Reports</h2>
            @if(!empty($recentReports) && $recentReports->count() > 0)
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b">
                        <th class="px-4 py-2">Title</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Created At</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentReports as $report)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-2">{{ $report->title }}</td>
                        <td class="px-4 py-2">{{ $report->user->name }}</td>
                        <td class="px-4 py-2">
                            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                                @elseif($report->status == 'resolved') bg-green-100 text-green-800
                                @else bg-gray-100 text-gray-800 @endif">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-2">{{ $report->created_at->format('F d, Y') }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('admin.reports.show', $report) }}" class="text-blue-600 hover:underline">View</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
                <p class="text-gray-600">No recent reports available.</p>
            @endif
        </div>

    </main>
</body>
</html>
