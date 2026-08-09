@extends('layouts.admin.app')

@section('title', 'Movies')
@section('page-title', 'Movies')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Movies
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage movies in Ruang Cinema.
            </p>
        </div>

        <a
            href="{{ route('admin.movies.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-lg bg-gray-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-gray-800"
        >
            <x-icon name="plus" size="18" />

            Add Movie
        </a>

    </div>


    {{-- Movies Table --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="w-full text-left text-sm text-gray-500">

                <thead class="bg-gray-50 text-xs uppercase text-gray-700">

                    <tr>

                        <th scope="col" class="px-6 py-3">
                            Poster
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Movie
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Genre
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Release
                        </th>

                        <th scope="col" class="px-6 py-3">
                            Rating
                        </th>

                        <th scope="col" class="px-6 py-3 text-right">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody>

                    @forelse ($movies as $movie)

                        <tr class="border-b border-gray-200 bg-white">

                            {{-- Poster --}}
                            <td class="px-6 py-4">

                                @if ($movie->poster)

                                    <img
                                        src="{{ asset('storage/' . $movie->poster) }}"
                                        alt="{{ $movie->title }}"
                                        class="h-16 w-11 rounded-md object-cover"
                                    >

                                @else

                                    <div class="flex h-16 w-11 items-center justify-center rounded-md bg-gray-100 text-gray-400">
                                        <x-icon name="image" size="18" />
                                    </div>

                                @endif

                            </td>


                            {{-- Movie --}}
                            <td class="px-6 py-4">

                                <div class="font-semibold text-gray-900">
                                    {{ $movie->title }}
                                </div>

                                <div class="mt-1 text-xs text-gray-500">
                                    {{ $movie->director ?: 'Unknown director' }}
                                </div>

                            </td>


                            {{-- Genre --}}
                            <td class="px-6 py-4">

                                <div class="flex flex-wrap gap-1.5">

                                    @forelse ($movie->genres as $genre)

                                        <span class="rounded-md bg-gray-100 px-2 py-1 text-xs font-medium text-gray-700">
                                            {{ $genre->name }}
                                        </span>

                                    @empty

                                        <span class="text-gray-400">
                                            -
                                        </span>

                                    @endforelse

                                </div>

                            </td>


                            {{-- Release --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                {{ $movie->release_date?->format('Y') ?? '-' }}

                            </td>


                            {{-- Rating --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-1.5">

                                    <x-icon
                                        name="star"
                                        size="16"
                                        class="fill-current text-gray-900"
                                    />

                                    <span class="font-medium text-gray-900">
                                        {{ number_format($movie->rating, 1) }}
                                    </span>

                                </div>

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('admin.movies.edit', $movie) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-gray-300 bg-white px-3 py-2 text-xs font-medium text-gray-700 transition hover:bg-gray-50"
                                    >
                                        <x-icon name="pencil" size="15" />

                                        Edit
                                    </a>


                                    <form
                                        action="{{ route('admin.movies.destroy', $movie) }}"
                                        method="POST"
                                        class="delete-movie-form"
                                        data-movie-title="{{ $movie->title }}"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 bg-white px-3 py-2 text-xs font-medium text-red-600 transition hover:bg-red-50"
                                        >
                                            <x-icon name="trash-2" size="15" />

                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="px-6 py-12 text-center"
                            >

                                <div class="flex flex-col items-center">

                                    <div class="mb-3 flex h-12 w-12 items-center justify-center rounded-full bg-gray-100 text-gray-400">
                                        <x-icon name="film" size="22" />
                                    </div>

                                    <h3 class="font-medium text-gray-900">
                                        No movies found
                                    </h3>

                                    <p class="mt-1 text-sm text-gray-500">
                                        Start by adding your first movie.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
    document.addEventListener('submit', (event) => {
        const form = event.target.closest('.delete-movie-form');

        if (!form) return;

        event.preventDefault();

        const movieTitle = form.dataset.movieTitle;

        window.showConfirmAlert(
            'Hapus movie?',
            `Apakah Anda yakin ingin menghapus movie "${movieTitle}"? Data yang dihapus tidak dapat dikembalikan.`
        ).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>

@endpush
