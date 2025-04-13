@extends('layouts/master')

@section('title', 'Instansi')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-center mb-10">Daftar Instansi</h1>

        @if ($instansis->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($instansis as $instansi)
                    <a href="{{ route('instansi.show', $instansi->id_instansi) }}"
                        class="block bg-white rounded-xl shadow hover:shadow-lg transition duration-300 p-6 border border-gray-100"
                        style="background-image: url('{{ asset('storage/' . $instansi->background) }}'); background-size: cover; background-position: center;">
                        <div class="relative">
                            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-40"></div>
                            <div class="relative z-10 p-6">
                                <!-- Foto Profil -->
                                <div class="flex justify-center mb-4">
                                    <img src="{{ asset('storage/' . $instansi->profile) }}"
                                        alt="Profile Picture"
                                        class="w-24 h-24 rounded-full border-4 border-white shadow-lg object-cover">
                                </div>
                                <div class="text-xl text-center font-semibold text-white mb-2">{{ $instansi->nama }}</div>
                            </div>
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