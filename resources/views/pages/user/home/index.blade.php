@extends('layouts.user.app')

@section('title', 'Ruang Cinema')

@section('description', 'Temukan film, baca review, berikan komentar, dan simpan film favoritmu.')

@section('content')

    {{-- Hero Section --}}
    <section class="relative overflow-hidden bg-white pt-20">

        {{-- Background Decoration --}}
        <div class="pointer-events-none absolute inset-0">
            <div class="absolute -right-32 -top-32 h-96 w-96 rounded-full bg-gray-100 blur-3xl"></div>
            <div class="absolute -bottom-32 -left-32 h-96 w-96 rounded-full bg-gray-100 blur-3xl"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 py-20 sm:px-6 sm:py-24 lg:px-8 lg:py-28">

            <div class="grid items-center gap-16 lg:grid-cols-2">

                {{-- Hero Content --}}
                <div class="max-w-2xl">

                    {{-- Small Label --}}
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-gray-200 bg-gray-50 px-4 py-2">
                        <span class="h-2 w-2 rounded-full bg-gray-900"></span>

                        <span class="text-sm font-medium text-gray-600">
                            Your Personal Cinema Space
                        </span>
                    </div>

                    {{-- Heading --}}
                    <h1 class="text-5xl font-bold leading-[1.05] tracking-tight text-gray-950 sm:text-6xl lg:text-7xl">
                        Discover Your
                        <span class="block text-gray-400">
                            Next Favorite Movie.
                        </span>
                    </h1>

                    {{-- Description --}}
                    <p class="mt-7 max-w-xl text-base leading-7 text-gray-600 sm:text-lg">
                        Temukan film yang ingin kamu tonton, baca review,
                        bagikan pendapatmu, dan simpan film favoritmu
                        dalam satu ruang.
                    </p>

                    {{-- CTA --}}
                    <div class="mt-9 flex flex-col gap-3 sm:flex-row">

                        <a
                            href="{{ route('movies.index') }}"
                            class="inline-flex items-center justify-center gap-2 rounded-full bg-gray-950 px-6 py-3.5 text-sm font-semibold text-white transition duration-200 hover:bg-gray-800"
                        >
                            Explore Movies

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
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                />
                            </svg>
                        </a>

                        <a
                            href="#about"
                            class="inline-flex items-center justify-center rounded-full border border-gray-300 px-6 py-3.5 text-sm font-semibold text-gray-700 transition duration-200 hover:border-gray-400 hover:bg-gray-50"
                        >
                            Learn More
                        </a>

                    </div>

                    {{-- Small Stats --}}
                    <div class="mt-12 flex flex-wrap items-center gap-x-8 gap-y-4 border-t border-gray-200 pt-7">

                        <div>
                            <p class="text-2xl font-bold text-gray-950">
                                100+
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Movies
                            </p>
                        </div>

                        <div class="h-10 w-px bg-gray-200"></div>

                        <div>
                            <p class="text-2xl font-bold text-gray-950">
                                10+
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Genres
                            </p>
                        </div>

                        <div class="h-10 w-px bg-gray-200"></div>

                        <div>
                            <p class="text-2xl font-bold text-gray-950">
                                Community
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Movie Lovers
                            </p>
                        </div>

                    </div>

                </div>


                {{-- Hero Visual --}}
                <div class="relative mx-auto w-full max-w-xl lg:ml-auto">

                    {{-- Decorative Circle --}}
                    <div class="absolute left-1/2 top-1/2 h-80 w-80 -translate-x-1/2 -translate-y-1/2 rounded-full border border-gray-200 sm:h-96 sm:w-96"></div>

                    <div class="absolute left-1/2 top-1/2 h-64 w-64 -translate-x-1/2 -translate-y-1/2 rounded-full border border-dashed border-gray-300 sm:h-80 sm:w-80"></div>


                    {{-- Main Movie Card --}}
                    <div class="relative mx-auto w-64 sm:w-72">

                        <div class="relative aspect-[2/3] overflow-hidden rounded-3xl bg-gray-950 shadow-2xl">

                            {{-- Poster Decoration --}}
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-800 via-gray-950 to-black"></div>

                            <div class="absolute -right-20 -top-20 h-52 w-52 rounded-full bg-white/10 blur-2xl"></div>

                            <div class="absolute -bottom-20 -left-20 h-52 w-52 rounded-full bg-gray-500/20 blur-2xl"></div>


                            {{-- Film Icon --}}
                            <div class="absolute inset-0 flex flex-col items-center justify-center px-8 text-center">

                                <div class="mb-6 flex h-20 w-20 items-center justify-center rounded-2xl border border-white/20 bg-white/10 backdrop-blur">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="none"
                                        stroke="currentColor"
                                        class="h-10 w-10 text-white"
                                        stroke-width="1.5"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                                        />
                                    </svg>
                                </div>

                                <p class="text-xs font-medium uppercase tracking-[0.3em] text-gray-400">
                                    Ruang Cinema
                                </p>

                                <h2 class="mt-4 text-3xl font-bold tracking-tight text-white">
                                    Your Movie
                                    <span class="block text-gray-400">
                                        Journey
                                    </span>
                                </h2>

                                <p class="mt-4 text-sm leading-6 text-gray-400">
                                    Explore stories.
                                    Discover favorites.
                                </p>

                            </div>


                            {{-- Bottom Information --}}
                            <div class="absolute bottom-0 left-0 right-0 border-t border-white/10 bg-black/30 p-5 backdrop-blur">

                                <div class="flex items-center justify-between">

                                    <div>
                                        <p class="text-xs uppercase tracking-wider text-gray-500">
                                            Now Exploring
                                        </p>

                                        <p class="mt-1 text-sm font-semibold text-white">
                                            Movies & Stories
                                        </p>
                                    </div>

                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-white text-gray-950">
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
                                                d="M12 6v6l4 2"
                                            />
                                        </svg>
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- Floating Rating Card --}}
                    <div class="absolute -left-2 top-12 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl sm:-left-8">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gray-950 text-white">
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
                                        d="m12 3 2.8 5.7 6.2.9-4.5 4.4 1.1 6.2L12 17.3 6.4 20.2l1.1-6.2L3 9.6l6.2-.9L12 3Z"
                                    />
                                </svg>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500">
                                    Movie Rating
                                </p>

                                <p class="text-sm font-bold text-gray-950">
                                    4.8 / 5.0
                                </p>
                            </div>

                        </div>

                    </div>


                    {{-- Floating Community Card --}}
                    <div class="absolute -bottom-5 -right-2 rounded-2xl border border-gray-200 bg-white p-4 shadow-xl sm:-right-8">

                        <div class="flex items-center gap-3">

                            <div class="flex -space-x-2">

                                <div class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-gray-800 text-xs font-bold text-white">
                                    R
                                </div>

                                <div class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-gray-600 text-xs font-bold text-white">
                                    C
                                </div>

                                <div class="flex h-9 w-9 items-center justify-center rounded-full border-2 border-white bg-gray-400 text-xs font-bold text-white">
                                    +
                                </div>

                            </div>

                            <div>
                                <p class="text-sm font-bold text-gray-950">
                                    Movie Community
                                </p>

                                <p class="text-xs text-gray-500">
                                    Share your thoughts
                                </p>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>
    </section>

    {{-- Feature Section --}}
    <section class="bg-gray-50 py-20 sm:py-24 lg:py-28">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Heading --}}
            <div class="mx-auto max-w-2xl text-center">

                <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Everything You Need
                </span>

                <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">
                    Your Movie Experience,
                    <span class="text-gray-400">
                        All in One Place.
                    </span>
                </h2>

                <p class="mt-5 text-base leading-7 text-gray-600">
                    Ruang Cinema membantu kamu menemukan film,
                    membaca pendapat komunitas, dan menyimpan
                    film yang ingin kamu tonton kembali.
                </p>

            </div>


            {{-- Feature Cards --}}
            <div class="mt-14 grid gap-6 md:grid-cols-3">

                {{-- Discover Movies --}}
                <div class="group rounded-3xl border border-gray-200 bg-white p-8 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-950 text-white transition duration-300 group-hover:scale-105">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-7 w-7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-7 text-xl font-bold text-gray-950">
                        Discover Movies
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Jelajahi berbagai film berdasarkan judul,
                        genre, rating, dan informasi lainnya untuk
                        menemukan film yang sesuai dengan seleramu.
                    </p>

                    <a
                        href="{{ route('movies.index') }}"
                        class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
                    >
                        Explore Movies

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4 transition group-hover:translate-x-1"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </a>

                </div>


                {{-- Read Reviews --}}
                <div class="group rounded-3xl border border-gray-200 bg-white p-8 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-950 text-white transition duration-300 group-hover:scale-105">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-7 w-7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M8.25 9.75h7.5m-7.5 3h4.5M6.75 19.5h10.5A2.25 2.25 0 0 0 19.5 17.25v-9A2.25 2.25 0 0 0 17.25 6H6.75A2.25 2.25 0 0 0 4.5 8.25v9a2.25 2.25 0 0 0 2.25 2.25Z"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-7 text-xl font-bold text-gray-950">
                        Read Reviews
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Baca komentar dan pendapat pengguna lain
                        sebelum menonton sebuah film, atau bagikan
                        pendapatmu setelah menontonnya.
                    </p>

                    <a
                        href="{{ route('movies.index') }}"
                        class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
                    >
                        Read Reviews

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.8"
                            stroke="currentColor"
                            class="h-4 w-4 transition group-hover:translate-x-1"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                            />
                        </svg>
                    </a>

                </div>


                {{-- Save Favorites --}}
                <div class="group rounded-3xl border border-gray-200 bg-white p-8 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                    <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gray-950 text-white transition duration-300 group-hover:scale-105">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.7"
                            stroke="currentColor"
                            class="h-7 w-7"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M21 8.25c0 5.25-9 10.5-9 10.5S3 13.5 3 8.25A4.25 4.25 0 0 1 7.25 4c1.6 0 3.05.9 3.75 2.25A4.25 4.25 0 0 1 14.75 4 4.25 4.25 0 0 1 19 8.25Z"
                            />
                        </svg>

                    </div>

                    <h3 class="mt-7 text-xl font-bold text-gray-950">
                        Save Favorites
                    </h3>

                    <p class="mt-3 text-sm leading-6 text-gray-600">
                        Simpan film yang menarik perhatianmu ke
                        daftar favorit agar mudah ditemukan kembali
                        kapan saja dan bisa kamu lihat kembali di daftar film favorite.
                    </p>

                    @auth
                        <a
                            href="{{ route('favorites') }}"
                            class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
                        >
                            My Favorites

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4 transition group-hover:translate-x-1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                />
                            </svg>
                        </a>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
                        >
                            Login to Save

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="h-4 w-4 transition group-hover:translate-x-1"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                />
                            </svg>
                        </a>
                    @endauth

                </div>

            </div>

        </div>

    </section>

    {{-- Trending Movies Section --}}
    <section class="bg-white py-20 sm:py-24 lg:py-28">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex items-end justify-between gap-6">

                <div>

                    <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                        Trending Movies
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">
                        Stories Worth
                        <span class="text-gray-400">
                            Watching.
                        </span>
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-gray-600 sm:text-base">
                        Film yang sedang populer minggu ini.
                    </p>

                </div>


                {{-- View All --}}
                <a
                    href="{{ route('movies.index') }}"
                    class="hidden shrink-0 items-center gap-2 rounded-md border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-800 transition hover:border-gray-400 hover:bg-gray-50 sm:inline-flex"
                >
                    View All Movies

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9 18 6-6-6-6"
                        />
                    </svg>

                </a>

            </div>


            {{-- Movies Carousel --}}
            <div class="relative mt-8" data-horizontal-carousel>

                {{-- Movie List --}}
                <div
                    data-horizontal-carousel-viewport
                    class="overflow-hidden"
                >

                    <div
                        id="trending-movies"
                        data-horizontal-carousel-track
                        class="flex gap-5 pb-4 transition-transform duration-500 ease-out"
                    >

                    @forelse ($movies as $movie)

                        <div class="w-[78%] shrink-0 sm:w-[48%] lg:w-[calc((100%-5rem)/5)]">

                            <x-user.movie-card
                                :movie="$movie"
                                compact
                            />

                        </div>

                    @empty

                        <div class="w-full rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-16 text-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="mx-auto h-10 w-10 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                                />
                            </svg>

                            <h3 class="mt-4 text-base font-semibold text-gray-900">
                                No Movies Available
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                Belum ada film yang tersedia di Ruang Cinema.
                            </p>

                        </div>

                    @endforelse

                    </div>

                </div>


                {{-- Previous Button --}}
                @if ($movies->count() > 5)
                    <button type="button" data-horizontal-carousel-prev class="absolute left-0 top-1/2 hidden h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-800 shadow-sm transition hover:border-gray-400 hover:bg-gray-50" aria-label="Previous movies">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-5 w-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m15 18-6-6 6-6" />
                        </svg>
                    </button>
                @endif

                {{-- Next Button --}}
                @if ($movies->count() > 5)

                    <button
                        type="button"
                        data-horizontal-carousel-next
                        class="absolute right-0 top-1/2 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-gray-300 bg-white text-gray-800 shadow-sm transition hover:border-gray-400 hover:bg-gray-50"
                        aria-label="Next movies"
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
                                d="m9 18 6-6-6-6"
                            />
                        </svg>

                    </button>

                @endif

            </div>


            {{-- Mobile View All --}}
            <div class="mt-6 sm:hidden">

                <a
                    href="{{ route('movies.index') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900"
                >
                    View All Movies

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="m9 18 6-6-6-6"
                        />
                    </svg>

                </a>

            </div>

        </div>

    </section>

    {{-- Genres Section --}}
    <section class="bg-gray-50 py-20 sm:py-24 lg:py-28">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Section Header --}}
            <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">

                <div class="max-w-2xl">

                    <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                        Explore by Genre
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">
                        Find Stories
                        <span class="text-gray-400">
                            Your Way.
                        </span>
                    </h2>

                    <p class="mt-4 text-base leading-7 text-gray-600">
                        Jelajahi koleksi film berdasarkan genre dan
                        temukan cerita yang sesuai dengan suasana hatimu.
                    </p>

                </div>

                {{-- View All Movies --}}
                <a
                    href="{{ route('movies.index') }}"
                    class="inline-flex shrink-0 items-center gap-2 self-start rounded-full border border-gray-300 px-5 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-400 hover:bg-white sm:self-auto"
                >
                    Browse All Movies

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.8"
                        stroke="currentColor"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                        />
                    </svg>

                </a>

            </div>


            {{-- Genre Cards --}}
            <div class="mt-12 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">

                @forelse ($genres as $genre)

                    <div class="group relative overflow-hidden rounded-3xl border border-gray-200 bg-white p-6 transition duration-300 hover:-translate-y-1 hover:border-gray-300 hover:shadow-xl">

                        {{-- Decorative Number --}}
                        <div class="absolute -right-5 -top-8 text-8xl font-bold text-gray-50 transition duration-300 group-hover:text-gray-100">
                            {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                        </div>


                        <div class="relative">

                            {{-- Icon --}}
                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gray-950 text-white">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.6"
                                    stroke="currentColor"
                                    class="h-6 w-6"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V6.75Z"
                                    />

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="m8.25 15.75 2.25-2.25 2.25 2.25 3-3 2.25 2.25"
                                    />
                                </svg>

                            </div>


                            {{-- Genre Name --}}
                            <h3 class="mt-6 text-xl font-bold text-gray-950">
                                {{ $genre->name }}
                            </h3>


                            {{-- Movie Count --}}
                            <p class="mt-2 text-sm text-gray-500">
                                {{ $genre->movies_count }}
                                {{ $genre->movies_count == 1 ? 'Movie' : 'Movies' }}
                            </p>


                            {{-- Bottom Action --}}
                            <a
                                href="{{ route('movies.index') }}"
                                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
                            >
                                Explore Genre

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.8"
                                    stroke="currentColor"
                                    class="h-4 w-4 transition group-hover:translate-x-1"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3"
                                    />
                                </svg>

                            </a>

                        </div>

                    </div>

                @empty

                    <div class="col-span-full rounded-3xl border border-dashed border-gray-300 bg-white px-6 py-16 text-center">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="mx-auto h-12 w-12 text-gray-400"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4.5 6.75A2.25 2.25 0 0 1 6.75 4.5h10.5a2.25 2.25 0 0 1 2.25 2.25v10.5a2.25 2.25 0 0 1-2.25 2.25H6.75a2.25 2.25 0 0 1-2.25-2.25V6.75Z"
                            />
                        </svg>

                        <h3 class="mt-4 text-lg font-semibold text-gray-900">
                            No Genres Available
                        </h3>

                        <p class="mt-2 text-sm text-gray-500">
                            Belum ada genre yang tersedia di Ruang Cinema.
                        </p>

                    </div>

                @endforelse

            </div>

        </div>

    </section>

    {{-- About / Why Ruang Cinema Section --}}
    <section id="about" class="bg-white py-20 sm:py-24">

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

            {{-- Main About + Testimonials --}}
            <div class="grid gap-10 lg:grid-cols-2 lg:gap-12">

                {{-- =========================
                    WHY RUANG CINEMA
                ========================== --}}
                <div class="lg:border-r lg:border-gray-200 lg:pr-12">

                    <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                        Why Ruang Cinema
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">
                        Mengapa Ruang Cinema?
                    </h2>


                    {{-- Features --}}
                    <div class="mt-8 space-y-6">

                        {{-- Trusted Reviews --}}
                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-gray-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 text-gray-800"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 12.75 11.25 15 15 9.75M12 3.75l7.5 3v5.25c0 4.142-3.13 7.876-7.5 9-4.37-1.124-7.5-4.858-7.5-9V6.75l7.5-3Z"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-950">
                                    Review Terpercaya
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Ulasan dari pengguna nyata tanpa spoiler.
                                </p>
                            </div>

                        </div>


                        {{-- Active Community --}}
                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-gray-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 text-gray-800"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.37 9.37 0 0 0 2.25-.273V18a2.25 2.25 0 0 0-2.25-2.25h-1.5M15 19.128v-.003a6.75 6.75 0 0 0-6-6.75m6 6.753a9.37 9.37 0 0 1-2.25-.273V18a2.25 2.25 0 0 1 2.25-2.25h1.5M9 12.375a3.375 3.375 0 1 0 0-6.75 3.375 3.375 0 0 0 0 6.75ZM4.5 19.5a6.75 6.75 0 0 1 9-6.364"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-950">
                                    Komunitas Aktif
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Berdiskusi dengan pecinta film lainnya.
                                </p>
                            </div>

                        </div>


                        {{-- Safe & Comfortable --}}
                        <div class="flex items-start gap-4">

                            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gray-300 bg-gray-50">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke-width="1.5"
                                    stroke="currentColor"
                                    class="h-5 w-5 text-gray-800"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M16.5 10.5V6.75a4.5 4.5 0 0 0-9 0v3.75m-.75 0h10.5A1.5 1.5 0 0 1 18.75 12v7.5A1.5 1.5 0 0 1 17.25 21H6.75a1.5 1.5 0 0 1-1.5-1.5V12a1.5 1.5 0 0 1 1.5-1.5Z"
                                    />
                                </svg>

                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-gray-950">
                                    Aman & Nyaman
                                </h3>

                                <p class="mt-1 text-sm leading-6 text-gray-600">
                                    Akunmu aman, pengalamanmu nyaman.
                                </p>
                            </div>

                        </div>

                    </div>

                </div>


                {{-- =========================
                    TESTIMONIALS
                ========================== --}}
                <div>

                    <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                        Community Voices
                    </span>

                    <h2 class="mt-3 text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl">
                        Apa Kata Mereka?
                    </h2>


                    {{-- Testimonials --}}
                    <div class="mt-8 grid gap-4 sm:grid-cols-3 lg:grid-cols-1 xl:grid-cols-3">

                        {{-- Testimonial 1 --}}
                        <div class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="text-3xl font-bold leading-none text-gray-300">
                                “
                            </div>

                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                Ruang Cinema membantu saya menemukan banyak film bagus
                                yang sebelumnya tidak saya tahu.
                            </p>

                            <div class="mt-auto flex items-center gap-3 pt-8">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-5 w-5 text-gray-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1-7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-950">
                                        Andi Pratama
                                    </p>

                                    <p class="text-[11px] text-gray-500">
                                        Pengguna
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Testimonial 2 --}}
                        <div class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="text-3xl font-bold leading-none text-gray-300">
                                “
                            </div>

                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                Fitur favorit dan review-nya sangat membantu saya
                                menemukan film yang ingin ditonton.
                            </p>

                            <div class="mt-auto flex items-center gap-3 pt-8">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-5 w-5 text-gray-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1-7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-950">
                                        Dewi Lestari
                                    </p>

                                    <p class="text-[11px] text-gray-500">
                                        Pengguna
                                    </p>
                                </div>

                            </div>

                        </div>


                        {{-- Testimonial 3 --}}
                        <div class="flex h-full flex-col rounded-2xl border border-gray-200 bg-white p-5">

                            <div class="text-3xl font-bold leading-none text-gray-300">
                                “
                            </div>

                            <p class="mt-3 text-sm leading-6 text-gray-700">
                                Komunitasnya seru dan selalu ada diskusi menarik
                                tentang film terbaru!
                            </p>

                            <div class="mt-auto flex items-center gap-3 pt-8">

                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-gray-100">
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke-width="1.5"
                                        stroke="currentColor"
                                        class="h-5 w-5 text-gray-400"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1-7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                        />
                                    </svg>
                                </div>

                                <div>
                                    <p class="text-xs font-bold text-gray-950">
                                        Bima Setyawan
                                    </p>

                                    <p class="text-[11px] text-gray-500">
                                        Pengguna
                                    </p>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- =========================
                CTA
            ========================== --}}
            <div class="mt-12 overflow-hidden rounded-2xl border border-gray-300 bg-gray-50">

                <div class="flex flex-col gap-6 px-6 py-6 sm:flex-row sm:items-center sm:justify-between sm:px-8">

                    <div class="flex items-center gap-5">

                        {{-- Cinema Icon --}}
                        <div class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-gray-200">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.5"
                                stroke="currentColor"
                                class="h-7 w-7 text-gray-900"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M3.75 7.5h16.5M3.75 16.5h16.5M6.75 4.5v3M11.25 4.5v3M15.75 4.5v3M6.75 16.5v3M11.25 16.5v3M15.75 16.5v3"
                                />
                            </svg>

                        </div>


                        <div>

                            <h3 class="text-lg font-bold text-gray-950 sm:text-xl">
                                Siap menemukan film favoritmu berikutnya?
                            </h3>

                            <p class="mt-1 text-sm text-gray-600">
                                Bergabung sekarang dan jadi bagian dari komunitas pecinta film.
                            </p>

                        </div>

                    </div>


                    {{-- CTA Button --}}
                    <a
                        href="{{ route('register') }}"
                        class="inline-flex shrink-0 items-center justify-center rounded-lg bg-gray-950 px-6 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        Buat Akun Sekarang
                    </a>

                </div>

            </div>

        </div>

    </section>

@endsection
