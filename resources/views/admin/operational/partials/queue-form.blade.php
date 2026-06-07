<div x-show="openQueueModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">

    <div x-show="openQueueModal" x-transition.opacity.duration.200ms @click="openQueueModal = false"
        class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div x-show="openQueueModal" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg z-10 relative flex flex-col max-h-[90vh]">
        
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between shrink-0">
            <h3 class="text-base font-bold text-slate-800">Tambah Antrian Pasien</h3>
            <button type="button" @click="openQueueModal = false"
                class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form @submit.prevent="saveNewQueue()" class="p-6 space-y-5 overflow-y-auto relative">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ID Antrian</label>
                    <input type="text" x-model="formQueue.id" disabled
                        class="w-full px-3.5 py-2 text-sm bg-slate-100 border border-slate-200 rounded-lg text-slate-500 font-semibold focus:outline-none cursor-not-allowed opacity-80">
                </div>

                <div x-data="{
                    open: false,
                    search: '',
                    options: [
                        @foreach($patients as $patient)
                            { id: '{{ $patient->id }}', label: '{{ addslashes($patient->user->name ?? 'Anonim') }}' },
                        @endforeach
                    ],
                    get filteredOptions() {
                        if (this.search === '') return this.options;
                        return this.options.filter(i => i.label.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    get selectedLabel() {
                        let selected = this.options.find(i => i.id == formQueue.patient_id);
                        return selected ? selected.label : 'Pilih Pasien...';
                    }
                }" @click.outside="open = false" class="relative">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pasien</label>
                    
                    <button type="button" @click="open = !open" 
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-left focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 flex justify-between items-center"
                        :class="formQueue.patient_id ? 'text-slate-800' : 'text-slate-400'">
                        <span x-text="selectedLabel" class="truncate"></span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>

                    <div x-show="open" style="display: none;"
                        class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg overflow-hidden">
                        
                        <div class="p-2 border-b border-slate-100 bg-white">
                            <div class="relative">
                                <input type="text" x-model="search" x-ref="searchInput" placeholder="Cari pasien..."
                                    class="w-full pl-3 pr-8 py-1.5 text-sm border border-slate-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <svg class="w-4 h-4 absolute right-2.5 top-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>

                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="option in filteredOptions" :key="option.id">
                                <li @click="formQueue.patient_id = option.id; open = false; search = ''"
                                    class="px-3.5 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition-colors"
                                    x-text="option.label">
                                </li>
                            </template>
                            <li x-show="filteredOptions.length === 0" class="px-3.5 py-3 text-sm text-slate-500 text-center">
                                Pasien tidak ditemukan
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div x-data="{
                    open: false,
                    search: '',
                    options: [
                        @foreach($doctors as $doctor)
                            { id: '{{ $doctor->id }}', label: '{{ addslashes($doctor->user->name ?? 'Anonim') }} - {{ addslashes($doctor->specialization) }}' },
                        @endforeach
                    ],
                    get filteredOptions() {
                        if (this.search === '') return this.options;
                        return this.options.filter(i => i.label.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    get selectedLabel() {
                        let selected = this.options.find(i => i.id == formQueue.doctor_id);
                        return selected ? selected.label : 'Pilih Dokter...';
                    }
                }" @click.outside="open = false" class="relative">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dokter Tujuan</label>
                    <button type="button" @click="open = !open" 
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-left focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 flex justify-between items-center"
                        :class="formQueue.doctor_id ? 'text-slate-800' : 'text-slate-400'">
                        <span x-text="selectedLabel" class="truncate"></span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" style="display: none;" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-2 border-b border-slate-100 bg-white">
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Cari dokter..." class="w-full pl-3 pr-8 py-1.5 text-sm border border-slate-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <svg class="w-4 h-4 absolute right-2.5 top-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="option in filteredOptions" :key="option.id">
                                <li @click="formQueue.doctor_id = option.id; open = false; search = ''" class="px-3.5 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition-colors" x-text="option.label"></li>
                            </template>
                            <li x-show="filteredOptions.length === 0" class="px-3.5 py-3 text-sm text-slate-500 text-center">Dokter tidak ditemukan</li>
                        </ul>
                    </div>
                </div>

                <div x-data="{
                    open: false,
                    search: '',
                    options: [
                        @foreach($clinics as $clinic)
                            { id: '{{ $clinic->id }}', label: '{{ addslashes($clinic->name) }}' },
                        @endforeach
                    ],
                    get filteredOptions() {
                        if (this.search === '') return this.options;
                        return this.options.filter(i => i.label.toLowerCase().includes(this.search.toLowerCase()));
                    },
                    get selectedLabel() {
                        let selected = this.options.find(i => i.id == formQueue.clinic_id);
                        return selected ? selected.label : 'Pilih Poliklinik...';
                    }
                }" @click.outside="open = false" class="relative">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Poliklinik</label>
                    <button type="button" @click="open = !open" 
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-left focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 flex justify-between items-center"
                        :class="formQueue.clinic_id ? 'text-slate-800' : 'text-slate-400'">
                        <span x-text="selectedLabel" class="truncate"></span>
                        <svg class="w-4 h-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    <div x-show="open" style="display: none;" class="absolute z-50 w-full mt-1 bg-white border border-slate-200 rounded-lg shadow-lg overflow-hidden">
                        <div class="p-2 border-b border-slate-100 bg-white">
                            <div class="relative">
                                <input type="text" x-model="search" placeholder="Cari poliklinik..." class="w-full pl-3 pr-8 py-1.5 text-sm border border-slate-300 rounded-md focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                                <svg class="w-4 h-4 absolute right-2.5 top-2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                            </div>
                        </div>
                        <ul class="max-h-48 overflow-y-auto py-1">
                            <template x-for="option in filteredOptions" :key="option.id">
                                <li @click="formQueue.clinic_id = option.id; open = false; search = ''" class="px-3.5 py-2 text-sm text-slate-700 hover:bg-blue-50 hover:text-blue-700 cursor-pointer transition-colors" x-text="option.label"></li>
                            </template>
                            <li x-show="filteredOptions.length === 0" class="px-3.5 py-3 text-sm text-slate-500 text-center">Poliklinik tidak ditemukan</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div x-data="{ 
                    minDatetime: '',
                    initMinDate() {
                        let now = new Date();
                        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
                        this.minDatetime = now.toISOString().slice(0, 16);
                    }
                }" x-init="initMinDate()">
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tgl / Jam</label>
                    <input type="datetime-local" x-model="formQueue.appointment_datetime" required
                        :min="minDatetime"
                        class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Awal</label>
                    <div class="relative">
                        <select x-model="formQueue.status" required
                            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all">
                            <option value="pending">Menunggu</option>
                            <option value="approved">Dalam Proses</option>
                            <option value="completed">Selesai</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Keluhan Pasien</label>
                <textarea x-model="formQueue.complaint" rows="2" placeholder="Masukkan keluhan pasien..." required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all resize-none"></textarea>
            </div>

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2 shrink-0">
                <button type="button" @click="openQueueModal = false"
                    class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">
                    Batal
                </button>
                <button type="submit"
                    class="px-5 py-2 text-xs font-semibold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
                    Simpan Antrian
                </button>
            </div>
        </form>
    </div>
</div>