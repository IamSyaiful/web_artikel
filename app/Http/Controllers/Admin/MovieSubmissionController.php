<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MovieSubmissionController extends Controller
{
    public function index(): View
    {
        $submissions = Movie::where('status', Movie::STATUS_PENDING)
            ->with('author')
            ->latest()
            ->paginate(15);

        return view('pages.admin.movie-submissions.index', compact('submissions'));
    }

    public function show(Movie $submission): View
    {
        $submission->load(['author', 'genres']);

        return view('pages.admin.movie-submissions.show', compact('submission'));
    }

    public function approve(Movie $submission): RedirectResponse
    {
        if ($submission->status !== Movie::STATUS_PENDING) {
            return back()->with('error', 'Pengajuan ini sudah direview.');
        }

        $submission->update([
            'status' => Movie::STATUS_APPROVED,
            'note' => null,
        ]);

        return redirect()->route('admin.movie-submissions.index')->with('success', 'Pengajuan berhasil disetujui dan movie dipublikasikan.');
    }

    public function reject(Request $request, Movie $submission): RedirectResponse
    {
        $validated = $request->validate([
            'rejection_reason' => ['required', 'string', 'max:5000'],
        ]);

        if ($submission->status !== Movie::STATUS_PENDING) {
            return back()->with('error', 'Pengajuan ini sudah direview.');
        }

        $submission->update([
            'status' => Movie::STATUS_REJECTED,
            'note' => $validated['rejection_reason'],
        ]);

        return redirect()->route('admin.movie-submissions.index')->with('success', 'Pengajuan ditolak dan alasan telah dikirim ke user.');
    }
}
