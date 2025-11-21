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
            <div class="flex-1 space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-semibold text-gray-800">{{ auth()->user()->name }}</h2>
                    {{-- Edit Profile Button --}}
                    <a href="{{ route('admin.profile.edit') }}" 
                       class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Edit Profile
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-gray-600"><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                        <p class="text-gray-600"><span class="font-semibold">Role:</span> {{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-600"><span class="font-semibold">Joined:</span> {{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
