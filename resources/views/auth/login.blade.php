@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50">
    <div class="w-full max-w-md bg-white rounded-lg shadow-lg p-8">
        
        <!-- Back to Welcome Page Button -->
        <div class="mb-6 text-right">
            <a href="{{ url('/') }}" class="text-green-600 text-sm bg-green-100 px-3 py-1 rounded hover:bg-green-200 transition">
                &larr; Back to Welcome
            </a>
        </div>

        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <div class="mb-6">
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full border px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-green-400">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700 transition">
                Login
            </button>
        </form>

        <p class="mt-4 text-center text-gray-600">
            Don't have an account?
            <a href="{{ route('register') }}" class="text-green-600 hover:underline">Register here</a>
        </p>
    </div>
</div>
@endsection
