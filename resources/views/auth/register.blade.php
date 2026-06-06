<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Pasien - My Appointment</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen py-10 font-sans antialiased">

    <div class="w-full max-w-2xl p-4 sm:p-6">
        
        <div class="bg-white rounded-3xl shadow-xl shadow-gray-200/50 p-6 sm:p-10 border border-gray-100">
            
            <div class="text-center mb-10">
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Daftar Akun Baru</h1>
                <p class="text-sm text-gray-500">Silakan lengkapi data diri Anda untuk memulai perjalanan kesehatan presisi.</p>
            </div>

            <form action="{{ route('register.process') }}" method="POST" class="space-y-8">
                @csrf
                
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 text-red-600 p-4 rounded-xl text-sm font-medium border border-red-100">
                        Pendaftaran gagal. Silakan periksa kembali data yang Anda masukkan.
                    </div>
                @endif

                <div>
                    <h2 class="flex items-center gap-2 text-sm font-bold text-blue-600 mb-5 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Informasi Akun
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Email</label>
                            <input type="email" name="email" required placeholder="nama@email.com" value="{{ old('email') }}"
                                class="w-full px-4 py-3 bg-gray-50 border @error('email') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all">
                            @error('email')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Username</label>
                            <input type="text" name="username" required placeholder="username_anda" value="{{ old('username') }}"
                                class="w-full px-4 py-3 bg-gray-50 border @error('username') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all">
                            @error('username')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Kata Sandi</label>
                            <input type="password" name="password" required placeholder="********" 
                                class="w-full px-4 py-3 bg-gray-50 border @error('password') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all">
                            @error('password')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Konfirmasi Sandi</label>
                            <input type="password" name="password_confirmation" required placeholder="********" 
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="flex items-center gap-2 text-sm font-bold text-blue-600 mb-5 pb-2 border-b border-gray-100">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" /></svg>
                        Biodata Pasien
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" required placeholder="Sesuai KTP" value="{{ old('name') }}"
                                class="w-full px-4 py-3 bg-gray-50 border @error('name') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all">
                            @error('name')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Nomor Telepon</label>
                            <input type="tel" name="phone_number" required placeholder="08xx xxxx xxxx" value="{{ old('phone_number') }}"
                                class="w-full px-4 py-3 bg-gray-50 border @error('phone_number') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all">
                            @error('phone_number')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Tanggal Lahir</label>
                            <input type="date" name="date_of_birth" required value="{{ old('date_of_birth') }}"
                                class="w-full px-4 py-3 bg-gray-50 border @error('date_of_birth') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm text-gray-700 outline-none transition-all">
                            @error('date_of_birth')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-[11px] font-bold text-gray-500 uppercase tracking-wider mb-2">Alamat Domisili</label>
                            <textarea name="address" required rows="3" placeholder="Tuliskan alamat lengkap..." 
                                class="w-full px-4 py-3 bg-gray-50 border @error('address') border-red-300 focus:ring-red-500/20 focus:border-red-500 @else border-gray-200 focus:ring-blue-500/20 focus:border-blue-500 @enderror rounded-xl text-sm outline-none transition-all resize-none">{{ old('address') }}</textarea>
                            @error('address')
                                <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/20 flex justify-center items-center gap-2">
                        Daftar Akun Baru
                    </button>
                </div>
            </form>

            <div class="mt-8 text-center">
                <p class="text-sm text-gray-500">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-bold text-blue-600 hover:underline">Masuk di sini</a>
                </p>
            </div>

        </div>
    </div>

</body>
</html>