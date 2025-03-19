@extends('layouts.master')
@section('content')
<main class="max-w-screen min-h-screen w-full">
    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
        <div class="w-full bg-white px-6 py-4 rounded-xl flex flex-col gap-10">
            <div class="flex justify-between items-center">
                <h1 class="text-4xl font-bold">Instansi</h1>
                <button id="tambahInstansiBtn" class="px-4 py-1 rounded-lg bg-violet-500 text-white capitalize font-medium hover:bg-violet-600 cursor-pointer">Tambah</button>
            </div>
            <div class="relative overflow-x-auto">
                @if($instansi->count() > 0)
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3">#</th>
                                <th scope="col" class="px-6 py-3">Nama</th>
                                <th scope="col" class="px-6 py-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($instansi as $key => $item)
                                <tr class="bg-white border-b">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $item->nama }}
                                    </td>
                                    <td class="px-6 py-4 flex gap-3 items-center">
                                        <button class="editInstansiBtn px-4 py-1 rounded-lg bg-yellow-500 text-white capitalize font-medium hover:bg-yellow-600 cursor-pointer" data-id="{{ $item->id_instansi }}" data-nama="{{ $item->nama }}" data-alamat="{{ $item->alamat }}" data-deskripsi="{{ $item->deskripsi }}" data-profile="{{ $item->profile }}" data-background="{{ $item->background }}">Edit</button>
                                        <form action="{{ route('dashboard.instansi.destroy') }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id_instansi" value="{{ $item->id_instansi }}">
                                            <button type="submit"
                                                class="px-4 py-1 rounded-lg bg-red-500 text-white capitalize font-medium hover:bg-red-600 cursor-pointer">delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-2xl font-semibold text-center">Tidak ada data</p>
                @endif
            </div>
        </div>
    </div>
    <div id="modalTambahPermission" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <form action="{{ route('dashboard.instansi.store') }}" method="POST" class="bg-white max-w-lg w-full rounded-xl shadow-md py-6 px-8 flex flex-col gap-6">
            @csrf
            <h2 class="text-2xl font-bold text-center capitalize">Tambah Instansi</h2>
            <div>
                <label for="nama" class="block font-medium capitalize text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="nama" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-violet-500">
            </div>
            <div>
                <label for="alamat" class="block font-medium capitalize text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" id="alamat" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-violet-500">
            </div>
            <div>
                <label for="deskripsi" class="block font-medium capitalize text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-violet-500"></textarea>
            </div>
            <div>
                <label for="profile" class="block font-medium capitalize text-gray-700 mb-1">Profile</label>
                <input type="text" name="profile" id="profile" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-violet-500">
            </div>
            <div>
                <label for="background" class="block font-medium capitalize text-gray-700 mb-1">Background</label>
                <input type="text" name="background" id="background" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-violet-500">
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" id="closeTambahModalBtn" class="px-4 py-2 rounded-lg bg-gray-400 text-white capitalize font-medium hover:bg-gray-500 cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-blue-500 text-white capitalize font-medium hover:bg-blue-600 cursor-pointer">Submit</button>
            </div>
        </form>
    </div>

    <div id="modalEditPermission" class="fixed inset-0 z-50 hidden bg-gray-900 bg-opacity-50 flex justify-center items-center">
        <form action="{{ route('dashboard.instansi.update') }}" method="POST" class="bg-white max-w-lg w-full rounded-xl shadow-md py-6 px-8 flex flex-col gap-6">
            @csrf
            @method('PUT')
            <h2 class="text-2xl font-bold text-center capitalize">Edit Instansi</h2>
            <input type="hidden" name="id_instansi" id="editIdPermission">
            <div>
                <label for="editNama" class="block font-medium capitalize text-gray-700 mb-1">Nama</label>
                <input type="text" name="nama" id="editNama" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-yellow-500">
            </div>
            <div>
                <label for="editAlamat" class="block font-medium capitalize text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" id="editAlamat" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-yellow-500">
            </div>
            <div>
                <label for="editDeskripsi" class="block font-medium capitalize text-gray-700 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="editDeskripsi" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-yellow-500"></textarea>
            </div>
            <div>
                <label for="editProfile" class="block font-medium capitalize text-gray-700 mb-1">Profile</label>
                <input type="text" name="profile" id="editProfile" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-yellow-500">
            </div>
            <div>
                <label for="editBackground" class="block font-medium capitalize text-gray-700 mb-1">Background</label>
                <input type="text" name="background" id="editBackground" required class="w-full outline-none border-2 border-gray-300 rounded-lg py-2 px-3 focus:ring focus:ring-yellow-500">
            </div>
            <div class="flex justify-end gap-4">
                <button type="button" id="closeEditModalBtn" class="px-4 py-2 rounded-lg bg-gray-400 text-white capitalize font-medium hover:bg-gray-500 cursor-pointer">Batal</button>
                <button type="submit" class="px-4 py-2 rounded-lg bg-yellow-500 text-white capitalize font-medium hover:bg-yellow-600 cursor-pointer">Update</button>
            </div>
        </form>
    </div>
</main>
@endsection
