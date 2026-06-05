@extends('components.guest-layout')

@section('content')
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-24">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
            <div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900 leading-tight mb-6">
                    Solusi Kesehatan Digital Masa Depan
                </h1>
                <p class="text-lg text-gray-600 mb-8 max-w-lg">
                    Nikmati pengalaman layanan medis masa depan yang lebih cepat,
                    terintegrasi, dan mudah diakses melalui perangkat Anda.
                </p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <a href="{{ route('login') }}"
                        class="bg-blue-600 text-white text-center px-8 py-3 rounded-full font-semibold hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                        Mulai Sekarang
                    </a>
                    <a href="#layanan"
                        class="bg-gray-100 text-gray-700 text-center px-8 py-3 rounded-full font-semibold hover:bg-gray-200 transition">
                        Pelajari Lebih Lanjut
                    </a>
                </div>
            </div>

            <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-200 aspect-video md:aspect-[4/3]">

                <img src="{{ asset('assets/images/wifeye.png') }}" alt="Gambar" class="w-full h-full object-cover">

            </div>
        </div>
    </section>

    <section id="layanan" class="bg-white py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold text-gray-900 mb-12">Layanan Unggulan Kami</h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-left">
                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Registrasi Mudah</h3>
                    <p class="text-gray-600">Daftar dan kelola janji temu dengan dokter spesialis pilihan Anda tanpa antrean
                        panjang secara konvensional.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Dokter Spesialis</h3>
                    <p class="text-gray-600">Akses langsung ke berbagai spesialis kesehatan berpengalaman di bidangnya
                        masing-masing.</p>
                </div>

                <div class="p-6 bg-gray-50 rounded-2xl border border-gray-100 hover:shadow-lg transition">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Rekam Medis Terintegrasi</h3>
                    <p class="text-gray-600">Jejak riwayat medis, diagnosis, dan resep tersimpan aman dan dapat diakses
                        dengan mudah oleh Anda.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-20">
        <div class="bg-blue-600 rounded-3xl p-10 md:p-16 text-white text-center shadow-2xl">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 divide-x-0 md:divide-x divide-blue-400">
                <div class="flex flex-col items-center">
                    <h4 class="text-4xl md:text-5xl font-bold mb-2">500+</h4>
                    <p class="text-blue-100 font-medium">Dokter Spesialis</p>
                </div>
                <div class="flex flex-col items-center">
                    <h4 class="text-4xl md:text-5xl font-bold mb-2">10k+</h4>
                    <p class="text-blue-100 font-medium">Pasien Aktif</p>
                </div>
                <div class="flex flex-col items-center">
                    <h4 class="text-4xl md:text-5xl font-bold mb-2">2M+</h4>
                    <p class="text-blue-100 font-medium">Konsultasi</p>
                </div>
                <div class="flex flex-col items-center">
                    <h4 class="text-4xl md:text-5xl font-bold mb-2">99%</h4>
                    <p class="text-blue-100 font-medium">Tingkat Kepuasan</p>
                </div>
            </div>
        </div>
    </section>
@endsection
