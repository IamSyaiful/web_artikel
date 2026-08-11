<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Genre;
use App\Models\MovieSubmission;
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
        $submissions = $request->user()->movieSubmissions()
            ->with('genres')
            ->latest()
            ->paginate(10);

        return view('pages.user.movie-submissions.index', compact('submissions'));
    }

    public function create(): View
    {
        return view('pages.user.movie-submissions.create', [
            'genres' => Genre::orderBy('name')->get(),
            'submission' => new MovieSubmission,
        ]);
    }

    public function store(Request $request, TmdbService $tmdb): RedirectResponse
    {
        $validated = $this->validated($request);
        $poster = $this->storePoster($request, $tmdb);

        $submission = $request->user()->movieSubmissions()->create([
            ...$this->movieAttributes($validated),
            'slug' => Str::slug($validated['title']),
            'poster' => $poster,
            'status' => MovieSubmission::STATUS_PENDING,
        ]);

        $submission->genres()->sync($validated['genres']);

        return redirect()->route('submissions.index')->with('success', 'Pengajuan artikel movie berhasil dikirim.');
    }

    public function edit(Request $request, MovieSubmission $submission): View
    {
        $this->ensureRejectedOwner($request, $submission);

        return view('pages.user.movie-submissions.edit', [
            'genres' => Genre::orderBy('name')->get(),
            'submission' => $submission->load('genres'),
        ]);
    }

    public function update(Request $request, MovieSubmission $submission, TmdbService $tmdb): RedirectResponse
    {
        $this->ensureRejectedOwner($request, $submission);
        $validated = $this->validated($request);
        $poster = $submission->poster;

        if ($request->hasFile('poster') || $request->filled('tmdb_poster_path')) {
            if ($poster) {
                Storage::disk('public')->delete($poster);
            }

            $poster = $this->storePoster($request, $tmdb);
        }

        $submission->update([
            ...$this->movieAttributes($validated),
            'slug' => Str::slug($validated['title']),
            'poster' => $poster,
            'status' => MovieSubmission::STATUS_PENDING,
            'rejection_reason' => null,
            'reviewed_by' => null,
            'reviewed_at' => null,
            'approved_movie_id' => null,
        ]);
        $submission->genres()->sync($validated['genres']);

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

    private function ensureRejectedOwner(Request $request, MovieSubmission $submission): void
    {
        abort_unless(
            $submission->user_id === $request->user()->id && $submission->status === MovieSubmission::STATUS_REJECTED,
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
            return $request->file('poster')->store('movie-submissions/posters', 'public');
        }

        if ($request->filled('tmdb_poster_path')) {
            try {
                return $tmdb->storePoster($request->string('tmdb_poster_path')->toString(), 'movie-submissions/posters');
            } catch (RequestException|\RuntimeException $exception) {
                report($exception);
            }
        }

        return null;
    }
}
