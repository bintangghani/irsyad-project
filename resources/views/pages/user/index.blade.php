@extends('layouts/master')

@section('title', 'User')

@section('content')
    <div class="container mx-auto px-4">
        <!-- Trending Books Carousel -->
        <div
            class="relative w-full flex flex-col md:flex-row bg-gradient-to-r from-gray-900 to-gray-700 text-white p-8 rounded-lg shadow-lg">
            <div class="md:w-2/3 flex flex-col justify-center">
                <span class="text-red-400 font-semibold">Exclusive Content</span>
                <h2 class="text-3xl font-bold mt-2">Discover libraries full of content with our annual subscription</h2>
                <p class="mt-4 text-gray-300 text-sm">Monthly subscription allows you to instantly get access to a library of
                    over a thousand e-books and audio premium library. It also unlocks audiobook content which contains a
                    lot of world-known bestsellers.</p>
                <div class="mt-6 flex gap-4">
                    <button class="bg-red-500 text-white px-4 py-2 rounded-lg shadow hover:bg-red-600">Go Premium</button>
                    <span class="text-lg font-semibold bg-red-600 px-4 py-2 rounded-lg shadow">$9.99 Monthly</span>
                </div>
            </div>
            <div class="md:w-1/3 flex justify-center mt-6 md:mt-0">
                <img src="{{ asset('storage/subscription-image.png') }}" alt="Reading Illustration" class="h-48">
            </div>
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
