@extends('layouts.app')

@section('content')
<div class="flex min-h-screen bg-gray-50">

    <!-- Main content -->
    <main class="flex-1 p-8">

        <!-- Back button -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}"
                class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 shadow-sm transition">
                Back
            </a>
        </div>

        <!-- Reports Sections -->
        <div class="space-y-12">

            @foreach ([
                'pendingReports' => ['title' => 'Pending Reports ⏳', 'color' => 'yellow'],
                'inProgressReports' => ['title' => 'In Progress Reports 🔄', 'color' => 'blue'],
                'resolvedReports' => ['title' => 'Resolved Reports ✅', 'color' => 'green']
            ] as $reportsVar => $info)
            <section>
                <h2 class="text-2xl font-bold mb-4 text-{{ $info['color'] }}-700">{{ $info['title'] }}</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full border rounded-lg overflow-hidden shadow-sm">
                        <thead class="bg-{{ $info['color'] }}-100 text-{{ $info['color'] }}-800 font-semibold">
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
                            @forelse($$reportsVar as $report)
                            <tr class="border-b hover:bg-{{ $info['color'] }}-50 transition" data-report-id="{{ $report->id }}">
                                <td class="px-4 py-3">{{ $report->id }}</td>
                                <td class="px-4 py-3">
                                    @if($report->image)
                                    <img src="{{ asset('storage/' . $report->image) }}" class="w-16 h-16 object-cover rounded" alt="Report Image">
                                    @else
                                    <span class="text-gray-400">No Image</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">{{ $report->location }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 rounded-full text-sm font-semibold
                                        @if($report->status === 'pending') bg-yellow-200 text-yellow-800
                                        @elseif($report->status === 'in-progress') bg-blue-200 text-blue-800
                                        @else bg-green-200 text-green-800 @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3">{{ $report->created_at->format('M d, Y H:i') }}</td>
                                <td class="px-4 py-3 flex gap-2">
                                    <a href="{{ route('admin.reports.show', $report) }}"
                                        class="font-semibold hover:underline text-{{ $info['color'] }}-800">View</a>

                                    @if($report->status !== 'resolved')
                                    <!-- Minimal check button -->
                                    <button type="button"
                                        class="advance-btn transform transition-transform duration-200 hover:scale-125"
                                        data-report-id="{{ $report->id }}">✅
                                    </button>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-6 text-gray-500">
                                    No {{ strtolower($info['title']) }} found.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
            @endforeach

        </div>
    </main>
</div>

<!-- AJAX Advance Button Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.querySelectorAll('.advance-btn').forEach(button => {
        button.addEventListener('click', async () => {
            const reportId = button.dataset.reportId;

            try {
                const res = await fetch(`/admin/reports/${reportId}/advance`, {
                    method: 'PATCH',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token,
                        'Accept': 'application/json'
                    }
                });
                const data = await res.json();

                if (res.ok) {
                    const row = button.closest('tr');
                    const statusCell = row.querySelector('td:nth-child(4) span');
                    statusCell.textContent = data.new_status;

                    // Update badge color
                    statusCell.className = 'px-2 py-1 rounded-full text-sm font-semibold';
                    if (data.new_status === 'pending') statusCell.classList.add('bg-yellow-200', 'text-yellow-800');
                    else if (data.new_status === 'in-progress') statusCell.classList.add('bg-blue-200', 'text-blue-800');
                    else if (data.new_status === 'resolved') statusCell.classList.add('bg-green-200', 'text-green-800');

                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to update status.');
                }
            } catch (err) {
                console.error(err);
                alert('Something went wrong!');
            }
        });
    });
});
</script>
@endsection
