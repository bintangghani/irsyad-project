<!DOCTYPE html>
<html lang="en">

<head>
    @extends('includes.head')
</head>

<body class="bg-gray-100 flex h-full items-center">


    <main class="w-full mx-auto p-6">
        @yield('content')
    </main>

    @extends('includes.script')
    @stack('scripts')
</body>

</html>
