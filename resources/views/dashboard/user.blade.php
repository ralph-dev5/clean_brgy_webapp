@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-6">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Your Reports</h2>
        <a href="{{ route('report.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            + Submit New Report
        </a>
    </div>

    <!-- List of Reports -->
    @if($reports->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
            You haven't submitted any reports yet.
        </div>
    @else
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">ID</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Description</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Image</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reports as $report)
                        <tr>
                            <td class="px-4 py-2">{{ $report->id }}</td>
                            <td class="px-4 py-2">{{ Str::limit($report->description, 50) }}</td>
                            <td class="px-4 py-2">
                                @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" class="w-20 h-auto rounded">
                                @else
                                    -
                                @endif
                            </td>
                            <td class="px-4 py-2">{{ ucfirst($report->status ?? 'Pending') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
