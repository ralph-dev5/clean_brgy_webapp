@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-12 p-6">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <a href="{{ route('admin.profile') }}"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                ← Back
            </a>
            <h1 class="text-3xl font-bold text-gray-800 tracking-wide">Edit Profile</h1>
            <div></div>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-green-100 text-green-800 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Card --}}
        <div class="bg-white p-8 rounded-2xl shadow-xl border border-gray-200">
            <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data"
                class="space-y-6">
                @csrf
                @method('PUT') {{-- Important: use PUT for updating --}}

                {{-- Name --}}
                <div>
                    <label class="block font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-1 focus:ring focus:ring-blue-200">
                    @error('name') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="w-full border border-gray-300 rounded-lg p-3 mt-1 focus:ring focus:ring-blue-200">
                    @error('email') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror
                </div>

                {{-- Avatar --}}
                <div>
                    <label class="block font-semibold text-gray-700">Profile Picture</label>
                    <input type="file" name="avatar" id="avatarInput" class="mt-1">
                    @error('avatar') <span class="text-red-600 text-sm">{{ $message }}</span> @enderror

                    <div class="mt-4 flex items-center gap-4">
                        <p class="text-gray-600 text-sm">Preview:</p>
                        <img id="avatarPreview" src="{{ $user->avatar ? asset('storage/' . $user->avatar) : '' }}"
                            alt="Avatar"
                            class="w-24 h-24 rounded-full object-cover border shadow {{ $user->avatar ? '' : 'hidden' }}">
                    </div>
                </div>

                {{-- Add this script at the bottom of your Blade file --}}
                <script>
                    const avatarInput = document.getElementById('avatarInput');
                    const avatarPreview = document.getElementById('avatarPreview');

                    avatarInput.addEventListener('change', function () {
                        const file = this.files[0];
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function (e) {
                                avatarPreview.src = e.target.result;
                                avatarPreview.classList.remove('hidden');
                            }
                            reader.readAsDataURL(file);
                        }
                    });
                </script>


                {{-- Submit --}}
                <div>
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                        Update Profile
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection