<div 
    x-show="openHistory" 
    style="display: none;"
    class="fixed inset-0 z-50 overflow-hidden"
>
    <div 
        x-show="openHistory"
        x-transition.opacity.duration.300ms
        @click="openHistory = false"
        class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"
    ></div>

    <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
        <div 
            x-show="openHistory"
            x-transition:enter="transform transition ease-in-out duration-300"
            x-transition:enter-start="translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition ease-in-out duration-300"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="translate-x-full"
            class="w-screen max-w-md"
        >
            <div class="flex h-full flex-col bg-white shadow-2xl border-l border-slate-100">
                
                <div class="bg-blue-600 px-6 py-5 flex items-start justify-between shadow-sm z-10">
                    <div>
                        <h2 class="text-base font-bold text-white leading-tight">Rekam Medis Historis</h2>
                        <p class="mt-1 text-sm text-blue-100 font-medium" x-text="patientName"></p>
                    </div>
                    <div class="ml-3 flex h-7 items-center">
                        <button @click="openHistory = false" type="button" class="rounded-md text-blue-200 hover:text-white focus:outline-none transition-colors">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>
                </div>

                <div class="relative flex-1 px-4 py-6 sm:px-6 overflow-y-auto bg-white">
                    
                    <div class="relative border-l-2 border-slate-100 ml-3 space-y-6">
                        
                        @foreach($history as $index => $rekam)
                        <div class="relative pl-6">
                            <div class="absolute -left-[9px] top-1 w-4 h-4 rounded-full border-4 border-white bg-blue-500"></div>
                            
                            <div class="bg-slate-50 p-4 rounded-xl shadow-sm border border-slate-100 hover:border-blue-200 transition-colors">
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-[10px] font-bold text-blue-600 bg-blue-100/50 px-2 py-0.5 rounded">{{ $rekam['tanggal'] }}</span>
                                    <span class="text-[10px] font-medium text-slate-500">{{ $rekam['dokter'] }}</span>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Diagnosa</p>
                                    <p class="text-xs font-semibold text-slate-800">{{ $rekam['diagnosa'] }}</p>
                                </div>
                                
                                <div class="mb-3">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Tindakan</p>
                                    <p class="text-[11px] text-slate-600 leading-relaxed">{{ $rekam['tindakan'] }}</p>
                                </div>

                                @if(count($rekam['resep']) > 0)
                                <div class="pt-3 border-t border-slate-200/60">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1">Resep</p>
                                    <ul class="list-disc pl-4 text-[11px] text-slate-600 space-y-0.5">
                                        @foreach($rekam['resep'] as $resep)
                                            <li>{{ $resep }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>

                <div class="bg-white px-4 py-4 border-t border-slate-100 flex items-center justify-between gap-3 shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
                    <button @click="openHistory = false" class="flex-1 bg-slate-50 text-slate-600 border border-slate-200 px-4 py-2.5 rounded-xl text-xs font-bold hover:bg-slate-100 transition-colors text-center">
                        Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>