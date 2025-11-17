@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-50 to-green-100 px-4">

    <!-- Back Button (Top-Left) -->
    <a href="{{ url('/') }}"
       class="absolute top-4 left-4 text-green-700 text-sm font-medium hover:underline transition">
        ← Back to Welcome
    </a>

    <!-- Login Card -->
    <div class="w-full max-w-md bg-white border border-green-200 rounded-2xl shadow-xl p-8
                transition-all duration-300 hover:shadow-2xl">

        <!-- Title -->
        <h2 class="text-2xl font-bold text-green-700 text-center mb-6">
            Login to Your Account
        </h2>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg text-sm border border-green-300">
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
                <label for="email" class="block text-green-800 font-medium mb-1">
                    Email
                </label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                       class="w-full px-4 py-2 border border-green-400 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                              transition-all">
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-green-800 font-medium mb-1">
                    Password
                </label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 border border-green-400 rounded-lg
                              focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent
                              transition-all">
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember"
                       class="rounded text-green-600 focus:ring-green-500 border-green-400">
                <label for="remember" class="ml-2 text-green-800 text-sm">
                    Remember me
                </label>
            </div>

            <!-- Login Button -->
            <button type="submit"
                class="w-full bg-green-600 text-white py-2.5 rounded-lg text-lg font-semibold
                       hover:bg-green-700 active:scale-[.98] transition-all shadow-md hover:shadow-lg">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-green-700 text-sm">
            Don’t have an account?
            <a href="{{ route('register') }}" class="font-semibold hover:underline">
                Register here
            </a>
        </p>

    </div>
</div>
@endsection
