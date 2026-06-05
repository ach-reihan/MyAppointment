<x-app-layout :title="'Manajemen Operasional – My Appointment'">
    <div x-data="{ 
        openHistory: false, 
        patientName: '',
        
        // State Modal Tambah
        openQueueModal: false,
        formQueue: { id: '', nama: '', dokter: '', poli: '', waktu: '', status: 'Menunggu' },

        // State Data & Pencarian
        searchQuery: '',
        queueList: {{ json_encode($queues) }},

        // ===== 1. FILTER PENCARIAN =====
        get filteredQueues() {
            if (this.searchQuery === '') return this.queueList;
            const term = this.searchQuery.toLowerCase();
            return this.queueList.filter(item => {
                return item.nama.toLowerCase().includes(term) || 
                       item.id.toLowerCase().includes(term) ||
                       item.dokter.toLowerCase().includes(term) ||
                       item.status.toLowerCase().includes(term);
            });
        },

        // ===== 2. KONFIGURASI PAGINASI (Berdasarkan Data Terfilter) =====
        currentPage: 1,
        itemsPerPage: 2, // Set 2 per halaman

        get totalPages() {
            return Math.ceil(this.filteredQueues.length / this.itemsPerPage) || 1;
        },

        get paginatedQueues() {
            let start = (this.currentPage - 1) * this.itemsPerPage;
            let end = start + this.itemsPerPage;
            return this.filteredQueues.slice(start, end);
        },

        // ===== 3. FUNGSI AKSI TABEL =====
        markAsDone(id) {
            let index = this.queueList.findIndex(item => item.id === id);
            if (index !== -1) {
                this.queueList[index].status = 'Selesai';
                this.queueList[index].color = 'emerald';
            }
        },

        deleteQueue(id) {
            if(confirm('Apakah Anda yakin ingin menghapus antrian ini?')) {
                this.queueList = this.queueList.filter(item => item.id !== id);
                // Cegah halaman kosong
                if (this.currentPage > this.totalPages) this.currentPage = this.totalPages;
            }
        },

        // ===== 4. FUNGSI MODAL TAMBAH DATA =====
        openNewPatientModal() {
            this.formQueue = {
                id: '#PX-' + Math.floor(Math.random() * 900000 + 100000),
                nama: '', dokter: '', poli: '', waktu: '', status: 'Menunggu'
            };
            this.openQueueModal = true;
        },

        saveNewQueue() {
            let initial = this.formQueue.nama.substring(0, 2).toUpperCase();
            if(initial.length === 0) initial = 'PX';

            let color = 'amber';
            if(this.formQueue.status === 'Proses') color = 'blue';
            if(this.formQueue.status === 'Selesai') color = 'emerald';

            this.queueList.unshift({
                id: this.formQueue.id, nama: this.formQueue.nama, initial: initial,
                dokter: this.formQueue.dokter, poli: this.formQueue.poli,
                waktu: this.formQueue.waktu, status: this.formQueue.status, color: color
            });
            
            this.openQueueModal = false;
            this.searchQuery = ''; // Reset pencarian jika ada
            this.currentPage = 1; // Kembali ke halaman pertama
        }
    }"
    @global-search.window="searchQuery = $event.detail; currentPage = 1" 
    >

        <div class="mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Operasional</h1>
                <p class="text-sm text-slate-500 mt-0.5">Kelola janji temu dan rekam medis harian hari ini.</p>
            </div>

            <button 
                @click="openNewPatientModal()"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition-colors shadow-sm w-full sm:w-auto"
            >
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                </svg>
                Pasien Baru
            </button>
        </div>

        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            @php
                $colorMap = [
                    'blue'    => 'border-b-blue-500',
                    'amber'   => 'border-b-amber-500',
                    'indigo'  => 'border-b-indigo-500',
                    'emerald' => 'border-b-emerald-500',
                ];
            @endphp
            @foreach($stats as $stat)
            <div class="bg-white rounded-2xl p-5 border border-slate-100 shadow-sm border-b-4 {{ $colorMap[$stat['color']] }}">
                <p class="text-xs font-semibold text-slate-500 mb-2">{{ $stat['label'] }}</p>
                <p class="text-3xl font-extrabold text-slate-800">{{ $stat['value'] }}</p>
                <p class="text-[11px] text-slate-400 mt-2">{{ $stat['desc'] }}</p>
            </div>
            @endforeach
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden flex flex-col">
            <div class="p-5 flex items-center justify-between border-b border-slate-100">
                <h2 class="text-sm font-bold text-slate-800">Jadwal Janji Temu Hari Ini</h2>
                <div class="flex gap-2">
                    <button class="p-1.5 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                    </button>
                    <button class="p-1.5 border border-slate-200 rounded-lg text-slate-500 hover:bg-slate-50">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                    </button>
                </div>
            </div>

            <div class="overflow-x-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100">
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider">ID Pasien</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider">Nama Pasien</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider">Dokter Tujuan</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider">Poli</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider">Tanggal/Jam</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider text-center">Status</th>
                            <th class="px-5 py-3 text-[11px] font-bold text-slate-400 tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        
                        <template x-for="q in paginatedQueues" :key="q.id">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-5 py-4 text-xs font-semibold text-slate-500" x-text="q.id"></td>
                                <td class="px-5 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="w-7 h-7 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 font-bold text-[10px]" x-text="q.initial"></div>
                                        <span class="text-xs font-bold text-slate-700" x-text="q.nama"></span>
                                    </div>
                                </td>
                                <td class="px-5 py-4 text-xs text-slate-600" x-text="q.dokter"></td>
                                <td class="px-5 py-4 text-xs text-slate-600" x-text="q.poli"></td>
                                <td class="px-5 py-4 text-xs text-slate-500 whitespace-pre-line leading-tight" x-text="q.waktu.replace(', ', '\n')"></td>
                                
                                <td class="px-5 py-4 text-center">
                                    <span 
                                        class="px-3 py-1 text-[10px] font-bold rounded-full border inline-block w-full max-w-[80px]"
                                        :class="{
                                            'bg-amber-100/50 text-amber-600 border-amber-100': q.color === 'amber',
                                            'bg-blue-100/50 text-blue-600 border-blue-100': q.color === 'blue',
                                            'bg-emerald-100/50 text-emerald-600 border-emerald-100': q.color === 'emerald',
                                            'bg-slate-100 text-slate-600 border-slate-200': !['amber', 'blue', 'emerald'].includes(q.color)
                                        }"
                                        x-text="q.status"
                                    ></span>
                                </td>

                                <td class="px-5 py-4 text-right">
                                    <div class="inline-flex items-center justify-end gap-1 w-full">
                                        
                                        <button 
                                            x-show="q.status !== 'Selesai'" 
                                            @click="markAsDone(q.id)" 
                                            class="p-1.5 text-slate-400 hover:text-emerald-600 hover:bg-emerald-50 rounded transition-colors" 
                                            title="Selesaikan"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                                        </button>
                                        
                                        <button 
                                            @click="openHistory = true; patientName = q.nama" 
                                            class="p-1.5 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded transition-colors" 
                                            title="Rekam Medis"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                        </button>
                                        
                                        <button 
                                            @click="deleteQueue(q.id)" 
                                            class="p-1.5 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded transition-colors" 
                                            title="Batalkan/Hapus"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                        </button>

                                    </div>
                                </td>
                            </tr>
                        </template>

                        <tr x-show="filteredQueues.length === 0" style="display: none;">
                            <td colspan="7" class="px-5 py-10 text-center text-slate-400 text-sm">
                                Tidak ada data yang ditemukan.
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
            
            <div class="px-5 py-4 border-t border-slate-100 flex items-center justify-between">
                
                <span class="text-xs text-slate-500">
                    Menampilkan <span x-text="filteredQueues.length > 0 ? ((currentPage - 1) * itemsPerPage + 1) : 0"></span> 
                    - <span x-text="Math.min(currentPage * itemsPerPage, filteredQueues.length)"></span> 
                    dari <span x-text="filteredQueues.length"></span> janji temu
                </span>
                
                <div class="flex gap-1" x-show="totalPages > 1">
                    <button 
                        @click="if(currentPage > 1) currentPage--"
                        :disabled="currentPage === 1"
                        :class="currentPage === 1 ? 'opacity-50 cursor-not-allowed text-slate-400' : 'text-slate-500 hover:bg-slate-50'"
                        class="px-3 py-1 text-xs font-semibold rounded transition-colors">
                        Sebelumnya
                    </button>
                    
                    <template x-for="page in totalPages" :key="page">
                        <button 
                            @click="currentPage = page"
                            :class="currentPage === page ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-50'"
                            class="w-6 h-6 flex items-center justify-center text-xs font-semibold rounded-full transition-colors"
                            x-text="page">
                        </button>
                    </template>
                    
                    <button 
                        @click="if(currentPage < totalPages) currentPage++"
                        :disabled="currentPage === totalPages"
                        :class="currentPage === totalPages ? 'opacity-50 cursor-not-allowed text-blue-300' : 'text-blue-600 hover:bg-blue-50'"
                        class="px-3 py-1 text-xs font-semibold rounded transition-colors">
                        Berikutnya
                    </button>
                </div>
            </div>
        </div>
        
        @include('admin.operational.partials.queue-form')
        @include('admin.operational.partials.history-sidebar')

    </div>
</x-app-layout>