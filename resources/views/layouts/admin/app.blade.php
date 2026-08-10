<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Admin Dashboard') - Ruang Cinema</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="bg-[#f5f7fa] font-sans text-gray-900">

    <x-admin.sidebar />

    <div class="lg:ml-64">

        <x-admin.navbar />

        <main class="p-4 sm:p-6 lg:p-8">
            @yield('content')
        </main>

    </div>

    @stack('scripts')

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showSuccessAlert(
                    @js(session('success_title', 'Berhasil')),
                    @js(session('success'))
                );
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.showErrorAlert(
                    @js(session('error_title', 'Terjadi kesalahan')),
                    @js(session('error'))
                );
            });
        </script>
    @endif

</body>

</html>
