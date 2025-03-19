@extends('layouts.master')

@section('content')
    <main class="max-w-screen min-h-screen w-full">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="w-full bg-white px-6 py-4 rounded-xl flex flex-col gap-10">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold">Edit Role</h1>
                    <a href="{{ route('dashboard.role.index') }}"
                        class="px-4 py-1 rounded-lg bg-violet-500 text-white capitalize font-medium hover:bg-violet-600 cursor-pointer">
                        Kembali
                    </a>
                </div>

                <div>
                    <form action="{{ route('dashboard.role.update', $role->id) }}" method="POST" class="flex flex-col gap-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="name" class="block text-lg font-medium text-gray-700">Nama Role</label>
                            <input type="hidden" name="id_role" value="{{ $role->id_role }}">
                            <input type="text" name="nama" id="nama" value="{{ old('name', $role->nama) }}" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-violet-500 focus:border-violet-500">
                            @error('nama')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 rounded-lg bg-violet-500 text-white font-medium hover:bg-violet-600">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection
