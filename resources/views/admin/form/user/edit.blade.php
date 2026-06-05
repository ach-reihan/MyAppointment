<form @submit.prevent="alert('Role Akses Berhasil Diperbarui!'); openModal = false;" class="p-6 space-y-4">
    
    <div class="p-3 mb-4 rounded-lg bg-blue-50 border border-blue-100 flex items-start gap-3">
        <svg class="w-5 h-5 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <p class="text-xs text-blue-700">Kosongkan kolom password jika Anda tidak ingin mengubah password milik user ini.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Username</label>
            <input 
                type="text" 
                x-model="username"
                disabled
                class="w-full px-3.5 py-2 text-sm bg-slate-100 border border-slate-200 rounded-lg text-slate-500 focus:outline-none opacity-80 cursor-not-allowed"
            >
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Password Baru</label>
            <input 
                type="password" 
                x-model="password"
                placeholder="Isi untuk mereset sandi"
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
            >
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Role Akses</label>
        <div class="relative">
            <select 
                x-model="roleAkses"
                required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all"
            >
                <option value="Admin">Admin</option>
                <option value="Dokter">Dokter</option>
                <option value="Pasien">Pasien</option>
            </select>
            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
        </div>
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