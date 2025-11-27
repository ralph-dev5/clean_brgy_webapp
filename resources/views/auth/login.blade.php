@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-green-50 px-4">

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl p-8 transition-all duration-300 hover:shadow-2xl">

        <!-- Back Button -->
        <div class="mb-6 text-left">
            <a href="{{ url('/') }}" class="text-green-600 text-sm font-medium hover:underline">
                Back
            </a>
        </div>

        <!-- Title -->
        <h2 class="text-2xl font-bold text-green-700 text-center mb-6">
            Login to Your Account
        </h2>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 font-medium mb-1">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-gray-700 font-medium mb-1">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full border border-gray-300 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 focus:border-transparent transition-all">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                       class="rounded text-green-600 focus:ring-green-400 border-gray-300">
                <label for="remember" class="ml-2 text-gray-700 text-sm">Remember me</label>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-2.5 rounded-lg text-lg font-semibold hover:bg-green-700 active:scale-[.98] transition-all shadow-md hover:shadow-lg">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600 text-sm">
            Don’t have an account? 
            <a href="{{ route('register') }}" class="text-green-600 font-medium hover:underline">Register here</a>
        </p>

    </div>
</div>
@endsection
