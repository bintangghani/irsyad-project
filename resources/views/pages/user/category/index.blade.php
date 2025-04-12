@extends('layouts.master')

@section('title', 'Kategori Buku')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-6">Jelajahi Koleksi Buku Kami</h1>
            
            <form method="GET" action="{{ route('category') }}" class="flex flex-col md:flex-row gap-4">
                <div class="flex-1">
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-1">Filter Genre</label>
                    <div class="relative">
                        <select 
                            id="genre" 
                            name="genre" 
                            onchange="this.form.submit()" 
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white"
                        >
                            <option value="">Semua Genre</option>
                            @foreach ($genres as $genre)
                                <option value="{{ $genre }}" {{ $selectedGenre === $genre ? 'selected' : '' }}>
                                    {{ $genre }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="flex-1">
                    <label for="jenis" class="block text-sm font-medium text-gray-700 mb-1">Filter Jenis</label>
                    <div class="relative">
                        <select 
                            id="jenis" 
                            name="jenis" 
                            onchange="this.form.submit()" 
                            class="block w-full pl-4 pr-10 py-3 text-base border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#696cff] focus:border-transparent rounded-lg appearance-none bg-white"
                        >
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisList as $id => $nama)
                                <option value="{{ $id }}" {{ $selectedJenis === $id ? 'selected' : '' }}>
                                    {{ ucfirst($nama) }}
                                </option>
                            @endforeach
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                @if ($selectedGenre || $selectedJenis)
                    <div class="flex items-end">
                        <a 
                            href="{{ route('category') }}" 
                            class="px-4 py-3 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-lg transition-colors flex items-center"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4 2a1 1 0 011 1v2.101a7.002 7.002 0 0111.601 2.566 1 1 0 11-1.885.666A5.002 5.002 0 005.999 7H9a1 1 0 010 2H4a1 1 0 01-1-1V3a1 1 0 011-1zm.008 9.057a1 1 0 011.276.61A5.002 5.002 0 0014.001 13H11a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0v-2.101a7.002 7.002 0 01-11.601-2.566 1 1 0 01.61-1.276z" clip-rule="evenodd" />
                            </svg>
                            Reset
                        </a>
                    </div>
                @endif
            </form>
        </div>
        <div class="space-y-10">
            @foreach ($categories as $category)
                @if ($selectedGenre && $category->nama !== $selectedGenre)
                    @continue
                @endif

                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <div class="flex justify-between items-center">
                            <h2 class="text-xl md:text-2xl font-bold text-gray-800">{{ $category->nama }}</h2>
                            @if (!$selectedGenre && $category->filteredBooks->count() > 6)
                                <a 
                                    href="{{ route('category', ['genre' => $category->nama]) }}" 
                                    class="text-[#696cff] hover:text-[#5a5cff] text-sm font-medium hover:underline flex items-center"
                                >
                                    Lihat Semua <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        @php
                            $booksToShow = $selectedGenre ? $category->filteredBooks : $category->filteredBooks->take(6);
                        @endphp

                        @if($booksToShow->count() > 0)
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                @foreach ($booksToShow as $book)
                                    <div class="bg-gray-50 rounded-lg p-4 hover:shadow-md transition-shadow">
                                        <a href="{{ route('dashboard.buku.create', $book->id) }}" class="block">
                                            <div class="flex gap-4">
                                                <img 
                                                    src="{{ asset('storage/' . $book->sampul) }}" 
                                                    alt="{{ $book->judul }}"
                                                    class="w-24 h-36 md:w-28 md:h-40 object-cover rounded-lg shadow"
                                                >
                                                <div class="flex-1">
                                                    <h3 class="text-lg font-semibold text-gray-800 hover:text-[#696cff] transition-colors">
                                                        {{ $book->judul }}
                                                    </h3>
                                                    <div class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                        <span class="text-[#696cff] font-medium">{{ $book->kategori->nama ?? 'Genre' }}</span>
                                                        <span>•</span>
                                                        <span>{{ $book->uploaded->nama }}</span>
                                                    </div>
                                                    <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                                                        {{ $book->deskripsi }}
                                                    </p>
                                                    <div class="flex justify-between items-center mt-3 text-xs text-gray-400">
                                                        <span>{{ number_format($book->total_read) }} views</span>
                                                        <span class="{{ $book->status === 'Completed' ? 'text-green-600' : 'text-yellow-600' }} font-semibold">
                                                            {{ ucfirst($book->status) ?? 'Ongoing' }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                                <p class="mt-2 text-gray-500">Tidak ada buku yang ditemukan</p>
                                @if ($selectedGenre || $selectedJenis)
                                    <a href="{{ route('category') }}" class="mt-2 inline-block text-[#696cff] hover:underline">Reset filter</a>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection