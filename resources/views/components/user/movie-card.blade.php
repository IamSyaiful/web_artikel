@props([
    'movie',
    'compact' => false,
])

@if ($compact)

    {{-- COMPACT MOVIE CARD - TRENDING MOVIES --}}

    <a
        href="{{ route('movies.show', $movie) }}"
        class="group block overflow-hidden rounded-lg border border-gray-300 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-md"
    >

        {{-- Poster --}}
        <div class="relative aspect-[4/4] overflow-hidden bg-gray-100">

            @if ($movie->poster)

                <img
                    src="{{ asset('storage/' . $movie->poster) }}"
                    alt="{{ $movie->title }}"
                    class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                >

            @else

                <div class="flex h-full w-full flex-col items-center justify-center bg-gray-100 text-center">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.3"
                        stroke="currentColor"
                        class="h-10 w-10 text-gray-300"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                        />
                    </svg>

                </div>

            @endif


            {{-- Rating --}}
            @if ($movie->rating !== null)

                <div class="absolute right-2 top-2 flex items-center gap-1 rounded-full bg-black/80 px-2 py-1 text-[10px] font-semibold text-white">

                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        class="h-2.5 w-2.5"
                    >
                        <path d="m12 3 2.78 5.63 6.22.9-4.5 4.38 1.06 6.2L12 17.2l-5.56 2.91 1.06-6.2L3 9.53l6.22-.9L12 3Z"/>
                    </svg>

                    {{ number_format((float) $movie->rating, 1) }}

                </div>

            @endif

        </div>


        {{-- Movie Information --}}
        <div class="p-3">

            {{-- Title + Release Year --}}
            <h3 class="truncate text-sm font-semibold text-gray-950">
                {{ $movie->title }}

                @if ($movie->release_date)
                    <span class="font-normal text-gray-500">
                        ({{ $movie->release_date->format('Y') }})
                    </span>
                @endif
            </h3>


            {{-- Genres --}}
            @if ($movie->genres->isNotEmpty())

                <div class="mt-2 flex gap-1.5 overflow-hidden">

                    @foreach ($movie->genres->take(2) as $genre)

                        <span class="truncate rounded-full bg-gray-100 px-2 py-1 text-[10px] font-medium text-gray-600">
                            {{ $genre->name }}
                        </span>

                    @endforeach

                </div>

            @endif

        </div>

    </a>
@else


    {{-- NORMAL MOVIE CARD --}}

    <div class="group overflow-hidden rounded-2xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-lg">

        {{-- Poster --}}
        <a
            href="{{ route('movies.show', $movie) }}"
            class="block"
        >

            <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">

                @if ($movie->poster)

                    <img
                        src="{{ asset('storage/' . $movie->poster) }}"
                        alt="{{ $movie->title }}"
                        class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                    >

                @else

                    <div class="flex h-full w-full flex-col items-center justify-center bg-gray-950 text-center">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="h-12 w-12 text-gray-500"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                            />
                        </svg>

                        <span class="mt-4 px-6 text-xs font-medium uppercase tracking-[0.2em] text-gray-500">
                            Ruang Cinema
                        </span>

                    </div>

                @endif


                {{-- Rating --}}
                @if ($movie->rating !== null)

                    <div class="absolute right-4 top-4 flex items-center gap-1 rounded-full bg-black/75 px-3 py-1.5 text-xs font-semibold text-white backdrop-blur">

                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                            class="h-3.5 w-3.5"
                        >
                            <path d="m12 3 2.78 5.63 6.22.9-4.5 4.38 1.06 6.2L12 17.2l-5.56 2.91 1.06-6.2L3 9.53l6.22-.9L12 3Z"/>
                        </svg>

                        {{ number_format((float) $movie->rating, 1) }}

                    </div>

                @endif

            </div>

        </a>


        {{-- Movie Information --}}
        <div class="p-5">

            <h3 class="line-clamp-1 text-lg font-bold text-gray-950">
                {{ $movie->title }}
            </h3>


            {{-- Release Date + Duration --}}
            <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">

                @if ($movie->release_date)

                    <span>
                        {{ $movie->release_date->format('Y') }}
                    </span>

                @endif


                @if ($movie->release_date && $movie->duration)

                    <span class="h-1 w-1 rounded-full bg-gray-300"></span>

                @endif


                @if ($movie->duration)

                    <span>
                        {{ $movie->duration }} min
                    </span>

                @endif

            </div>


            {{-- Genres --}}
            @if ($movie->genres->isNotEmpty())

                <div class="mt-4 flex flex-wrap gap-2">

                    @foreach ($movie->genres->take(2) as $genre)

                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-600">
                            {{ $genre->name }}
                        </span>

                    @endforeach

                </div>

            @endif


            {{-- Detail Link --}}
            <a
                href="{{ route('movies.show', $movie) }}"
                class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gray-950"
            >

                View Details

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

@endif
