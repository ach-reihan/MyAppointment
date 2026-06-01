<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, mobileSidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Healthink Medical Admin' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F0F4F8] font-sans antialiased">

    <div
        x-show="mobileSidebarOpen"
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="mobileSidebarOpen = false"
        class="fixed inset-0 bg-black/40 z-20 lg:hidden"
        style="display:none;"
    ></div>

    <div class="flex h-screen overflow-hidden">

        <aside
            :class="[
                'fixed inset-y-0 left-0 z-30 flex flex-col bg-white border-r border-slate-100 transition-all duration-300 ease-in-out',
                'lg:static lg:translate-x-0',
                sidebarOpen ? 'w-60' : 'w-16',
                mobileSidebarOpen ? 'translate-x-0 w-60' : '-translate-x-full lg:translate-x-0'
            ]"
        >
            @include('components.sidebar')
        </aside>

        <div class="flex flex-col flex-1 min-w-0 overflow-hidden">

            @include('components.topbar')

            <main class="flex-1 overflow-y-auto p-4 lg:p-6">
                {{ $slot }}
            </main>

            <footer class="px-6 py-3 bg-white border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                <span>© 2024 Healthink Medical Solutions. Seluruh hak cipta dilindungi.</span>
                <div class="flex gap-4">
                    <a href="#" class="hover:text-blue-600 transition-colors">Pusat Bantuan</a>
                    <a href="#" class="hover:text-blue-600 transition-colors">Syarat & Ketentuan</a>
                </div>
            </footer>
        </div>
    </div>

</body>
</html>