@extends('layouts.master')

<div class="max-w-xs p-3 shadow-md min-h-screen bg-white">
    <nav class="flex flex-col justify-between h-full">
        <!-- Logo & Toggle Menu -->
        <div>
            <div class="flex justify-between items-center p-2">
                <img src="{{ asset('storage/images/contoh-logo.png') }}" alt="Logo" class="h-10 w-auto">
                <svg class="w-6 h-6 text-gray-800 cursor-pointer" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </div>

            @php
                $currentRoute = Route::currentRouteName();
            @endphp

            <!-- Navigation Items -->
            <ul class="space-y-1">
                <li>
                    <a href="#"
                        class="flex items-center gap-x-2 p-2 rounded-lg cursor-pointer 
                        {{ $currentRoute == 'dashboard' ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="black"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-black">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="#"
                        class="flex items-center gap-x-2 p-2 rounded-lg cursor-pointer 
                        {{ $currentRoute == 'users' ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="black"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M12 4a4 4 0 1 0 0 8 4 4 0 0 0 0-8Zm-2 9a4 4 0 0 0-4 4v1a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2v-1a4 4 0 0 0-4-4h-4Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-black">User</span>
                    </a>
                </li>


                <li class="relative">
                    <button id="booksDropdownBtn"
                        class="flex items-center gap-x-2 p-2 rounded-lg cursor-pointer w-full
                        {{ in_array($currentRoute, ['books', 'categories']) ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="black"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M6 2a2 2 0 0 0-2 2v15a3 3 0 0 0 3 3h12a1 1 0 1 0 0-2h-2v-2h2a1 1 0 0 0 1-1V4a2 2 0 0 0-2-2h-8v16h5v2H7a1 1 0 1 1 0-2h1V2H6Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-black">Buku</span>
                        <svg class="w-4 h-4 transition-transform duration-200 ml-auto" id="booksDropdownIcon"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>

                    <ul id="booksDropdownMenu" class="hidden transition-all duration-200 scale-95 opacity-0 origin-top">
                        <li><a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Semua Buku</a></li>
                        <li><a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Jenis Buku</a></li>
                        <li><a href="#" class="block px-4 py-2 text-sm hover:bg-gray-200">Kelompok Buku</a></li>
                    </ul>
                </li>
                <li>
                    <a href="#"
                        class="flex items-center gap-x-2 p-2 rounded-lg cursor-pointer 
                        {{ $currentRoute == 'instansi' ? 'bg-gray-300' : 'hover:bg-gray-200' }}">
                        <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="black"
                            viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M4 4a1 1 0 0 1 1-1h14a1 1 0 1 1 0 2v14a1 1 0 1 1 0 2H5a1 1 0 1 1 0-2V5a1 1 0 0 1-1-1Zm5 2a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H9Z"
                                clip-rule="evenodd" />
                        </svg>
                        <span class="text-sm font-semibold text-black">Instansi</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout -->
        <a href="#" class="flex items-center gap-x-2 p-2 rounded-lg hover:bg-gray-200">
            <svg class="w-6 h-6 text-gray-800" xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24">
                <path fill-rule="evenodd"
                    d="M11.293 3.293a1 1 0 0 1 1.414 0l6 6 2 2a1 1 0 0 1-1.414 1.414L19 12.414V19a2 2 0 0 1-2 2h-3a1 1 0 0 1-1-1v-3h-2v3a1 1 0 0 1-1 1H7a2 2 0 0 1-2-2v-6.586l-.293.293a1 1 0 0 1-1.414-1.414l2-2 6-6Z"
                    clip-rule="evenodd" />
            </svg>
            <span class="text-sm font-semibold text-black">Log Out</span>
        </a>
    </nav>
</div>

@vite('resources/js/admin/dashboard/sidebar.js')
