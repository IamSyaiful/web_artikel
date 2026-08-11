<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use App\Models\Page;

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

        $homeContent = Page::where('slug', 'home')
            ->with('contents')
            ->first()?->contents
            ->pluck('value', 'key') ?? collect();

        return view('pages.user.home.index', compact('movies', 'genres', 'homeContent'));
    }
}
