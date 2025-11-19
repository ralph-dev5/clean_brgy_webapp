@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-12">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            ← Back
        </a>

        <h1 class="text-4xl font-bold text-gray-800 tracking-wide">
            All Garbage Reports
        </h1>

        <div></div>
    </div>

    {{-- Card Container --}}
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">

        {{-- Status Tabs --}}
        @php
            $currentStatus = request('status', 'pending');
            $statuses = ['pending'=>'Pending', 'in-progress'=>'In Progress', 'resolved'=>'Resolved'];
        @endphp
        <div class="flex gap-4 mb-6">
            @foreach($statuses as $key => $label)
                <a href="{{ url('/admin/reports?status=' . $key) }}"
                   class="px-4 py-2 rounded-full font-semibold text-sm
                   {{ $currentStatus === $key 
                        ? ($key==='pending'?'bg-yellow-600 text-white':
                            ($key==='in-progress'?'bg-blue-600 text-white':'bg-green-600 text-white'))
                        : 'bg-gray-200 text-gray-700 hover:bg-gray-300 transition' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        {{-- Table --}}
        @if($reports->isEmpty())
            <div class="text-center py-10 text-gray-600 text-lg">
                No reports found for this category.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse rounded-lg overflow-hidden">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm uppercase">
                            <th class="p-3 border">ID</th>
                            <th class="p-3 border">Resident</th>
                            <th class="p-3 border">Description</th>
                            <th class="p-3 border">Image</th>
                            <th class="p-3 border text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-900 text-sm">
                        @foreach($reports as $report)
                        <tr class="hover:bg-gray-50 transition border-b">
                            {{-- ID --}}
                            <td class="p-3 border text-center font-semibold text-gray-700">
                                {{ $report->id }}
                            </td>

                            {{-- Resident --}}
                            <td class="p-3 border">{{ $report->user->name }}</td>

                            {{-- Description --}}
                            <td class="p-3 border">{{ Str::limit($report->description,50) }}</td>

                            {{-- Image --}}
                            <td class="p-3 border text-center">
                                @if($report->image)
                                    <img src="{{ asset('storage/'.$report->image) }}"
                                         class="w-20 h-20 object-cover rounded-lg border shadow">
                                @else
                                    <span class="text-gray-500 italic">No Image</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="p-3 border text-center flex justify-center gap-2">
                                @if($report->status === 'pending')
                                    <!-- Move from Pending → In Progress -->
                                    <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="in-progress">
                                        <button class="px-4 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                            Start
                                        </button>
                                    </form>
                                @elseif($report->status === 'in-progress')
                                    <!-- Move from In Progress → Resolved -->
                                    <form action="{{ route('admin.reports.updateStatus', $report) }}" method="POST">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="resolved">
                                        <button class="px-4 py-1.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition">
                                            Done
                                        </button>
                                    </form>
                                @endif

                                <!-- View Button -->
                                <a href="{{ route('admin.reports.show',$report) }}"
                                   class="px-4 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
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
</div>
@endsection
