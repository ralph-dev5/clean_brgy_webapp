@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto mt-12 p-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('admin.dashboard') }}" 
           class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
            ← Back
        </a>
        <h1 class="text-4xl font-bold text-gray-800 tracking-wide">Profile</h1>
        <div></div>
    </div>

    {{-- Profile Card --}}
    <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
        <div class="flex flex-col md:flex-row md:items-center md:gap-6">
            {{-- Avatar --}}
            <div class="flex-shrink-0 mb-6 md:mb-0">
                <img src="{{ auth()->user()->avatar ?? asset('default-avatar.png') }}" 
                     class="w-32 h-32 object-cover rounded-full border shadow" alt="Avatar">
            </div>

            {{-- Info --}}
            <div class="flex-1 space-y-3">
                <p><span class="font-semibold">Name:</span> {{ auth()->user()->name }}</p>
                <p><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                <p><span class="font-semibold">Role:</span> {{ auth()->user()->role }}</p>
                <p><span class="font-semibold">Joined:</span> {{ auth()->user()->created_at->format('M d, Y') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
