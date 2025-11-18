@extends('layouts.app')

@section('content')
<div class="flex">

    <!-- MAIN CONTENT -->
    <div class="ml-64 w-full max-w-4xl mx-auto mt-10 px-6">

        <h2 class="text-3xl font-bold text-green-700 mb-8">Profile</h2>

        <div class="bg-white shadow-xl rounded-2xl p-8 flex flex-col md:flex-row items-center md:items-start gap-8">

            <!-- Avatar Section -->
            <div class="flex flex-col items-center md:items-start">
                <div class="w-32 h-32 rounded-full overflow-hidden mb-4 shadow-lg">
                    <img src="{{ asset('storage/profile/' . ($user->avatar ?? 'default.png')) }}" 
                         alt="Avatar" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500 mt-1">{{ $user->email }}</p>
            </div>

            <!-- Profile Details -->
            <div class="flex-1 flex flex-col justify-between">
                <div class="grid grid-cols-1 gap-4 mb-6">
                    <div class="bg-green-50 rounded-lg p-4 shadow-sm">
                        <span class="font-semibold text-gray-700">Role:</span>
                        <span class="text-gray-800">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4 shadow-sm">
                        <span class="font-semibold text-gray-700">Registered:</span>
                        <span class="text-gray-800">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <a href="#"
                   class="self-start px-6 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition transform hover:scale-105">
                    Edit Profile
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
