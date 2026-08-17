<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\Movie;
use App\Services\RichTextSanitizer;
use App\Services\TmdbService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MovieSubmissionController extends Controller
{
    public function index(Request $request): View
    {
        $movies = $request->user()->movies()
            ->with('genres')
            ->latest()
            ->paginate(10);

        return view('pages.user.movie-submissions.index', compact('movies'));
    }

    public function create(): View
    {
        return view('pages.user.movie-submissions.create', [
            'genres' => Genre::orderBy('name')->get(),
            'movie' => new Movie,
        ]);
    }

    public function store(Request $request, TmdbService $tmdb, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $validated = $this->validated($request);
        $validated['synopsis'] = $sanitizer->clean($validated['synopsis'] ?? null);
        $validated['review'] = $sanitizer->clean($validated['review'] ?? null);
        $poster = $this->storePoster($request, $tmdb);

        $movie = $request->user()->movies()->create([
            ...$this->movieAttributes($validated),
            'slug' => Str::slug($validated['title']),
            'poster' => $poster,
            'status' => Movie::STATUS_PENDING,
            'note' => null,
        ]);

        $movie->genres()->sync($validated['genres']);

        return redirect()->route('submissions.index')->with('success', 'Pengajuan artikel movie berhasil dikirim.');
    }

    public function edit(Request $request, Movie $movie): View
    {
        $this->ensureRejectedOwner($request, $movie);

        return view('pages.user.movie-submissions.edit', [
            'genres' => Genre::orderBy('name')->get(),
            'movie' => $movie->load('genres'),
        ]);
    }

    public function update(Request $request, Movie $movie, TmdbService $tmdb, RichTextSanitizer $sanitizer): RedirectResponse
    {
        $this->ensureRejectedOwner($request, $movie);
        $validated = $this->validated($request);
        $validated['synopsis'] = $sanitizer->clean($validated['synopsis'] ?? null);
        $validated['review'] = $sanitizer->clean($validated['review'] ?? null);
        $poster = $movie->poster;

        if ($request->hasFile('poster') || $request->filled('tmdb_poster_path')) {
            if ($poster) {
                Storage::disk('public')->delete($poster);
            }

            $poster = $this->storePoster($request, $tmdb);
        }

        $movie->update([
            ...$this->movieAttributes($validated),
            'slug' => Str::slug($validated['title']),
            'poster' => $poster,
            'status' => Movie::STATUS_PENDING,
            'note' => null,
        ]);
        $movie->genres()->sync($validated['genres']);

        return redirect()->route('submissions.index')->with('success', 'Pengajuan diperbarui dan dikirim ulang untuk direview.');
    }

    public function tmdbSearch(Request $request, TmdbService $tmdb)
    {
        $validated = $request->validate(['query' => ['required', 'string', 'min:2', 'max:100']]);

        try {
            return response()->json(['results' => $tmdb->searchMovies($validated['query'])]);
        } catch (RequestException|\RuntimeException $exception) {
            report($exception);

            return response()->json(['message' => 'TMDB tidak dapat diakses saat ini.'], 502);
        }
    }

    public function tmdbDetails(int $tmdbMovie, TmdbService $tmdb)
    {
        try {
            return response()->json($tmdb->movieDetails($tmdbMovie));
        } catch (RequestException|\RuntimeException $exception) {
            report($exception);

            return response()->json(['message' => 'Detail film dari TMDB tidak dapat diambil.'], 502);
        }
    }

    private function ensureRejectedOwner(Request $request, Movie $movie): void
    {
        abort_unless(
            $movie->user_id === $request->user()->id && $movie->status === Movie::STATUS_REJECTED,
            403,
        );
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'max:10240'],
            'release_date' => ['nullable', 'date'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'director' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'synopsis' => ['nullable', 'string'],
            'review' => ['nullable', 'string'],
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['exists:genres,id'],
        ]);
    }

    private function movieAttributes(array $validated): array
    {
        return [
            'title' => $validated['title'],
            'release_date' => $validated['release_date'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'director' => $validated['director'] ?? null,
            'rating' => $validated['rating'] ?? 0,
            'synopsis' => $validated['synopsis'] ?? null,
            'review' => $validated['review'] ?? null,
        ];
    }

    private function storePoster(Request $request, TmdbService $tmdb): ?string
    {
        if ($request->hasFile('poster')) {
            return $request->file('poster')->store('posters', 'public');
        }

        if ($request->filled('tmdb_poster_path')) {
            try {
                return $tmdb->storePoster($request->string('tmdb_poster_path')->toString(), 'posters');
            } catch (RequestException|\RuntimeException $exception) {
                report($exception);
            }
        }

        return null;
    }
}
