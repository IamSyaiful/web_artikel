@extends('layouts.user.app')

@section('title', $movie->title . ' - Ruang Cinema')

@section('description')
    {{ $movie->synopsis ?? 'Lihat detail film, rating, review, dan komentar di Ruang Cinema.' }}
@endsection


@section('content')

<div class="bg-white">

    {{-- ========================================================= --}}
    {{-- Movie Detail --}}
    {{-- ========================================================= --}}

    <section class="py-8 sm:py-12 lg:py-16">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- ================================================= --}}
            {{-- Back To Movies --}}
            {{-- ================================================= --}}

            <a
                href="{{ route('movies.index') }}"
                class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-gray-950"
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
                        d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"
                    />
                </svg>

                Back to Movies

            </a>


            {{-- ================================================= --}}
            {{-- Movie Content --}}
            {{-- ================================================= --}}

            <div class="mt-8 grid gap-8 lg:grid-cols-[300px_minmax(0,1fr)] lg:gap-12 xl:grid-cols-[320px_minmax(0,1fr)]">


                {{-- ================================================= --}}
                {{-- Poster --}}
                {{-- ================================================= --}}

                <div class="mx-auto w-full max-w-[320px] lg:mx-0 lg:max-w-none">

                    <div class="group relative overflow-hidden rounded-2xl border border-gray-200 bg-gray-100">

                        <div class="aspect-[2/3]">

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
                                        class="h-16 w-16 text-gray-300"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            d="M4 7.5h16M4 16.5h16M7 4v3.5M12 4v3.5M17 4v3.5M7 16.5V20M12 16.5V20M17 16.5V20"
                                        />
                                    </svg>

                                    <span class="mt-4 text-xs font-medium uppercase tracking-[0.2em] text-gray-400">
                                        Ruang Cinema
                                    </span>

                                </div>

                            @endif

                        </div>


                        {{-- Rating --}}
                        @if ($movie->rating !== null)

                            <div class="absolute right-3 top-3 flex items-center gap-1 rounded-full bg-gray-950 px-3 py-1.5 text-xs font-semibold text-white">

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

                </div>


                {{-- ================================================= --}}
                {{-- Movie Information --}}
                {{-- ================================================= --}}

                <div class="min-w-0 flex flex-col justify-center">

                    {{-- Title --}}
                    <h1 class="text-3xl font-bold tracking-tight text-gray-950 sm:text-4xl lg:text-5xl">

                        {{ $movie->title }}

                        @if ($movie->release_date)

                            <span class="font-normal text-gray-400">
                                ({{ $movie->release_date->format('Y') }})
                            </span>

                        @endif

                    </h1>


                    {{-- ================================================= --}}
                    {{-- Meta --}}
                    {{-- ================================================= --}}

                    <div class="mt-4 flex flex-wrap items-center gap-x-4 gap-y-2 text-sm text-gray-600">

                        @if ($movie->rating !== null)

                            <span class="inline-flex items-center gap-1.5 font-semibold text-gray-900">

                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="currentColor"
                                    viewBox="0 0 24 24"
                                    class="h-4 w-4"
                                >
                                    <path d="m12 3 2.78 5.63 6.22.9-4.5 4.38 1.06 6.2L12 17.2l-5.56 2.91 1.06-6.2L3 9.53l6.22-.9L12 3Z"/>
                                </svg>

                                {{ number_format((float) $movie->rating, 1) }}

                            </span>

                        @endif


                        @if ($movie->rating !== null && ($movie->duration || $movie->release_date))

                            <span class="text-gray-300">
                                •
                            </span>

                        @endif


                        @if ($movie->duration)

                            <span>
                                {{ $movie->duration }} min
                            </span>

                        @endif


                        @if ($movie->duration && $movie->release_date)

                            <span class="text-gray-300">
                                •
                            </span>

                        @endif


                        @if ($movie->release_date)

                            <span>
                                {{ $movie->release_date->format('Y') }}
                            </span>

                        @endif

                    </div>


                    {{-- ================================================= --}}
                    {{-- Genres --}}
                    {{-- ================================================= --}}

                    @if ($movie->genres->isNotEmpty())

                        <div class="mt-5 flex flex-wrap gap-2">

                            @foreach ($movie->genres as $genre)

                                <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-700">
                                    {{ $genre->name }}
                                </span>

                            @endforeach

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- Director --}}
                    {{-- ================================================= --}}

                    @if ($movie->director)

                        <div class="mt-7">

                            <h2 class="text-sm font-semibold text-gray-950">
                                Director
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ $movie->director }}
                            </p>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- Synopsis --}}
                    {{-- ================================================= --}}

                    @if ($movie->synopsis)

                        <div class="mt-7 max-w-3xl">

                            <h2 class="text-sm font-semibold text-gray-950">
                                Synopsis
                            </h2>

                            <p class="mt-2 break-words text-sm leading-7 text-gray-600 sm:text-base">
                                {{ $movie->synopsis }}
                            </p>

                        </div>

                    @endif


                    {{-- ================================================= --}}
                    {{-- Favorite --}}
                    {{-- ================================================= --}}

                    <div class="mt-8">

                        @auth

                            <form
                                action="{{ route('movies.favorite', $movie) }}"
                                method="POST"
                            >

                                @csrf

                                <button
                                    type="submit"
                                    class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-900 transition hover:border-gray-950 hover:bg-gray-50 sm:w-auto"
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
                                            d="M20.84 8.61a5.5 5.5 0 0 0-7.78 0L12 9.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-4.84a5.5 5.5 0 0 0 0-7.78Z"
                                        />
                                    </svg>

                                    Add to Favorites

                                </button>

                            </form>

                        @else

                            <a
                                href="{{ route('login') }}"
                                class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-gray-300 px-5 py-2.5 text-sm font-semibold text-gray-900 transition hover:border-gray-950 hover:bg-gray-50 sm:w-auto"
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
                                        d="M20.84 8.61a5.5 5.5 0 0 0-7.78 0L12 9.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78L12 21.23l8.84-4.84a5.5 5.5 0 0 0 0-7.78Z"
                                    />
                                </svg>

                                Add to Favorites

                            </a>

                        @endauth

                    </div>

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- Review --}}
    {{-- ========================================================= --}}

    @if ($movie->review)

        <section class="pb-12 sm:pb-16">

            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

                <div class="rounded-2xl border border-gray-200 bg-white p-5 sm:p-8">

                    <h2 class="text-lg font-bold text-gray-950">
                        Review
                    </h2>


                    <div class="mt-5 max-w-3xl">

                        <div class="flex gap-3 sm:gap-4">

                            <span class="shrink-0 text-3xl leading-none text-gray-300 sm:text-4xl">
                                “
                            </span>

                            <p class="min-w-0 break-words text-sm leading-7 text-gray-600 sm:text-base">
                                {{ $movie->review }}
                            </p>

                        </div>


                        {{-- Reviewer --}}
                        <div class="mt-5 flex items-center gap-3 border-t border-gray-100 pt-5">

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
                                        d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                    />
                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-gray-950">
                                    Ruang Cinema
                                </p>

                                <p class="text-xs text-gray-500">
                                    Official Review
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    @endif



    {{-- ========================================================= --}}
    {{-- Comments --}}
    {{-- ========================================================= --}}

    <section class="pb-14 sm:pb-20">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            <div class="rounded-2xl border border-gray-200 bg-white p-4 sm:p-6">

                {{-- ================================================= --}}
                {{-- Comments Header --}}
                {{-- ================================================= --}}

                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                    <h2 class="text-lg font-bold text-gray-950">

                        Comments

                        <span class="font-normal text-gray-400">
                            ({{ $movie->comments->count() }})
                        </span>

                    </h2>

                </div>


                {{-- ================================================= --}}
                {{-- Comments List --}}
                {{-- ================================================= --}}

                <div class="mt-5 space-y-3">

                    @forelse ($movie->comments as $comment)

                        <div class="rounded-xl border border-gray-200 p-4 sm:p-5">

                            <div class="flex gap-3 sm:gap-4">

                                {{-- Avatar --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100">

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
                                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                        />
                                    </svg>

                                </div>


                                {{-- Content --}}
                                <div class="min-w-0 flex-1">

                                    <div class="flex items-start justify-between gap-3">

                                        <div class="min-w-0">

                                            <p class="truncate text-sm font-semibold text-gray-950">
                                                {{ $comment->user->name }}
                                            </p>

                                            <p class="mt-0.5 text-xs text-gray-400">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </p>

                                        </div>

                                    </div>


                                    {{-- Comment --}}
                                    <p class="mt-3 break-words text-sm leading-6 text-gray-600">
                                        {{ $comment->comment }}
                                    </p>


                                    {{-- Owner Actions --}}
                                    @auth

                                        @if ($comment->user_id === auth()->id())

                                            <div class="mt-4 flex flex-wrap items-center gap-4">

                                                <button
                                                    type="button"
                                                    class="text-xs font-semibold text-gray-600 transition hover:text-gray-950"
                                                >
                                                    Edit
                                                </button>


                                                <form
                                                    action="{{ route('comments.destroy', $comment) }}"
                                                    method="POST"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="text-xs font-semibold text-gray-600 transition hover:text-red-600"
                                                    >
                                                        Delete
                                                    </button>

                                                </form>

                                            </div>

                                        @endif

                                    @endauth

                                </div>

                            </div>

                        </div>

                    @empty

                        <div class="rounded-xl border border-dashed border-gray-300 px-6 py-12 text-center">

                            <p class="text-sm font-medium text-gray-700">
                                Belum ada komentar.
                            </p>

                            <p class="mt-1 text-sm text-gray-500">
                                Jadilah yang pertama memberikan pendapat tentang film ini.
                            </p>

                        </div>

                    @endforelse

                </div>


                {{-- ================================================= --}}
                {{-- Comment Form --}}
                {{-- ================================================= --}}

                <div class="mt-4">

                    @auth

                        <form
                            action="{{ route('movies.comments.store', $movie) }}"
                            method="POST"
                            class="rounded-xl border border-gray-200 p-4 sm:p-5"
                        >

                            @csrf

                            <div class="flex flex-col gap-4 sm:flex-row">

                                {{-- Avatar --}}
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-gray-100">

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
                                            d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0"
                                        />
                                    </svg>

                                </div>


                                {{-- Form Content --}}
                                <div class="min-w-0 flex-1">

                                    <textarea
                                        name="comment"
                                        rows="3"
                                        required
                                        maxlength="1000"
                                        placeholder="Write a comment..."
                                        class="w-full resize-none rounded-lg border border-gray-200 px-4 py-3 text-sm text-gray-900 outline-none transition placeholder:text-gray-400 focus:border-gray-400 focus:ring-0"
                                    ></textarea>


                                    <div class="mt-3 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                                        <p class="text-xs text-gray-400">
                                            Be kind and respectful.
                                        </p>


                                        <button
                                            type="submit"
                                            class="inline-flex w-full items-center justify-center rounded-lg bg-gray-950 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-gray-800 sm:w-auto"
                                        >
                                            Post Comment
                                        </button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    @else

                        <div class="rounded-xl border border-gray-200 px-5 py-6 text-center">

                            <p class="text-sm text-gray-600">
                                Login untuk ikut memberikan komentar.
                            </p>

                            <a
                                href="{{ route('login') }}"
                                class="mt-3 inline-flex rounded-lg bg-gray-950 px-4 py-2.5 text-xs font-semibold text-white transition hover:bg-gray-800"
                            >
                                Login
                            </a>

                        </div>

                    @endauth

                </div>

            </div>

        </div>

    </section>



    {{-- ========================================================= --}}
    {{-- You May Also Like --}}
    {{-- ========================================================= --}}

    <section class="pb-14 sm:pb-20">

        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-6 flex items-center justify-between gap-4">

                <h2 class="text-xl font-bold tracking-tight text-gray-950 sm:text-2xl">
                    You May Also Like
                </h2>


                <a
                    href="{{ route('movies.index') }}"
                    class="hidden shrink-0 items-center gap-2 text-sm font-semibold text-gray-700 transition hover:text-gray-950 sm:inline-flex"
                >

                    View All

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


            {{-- Related Movies --}}
            @if ($relatedMovies->isNotEmpty())

                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">

                    @foreach ($relatedMovies as $relatedMovie)

                        <x-user.movie-card
                            :movie="$relatedMovie"
                            :compact="true"
                        />

                    @endforeach

                </div>

            @else

                <div class="rounded-2xl border border-dashed border-gray-300 bg-gray-50 px-6 py-12 text-center">

                    <p class="text-sm text-gray-500">
                        Belum ada film terkait.
                    </p>

                </div>

            @endif

        </div>

    </section>
</div>

@endsection
