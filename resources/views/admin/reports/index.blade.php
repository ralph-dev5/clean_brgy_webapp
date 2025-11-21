@extends('layouts.app')

@section('content')
    <div class="container mx-auto mt-10">

        <div class="flex flex-col md:flex-row items-center justify-between mb-6 gap-4">
            <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition flex items-center gap-1">
                ← Back to Dashboard
            </a>
            <h1 class="text-3xl font-bold text-gray-800">All Reports</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 shadow">
                {{ session('success') }}
            </div>
        @endif

        @php
            $reportSections = [
                'Pending Reports' => ['data' => $pendingReports, 'color' => 'yellow-600', 'next_status' => 'in-progress'],
                'In Progress Reports' => ['data' => $inProgressReports, 'color' => 'blue-600', 'next_status' => 'resolved'],
                'Resolved Reports' => ['data' => $resolvedReports, 'color' => 'green-600', 'next_status' => null],
            ];
        @endphp

        @foreach($reportSections as $sectionName => $section)
            <h2 class="text-xl font-semibold mt-8 mb-2">{{ $sectionName }}</h2>
            <div class="bg-white shadow rounded-lg p-4 overflow-x-auto mb-6">
                <table class="w-full border-collapse table-auto">
                    <thead>
                        <tr class="bg-gray-100 border-b">
                            <th class="py-2 px-3 text-left">ID</th>
                            <th class="py-2 px-3 text-left">Image</th>
                            <th class="py-2 px-3 text-left">Location</th>
                            <th class="py-2 px-3 text-left">Status</th>
                            <th class="py-2 px-3 text-left">Created At</th>
                            <th class="py-2 px-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($section['data'] as $report)
                            <tr class="border-b hover:bg-gray-50 transition">
                                <td class="py-2 px-3 font-medium">{{ $report->id }}</td>
                                <td class="py-2 px-3">
                                    @if($report->image)
                                        <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image"
                                            class="h-16 w-16 object-cover rounded shadow-sm">
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="py-2 px-3">{{ $report->location ?? '-' }}</td>
                                <td class="py-2 px-3">
                                    <span class="px-2 py-1 rounded text-white bg-{{ $section['color'] }}">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="py-2 px-3 text-gray-600">{{ $report->created_at->format('M d, Y H:i') }}</td>
                                <td class="py-2 px-3 flex flex-wrap gap-2">
                                    <a href="{{ route('admin.reports.show', $report) }}"
                                        class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                                        View
                                    </a>

                                    @if($section['next_status'])
                                        <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="{{ $section['next_status'] }}">
                                            <button class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition">
                                                Done
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-4 text-center text-gray-500">No {{ strtolower($sectionName) }} found.</td>
                            </tr>
                        @endforelse
                    </tbody>


                </table>
            </div>
        @endforeach

    </div>
@endsection