@extends('layouts.master')
@section('content')
<main class="max-w-screen w-full h-full flex relative">
    <div class="w-full flex flex-col justify-center items-center gap-10 min-h-screen h-full px-10">
        <h3 class="w-fit text-3xl font-bold text-[#6636F1] self-start">Irsyad Cloud Drive</h3>
        <div class="w-full h-full flex flex-col gap-8">
            <div class="flex flex-col gap-2 items-center lg:items-start">
                <h1 class="w-fit text-5xl font-black">Masuk ke akun anda</h1>
                <h6>Belum memiliki akun? <a href="/auth/register" class="text-[#6636F1] font-medium cursor-pointer">Register</a></h6>
            </div>
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-0.5">
                        <label for="email" class="text-base font-medium px-1">Email</label>
                        <input type="email" name="email" id="email" placeholder="example@example.xyz" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                    <div class="flex flex-col gap-0.5">
                        <label for="password" class="text-base font-medium px-1">Password</label>
                        <input type="password" name="password" id="password" placeholder="********" class="outline-none border-2 border-gray-400 p-1.5 rounded w-full hover:border-[#6636F1] focus:border-[#6636F1] focus-visible:border-[#6636F1] active:border-[#6636F1]">
                    </div>
                </div>
                <div>
                    <button class="w-full py-3 border-2outline-none border-2 border-[#6636F1] bg-[#6636F1] text-white p-1.5 rounded-lg hover:bg-white hover:text-[#6636F1]">Login</button>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection