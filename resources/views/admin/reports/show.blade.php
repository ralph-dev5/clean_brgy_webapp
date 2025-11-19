@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10 p-8 bg-white shadow-lg rounded-xl">

    {{-- ===== Back Button ===== --}}
    <div class="mb-4">
        <a href="{{ route('admin.reports.index') }}" 
           class="inline-block px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
            &larr; Back to Reports
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Report Details</h1>

    <div class="space-y-4">
        <p><strong>ID:</strong> {{ $report->id }}</p>
        <p><strong>Resident:</strong> {{ $report->user->name }}</p>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Location:</strong> {{ $report->location ?? '-' }}</p>
        <p><strong>Status:</strong> 
            @if($report->status === 'resolved')
                <span class="px-2 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Resolved</span>
            @elseif($report->status === 'in-progress')
                <span class="px-2 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">In Progress</span>
            @else
                <span class="px-2 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">Pending</span>
            @endif
        </p>
        <p><strong>Image:</strong></p>
        @if($report->image)
            <img src="{{ asset('storage/' . $report->image) }}" class="w-64 h-64 object-cover rounded-lg border">
        @else
            <span class="text-gray-500 italic">No Image</span>
        @endif
    </div>

</div>
@endsection
