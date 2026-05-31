<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $isAdmin = $user->is_admin;

        $gamesQuery = Game::query();

        if (! $isAdmin) {
            $gamesQuery->where('user_id', $user->id);
        }

        $totalUsers = User::count();
        $totalGames = (clone $gamesQuery)->count();

        $genreStats = (clone $gamesQuery)
            ->selectRaw('genre, COUNT(*) as count')
            ->groupBy('genre')
            ->get();

        $statusStats = (clone $gamesQuery)
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->get();

        $recentGames = (clone $gamesQuery)
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'isAdmin',
            'totalUsers',
            'totalGames',
            'genreStats',
            'statusStats',
            'recentGames'
        ));
    }
}
