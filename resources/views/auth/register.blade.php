<!DOCTYPE html>
<html
    lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('theme') === 'dark' }"
    x-init="document.documentElement.classList.toggle('dark', darkMode)"
    :class="{ dark: darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Register - Ruang Cinema</title>

    {{-- Prevent theme flash --}}
    <script>
        if (
            localStorage.getItem('theme') === 'dark' ||
            (!localStorage.getItem('theme') &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        }
    </script>

    {{-- Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-950 dark:bg-gray-950 dark:text-white lg:h-screen lg:overflow-hidden">

    <div class="relative mx-auto flex min-h-screen max-w-7xl overflow-hidden bg-white shadow-xl dark:bg-gray-900 lg:my-4 lg:h-[calc(100vh-2rem)] lg:min-h-0 lg:rounded-3xl">

        {{-- ========================================================= --}}
        {{-- THEME TOGGLE --}}
        {{-- ========================================================= --}}

        <button
            type="button"
            @click="
                darkMode = !darkMode;
                localStorage.setItem('theme', darkMode ? 'dark' : 'light');
                document.documentElement.classList.toggle('dark', darkMode);
            "
            class="absolute right-5 top-5 z-30 flex h-10 w-10 items-center justify-center rounded-full border border-gray-200 bg-white text-gray-600 shadow-sm transition hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700"
            aria-label="Toggle theme"
        >
            <x-icon
                name="moon"
                size="20"
                x-show="!darkMode"
            />

            <x-icon
                name="sun"
                size="20"
                x-show="darkMode"
            />
        </button>


        {{-- ========================================================= --}}
        {{-- LEFT PANEL --}}
        {{-- ========================================================= --}}

        <section class="relative hidden w-1/2 overflow-hidden bg-[#071426] p-8 text-white lg:flex lg:flex-col">

            {{-- Cinema background photo with a readable text overlay --}}
            <img
                src="{{ asset('storage/web/foto bioskop.jpg') }}"
                alt="Suasana bioskop"
                class="absolute inset-0 h-full w-full object-cover"
            >

            <div class="absolute inset-0 bg-gradient-to-b from-[#071426]/75 via-[#071426]/55 to-[#071426]/95"></div>

            {{-- Decorative circles --}}
            <div class="absolute -right-24 -top-24 h-64 w-64 rounded-full border border-white/15"></div>
            <div class="absolute -bottom-24 -left-24 h-64 w-64 rounded-full border border-white/15"></div>


            {{-- Logo --}}
            <div class="relative z-10">
                <x-ruang-cinema-logo variant="white" fit="contain" class="h-14 w-52 object-center" />
            </div>


            {{-- Left Description --}}
            <div class="relative z-10 mt-auto">

                <h2 class="text-3xl font-bold leading-tight">
                    Bergabung dengan kami.
                    <br>

                    <span class="text-gray-400">
                        Temukan film favoritmu.
                    </span>
                </h2>

                <p class="mt-3 max-w-md text-sm leading-6 text-gray-400">
                    Buat akun Ruang Cinema dan nikmati pengalaman
                    menemukan, menyimpan, dan berbagi film favoritmu.
                </p>

            </div>

        </section>


        {{-- ========================================================= --}}
        {{-- RIGHT PANEL --}}
        {{-- ========================================================= --}}

        <section class="flex w-full items-center justify-center bg-white px-6 py-8 dark:bg-gray-900 sm:px-10 lg:w-1/2 lg:px-16">

            <div class="w-full max-w-md">

                {{-- Mobile Logo --}}
                <div class="mb-5 flex justify-center lg:hidden">
                    <x-ruang-cinema-logo fit="contain" class="h-10 w-40 object-center dark:hidden" />
                    <x-ruang-cinema-logo variant="white" fit="contain" class="hidden h-10 w-40 object-center dark:block" />
                </div>


                {{-- Heading --}}
                <div class="text-center">

                    <h2 class="text-3xl font-bold tracking-tight text-gray-950 dark:text-white">
                        Create Account
                    </h2>

                    <p class="mx-auto mt-2 max-w-sm text-sm leading-5 text-gray-500 dark:text-gray-400">
                        Daftar untuk mulai menemukan dan menyimpan
                        film favoritmu.
                    </p>

                </div>


                {{-- Register Form --}}
                <form
                    method="POST"
                     action="{{ route('register') }}"
                    class="mt-6 space-y-3.5"
                    x-data="{
                        loading: false,
                        showPassword: false,
                        showConfirmation: false
                    }"
                    @submit="loading = true"
                >

                    @csrf


                    {{-- Name --}}
                    <div>

                        <label
                            for="name"
                            class="mb-1.5 block text-sm font-semibold"
                        >
                            Name
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <x-icon
                                    name="user"
                                    size="19"
                                />
                            </span>

                            <input
                                id="name"
                                type="text"
                                name="name"
                                value="{{ old('name') }}"
                                required
                                autofocus
                                autocomplete="name"
                                placeholder="Enter your name"
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 outline-none transition focus:border-gray-950 focus:ring-1 focus:ring-gray-950 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white"
                            >

                        </div>

                        @error('name')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Email --}}
                    <div>

                        <label
                            for="email"
                            class="mb-1.5 block text-sm font-semibold"
                        >
                            Email
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <x-icon
                                    name="mail"
                                    size="19"
                                />
                            </span>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autocomplete="username"
                                placeholder="email@example.com"
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-4 text-sm text-gray-900 outline-none transition focus:border-gray-950 focus:ring-1 focus:ring-gray-950 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white"
                            >

                        </div>

                        @error('email')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Password --}}
                    <div>

                        <label
                            for="password"
                            class="mb-1.5 block text-sm font-semibold"
                        >
                            Password
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <x-icon
                                    name="lock"
                                    size="19"
                                />
                            </span>

                            <input
                                id="password"
                                :type="showPassword ? 'text' : 'password'"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Create a password"
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-12 text-sm text-gray-900 outline-none transition focus:border-gray-950 focus:ring-1 focus:ring-gray-950 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white"
                            >

                            <button
                                type="button"
                                @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 transition hover:text-gray-700 dark:hover:text-gray-200"
                                aria-label="Toggle password visibility"
                            >

                                <x-icon
                                    name="eye"
                                    size="19"
                                    x-show="!showPassword"
                                />

                                <x-icon
                                    name="eye-off"
                                    size="19"
                                    x-show="showPassword"
                                />

                            </button>

                        </div>

                        @error('password')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Confirm Password --}}
                    <div>

                        <label
                            for="password_confirmation"
                            class="mb-1.5 block text-sm font-semibold"
                        >
                            Confirm Password
                        </label>

                        <div class="relative">

                            <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                                <x-icon
                                    name="lock-keyhole"
                                    size="19"
                                />
                            </span>

                            <input
                                id="password_confirmation"
                                :type="showConfirmation ? 'text' : 'password'"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Confirm your password"
                                class="w-full rounded-xl border border-gray-300 bg-white py-3 pl-11 pr-12 text-sm text-gray-900 outline-none transition focus:border-gray-950 focus:ring-1 focus:ring-gray-950 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:focus:border-white dark:focus:ring-white"
                            >

                            <button
                                type="button"
                                @click="showConfirmation = !showConfirmation"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 transition hover:text-gray-700 dark:hover:text-gray-200"
                                aria-label="Toggle password confirmation visibility"
                            >

                                <x-icon
                                    name="eye"
                                    size="19"
                                    x-show="!showConfirmation"
                                />

                                <x-icon
                                    name="eye-off"
                                    size="19"
                                    x-show="showConfirmation"
                                />

                            </button>

                        </div>

                        @error('password_confirmation')
                            <p class="mt-1 text-xs text-red-500">
                                {{ $message }}
                            </p>
                        @enderror

                    </div>


                    {{-- Register Button --}}
                    <button
                        type="submit"
                        :disabled="loading"
                        class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#071426] px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-gray-950 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-80 dark:bg-white dark:text-[#071426] dark:hover:bg-gray-200 dark:focus:ring-white"
                    >

                        {{-- Loader --}}
                        <span
                            x-show="loading"
                            class="flex items-center gap-2"
                        >
                            <svg
                                aria-hidden="true"
                                class="h-5 w-5 animate-spin"
                                viewBox="0 0 24 24"
                                fill="none"
                            >
                                <circle
                                    cx="12"
                                    cy="12"
                                    r="9"
                                    class="opacity-25"
                                    stroke="currentColor"
                                    stroke-width="3"
                                />

                                <path
                                    d="M21 12a9 9 0 0 1-9 9"
                                    class="opacity-90"
                                    stroke="currentColor"
                                    stroke-width="3"
                                    stroke-linecap="round"
                                />
                            </svg>

                            Creating account...
                        </span>


                        <span x-show="!loading">
                            Register
                        </span>

                    </button>


                    {{-- Login --}}
                    <p class="pt-1 text-center text-sm text-gray-500 dark:text-gray-400">

                        Sudah punya akun?

                        <a
                            href="{{ route('login') }}"
                            class="ml-1 font-semibold text-gray-950 hover:underline dark:text-white"
                        >
                            Login
                        </a>

                    </p>

                </form>

            </div>

        </section>

    </div>

</body>
</html>
