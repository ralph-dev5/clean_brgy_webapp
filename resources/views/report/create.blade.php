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

<body class="bg-gray-100 min-h-screen flex justify-center font-sans">

    <!-- Main Content -->
    <main class="flex-1 p-10 max-w-3xl w-full">

        <!-- Page Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold">Submit New Report</h1>
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

        <!-- Report Form -->
        <div class="bg-white p-6 rounded-2xl shadow">
            <form action="{{ route('user.report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                <!-- Location Dropdown -->
                <div>
                    <label for="location" class="block text-gray-700 font-medium mb-1">Location</label>
                    <select name="location" id="location" required
                            class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                        <option value="" disabled selected>Select</option>
                        @for ($i = 1; $i <= 8; $i++)
                            <option value="Purok {{ $i }}" {{ old('location') == "Purok $i" ? 'selected' : '' }}>Purok {{ $i }}</option>
                        @endfor
                    </select>
                    @error('location')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-1">Description</label>
                    <textarea name="description" id="description" rows="4"
                              placeholder="Describe the issue or concern..." required
                              class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">{{ old('description') }}</textarea>
                    @error('description')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-gray-700 font-medium mb-1">Attach Image (optional)</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500">
                    <p class="text-sm text-gray-500 mt-1">Maximum file size: 2MB. Supported formats: JPG, PNG, GIF</p>
                    @error('image')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Form Buttons -->
                <div class="flex gap-4">
                    <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Submit Report
                    </button>
                    <a href="{{ route('user.dashboard') }}" class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </main>

</body>
</html>
