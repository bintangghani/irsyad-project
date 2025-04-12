<!DOCTYPE html>
<html lang="en">

<head>
    @extends('includes.head')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <header class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
        @include('layouts.sections.navbarclient.navbarclient')
    </header>

    <main class="flex-1 w-full max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-6 mt-12">
        @yield('content')
    </main>

    @extends('includes.script')
    @stack('scripts')

</body>
</html>
