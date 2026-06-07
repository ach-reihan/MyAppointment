<div x-show="openQueueModal" class="fixed inset-0 z-50 flex items-center justify-center p-4" style="display: none;">

    <div x-show="openQueueModal" x-transition.opacity.duration.200ms @click="openQueueModal = false"
        class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm"></div>

    <div x-show="openQueueModal" x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="bg-white rounded-2xl shadow-xl border border-slate-100 w-full max-w-lg overflow-hidden z-10 relative">
        <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
            <h3 class="text-base font-bold text-slate-800">Tambah Antrian Pasien</h3>
            <button @click="openQueueModal = false"
                class="text-slate-400 hover:text-slate-600 rounded-lg p-1.5 hover:bg-slate-50 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <form @submit.prevent="saveNewQueue()" class="p-6 space-y-4">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ID
                        Antrian</label>
                    <input type="text" x-model="formQueue.id" disabled
                        class="w-full px-3.5 py-2 text-sm bg-slate-100 border border-slate-200 rounded-lg text-slate-500 font-semibold focus:outline-none cursor-not-allowed opacity-80">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Pasien</label>
                    <div class="relative">
                        <select x-model="formQueue.patient_id" required
                            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all">
                            <option value="" disabled selected>Pilih Pasien</option>
                            @foreach($patients as $patient)
                                <option value="{{ $patient->id }}">{{ $patient->user->name ?? 'Anonim' }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Dokter Tujuan</label>
                    <div class="relative">
                        <select x-model="formQueue.doctor_id" required
                            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all">
                            <option value="" disabled selected>Pilih Dokter</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->user->name ?? 'Anonim' }} - {{ $doctor->specialization }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Poliklinik</label>
                    <div class="relative">
                        <select x-model="formQueue.clinic_id" required
                            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all">
                            <option value="" disabled selected>Pilih Poliklinik</option>
                            @foreach($clinics as $clinic)
                                <option value="{{ $clinic->id }}">{{ $clinic->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tgl / Jam</label>
                    <input type="datetime-local" x-model="formQueue.appointment_datetime" required
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

            <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
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