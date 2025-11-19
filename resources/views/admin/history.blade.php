@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-14 px-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-10">
        <a href="{{ route('admin.dashboard') }}"
           class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl shadow hover:bg-gray-200 transition">
            ← Back
        </a>

        <h1 class="text-4xl font-extrabold text-gray-800 drop-shadow-sm">
            Report History
        </h1>

        <div></div>
    </div>

    {{-- Card --}}
    <div class="bg-white rounded-3xl shadow-2xl border border-gray-100 p-10">

        @if($reports->isEmpty())
            <div class="text-center py-16 text-gray-500 text-lg">
                No resolved reports found.
            </div>
        @else
        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 rounded-2xl overflow-hidden">

                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-sm uppercase tracking-wide">
                        <th class="p-4 border-b">ID</th>
                        <th class="p-4 border-b">Description</th>
                        <th class="p-4 border-b">Location</th>
                        <th class="p-4 border-b">Image</th>
                        <th class="p-4 border-b">Status</th>
                        <th class="p-4 border-b text-center">Actions</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 text-sm">

                    @foreach($reports as $report)
                    <tr class="hover:bg-gray-50 transition border-b">

                        {{-- ID --}}
                        <td class="p-4 text-center font-bold text-gray-700">
                            {{ $report->id }}
                        </td>

                        {{-- Description --}}
                        <td class="p-4">
                            {{ Str::limit($report->description, 50) }}
                        </td>

                        {{-- Location --}}
                        <td class="p-4">
                            {{ $report->location ?? '-' }}
                        </td>

                        {{-- Image --}}
                        <td class="p-4 text-center">
                            @if($report->image)
                                <img src="{{ asset('storage/' . $report->image) }}"
                                     class="w-20 h-20 object-cover rounded-xl border shadow-md">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="p-4 text-center">
                            <span class="px-4 py-1.5 rounded-full bg-green-600 text-white text-xs font-semibold shadow">
                                {{ ucfirst($report->status) }}
                            </span>
                        </td>

                        {{-- Actions --}}
                        <td class="p-4 text-center">
                            <div class="flex items-center justify-center gap-3">

                                {{-- Done --}}
                                <form action="{{ route('admin.reports.updateStatus', $report) }}"
                                      method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="resolved">

                                    <button
                                        class="px-4 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                                        Done
                                    </button>
                                </form>

                                {{-- View --}}
                                <a href="{{ route('admin.reports.show', $report) }}"
                                   class="px-4 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                                    View
                                </a>

                            </div>
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
