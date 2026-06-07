<x-app-layout :title="'Data Pasien – My Appointment'">

    <div x-data="{ 
        openModal: false, 
        isEdit: false,
        modalTitle: 'Tambah Data Pasien',
        idPasien: '',
        namaLengkap: '',
        noTelepon: '',
        tglLahir: '',
        alamat: '',

        // Data & Pencarian
        searchQuery: '',
        patientList: {{ json_encode($patients) }},
        openDeleteModal: false,
        deletingId: '',

        get filteredPatients() {
            if (this.searchQuery === '') return this.patientList;
            const term = this.searchQuery.toLowerCase();
            return this.patientList.filter(pat => {
                return pat.nama.toLowerCase().includes(term) || 
                       pat.no_telepon.toLowerCase().includes(term) ||
                       pat.id.toLowerCase().includes(term) ||
                       pat.alamat.toLowerCase().includes(term);
            });
        },

        async saveData() {
            const url = this.isEdit 
                ? `/admin/master-data/patients/${this.idPasien}` 
                : '/admin/master-data/patients';
            
            const method = this.isEdit ? 'PUT' : 'POST';
            
            const payload = {
                name: this.namaLengkap,
                phone_number: this.noTelepon,
                date_of_birth: this.tglLahir,
                address: this.alamat
            };
            
            try {
                const response = await fetch(url, {
                    method: method,
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(payload)
                });
                
                const result = await response.json();
                if (response.ok && result.success) {
                    window.location.reload();
                } else {
                    const message = result.message || 'Terjadi kesalahan saat menyimpan data.';
                    const errors = result.errors ? Object.values(result.errors).flat().join('\n') : '';
                    alert(message + (errors ? '\n\n' + errors : ''));
                }
            } catch (error) {
                console.error(error);
                alert('Gagal menghubungi server.');
            }
        },

        triggerDelete(id) {
            this.deletingId = id;
            this.openDeleteModal = true;
        },

        async confirmDelete() {
            this.openDeleteModal = false;
            try {
                const response = await fetch(`/admin/master-data/patients/${this.deletingId}`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });
                
                const result = await response.json();
                if (response.ok && result.success) {
                    window.location.reload();
                } else {
                    alert(result.message || 'Gagal menghapus pasien.');
                }
            } catch (error) {
                console.error(error);
                alert('Gagal menghubungi server.');
            }
        }
    }"
    @global-search.window="searchQuery = $event.detail"
    >

        <div class="mb-6">
            <h1 class="text-xl font-bold text-slate-800 tracking-tight">Master Data Management</h1>
            <p class="text-sm text-slate-500 mt-0.5">Kelola informasi fundamental rumah sakit dalam satu dasbor terpusat.</p>
        </div>

        <div class="flex flex-wrap gap-2 mb-6 bg-slate-100 p-1.5 rounded-xl w-max border border-slate-200/60">
            <a href="{{ route('admin.master-data.users') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Manajemen User
            </a>
            <a href="{{ route('admin.master-data.doctors') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Data Dokter
            </a>
            <a href="{{ route('admin.master-data.patients') }}" class="px-4 py-2 text-xs font-semibold rounded-lg bg-white text-blue-600 shadow-sm transition-all">
                Data Pasien
            </a>
            <a href="{{ route('admin.master-data.polyclinics') }}" class="px-4 py-2 text-xs font-semibold rounded-lg text-slate-600 hover:text-slate-900 transition-colors">
                Data Poliklinik
            </a>
        </div>

        <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
            <div class="p-5 flex items-center justify-between border-b border-slate-100 flex-wrap gap-4">
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Daftar Pasien Terdaftar</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Total terdapat {{ count($patients) }} pasien terdaftar</p>
                </div>
                <button 
                    @click="openModal = true; isEdit = false; modalTitle = 'Tambah Pasien Baru'; idPasien = ''; namaLengkap = ''; noTelepon = ''; tglLahir = ''; alamat = ''" 
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-blue-600 text-white rounded-xl text-xs font-semibold hover:bg-blue-700 transition-colors shadow-sm"
                >
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Tambah Pasien
                </button>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50/70 border-b border-slate-100">
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider">ID PASIEN</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider">NAMA LENGKAP</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider">NO. TELEPON</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider">TGL. LAHIR</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider">ALAMAT</th>
                            <th class="px-6 py-3.5 text-xs font-bold text-slate-400 tracking-wider text-right">AKSI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        <template x-for="pasien in filteredPatients" :key="pasien.id">
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="px-6 py-4 text-xs font-semibold text-slate-500" x-text="pasien.id"></td>
                                <td class="px-6 py-4 text-xs font-bold text-slate-700" x-text="pasien.nama"></td>
                                <td class="px-6 py-4 text-xs font-medium text-slate-600" x-text="pasien.no_telepon"></td>
                                <td class="px-6 py-4 text-xs text-slate-600" x-text="pasien.tgl_lahir"></td>
                                <td class="px-6 py-4 text-xs text-slate-500 truncate max-w-[200px]" :title="pasien.alamat" x-text="pasien.alamat"></td>
                                <td class="px-6 py-4 text-xs text-right">
                                    <div class="inline-flex items-center gap-2">
                                        <button 
                                            @click="openModal = true; isEdit = true; modalTitle = 'Edit Data Pasien'; idPasien = pasien.id; namaLengkap = pasien.nama; noTelepon = pasien.no_telepon; tglLahir = pasien.tgl_lahir; alamat = pasien.alamat"
                                            class="p-2 text-slate-400 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all"
                                            title="Edit Pasien"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <button 
                                            @click="triggerDelete(pasien.id)"
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-all"
                                            title="Hapus"
                                        >
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="filteredPatients.length === 0" style="display: none;">
                            <td colspan="6" class="px-6 py-8 text-center text-slate-400 text-sm">Tidak ada data ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
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
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>

                <div x-show="!isEdit">
                    @include('admin.form.patient.create')
                </div>
                <div x-show="isEdit" style="display: none;">
                    @include('admin.form.patient.edit')
                </div>
            </div>
        </div>
        <div x-show="openDeleteModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;" x-cloak>
            <div x-show="openDeleteModal" x-transition.opacity.duration.200ms @click="openDeleteModal = false" class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

            <div 
                x-show="openDeleteModal"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-95"
                class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-md overflow-hidden z-10 relative"
            >
                <div class="p-6 text-center">
                    <div class="w-12 h-12 rounded-full bg-red-50 text-red-600 flex items-center justify-center mx-auto mb-4 border border-red-100">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-4v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-slate-800 mb-2">Konfirmasi Hapus</h3>
                    <p class="text-xs text-slate-500 leading-relaxed mb-6">Apakah Anda yakin ingin menghapus data pasien ini? Tindakan ini tidak dapat dibatalkan.</p>
                    <div class="flex items-center justify-center gap-3">
                        <button type="button" @click="openDeleteModal = false" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors border border-slate-200/60">
                            Batal
                        </button>
                        <button type="button" @click="confirmDelete()" class="px-5 py-2 text-xs font-semibold bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors shadow-sm">
                            Ya, Hapus
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>