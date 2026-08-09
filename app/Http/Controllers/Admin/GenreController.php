<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Genre;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $genres = Genre::latest()->get();

        return view('pages.admin.genres.index', compact('genres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.admin.genres.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:genres,name'],
        ]);

        $slug = Str::slug($validated['name']);

        if (Genre::where('slug', $slug)->exists()) {
            return response()->json([
                'message' => 'The generated slug already exists.',
            ], 422);
        }

        $genre = Genre::create([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.genres.index')
            ->with('success_title', 'Genre berhasil disimpan')
            ->with('success', 'Genre baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Genre $genre)
    {
        return response()->json([
            'genre' => $genre,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Genre $genre)
    {
        return view('pages.admin.genres.edit', compact('genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Genre $genre)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('genres', 'name')->ignore($genre->id)],
        ]);

        $slug = Str::slug($validated['name']);

        if (Genre::where('slug', $slug)->where('id', '!=', $genre->id)->exists()) {
            return response()->json([
                'message' => 'The generated slug already exists.',
            ], 422);
        }

        $genre->update([
            'name' => $validated['name'],
            'slug' => $slug,
        ]);

        return redirect()
            ->route('admin.genres.index')
            ->with('success_title', 'Genre berhasil diedit')
            ->with('success', 'Perubahan genre berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Genre $genre)
    {
        $genre->delete();

        return redirect()
            ->route('admin.genres.index')
            ->with('success_title', 'Genre berhasil dihapus')
            ->with('success', 'Genre berhasil dihapus dari daftar.');
    }
}
