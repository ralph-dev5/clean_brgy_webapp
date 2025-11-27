@php
    use Illuminate\Support\Facades\Route;
@endphp

@extends('layouts.app')

@section('content')
<main class="flex-1 p-10 bg-gray-50 min-h-screen" x-data="{ showEdit: false, showPassword: false }">

    <div class="max-w-3xl mx-auto bg-white rounded-3xl shadow-xl p-10">

        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('user.dashboard') }}"
               class="inline-flex items-center gap-2 text-green-700 font-medium hover:underline transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>

        <!-- Page Heading -->
        <h1 class="text-3xl font-bold text-green-700 mb-8">Settings</h1>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 rounded shadow">
                {{ session('success') }}
            </div>
        @endif

        <!-- EDIT PROFILE -->
        <button @click="showEdit = !showEdit"
            class="w-full flex justify-between items-center bg-green-50 px-5 py-3 rounded-xl border border-green-200 hover:bg-green-100 transition mb-2">
            <span class="text-lg font-semibold text-green-700">Edit Profile</span>

            <svg x-show="!showEdit" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>

            <svg x-show="showEdit" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
        </button>

        <div x-show="showEdit" class="mt-4 mb-10" x-collapse>
            <form method="POST" enctype="multipart/form-data" action="{{ route('user.profile.update') }}"
                  class="space-y-6">
                @csrf
                @method('PUT')

                <!-- AVATAR SECTION -->
                <div class="flex flex-col items-center gap-4">
                    <label class="text-gray-700 font-medium">Avatar</label>
                    <div class="relative group">
                        <img id="avatarPreview"
                             src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('default-avatar.png') }}"
                             class="w-32 h-32 rounded-full object-cover border-4 border-green-500 shadow-md transition group-hover:opacity-90">

                        <label for="avatarInput"
                               class="absolute bottom-1 right-1 bg-green-600 text-white p-2 rounded-full cursor-pointer shadow-lg hover:bg-green-700 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M15.232 5.232l3.536 3.536M9 13l6.464-6.464m0 0L17 7l-2.464-2.464m-1.414 1.414L7 13l-.707 4.243L10.535 16z" />
                            </svg>
                        </label>
                    </div>

                    <input type="file" name="avatar" id="avatarInput" class="hidden" accept="image/*"
                           onchange="previewAvatar(event)">
                </div>

                <!-- NAME -->
                <div>
                    <label class="block font-medium text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ Auth::user()->name }}"
                           class="w-full border-gray-300 rounded-lg p-2">
                </div>

                <!-- EMAIL -->
                <div>
                    <label class="block font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ Auth::user()->email }}"
                           class="w-full border-gray-300 rounded-lg p-2">
                </div>

                <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                    Save Changes
                </button>
            </form>
        </div>

        <!-- CHANGE PASSWORD -->
        <button @click="showPassword = !showPassword"
            class="w-full flex justify-between items-center bg-green-50 px-5 py-3 rounded-xl border border-green-200 hover:bg-green-100 transition mb-2">
            <span class="text-lg font-semibold text-green-700">Change Password</span>

            <svg x-show="!showPassword" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>

            <svg x-show="showPassword" class="h-6 w-6 text-green-700" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
            </svg>
        </button>

        <div x-show="showPassword" class="mt-4" x-collapse>
            <form method="POST" action="{{ route('user.profile.password') }}" class="space-y-6">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium text-gray-700">Current Password</label>
                    <input type="password" name="current_password" class="w-full border-gray-300 rounded-lg p-2">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">New Password</label>
                    <input type="password" name="password" class="w-full border-gray-300 rounded-lg p-2">
                </div>

                <div>
                    <label class="block font-medium text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-lg p-2">
                </div>

                <button class="bg-green-600 text-white px-5 py-2 rounded-lg hover:bg-green-700">
                    Update Password
                </button>
            </form>
        </div>

    </div>
</main>

<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = () => {
            document.getElementById('avatarPreview').src = reader.result;
        }
        reader.readAsDataURL(file);
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
@endsection
