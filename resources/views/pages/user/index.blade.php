@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts/master')

@section('title', 'User')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <!-- Hero Banner -->
        <div
            class="relative w-full mx-auto bg-gradient-to-r from-[#111827] to-[#1E293B] text-white rounded-xl shadow-2xl overflow-hidden mb-12">
            <div class="container mx-auto px-6 py-12 md:py-16 lg:py-20 relative z-10">
                <div class="max-w-2xl">
                    <span class="text-[#696cff] font-semibold">Halo {{ $user->nama ?? 'Guest' }}!</span>
                    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mt-2 leading-tight">
                        Temukan Dunia Literasi di <span class="text-[#696cff]">Perpustakaan Digital</span> Kami
                    </h1>
                    <p class="mt-6 text-gray-300 text-base md:text-lg">
                        Jelajahi ribuan koleksi buku digital dan audiobook premium. Nikmati akses tanpa batas ke berbagai
                        bacaan menarik, mulai dari novel best-seller hingga konten edukasi eksklusif.
                    </p>
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <button
                            class="bg-[#696cff] hover:bg-[#5a5cff] text-white px-8 py-3 rounded-lg shadow-lg text-lg font-semibold transition-all transform hover:scale-105">
                            Mulai Membaca Sekarang
                        </button>
                        <button
                            class="bg-white/10 hover:bg-white/20 text-white px-8 py-3 rounded-lg border border-white/20 text-lg font-semibold transition-all">
                            Pelajari Lebih Lanjut
                        </button>
                    </div>
                </div>
            </div>
            <div
                class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80')] bg-cover bg-center opacity-10">
            </div>
        </div>
        <div class="mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Buku Populer</h2>
                <a href="/category"
                    class="text-[#696cff] hover:text-[#5a5cff] text-sm font-medium hover:underline flex items-center">
                    Lihat Semua <span class="ml-1">→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($trendingBooks as $book)
                    <div class="flex gap-4">
                        <a href="{{ route('dashboard.buku.create', $book->id) }}" class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                        </a>
                        <div class="flex flex-col justify-between">
                            <div>
                                <a href="{{ route('dashboard.buku.create', $book->id) }}">
                                    <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                        {{ $book->judul }}
                                    </h3>
                                </a>
                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-1">
                                    <div class="flex flex-wrap items-center gap-1 text-xs">
                                        {{-- bagian ini belum bisa menampilkan nama dari setiap kelompok sub_kelompok sama jenis karna yang tampil nya uuid --}}
                                        <span
                                            class="text-[#696cff] font-medium">{{ $book->kategori->nama ?? 'Genre' }}</span>
                                        <span
                                            class="text-[#696cff] font-medium">{{ $book->sub_kelompok->nama ?? 'Genre' }}</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                        <span class="text-[#696cff] font-medium">{{ $book->jenis->nama ?? 'Genre' }}</span>
                                        <span>{{ $book->uploaded->nama }}</span>
                                    </div>
                                </div>
                                <p class="text-sm text-[#333333] mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::words($book->deskripsi, 100, '...') }}
                                </p>
                            </div>
                            <div class="text-xs text-[#3a4a5a99] mt-3">
                                <span>{{ number_format($book->total_read) }} views</span>
                                <span
                                    class="ml-2 {{ $book->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                    {{ ucfirst($book->status) ?? 'Ongoing' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-gradient-to-r from-[#696cff] to-[#5a5cff] rounded-xl p-8 md:p-12 mb-16 text-white shadow-lg">
            <div class="max-w-4xl mx-auto text-center">
                <h2 class="text-2xl md:text-3xl font-bold mb-4">Mengapa Memilih Perpustakaan Kami?</h2>
                <p class="text-white/90 mb-8 text-lg">Kami menyediakan pengalaman membaca yang tak tertandingi dengan
                    koleksi buku terbaik dan fitur-fitur eksklusif.</p>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Koleksi Lengkap</h3>
                        <p class="text-white/80 text-sm">Ribuan buku dari berbagai genre tersedia untuk Anda.</p>
                    </div>

                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">Akses Cloud</h3>
                        <p class="text-white/80 text-sm">Baca di mana saja dengan penyimpanan cloud kami.</p>
                    </div>

                    <div class="bg-white/10 p-6 rounded-lg backdrop-blur-sm">
                        <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-4 mx-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                        </div>
                        <h3 class="font-semibold text-lg mb-2">100% Aman</h3>
                        <p class="text-white/80 text-sm">Data dan privasi Anda terlindungi dengan enkripsi terbaik.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-16">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Rilisan Terbaru</h2>
                <a href="/category"
                    class="text-[#696cff] hover:text-[#5a5cff] text-sm font-medium hover:underline flex items-center">
                    Lihat Semua <span class="ml-1">→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($newUploads as $book)
                    <div class="flex gap-4">
                        <a href="{{ route('dashboard.buku.create', $book->id) }}" class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                        </a>
                        <div class="flex flex-col justify-between">
                            <div>
                                <a href="{{ route('dashboard.buku.create', $book->id) }}">
                                    <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                        {{ $book->judul }}
                                    </h3>
                                </a>
                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-1">
                                    <span class="text-[#696cff] font-medium">{{ $book->kategori->nama ?? 'Genre' }}</span>
                                    <span>·</span>
                                    <span>{{ $book->uploaded->nama }}</span>
                                </div>
                                <p class="text-sm text-[#333333]  mt-2 line-clamp-2">
                                    {{ $book->deskripsi }}
                                </p>
                            </div>
                            <div class="text-xs text-[#3a4a5a99] mt-3">
                                <span>{{ number_format($book->total_read) }} views</span>
                                <span
                                    class="ml-2 {{ $book->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                    {{ ucfirst($book->status) ?? 'Ongoing' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row">
                <div class="md:w-1/2 bg-[#696cff] p-8 md:p-12 text-white">
                    <h2 class="text-2xl md:text-3xl font-bold mb-4">Bergabunglah dengan Komunitas Pembaca Kami</h2>
                    <p class="mb-6 text-white/90">Dapatkan akses eksklusif ke buku-buku terbaru, diskon spesial, dan konten
                        anggota hanya untuk Anda.</p>
                    <button
                        class="bg-white text-[#696cff] px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        Daftar Sekarang - Gratis!
                    </button>
                </div>
                <div class="md:w-1/2 bg-gray-50 p-8 md:p-12">
                    <h3 class="text-xl font-semibold mb-4 text-gray-800">Tetap Terhubung</h3>
                    <p class="text-gray-600 mb-6">Berlangganan newsletter kami untuk mendapatkan update buku terbaru
                        langsung ke email Anda.</p>
                    <div class="flex">
                        <input type="email" placeholder="Alamat email Anda"
                            class="flex-grow px-4 py-3 rounded-l-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent">
                        <button
                            class="bg-[#696cff] text-white px-6 py-3 rounded-r-lg font-medium hover:bg-[#5a5cff] transition">
                            Berlangganan
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
