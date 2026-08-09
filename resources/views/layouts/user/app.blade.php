<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('description', 'Ruang Cinema - Temukan, baca review, dan simpan film favoritmu.')">

    <title>@yield('title', 'Ruang Cinema')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="min-h-screen bg-white text-gray-900 antialiased">

    {{-- Navbar --}}
    @include('components.user.navbar')

    {{-- SweetAlert2 Flash Messages --}}
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showSuccessAlert(
                    'Success',
                    @js(session('success'))
                );
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showErrorAlert(
                    'Something went wrong',
                    @js(session('error'))
                );
            });
        </script>
    @endif

    @if (session('warning'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showWarningAlert(
                    'Warning',
                    @js(session('warning'))
                );
            });
        </script>
    @endif

    @if (session('info'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showInfoAlert(
                    'Information',
                    @js(session('info'))
                );
            });
        </script>
    @endif

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.user.footer')

    @stack('scripts')

</body>
</html>
