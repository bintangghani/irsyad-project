@php
    use Illuminate\Support\Str;
@endphp

@extends('layouts.master')

@section('title', 'Kategori Buku')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Jelajahi Koleksi Buku Kami</h1>

            <form method="GET" id="filterForm" action="{{ route('category') }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="flex-1">
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Filter Genre</label>
                    <div class="relative">
                        <select id="genre" name="genre" onchange="this.form.submit()"
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white">
                            <option value="">Semua Genre</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre }}" {{ $selectedGenre === $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="flex-1">
                    <label for="jenisBuku" class="block text-sm font-medium text-gray-700 mb-1">Filter Jenis</label>
                    <div class="relative">
                        <select id="jenisBuku" name="jenisBuku" onchange="this.form.submit()"
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisList as $id => $nama)
                                <option value="{{ $id }}" {{ $selectedJenis === $id ? 'selected' : '' }}>
                                    {{ $nama }}</option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="sub_category" class="block text-sm font-medium text-gray-700 mb-1">Filter Sub Genre</label>
                    <div class="relative">
                        <select id="sub_category" name="sub_category" onchange="this.form.submit()"
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white">
                            <option value="">Semua Sub Genre</option>
                            @foreach ($subGenres as $id => $nama)
                                <option value="{{ $id }}" {{ $selectedSubCategory === $id ? 'selected' : '' }}>
                                    {{ ucfirst($nama) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="instansi" class="block text-sm font-medium text-gray-700 mb-1">Filter Instansi</label>
                    <div class="relative">
                        <select id="instansi" name="instansi" onchange="this.form.submit()"
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white">
                            <option value="">Semua Instansi</option>
                            @foreach ($instansis as $id => $nama)
                                <option value="{{ $id }}" {{ $selectedInstansi === $id ? 'selected' : '' }}>
                                    {{ $nama }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">Filter Penerbit</label>
                    <div class="relative">
                        <select id="penerbit" name="penerbit" onchange="this.form.submit()"
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white">
                            <option value="">Semua Penerbit</option>
                            @foreach ($penerbits as $penerbit)
                                <option value="{{ $penerbit }}"
                                    {{ $selectedPenerbit === $penerbit ? 'selected' : '' }}>
                                    {{ $penerbit }}
                                </option>
                            @endforeach

                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Cari Judul Buku</label>
                    <input type="text" id="search" name="search" value="{{ request('search') }}"
                        placeholder="Masukkan judul buku..." oninput="submitFormAfterDelay()"
                        class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white" />
                </div>


                @if ($selectedGenre || $selectedJenis)
                    <div class="flex items-end">
                        <a href="{{ route('category') }}"
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
        @if ($trendingBooks)
            <h2 class="text-2xl font-bold mb-4">Paling Banyak Dibaca</h2>
        @endif

        @if ($books->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach ($books as $book)
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
                                            class="text-[#696cff] font-medium">{{ $book->subKelompok->kelompok->nama ?? 'Genre' }}</span>
                                        <span
                                            class="text-[#696cff] font-medium">{{ $book->subKelompok->nama ?? 'Genre' }}</span>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                        <span
                                            class="text-[#696cff] font-medium">{{ $book->jenisBuku->nama ?? 'Genre' }}</span>
                                        <span>{{ \Illuminate\Support\Str::words($book->penerbit ?? $book->uploaded->nama, 1, '...') }}</span>
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
        @else
            <div class="text-center py-8 text-gray-500">
                @if ($selectedGenre || $selectedJenis || $selectedSubCategory || $selectedInstansi || $selectedPenerbit || $search)
                    <h2 class="text-2xl font-semibold mb-4 text-gray-800">
                        Menampilkan buku
                        @if ($selectedGenre)
                            dengan genre <span class="font-bold">{{ $selectedGenre }}</span>
                        @endif
                        @if ($selectedJenis)
                            {{ $selectedGenre ? ',' : '' }} jenis <span class="font-bold">{{ $selectedJenis }}</span>
                        @endif
                        @if ($selectedSubCategory)
                            {{ $selectedGenre || $selectedJenis ? ',' : '' }} sub genre <span
                                class="font-bold">{{ $selectedSubCategory }}</span>
                        @endif
                        @if ($selectedInstansi)
                            {{ $selectedGenre || $selectedJenis || $selectedSubCategory ? ',' : '' }} dari instansi <span
                                class="font-bold">{{ $selectedInstansi }}</span>
                        @endif
                        @if ($selectedPenerbit)
                            {{ $selectedGenre || $selectedJenis || $selectedSubCategory || $selectedInstansi ? ',' : '' }}
                            penerbit <span class="font-bold">{{ $selectedPenerbit }}</span>
                        @endif
                        @if ($search)
                            {{ $selectedGenre || $selectedJenis || $selectedSubCategory || $selectedInstansi || $selectedPenerbit ? ',' : '' }}
                            dengan pencarian judul "<span class="font-bold">{{ $search }}</span>"
                        @endif
                    </h2>
                    @foreach ($categories as $category)
                        @if ($category->filteredBooks->isNotEmpty())
                            <h3 class="text-lg font-bold text-[#696cff] mt-6 mb-2">{{ $category->nama }}</h3>

                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                                @foreach ($category->filteredBooks as $book)
                                    <div
                                        class="bg-white rounded-2xl p-4 shadow-sm hover:shadow-md transition-shadow duration-300">
                                        <a href="{{ route('dashboard.buku.create', $book->id) }}" class="flex gap-4">
                                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                                class="w-24 h-36 md:w-28 md:h-40 object-cover rounded-lg shadow">

                                            <div class="flex-1">
                                                <h3
                                                    class="text-base font-semibold text-gray-800 hover:text-[#696cff] transition-colors line-clamp-2">
                                                    {{ $book->judul }}
                                                </h3>

                                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-1">
                                                    <div class="flex flex-wrap items-center gap-1 text-xs">
                                                        {{-- bagian ini belum bisa menampilkan nama dari setiap kelompok sub_kelompok sama jenis karna yang tampil nya uuid --}}
                                                        <span
                                                            class="text-[#696cff] font-medium">{{ $book->kategori->nama ?? 'Genre' }}</span>
                                                        <span
                                                            class="text-[#696cff] font-medium">{{ $book->sub_kelompok->nama ?? 'Genre' }}</span>
                                                    </div>
                                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                                        <span
                                                            class="text-[#696cff] font-medium">{{ $book->jenis->nama ?? 'Genre' }}</span>
                                                        <span>{{ $book->penerbit ?? $book->uploaded->nama }}</span>
                                                    </div>
                                                </div>

                                                <p class="text-sm text-[#333333] mt-2 line-clamp-2">
                                                    {{ \Illuminate\Support\Str::words($book->deskripsi, 100, '...') }}
                                                </p>

                                                <div class="flex justify-between items-center mt-3 text-xs text-gray-400">
                                                    <span>{{ number_format($book->total_read) }} views</span>
                                                    <span
                                                        class="{{ $book->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                                        {{ ucfirst($book->status) ?? 'Ongoing' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    @endforeach
                @endif
            </div>
        @endif


    </div>
    <script>
        let typingTimer;
        const delay = 600;

        function submitFormAfterDelay() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(() => {
                document.getElementById('filterForm').submit();
            }, delay);
        }
    </script>
@endsection