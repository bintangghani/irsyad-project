@extends('layouts/master')

@section('title', 'User')

@section('content')
    <div class="container mx-auto px-4">
        <div
            class="relative w-full max-w-6xl mx-auto flex flex-col md:flex-row bg-[#111827] text-white p-8 rounded-xl shadow-lg overflow-hidden">
            <div class="absolute inset-0 bg-[#1E293B] clip-path-diagonal"></div>
            <div class="md:w-2/3 flex flex-col justify-center relative z-10">
                <span class="text-red-400 font-semibold"> {{ $user->nama ?? 'Guest' }}!</span>
                <h2 class="text-3xl font-bold mt-2">Selamat datang di Perpustakaan Online</h2>
                <p class="mt-4 text-gray-300 text-sm">
                    Jelajahi ribuan koleksi buku digital dan audiobook premium hanya dengan satu klik.
                    Nikmati akses tanpa batas ke berbagai bacaan menarik, mulai dari novel best-seller, buku edukasi, hingga
                    konten audio eksklusif.
                    Perpustakaan online ini dirancang untuk memenuhi kebutuhan belajar dan hiburan Anda di mana saja, kapan
                    saja.
                </p>
                <div class="mt-6">
                    <button
                        class="bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg text-lg font-semibold hover:bg-red-600 transition">
                        Mulai Membaca Sekarang
                    </button>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <h2 class="text-2xl font-bold text-center">Trending Books</h2>
            <div class="relative flex items-center mt-4">
                <button class="absolute left-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                    id="prevBtn">&#10094;</button>
                <div class="overflow-hidden w-full px-8">
                    <div class="flex gap-4 transition-transform duration-300 ease-in-out" id="bookCarousel">
                        @foreach ($trendingBooks as $book)
                            <div
                                class="min-w-[220px] bg-white shadow-md rounded-lg overflow-hidden p-4 transition hover:scale-105">
                                <a href="" class="block">
                                    <img src="{{ asset('storage/' . $book->sampul) }}"
                                        class="w-full h-48 object-cover object-center rounded">
                                    <h3 class="text-lg font-semibold mt-2">{{ $book->judul }}</h3>
                                    <p class="text-gray-500 text-sm">by {{ $book->uploaded->nama }}</p>
                                    <p class="text-xs text-gray-400 mt-1">{{ Str::limit($book->deskripsi, 60) }}</p>
                                </a>
                                <a href=""
                                    class="mt-2 w-full block py-2 text-center rounded text-white bg-blue-600 hover:bg-blue-700">
                                    View Book
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
                <button class="absolute right-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                    id="nextBtn">&#10095;</button>
            </div>
        </div>
        <h2 class="text-2xl font-bold text-center mt-8">New Uploads</h2>
        <div class="relative flex items-center mt-4">
            <button class="absolute left-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                id="prevNewBtn">&#10094;</button>
            <div class="overflow-hidden w-full px-8">
                <div class="flex gap-4 transition-transform duration-300 ease-in-out" id="newUploadsCarousel">
                    @foreach ($newUploads as $book)
                        <div
                            class="min-w-[220px] bg-white shadow-md rounded-lg overflow-hidden p-4 transition hover:scale-105">
                            <a href="" class="block">
                                <img src="{{ asset('storage/' . $book->sampul) }}" class="w-full h-48 object-cover rounded">
                                <h3 class="text-lg font-semibold mt-2">{{ $book->judul }}</h3>
                                <p class="text-gray-500 text-sm">by {{ $book->uploaded->nama }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($book->deskripsi, 60) }}</p>
                            </a>
                            <a href=""
                                class="mt-2 w-full block py-2 text-center rounded text-white bg-blue-600 hover:bg-blue-700">
                                View Book
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <button class="absolute right-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                id="nextNewBtn">&#10095;</button>
        </div>
    </div>
    <style>
        .clip-path-diagonal {
            clip-path: polygon(0 0, 85% 0, 100% 100%, 0% 100%);
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function setupCarousel(carouselId, prevBtnId, nextBtnId) {
                let scrollAmount = 0;
                const scrollStep = 220;
                const carousel = document.getElementById(carouselId);
                const prevBtn = document.getElementById(prevBtnId);
                const nextBtn = document.getElementById(nextBtnId);

                nextBtn.addEventListener("click", function() {
                    carousel.scrollTo({
                        left: (scrollAmount += scrollStep),
                        behavior: "smooth"
                    });
                });

                prevBtn.addEventListener("click", function() {
                    carousel.scrollTo({
                        left: (scrollAmount -= scrollStep),
                        behavior: "smooth"
                    });
                });
            }

            setupCarousel("bookCarousel", "prevBtn", "nextBtn");
            setupCarousel("newUploadsCarousel", "prevNewBtn", "nextNewBtn");
        });
    </script>
@endsection
