@extends('layouts.master')

@section('title', $instansi->nama)

@section('content')
    <div class="container mx-auto px-4 py-10">
        <div class="relative mb-6 rounded-lg overflow-hidden shadow-lg">
            <img src="{{ asset('storage/' . $instansi->background) }}" alt="Background Image" class="w-full h-80 object-cover object-center">
            <div class="absolute top-0 left-0 w-full h-full bg-black opacity-30"></div>
        </div>

        <div class="bg-white rounded-lg shadow-xl p-8">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('storage/' . $instansi->profile) }}" alt="Profile Picture"
                    class="w-32 h-32 rounded-full border-4 border-white shadow-md object-cover">
            </div>

            <h1 class="text-3xl font-semibold text-gray-800 text-center mb-4">{{ $instansi->nama }}</h1>
            <p class="text-lg text-gray-600 text-center mb-4">{{ $instansi->alamat ?? 'Alamat tidak tersedia' }}</p>

            <div class="text-gray-700 mb-6">
                <h2 class="text-2xl font-medium text-gray-800 mb-3">Deskripsi Instansi</h2>
                <p class="text-base leading-relaxed">{{ $instansi->deskripsi ?? 'Deskripsi instansi belum tersedia.' }}</p>
            </div>
        </div>
    </div>
@endsection
