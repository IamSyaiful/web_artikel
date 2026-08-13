@php($isEdit = $movie->exists)

@if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
        <ul class="list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ $isEdit ? route('submissions.update', $movie) : route('submissions.store') }}" enctype="multipart/form-data" class="space-y-6">
    @csrf
    @if ($isEdit) @method('PUT') @endif

    <div class="grid gap-6 md:grid-cols-2">
        <div>
            <label for="title" class="mb-2 block text-sm font-medium text-gray-700">Title</label>
            <input id="title" name="title" required value="{{ old('title', $movie->title) }}" class="w-full rounded-lg border-gray-300" placeholder="Movie title">
        </div>
        <div>
            <label for="slug" class="mb-2 block text-sm font-medium text-gray-700">Slug</label>
            <input id="slug" disabled value="{{ old('title', $movie->title) ? \Illuminate\Support\Str::slug(old('title', $movie->title)) : '' }}" class="w-full rounded-lg border-gray-300 bg-gray-100 text-gray-500">
        </div>
    </div>

    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4">
        <div class="flex gap-3">
            <input id="tmdb-query" type="search" placeholder="Search movie on TMDB" class="min-w-0 flex-1 rounded-lg border-gray-300">
            <button type="button" id="tmdb-search" class="rounded-lg bg-gray-900 px-4 py-2 text-sm font-medium text-white">Search</button>
        </div>
        <div id="tmdb-results" class="mt-3 hidden space-y-2"></div>
        <input type="hidden" name="tmdb_poster_path" id="tmdb-poster-path">
    </div>

    <div class="grid gap-6 md:grid-cols-3">
        <div>
            <label for="poster" class="mb-2 block text-sm font-medium text-gray-700">Poster</label>
            <input id="poster" name="poster" type="file" accept="image/*" class="w-full rounded-lg border border-gray-300 bg-white p-2 text-sm">
            <div id="poster-preview" class="{{ $movie->poster ? 'flex' : 'hidden' }} mt-3 items-center gap-3 rounded-lg border border-gray-200 bg-gray-50 p-3">
                <img
                    src="{{ $movie->poster ? asset('storage/' . $movie->poster) : '' }}"
                    alt="Poster preview"
                    class="h-24 w-16 rounded object-cover"
                    data-poster-preview-image
                >
                <div class="min-w-0">
                    <p class="text-xs font-semibold text-gray-700">Poster preview</p>
                    <p class="mt-1 truncate text-xs text-gray-500" data-poster-preview-name>
                        {{ $movie->poster ? 'Current poster' : '' }}
                    </p>
                </div>
            </div>
        </div>
        <div><label for="release_date" class="mb-2 block text-sm font-medium text-gray-700">Release date</label><input id="release_date" name="release_date" type="date" value="{{ old('release_date', $movie->release_date?->format('Y-m-d')) }}" class="w-full rounded-lg border-gray-300"></div>
        <div><label for="duration" class="mb-2 block text-sm font-medium text-gray-700">Duration (minutes)</label><input id="duration" name="duration" type="number" min="1" value="{{ old('duration', $movie->duration) }}" class="w-full rounded-lg border-gray-300"></div>
    </div>

    <div class="grid gap-6 md:grid-cols-2">
        <div><label for="director" class="mb-2 block text-sm font-medium text-gray-700">Director</label><input id="director" name="director" value="{{ old('director', $movie->director) }}" class="w-full rounded-lg border-gray-300"></div>
        <div><label for="rating" class="mb-2 block text-sm font-medium text-gray-700">Rating</label><input id="rating" name="rating" type="number" min="0" max="5" step="0.1" value="{{ old('rating', $movie->rating ?? 0) }}" class="w-full rounded-lg border-gray-300"></div>
    </div>

    <div>
        <label class="mb-2 block text-sm font-medium text-gray-700">Genres</label>
        <div class="grid grid-cols-2 gap-3 rounded-lg border border-gray-200 bg-gray-50 p-4 sm:grid-cols-3">
            @php($selectedGenres = old('genres', $movie->exists ? $movie->genres->pluck('id')->all() : []))
            @php($tmdbGenreIds = [
                'Action' => 28,
                'Adventure' => 12,
                'Animation' => 16,
                'Comedy' => 35,
                'Crime' => 80,
                'Documentary' => 99,
                'Drama' => 18,
                'Family' => 10751,
                'Fantasy' => 14,
                'History' => 36,
                'Horror' => 27,
                'Music' => 10402,
                'Mystery' => 9648,
                'Romance' => 10749,
                'Sci-Fi' => 878,
                'Science Fiction' => 878,
                'TV Movie' => 10770,
                'Thriller' => 53,
                'War' => 10752,
                'Western' => 37,
            ])
            @foreach ($genres as $genre)
                <label class="flex items-center gap-2 text-sm text-gray-700"><input type="checkbox" name="genres[]" value="{{ $genre->id }}" data-tmdb-genre-id="{{ $tmdbGenreIds[$genre->name] ?? '' }}" @checked(in_array($genre->id, $selectedGenres))> {{ $genre->name }}</label>
            @endforeach
        </div>
        @error('genres')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div><label for="synopsis" class="mb-2 block text-sm font-medium text-gray-700">Synopsis</label><textarea id="synopsis" name="synopsis" rows="5" class="w-full rounded-lg border-gray-300">{{ old('synopsis', $movie->synopsis) }}</textarea></div>
    <div><label for="review" class="mb-2 block text-sm font-medium text-gray-700">Review</label><textarea id="review" name="review" rows="8" class="w-full rounded-lg border-gray-300">{{ old('review', $movie->review) }}</textarea></div>

    <div class="flex justify-end gap-3 border-t border-gray-200 pt-5">
        <a href="{{ route('submissions.index') }}" class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm font-medium text-gray-700">Cancel</a>
        <button class="rounded-lg bg-gray-950 px-4 py-2.5 text-sm font-medium text-white">{{ $isEdit ? 'Resubmit article' : 'Submit article' }}</button>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const titleInput = document.getElementById('title');
        const slugInput = document.getElementById('slug');
        const posterInput = document.getElementById('poster');
        const posterPathInput = document.getElementById('tmdb-poster-path');
        const posterPreview = document.getElementById('poster-preview');
        const posterPreviewImage = posterPreview?.querySelector('[data-poster-preview-image]');
        const posterPreviewName = posterPreview?.querySelector('[data-poster-preview-name]');
        const results = document.getElementById('tmdb-results');

        const escapeHtml = (value) => String(value ?? '').replace(/[&<>'"]/g, (character) => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', "'": '&#039;', '"': '&quot;'
        }[character]));

        const syncSlug = () => {
            if (!titleInput || !slugInput) return;

            slugInput.value = titleInput.value
                .toLowerCase()
                .trim()
                .replace(/[^\p{L}\p{N}]+/gu, '-')
                .replace(/^-+|-+$/g, '');
        };

        const showPosterPreview = (source, name) => {
            if (!posterPreview || !posterPreviewImage || !posterPreviewName || !source) return;

            posterPreviewImage.src = source;
            posterPreviewName.textContent = name;
            posterPreview.classList.remove('hidden');
            posterPreview.classList.add('flex');
        };

        const hidePosterPreview = () => {
            if (!posterPreview) return;

            posterPreview.classList.add('hidden');
            posterPreview.classList.remove('flex');
            posterPreviewImage?.removeAttribute('src');
            posterPreviewName.textContent = '';
        };

        const fillMovieForm = (movie) => {
            titleInput.value = movie.title || '';
            syncSlug();

            for (const [id, value] of Object.entries({
                release_date: movie.release_date,
                duration: movie.duration,
                director: movie.director,
                rating: movie.rating,
                synopsis: movie.synopsis,
            })) {
                const field = document.getElementById(id);
                if (field) field.value = value || '';
            }

            const importedGenreIds = new Set((movie.genre_ids || []).map((id) => String(id)));
            document.querySelectorAll('[data-tmdb-genre-id]').forEach((checkbox) => {
                checkbox.checked = importedGenreIds.has(checkbox.dataset.tmdbGenreId);
            });

            posterPathInput.value = movie.poster_path || '';
            if (movie.poster_url) {
                showPosterPreview(movie.poster_url, 'Poster from TMDB');
            } else {
                hidePosterPreview();
            }

            results.classList.add('hidden');
            results.innerHTML = '';
        };

        titleInput?.addEventListener('input', syncSlug);

        posterInput?.addEventListener('change', () => {
            posterPathInput.value = '';

            const file = posterInput.files?.[0];
            if (!file) {
                hidePosterPreview();
                return;
            }

            showPosterPreview(URL.createObjectURL(file), file.name);
        });

        document.getElementById('tmdb-search')?.addEventListener('click', async () => {
            const query = document.getElementById('tmdb-query').value.trim();
            if (!query) return;

            results.innerHTML = '<p class="text-sm text-gray-500">Searching...</p>';
            results.classList.remove('hidden');

            try {
                const response = await fetch(`{{ route('submissions.tmdb.search') }}?query=${encodeURIComponent(query)}`, {
                    headers: { 'Accept': 'application/json' },
                });
                const data = await response.json();
                if (!response.ok) throw new Error(data.message || 'TMDB request failed.');

                results.innerHTML = (data.results || []).map((movie) => `<button type="button" data-tmdb-id="${movie.id}" class="flex w-full items-center gap-3 rounded-lg bg-white p-2 text-left hover:bg-gray-100">
                    ${movie.poster_url ? `<img src="${escapeHtml(movie.poster_url)}" alt="" class="h-14 w-10 rounded object-cover">` : '<div class="h-14 w-10 rounded bg-gray-100"></div>'}
                    <span class="min-w-0 text-sm font-medium">${escapeHtml(movie.title)} (${escapeHtml((movie.release_date || '').slice(0, 4))})</span>
                </button>`).join('') || '<p class="text-sm text-gray-500">No results.</p>';

                results.querySelectorAll('[data-tmdb-id]').forEach((button) => button.addEventListener('click', async () => {
                    const response = await fetch(`{{ url('/submissions/tmdb') }}/${button.dataset.tmdbId}`, {
                        headers: { 'Accept': 'application/json' },
                    });
                    const detail = await response.json();
                    if (!response.ok) throw new Error(detail.message || 'TMDB request failed.');
                    fillMovieForm(detail);
                }));
            } catch (error) {
                results.innerHTML = `<p class="text-sm text-red-600">${escapeHtml(error.message)}</p>`;
            }
        });
    });
</script>
@endpush
