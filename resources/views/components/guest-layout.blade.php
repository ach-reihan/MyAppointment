<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Appointment - Solusi Kesehatan Digital</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased text-gray-900">
    
    <nav x-data="{ open: false }" class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('landing') }}" class="text-2xl font-bold text-blue-600">
                        My Appointment
                    </a>
                </div>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="#" class="text-gray-500 hover:text-blue-600">Beranda</a>
                    <a href="#layanan" class="text-gray-500 hover:text-blue-600">Layanan Kami</a>
                    <a href="#tentang" class="text-gray-500 hover:text-blue-600">Tentang Kami</a>
                    <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-blue-600">Log in</a>
                    <a href="{{ route('login') }}" class="bg-blue-600 text-white px-5 py-2 rounded-full font-medium hover:bg-blue-700 transition">
                        Mulai Sekarang
                    </a>
                </div>

                <div class="md:hidden flex items-center">
                    <button @click="open = !open" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div x-show="open" class="md:hidden bg-white border-t">
            <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
                <a href="#" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md">Beranda</a>
                <a href="#layanan" class="block px-3 py-2 text-gray-700 hover:bg-gray-50 rounded-md">Layanan Kami</a>
                <a href="{{ route('login') }}" class="block px-3 py-2 text-blue-600 font-medium">Log in</a>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-200 mt-20 pt-10 pb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-sm text-gray-500">
            <p>&copy; {{ date('Y') }} My Appointment Medical Solutions. Seluruh hak cipta dilindungi.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-gray-900">Privasi</a>
                <a href="#" class="hover:text-gray-900">Syarat & Ketentuan</a>
            </div>
        </div>
    </footer>

</body>
</html>