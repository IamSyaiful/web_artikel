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

        return response()->json([
            'message' => 'Comment added successfully.',
            'comment' => $comment->load('user'),
        ], 201);
    }

    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message'=> 'You Can Only Delete Your Own Comments.'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully.']);
    }

    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== auth()->id()) {
            return response()->json(['message' => 'You can only edit your own comments.'], 403);
        }

        $validated = $request->validate([
            'comment' => ['required', 'string', 'max:1000'],
        ]);

        $comment->update([
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'message' => 'Comment updated successfully.',
            'comment' => $comment->load('user'),
        ]);
    }
}
