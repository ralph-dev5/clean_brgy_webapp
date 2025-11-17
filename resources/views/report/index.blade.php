@extends('layouts.app') <!-- Make sure this layout exists -->

@section('content')
<div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-3xl font-bold mb-6">All Garbage Reports</h1>

    @if($reports->isEmpty())
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded mb-4">
            No reports submitted yet.
        </div>
    @else
        <table class="min-w-full bg-white border border-gray-300 rounded-lg overflow-hidden">
            <thead class="bg-gray-200">
                <tr>
                    <th class="px-4 py-2 border">ID</th>
                    <th class="px-4 py-2 border">Resident</th>
                    <th class="px-4 py-2 border">Description</th>
                    <th class="px-4 py-2 border">Image</th>
                    <th class="px-4 py-2 border">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reports as $report)
                <tr>
                    <td class="px-4 py-2 border">{{ $report->id }}</td>
                    <td class="px-4 py-2 border">{{ $report->user->name }}</td>
                    <td class="px-4 py-2 border">{{ Str::limit($report->description, 50) }}</td>
                    <td class="px-4 py-2 border">
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" class="w-20 h-auto rounded">
                        @else
                            <span class="text-gray-500 italic">No image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('admin.reports.show', $report->id) }}" 
                           class="text-blue-600 hover:underline">
                            View
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
