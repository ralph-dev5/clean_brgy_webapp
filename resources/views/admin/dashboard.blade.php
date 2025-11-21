@extends('layouts.app')

@section('content')
<div class="flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg sticky top-0 h-screen">
        <div class="p-6 flex flex-col h-full">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Panel</h2>
            <nav class="flex flex-col gap-2 flex-1">
                <a href="{{ route('admin.dashboard') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.dashboard') ? 'font-semibold bg-gray-200' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.reports.index') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.reports.*') ? 'font-semibold bg-gray-200' : '' }}">
                    Reports
                </a>
                <a href="{{ route('admin.reports.trash') }}" 
                   class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
                   {{ request()->routeIs('admin.reports.trash') ? 'font-semibold bg-gray-200' : '' }}">
                    Deleted Reports
                </a>
            </nav>
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" 
                        class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10 bg-gray-100">
        <h1 class="text-3xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h1>
        <p class="text-gray-700 mb-6">This is your admin dashboard. Manage users, view reports, and configure settings.</p>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <div class="bg-blue-100 p-6 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-blue-700">Total Users</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalUsers ?? 0 }}</p>
            </div>
            <div class="bg-green-100 p-6 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-green-700">Total Reports</h2>
                <p class="text-2xl font-bold mt-2">{{ $totalReports ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 p-6 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-yellow-800">Pending Reports ⏳</h2>
                <p class="text-2xl font-bold mt-2">{{ $pendingReports ?? 0 }}</p>
            </div>
            <div class="bg-purple-100 p-6 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-purple-800">In Progress Reports 🔄</h2>
                <p class="text-2xl font-bold mt-2">{{ $inProgressReports ?? 0 }}</p>
            </div>
            <div class="bg-gray-200 p-6 rounded shadow hover:shadow-lg transition">
                <h2 class="text-xl font-semibold text-gray-800">Processed Reports ✅</h2>
                <p class="text-2xl font-bold mt-2">{{ $resolvedReports ?? 0 }}</p>
            </div>
        </div>

        <!-- Recent Reports Table -->
        <div class="mt-10 bg-white rounded shadow p-6">
            <h2 class="text-2xl font-bold mb-4">Recent Reports</h2>
            @if($recentReports->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full table-auto border-collapse">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="px-4 py-2 text-left">ID</th>
                            <th class="px-4 py-2 text-left">Purok</th>
                            <th class="px-4 py-2 text-left">User</th>
                            <th class="px-4 py-2 text-left">Status</th>
                            <th class="px-4 py-2 text-left">Created At</th>
                            <th class="px-4 py-2 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentReports as $report)
                        <tr class="hover:bg-gray-50 transition border-b">
                            <td class="px-4 py-2 font-medium">{{ $report->id }}</td>
                            <td class="px-4 py-2">{{ $report->location }}</td>
                            <td class="px-4 py-2">{{ $report->user->name }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-sm font-semibold
                                    @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                                    @elseif($report->status == 'resolved') bg-green-100 text-green-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($report->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $report->created_at->format('F d, Y') }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.reports.show', $report) }}"
                                   class="text-blue-600 hover:underline">View</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
                <p class="text-gray-600">No recent reports available.</p>
            @endif
        </div>

    </main>
</div>
@endsection
