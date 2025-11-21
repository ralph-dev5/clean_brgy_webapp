<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report | Admin Panel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen font-sans p-10">

    <!-- Back link -->
    <a href="{{ route('admin.reports.index') }}" 
       class="text-blue-600 hover:underline mb-4 inline-block">
        ← Back to Reports
    </a>

    <!-- Report Details -->
    <div class="bg-white rounded shadow p-6">
        <h1 class="text-2xl font-bold mb-4">Report Details</h1>

        <p><strong>ID:</strong> {{ $report->id }}</p>
        <p><strong>User:</strong> {{ $report->user->name ?? 'N/A' }}</p>
        <p><strong>Type:</strong> {{ $report->type }}</p>
        <p><strong>Location:</strong> {{ $report->location }}</p>
        <p><strong>Description:</strong> {{ $report->description }}</p>
        <p><strong>Status:</strong> 
            <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                @elseif($report->status == 'resolved') bg-green-100 text-green-800
                @else bg-gray-100 text-gray-800 @endif">
                {{ ucfirst($report->status) }}
            </span>
        </p>

        <!-- Image -->
        @if($report->image)
            <div class="mt-4">
                <strong>Image:</strong>
                <img src="{{ asset('storage/' . $report->image) }}" 
                     alt="Report Image" class="w-64 h-64 object-cover rounded shadow mt-2">
            </div>
        @endif

        <!-- Actions -->
        <div class="mt-6 flex gap-2">
            <a href="{{ route('admin.reports.edit', $report) }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">
                Edit
            </a>

            <form action="{{ route('admin.reports.destroy', $report) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition">
                    Delete
                </button>
            </form>
        </div>
    </div>

</body>
</html>
