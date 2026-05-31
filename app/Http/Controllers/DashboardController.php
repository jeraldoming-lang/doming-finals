<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Game;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers  = User::count();
        $totalGames  = Game::where('user_id', auth()->id())->count();
        $genreStats  = Game::where('user_id', auth()->id())
                        ->selectRaw('genre, count(*) as count')
                        ->groupBy('genre')->get();
        $statusStats = Game::where('user_id', auth()->id())
                        ->selectRaw('status, count(*) as count')
                        ->groupBy('status')->get();
        $recentGames = Game::where('user_id', auth()->id())
                        ->latest()->take(5)->get();

        return view('dashboard.index', compact(
            'totalUsers', 'totalGames', 'genreStats', 'statusStats', 'recentGames'
        ));
    }
}