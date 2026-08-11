<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieSubmission;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MovieSubmissionController extends Controller
{
    public function index(): View
    {
        $submissions = MovieSubmission::with('author')
            ->latest()
            ->paginate(15);

        return view('pages.admin.movie-submissions.index', compact('submissions'));
    }

    public function show(MovieSubmission $submission): View
    {
        $submission->load(['author', 'reviewer', 'genres', 'approvedMovie']);

        return view('pages.admin.movie-submissions.show', compact('submission'));
    }

    public function approve(MovieSubmission $submission): RedirectResponse
    {
        if ($submission->status !== MovieSubmission::STATUS_PENDING) {
            return back()->with('error', 'Pengajuan ini sudah direview.');
        }

        if (Movie::where('slug', $submission->slug)->exists()) {
            return back()->with('error', 'Slug movie sudah digunakan. Pengajuan tetap berstatus pending.');
        }

        DB::transaction(function () use ($submission): void {
            $submission = MovieSubmission::query()->lockForUpdate()->findOrFail($submission->id);

            if ($submission->status !== MovieSubmission::STATUS_PENDING) {
                abort(409, 'Pengajuan ini sudah direview.');
            }

            if (Movie::where('slug', $submission->slug)->exists()) {
                abort(422, 'Slug movie sudah digunakan.');
            }

            $movie = Movie::create([
                'user_id' => $submission->user_id,
                'title' => $submission->title,
                'slug' => $submission->slug,
                'poster' => $submission->poster,
                'release_date' => $submission->release_date,
                'duration' => $submission->duration,
                'director' => $submission->director,
                'rating' => $submission->rating,
                'synopsis' => $submission->synopsis,
                'review' => $submission->review,
            ]);

            $movie->genres()->sync($submission->genres()->pluck('genres.id'));
            $submission->update([
                'status' => MovieSubmission::STATUS_APPROVED,
                'reviewed_by' => auth()->id(),
                'reviewed_at' => now(),
                'approved_movie_id' => $movie->id,
                'rejection_reason' => null,
            ]);
        });

        return redirect()->route('admin.movie-submissions.index')->with('success', 'Pengajuan berhasil disetujui dan movie dipublikasikan.');
    }

    public function reject(Request $request, MovieSubmission $submission): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:5000'],
        ]);

        if ($submission->status !== MovieSubmission::STATUS_PENDING) {
            return back()->with('error', 'Pengajuan ini sudah direview.');
        }

        $submission->update([
            'status' => MovieSubmission::STATUS_REJECTED,
            'rejection_reason' => $validated['rejection_reason'],
            'reviewed_by' => $request->user()->id,
            'reviewed_at' => now(),
            'approved_movie_id' => null,
        ]);

        return redirect()->route('admin.movie-submissions.show', $submission)->with('success', 'Pengajuan ditolak dan alasan telah dikirim ke user.');
    }
}
