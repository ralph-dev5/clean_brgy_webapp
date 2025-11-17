@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Garbage Reports</h1>
        <a href="{{ route('report.create') }}" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">
            Add New Report
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Resident</th>
                    <th class="px-4 py-2 border">Location</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Image</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr>
                    <td class="px-4 py-2 border">{{ $report->id }}</td>
                    <td class="px-4 py-2 border">{{ $report->user->name }}</td>
                    <td class="px-4 py-2 border">{{ $report->type }}</td>
                    <td class="px-4 py-2 border">{{ Str::limit($report->description, 50) }}</td>
                    <td class="px-4 py-2 border">
                        @if($report->image)
                        <img src="{{ asset('storage/' . $report->image) }}" class="w-24 h-auto rounded">
                        @else
                        N/A
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.reports.show', $report->id) }}" class="text-blue-600 hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center px-4 py-2 border">No reports found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
