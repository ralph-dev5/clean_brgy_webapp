<aside class="w-64 bg-white shadow-lg h-screen sticky top-0">
    <div class="p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
        <nav class="flex flex-col gap-2">
            <!-- Dashboard Link -->
            <a href="{{ route('admin.dashboard') }}" 
               class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
               {{ request()->routeIs('admin.dashboard') ? 'font-semibold bg-gray-200' : '' }}">
               Dashboard
            </a>

            <!-- Reports Link -->
            <a href="{{ route('admin.reports.index') }}" 
               class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
               {{ request()->routeIs('admin.reports.*') ? 'font-semibold bg-gray-200' : '' }}">
               Reports
            </a>

            <!-- Trash Link -->
            <a href="{{ route('admin.reports.trash') }}" 
               class="text-gray-700 hover:bg-gray-200 px-4 py-2 rounded transition
               {{ request()->routeIs('admin.reports.trash') ? 'font-semibold bg-gray-200' : '' }}">
               Trash
            </a>

            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}" class="mt-4">
                @csrf
                <button type="submit" 
                        class="w-full text-left text-red-600 hover:bg-red-100 px-4 py-2 rounded transition">
                    Logout
                </button>
            </form>
        </nav>
    </div>
</aside>
