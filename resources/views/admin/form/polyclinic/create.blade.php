<form @submit.prevent="saveData()" class="p-6 space-y-4">
    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Poliklinik</label>
        <input 
            type="text" 
            x-model="namaPoli"
            placeholder="Contoh: Poli Mata"
            required
            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
        >
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Deskripsi Layanan</label>
        <textarea x-model="deskripsi" rows="3" placeholder="Jelaskan layanan yang tersedia pada poliklinik ini..."
            required
            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all resize-none"></textarea>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Status Operasional</label>
        <div class="relative">
            <select x-model="statusPoli" required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all">
                <option value="AKTIF">AKTIF</option>
                <option value="NON-AKTIF">NON-AKTIF</option>
                <option value="MAINTENANCE">MAINTENANCE</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </div>
        </div>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
        <button type="button" @click="openModal = false"
            class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">
            Batal
        </button>
        <button type="submit"
            class="px-5 py-2 text-xs font-semibold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
            Simpan Data
        </button>
    </div>
</form>
