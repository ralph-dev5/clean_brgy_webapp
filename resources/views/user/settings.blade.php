<main class="flex-1 p-10 bg-gray-50 min-h-screen">
    <div class="max-w-4xl mx-auto bg-white rounded-3xl shadow-2xl p-12">

        <!-- Header -->
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-4xl font-extrabold text-green-700">Account Settings</h1>

            <a href="{{ route('user.dashboard') }}"
                class="text-green-700 font-medium hover:underline flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>


        <!-- Flash Messages -->
        @if(session('success'))
            <div class="mb-6 p-5 bg-green-100 text-green-800 rounded-xl shadow-inner border border-green-200">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('user.settings.update') }}" class="space-y-8"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Avatar Preview -->
            <div class="flex justify-center mb-6">
                @php
                    $userAvatar = Auth::user()->avatar;
                    $avatarExists = $userAvatar && Storage::disk('public')->exists($userAvatar);
                @endphp

                <div
                    class="relative w-28 h-28 rounded-full bg-green-600 border-4 border-white shadow-lg overflow-hidden flex items-center justify-center">
                    <img id="avatarPreview"
                        src="{{ $avatarExists ? asset('storage/' . $userAvatar) . '?' . time() : '' }}" alt="Avatar"
                        class="w-full h-full object-cover" />
                    @if(!$avatarExists)
                        <span id="avatarInitials" class="text-white text-3xl font-bold">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Upload Avatar -->
            <div class="flex flex-col">
                <label for="avatar" class="text-gray-700 font-medium mb-2">Profile Picture</label>
                <input type="file" name="avatar" id="avatar" accept="image/*" onchange="previewAvatar(event)"
                    class="w-full px-5 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all shadow-sm text-gray-700 font-medium">
            </div>

            <!-- Full Name -->
            <div class="flex flex-col">
                <label for="name" class="text-gray-700 font-medium mb-2">Full Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', Auth::user()->name) }}"
                    class="w-full px-5 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all shadow-sm text-gray-700 font-medium">
            </div>

            <!-- Email Address -->
            <div class="flex flex-col">
                <label for="email" class="text-gray-700 font-medium mb-2">Email Address</label>
                <input type="email" name="email" id="email" value="{{ old('email', Auth::user()->email) }}"
                    class="w-full px-5 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all shadow-sm text-gray-700 font-medium">
            </div>

            <!-- New Password -->
            <div class="flex flex-col">
                <label for="password" class="text-gray-700 font-medium mb-2">New Password</label>
                <input type="password" name="password" id="password"
                    class="w-full px-5 py-3 border border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition-all shadow-sm text-gray-700 font-medium">
                <p class="text-sm text-gray-500 mt-1">Leave blank if you don’t want to change it.</p>
            </div>

            <!-- Save Changes Button -->
            <button type="submit"
                class="w-full flex justify-center items-center gap-2 bg-green-600 text-white py-3 rounded-2xl text-lg font-semibold hover:bg-green-700 active:scale-[.97] transition-all shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path
                        d="M17.707 5.293a1 1 0 00-1.414 0L9 12.586 5.707 9.293a1 1 0 00-1.414 1.414l4 4a1 1 0 001.414 0l8-8a1 1 0 000-1.414z" />
                </svg>
                Save Changes
            </button>
        </form>
    </div>
</main>

<!-- Avatar Preview Script -->
<script>
    function previewAvatar(event) {
        const file = event.target.files[0];
        if (!file) return;

        const avatarPreview = document.getElementById('avatarPreview');
        const initials = document.getElementById('avatarInitials');

        avatarPreview.src = URL.createObjectURL(file);
        avatarPreview.style.display = 'block';
        if (initials) initials.style.display = 'none';
    }
</script>