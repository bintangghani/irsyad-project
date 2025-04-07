@extends('layouts.master')

@section('title', 'Detail Buku')

@section('content')
    <div class="container w-full p-20">
        <div class="flex flex-rows bg-white shadow rounded-lg">
            <div class="flex flex-col items-start p-5">
                <img src="{{ asset($buku->sampul) }}" alt="Cover Buku" class="w-48 h-48 object-cover">
                <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank">
                    <button id="wantToReadBtn" class="mt-5 bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600">
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
                        <span>Share</span>
                    </div>
                    <form action="{{ route('dashboard.bookmarks.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        <div class="flex flex-col items-center ml-3">
                            <button>
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
                        <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank" class="btn btn-primary btn-sm">
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

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">Related Books</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($buku as $related)
                <div class="bg-white shadow rounded-lg p-4">
                    <img src="{{ asset($buku->sampul) }}" alt="{{ $related }}"
                        class="w-full h-48 object-cover rounded">
                    <h3 class="mt-2 text-sm font-semibold">{{ $related }}</h3>
                    <p class="text-xs text-gray-500">By {{ $related }}</p>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{-- {{ $buku->links() }} --}}
        </div>
    </div>

    <div class="mt-10">
        <h2 class="text-xl font-bold mb-4">More by {{ $buku->penulis }}</h2>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach ($buku as $book)
                <div class="bg-white shadow rounded-lg p-4">
                    <img src="{{ asset($buku->sampul) }}" alt="{{ $book }}"
                        class="w-full h-48 object-cover rounded">
                    <h3 class="mt-2 text-sm font-semibold">{{ $book }}</h3>
                </div>
            @endforeach
        </div>
        <div class="mt-4">
            {{-- {{ $buku->links() }} --}}
        </div>
        <script>
            document.getElementById('wantToReadBtn').addEventListener('click', function() {
                fetch('{{ route('dashboard.buku.read', $buku->id_buku) }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({})
                    })
                    .then(response => response.json())
                    .then(data => {
                        alert(data.message);
                    })
                    .catch(error => console.error('Error:', error));
            });
        </script>
    </div>
@endsection
