@extends('layouts.app')

@section('content')
<div x-data="{ sidebarOpen: true }" class="flex min-h-screen bg-gray-50">

    <!-- Sidebar -->
    <aside 
        :class="sidebarOpen ? 'w-64' : 'w-0'"
        class="bg-white shadow-lg sticky top-0 h-screen border-r overflow-hidden transition-all duration-300"
    >
        <div class="p-6 flex flex-col h-full">
            <h2 class="text-2xl font-bold text-green-700 mb-8">Admin Panel</h2>

            <!-- Navigation -->
            <nav class="flex flex-col gap-2 flex-1">
                @php
                    function navItem($label, $route, $active, $color='green') {
                        return '
                        <a href="'.route($route).'"
                           class="px-4 py-2 rounded-lg transition
                                  '.($active
                                      ? "bg-$color-100 text-$color-800 font-semibold shadow-sm"
                                      : "text-gray-700 hover:bg-$color-50 hover:text-$color-700"
                                  ).'">
                            '.$label.'
                        </a>';
                    }
                @endphp

                {!! navItem('Dashboard', 'admin.dashboard', request()->routeIs('admin.dashboard')) !!}
                {!! navItem('Reports', 'admin.reports.index', request()->routeIs('admin.reports.*'), 'blue') !!}
                {!! navItem('Deleted Reports', 'admin.reports.trash', request()->routeIs('admin.reports.trash'), 'red') !!}
                {!! navItem('Users', 'admin.users', request()->routeIs('admin.users'), 'purple') !!}
                {!! navItem('Analytics', 'admin.analytics', request()->routeIs('admin.analytics'), 'yellow') !!}
                {!! navItem('Settings', 'admin.settings', request()->routeIs('admin.settings'), 'gray') !!}
            </nav>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-2 rounded-lg text-red-600 hover:bg-red-100 font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">

        <!-- Toggle Sidebar Button (above the dashboard card) -->
        <div class="mb-4">
            <button 
                @click="sidebarOpen = !sidebarOpen"
                class="px-3 py-2 bg-gray-200 hover:bg-gray-300 rounded-lg shadow transition"
                title="Toggle Sidebar"
            >
                ☰
            </button>
        </div>

        <!-- Dashboard Header Card -->
        <div class="bg-white rounded-xl shadow border p-6 mb-10 flex items-center gap-4">

            <!-- Admin Avatar -->
            @php $admin = Auth::user(); @endphp
            @if($admin->avatar && file_exists(storage_path('app/public/' . $admin->avatar)))
                <img src="{{ asset('storage/' . $admin->avatar) }}"
                     alt="Admin Avatar"
                     class="w-12 h-12 rounded-full border border-gray-300 object-cover shadow-sm">
            @else
                <div class="w-12 h-12 rounded-full bg-gray-300 flex items-center justify-center 
                            text-white text-lg font-semibold shadow-sm">
                    {{ strtoupper(substr($admin->name, 0, 1)) }}
                </div>
            @endif

            <!-- Welcome Text -->
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900">Welcome, {{ $admin->name }} 👋</h1>
                <p class="text-gray-600 mt-1">Here are the latest updates and system statuses.</p>
            </div>

        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-6">
            <div class="p-6 rounded-xl bg-green-50 border-l-4 border-green-500 shadow hover:shadow-lg transition">
                <h2 class="text-gray-700 font-medium">Total Users</h2>
                <p class="text-3xl font-bold mt-2 text-green-700">{{ $totalUsers ?? 0 }}</p>
            </div>

            <div class="p-6 rounded-xl bg-blue-50 border-l-4 border-blue-500 shadow hover:shadow-lg transition">
                <h2 class="text-gray-700 font-medium">Total Reports</h2>
                <p class="text-3xl font-bold mt-2 text-blue-700">{{ $totalReports ?? 0 }}</p>
            </div>

            <div class="p-6 rounded-xl bg-yellow-50 border-l-4 border-yellow-500 shadow hover:shadow-lg transition">
                <h2 class="text-gray-700 font-medium">Pending Reports ⏳</h2>
                <p class="text-3xl font-bold mt-2 text-yellow-600">{{ $pendingReports ?? 0 }}</p>
            </div>

            <div class="p-6 rounded-xl bg-blue-50 border-l-4 border-blue-600 shadow hover:shadow-lg transition">
                <h2 class="text-gray-700 font-medium">In Progress 🔄</h2>
                <p class="text-3xl font-bold mt-2 text-blue-600">{{ $inProgressReports ?? 0 }}</p>
            </div>

            <div class="p-6 rounded-xl bg-green-50 border-l-4 border-green-600 shadow hover:shadow-lg transition">
                <h2 class="text-gray-700 font-medium">Resolved Reports ✅</h2>
                <p class="text-3xl font-bold mt-2 text-green-600">{{ $resolvedReports ?? 0 }}</p>
            </div>
        </div>

        <!-- Recent Reports -->
        <div class="mt-12 bg-white rounded-xl shadow border p-6">
            <h2 class="text-2xl font-bold mb-6">Recent Reports</h2>

            @if($recentReports->count())
                <div class="overflow-x-auto">
                    <table class="w-full table-auto border-collapse">
                        <thead>
                            <tr class="bg-gray-100 text-gray-700 border-b">
                                <th class="px-4 py-3 text-left font-semibold">ID</th>
                                <th class="px-4 py-3 text-left font-semibold">Purok</th>
                                <th class="px-4 py-3 text-left font-semibold">User</th>
                                <th class="px-4 py-3 text-left font-semibold">Status</th>
                                <th class="px-4 py-3 text-left font-semibold">Created At</th>
                                <th class="px-4 py-3 text-left font-semibold">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($recentReports as $report)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-medium">{{ $report->id }}</td>
                                    <td class="px-4 py-3">{{ $report->location }}</td>
                                    <td class="px-4 py-3">{{ $report->user->name }}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 rounded-full text-sm font-semibold
                                            @if($report->status == 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($report->status == 'in-progress') bg-blue-100 text-blue-700
                                            @elseif($report->status == 'resolved') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-gray-700">{{ $report->created_at->format('F d, Y') }}</td>
                                    <td class="px-4 py-3">
                                        <a href="{{ route('admin.reports.show', $report) }}"
                                           class="text-blue-600 font-semibold hover:underline">
                                            View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            @else
                <div class="text-center py-10">
                    <p class="text-gray-500 text-lg">No recent reports available.</p>
                </div>
            @endif
        </div>

    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
