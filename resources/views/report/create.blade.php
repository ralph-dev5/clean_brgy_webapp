@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-12 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('user.dashboard') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            ← Back to Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-800 tracking-wide">Submit New Report</h1>
        <div></div>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    {{-- Report Form --}}
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
        <form action="{{ route('report.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            {{-- Type --}}
            <div>
                <label class="block font-semibold text-gray-700">Type</label>
                <input type="text" name="type" value="{{ old('type') }}"
                       class="w-full border border-gray-300 rounded-lg p-3 mt-1 focus:ring focus:ring-blue-200">
                @error('type') 
                    <span class="text-red-600 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label class="block font-semibold text-gray-700">Description</label>
                <textarea name="description" rows="4"
                          class="w-full border border-gray-300 rounded-lg p-3 mt-1 focus:ring focus:ring-blue-200">{{ old('description') }}</textarea>
                @error('description') 
                    <span class="text-red-600 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Image --}}
            <div>
                <label class="block font-semibold text-gray-700">Attach Image (optional)</label>
                <input type="file" name="image" class="mt-1">
                @error('image') 
                    <span class="text-red-600 text-sm">{{ $message }}</span> 
                @enderror
            </div>

            {{-- Submit --}}
            <div class="flex gap-4">
                <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Submit Report
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
