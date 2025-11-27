@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8 px-4 lg:px-0 space-y-6">

    <!-- Header -->
    <h1 class="text-2xl font-bold text-gray-900 mb-4 flex items-center gap-3">
        Profile

        <!-- Small User Avatar -->
        @if ($user->avatar && Storage::disk('public')->exists($user->avatar))
            <img src="{{ asset('storage/' . $user->avatar) }}"
                 alt="User Avatar"
                 class="w-8 h-8 rounded-full border border-gray-300 object-cover">
        @else
            <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-white text-xs">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>
        @endif
    </h1>

    <!-- Profile Form -->
    <div class="bg-white shadow rounded-md p-4">
        <form action="{{ route('user.profile.update') }}"
              method="POST"
              enctype="multipart/form-data"
              class="space-y-3 text-sm">

            @csrf
            @method('PUT')

            <!-- Name -->
            <div>
                <label class="block font-medium text-gray-800 mb-1">Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       class="w-full border rounded-md px-2 py-1 text-sm
                              focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Email -->
            <div>
                <label class="block font-medium text-gray-800 mb-1">Email</label>
                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       class="w-full border rounded-md px-2 py-1 text-sm
                              focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <!-- Avatar Upload -->
            <div>
                <label class="block font-medium text-gray-800 mb-1">Avatar</label>
                <input type="file"
                       name="avatar"
                       class="w-full text-sm"
                       accept="image/*"
                       onchange="previewUserAvatar(event)">
            </div>

            <!-- Avatar Preview -->
            <div class="mt-2">
                <div class="w-16 h-16 rounded-full overflow-hidden border shadow-sm">
                    <img id="avatarPreview"
                         src="{{ $user->avatar
                                ? asset('storage/' . $user->avatar)
                                : asset('default-avatar.png') }}"
                         class="w-full h-full object-cover">
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white
                           px-4 py-1.5 rounded-md text-sm font-medium transition">
                Update Profile
            </button>

        </form>
    </div>
</div>

<!-- Avatar Preview Script -->
<script>
    function previewUserAvatar(event) {
        const preview = document.getElementById('avatarPreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
