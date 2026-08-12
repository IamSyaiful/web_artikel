<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\MovieController;
use App\Http\Controllers\User\MovieController as UserMovieController;
use App\Http\Controllers\User\CommentController;
use App\Http\Controllers\User\FavoriteController;
use App\Http\Controllers\User\MovieSubmissionController as UserMovieSubmissionController;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MovieSubmissionController as AdminMovieSubmissionController;
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

    Route::delete('/movies/{movie}', [UserMovieController::class, 'destroy'])
        ->name('movies.destroy');

    Route::get('/submissions', [UserMovieSubmissionController::class, 'index'])
        ->name('submissions.index');
    Route::get('/submissions/create', [UserMovieSubmissionController::class, 'create'])
        ->name('submissions.create');
    Route::post('/submissions', [UserMovieSubmissionController::class, 'store'])
        ->name('submissions.store');
    Route::get('/submissions/{submission}/edit', [UserMovieSubmissionController::class, 'edit'])
        ->name('submissions.edit');
    Route::put('/submissions/{submission}', [UserMovieSubmissionController::class, 'update'])
        ->name('submissions.update');
    Route::get('/submissions/tmdb/search', [UserMovieSubmissionController::class, 'tmdbSearch'])
        ->name('submissions.tmdb.search');
    Route::get('/submissions/tmdb/{tmdbMovie}', [UserMovieSubmissionController::class, 'tmdbDetails'])
        ->whereNumber('tmdbMovie')
        ->name('submissions.tmdb.details');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function ()
{

    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('users', [UserController::class, 'index'])
        ->name('users.index');
    Route::get('users/create', [UserController::class, 'create'])
        ->name('users.create');
    Route::post('users', [UserController::class, 'store'])
        ->name('users.store');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])
        ->name('users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])
        ->name('users.update');
    Route::delete('users/{user}', [UserController::class, 'destroy'])
        ->name('users.destroy');

    Route::get('movies', [MovieController::class, 'index'])
        ->name('movies.index');
    Route::get('movies/create', [MovieController::class, 'create'])
        ->name('movies.create');
    Route::post('movies', [MovieController::class, 'store'])
        ->name('movies.store');
    Route::get('movies/{movie}/edit', [MovieController::class, 'edit'])
        ->name('movies.edit');
    Route::put('movies/{movie}', [MovieController::class, 'update'])
        ->name('movies.update');
    Route::delete('movies/{movie}', [MovieController::class, 'destroy'])
        ->name('movies.destroy');

    Route::get('movie-submissions', [AdminMovieSubmissionController::class, 'index'])
        ->name('movie-submissions.index');
    Route::get('movie-submissions/{submission}', [AdminMovieSubmissionController::class, 'show'])
        ->name('movie-submissions.show');
    Route::post('movie-submissions/{submission}/approve', [AdminMovieSubmissionController::class, 'approve'])
        ->name('movie-submissions.approve');
    Route::post('movie-submissions/{submission}/reject', [AdminMovieSubmissionController::class, 'reject'])
        ->name('movie-submissions.reject');

    Route::get('movies/tmdb/search', [MovieController::class, 'tmdbSearch'])
        ->name('movies.tmdb.search');
    Route::get('movies/tmdb/{tmdbMovie}', [MovieController::class, 'tmdbDetails'])
        ->whereNumber('tmdbMovie')
        ->name('movies.tmdb.details');

    Route::get('genres', [GenreController::class, 'index'])
        ->name('genres.index');
    Route::get('genres/create', [GenreController::class, 'create'])
        ->name('genres.create');
    Route::post('genres', [GenreController::class, 'store'])
        ->name('genres.store');
    Route::get('genres/{genre}/edit', [GenreController::class, 'edit'])
        ->name('genres.edit');
    Route::put('genres/{genre}', [GenreController::class, 'update'])
        ->name('genres.update');
    Route::delete('genres/{genre}', [GenreController::class, 'destroy'])
        ->name('genres.destroy');

    Route::get('pages', [PageController::class, 'index'])
        ->name('pages.index');
    Route::get('pages/create', [PageController::class, 'create'])
        ->name('pages.create');
    Route::post('pages', [PageController::class, 'store'])
        ->name('pages.store');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])
        ->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])
        ->name('pages.update');
    Route::delete('pages/{page}', [PageController::class, 'destroy'])
        ->name('pages.destroy');
});

Route::middleware('auth')->group(function () {
    Route::put('/password', [PasswordController::class, 'update'])->name('password.update');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
