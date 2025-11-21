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

        @if(session('error'))
            <div class="mb-6 p-4 bg-red-100 text-red-800 rounded shadow">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white p-6 rounded shadow max-w-3xl">
            <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf



                <!-- Location Dropdown -->
                <div>
                    <label for="location" class="block text-gray-700 font-medium mb-1">
                        Location
                    </label>

                    <select name="location" id="location"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        required>
                        <option value="" disabled selected>Select</option>
                        <option value="Purok 1" {{ old('location') == 'Purok 1' ? 'selected' : '' }}>Purok 1</option>
                        <option value="Purok 2" {{ old('location') == 'Purok 2' ? 'selected' : '' }}>Purok 2</option>
                        <option value="Purok 3" {{ old('location') == 'Purok 3' ? 'selected' : '' }}>Purok 3</option>
                        <option value="Purok 4" {{ old('location') == 'Purok 4' ? 'selected' : '' }}>Purok 4</option>
                        <option value="Purok 5" {{ old('location') == 'Purok 5' ? 'selected' : '' }}>Purok 5</option>
                    </select>

                    @error('location')
                        <span class="text-red-600 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Description -->
                <div>
                    <label for="description" class="block text-gray-700 font-medium mb-1">
                        Description
                    </label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full border border-gray-300 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-500"
                        placeholder="Describe the issue or concern..." required>{{ old('description') }}</textarea>
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

                <!-- Buttons -->
                <div class="flex gap-4">
                    <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition">
                        Submit Report
                    </button>
                    <a href="{{ route('user.dashboard') }}"
                        class="px-6 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400 transition">
                        Cancel
                    </a>
                </div>

            </form>
        </div>
    </main>

</body>

</html>