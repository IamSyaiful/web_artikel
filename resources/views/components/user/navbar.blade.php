<nav
    x-data="{ open: false, userMenuOpen: false }"
    class="sticky top-0 z-50 border-b border-gray-200 bg-white"
>

    {{-- DESKTOP NAVBAR --}}

    <div class="mx-auto hidden h-[86px] max-w-7xl items-center justify-between px-4 sm:px-6 lg:flex lg:px-8">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <x-ruang-cinema-logo fit="contain" class="h-10 w-40 object-center" />
        </a>


        {{-- Navigation --}}
        <div class="flex items-center gap-8">

            <a
                href="{{ route('home') }}"
                class="group relative py-2 text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                Home
                <span class="absolute inset-x-0 bottom-0 h-0.5 origin-center scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100 @if (request()->routeIs('home')) scale-x-100 @endif"></span>
            </a>

            <a
                href="{{ route('movies.index') }}"
                class="group relative py-2 text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                Movies
                <span class="absolute inset-x-0 bottom-0 h-0.5 origin-center scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100 @if (request()->routeIs('movies.*')) scale-x-100 @endif"></span>
            </a>

            <a
                href="#about"
                class="group relative py-2 text-sm font-medium text-gray-700 transition hover:text-gray-950"
            >
                About
                <span class="absolute inset-x-0 bottom-0 h-0.5 origin-center scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100"></span>
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

                <div class="relative" @keydown.escape.window="userMenuOpen = false" @click.outside="userMenuOpen = false">
                    <button
                        type="button"
                        @click="userMenuOpen = !userMenuOpen"
                        class="flex items-center gap-3 text-left"
                        :aria-expanded="userMenuOpen"
                        aria-haspopup="true"
                    >
                        <span class="hidden sm:block">
                            <span class="block text-sm font-semibold text-gray-950">{{ auth()->user()->name }}</span>
                        </span>

                        <span class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-100 text-gray-500">
                            <x-icon name="user-round" size="20" />
                        </span>

                        <x-icon name="chevron-down" size="16" class="text-gray-500 transition" x-bind:class="{ 'rotate-180': userMenuOpen }" />
                    </button>

                    <div
                        x-cloak
                        x-show="userMenuOpen"
                        x-transition
                        class="absolute right-0 top-full z-50 mt-3 w-48 rounded-xl border border-gray-200 bg-white p-2 shadow-lg"
                    >
                        <a
                            href="{{ route('profile.edit') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                        >
                            <x-icon name="user-round" size="17" />
                            Profile
                        </a>

                        <a
                            href="{{ route('favorites') }}"
                            class="flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                        >
                            <x-icon name="heart" size="17" />
                            Favorite
                        </a>

                        <div class="my-1 border-t border-gray-100"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center gap-3 rounded-lg px-3 py-2.5 text-left text-sm text-red-600 transition hover:bg-red-50"
                            >
                                <x-icon name="log-out" size="17" />
                                Logout
                            </button>
                        </form>
                    </div>
                </div>

            @endguest

        </div>

    </div>


    {{-- ============================= --}}
    {{-- MOBILE NAVBAR --}}
    {{-- ============================= --}}

    <div class="flex h-[64px] items-center justify-between px-4 lg:hidden">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center">
            <x-ruang-cinema-logo fit="contain" class="h-8 w-32 object-center" />
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

                <a href="{{ route('home') }}" @click="open = false" class="flex items-center">
                    <x-ruang-cinema-logo fit="contain" class="h-8 w-32 object-center" />
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
                        class="group relative flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:text-gray-950"
                    >
                        Home
                        <span class="absolute bottom-2 left-3 h-0.5 w-10 origin-left scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100 @if (request()->routeIs('home')) scale-x-100 @endif"></span>
                    </a>

                    <a
                        href="{{ route('movies.index') }}"
                        @click="open = false"
                        class="group relative flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:text-gray-950"
                    >
                        Movies
                        <span class="absolute bottom-2 left-3 h-0.5 w-10 origin-left scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100 @if (request()->routeIs('movies.*')) scale-x-100 @endif"></span>
                    </a>

                    <a
                        href="#about"
                        @click="open = false"
                        class="group relative flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:text-gray-950"
                    >
                        About
                        <span class="absolute bottom-2 left-3 h-0.5 w-10 origin-left scale-x-0 rounded-full bg-gray-950 transition-transform duration-300 ease-out group-hover:scale-x-100"></span>
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
                            href="{{ route('profile.edit') }}"
                            @click="open = false"
                            class="flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100"
                        >
                            Profile
                        </a>

                        <a
                            href="{{ route('favorites') }}"
                            @click="open = false"
                            class="mt-1 flex items-center rounded-xl px-3 py-3 text-sm font-medium text-gray-700 transition hover:bg-gray-100 hover:text-gray-950"
                        >
                            Favorite
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="mt-1">
                            @csrf
                            <button
                                type="submit"
                                class="flex w-full items-center rounded-xl px-3 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50"
                            >
                                Logout
                            </button>
                        </form>

                    @endguest

                </div>

            </div>

        </aside>

    </div>

</nav>
