<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\User\MovieController as UserMovieController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Auth\PasswordController;

Route::get('/', [HomeController::class, 'index'])
    ->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::get('/movies', [UserMovieController::class, 'index'])
    ->name('movies.index');

Route::get('/movies/{movie}', [UserMovieController::class, 'show'])
    ->name('movies.show');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/movies/{movie}/comments', [CommentController::class, 'store'])
        ->name('movies.comments.store');

    Route::put('/comments/{comment}', [CommentController::class, 'update'])
        ->name('comments.update');

    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])
        ->name('comments.destroy');

    Route::get('/favorites', [FavoriteController::class, 'index'])
        ->name('favorites');

    Route::post('/movies/{movie}/favorite', [FavoriteController::class, 'store'])
        ->name('movies.favorite');

    Route::delete('/movies/{movie}/favorite', [FavoriteController::class, 'destroy'])
        ->name('movies.unfavorite');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function ()
{

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('users', UserController::class)
    ->except(['show']);

    Route::resource('movies', MovieController::class)
    ->except(['show']);

    Route::get('movies/tmdb/search', [MovieController::class, 'tmdbSearch'])
        ->name('movies.tmdb.search');
    Route::get('movies/tmdb/{tmdbMovie}', [MovieController::class, 'tmdbDetails'])
        ->whereNumber('tmdbMovie')
        ->name('movies.tmdb.details');

    Route::resource('genres', GenreController::class)
    ->except(['show']);

    Route::resource('pages', PageController::class)
    ->except(['show']);
});

Route::middleware('auth')->group(function () {
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
