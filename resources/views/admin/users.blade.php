@extends('layouts.app')

@section('content')
<div class="container mx-auto mt-8">

    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}"
           class="inline-block px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300 shadow-sm transition">
            Back
        </a>
    </div>

    <h1 class="text-3xl font-bold text-gray-800 mb-4">
        Users ({{ $users->count() }})
    </h1>

    @if($users->isEmpty())
        <p class="text-gray-600 text-lg">No users found.</p>
    @else
        <div class="overflow-x-auto bg-white shadow-md rounded-lg p-4">
            <table class="min-w-full border-collapse text-sm">
                <thead class="bg-blue-100 text-blue-800 font-semibold">
                    <tr>
                        <th class="py-2 px-3 border">ID</th>
                        <th class="py-2 px-3 border">Name</th>
                        <th class="py-2 px-3 border">Email</th>
                        <th class="py-2 px-3 border">Role</th>
                        <th class="py-2 px-3 border">Registered At</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr class="border-b hover:bg-blue-50 transition">
                            <td class="py-2 px-3 border font-medium">{{ $user->id }}</td>
                            <td class="py-2 px-3 border">{{ $user->name }}</td>
                            <td class="py-2 px-3 border">{{ $user->email }}</td>
                            <td class="py-2 px-3 border">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $user->role === 'Admin' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td class="py-2 px-3 border">{{ $user->created_at->format('F d, Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Optional Pagination -->
            @if(method_exists($users, 'links'))
                <div class="mt-4">
                    {{ $users->withQueryString()->links() }}
                </div>
            @endif
        </div>
    @endif

</div>
@endsection
