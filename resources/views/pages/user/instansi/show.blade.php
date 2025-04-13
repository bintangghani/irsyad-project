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
                            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                                <!-- Sampul Buku -->
                                @if ($buku->sampul)
                                    <img src="{{ asset('storage/' . $buku->sampul) }}" alt="Sampul {{ $buku->judul }}"
                                        class="w-full h-48 object-cover">
                                @else
                                    <div
                                        class="w-full h-48 bg-gray-100 flex items-center justify-center text-gray-400 text-sm">
                                        No Image
                                    </div>
                                @endif

                                <!-- Konten Buku -->
                                <div class="p-4">
                                    <!-- Judul Buku -->
                                    <h3 class="text-lg font-semibold text-gray-800 mb-2">{{ $buku->judul }}</h3>

                                    <!-- Deskripsi Buku -->
                                    <p class="text-sm text-gray-500 mb-2">
                                        {{ $buku->deskripsi ?? 'Deskripsi buku belum tersedia' }}
                                    </p>

                                    <!-- Detail Buku -->
                                    <div class="space-y-2 mb-4">
                                        <p class="text-sm text-gray-600">
                                            Penerbit : {{ $buku->penerbit ?? 'Penerbit tidak diketahui' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Tahun Penerbit : {{ $buku->tahun_terbit ?? 'Tahun penerbit tidak diketahui' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Jumlah Halaman : {{ $buku->jumlah_halaman ?? 'Jumlah halaman tidak diketahui' }}
                                        </p>
                                    </div>

                                    <!-- Link untuk melihat detail buku -->
                                    <a href="{{ route('showBuku', $buku->id_buku) }}"
                                        class="text-blue-600 hover:underline text-sm mt-2">
                                        Lihat Detail Buku
                                    </a>
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
