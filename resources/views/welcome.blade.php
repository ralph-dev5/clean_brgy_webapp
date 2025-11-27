<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Clean Brgy App</title>
<script src="https://cdn.tailwindcss.com"></script>

<style>
.animate-fade {
    animation: fadeIn 0.8s ease-in-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
function showSection(id) {
    document.querySelectorAll("section").forEach(sec => {
        sec.classList.add("hidden");
        sec.classList.remove("animate-fade"); // remove animation first
    });
    const sec = document.getElementById(id);
    sec.classList.remove("hidden");
    sec.classList.add("animate-fade"); // add animation
}

// Animate Get Started button on page load
window.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("get-started-btn");
    if (btn) btn.classList.add("animate-fade");
});
</script>
</head>

<body class="bg-gray-50 font-sans">

<!-- NAVBAR -->
<nav class="bg-white shadow-md fixed w-full z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex space-x-6 text-sm font-medium">
                <button onclick="showSection('home')" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md">Home</button>
                <button onclick="showSection('about')" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md">About</button>
                <button onclick="showSection('contact')" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md">Contact</button>
            </div>
            <div class="space-x-2">
                <a href="{{ route('login') }}" class="text-gray-700 hover:text-green-600 px-3 py-2 rounded-md text-sm font-medium">Login</a>
                <a href="{{ route('register') }}" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition text-sm font-medium">Register</a>
            </div>
        </div>
    </div>
</nav>

<div class="pt-20">

    <!-- HOME SECTION -->
    <section id="home" class="animate-fade">
        <div class="bg-gradient-to-b from-green-50 to-white">
            <div class="max-w-7xl mx-auto px-6 py-24 text-center">
                <h1 class="text-5xl font-extrabold text-green-700 mb-4 drop-shadow-sm">Welcome to our website!</h1>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto leading-relaxed">
                    A simple and efficient way for residents to submit reports, track updates,
                    and help maintain a clean and safe community.
                </p>
                <div class="mt-6">
                    <a id="get-started-btn" href="{{ route('login') }}"
                       class="bg-green-600 text-white px-8 py-3 rounded-full text-lg font-semibold shadow hover:bg-green-700 hover:shadow-lg transition-all">
                        Get Started
                    </a>
                </div>
            </div>
        </div>

        <!-- FEATURES -->
        <div class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-10 text-center">
                <div class="bg-green-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                    <div class="text-green-600 text-5xl mb-4">📝</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Submit Reports</h3>
                    <p class="text-gray-600">Report waste issues, damaged facilities, or community problems quickly.</p>
                </div>
                <div class="bg-green-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                    <div class="text-green-600 text-5xl mb-4">📊</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Track Status</h3>
                    <p class="text-gray-600">Stay updated with real-time progress of your reports.</p>
                </div>
                <div class="bg-green-50 p-8 rounded-2xl shadow-md hover:shadow-xl transition">
                    <div class="text-green-600 text-5xl mb-4">🤝</div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">Support Your Community</h3>
                    <p class="text-gray-600">Help keep your barangay clean, safe, and environmentally aware.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="about" class="py-20 bg-gray-50 hidden">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white rounded-3xl shadow-lg p-12 md:p-16 text-center md:text-left flex flex-col md:flex-row items-center gap-10">
                <div class="flex-shrink-0 text-green-600 text-6xl md:text-8xl text-center md:text-left">🏘️</div>
                <div class="flex-1">
                    <h2 class="text-3xl md:text-4xl font-bold text-green-700 mb-4">About the App</h2>
                    <p class="text-gray-700 text-lg md:text-xl leading-relaxed mb-6">
                        Clean Barangay App helps residents report issues such as waste, damages,
                        or environmental concerns and get updates in real-time.
                        It strengthens communication between the community and the barangay.
                    </p>
                    <ul class="space-y-3 text-gray-600 text-left md:text-left">
                        <li class="flex items-center gap-3"><span class="text-green-600">✅</span> Easy reporting anytime</li>
                        <li class="flex items-center gap-3"><span class="text-green-600">✅</span> Real-time updates on report status</li>
                        <li class="flex items-center gap-3"><span class="text-green-600">✅</span> Strengthens resident-barangay communication</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contact" class="py-20 bg-gray-50 hidden">
        <div class="max-w-3xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-green-700 mb-8">Contact Us</h2>
            <p class="text-gray-600 text-lg mb-8">
                Have questions, suggestions, or concerns? Feel free to send us a message and we’ll get back to you as soon as possible.
            </p>
            <div class="space-y-4 text-gray-700 text-lg">
                <div class="flex items-center justify-center space-x-3">
                    <span class="text-green-600 text-2xl">📍</span>
                    <span>Salog Pob. Sorsogon city</span>
                </div>
                <div class="flex items-center justify-center space-x-3">
                    <span class="text-green-600 text-2xl">📧</span>
                    <span>info@cleanbarangayapp.com</span>
                </div>
                <div class="flex items-center justify-center space-x-3">
                    <span class="text-green-600 text-2xl">📞</span>
                    <span>+63 912 345 6789</span>
                </div>
            </div>
        </div>
    </section>

</div>

<!-- FOOTER -->
<footer class="bg-gray-100 py-6 mt-12 text-center text-gray-600">
    &copy; 2025 Clean Brgy App — All rights reserved.
</footer>

</body>
</html>
