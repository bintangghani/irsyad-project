@extends('layouts/master')

@section('title', 'User')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Trending Books Carousel -->
        <div class="relative w-full max-w-4xl mx-auto overflow-hidden rounded-lg shadow-lg">
            <div id="carousel" class="flex transition-transform duration-700 ease-in-out"
                style="width: {{ count($trendingBooks) * 100 }}%;">
                @foreach ($trendingBooks as $book)
                    <div class="relative w-full h-64 flex-shrink-0" style="width: {{ 100 / count($trendingBooks) }}%;">
                        <img src="{{ asset('storage/' . $book->sampul) }}" class="w-full h-full object-cover">
                        <div
                            class="absolute inset-0  bg-opacity-50 flex items-center justify-center text-white p-4 opacity-0 transition hover:opacity-100">
                            <div class="text-center">
                                <h3 class="text-lg font-semibold">{{ $book->judul }}</h3>
                                <p class="text-sm">by {{ $book->uploaded->nama }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <button id="prev"
                class="absolute left-2 top-1/2 -translate-y-1/2 text-white p-2 bg-gray-900 rounded-full shadow-lg hover:bg-gray-700">❮</button>
            <button id="next"
                class="absolute right-2 top-1/2 -translate-y-1/2 text-white p-2 bg-gray-900 rounded-full shadow-lg hover:bg-gray-700">❯</button>
        </div>

        <!-- Trending Books List -->
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

        <!-- New Uploads (same as Trending Books) -->
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
