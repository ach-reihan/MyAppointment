<x-app-layout :title="'Data Poliklinik – My Appointment'">

    <div x-data="{ 
        openModal: false, 
        isEdit: false,
        modalTitle: 'Tambah Poliklinik Baru',
        namaPoli: '',
        deskripsi: '',
        statusPoli: 'AKTIF'
    }">

        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Master Data Management</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola informasi fundamental rumah sakit dalam satu dasbor terpusat.</p>
        </div>

        <div class="flex flex-wrap gap-2 mb-6 bg-slate-100 p-1.5 rounded-xl w-max border border-slate-200/60">
            <a href="{{ route('master-data.users') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Manajemen User
            </a>
            <a href="{{ route('master-data.doctors') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Data Dokter
            </a>
            <a href="{{ route('master-data.patients') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Data Pasien
            </a>
            <a href="{{ route('master-data.polyclinics') }}" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white text-blue-600 shadow-sm transition-all">
                Data Poliklinik
            </a>
        </div>

        <div class="bg-transparent">
            <div class="flex items-center justify-between mb-6 flex-wrap gap-4">
                <div>
                    <h2 class="text-lg font-bold text-slate-800">Manajemen Poliklinik</h2>
                </div>
                <button 
                    @click="openModal = true; isEdit = false; modalTitle = 'Tambah Poliklinik Baru'; namaPoli = ''; deskripsi = ''; statusPoli = 'AKTIF'" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition-colors shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Tambah Poli
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($polyclinics as $poli)
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-6 relative overflow-hidden group hover:shadow-md transition-all">
                    <div class="absolute left-0 top-0 bottom-0 w-1.5 {{ $poli['border_color'] }}"></div>

                    <div class="flex justify-between items-start mb-4 pl-2">
                        <div class="w-10 h-10 rounded-full bg-slate-50 flex items-center justify-center text-slate-600">
                            @if($poli['icon'] === 'umum')
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                            @else
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button 
                                @click="openModal = true; isEdit = true; modalTitle = 'Edit Data Poliklinik'; namaPoli = '{{ $poli['nama'] }}'; deskripsi = '{{ $poli['deskripsi'] }}'; statusPoli = '{{ $poli['status'] }}'"
                                class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                            </button>
                            <button 
                                @click="if(confirm('Hapus poli ini?')) alert('Data berhasil dihapus (Mocking)')"
                                class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors"
                            >
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="pl-2">
                        <h3 class="text-base font-bold text-slate-800 mb-2">{{ $poli['nama'] }}</h3>
                        <p class="text-xs text-slate-500 leading-relaxed mb-6 min-h-[40px]">{{ $poli['deskripsi'] }}</p>
                        
                        <div class="flex items-center justify-between border-t border-slate-100 pt-4 mt-auto">
                            <span class="text-xs font-semibold text-slate-600">{{ $poli['jumlah_dokter'] }} Dokter Aktif</span>
                            <span class="px-2.5 py-1 text-[10px] font-bold rounded bg-emerald-50 text-emerald-600 border border-emerald-100">{{ $poli['status'] }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div x-show="openModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">
            <div x-show="openModal" x-transition.opacity.duration.200ms @click="openModal = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-xs"></div>

            <div 
                x-show="openModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg overflow-hidden z-10 relative"
            >
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="text-base font-bold text-slate-800" x-text="modalTitle"></h3>
                    <button @click="openModal = false" class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div x-show="!isEdit">
                    @include('admin.form.polyclinic.create')
                </div>
                <div x-show="isEdit" style="display: none;">
                    @include('admin.form.polyclinic.edit')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>