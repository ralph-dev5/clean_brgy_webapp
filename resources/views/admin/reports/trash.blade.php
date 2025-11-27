@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 shadow-sm transition">
            Back
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-6">Trashed Reports 🗑️</h1>

    @if($reports->isEmpty())
        <p class="text-gray-600 text-lg">No reports in trash.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full border-collapse text-sm">
                <thead class="bg-red-100 text-red-800 font-semibold">
                    <tr>
                        <th class="py-2 px-3 border">ID</th>
                        <th class="py-2 px-3 border">Description</th>
                        <th class="py-2 px-3 border">User</th>
                        <th class="py-2 px-3 border">Deleted At</th>
                        <th class="py-2 px-3 border">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="border-b hover:bg-red-50 transition">
                            <td class="py-2 px-3 border font-medium">{{ $report->id }}</td>
                            <td class="py-2 px-3 border">{{ $report->description ?? 'N/A' }}</td>
                            <td class="py-2 px-3 border">{{ $report->user->name ?? 'N/A' }}</td>
                            <td class="py-2 px-3 border">{{ $report->deleted_at->format('Y-m-d h:i A') }}</td>
                            <td class="py-2 px-3 border flex gap-2">

                                {{-- Restore Button --}}
                                <form action="{{ route('admin.reports.restore', $report->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 shadow-sm transition text-xs">
                                        Restore
                                    </button>
                                </form>

                                {{-- Permanent Delete Button --}}
                                <form action="{{ route('admin.reports.forceDelete', $report->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 shadow-sm transition text-xs">
                                        Delete Permanently
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Optional Pagination -->
            @if(method_exists($reports, 'links'))
                <div class="mt-4">
                    {{ $reports->withQueryString()->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
