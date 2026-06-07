<form @submit.prevent="saveData()" class="p-6 space-y-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">ID Pasien</label>
            <input 
                type="text" 
                x-model="idPasien"
                disabled
                class="w-full px-3.5 py-2 text-sm bg-slate-100 border border-slate-200 rounded-lg text-slate-500 font-semibold focus:outline-none cursor-not-allowed opacity-80"
            >
            <p class="text-[10px] text-slate-400 mt-1">ID tidak dapat diubah.</p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap</label>
            <input 
                type="text" 
                x-model="namaLengkap"
                placeholder="Contoh: Budi Santoso"
                required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
            >
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">No. Telepon</label>
            <input 
                type="tel" 
                x-model="noTelepon"
                @input="noTelepon = noTelepon.replace(/[^0-9+\-\s]/g, '')"
                placeholder="Contoh: 0812-..."
                required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
            >
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Tanggal Lahir</label>
            <input 
                type="text" 
                x-model="tglLahir"
                placeholder="Contoh: 12 Mei 1985"
                required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
            >
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Lengkap</label>
        <textarea 
            x-model="alamat"
            rows="3"
            placeholder="Masukkan alamat lengkap domisili"
            required
            class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all resize-none"
        ></textarea>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
        <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">
            Batal
        </button>
        <button type="submit" class="px-5 py-2 text-xs font-semibold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
            Simpan Perubahan
        </button>
    </div>
</form>