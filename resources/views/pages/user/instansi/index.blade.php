@extends('layouts/master')

@section('title', 'Instansi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-10">Daftar Instansi</h1>

        @if ($instansis->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($instansis as $instansi)
                    <a href="{{ route('instansi.show', $instansi->id_instansi) ?? '' }}"
                        class="block rounded-xl shadow hover:shadow-lg transition duration-300 border border-gray-100 overflow-hidden bg-white">

                        {{-- Background Section --}}
                        <div class="relative h-40 bg-cover bg-center"
                            @if ($instansi->background) style="background-image: url('{{ asset('storage/' . $instansi->background) }}');" @endif>
                            @unless ($instansi->background)
                                <div class="flex items-center justify-center w-full h-full bg-gray-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-gray-500" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 21h18M9 8h6M9 12h6m-6 4h6M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16" />
                                    </svg>
                                </div>
                            @endunless

                            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-40"></div>
                        </div>

                        {{-- Content Section --}}
                        <div class="relative z-10 p-6 bg-white">
                            <div class="flex justify-center mb-4">
                                @if ($instansi->profile)
                                    <img src="{{ asset('storage/' . $instansi->profile) }}" alt="Profile Picture"
                                        class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover -mt-16 bg-white">
                                @else
                                    <div
                                        class="w-24 h-24 rounded-full border-4 border-white shadow-lg bg-gray-200 flex items-center justify-center -mt-16">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-500"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 21h18M9 8h6M9 12h6m-6 4h6M5 21V5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="text-xl text-center font-semibold text-gray-800 mb-2">{{ $instansi->nama }}</div>
                        </div>
                    </a>
                @endforeach
            </div>

            @if (method_exists($instansis, 'links'))
                <div class="mt-8 flex justify-center">
                    {{ $instansis->links() }}
                </div>
            @endif
        @else
            <p class="text-center text-gray-500">Belum ada instansi yang tersedia.</p>
        @endif
    </div>
@endsection
