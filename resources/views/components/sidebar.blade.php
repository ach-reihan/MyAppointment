<div class="flex flex-col h-full">

    <div class="flex items-center gap-3 px-4 py-5 border-b border-slate-100 min-h-[65px]">
        <div class="flex-shrink-0 w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
            </svg>
        </div>
        <div x-show="sidebarOpen || mobileSidebarOpen" x-transition:enter="transition-all duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" class="overflow-hidden">
            <p class="text-sm font-bold text-blue-600 leading-tight whitespace-nowrap">My Appointment</p>
            <p class="text-[10px] text-slate-400 whitespace-nowrap">Medical Admin</p>
        </div>
    </div>

    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">

        <a href="{{ route('admin.dashboard') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h7v7H3zM14 3h7v7h-7zM14 14h7v7h-7zM3 14h7v7H3z"/>
            </svg>
            <span x-show="sidebarOpen || mobileSidebarOpen" class="text-sm font-medium whitespace-nowrap overflow-hidden">Dashboard</span>
        </a>

        <div x-data="{ open: {{ request()->routeIs('master-data.*') ? 'true' : 'false' }} }">
            <button @click="open = !open"
                class="w-full group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                       {{ request()->routeIs('admin.master-data.*') ? 'text-blue-600 bg-blue-50' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                </svg>
                <span x-show="sidebarOpen || mobileSidebarOpen" class="flex-1 text-sm font-medium text-left whitespace-nowrap overflow-hidden">Master Data</span>
                <svg x-show="sidebarOpen || mobileSidebarOpen" :class="open ? 'rotate-180' : ''" class="w-4 h-4 flex-shrink-0 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="open && (sidebarOpen || mobileSidebarOpen)" x-transition class="mt-1 ml-8 space-y-1">
                <a href="{{ route('admin.master-data.users') }}" class="block px-3 py-2 text-xs rounded-md transition-colors
                   {{ request()->routeIs('admin.master-data.users') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">
                    Manajemen User
                </a>
                <a href="{{ route('admin.master-data.doctors') }}" class="block px-3 py-2 text-xs rounded-md transition-colors
                   {{ request()->routeIs('admin.master-data.doctors') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">
                    Data Dokter
                </a>
                <a href="{{ route('admin.master-data.patients') }}" class="block px-3 py-2 text-xs rounded-md transition-colors
                   {{ request()->routeIs('admin.master-data.patients') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">
                    Data Pasien
                </a>
                <a href="{{ route('admin.master-data.polyclinics') }}" class="block px-3 py-2 text-xs rounded-md transition-colors
                   {{ request()->routeIs('admin.master-data.polyclinics') ? 'text-blue-600 bg-blue-50 font-medium' : 'text-slate-500 hover:text-blue-600 hover:bg-blue-50' }}">
                    Data Poliklinik
                </a>
            </div>
        </div>

        <a href="{{ route('admin.operational.queue') }}"
           class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-150
                  {{ request()->routeIs('admin.operational.*') ? 'bg-blue-600 text-white shadow-sm' : 'text-slate-600 hover:bg-blue-50 hover:text-blue-600' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span x-show="sidebarOpen || mobileSidebarOpen" class="text-sm font-medium whitespace-nowrap overflow-hidden">Operasional</span>
        </a>

    </nav>

    <div class="border-t border-slate-100 p-3">
        <div class="flex items-center gap-3 px-2 py-2 rounded-lg hover:bg-slate-50 transition-colors cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center flex-shrink-0 text-white text-xs font-bold">
                SW
            </div>
            <div x-show="sidebarOpen || mobileSidebarOpen" class="overflow-hidden">
                <p class="text-xs font-semibold text-slate-700 whitespace-nowrap">Dr. Sarah Wijaya</p>
                <p class="text-[10px] text-slate-400 whitespace-nowrap">Super Admin</p>
            </div>
        </div>
    </div>

</div>