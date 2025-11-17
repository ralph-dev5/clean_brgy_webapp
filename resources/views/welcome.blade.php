<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clean Brgy App</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 font-sans">

    <!-- Navbar -->
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="text-2xl font-bold text-green-600">
                    Clean Brgy App
                </div>
                <div class="space-x-2">
                    <a href="{{ route('login') }}" 
                       class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">
                       Login
                    </a>

                    <a href="{{ route('register') }}" 
                       class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-sm font-medium">
                       Register
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-green-600 text-white py-24">
        <div class="max-w-4xl mx-auto text-center px-4">
            <h1 class="text-4xl md:text-5xl font-extrabold mb-4">
                Welcome to Clean Brgy App
            </h1>

            <p class="text-lg md:text-xl mb-10 opacity-90">
                Report basura gusto, tapon basura ayaw — talaga ka ha.
            </p>

            <a href="{{ route('register') }}"
               class="bg-white text-green-600 font-bold px-8 py-3 rounded-lg shadow-md 
                      hover:bg-gray-100 transition-all text-lg">
               Get Started
            </a>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20">
        <div class="max-w-6xl mx-auto px-4">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-12">
                Key Features
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">

                <!-- Feature 1 -->
                <div class="bg-white shadow-lg rounded-2xl p-8 text-center hover:shadow-2xl transition">
                    <div class="text-green-600 text-5xl mb-4">📝</div>
                    <h3 class="text-xl font-semibold mb-2">Submit Reports</h3>
                    <p class="text-gray-600">
                        Easily send garbage reports with details and images.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-white shadow-lg rounded-2xl p-8 text-center hover:shadow-2xl transition">
                    <div class="text-green-600 text-5xl mb-4">📊</div>
                    <h3 class="text-xl font-semibold mb-2">Track Status</h3>
                    <p class="text-gray-600">
                        Monitor your submitted reports in real-time.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-white shadow-lg rounded-2xl p-8 text-center hover:shadow-2xl transition">
                    <div class="text-green-600 text-5xl mb-4">🏘️</div>
                    <h3 class="text-xl font-semibold mb-2">Help the Community</h3>
                    <p class="text-gray-600">
                        Contribute to keeping your barangay clean and safe.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-100 py-6 mt-12">
        <div class="max-w-7xl mx-auto px-4 text-center text-gray-600">
            &copy; {{ date('Y') }} Clean Brgy App — All rights reserved.
        </div>
    </footer>

</body>
</html>
