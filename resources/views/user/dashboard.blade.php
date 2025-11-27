<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Description</th>
                <th class="px-4 py-2 text-left">Location</th>
                <th class="px-4 py-2 text-left">Image</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($reports as $report)
                <tr class="hover:bg-green-50 transition">
                    <td class="px-4 py-2">{{ $report->id }}</td>
                    <td class="px-4 py-2">{{ Str::limit($report->description, 50) }}</td>
                    <td class="px-4 py-2">{{ $report->location }}</td>
                    <td class="px-4 py-2">
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image"
                                 class="w-20 h-20 object-cover rounded shadow">
                        @else
                            <span class="text-gray-500 text-sm">No Image</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        @php
                            $statusClasses = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'in-progress' => 'bg-blue-100 text-blue-800',
                                'resolved' => 'bg-green-100 text-green-800'
                            ];
                        @endphp
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                     {{ $statusClasses[$report->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <form action="{{ route('user.report.destroy', $report) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 transition">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-2 text-gray-600 text-center">
                        No reports submitted yet.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
