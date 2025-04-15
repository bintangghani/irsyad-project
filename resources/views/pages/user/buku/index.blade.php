@extends('layouts.master')

@section('title', 'Detail Buku')

@section('content')
    <div class="container w-full p-20">
        <div class="flex flex-rows bg-white shadow rounded-lg">
            <div class="flex items-center flex-col p-5">
                <img src="{{ asset('storage/' . $buku->sampul) }}" class="object-contain object-center rounded w-full h-64"> 
                <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank">
                    <button id="wantToReadBtn"
                        class="mt-5 bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600 needvalidation ">
                        Read Now
                    </button>
                </a>
                <div class="flex flex-row mt-5 space-x-4">
                    <div class="flex flex-col items-center ml-6">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-share-fill" viewBox="0 0 16 16">
                            <path
                                d="M11 2.5a2.5 2.5 0 1 1 .603 1.628l-6.718 3.12a2.5 2.5 0 0 1 0 1.504l6.718 3.12a2.5 2.5 0 1 1-.488.876l-6.718-3.12a2.5 2.5 0 1 1 0-3.256l6.718-3.12A2.5 2.5 0 0 1 11 2.5" />
                        </svg>
                        <span>Download</span>
                    </div>
                    <form action="{{ route('dashboard.bookmarks.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="flex flex-col items-center ml-3">
                            <button id= 'downloadBtn' class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                    class="bi bi-bookmarks-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M2 4a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L7 13.101l-4.223 2.815A.5.5 0 0 1 2 15.5z" />
                                    <path
                                        d="M4.268 1A2 2 0 0 1 6 0h6a2 2 0 0 1 2 2v11.5a.5.5 0 0 1-.777.416L13 13.768V2a1 1 0 0 0-1-1z" />
                                </svg>
                                <span>Bookmarks</span>
                            </button>
                            <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">

                    </form>
                </div>
                <div class="flex flex-col items-center">
                    @if ($buku->file_buku)
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                            class="bi bi-download" viewBox="0 0 16 16">
                            <path d="M.5 9.9v4.6a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V9.9h-1V14H1V9.9H.5z" />
                            <path d="M5.354 5.354 8 8l2.646-2.646-.708-.708L8.5 6.293V0h-1v6.293L6.062 4.646l-.708.708z" />
                        </svg>
                        <a href="{{ asset('storage/' . $buku->file_buku) }}" 
                            download 
                            class="btn btn-primary btn-sm needvalidation">
                            Download
                        </a>
                    @else
                        <span class="text-muted">Tidak ada file</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full p-6 ">
            <h1 class="text-2xl font-bold mb-2">{{ $buku->judul }}</h1>
            <p class="text-gray-500 text-sm mb-4">By {{ $buku->penulis }}</p>

            <p class="text-gray-700 mb-6">
                {{ $buku->deskripsi ?? 'Deskripsi tidak tersedia untuk buku ini.' }}
            </p>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-semibold text-gray-800">Publish Date:</p>
                    <p>{{ $buku->tahun_terbit }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Publisher:</p>
                    <p>{{ $buku->penerbit }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Language:</p>
                    <p>{{ $buku->bahasa ?? 'English' }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-800">Pages:</p>
                    <p>{{ $buku->jumlah_halaman }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-center">Related Books</h2>
        <div class="relative flex items-center mt-4">
            <button class="absolute left-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                id="prevBtn">&#10094;</button>
            <div class="overflow-hidden w-full px-8">
                <div class="flex gap-4 transition-transform duration-300 ease-in-out" id="bookCarousel">
                    @foreach ($relatedBooks as $book)
                        <div
                            class="min-w-[220px] bg-white shadow-md rounded-lg overflow-hidden p-4 transition hover:scale-105">
                            <a href="" class="block">
                                <img src="{{ asset('storage/' . $book->sampul) }}"
                                    class="w-full h-48 object-cover object-center rounded">
                                <h3 class="text-lg font-semibold mt-2">{{ $book->judul }}</h3>
                                <p class="text-gray-500 text-sm">by {{ $book->uploaded->nama }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($book->deskripsi, 60) }}</p>
                            </a>
                            <a href="{{ route('show', $book->id_buku) }}"
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

    <div class="mt-8">
        <h2 class="text-2xl font-bold text-center capitalize">More By {{ $buku->uploaded->nama }}</h2>
        <div class="relative flex items-center mt-4">
            <button class="absolute left-0 z-10 p-2 bg-gray-200 rounded-full shadow-md hover:bg-gray-300"
                id="prevBtn">&#10094;</button>
            <div class="overflow-hidden w-full px-8">
                <div class="flex gap-4 transition-transform duration-300 ease-in-out" id="bookCarousel">
                    @foreach ($moreBy as $book)
                        <div
                            class="min-w-[220px] bg-white shadow-md rounded-lg overflow-hidden p-4 transition hover:scale-105">
                            <a href="" class="block">
                                <img src="{{ asset('storage/' . $book->sampul) }}"
                                    class="w-full h-48 object-cover object-center rounded">
                                <h3 class="text-lg font-semibold mt-2">{{ $book->judul }}</h3>
                                <p class="text-gray-500 text-sm">by {{ $book->uploaded->nama }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ Str::limit($book->deskripsi, 60) }}</p>
                            </a>
                            <a href="{{ route('show', $book->id_buku) }}"
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
    <script>
        document.getElementById('wantToReadBtn').addEventListener('click', function(event) {
            if (!isUserLoggedIn()) {
                event.preventDefault();

                Swal.fire({
                    icon: 'warning',
                    title: 'Login Required',
                    text: 'You need to log in to read this book.',
                    showCancelButton: true,
                    confirmButtonText: 'Login',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = '{{ route('auth.login') }}';
                    }
                });
            } else {
                fetch('{{ route('dashboard.buku.read', $buku->id_buku) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        alert(data.message);

                        window.open('{{ asset('storage/' . $buku->file_buku) }}', '_blank');
                    })
            }
        });

        function isUserLoggedIn() {
            return {{ auth()->check() ? 'true' : 'false' }};
        }
    </script>
    </div>
@endsection
