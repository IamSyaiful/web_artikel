@extends('layouts.user.app')

@section('title', 'Movies - Ruang Cinema')

@section('description', 'Temukan berbagai film favoritmu di Ruang Cinema.')

@section('content')

{{-- ========================================================= --}}
{{-- HERO SECTION --}}
{{-- ========================================================= --}}

<section class="border-b border-gray-200 bg-gray-50">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid min-h-[280px] items-center gap-10 py-14 lg:grid-cols-2 lg:py-16">

            {{-- Hero Text --}}
            <div>

                <span class="text-sm font-semibold uppercase tracking-[0.2em] text-gray-500">
                    Ruang Cinema
                </span>

                <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-950 sm:text-5xl">
                    Movies
                </h1>

                <p class="mt-4 max-w-xl text-base leading-7 text-gray-600 sm:text-lg">
                    Temukan film favoritmu. Review, rating, dan simpan film
                    yang ingin kamu tonton.
                </p>

            </div>


            {{-- Hero Illustration --}}
            <div class="hidden justify-center lg:flex">

                <div class="relative flex h-48 w-[360px] items-center justify-center">

                    {{-- Decorative circles --}}
                    <div class="absolute h-40 w-40 rounded-full border border-gray-200"></div>

                    <div class="absolute h-52 w-52 rounded-full border border-dashed border-gray-200"></div>


                    {{-- Film Reel --}}
                    <div class="relative z-10 flex h-32 w-32 items-center justify-center rounded-full border-2 border-gray-300">

                        <div class="grid h-20 w-20 grid-cols-2 gap-2">

                            <span class="rounded-full border-2 border-gray-300"></span>
                            <span class="rounded-full border-2 border-gray-300"></span>
                            <span class="rounded-full border-2 border-gray-300"></span>
                            <span class="rounded-full border-2 border-gray-300"></span>

                        </div>

                        <div class="absolute h-6 w-6 rounded-full border-2 border-gray-300"></div>

                    </div>


                    {{-- Clapper --}}
                    <div class="absolute right-4 top-5 z-20 w-36 rotate-[-8deg]">

                        <div class="h-5 rounded-md border-2 border-gray-300 bg-gray-200"></div>

                        <div class="mt-1 h-20 rounded-md border-2 border-gray-300 bg-gray-100">

                            <div class="mt-5 h-px bg-gray-300"></div>

                            <div class="mt-5 h-px bg-gray-300"></div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</section>


{{-- ========================================================= --}}
{{-- MOVIE EXPLORER --}}
{{-- ========================================================= --}}

<section class="bg-white py-8 sm:py-12">

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">

        <div class="grid gap-6 lg:grid-cols-[200px_minmax(0,1fr)]">


            {{-- ================================================= --}}
            {{-- FILTER SIDEBAR --}}
            {{-- ================================================= --}}

            <aside class="h-fit rounded-xl border border-gray-200 bg-white">

                <form
                    action="{{ route('movies.index') }}"
                    method="GET"
                >

                    {{-- Filter Header --}}
                    <div class="flex items-center justify-between border-b border-gray-200 px-4 py-4">

                        <h2 class="text-base font-semibold text-gray-950">
                            Filter
                        </h2>

                        <a
                            href="{{ route('movies.index') }}"
                            class="text-xs font-medium text-gray-500 transition hover:text-gray-950"
                        >
                            Reset
                        </a>

                    </div>


                    {{-- Search --}}
                    <div class="border-b border-gray-200 p-4">

                        <div class="relative">

                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search movies..."
                                class="w-full rounded-lg border border-gray-300 bg-white py-2.5 pl-3 pr-9 text-xs text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-950 focus:ring-1 focus:ring-gray-950"
                            >

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.8"
                                stroke="currentColor"
                                class="absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-gray-500"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="m21 21-4.35-4.35m1.35-5.4a6.75 6.75 0 1 1-13.5 0 6.75 6.75 0 0 1 13.5 0Z"
                                />
                            </svg>

                        </div>

                    </div>


                    {{-- Genres --}}
                    <div class="border-b border-gray-200 p-4">

                        <div class="mb-4 flex items-center justify-between">

                            <h3 class="text-sm font-semibold text-gray-950">
                                Genres
                            </h3>

                            <span class="text-xs text-gray-400">
                                ^
                            </span>

                        </div>


                        <div class="space-y-3">

                            @foreach ($genres as $genre)

                                <label class="flex cursor-pointer items-center justify-between gap-2 text-xs text-gray-600">

                                    <span class="flex items-center gap-2">

                                        <input
                                            type="radio"
                                            name="genre"
                                            value="{{ $genre->id }}"
                                            @checked(request('genre') == $genre->id)
                                            class="h-3.5 w-3.5 border-gray-300 text-gray-950 focus:ring-gray-950"
                                        >

                                        <span>
                                            {{ $genre->name }}
                                        </span>

                                    </span>

                                    <span class="text-[11px] text-gray-400">
                                        ({{ $genre->movies_count }})
                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    {{-- Rating --}}
                    <div class="border-b border-gray-200 p-4">

                        <div class="mb-4 flex items-center justify-between">

                            <h3 class="text-sm font-semibold text-gray-950">
                                Rating
                            </h3>

                            <span class="text-xs text-gray-400">
                                ^
                            </span>

                        </div>


                        <div class="space-y-3">

                            @foreach ([4.5, 4.0, 3.5, 3.0, 2.0] as $rating)

                                <label class="flex cursor-pointer items-center gap-2 text-xs text-gray-600">

                                    <input
                                        type="radio"
                                        name="rating"
                                        value="{{ $rating }}"
                                        @checked(request('rating') == $rating)
                                        class="h-3.5 w-3.5 border-gray-300 text-gray-950 focus:ring-gray-950"
                                    >

                                    <span class="flex items-center gap-1">

                                        <span class="tracking-[1px] text-gray-950">
                                            @if ($rating >= 4.5)
                                                ★★★★★
                                            @elseif ($rating >= 4.0)
                                                ★★★★☆
                                            @elseif ($rating >= 3.5)
                                                ★★★★☆
                                            @elseif ($rating >= 3.0)
                                                ★★★☆☆
                                            @else
                                                ★★☆☆☆
                                            @endif
                                        </span>

                                        <span class="ml-1">
                                            {{ number_format($rating, 1) }}+
                                        </span>

                                    </span>

                                </label>

                            @endforeach

                        </div>

                    </div>


                    {{-- Year --}}
                    <div class="border-b border-gray-200 p-4">

                        <div class="mb-4 flex items-center justify-between">

                            <h3 class="text-sm font-semibold text-gray-950">
                                Year
                            </h3>

                            <span class="text-xs text-gray-400">
                                ^
                            </span>

                        </div>


                        <div class="grid grid-cols-2 gap-2">

                            <input
                                type="number"
                                name="year_from"
                                value="{{ request('year_from') }}"
                                placeholder="From"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-xs text-gray-700 outline-none focus:border-gray-950 focus:ring-1 focus:ring-gray-950"
                            >

                            <input
                                type="number"
                                name="year_to"
                                value="{{ request('year_to') }}"
                                placeholder="To"
                                class="w-full rounded-lg border border-gray-300 px-2.5 py-2 text-xs text-gray-700 outline-none focus:border-gray-950 focus:ring-1 focus:ring-gray-950"
                            >

                        </div>

                    </div>


                    {{-- Apply Filter --}}
                    <div class="p-4">

                        <button
                            type="submit"
                            class="w-full rounded-lg bg-gray-950 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-gray-800"
                        >
                            Apply Filter
                        </button>

                    </div>

                </form>

            </aside>


            {{-- ================================================= --}}
            {{-- MOVIE CONTENT --}}
            {{-- ================================================= --}}

            <div class="min-w-0">


                {{-- Content Header --}}
                <div class="flex flex-col gap-4 border-b border-gray-200 pb-4 sm:flex-row sm:items-center sm:justify-between">

                    <div>

                        <p class="text-base font-semibold text-gray-950">

                            {{ $movies->total() }}

                            Movies Found

                        </p>

                        @if (request()->hasAny(['search', 'genre', 'rating', 'year_from', 'year_to']))

                            <p class="mt-1 text-xs text-gray-500">
                                Menampilkan hasil berdasarkan filter yang dipilih.
                            </p>

                        @endif

                    </div>


                    {{-- Sort --}}
                    <form
                        action="{{ route('movies.index') }}"
                        method="GET"
                    >

                        {{-- Preserve Filters --}}
                        @foreach (request()->except('sort', 'page') as $key => $value)

                            @if (is_array($value))

                                @foreach ($value as $item)

                                    <input
                                        type="hidden"
                                        name="{{ $key }}[]"
                                        value="{{ $item }}"
                                    >

                                @endforeach

                            @else

                                <input
                                    type="hidden"
                                    name="{{ $key }}"
                                    value="{{ $value }}"
                                >

                            @endif

                        @endforeach


                        <select
                            name="sort"
                            onchange="this.form.submit()"
                            class="rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-xs text-gray-700 outline-none transition focus:border-gray-950 focus:ring-1 focus:ring-gray-950"
                        >

                            <option value="">
                                Most Popular
                            </option>

                            <option
                                value="rating"
                                @selected(request('sort') === 'rating')
                            >
                                Highest Rating
                            </option>

                            <option
                                value="newest"
                                @selected(request('sort') === 'newest')
                            >
                                Newest
                            </option>

                            <option
                                value="oldest"
                                @selected(request('sort') === 'oldest')
                            >
                                Oldest
                            </option>

                            <option
                                value="title"
                                @selected(request('sort') === 'title')
                            >
                                Title A-Z
                            </option>

                        </select>

                    </form>

                </div>


                {{-- ================================================= --}}
                {{-- MOVIE GRID --}}
                {{-- ================================================= --}}

                <div class="mt-5 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    @forelse ($movies as $movie)

                        <x-user.movie-card
                            :movie="$movie"
                            compact
                        />

                    @empty

                        <div class="col-span-full rounded-xl border border-dashed border-gray-300 bg-gray-50 px-6 py-20 text-center">

                            <svg
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke-width="1.4"
                                stroke="currentColor"
                                class="mx-auto h-12 w-12 text-gray-400"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                                />
                            </svg>

                            <h3 class="mt-4 text-lg font-semibold text-gray-950">
                                No Movies Found
                            </h3>

                            <p class="mt-2 text-sm text-gray-500">
                                Tidak ada film yang sesuai dengan pencarian atau filter.
                            </p>

                            <a
                                href="{{ route('movies.index') }}"
                                class="mt-5 inline-flex rounded-full bg-gray-950 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-gray-800"
                            >
                                Reset Filter
                            </a>

                        </div>

                    @endforelse

                </div>


                {{-- Pagination --}}
                @if ($movies->hasPages())
                    <div class="mt-10 flex justify-center">
                        <nav
                            class="flex items-center gap-2"
                            aria-label="Pagination"
                        >

                            {{-- Previous --}}
                            @if ($movies->onFirstPage())

                                <span
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-300"
                                    aria-disabled="true"
                                >
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
                                            d="m14.5 6-6 6 6 6"
                                        />
                                    </svg>
                                </span>

                            @else

                                <a
                                    href="{{ $movies->previousPageUrl() }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-600 transition hover:border-gray-300 hover:bg-gray-50"
                                    aria-label="Previous page"
                                >
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
                                            d="m14.5 6-6 6 6 6"
                                        />
                                    </svg>
                                </a>

                            @endif


                            {{-- Page Numbers --}}
                            @foreach ($movies->getUrlRange(
                                max(1, $movies->currentPage() - 2),
                                min($movies->lastPage(), $movies->currentPage() + 2)
                            ) as $page => $url)

                                @if ($page == $movies->currentPage())

                                    <span
                                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-md bg-gray-950 px-3 text-sm font-semibold text-white"
                                        aria-current="page"
                                    >
                                        {{ $page }}
                                    </span>

                                @else

                                    <a
                                        href="{{ $url }}"
                                        class="inline-flex h-9 min-w-9 items-center justify-center rounded-md border border-gray-200 px-3 text-sm font-medium text-gray-700 transition hover:border-gray-300 hover:bg-gray-50"
                                    >
                                        {{ $page }}
                                    </a>

                                @endif

                            @endforeach


                            {{-- Next --}}
                            @if ($movies->hasMorePages())

                                <a
                                    href="{{ $movies->nextPageUrl() }}"
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-600 transition hover:border-gray-300 hover:bg-gray-50"
                                    aria-label="Next page"
                                >
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
                                            d="m9.5 6 6 6-6 6"
                                        />
                                    </svg>
                                </a>

                            @else

                                <span
                                    class="inline-flex h-9 w-9 items-center justify-center rounded-md border border-gray-200 text-gray-300"
                                    aria-disabled="true"
                                >
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
                                            d="m9.5 6 6 6-6 6"
                                        />
                                    </svg>
                                </span>

                            @endif

                        </nav>
                    </div>
                @endif

            </div>

        </div>

    </div>

</section>

@endsection
