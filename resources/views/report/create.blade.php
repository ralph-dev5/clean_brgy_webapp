@extends('layouts.app')

@section('content')
<div class="max-w-lg mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Submit a Report</h1>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>- {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('report.store') }}" enctype="multipart/form-data">
        @csrf

        <!-- Location Field -->
        <div class="mb-4">
            <label for="location" class="block mb-1 font-semibold">Location</label>
            <input type="text" name="location" id="location" class="w-full border px-3 py-2 rounded" placeholder="E.g., Garbage, Road Issue" required>
        </div>

        <!-- Description -->
        <div class="mb-4">
            <label for="description" class="block mb-1 font-semibold">Description</label>
            <textarea name="description" id="description" class="w-full border px-3 py-2 rounded" rows="5" placeholder="Describe the issue..." required></textarea>
        </div>

        <!-- Image -->
        <div class="mb-4">
            <label for="image" class="block mb-1 font-semibold">Image (optional)</label>
            <input type="file" name="image" id="image" class="w-full">
        </div>

        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
            Submit Report
        </button>
    </form>
</div>
@endsection
