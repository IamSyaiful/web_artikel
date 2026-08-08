<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;

class MovieController extends Controller
{
    public function index()
    {
        $movies =Movie::with('genres')->latest()->get();

        return response()->json($movies);
    }

    public function show(Movie $movie)
    {
        $movie->load('genres', 'comments.user');

        return response()->json([
            'movie' => $movie,
        ]);
    }
}
