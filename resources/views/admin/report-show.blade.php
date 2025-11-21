@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-4">Report Details</h1>

    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-semibold mb-2">{{ $report->title }}</h2>
        <p><strong>Status:</strong> {{ ucfirst($report->status) }}</p>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Location:</strong> {{ $report->location ?? 'N/A' }}</p>
        <p><strong>Reported by:</strong> {{ $report->user->name ?? 'Unknown' }}</p>
        <p><strong>Created at:</strong> {{ $report->created_at->format('F d, Y H:i') }}</p>

        <a href="{{ route('admin.reports.index') }}" 
           class="mt-4 inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
           Back to Reports
        </a>
    </div>
</div>
@endsection
