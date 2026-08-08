<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\User\MovieController as UserMovieController;
use App\Http\Controllers\User\CommentController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/movies', [UserMovieController::class, 'index'])
    ->name('movies.index');

Route::get('/movies/{movie}', [UserMovieController::class, 'show'])
    ->name('movies.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/favorites', function () {
        return 'My Favorite Movies';
    })->name('favorites');

    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
        ->name('movies.comments.store');

    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

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
