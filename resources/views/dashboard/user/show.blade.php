@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">
    <h1 class="text-3xl font-bold mb-6">User Profile</h1>

    <div class="bg-white p-6 rounded-lg shadow-md w-full md:w-1/2">
        <p class="mb-2"><strong>Name:</strong> {{ $user->name }}</p>
        <p class="mb-2"><strong>Email:</strong> {{ $user->email }}</p>
        <p class="mb-2"><strong>Role:</strong> {{ ucfirst($user->role) }}</p>
        <p class="mb-2"><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>

        <div class="mt-4">
            <a href="{{ route('user.dashboard') }}" 
               class="px-4 py-2 bg-gray-600 text-white rounded hover:bg-gray-700">
               Back to Dashboard
            </a>
        </div>
    </div>
</div>
@endsection
