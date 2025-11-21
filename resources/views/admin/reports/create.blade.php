@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit New Report | Clean Barangay App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
        <div class="p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">User Panel</h2>
            <nav class="flex flex-col gap-2">
                <a href="{{ route('user.dashboard') }}" class="text-gray-700 hover:bg-green-100 px-4 py-2 rounded transition
                   {{ request()->routeIs('user.dashboard') ? 'font-semibold bg-green-100' : '' }}">
                    My Reports
                </a>
                <a href="{{ route('report.create') }}" class="text-gray-700 hover:bg-green-100 px-4 py-2 rounded transition
                   {{ request()->routeIs('report.create') ? 'font-semibold bg-green-100' : '' }}">
                    Submit New Report
                </a>
                <form method="POST" action="{{ route('logout') }}" class="mt-4">
                    @csrf
                    <button type="submit"
                        class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">
                        Logout
                    </button>
                </form>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-10">
        <h1 class="text-3xl font-bold mb-6">Submit New Report</h1>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow max-w-3xl">
            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf

                <!-- Location -->
                <div>
                    <label for="location" class="block text-gray-700 font-medium mb-1">Location</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        placeholder="Enter location"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('location')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Type -->
                <div>
                    <label for="type" class="block text-gray-700 font-medium mb-1">Type</label>
                    <input type="text" name="type" id="type" value="{{ old('type') }}"
                        placeholder="Enter report type"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('type')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Optional description">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-1">Attach Image (optional)</label>
                    <input type="file" name="image" id="image"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    @error('image')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Submit Report
                    </button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
