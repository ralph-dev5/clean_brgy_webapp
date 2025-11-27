@props(['reports', 'title', 'color', 'showCheck' => true])

<section>
    <h2 class="text-2xl font-bold mb-4 text-{{ $color }}-700">{{ $title }}</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full border rounded-lg overflow-hidden shadow-sm">
            <thead class="bg-{{ $color }}-100 text-{{ $color }}-800 font-semibold">
                <tr>
                    <th class="px-4 py-3 text-left">ID</th>
                    <th class="px-4 py-3 text-left">Image</th>
                    <th class="px-4 py-3 text-left">Location</th>
                    <th class="px-4 py-3 text-left">Status</th>
                    <th class="px-4 py-3 text-left">Created At</th>
                    <th class="px-4 py-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                <tr class="border-b hover:bg-{{ $color }}-50 transition" data-report-id="{{ $report->id }}">
                    <td class="px-4 py-3">{{ $report->id }}</td>
                    <td class="px-4 py-3">
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}"
                                 class="w-16 h-16 object-cover rounded" alt="Report Image">
                        @else
                            <span class="text-gray-400">No Image</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $report->location }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-sm font-semibold bg-{{ $color }}-200 text-{{ $color }}-800">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">{{ $report->created_at->format('M d, Y H:i') }}</td>
                    <td class="px-4 py-3 flex gap-2">
                        <a href="{{ route('admin.reports.show', $report) }}"
                           class="text-{{ $color }}-800 font-semibold hover:underline">View</a>

                        @if($showCheck)
                        <button type="button"
                                class="px-3 py-1 rounded-full bg-green-600 text-white hover:bg-green-700 transition advance-btn"
                                data-report-id="{{ $report->id }}">
                            ✅
                        </button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-6 text-gray-500">No reports found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
