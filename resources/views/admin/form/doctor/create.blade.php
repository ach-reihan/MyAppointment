<form @submit.prevent="saveData()" class="p-6 space-y-4">
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Nama Lengkap & Gelar</label>
            <input 
                type="text" 
                x-model="namaDokter"
                placeholder="Contoh: dr. Nama, Sp.X"
                required
                class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all"
            >
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Spesialisasi</label>
            <div class="relative">
                <select 
                    x-model="spesialisasi"
                    required
                    class="w-full px-3.5 py-2 text-sm bg-slate-50 border border-slate-200 rounded-lg text-slate-800 focus:outline-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 appearance-none transition-all"
                >
                    <option value="" disabled selected>Pilih Spesialisasi</option>
                    <option value="Umum">Umum</option>
                    <option value="Penyakit Dalam">Ortodentis</option>
                    <option value="Spesialis Anak">Spesialis Anak</option>
                    <option value="Bedah">Kardiolog</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3.5 text-slate-400">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <div>
        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2.5">Mapping Poliklinik (Multiple)</label>
        <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 grid grid-cols-2 md:grid-cols-3 gap-3">
            @php
                $poliklinikList = ['Poli Umum', 'Poli Anak', 'Poli Jantung', 'Poli Gigi', 'VIP'];
            @endphp
            
            @foreach($poliklinikList as $poli)
            <label class="flex items-center gap-2 cursor-pointer group">
                <input 
                    type="checkbox" 
                    value="{{ $poli }}" 
                    x-model="poliTugasan"
                    class="w-4 h-4 text-blue-600 bg-white border-slate-300 rounded focus:ring-blue-500 focus:ring-2"
                >
                <span class="text-xs font-medium text-slate-600 group-hover:text-slate-800 transition-colors">{{ $poli }}</span>
            </label>
            @endforeach
        </div>
    </div>

    <div class="mt-6 pt-4 border-t border-slate-100 flex items-center justify-end gap-2">
        <button type="button" @click="openModal = false" class="px-4 py-2 text-xs font-semibold text-slate-500 hover:bg-slate-50 rounded-xl transition-colors">
            Batal
        </button>
        <button type="submit" class="px-5 py-2 text-xs font-semibold bg-blue-600 text-white rounded-xl hover:bg-blue-700 transition-colors shadow-sm">
            Simpan Data
        </button>
    </div>
</form>