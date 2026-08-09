<footer class="border-t border-gray-200 bg-white">

    <div class="mx-auto max-w-7xl px-6 py-10 sm:px-8 lg:px-10">

        {{-- Main Footer --}}
        <div class="grid gap-10 sm:grid-cols-2 lg:grid-cols-[1.5fr_1fr_1fr_1fr]">

            {{-- Brand --}}
            <div>

                <a href="{{ route('home') }}" class="inline-flex items-center">
                    <x-ruang-cinema-logo fit="contain" class="h-8 w-36 object-center" />
                </a>

                <p class="mt-4 max-w-xs text-sm leading-6 text-gray-600">
                    Platform review & rekomendasi film untuk semua pecinta film
                    di Indonesia.
                </p>

            </div>


            {{-- Menu --}}
            <div>

                <h3 class="text-sm font-bold text-gray-950">
                    Menu
                </h3>

                <ul class="mt-4 space-y-2.5 text-xs text-gray-600">

                    <li>
                        <a
                            href="{{ route('home') }}"
                            class="transition hover:text-gray-950"
                        >
                            Home
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('movies.index') }}"
                            class="transition hover:text-gray-950"
                        >
                            Movies
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('movies.index') }}"
                            class="transition hover:text-gray-950"
                        >
                            Genres
                        </a>
                    </li>

                    <li>
                        <a
                            href="{{ route('home') }}#about"
                            class="transition hover:text-gray-950"
                        >
                            About Us
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Bantuan --}}
            <div>

                <h3 class="text-sm font-bold text-gray-950">
                    Bantuan
                </h3>

                <ul class="mt-4 space-y-2.5 text-xs text-gray-600">

                    <li>
                        <a href="#" class="transition hover:text-gray-950">
                            FAQ
                        </a>
                    </li>

                    <li>
                        <a href="#" class="transition hover:text-gray-950">
                            Kebijakan Privasi
                        </a>
                    </li>

                    <li>
                        <a href="#" class="transition hover:text-gray-950">
                            Syarat & Ketentuan
                        </a>
                    </li>

                    <li>
                        <a href="#" class="transition hover:text-gray-950">
                            Hubungi Kami
                        </a>
                    </li>

                </ul>

            </div>


            {{-- Ikuti Kami --}}
            <div>

                <h3 class="text-sm font-bold text-gray-950">
                    Ikuti Kami
                </h3>

                <div class="mt-5 flex items-center gap-4">

                    {{-- Instagram --}}
                    <a
                        href="#"
                        aria-label="Instagram"
                        class="text-gray-800 transition hover:text-gray-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4"
                        >
                            <rect
                                width="18"
                                height="18"
                                x="3"
                                y="3"
                                rx="5"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="4"
                            />

                            <path
                                stroke-linecap="round"
                                d="M17.5 6.5h.01"
                            />
                        </svg>
                    </a>


                    {{-- X --}}
                    <a
                        href="#"
                        aria-label="X"
                        class="text-gray-800 transition hover:text-gray-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-4 w-4"
                        >
                            <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24h-6.657l-5.214-6.817-5.963 6.817H1.684l7.73-8.835L1.258 2.25h6.826l4.713 6.231 5.447-6.231Zm-1.161 17.52h1.833L7.084 4.126H5.117L17.083 19.77Z"/>
                        </svg>
                    </a>


                    {{-- Facebook --}}
                    <a
                        href="#"
                        aria-label="Facebook"
                        class="text-gray-800 transition hover:text-gray-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-4 w-4"
                        >
                            <path d="M13.5 21v-8h2.75l.5-3h-3.25V8.05c0-.87.24-1.55 1.6-1.55h1.7V3.82c-.29-.04-1.28-.12-2.43-.12-2.4 0-4.05 1.46-4.05 4.15V10H7.5v3h2.82v8h3.18Z"/>
                        </svg>
                    </a>


                    {{-- YouTube --}}
                    <a
                        href="#"
                        aria-label="YouTube"
                        class="text-gray-800 transition hover:text-gray-500"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            viewBox="0 0 24 24"
                            fill="currentColor"
                            class="h-4 w-4"
                        >
                            <path d="M21.58 7.19a2.98 2.98 0 0 0-2.1-2.1C17.63 4.6 12 4.6 12 4.6s-5.63 0-7.48.49a2.98 2.98 0 0 0-2.1 2.1C1.93 9.04 1.93 12 1.93 12s0 2.96.49 4.81a2.98 2.98 0 0 0 2.1 2.1c1.85.49 7.48.49 7.48.49s5.63 0 7.48-.49a2.98 2.98 0 0 0 2.1-2.1c.49-1.85.49-4.81.49-4.81s0-2.96-.49-4.81ZM10.03 15.4V8.6L15.9 12l-5.87 3.4-5.87-3.4Z"/>
                        </svg>
                    </a>

                </div>

            </div>

        </div>


        {{-- Copyright --}}
        <div class="mt-8 border-t border-gray-200 pt-5 text-center">

            <p class="text-[11px] text-gray-500">
                © {{ date('Y') }} Ruang Cinema. All rights reserved.
            </p>

        </div>

    </div>

</footer>
