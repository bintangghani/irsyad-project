@extends('layouts.master')
@section('content')
    <main class="max-w-screen min-h-screen w-full">
        <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
            <div class="w-full bg-white px-6 py-4 rounded-xl flex flex-col gap-10">
                <div class="flex justify-between items-center">
                    <h1 class="text-4xl font-bold">Jenis</h1>
                    <button id="tambahJenisBtn"
                        class="px-4 py-1 rounded-lg bg-violet-500 text-white capitalize font-medium hover:bg-violet-600 cursor-pointer">tambah</button>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                        @if($jenis->count() > 0)
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 ">
                                <tr>
                                    <th scope="col" class="px-6 py-3 w-16">
                                        #
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/2">
                                        Nama
                                    </th>
                                    <th scope="col" class="px-6 py-3 w-1/4">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jenis as $key => $item)
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $key + 1  }}
                                        </th>
                                        <td class="px-6 py-4 capitalize">
                                            <div class="editJenisSection">
                                                {{ $item->nama  }}
                                            </div>
                                            <form action="{{ route('dashboard.jenis.update', ['id' => $item->id]) }}" method="POST"
                                                class="hidden flex items-center gap-3 editJenisInput">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="id_jenis" value="{{ $item->id_jenis }}">
                                                <input type="text" name="nama"
                                                    class="w-full outline-none border-2 border-gray-200 rounded-lg py-1 px-1.5"
                                                    value="{{ $item->nama }}">
                                                <button type="submit"
                                                    class="px-4 py-1 rounded-lg bg-yellow-500 text-white capitalize font-medium hover:bg-yellow-600 cursor-pointer editJenisSubmitBtn">update</button>
                                            </form>
                                        </td>
                                        <td class="px-6 py-4 flex gap-3 items-center">
                                            <button
                                                class="px-4 py-1 rounded-lg bg-yellow-500 text-white capitalize font-medium hover:bg-yellow-600 cursor-pointer editJenisBtn">edit</button>
                                            <form action="{{ route('dashboard.jenis.destroy') }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="hidden" name="id_jenis" value="{{ $item->id_jenis }}">
                                                <button type="submit"
                                                    class="px-4 py-1 rounded-lg bg-red-500 text-white capitalize font-medium hover:bg-red-600 cursor-pointer">delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <h6 class="text-2xl font-semibold text-center">Tidak ada data</h6>
                        @endif
                    </table>
                </div>
            </div>
        </div>
        <div id="modalTambahJenis"
            class="fixed top-0 bottom-0 left-0 right-0 z-50 w-screen h-screen bg-gray-300 opacity-0 hidden justify-center items-center">
            <form action="{{ route('dashboard.jenis.store') }}" method="POST"
                class="bg-white max-w-lg max-h-1/2 w-full rounded-xl shadow-md py-4 px-8 flex flex-col gap-6">
                @csrf
                <h2 class="text-2xl font-bold text-center capitalize">tambah jenis</h2>
                <div>
                    <label for="nama" class="font-medium capitalize text-gray-700 px-1">nama</label>
                    <input type="text" name="nama"
                        class="w-full outline-none border-2 border-gray-200 rounded-lg py-1 px-1.5">
                </div>
                <button type="submit"
                    class="px-4 py-1 rounded-lg bg-blue-500 text-white capitalize font-medium hover:bg-blue-600 cursor-pointer">submit</button>
            </form>
        </div>
    </main>
@endsection