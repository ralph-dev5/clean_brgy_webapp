@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-6xl mx-auto px-4 lg:px-0 space-y-10">

        <!-- Header + Avatar + Actions -->
        <div class="bg-gradient-to-r from-green-600 to-emerald-500 text-white rounded-3xl shadow-xl p-8 flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">

            <!-- Left: Avatar + Welcome -->
            <div class="flex items-center gap-4">
                <!-- Avatar Circle -->
                <div class="relative w-14 h-14 rounded-full bg-green-600 border-2 border-white shadow-lg overflow-hidden flex items-center justify-center">
                    @php
                        $avatarPath = $user->avatar;
                        $avatarExists = $avatarPath && Storage::disk('public')->exists($avatarPath);
                        $avatarTimestamp = session('avatar_updated_at') ?? time();
                    @endphp

                    @if($avatarExists)
                        <img src="{{ asset('storage/' . $user->avatar) }}?{{ $avatarTimestamp }}" 
                             alt="Avatar" class="w-full h-full object-cover">
                    @else
                        @php
                            $names = explode(' ', $user->name);
                            $initials = count($names) > 1
                                ? strtoupper(substr($names[0], 0, 1) . substr($names[1], 0, 1))
                                : strtoupper(substr($names[0], 0, 1));
                        @endphp
                        <span class="text-white text-xl font-bold">{{ $initials }}</span>
                    @endif
                </div>

                <!-- Welcome Message -->
                <div>
                    <p class="text-sm uppercase tracking-widest text-white/80 font-semibold">
                        Barangay Clean &amp; Green
                    </p>

                    <h1 class="text-3xl lg:text-4xl font-extrabold mt-2">
                        @if(isset($isFirstLogin) && $isFirstLogin)
                            Welcome, {{ $user->name }} 👋
                        @else
                            Welcome back, {{ $user->name }} 👋
                        @endif
                    </h1>

                    <p class="text-white/90 mt-1">
                        Track your submissions, monitor their status, and keep our community clean.
                    </p>
                </div>
            </div>

            <!-- Right: Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('user.report.create') }}" 
                   class="inline-flex items-center justify-center gap-2 border border-white/70 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-white/10 transition">
                    Submit New Report
                </a>

                <a href="{{ route('user.profile') }}" 
                   class="inline-flex items-center justify-center gap-2 border border-white/70 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-white/10 transition">
                    Settings
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center justify-center gap-2 border border-white/70 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-white/10 transition">
                        Logout
                    </button>
                </form>
            </div>

        </div>

        <!-- Stats Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-6">
            @php
                $stats = [
                    ['label' => 'Total Reports', 'value' => $totalReports, 'accent' => 'text-green-600'],
                    ['label' => 'Pending', 'value' => $pendingReports, 'accent' => 'text-yellow-600'],
                    ['label' => 'In Progress', 'value' => $inProgressReports, 'accent' => 'text-blue-600'],
                    ['label' => 'Resolved', 'value' => $resolvedReports, 'accent' => 'text-emerald-600'],
                    ['label' => 'Photos Submitted', 'value' => $submittedImages, 'accent' => 'text-purple-600'],
                ];
            @endphp

            @foreach($stats as $stat)
                <div class="bg-white rounded-2xl border shadow-sm hover:shadow-md transition p-5">
                    <p class="text-sm uppercase tracking-wide text-gray-500">{{ $stat['label'] }}</p>
                    <p class="text-3xl font-bold mt-2 {{ $stat['accent'] }}">{{ $stat['value'] }}</p>
                </div>
            @endforeach
        </div>

        <!-- Reports Table -->
        <div class="bg-white rounded-3xl shadow-lg border p-6">
            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900">My Reports</h2>
                    <p class="text-gray-500">Monitor each report’s progress and manage your submissions.</p>
                </div>
            </div>

            @if($reports->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full table-auto text-left">
                        <thead>
                            <tr class="bg-gray-100 text-gray-600 uppercase text-sm tracking-wide">
                                <th class="px-4 py-3 rounded-l-2xl">ID</th>
                                <th class="px-4 py-3">Location</th>
                                <th class="px-4 py-3">Description</th>
                                <th class="px-4 py-3">Image</th>
                                <th class="px-4 py-3">Status</th>
                                <th class="px-4 py-3 rounded-r-2xl text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($reports as $report)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-3 font-semibold text-gray-800">#{{ $report->id }}</td>
                                    <td class="px-4 py-3 text-gray-700">{{ $report->location }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ Str::limit($report->description ?? 'No description', 60) }}</td>
                                    <td class="px-4 py-3">
                                        @if($report->image)
                                            <img src="{{ asset('storage/' . $report->image) }}" class="w-16 h-16 rounded-xl object-cover border">
                                        @else
                                            <span class="text-gray-400 text-sm">No Image</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            @if($report->status === 'pending') bg-yellow-100 text-yellow-700
                                            @elseif($report->status === 'in-progress') bg-blue-100 text-blue-700
                                            @elseif($report->status === 'resolved') bg-green-100 text-green-700
                                            @else bg-gray-100 text-gray-700 @endif">
                                            {{ ucfirst($report->status) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('user.report.show', $report) }}" class="text-green-600 font-semibold hover:underline">View</a>
                                            <form action="{{ route('user.report.destroy', $report) }}" method="POST" onsubmit="return confirm('Delete this report?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 font-semibold hover:underline">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $reports->links() }}
                </div>
            @else
                <div class="text-center py-10 text-gray-500">
                    You haven’t submitted any reports yet. Start by clicking “Submit New Report.”
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
