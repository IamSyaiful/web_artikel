<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $recentMovies = Movie::approved()
            ->with('genres')
            ->latest()
            ->take(10)
            ->get();

        $recentUsers = User::latest()
            ->take(10)
            ->get();

        $pendingSubmissions = Movie::where('status', Movie::STATUS_PENDING)
            ->with('author')
            ->latest()
            ->take(5)
            ->get();

        $pendingSubmissionCount = Movie::where('status', Movie::STATUS_PENDING)->count();

        return view('pages.admin.dashboard.index', [
            'recentMovies' => $recentMovies,
            'recentUsers' => $recentUsers,
            'pendingSubmissions' => $pendingSubmissions,
            'pendingSubmissionCount' => $pendingSubmissionCount,
        ]);
    }
}
