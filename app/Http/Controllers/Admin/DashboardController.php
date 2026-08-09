<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $recentMovies = Movie::with('genres')
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        return view('pages.admin.dashboard.index', [
            'recentMovies' => $recentMovies,
            'recentUsers' => $recentUsers,
        ]);
    }
}
