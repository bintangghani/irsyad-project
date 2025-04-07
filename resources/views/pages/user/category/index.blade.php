@extends('layouts.master')

@section('title', 'Kategori Buku')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-center mb-6">Kategori Buku</h1>

        @foreach ($categories as $category)
            <div class="mb-8">
                <!-- Nama Kategori -->
                <h2 class="text-xl font-semibold mb-4">{{ $category->nama }}</h2>

                <!-- Buku dalam Kategori -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($category->buku->take(8) as $buku)
                        <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                            <img src="{{ asset('storage/' . $buku->sampul) }}" alt="{{ $buku->judul }}"
                                class="w-full h-40 object-cover">
                            <div class="p-4">
                                <h3 class="text-lg font-semibold">{{ $buku->judul }}</h3>
                                <p class="text-gray-600 text-sm">{{ $buku->uploaded->nama }}</p>
                                </a>
                                <a href=""
                                    class="mt-2 w-full block py-2 text-center rounded text-white bg-blue-600 hover:bg-blue-700">
                                    View Book
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection
