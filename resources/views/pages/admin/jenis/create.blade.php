@extends('layouts.master')
@section('content')
    <main class="max-w-screen min-h-screen w-full">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="w-full bg-white px-6 py-4 rounded-xl flex flex-col gap-10">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold">Jenis</h1>
                    <a href="{{ route('dashboard.jenis.index') }}"
                        class="px-4 py-1 rounded-lg bg-violet-500 text-white capitalize font-medium hover:bg-violet-600 cursor-pointer">kembali</a>
                </div>
                <div>
                    
                </div>
            </div>
        </div>
    </main>
@endsection