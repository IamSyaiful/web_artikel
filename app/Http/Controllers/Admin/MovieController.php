<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movie::with('genres')->latest()->get();
        return response()->json($movies);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $genres = Genre::orderBy('name')->get();

        return response()->json([
            'genres' => $genres,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'release_date' => ['nullable', 'date'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'director' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'synopsis' => ['nullable', 'string'],
            'review' => ['nullable', 'string'],
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['exists:genres,id'],
        ]);

        $slug = Str::slug($validated['title']);

        if (Movie::where('slug', $slug)->exists()) {
            return response()->json([
                'message' => 'The generated slug already exists.',
            ], 422);
        }

        $posterPath = null;

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')
                ->store('movies/posters', 'public');
        }

        $movie = Movie::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'poster' => $posterPath,
            'release_date' => $validated['release_date'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'director' => $validated['director'] ?? null,
            'rating' => $validated['rating'] ?? 0,
            'synopsis' => $validated['synopsis'] ?? null,
            'review' => $validated['review'] ?? null,
        ]);

        $movie->genres()->sync($validated['genres']);

        return response()->json([
            'message' => 'Movie created successfully',
            'movie' => $movie->load('genres'),
        ], 201);
    }


    public function show(Movie $movie)
    {
        return response()->json([
            'movie' => $movie->load('genres'),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movie $movie)
    {
        $movie->load('genres');

        $genres = Genre::orderBy('name')->get();

        return response()->json([
            'movie' => $movie,
            'genres' => $genres,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movie $movie)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'poster' => ['nullable', 'image', 'max:2048'],
            'release_date' => ['nullable', 'date'],
            'duration' => ['nullable', 'integer', 'min:1'],
            'director' => ['nullable', 'string', 'max:255'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'synopsis' => ['nullable', 'string'],
            'review' => ['nullable', 'string'],
            'genres' => ['required', 'array', 'min:1'],
            'genres.*' => ['exists:genres,id'],
        ]);

        $slug = Str::slug($validated['title']);

        if (Movie::where('slug', $slug)->where('id', '!=', $movie->id)->exists()) {
            return response()->json([
                'message' => 'The generated slug already exists.',
            ], 422);
        }

        $posterPath = $movie->poster;

        if ($request->hasFile('poster')) {
            if ($movie->poster) {
                Storage::disk('public')->delete($movie->poster);
            }

            $posterPath = $request->file('poster')
                ->store('movies/posters', 'public');
        }

        $movie->update([
            'title' => $validated['title'],
            'slug' => $slug,
            'poster' => $posterPath,
            'release_date' => $validated['release_date'] ?? null,
            'duration' => $validated['duration'] ?? null,
            'director' => $validated['director'] ?? null,
            'rating' => $validated['rating'] ?? 0,
            'synopsis' => $validated['synopsis'] ?? null,
            'review' => $validated['review'] ?? null,
        ]);

        $movie->genres()->sync($validated['genres']);

        return response()->json([
            'message' => 'Movie updated successfully',
            'movie' => $movie->load('genres'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movie $movie)
    {
        if ($movie->poster) {
            Storage::disk('public')->delete($movie->poster);
        }

        $movie->delete();

        return response()->json([
            'message' => 'Movie deleted successfully',
        ]);
    }
}
