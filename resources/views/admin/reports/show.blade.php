@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto mt-12 p-8 bg-white shadow-2xl rounded-2xl">

    {{-- ===== Back Button ===== --}}
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" 
           class="inline-block px-5 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition transform hover:scale-105">
            &larr; Back to Dashboard
        </a>
    </div>

    {{-- ===== Header ===== --}}
    <h1 class="text-4xl font-extrabold text-gray-800 mb-8">Report Details</h1>

    {{-- ===== Report Info ===== --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        {{-- Left Column --}}
        <div class="space-y-4">
            <p><strong>ID:</strong> <span class="text-gray-700">{{ $report->id }}</span></p>
            <p><strong>Resident:</strong> <span class="text-gray-700">{{ $report->user->name }}</span></p>
            <p><strong>Description:</strong> <span class="text-gray-700">{{ $report->description }}</span></p>
            <p><strong>Location:</strong> <span class="text-gray-700">{{ $report->location ?? '-' }}</span></p>
            <p><strong>Status:</strong> 
                @if($report->status === 'resolved')
                    <span class="px-3 py-1 rounded-full bg-green-100 text-green-700 font-semibold">Resolved</span>
                @elseif($report->status === 'in-progress')
                    <span class="px-3 py-1 rounded-full bg-blue-100 text-blue-700 font-semibold">In Progress</span>
                @else
                    <span class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 font-semibold">Pending</span>
                @endif
            </p>
        </div>

        {{-- Right Column (Image) --}}
        <div class="flex items-center justify-center">
            @if($report->image)
                <img src="{{ asset('storage/' . $report->image) }}" 
                     alt="Report Image" 
                     class="w-full max-w-md h-64 object-cover rounded-xl shadow-lg border">
            @else
                <div class="w-full max-w-md h-64 flex items-center justify-center bg-gray-100 rounded-xl border">
                    <span class="text-gray-400 italic">No Image Available</span>
                </div>
            @endif
        </div>

    </div>

</div>
@endsection
