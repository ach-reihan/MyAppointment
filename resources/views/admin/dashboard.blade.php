<x-app-layout :title="'Dashboard – My Appointment Admin'">

    <div class="mb-6">
        <h1 class="text-xl font-bold text-slate-800 tracking-tight">Ringkasan Makro</h1>
        <p class="text-sm text-slate-500 mt-0.5">Pantau performa operasional klinik secara real-time.</p>
    </div>

    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        @php
        $iconMap = [
            'users'    => '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>',
            'doctor'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>',
            'calendar' => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
            'clinic'   => '<path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>',
        ];
        $colorMap = [
            'blue'    => ['bg' => 'bg-blue-50',    'icon' => 'text-blue-600',    'ring' => 'bg-blue-600'],
            'indigo'  => ['bg' => 'bg-indigo-50',  'icon' => 'text-indigo-600',  'ring' => 'bg-indigo-600'],
            'amber'   => ['bg' => 'bg-amber-50',   'icon' => 'text-amber-600',   'ring' => 'bg-amber-500'],
            'emerald' => ['bg' => 'bg-emerald-50', 'icon' => 'text-emerald-600', 'ring' => 'bg-emerald-500'],
        ];
        $badgeMap = [
            'up'      => 'bg-emerald-100 text-emerald-700',
            'neutral' => 'bg-slate-100 text-slate-600',
            'warning' => 'bg-amber-100 text-amber-700',
            'success' => 'bg-emerald-100 text-emerald-700',
        ];
        @endphp

        @foreach($stats as $stat)
        @php
            $c = $colorMap[$stat['color']];
            $b = $badgeMap[$stat['badge_type']];
        @endphp
        <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm hover:shadow-md transition-shadow duration-200 flex flex-col gap-3">
            <div class="flex items-center justify-between">
                <div class="{{ $c['bg'] }} rounded-xl p-2.5">
                    <svg class="w-5 h-5 {{ $c['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        {!! $iconMap[$stat['icon']] !!}
                    </svg>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full {{ $b }}">
                    {{ $stat['badge'] }}
                </span>
            </div>
            <div>
                <p class="text-2xl font-extrabold text-slate-800 tracking-tight leading-none">{{ $stat['value'] }}</p>
                <p class="text-xs text-slate-500 mt-1">{{ $stat['label'] }}</p>
            </div>
        </div>
        @endforeach

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-4">

        <div class="lg:col-span-3 bg-white rounded-2xl border border-slate-100 shadow-sm p-5"
             x-data="{
                 bars: {{ json_encode($weekly) }},
                 tooltip: null,
                 tooltipX: 0,
                 tooltipY: 0,
             }">

            <div class="flex items-center justify-between mb-5">
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Kunjungan Pasien Mingguan</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Data kumulatif 7 hari terakhir</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-600 inline-block"></span>
                    <span class="text-xs text-slate-500">Kunjungan</span>
                </div>
            </div>

            <div class="flex items-end justify-between gap-2 h-40 px-2">
                <template x-for="(bar, i) in bars" :key="i">
                    <div class="flex-1 flex flex-col items-center gap-1.5 group relative">
                        <div x-show="tooltip === i"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100"
                             class="absolute -top-10 left-1/2 -translate-x-1/2 bg-slate-800 text-white text-xs px-2 py-1 rounded-lg whitespace-nowrap pointer-events-none z-10">
                            <span x-text="bar.count + ' pasien'"></span>
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-2 h-2 bg-slate-800 rotate-45"></div>
                        </div>

                        <div class="w-full relative rounded-t-md cursor-pointer transition-all duration-200"
                             :style="'height: ' + (bar.pct * 1.4) + 'px;'"
                             :class="tooltip === i ? 'bg-blue-700' : 'bg-blue-500 group-hover:bg-blue-600'"
                             @mouseenter="tooltip = i"
                             @mouseleave="tooltip = null">
                        </div>

                        <span class="text-[10px] text-slate-400 font-medium" x-text="bar.day"></span>
                    </div>
                </template>
            </div>

        </div>

        <div class="lg:col-span-2 bg-white rounded-2xl border border-slate-100 shadow-sm p-5 flex flex-col">

            <div class="flex items-center justify-between mb-4">
                <h2 class="text-sm font-bold text-slate-800">Aktivitas Terbaru</h2>
                <span class="text-[10px] bg-slate-100 text-slate-500 px-2 py-0.5 rounded-full font-medium">Hari Ini</span>
            </div>

            <div class="flex-1 space-y-3">
                @php
                $actColorMap = [
                    'emerald' => ['dot' => 'bg-emerald-500', 'ring' => 'bg-emerald-50', 'icon' => 'text-emerald-600'],
                    'blue'    => ['dot' => 'bg-blue-500',    'ring' => 'bg-blue-50',    'icon' => 'text-blue-600'],
                    'indigo'  => ['dot' => 'bg-indigo-500',  'ring' => 'bg-indigo-50',  'icon' => 'text-indigo-600'],
                    'amber'   => ['dot' => 'bg-amber-500',   'ring' => 'bg-amber-50',   'icon' => 'text-amber-600'],
                ];
                $actIconMap = [
                    'selesai'     => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>',
                    'masuk'       => '<path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                    'baru'        => '<path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>',
                    'reschedule'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>',
                ];
                @endphp

                @foreach($activities as $activity)
                @php
                    $ac = $actColorMap[$activity['color']];
                @endphp
                <div class="flex items-start gap-3 p-3 rounded-xl hover:bg-slate-50 transition-colors cursor-default">
                    <div class="flex-shrink-0 w-8 h-8 {{ $ac['ring'] }} rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4 {{ $ac['icon'] }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            {!! $actIconMap[$activity['type']] !!}
                        </svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-700 truncate">{{ $activity['title'] }}</p>
                        <p class="text-[11px] text-slate-400 truncate mt-0.5">{{ $activity['desc'] }}</p>
                    </div>
                    <span class="flex-shrink-0 text-[10px] text-slate-400 font-medium mt-0.5">{{ $activity['time'] }}</span>
                </div>
                @endforeach
            </div>

            <a href="#" class="mt-4 flex items-center justify-center gap-1.5 text-xs text-blue-600 font-semibold hover:text-blue-700 transition-colors py-2 rounded-lg hover:bg-blue-50">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M12 5l7 7-7 7"/>
                </svg>
                Lihat semua log aktivitas
            </a>

        </div>

    </div>

</x-app-layout>