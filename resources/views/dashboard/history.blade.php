@extends('layouts.app')

@section('content')
<div class="flex">

    <!-- MAIN CONTENT -->
    <div class="ml-64 w-full max-w-7xl mx-auto mt-8 px-4">

        <!-- Back Button -->
        <div class="mb-4">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-block px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition">
                &larr; Back to Dashboard
            </a>
        </div>

        <h2 class="text-3xl font-bold text-green-700 mb-6">History</h2>

        @if($reports->isEmpty())
            <div class="bg-green-50 border border-green-200 text-green-800 p-6 rounded-xl shadow-sm text-center">
                <p class="font-medium text-lg">No history reports available.</p>
            </div>
        @else
            <div class="overflow-x-auto bg-white shadow-lg rounded-2xl">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-green-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Location</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($reports as $report)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-3 font-medium">{{ $report->id }}</td>
                            <td class="px-6 py-3">{{ Str::limit($report->description, 60) }}</td>
                            <td class="px-6 py-3">{{ $report->location ?? '-' }}</td>
                            <td class="px-6 py-3">
                                @if($report->status === 'resolved')
                                    <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Resolved</span>
                                @else
                                    <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Pending</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">{{ $report->created_at->format('M d, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

    </div>

</div>
@endsection
