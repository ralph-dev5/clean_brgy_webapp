<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Report | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex font-sans justify-center">

    <!-- Main Content -->
    <main class="flex-1 p-10 max-w-4xl w-full">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Report Details</h1>
        </div>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded shadow">
                {{ session('error') }}
            </div>
        @endif

        <!-- Report Details -->
        <div class="bg-white p-6 rounded-2xl shadow space-y-6">

            <!-- Report ID -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Report ID</label>
                <p class="text-gray-800">{{ $report->id }}</p>
            </div>

            <!-- Location -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Location</label>
                <p class="text-gray-800">{{ $report->location }}</p>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Description</label>
                <p class="text-gray-800 whitespace-pre-wrap">{{ $report->description }}</p>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Status</label>
                <span class="inline-block px-3 py-1 rounded-full text-sm font-semibold
                              @if($report->status == 'pending') bg-yellow-100 text-yellow-800
                              @elseif($report->status == 'in-progress') bg-blue-100 text-blue-800
                              @elseif($report->status == 'resolved') bg-green-100 text-green-800
                              @else bg-gray-100 text-gray-800 @endif">
                    {{ ucfirst($report->status) }}
                </span>
            </div>

            <!-- Image Section -->
            <div>
                <label class="block text-gray-700 font-medium mb-2">Image</label>
                @if($report->image)
                    <img src="{{ asset('storage/' . $report->image) }}" alt="Report Image"
                        class="w-40 h-auto rounded shadow-lg">
                @else
                    <p class="text-gray-500 text-sm">No image attached</p>
                @endif
            </div>


            <!-- Submitted On -->
            <div>
                <label class="block text-gray-700 font-medium mb-1">Submitted On</label>
                <p class="text-gray-800">{{ $report->created_at->format('F d, Y \a\t h:i A') }}</p>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-4 border-t">
                <a href="{{ route('user.dashboard') }}"
                    class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                    Back
                </a>


            </div>

        </div>
    </main>

</body>

</html>