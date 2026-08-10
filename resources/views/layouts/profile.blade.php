<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Profile') - Ruang Cinema</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="min-h-screen bg-[#f5f7fa] font-sans text-gray-900 antialiased">
    @if (auth()->user()->role === 'admin')
        <x-admin.sidebar />

        <div class="lg:ml-64">
            <x-admin.navbar />
            <main class="p-4 sm:p-6 lg:p-8">
                @yield('content')
            </main>
        </div>
    @else
        @include('components.user.navbar')

        <main class="px-4 py-8 sm:px-6 lg:px-8">
            @yield('content')
        </main>

        @include('components.user.footer')
    @endif

    @stack('scripts')
</body>

</html>
