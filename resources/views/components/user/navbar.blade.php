<nav
    x-data="{ open: false }"
    class="sticky top-0 z-50 border-b border-gray-200 bg-white"
>

    {{-- DESKTOP NAVBAR --}}

    <div class="mx-auto hidden h-[86px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:flex lg:px-8">

        {{-- Logo --}}
        <a
            href="{{ route('home') }}"
            class="flex items-center gap-3"
        >

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-gray-950 text-white">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                    />
                </svg>

            </div>

            <div class="leading-none">

                <span class="block text-base font-semibold text-gray-950">
                    Ruang
                </span>

                <span class="mt-1 block text-[10px] font-medium tracking-[0.25em] text-gray-500">
                    CINEMA
                </span>

            </div>

        </a>


        {{-- Navigation --}}
        <div class="flex items-center gap-8">

            <a
                href="{{ route('home') }}"
                class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                Home
            </a>

            <a
                href="{{ route('movies.index') }}"
                class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                Movies
            </a>

            <a
                href="#genres"
                class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                Genres
            </a>

            <a
                href="#about"
                class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                About
            </a>

        </div>


        {{-- Right --}}
        <div class="flex items-center gap-7">

            {{-- Search --}}
            <button
                type="button"
                class="text-gray-700 transition hover:text-gray-950"
                aria-label="Search"
            >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.8"
                    stroke="currentColor"
                    class="h-5 w-5"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                    />
                </svg>
            </button>


            @guest

                <a
                    href="{{ route('login') }}"
                    class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
                >
                    Login
                </a>

                <a
                    href="{{ route('register') }}"
                    class="rounded-full bg-gray-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                >
                    Register
                </a>

            @else

                <a
                    href="{{ route('dashboard') }}"
                    class="text-sm font-medium text-gray-700 transition hover:text-gray-950"
                >
                    Dashboard
                </a>

            @endguest

        </div>

    </div>


    {{-- ============================= --}}
    {{-- MOBILE NAVBAR --}}
    {{-- ============================= --}}

    <div class="flex h-[64px] items-center justify-between px-4 lg:hidden">

        {{-- Logo --}}
        <a
            href="{{ route('home') }}"
            class="flex items-center gap-2.5"
        >

            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-950 text-white">

                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.6"
                    stroke="currentColor"
                    class="h-4 w-4"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                    />
                </svg>

            </div>

            <div class="leading-none">

                <span class="block text-sm font-semibold text-gray-950">
                    Ruang
                </span>

                <span class="mt-0.5 block text-[8px] font-medium tracking-[0.25em] text-gray-500">
                    CINEMA
                </span>

            </div>

        </a>


        {{-- Hamburger --}}
        <button
            type="button"
            @click="open = true"
            class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-100 text-gray-700 transition hover:bg-gray-200"
            aria-label="Open menu"
        >

            <svg
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="1.8"
                stroke="currentColor"
                class="h-5 w-5"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 7h16M4 12h16M4 17h16"
                />
            </svg>

        </button>

    </div>


    {{-- ============================= --}}
    {{-- MOBILE SIDEBAR --}}
    {{-- ============================= --}}

    <div
        x-cloak
        x-show="open"
        class="fixed inset-0 z-[100] lg:hidden"
        @keydown.escape.window="open = false"
    >

        {{-- Backdrop --}}
        <div
            x-show="open"
            x-transition:enter="transition-opacity duration-300 ease-out"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity duration-200 ease-in"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="open = false"
            class="absolute inset-0 bg-gray-950/30 backdrop-blur-sm"
        ></div>


        {{-- Sidebar --}}
        <aside
            x-show="open"
            x-transition:enter="transform transition duration-300 ease-out"
            x-transition:enter-start="-translate-x-full"
            x-transition:enter-end="translate-x-0"
            x-transition:leave="transform transition duration-250 ease-in"
            x-transition:leave-start="translate-x-0"
            x-transition:leave-end="-translate-x-full"
            class="relative flex h-full w-[280px] max-w-[85vw] flex-col bg-white shadow-2xl"
        >

            {{-- Sidebar Header --}}
            <div class="flex h-[64px] items-center justify-between border-b border-gray-200 px-5">

                <a
                    href="{{ route('home') }}"
                    @click="open = false"
                    class="flex items-center gap-2.5"
                >

                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-gray-950 text-white">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.6"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                            />
                        </svg>

                    </div>

                    <div class="leading-none">

                        <span class="block text-sm font-semibold text-gray-950">
                            Ruang
                        </span>

                        <span class="mt-0.5 block text-[8px] font-medium tracking-[0.25em] text-gray-500">
                            CINEMA
                        </span>

                    </div>

                </a>


                {{-- Close --}}
                <button
                    type="button"
                    @click="open = false"
                    class="flex h-9 w-9 items-center justify-center rounded-lg text-gray-500 transition hover:bg-gray-100 hover:text-gray-950"
                    aria-label="Close menu"
                >

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-5 w-5"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 6l12 12M18 6 6 18"
                        />
                    </svg>

                </button>

            </div>


            {{-- Navigation --}}
            <div class="flex flex-1 flex-col px-5 py-7">

                <p class="mb-3 px-3 text-[10px] font-semibold uppercase tracking-[0.2em] text-gray-400">
                    Menu
                </p>


                <div class="space-y-1">

                    <a
                        href="{{ route('home') }}"
                        @click="open = false"
                        class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                    >
                        Home
                    </a>

                    <a
                        href="{{ route('movies.index') }}"
                        @click="open = false"
                        class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                    >
                        Movies
                    </a>

                    <a
                        href="#genres"
                        @click="open = false"
                        class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                    >
                        Genres
                    </a>

                    <a
                        href="#about"
                        @click="open = false"
                        class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                    >
                        About
                    </a>

                </div>


                {{-- Bottom --}}
                <div class="mt-auto border-t border-gray-200 pt-6">

                    @guest

                        <a
                            href="{{ route('login') }}"
                            @click="open = false"
                            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Login
                        </a>

                        <a
                            href="{{ route('register') }}"
                            @click="open = false"
                            class="mt-2 flex items-center justify-center rounded-xl bg-gray-950 px-4 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                        >
                            Register
                        </a>

                    @else

                        <a
                            href="{{ route('dashboard') }}"
                            @click="open = false"
                            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Dashboard
                        </a>

                    @endguest

                </div>

            </div>

        </aside>

    </div>

</nav>
