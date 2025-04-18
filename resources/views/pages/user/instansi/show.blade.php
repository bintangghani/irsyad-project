@extends('layouts.master')

@section('title', $instansi->nama)

@section('content')
    <div class="container mx-auto px-4 py-10">
        <!-- Gambar Latar Belakang Instansi -->
        <div class="relative mb-6 rounded-lg overflow-hidden shadow-lg">
            <img src="{{ asset('storage/' . $instansi->background) }}" alt="Background Image"
                class="w-full h-80 object-cover object-center">
            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-30"></div>
        </div>

        <!-- Detail Instansi -->
        <div class="bg-white rounded-lg shadow-xl p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $instansi->profile) }}" alt="Profile Picture"
                    class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover">
            </div>

            <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">{{ $instansi->nama }}</h1>
            <p class="text-lg text-gray-600 text-center mb-4">{{ $instansi->alamat ?? 'Alamat tidak tersedia' }}</p>

            <div class="text-gray-700 mb-6">
                <h2 class="text-2xl font-medium text-gray-800 mb-3">Deskripsi Instansi</h2>
                <p class="text-base leading-relaxed">{{ $instansi->deskripsi ?? 'Deskripsi instansi belum tersedia.' }}</p>
            </div>
            <!-- Daftar Buku yang Berhubungan dengan Instansi -->
            <div class="mt-10">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">List Buku</h2>

                @if ($bukuInstansi->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach ($bukuInstansi as $buku)
                            <div class="flex gap-4">
                                <a href="{{ route('show', $buku->id_buku) }}" class="flex-shrink-0">
                                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                                        class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                                </a>
                                <div class="flex flex-col justify-between">
                                    <div>
                                        <a href="{{ route('show', $buku->id_buku) }}">
                                            <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                                {{ $buku->judul }}
                                            </h3>
                                        </a>
                                        <div class="text-xs text-[#333333] mt-1 flex items-center gap-0.5">
                                            <div class="flex flex-wrap items-center gap-1 text-xs">
                                                <a href="{{ route('category') }}?genre={{ urlencode($buku->subKelompok->kelompok->nama ?? '') }}"
                                                    class="text-[#696cff] font-medium hover:underline">
                                                    {{ $buku->subKelompok->kelompok->nama ?? 'Genre' }}
                                                </a>
                                                <a href="{{ route('category') }}?sub_category={{ $buku->subKelompok->id_sub_kelompok ?? '' }}"
                                                    class="text-[#696cff] font-medium hover:underline">
                                                    {{ $buku->subKelompok->nama ?? 'Sub Genre' }}
                                                </a>
                                            </div>
                                            <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                                <a href="{{ route('category') }}?jenis={{ $buku->jenisBuku->id_jenis ?? '' }}"
                                                    class="text-[#696cff] font-medium hover:underline">
                                                    {{ $buku->jenisBuku->nama ?? 'Jenis' }}
                                                </a>
                                                <a href="{{ route('category') }}?penerbit={{ urlencode($buku->penerbit ?? '') }}"
                                                    class="text-[#696cff] font-medium hover:underline">
                                                    {{ \Illuminate\Support\Str::words($buku->penerbit ?? $buku->uploaded->nama, 1, '...') }}
                                                </a>
                                            </div>
                                        </div>
                                        <p class="text-sm text-[#333333] mt-2 line-clamp-2">
                                            {{ \Illuminate\Support\Str::words($buku->deskripsi, 40, '...') }}
                                        </p>
                                    </div>
                                    <div class="text-xs text-[#3a4a5a99] mt-3">
                                        <span>{{ number_format($buku->total_read) }} views</span>
                                        <span
                                            class="ml-2 {{ $buku->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                            {{ ucfirst($buku->status) ?? 'Ongoing' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 mt-6">Belum ada buku yang terkait dengan instansi ini.</p>
                @endif
            </div>
        </div>

    </div>
@endsection
