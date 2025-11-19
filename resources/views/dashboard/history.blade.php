@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-12">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.dashboard') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            ← Back
        </a>
        <h1 class="text-4xl font-bold text-gray-800 tracking-wide">History</h1>
        <div></div>
    </div>

    {{-- History Table --}}
    <div class="bg-white p-6 rounded-2xl shadow-xl border border-gray-200 overflow-x-auto">
        <table class="w-full border-collapse">
            <thead>
                <tr class="bg-gray-100 text-gray-700 uppercase text-sm">
                    <th class="p-3 border">ID</th>
                    <th class="p-3 border">Description</th>
                    <th class="p-3 border">Location</th>
                    <th class="p-3 border">Image</th>
                    <th class="p-3 border">Status</th>
                    <th class="p-3 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr class="border-b hover:bg-gray-50 transition">
                    <td class="p-3 border text-center font-semibold">{{ $report->id }}</td>
                    <td class="p-3 border">{{ Str::limit($report->description, 50) }}</td>
                    <td class="p-3 border">{{ $report->location ?? '-' }}</td>
                    <td class="p-3 border text-center">
                        @if($report->image)
                            <img src="{{ asset('storage/'.$report->image) }}" 
                                 class="w-20 h-20 object-cover rounded-xl border shadow">
                        @else
                            <span class="text-gray-500 italic">No Image</span>
                        @endif
                    </td>
                    <td class="p-3 border text-center">
                        <span class="px-3 py-1 rounded-full text-white bg-green-600 text-xs uppercase tracking-wide">
                            {{ $report->status }}
                        </span>
                    </td>
                    <td class="p-3 border text-center flex justify-center gap-2">
                        <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="resolved">
                            <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                Done
                            </button>
                        </form>
                        <a href="{{ route('admin.reports.show', $report) }}" 
                           class="px-3 py-1 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="p-4 text-center text-gray-500">No reports found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
