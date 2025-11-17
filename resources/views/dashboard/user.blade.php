@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto mt-8 px-4">

    <!-- Top Navigation Bar with Logout -->
    <div class="flex justify-between items-center bg-white shadow-md rounded-lg px-6 py-4 mb-8">
        <h2 class="text-2xl font-bold text-green-700">User Dashboard</h2>

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button 
                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition">
                Logout
            </button>
        </form>
    </div>

    <!-- Header + Submit Report Button -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-gray-800">Your Reports</h2>
        <a href="{{ route('report.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition shadow">
            + Submit New Report
        </a>
    </div>

    <!-- Empty State -->
    @if($reports->isEmpty())
        <div class="bg-green-50 border border-green-200 text-green-800 p-6 rounded-xl shadow-sm text-center">
            <p class="font-medium text-lg">You haven’t submitted any reports yet.</p>
        </div>
    @else
        <!-- Reports Table -->
        <div class="overflow-x-auto bg-white shadow-lg rounded-2xl">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-green-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($reports as $report)
                        <tr class="hover:bg-green-50 transition">
                            <td class="px-6 py-3">{{ $report->id }}</td>
                            <td class="px-6 py-3">{{ Str::limit($report->description, 50) }}</td>
                            <td class="px-6 py-3">
                                @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" 
                                         class="w-20 h-16 object-cover rounded-lg shadow-sm">
                                @else
                                    <span class="text-gray-400">No Image</span>
                                @endif
                            </td>
                            <td class="px-6 py-3">
                                @php
                                    $status = ucfirst($report->status ?? 'Pending');
                                    $colors = [
                                        'Pending' => 'bg-yellow-100 text-yellow-800',
                                        'Resolved' => 'bg-green-100 text-green-800',
                                        'Rejected' => 'bg-red-100 text-red-800'
                                    ];
                                @endphp
                                <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $colors[$status] ?? 'bg-gray-100 text-gray-700' }}">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
