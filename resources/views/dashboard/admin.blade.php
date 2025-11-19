@extends('layouts.app')

@section('content')
    <div class="flex">

        {{-- ===== SIDEBAR ===== --}}
        <aside class="w-64 h-screen bg-green-700 text-white flex flex-col justify-between fixed">

            {{-- Top Menu --}}
            <div>
                <div class="p-6 border-b border-green-600">
                    <h2 class="text-xl font-bold">Admin Panel</h2>
                </div>

                <nav class="mt-6 flex flex-col space-y-2 px-4">
                    <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg hover:bg-green-600 transition">
                        Dashboard
                    </a>
                    <a href="{{ route('admin.profile') }}" class="px-4 py-2 rounded-lg hover:bg-green-600 transition">
                        Profile
                    </a>
                    <a href="{{ route('admin.history') }}" class="px-4 py-2 rounded-lg hover:bg-green-600 transition">
                        History
                    </a>
                    <a href="{{ route('admin.reports.index') }}" class="px-4 py-2 rounded-lg hover:bg-green-600 transition">
                        Reports
                    </a>
                </nav>
            </div>

            {{-- Bottom Logout --}}
            <div class="p-4 border-t border-green-600">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button
                        class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition flex items-center justify-center gap-2">
                        Log Out
                    </button>
                </form>
            </div>
        </aside>

        {{-- ===== MAIN CONTENT ===== --}}
        <div class="ml-64 w-full max-w-7xl mx-auto mt-8 px-4">

            {{-- Header --}}
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-3xl font-bold text-green-700">Admin Dashboard</h2>
            </div>

            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow rounded-xl p-6 flex flex-col items-start">
                    <span class="text-gray-500">Total Reports</span>
                    <h3 class="text-2xl font-bold text-green-700">{{ $reports->count() }}</h3>
                </div>

                <div class="bg-white shadow rounded-xl p-6 flex flex-col items-start">
                    <span class="text-gray-500">Pending Reports</span>
                    <h3 class="text-2xl font-bold text-yellow-500">{{ $reports->where('status', 'pending')->count() }}</h3>
                </div>

                <div class="bg-white shadow rounded-xl p-6 flex flex-col items-start">
                    <span class="text-gray-500">Resolved Reports</span>
                    <h3 class="text-2xl font-bold text-green-600">{{ $reports->where('status', 'resolved')->count() }}</h3>
                </div>
            </div>

            {{-- Reports Table --}}
            <div class="overflow-x-auto bg-white shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Location</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Image</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($reports as $report)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-3 font-medium">{{ $report->id }}</td>
                                <td class="px-6 py-3">{{ Str::limit($report->description, 60) }}</td>
                                <td class="px-6 py-3">{{ $report->location ?? '-' }}</td>
                                <td class="px-6 py-3">
                                    @if($report->image)
                                        <img src="{{ asset('storage/' . $report->image) }}"
                                            class="w-20 h-16 object-cover rounded-lg shadow-sm">
                                    @else
                                        <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3">
                                    @if($report->status === 'resolved')
                                        <span
                                            class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Resolved</span>
                                    @elseif($report->status === 'in-progress')
                                        <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">In
                                            Progress</span>
                                    @else
                                        <span
                                            class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Pending</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 flex gap-2">
                                    <form action="{{ route('admin.reports.destroy', $report->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to delete this report?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-sm">
                                            Done
                                        </button>

                                    </form>
                                    <a href="{{ route('admin.reports.show', $report->id) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition text-sm">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection