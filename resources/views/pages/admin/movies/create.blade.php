@extends('layouts.admin.app')

@section('title', 'Add Movie')
@section('page-title', 'Add Movie')

@section('content')

    <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900">
            Add Movie
        </h2>

        <p class="mt-1 text-sm text-gray-500">
            Add a new movie to Ruang Cinema.
        </p>
    </div>


    <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

        <div class="flex items-center gap-4 border-b border-gray-200 px-6 py-6 sm:px-8">
            <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-gray-100 text-gray-600">
                <x-icon name="clapperboard" size="22" />
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Movie Information</h3>
                <p class="mt-1 text-sm text-gray-500">Fill in the information below to add a new movie.</p>
            </div>
        </div>


        <form
            method="POST"
            action="{{ route('admin.movies.store') }}"
            enctype="multipart/form-data"
        >

            @csrf

            <div class="border-b border-gray-200 bg-gray-50 px-6 py-5 sm:px-8" data-tmdb-import>
                <div class="flex flex-col gap-4 lg:flex-row lg:items-end">
                    <div class="flex-1">
                        <label for="tmdb-search" class="mb-2 block text-sm font-medium text-gray-900">Import from TMDB</label>
                        <input
                            id="tmdb-search"
                            type="search"
                            placeholder="Search movie title..."
                            class="block h-11 w-full rounded-lg border border-gray-300 bg-white px-3.5 py-2.5 text-sm text-gray-900 focus:border-gray-500 focus:ring-2 focus:ring-gray-200"
                        >
                    </div>
                    <button type="button" data-tmdb-search class="inline-flex h-11 items-center justify-center gap-2 rounded-lg border border-gray-300 bg-white px-4 text-sm font-medium text-gray-700 hover:bg-gray-100">
                        <x-icon name="search" size="17" />
                        Search TMDB
                    </button>
                </div>
                <p class="mt-2 text-xs text-gray-500">Choose a result to fill the movie form automatically. This product uses the TMDB API.</p>
                <div class="mt-4 hidden space-y-2" data-tmdb-results></div>
            </div>

            <input type="hidden" name="tmdb_poster_path" id="tmdb_poster_path">

            <div class="space-y-8 p-6 sm:p-8">

                {{-- Title --}}
                <x-admin.input
                    name="title"
                    label="Movie Title"
                    placeholder="Enter movie title"
                    required
                />


                {{-- Poster / Release Date / Duration --}}
                <div class="grid gap-6 lg:grid-cols-[1.5fr_1fr_1fr]">
                    <x-admin.file-input name="poster" label="Poster" help="Maximum 10MB." />

                    <x-admin.input
                        name="release_date"
                        label="Release Date"
                        type="date"
                    />

                    <x-admin.input
                        name="duration"
                        label="Duration (minutes)"
                        type="number"
                        placeholder="e.g. 169"
                        min="1"
                    />

                </div>


                {{-- Director / Rating --}}
                <div class="grid gap-6 md:grid-cols-2">

                    <x-admin.input
                        name="director"
                        label="Director"
                        placeholder="Enter director name"
                    />

                    <x-admin.input
                        name="rating"
                        label="Rating"
                        type="number"
                        placeholder="e.g. 4.8"
                        value="0.0"
                        min="0"
                        max="5"
                        step="0.1"
                    />

                </div>


                {{-- Genres --}}
                <div>

                    <label class="mb-2.5 block text-sm font-medium text-gray-900">
                        Genres <span class="text-red-500">*</span>
                    </label>

                    <div class="grid grid-cols-2 gap-x-6 gap-y-4 rounded-lg border border-gray-200 bg-gray-50 p-5 sm:grid-cols-3 lg:grid-cols-4">

                        @php
                            $tmdbGenreIds = [
                                'Action' => 28,
                                'Adventure' => 12,
                                'Animation' => 16,
                                'Comedy' => 35,
                                'Crime' => 80,
                                'Drama' => 18,
                                'Fantasy' => 14,
                                'Horror' => 27,
                                'Romance' => 10749,
                                'Sci-Fi' => 878,
                                'Thriller' => 53,
                            ];
                        @endphp

                        @foreach ($genres as $genre)

                            <x-admin.checkbox
                                name="genres"
                                :value="$genre->id"
                                :label="$genre->name"
                                data-genre-name="{{ strtolower($genre->name) }}"
                                data-tmdb-genre-id="{{ $tmdbGenreIds[$genre->name] ?? '' }}"
                                :checked="in_array($genre->id, old('genres', []))"
                            />

                        @endforeach

                    </div>

                    @error('genres')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Synopsis --}}
                <x-admin.wysiwyg
                    name="synopsis"
                    label="Synopsis"
                    placeholder="Write movie synopsis..."
                />


                {{-- Review --}}
                <x-admin.wysiwyg
                    name="review"
                    label="Review"
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
                    Save Movie
                </button>

            </div>

        </form>

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const importBox = document.querySelector('[data-tmdb-import]');
        if (!importBox) return;

        const searchInput = importBox.querySelector('#tmdb-search');
        const searchButton = importBox.querySelector('[data-tmdb-search]');
        const resultsBox = importBox.querySelector('[data-tmdb-results]');
        const posterPathInput = document.querySelector('#tmdb_poster_path');

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (char) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        }[char]));

        const setValue = (id, value) => {
            const field = document.getElementById(id);
            if (field) field.value = value ?? '';
        };

        const fillMovieForm = (movie) => {
            setValue('title', movie.title);
            setValue('release_date', movie.release_date);
            setValue('duration', movie.duration);
            setValue('director', movie.director);
            setValue('rating', movie.rating);
            setValue('synopsis', movie.synopsis);
            posterPathInput.value = movie.poster_path ?? '';

            const importedGenreIds = new Set((movie.genre_ids ?? []).map((id) => String(id)));

            document.querySelectorAll('[data-genre-name]').forEach((checkbox) => {
                checkbox.checked = importedGenreIds.has(checkbox.dataset.tmdbGenreId);
            });

            if (movie.poster_url) {
                const preview = document.querySelector('#poster-preview');
                const placeholder = document.querySelector('#poster-upload-placeholder');
                const image = preview?.querySelector('img');
                const fileName = preview?.querySelector('[data-image-preview-name]');

                if (preview && placeholder && image && fileName) {
                    image.src = movie.poster_url;
                    fileName.textContent = 'Poster from TMDB';
                    placeholder.classList.add('hidden');
                    preview.classList.remove('hidden');
                    preview.classList.add('flex');
                }
            }

            resultsBox.classList.add('hidden');
            resultsBox.innerHTML = '';
            window.showSuccessAlert('Movie imported', 'Movie details have been filled from TMDB.');
        };

        const loadDetails = async (id) => {
            try {
                const response = await fetch(@json(route('admin.movies.tmdb.details', ['tmdbMovie' => '__ID__'])).replace('__ID__', id), {
                    headers: { 'Accept': 'application/json' }
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'TMDB request failed.');
                fillMovieForm(data);
            } catch (error) {
                window.showErrorAlert('Import failed', error.message);
            }
        };

        searchButton.addEventListener('click', async () => {
            const query = searchInput.value.trim();
            if (query.length < 2) return window.showErrorAlert('Search movie', 'Enter at least 2 characters.');

            searchButton.disabled = true;
            searchButton.classList.add('cursor-wait', 'opacity-60');
            resultsBox.classList.remove('hidden');
            resultsBox.innerHTML = '<p class="rounded-lg border border-gray-200 bg-white p-3 text-sm text-gray-500">Searching TMDB...</p>';

            try {
                const url = new URL(@json(route('admin.movies.tmdb.search')), window.location.origin);
                url.searchParams.set('query', query);
                const response = await fetch(url, { headers: { 'Accept': 'application/json' } });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'TMDB request failed.');

                resultsBox.innerHTML = data.results.length
                    ? data.results.map((movie) => `<button type="button" class="flex w-full items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 text-left hover:border-gray-400" data-tmdb-id="${movie.id}">
                        ${movie.poster_url ? `<img src="${escapeHtml(movie.poster_url)}" alt="" class="h-16 w-11 rounded object-cover">` : '<div class="h-16 w-11 rounded bg-gray-100"></div>'}
                        <span class="min-w-0"><span class="block truncate text-sm font-medium text-gray-900">${escapeHtml(movie.title)}</span><span class="mt-1 block text-xs text-gray-500">${escapeHtml(movie.release_date || 'Release date unavailable')}</span></span>
                    </button>`).join('')
                    : '<p class="rounded-lg border border-gray-200 bg-white p-3 text-sm text-gray-500">No movies found.</p>';

                resultsBox.querySelectorAll('[data-tmdb-id]').forEach((button) => {
                    button.addEventListener('click', () => loadDetails(button.dataset.tmdbId));
                });
            } catch (error) {
                resultsBox.innerHTML = '';
                window.showErrorAlert('TMDB search failed', error.message);
            } finally {
                searchButton.disabled = false;
                searchButton.classList.remove('cursor-wait', 'opacity-60');
            }
        });

        searchInput.addEventListener('keydown', (event) => {
            if (event.key === 'Enter') {
                event.preventDefault();
                searchButton.click();
            }
        });

        document.querySelector('#poster')?.addEventListener('change', () => {
            posterPathInput.value = '';
        });
    });
</script>
@endpush
