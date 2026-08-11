@extends('layouts.admin.app')

@section('title', 'Edit Movie')
@section('page-title', 'Edit Movie')

@section('content')

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">
            Edit Movie
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Update movie information in Ruang Cinema.
        </p>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                <x-icon name="clapperboard" size="22" />
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Movie Information</h3>
                <p class="mt-1 text-sm text-gray-500">Update the information below and save your changes.</p>
            </div>
        </div>

        <form
            method="POST"
            action="{{ route('admin.movies.update', $movie) }}"
            enctype="multipart/form-data"
        >
            @csrf
            @method('PUT')

            <div class="space-y-8 p-6 sm:p-8">

                <div class="grid gap-6 lg:grid-cols-2">
                    <x-admin.input
                        name="title"
                        label="Movie Title"
                        :value="$movie->title"
                        placeholder="Enter movie title"
                        required
                    />

                    <x-admin.input
                        name="slug"
                        label="Slug"
                        :value="$movie->slug"
                        placeholder="movie-slug"
                        disabled
                        data-movie-slug
                    />
                </div>

                <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr_1fr]">
                    <div>
                    <x-admin.file-input
                        name="poster"
                        label="Poster"
                        help="Maximum 10MB. Leave empty to keep the current poster."
                    />

                    @if ($movie->poster)
                        <div class="mt-4 flex items-center gap-4 rounded-lg border border-gray-200 bg-gray-50 p-3">
                            <img
                                src="{{ asset('storage/' . $movie->poster) }}"
                                alt="Current poster for {{ $movie->title }}"
                                class="h-20 w-14 rounded-md object-cover"
                            >

                            <div>
                                <p class="text-sm font-medium text-gray-900">
                                    Current poster
                                </p>
                                <p class="mt-1 text-xs text-gray-500">
                                    Upload a new file above to replace it.
                                </p>
                            </div>
                        </div>
                    @endif
                    </div>

                    <x-admin.input
                        name="release_date"
                        label="Release Date"
                        type="date"
                        :value="$movie->release_date?->format('Y-m-d')"
                    />

                    <x-admin.input
                        name="duration"
                        label="Duration (minutes)"
                        type="number"
                        :value="$movie->duration"
                        placeholder="e.g. 169"
                        min="1"
                    />
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <x-admin.input
                        name="director"
                        label="Director"
                        :value="$movie->director"
                        placeholder="Enter director name"
                    />

                    <x-admin.input
                        name="rating"
                        label="Rating"
                        type="number"
                        :value="$movie->rating"
                        placeholder="e.g. 4.8"
                        min="0"
                        max="5"
                        step="0.1"
                    />
                </div>

                <div>
                    <label class="mb-2.5 block text-sm font-medium text-gray-900">
                        Genres <span class="text-red-500">*</span>
                    </label>

                    @php
                        $selectedGenres = old('genres', $movie->genres->pluck('id')->all());
                    @endphp

                    <div class="grid grid-cols-2 gap-x-6 gap-y-4 rounded-lg border border-gray-200 bg-gray-50 p-5 sm:grid-cols-3 lg:grid-cols-4">
                        @foreach ($genres as $genre)
                            <x-admin.checkbox
                                name="genres"
                                :value="$genre->id"
                                :label="$genre->name"
                                :checked="in_array($genre->id, $selectedGenres)"
                            />
                        @endforeach
                    </div>

                    @error('genres')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <x-admin.wysiwyg
                    name="synopsis"
                    label="Synopsis"
                    :value="$movie->synopsis"
                    placeholder="Write movie synopsis..."
                />

                <x-admin.wysiwyg
                    name="review"
                    label="Review"
                    :value="$movie->review"
                    placeholder="Write movie review..."
                />

            </div>

            <div class="flex items-center justify-end gap-3 border-t border-gray-200 px-6 py-5 sm:px-8">
                <a
                    href="{{ route('admin.movies.index') }}"
                    class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 hover:bg-gray-50"
                >
                    <x-icon name="x" size="17" />
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center gap-2 rounded-lg bg-[#071426] px-4 py-2.5 text-sm font-medium text-white hover:bg-[#111f33]"
                >
                    <x-icon name="save" size="17" />
                    Update Movie
                </button>
            </div>
        </form>
    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const title = document.getElementById('title');
        const slug = document.querySelector('[data-movie-slug]');
        if (!title || !slug) return;

        const syncSlug = () => {
            slug.value = title.value
                .toLowerCase()
                .trim()
                .replace(/[^\p{L}\p{N}]+/gu, '-')
                .replace(/^-+|-+$/g, '');
        };

        title.addEventListener('input', syncSlug);
    });
</script>
@endpush
