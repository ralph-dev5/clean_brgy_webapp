@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-xl">

    {{-- ===== Back Button ===== --}}
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
            &larr; Back to Dashboard
        </a>
    </div>

    {{-- ===== Page Title ===== --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">All Garbage Reports</h1>

    {{-- ===== Status Tabs ===== --}}
    @php
        // Selected tab from request
        $currentStatus = request('status', 'pending');

        // All statuses
        $statuses = [
            'pending' => 'Pending',
            'in-progress' => 'In Progress',
            'resolved' => 'Resolved'
        ];
    @endphp

    <div class="flex space-x-4 mb-6">
        @foreach($statuses as $key => $label)
            <a href="{{ url('/admin/reports?status=' . $key) }}"
               class="px-4 py-2 rounded-lg font-semibold 
               {{ $currentStatus === $key 
                    ? ($key === 'pending' ? 'bg-yellow-600 text-white' 
                        : ($key === 'in-progress' ? 'bg-blue-600 text-white' 
                        : 'bg-green-600 text-white')) 
                    : 'bg-gray-200 text-gray-700' }}">
                {{ $label }}
            </a>
        @endforeach
    </div>

    {{-- ===== Filtered Reports ===== --}}
    @php
        $filteredReports = $reports->where('status', $currentStatus);
    @endphp

    @if($filteredReports->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg border border-yellow-300">
            No reports found for this category.
        </div>
    @else
        <div class="overflow-x-auto rounded-lg shadow">
            <table class="w-full bg-white border border-gray-200 rounded-lg">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-4 py-3 border">ID</th>
                        <th class="px-4 py-3 border">Resident</th>
                        <th class="px-4 py-3 border">Description</th>
                        <th class="px-4 py-3 border">Image</th>
                        <th class="px-4 py-3 border">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-800">
                    @foreach($filteredReports as $report)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-4 py-2 border text-center font-semibold">{{ $report->id }}</td>
                            <td class="px-4 py-2 border">{{ $report->user->name }}</td>
                            <td class="px-4 py-2 border">{{ Str::limit($report->description, 60) }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" 
                                         class="w-20 h-20 object-cover rounded-lg border">
                                @else
                                    <span class="text-gray-500 italic">No image</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 border text-center">
                                <a href="{{ route('admin.reports.show', $report->id) }}" 
                                   class="inline-block px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    View
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
