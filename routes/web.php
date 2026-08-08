<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', function () {
    return 'Movies List';
})->name('movies.index');

Route::get('/movies/{movie}', function ($movie) {
    return "Movie Details: {$movie}";
})->name('movies.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/favorites', function () {
        return 'My Favorite Movies';
    })->name('favorites');

    Route::post('/movies/{movie}/comments', function ($movie) {
        return "Comment on {$movie}";
    })->name('movies.comments.store');

    Route::post('/movies/{movie}/favorite', function ($movie) {
        return "Favorite movie {$movie}";
    })->name('movies.favorite');

    Route::delete('/movies/{movie}/favorite', function ($movie) {
        return "Remove favorite {$movie}";
    })->name('movies.unfavorite');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->group(function () {

    Route::get('/', function () {
        return 'Admin Dashboard';
    })->name('admin.dashboard');

    Route::resource('users', UserController::class)
    ->except(['show']);

    Route::resource('movies', MovieController::class)
    ->except(['show']);

    Route::resource('genres', GenreController::class)
    ->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
