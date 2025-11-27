@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4 lg:px-0 space-y-6">

    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-200 text-gray-800 rounded-md shadow hover:bg-gray-300 transition text-sm font-medium">
            Back
        </a>
    </div>

    <h1 class="text-2xl font-bold text-gray-900 mb-6">
        Analytics
    </h1>

    <!-- Statistics Cards -->
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

    <!-- Top Users Table -->
    <div class="mt-12 bg-white rounded-xl shadow border p-6">
        <h2 class="text-2xl font-bold mb-6">Top Users</h2>

        @if($topUsers->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full table-auto border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 border-b">
                        <th class="px-4 py-3 text-left font-semibold">User</th>
                        <th class="px-4 py-3 text-left font-semibold">Total Reports</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($topUsers as $user)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3 font-semibold">{{ $user->reports_count }}</td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>

        @else
        <div class="text-center py-10">
            <p class="text-gray-500 text-lg">No top users available.</p>
        </div>
        @endif
    </div>

</div>
@endsection
