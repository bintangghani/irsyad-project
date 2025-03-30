<!DOCTYPE html>
<html lang="en">

<head>
    @extends('includes.head')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <div class="w-full">
        @include('layouts/sections/navbarclient/navbarclient')
    </div>

    <main class="w-full mx-auto p-6 pt-16">
        @yield('content')
    </main>

    @extends('includes.script')
    @stack('scripts')
</body>

</html>
