@extends('layouts.master')
@section('content')
<main class="max-w-screen w-full h-full flex relative">
    <div class="w-full flex flex-col justify-center items-center gap-10 min-h-screen h-full px-10 lg:px-14 lg:w-1/2">
        <h3 class="w-fit text-3xl font-bold text-[#6636F1] self-start">PUSKITA Cloud Drive</h3>
        <div class="w-full h-full flex flex-col gap-8">
            <div class="flex flex-col gap-2 items-center lg:items-start">
                <h1 class="w-fit text-5xl font-black">Daftarkan akun anda</h1>
                <h6>Sudah memiliki akun? <button id="registerBtn" class="text-[#6636F1] font-medium cursor-pointer">Login</button></h6>
            </div>
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-0.5">
                        <label for="email" class="text-base font-medium px-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@example.xyz" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <label for="nama" class="text-base font-medium px-1">Nama</label>
                        <input type="text" name="nama" id="nama" placeholder="John Doe" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <label for="password" class="text-base font-medium px-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <label for="password_confirm" class="text-base font-medium px-1">Konfirmasi Password</label>
                        <input type="password" name="password_confirm" id="password" placeholder="********" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                </div>
                <div>
                    <button class="w-full py-3 border-2outline-none border-2 border-[#6636F1] bg-[#6636F1] text-white p-1.5 rounded-lg hover:bg-white hover:text-[#6636F1]">Login</button>
                </div>
            </div>
        </div>
    </div>
    <div class="w-full flex flex-col justify-center items-center gap-10 min-h-screen h-full px-10 lg:px-14 lg:w-1/2">
        <h3 class="w-fit text-3xl font-bold text-[#6636F1] self-start">PUSKITA Cloud Drive</h3>
        <div class="w-full h-full flex flex-col gap-8">
            <div class="flex flex-col gap-2 items-center lg:items-start">
                <h1 class="w-fit text-5xl font-black">Masuk ke akun anda</h1>
                <h6>Belum memiliki akun? <button id="loginBtn" class="text-[#6636F1] font-medium cursor-pointer">Register</button></h6>
            </div>
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-0.5">
                        <label for="email_login" class="text-base font-medium px-1">Email</label>
                        <input type="email" name="email_login" id="email_login" placeholder="example@example.xyz" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <label for="password_login" class="text-base font-medium px-1">Password</label>
                        <input type="password" name="password_login" id="password_login" placeholder="********" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                </div>
                <div>
                    <button class="w-full py-3 border-2outline-none border-2 border-[#6636F1] bg-[#6636F1] text-white p-1.5 rounded-lg hover:bg-white hover:text-[#6636F1]">Login</button>
                </div>
            </div>
        </div>
    </div>
    <div class="w-1/2 absolute top-0 z-50 p-4" id="imgAuth">
        <img src="{{ asset('storage/images/static/auth.png') }}" alt="Puskita Cloud Drive" class="object-cover w-full h-[calc(100vh-32px)] object-center rounded-lg">
    </div>
</main>
@endsection