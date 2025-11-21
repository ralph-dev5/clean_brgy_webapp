<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Reports | Clean Barangay App</title>
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
                <a href="#" class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition">Settings</a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">Logout</button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-4">Reports</h1>

        <!-- Status Filter Tabs -->
        <div class="flex gap-4 mb-6">
            <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}"
               class="px-4 py-2 rounded font-semibold transition
                      {{ $status == 'pending' ? 'bg-yellow-200 text-yellow-800' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
               ⏳ Pending
            </a>
            <a href="{{ route('admin.reports.index', ['status' => 'in-progress']) }}"
               class="px-4 py-2 rounded font-semibold transition
                      {{ $status == 'in-progress' ? 'bg-blue-200 text-blue-800' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
               🔄 In Progress
            </a>
            <a href="{{ route('admin.reports.index', ['status' => 'resolved']) }}"
               class="px-4 py-2 rounded font-semibold transition
                      {{ $status == 'resolved' ? 'bg-green-200 text-green-800' : 'bg-white text-gray-700 hover:bg-gray-200' }}">
               ✅ Processed
            </a>
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Title</th>
                        <th class="px-4 py-2 text-left">User</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Created At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-gray-50 transition">
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
                            <td class="px-4 py-2 flex gap-2">
                                <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:underline">View</a>

                                @if($report->status == 'pending')
                                    <form method="POST" action="{{ route('admin.reports.updateStatus', $report->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="in-progress">
                                        <button type="submit" class="text-green-600 hover:underline">Done</button>
                                    </form>
                                @elseif($report->status == 'in-progress')
                                    <form method="POST" action="{{ route('admin.reports.updateStatus', $report->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="resolved">
                                        <button type="submit" class="text-purple-600 hover:underline">Done</button>
                                    </form>
                                @elseif($report->status == 'resolved')
                                    <form method="POST" action="{{ route('admin.reports.destroy', $report->id) }}" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-2 text-gray-600">No reports found for this status.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>

</body>
</html>
