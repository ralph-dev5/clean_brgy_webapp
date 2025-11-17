@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto p-6 bg-white shadow rounded">
    <h2 class="text-xl font-bold mb-4">Submit a Report</h2>

    @if($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Type -->
        <label for="type" class="block font-semibold">Type</label>
        <select name="type" id="type" class="w-full border px-3 py-2 rounded mb-4" required>
            <option value="">-- Select type --</option>
            <option value="Garbage" {{ old('type') == 'Garbage' ? 'selected' : '' }}>Garbage</option>
            <option value="Road Issue" {{ old('type') == 'Road Issue' ? 'selected' : '' }}>Road Issue</option>
        </select>

        <!-- Location -->
        <label for="location" class="block font-semibold">Location</label>
        <input type="text" name="location" id="location" value="{{ old('location') }}"
               placeholder="E.g., Street, Barangay" required
               class="w-full border px-3 py-2 rounded mb-4">

        <!-- Description -->
        <label for="description" class="block font-semibold">Description</label>
        <textarea name="description" id="description" rows="4" placeholder="Describe the issue..." required
                  class="w-full border px-3 py-2 rounded mb-4">{{ old('description') }}</textarea>

        <!-- Image -->
        <label for="image" class="block font-semibold">Image (optional)</label>
        <input type="file" name="image" id="image" accept="image/*" class="mb-4">

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
            Submit Report
        </button>
    </form>
</div>
@endsection
