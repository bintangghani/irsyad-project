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
                    <div class="mt-8 flex flex-col sm:flex-row gap-4">
                        <a href="/category"
                            class="bg-[#696cff] hover:bg-[#5a5cff] text-white px-8 py-3 rounded-lg shadow-lg text-lg font-semibold transition-all transform hover:scale-105">
                            Mulai Membaca Sekarang
                        </a>

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
                        <a href="{{ route('show', $book->id_buku) }}" class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                        </a>
                        <div class="flex flex-col justify-between">
                            <div>
                                <a href="{{ route('show', $book->id_buku) }}">
                                    <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                        {{ $book->judul }}
                                    </h3>
                                </a>
                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-0.5">
                                    <div class="flex flex-wrap items-center gap-1 text-xs">
                                        <a href="{{ route('category') }}?genre={{ urlencode($book->subKelompok->kelompok->nama ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->kelompok->nama ?? 'Genre' }}
                                        </a>
                                        <a href="{{ route('category') }}?sub_category={{ $book->subKelompok->id_sub_kelompok ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->nama ?? 'Sub Genre' }}
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                        <a href="{{ route('category') }}?jenis={{ $book->jenisBuku->id_jenis ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->jenisBuku->nama ?? 'Jenis' }}
                                        </a>
                                        <a href="{{ route('category') }}?penerbit={{ urlencode($book->penerbit ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ \Illuminate\Support\Str::words($book->penerbit ?? $book->uploaded->nama, 1, '...') }}
                                        </a>
                                    </div>
                                </div>
                                <p class="text-sm text-[#333333] mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::words($book->deskripsi, 40, '...') }}
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
                        <a href="{{ route('show', $book->id_buku) }}" class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                        </a>
                        <div class="flex flex-col justify-between">
                            <div>
                                <a href="{{ route('show', $book->id_buku) }}">
                                    <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                        {{ $book->judul }}
                                    </h3>
                                </a>
                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-0.5">
                                    <div class="flex flex-wrap items-center gap-1 text-xs">
                                        <a href="{{ route('category') }}?genre={{ urlencode($book->subKelompok->kelompok->nama ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->kelompok->nama ?? 'Genre' }}
                                        </a>
                                        <a href="{{ route('category') }}?sub_category={{ $book->subKelompok->id_sub_kelompok ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->nama ?? 'Sub Genre' }}
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                        <a href="{{ route('category') }}?jenis={{ $book->jenisBuku->id_jenis ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->jenisBuku->nama ?? 'Jenis' }}
                                        </a>
                                        <a href="{{ route('category') }}?penerbit={{ urlencode($book->penerbit ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ \Illuminate\Support\Str::words($book->penerbit ?? $book->uploaded->nama, 1, '...') }}
                                        </a>
                                    </div>
                                </div>
                                <p class="text-sm text-[#333333] mt-2 line-clamp-2">
                                    {{ \Illuminate\Support\Str::words($book->deskripsi, 40, '...') }}
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

    </div>
@endsection
