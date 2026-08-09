<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $movies = $user->favoriteMovies()->with('genres')->latest('favorites.created_at')->get();

        return response()->json([
            'movies' => $movies,
        ]);
    }

    public function store(Movie $movie)
    {
        $user = auth()->user();

        if ($user->favoritedMovies()->where('movie_id', $movie->id)->exists()) {
            return response()->json([
                'message' => 'Movie is already in your favorites.',
            ], 422);
        }

        $user->favoritedMovies()->attach($movie->id);

        return response()->json([
            'message' => 'Movie added to favorites.',
        ], 201);
    }

    public function destroy(Movie $movie)
    {
        $user = auth()->user();

        $user->favoritedMovies()->detach($movie->id);

        return response()->json([
            'message' => 'Movie removed from favorites.',
        ]);
    }
}
