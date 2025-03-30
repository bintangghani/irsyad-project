@extends('layouts.master')

@section('title', 'Bookmarks')

@section('content')
<div class="container mt-5">
    <h1 class="text-2xl font-bold mb-4">Bookmarks</h1>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse ($bookmark as $bookmarks)
            <div class="bg-white shadow-lg rounded-xl overflow-hidden">
                <img src="{{ asset($bookmarks->buku->sampul) }}" alt="{{ $bookmarks->buku->judul }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $bookmarks->buku->judul }}</h3>
                    <p class="text-sm text-gray-500">By {{ $bookmarks->buku->penulis }}</p>
                    
                    <div class="mt-4 flex items-center space-x-2">
                        <!-- Tombol Read Now -->
                        <a href="{{ route('dashboard.buku.show', $bookmarks->buku->id_buku) }}"
                            class="flex-1 text-center text-white bg-gradient-to-r from-blue-500 to-indigo-500 hover:from-blue-600 hover:to-indigo-600 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 transition duration-300 ease-in-out">
                            Read Now
                        </a>

                        <!-- Tombol Remove -->
                        <form action="{{ route('dashboard.bookmarks.destroy', $bookmarks->id_bookmarks) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="text-white bg-red-500 hover:bg-red-900 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-xs px-3 py-2 transition duration-300 ease-in-out">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                class="bi bi-bookmarks" viewBox="0 0 16 16">
                                <path
                                d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z" />
                                <path
                                d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z" />
                            </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center">Tidak ada bookmark ditemukan.</p>
        @endforelse
    </div>
</div>
@endsection
