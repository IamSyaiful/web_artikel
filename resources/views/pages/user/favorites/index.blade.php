@extends('layouts.user.app')

@section('title', 'Favorites - Ruang Cinema')
@section('description', 'Daftar film favorit yang kamu simpan di Ruang Cinema.')

@section('content')
    <section class="bg-white py-10 sm:py-14">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <div class="mb-4 flex items-center gap-2 text-sm text-gray-500">
                        <a href="{{ route('home') }}" class="transition hover:text-gray-950">
                            <x-icon name="house" size="16" />
                        </a>
                        <span>/</span>
                        <span>Favorites</span>
                    </div>

                    <h1 class="text-4xl font-bold tracking-tight text-gray-950 sm:text-5xl">My Favorites</h1>
                    <p class="mt-3 text-base text-gray-600">Movie yang kamu simpan untuk ditonton nanti.</p>
                </div>

                <a
                    href="{{ route('movies.index') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-lg border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-700 transition hover:border-gray-400 hover:bg-gray-50"
                >
                    <x-icon name="grid-2x2" size="17" />
                    Explore Movies
                </a>
            </div>

            <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div class="inline-flex items-center gap-2 rounded-lg border border-gray-300 px-4 py-3 text-sm font-semibold text-gray-900">
                    <x-icon name="heart" size="18" class="fill-gray-900" />
                    {{ $movies->total() }} {{ $movies->total() === 1 ? 'Movie' : 'Movies' }}
                </div>

                <form method="GET" action="{{ route('favorites') }}">
                    <label class="sr-only" for="favorite-sort">Sort favorites</label>
                    <select
                        id="favorite-sort"
                        name="sort"
                        onchange="this.form.submit()"
                        class="rounded-lg border border-gray-300 bg-white px-4 py-3 text-sm font-medium text-gray-700 outline-none focus:border-gray-950 focus:ring-1 focus:ring-gray-950"
                    >
                        <option value="newest" @selected($sort === 'newest')>Newest First</option>
                        <option value="oldest" @selected($sort === 'oldest')>Oldest First</option>
                        <option value="title" @selected($sort === 'title')>Title A-Z</option>
                    </select>
                </form>
            </div>

            @if ($movies->isNotEmpty())
                <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($movies as $movie)
                        <article class="group overflow-hidden rounded-xl border border-gray-200 bg-white transition duration-300 hover:-translate-y-1 hover:shadow-lg">
                            <div class="relative aspect-[2/3] overflow-hidden bg-gray-100">
                                <a href="{{ route('movies.show', $movie) }}" class="block h-full">
                                    @if ($movie->poster)
                                        <img
                                            src="{{ asset('storage/' . $movie->poster) }}"
                                            alt="{{ $movie->title }}"
                                            class="h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                        >
                                    @else
                                        <div class="flex h-full flex-col items-center justify-center bg-gray-950 text-center text-gray-500">
                                            <x-icon name="clapperboard" size="42" />
                                            <span class="mt-3 px-5 text-xs uppercase tracking-[0.18em]">Ruang Cinema</span>
                                        </div>
                                    @endif
                                </a>

                                <form method="POST" action="{{ route('movies.unfavorite', $movie) }}" class="absolute right-3 top-3">
                                    @csrf
                                    @method('DELETE')
                                    <button
                                        type="submit"
                                        data-confirm-favorite
                                        class="flex h-10 w-10 items-center justify-center rounded-lg border border-gray-300 bg-white/95 text-gray-700 shadow-sm transition hover:bg-white hover:text-red-600"
                                        aria-label="Remove {{ $movie->title }} from favorites"
                                    >
                                        <x-icon name="heart" size="20" class="fill-red-500 text-red-500" />
                                    </button>
                                </form>

                                <div class="absolute bottom-3 right-3 flex items-center gap-1 rounded-md bg-gray-950/90 px-2 py-1 text-xs font-semibold text-white">
                                    <x-icon name="star" size="13" class="fill-white" />
                                    {{ number_format((float) $movie->rating, 1) }}
                                </div>
                            </div>

                            <div class="p-4">
                                <a href="{{ route('movies.show', $movie) }}" class="block">
                                    <h2 class="truncate text-base font-bold text-gray-950">{{ $movie->title }}</h2>
                                </a>

                                <div class="mt-2 flex items-center gap-2 text-sm text-gray-500">
                                    <span>{{ $movie->release_date?->format('Y') ?? '-' }}</span>
                                    @if ($movie->duration)
                                        <span class="h-1 w-1 rounded-full bg-gray-300"></span>
                                        <span>{{ intdiv($movie->duration, 60) }}h {{ $movie->duration % 60 }}m</span>
                                    @endif
                                </div>

                                @if ($movie->genres->isNotEmpty())
                                    <div class="mt-4 flex flex-wrap gap-1.5">
                                        @foreach ($movie->genres->take(3) as $genre)
                                            <span class="rounded-md border border-gray-200 bg-gray-50 px-2 py-1 text-xs font-medium text-gray-600">{{ $genre->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if ($movies->hasPages())
                    <div class="mt-10 flex justify-center">
                        {{ $movies->links() }}
                    </div>
                @endif
            @else
                <div class="rounded-2xl border border-gray-200 px-6 py-16 text-center">
                    <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-full border border-gray-300 text-gray-700">
                        <x-icon name="heart" size="30" />
                    </div>
                    <h2 class="mt-5 text-xl font-bold text-gray-950">Your favorites list is empty</h2>
                    <p class="mt-2 text-sm text-gray-500">Start exploring movies and add them to your favorites.</p>
                    <a
                        href="{{ route('movies.index') }}"
                        class="mt-6 inline-flex items-center gap-2 rounded-lg bg-gray-950 px-5 py-3 text-sm font-semibold text-white transition hover:bg-gray-800"
                    >
                        <x-icon name="grid-2x2" size="17" />
                        Browse Movies
                    </a>
                </div>
            @endif
        </div>
    </section>
@endsection
