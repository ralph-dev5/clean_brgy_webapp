@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}"
                class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 transition">
                ← Back to Dashboard
            </a>
        </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Trashed Reports</h1>

    @if($reports->isEmpty())
        <p class="text-gray-600">No reports in trash.</p>
    @else
        <div class="bg-white shadow-md rounded-lg p-6">
            <table class="min-w-full border">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="py-2 px-4 border">ID</th>
                        <th class="py-2 px-4 border">Title</th>
                        <th class="py-2 px-4 border">User</th>
                        <th class="py-2 px-4 border">Deleted At</th>
                        <th class="py-2 px-4 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr>
                            <td class="py-2 px-4 border">{{ $report->id }}</td>
                            <td class="py-2 px-4 border">{{ $report->title }}</td>
                            <td class="py-2 px-4 border">{{ $report->user->name }}</td>
                            <td class="py-2 px-4 border">{{ $report->deleted_at->format('Y-m-d H:i A') }}</td>
                            <td class="py-2 px-4 border flex gap-2">

                                {{-- Restore --}}
                                <form action="{{ route('admin.reports.restore', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700">
                                        Restore
                                    </button>
                                </form>

                                {{-- Permanent Delete --}}
                                <form action="{{ route('admin.reports.forceDelete', $report->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                        Delete Forever
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>
@endsection
