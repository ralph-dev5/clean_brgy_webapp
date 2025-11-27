@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-6 px-4 lg:px-0 space-y-6 text-sm">

    <!-- Back Button -->
    <div class="flex items-center justify-between mb-2">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-flex items-center gap-2 px-3 py-1.5 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition text-xs font-medium shadow-sm">
            Back
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- Profile Section -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-base font-semibold mb-3 text-gray-900">Profile Information</h2>

            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                @csrf
                @method('PUT')

                <!-- Avatar + Upload -->
                <div class="flex items-center gap-3">
                    <div class="w-16 h-16 rounded-full overflow-hidden border shadow-sm bg-gray-100">
                        <img id="avatarPreview"
                             src="{{ $admin->avatar ? asset('storage/' . $admin->avatar) . '?' . time() : asset('default-avatar.png') }}"
                             class="w-full h-full object-cover">
                    </div>

                    <div class="flex flex-col">
                        <label class="font-medium text-gray-700 text-xs">Change Avatar</label>

                        <!-- Upload Input -->
                        <input type="file" name="avatar" class="block mt-1 w-full text-xs" accept="image/*"
                               onchange="previewAvatar(event)">

                        <!-- Update Button -->
                        <button type="submit"
                            class="mt-2 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-xs font-medium transition w-max">
                            Update Avatar
                        </button>
                    </div>
                </div>

                <!-- Name (readonly) -->
                <div>
                    <label class="block font-medium text-gray-700 text-xs mb-1">Name</label>
                    <input type="text" name="name" value="{{ $admin->name }}"
                           class="w-full border rounded-md px-3 py-2 text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

                <!-- Email (readonly) -->
                <div>
                    <label class="block font-medium text-gray-700 text-xs mb-1">Email</label>
                    <input type="email" name="email" value="{{ $admin->email }}"
                           class="w-full border rounded-md px-3 py-2 text-xs bg-gray-100 cursor-not-allowed" readonly>
                </div>

            </form>
        </div>

        <!-- Password Section -->
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-base font-semibold mb-3 text-gray-900">Change Password</h2>

            <form action="{{ route('admin.profile.password') }}" method="POST" class="space-y-3">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-medium text-gray-700 text-xs mb-1">Current Password</label>
                    <input type="password" name="current_password"
                        class="w-full border rounded-md px-3 py-2 text-xs focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 text-xs mb-1">New Password</label>
                    <input type="password" name="password"
                        class="w-full border rounded-md px-3 py-2 text-xs focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <div>
                    <label class="block font-medium text-gray-700 text-xs mb-1">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full border rounded-md px-3 py-2 text-xs focus:ring-yellow-500 focus:border-yellow-500">
                </div>

                <button type="submit"
                    class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-1.5 rounded-md text-xs font-medium transition">
                    Change Password
                </button>
            </form>
        </div>

    </div>

    <!-- Preferences Section -->
    <div class="bg-white shadow rounded-lg p-4">
        <h2 class="text-base font-semibold mb-3 text-gray-900">Site Preferences</h2>

        <form action="{{ route('admin.settings.updatePreferences') }}" method="POST" class="space-y-3">
            @csrf
            @method('PUT')

            <!-- Site Name -->
            <div>
                <label class="block font-medium text-gray-700 text-xs mb-1">Site Name</label>
                <input type="text" name="site_name" value="{{ old('site_name', config('app.name')) }}"
                    class="w-full border rounded-md px-3 py-2 text-xs focus:ring-green-500 focus:border-green-500">
            </div>

            <!-- Admin Email (readonly) -->
            <div>
                <label class="block font-medium text-gray-700 text-xs mb-1">Admin Email</label>
                <input type="email" value="{{ old('admin_email', $admin->email) }}"
                    class="w-full border rounded-md px-3 py-2 text-xs bg-gray-100 cursor-not-allowed" readonly>
            </div>

            <!-- Notifications -->
            <div class="flex items-center gap-2">
                <input type="checkbox" name="notifications" id="notifications" class="h-3.5 w-3.5"
                       {{ old('notifications', true) ? 'checked' : '' }}>
                <label for="notifications" class="font-medium text-gray-700 text-xs">Enable Notifications</label>
            </div>

            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-md text-xs font-medium transition">
                Save Preferences
            </button>
        </form>
    </div>

</div>

<!-- Avatar Preview Script -->
<script>
    function previewAvatar(event) {
        const preview = document.getElementById('avatarPreview');
        preview.src = URL.createObjectURL(event.target.files[0]);
    }
</script>
@endsection
