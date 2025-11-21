@php
use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">User Panel</h2>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('user.dashboard') }}" 
                   class="text-gray-700 hover:bg-green-100 px-4 py-2 rounded transition
                   {{ request()->routeIs('user.dashboard') ? 'font-semibold bg-green-100' : '' }}">
                   My Reports
                </a>
                <a href="{{ route('report.create') }}" 
                   class="text-gray-700 hover:bg-green-100 px-4 py-2 rounded transition
                   {{ request()->routeIs('report.create') ? 'font-semibold bg-green-100' : '' }}">
                   Submit New Report
                </a>
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
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold">Welcome, {{ Auth::user()->name }}!</h1>
                <p class="text-gray-700 mt-1">Here are your submitted reports. You can view or delete them.</p>
            </div>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- Dashboard Summary -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-6">
            <x-dashboard-card title="Total Reports" value="{{ $totalReports ?? 0 }}" color="green" />
            <x-dashboard-card title="Pending Reports" value="{{ $pendingReports ?? 0 }}" color="yellow" />
            <x-dashboard-card title="In Progress" value="{{ $inProgressReports ?? 0 }}" color="blue" />
            <x-dashboard-card title="Resolved Reports" value="{{ $resolvedReports ?? 0 }}" color="green-200" />
            <x-dashboard-card title="Submitted Images" value="{{ $submittedImages ?? 0 }}" color="gray" />
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded shadow overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left">Type</th>
                        <th class="px-4 py-2 text-left">Image</th>
                        <th class="px-4 py-2 text-left">Location</th>
                        <th class="px-4 py-2 text-left">Status</th>
                        <th class="px-4 py-2 text-left">Created At</th>
                        <th class="px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reports as $report)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-4 py-2">
                                <div class="font-semibold">{{ $report->type }}</div>
                                <div class="text-gray-600 text-sm">{{ Str::limit($report->description, 50) }}</div>
                            </td>
                            <td class="px-4 py-2">
                                @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" 
                                         alt="Report Image" class="w-20 h-20 object-cover rounded shadow">
                                @else
                                    <span class="text-gray-500 text-sm">No Image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ $report->location }}</td>
                            <td class="px-4 py-2">
                                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                    @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                                    @elseif($report->status == 'resolved') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                {{ $report->created_at?->format('F d, Y H:i') ?? 'N/A' }}
                            </td>
                            <td class="px-4 py-2 flex gap-2">
                                <form action="{{ route('report.destroy', $report) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 text-gray-600 text-center">
                                No reports submitted yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $reports->links() }}
        </div>
    </main>
</body>
</html>
