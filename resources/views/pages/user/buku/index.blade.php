@extends('layouts.master')

@section('title', 'Detail Buku')

@section('content')
    <div class="container w-full p-20">
        <div class="flex flex-rows bg-white shadow rounded-lg">
            <div class="flex items-center flex-col p-5">
                <img src="{{ asset('storage/' . $buku->sampul) }}" class="object-contain object-center rounded w-full h-64">
                <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank">
                    <button class="mt-5 bg-blue-500 text-white py-2 px-6 rounded hover:bg-blue-600 needvalidation ">
                        Read Now
                    </button>
                </a>
                <div class="flex flex-row mt-6 space-x-3">
                    <div class="flex flex-col items-center ml-6 hover:text-[#696cff] transition duration-200 cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7.217 10.907a2.25 2.25 0 1 0 0 2.186m0-2.186c.18.324.283.696.283 1.093s-.103.77-.283 1.093m0-2.186 9.566-5.314m-9.566 7.5 9.566 5.314m0 0a2.25 2.25 0 1 0 3.935 2.186 2.25 2.25 0 0 0-3.935-2.186Zm0-12.814a2.25 2.25 0 1 0 3.933-2.185 2.25 2.25 0 0 0-3.933 2.185Z" />
                        </svg>
                        <span>Share</span>
                    </div>
                    <form action="{{ route('dashboard.bookmarks.store') }}" method="POST" enctype="multipart/form-data"
                        class="needs-validation" novalidate>
                        @csrf
                        <div
                            class="flex flex-col items-center ml-3 hover:text-[#696cff] transition duration-200 cursor-pointer">
                            <button class="flex flex-col items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0 1 11.186 0Z" />
                                </svg>
                                <span>Bookmarks</span>
                            </button>
                            <input type="hidden" name="id_user" value="{{ auth()->id() }}">
                            <input type="hidden" name="id_buku" value="{{ $buku->id_buku }}">
                    </form>
                </div>
                <div class="flex flex-col items-center hover:text-[#696cff] transition duration-200 cursor-pointer">
                    @if ($buku->file_buku)
                        <a href="{{ asset('storage/' . $buku->file_buku) }}" target="_blank"
                            class="flex flex-col items-center hover:text-[#696cff] transition duration-200 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M7.5 7.5h-.75A2.25 2.25 0 0 0 4.5 9.75v7.5a2.25 2.25 0 0 0 2.25 2.25h7.5a2.25 2.25 0 0 0 2.25-2.25v-7.5a2.25 2.25 0 0 0-2.25-2.25h-.75m-6 3.75 3 3m0 0 3-3m-3 3V1.5m6 9h.75a2.25 2.25 0 0 1 2.25 2.25v7.5a2.25 2.25 0 0 1-2.25 2.25h-7.5a2.25 2.25 0 0 1-2.25-2.25v-.75" />
                            </svg>
                            <span>Download</span>
                        </a>
                    @else
                        <span class="text-muted hidden">Tidak ada file</span>
                    @endif
                </div>
            </div>
        </div>

        <div class="w-full p-6 ">
            <h1 class="text-2xl font-bold mb-2">{{ $buku->judul }}</h1>
            <p class="text-gray-500 text-sm mb-4">By {{ $buku->penerbit }}</p>

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
                    <p class="capitalize">{{ $buku->uploaded->nama }}</p>
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
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Rilisan Terbaru</h2>
            <a href="/category"
                class="text-[#696cff] hover:text-[#5a5cff] text-sm font-medium hover:underline flex items-center">
                Lihat Semua <span class="ml-1">→</span>
            </a>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($relatedBooks as $book)
                <div class="flex gap-4">
                    <a href="{{ route('show', $book->id_buku) }}" class="flex-shrink-0">
                        <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                            class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                    </a>
                    <div class="flex flex-col justify-between">
                        <div>
                            <a href="{{ route('show', $book->id_buku) }}">
                                <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                    {{ $book->judul }}
                                </h3>
                            </a>
                            <div class="text-xs text-[#333333] mt-1 flex items-center gap-0.5">
                                <div class="flex flex-wrap items-center gap-1 text-xs">
                                    <a href="{{ route('category') }}?genre={{ urlencode($book->subKelompok->kelompok->nama ?? '') }}"
                                        class="text-[#696cff] font-medium hover:underline">
                                        {{ $book->subKelompok->kelompok->nama ?? 'Genre' }}
                                    </a>
                                    <a href="{{ route('category') }}?sub_category={{ $book->subKelompok->id_sub_kelompok ?? '' }}"
                                        class="text-[#696cff] font-medium hover:underline">
                                        {{ $book->subKelompok->nama ?? 'Sub Genre' }}
                                    </a>
                                </div>
                                <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                    <a href="{{ route('category') }}?jenis={{ $book->jenisBuku->id_jenis ?? '' }}"
                                        class="text-[#696cff] font-medium hover:underline">
                                        {{ $book->jenisBuku->nama ?? 'Jenis' }}
                                    </a>
                                    <a href="{{ route('category') }}?penerbit={{ urlencode($book->penerbit ?? '') }}"
                                        class="text-[#696cff] font-medium hover:underline">
                                        {{ \Illuminate\Support\Str::words($book->penerbit ?? $book->uploaded->nama, 1, '...') }}
                                    </a>
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

        <div class="mt-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-800">More By {{ $buku->penerbit }}</h2>
                <a href="/category"
                    class="text-[#696cff] hover:text-[#5a5cff] text-sm font-medium hover:underline flex items-center">
                    Lihat Semua <span class="ml-1">→</span>
                </a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($moreBy as $book)
                    <div class="flex gap-4">
                        <a href="{{ route('show', $book->id_buku) }}" class="flex-shrink-0">
                            <img src="{{ asset('storage/' . $book->sampul) }}" alt="{{ $book->judul }}"
                                class="w-32 h-48 md:w-36 md:h-52 object-cover rounded-lg shadow" />
                        </a>
                        <div class="flex flex-col justify-between">
                            <div>
                                <a href="{{ route('show', $book->id_buku) }}">
                                    <h3 class="text-lg text-[#222222] md:text-lg font-semibold leading-snug">
                                        {{ $book->judul }}
                                    </h3>
                                </a>
                                <div class="text-xs text-[#333333] mt-1 flex items-center gap-0.5">
                                    <div class="flex flex-wrap items-center gap-1 text-xs">
                                        <a href="{{ route('category') }}?genre={{ urlencode($book->subKelompok->kelompok->nama ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->kelompok->nama ?? 'Genre' }}
                                        </a>
                                        <a href="{{ route('category') }}?sub_category={{ $book->subKelompok->id_sub_kelompok ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->subKelompok->nama ?? 'Sub Genre' }}
                                        </a>
                                    </div>
                                    <div class="flex flex-wrap items-center gap-1 text-xs mt-1">
                                        <a href="{{ route('category') }}?jenis={{ $book->jenisBuku->id_jenis ?? '' }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ $book->jenisBuku->nama ?? 'Jenis' }}
                                        </a>
                                        <a href="{{ route('category') }}?penerbit={{ urlencode($book->penerbit ?? '') }}"
                                            class="text-[#696cff] font-medium hover:underline">
                                            {{ \Illuminate\Support\Str::words($book->penerbit ?? $book->uploaded->nama, 1, '...') }}
                                        </a>
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
            {{-- <script>
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
            </script> --}}

            {{-- <script>
                document.getElementById('downloadBtn')?.addEventListener('click', function(event) {
                    if (!isUserLoggedIn()) {
                        event.preventDefault();

                        Swal.fire({
                            icon: 'warning',
                            title: 'Login Required',
                            text: 'You need to log in to download this book.',
                            showCancelButton: true,
                            confirmButtonText: 'Login',
                            cancelButtonText: 'Cancel'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = '{{ route('auth.login') }}'; // Ubah sesuai route login kamu
                            }
                        });
                    } else {
                        window.open('{{ asset('storage/' . $buku->file_buku) }}', '_blank');
                    }
                });

                function isUserLoggedIn() {
                    return {{ auth()->check() ? 'true' : 'false' }};
                }
            </script> --}}

        </div>
    @endsection
