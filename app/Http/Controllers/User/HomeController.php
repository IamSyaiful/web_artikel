<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;

class HomeController extends Controller
{
    public function index()
    {
        $movies = Movie::with('genres')
            ->orderByDesc('release_date')
            ->orderByDesc('rating')
            ->take(10)
            ->get();

        $genres = Genre::withCount('movies')
        ->orderByDesc('movies_count')
        ->orderBy('name')
        ->take(6)
        ->get();

        return view('pages.user.home.index', compact('movies', 'genres'));
    }
}
