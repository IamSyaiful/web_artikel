<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Favorite;
use App\Models\User;

class FavoriteController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $movies = $user->favoritedMovies()->with('genres')->latest('favorites.created_at')->get();

        return view('pages.user.favorites.index', [
            'movies' => $movies,
        ]);
    }

    public function store(Movie $movie)
    {
        $user = auth()->user();

        if ($user->favoritedMovies()->where('movie_id', $movie->id)->exists()) {
            return back()->with('error', 'Movie is already in your favorites.');
        }

        $user->favoritedMovies()->attach($movie->id);

        return back()->with('success', 'Movie added to favorites.');
    }

    public function destroy(Movie $movie)
    {
        $user = auth()->user();

        $user->favoritedMovies()->detach($movie->id);

        return back()->with('success', 'Movie removed from favorites.');
    }
}
