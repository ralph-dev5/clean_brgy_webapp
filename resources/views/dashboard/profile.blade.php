@extends('layouts.app')

@section('content')
<div class="flex justify-center">

    <!-- MAIN CONTENT -->
    <div class="w-full max-w-4xl mt-12 px-6">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('admin.dashboard') }}" 
               class="inline-flex items-center px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back to Dashboard
            </a>
        </div>

        <h2 class="text-3xl font-bold text-green-700 mb-8 text-center md:text-left">Admin Profile</h2>

        <div class="bg-white shadow-2xl rounded-3xl p-8 flex flex-col md:flex-row items-center md:items-start gap-8 transition-transform transform hover:scale-101">

            <!-- Avatar Section -->
            <div class="flex flex-col items-center md:items-start text-center md:text-left">
                <div class="w-36 h-36 rounded-full overflow-hidden mb-4 shadow-xl border-4 border-green-100">
                    <img src="{{ asset('storage/profile/' . ($user->avatar ?? 'default.png')) }}" 
                         alt="Avatar" class="w-full h-full object-cover">
                </div>
                <h3 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h3>
                <p class="text-gray-500 mt-1">{{ $user->email }}</p>
            </div>

            <!-- Profile Details -->
            <div class="flex-1 flex flex-col justify-between">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                    <div class="bg-green-50 rounded-xl p-5 shadow-md hover:shadow-lg transition">
                        <span class="font-semibold text-gray-700">Role:</span>
                        <span class="text-gray-800 ml-1">{{ ucfirst($user->role) }}</span>
                    </div>
                    <div class="bg-green-50 rounded-xl p-5 shadow-md hover:shadow-lg transition">
                        <span class="font-semibold text-gray-700">Registered:</span>
                        <span class="text-gray-800 ml-1">{{ $user->created_at->format('M d, Y') }}</span>
                    </div>
                </div>

                <a href="#"
                   class="inline-block px-6 py-3 bg-green-700 text-white rounded-lg hover:bg-green-800 transition transform hover:scale-105 shadow-md hover:shadow-lg text-center font-semibold">
                    Edit Profile
                </a>
            </div>

        </div>
    </div>

</div>
@endsection
