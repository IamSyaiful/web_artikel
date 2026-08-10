<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Movie;

class CommentController extends Controller
{
    public function store(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'movie_id' => $movie->id,
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('movies.show', $movie)
            ->with('success', 'Comment posted successfully.');
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return redirect()
                ->back()
                ->with('error', 'You can only delete your own comments.');
        }

        $comment->delete();

        return redirect()
            ->back()
            ->with('success', 'Komentar berhasil dihapus.');
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update([
            'comment' => $validated['comment'],
        ]);

        return redirect()
            ->route('movies.show', $comment->movie_id)
            ->with('success', 'Comment updated successfully.');
    }
}
