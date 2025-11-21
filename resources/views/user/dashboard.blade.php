<div class="bg-white rounded shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-2 text-left">ID</th>
                <th class="px-4 py-2 text-left">Description</th>
                <th class="px-4 py-2 text-left">Location</th> <!-- added -->
                <th class="px-4 py-2 text-left">Image</th>
                <th class="px-4 py-2 text-left">Status</th>
                <th class="px-4 py-2 text-left">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ Str::limit($report->description, 50) }}</td>
                    <td>{{ $report->location }}</td> <!-- added -->
                    <td>
                        @if($report->image)
                            <img src="{{ asset('storage/' . $report->image) }}" class="w-20 h-20 object-cover rounded">
                        @else
                            No Image
                        @endif
                    </td>
                    <td>{{ ucfirst($report->status) }}</td>
                    <td>
                        <form action="{{ route('report.destroy', $report) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-600 text-white px-3 py-1 rounded">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6">No reports submitted yet.</td>
                </tr>
            @endforelse
        </tbody>

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
                        <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                                  @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                                  @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                                  @elseif($report->status == 'resolved') bg-green-100 text-green-800
                                  @else bg-gray-100 text-gray-800 @endif">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 flex gap-2">
                        <form action="{{ route('report.destroy', $report) }}" method="POST">
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