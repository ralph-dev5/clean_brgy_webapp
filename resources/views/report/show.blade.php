@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">

    <div class="bg-white shadow rounded-lg p-6">

        <h1 class="text-2xl font-bold mb-4">Report Details</h1>

        <div class="grid grid-cols-2 gap-6">

            <div>
                <h2 class="text-lg font-semibold">Type:</h2>
                <p class="text-gray-700">{{ $report->type }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold">User:</h2>
                <p class="text-gray-700">{{ $report->user->name }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold">Location:</h2>
                <p class="text-gray-700">{{ $report->location }}</p>
            </div>

            <div>
                <h2 class="text-lg font-semibold">Status:</h2>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($report->status == 'pending') bg-yellow-200 text-yellow-800
                    @elseif($report->status == 'in-progress') bg-blue-200 text-blue-800
                    @elseif($report->status == 'resolved') bg-green-200 text-green-800
                    @endif">
                    {{ ucfirst($report->status) }}
                </span>
            </div>

            <div class="col-span-2">
                <h2 class="text-lg font-semibold">Description:</h2>
                <p class="text-gray-700">{{ $report->description ?? 'No description provided.' }}</p>
            </div>

            <div class="col-span-2">
                <h2 class="text-lg font-semibold mb-2">Image:</h2>

                @if($report->image)
                    <img
                        src="{{ asset('storage/' . $report->image) }}"
                        class="w-64 h-64 object-cover rounded border"
                    >
                @else
                    <p class="text-gray-500">No image uploaded.</p>
                @endif
            </div>

        </div>

        <div class="mt-6 flex gap-3">

            <a href="{{ route('admin.reports.index') }}"
               class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800">
                Back to Reports
            </a>

            

        </div>

    </div>

</div>
@endsection
