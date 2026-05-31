<?php

namespace App\Http\Controllers;

use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private function gameImagePath(?string $filename = null): string
    {
        $path = public_path('avatars/game-images');

        if (! file_exists($path)) {
            mkdir($path, 0755, true);
        }

        return $filename ? $path . DIRECTORY_SEPARATOR . $filename : $path;
    }

    public function index()
    {
        $games = Game::where('user_id', auth()->id())->latest()->paginate(12);

        return view('games.index', compact('games'));
    }

    public function create()
    {
        return view('games.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'genre'    => 'required|string|max:100',
            'platform' => 'required|string|max:100',
            'status'   => 'required|in:owned,playing,completed,wishlist',
            'rating'   => 'nullable|integer|min:1|max:10',
            'notes'    => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'user_id'  => auth()->id(),
            'title'    => $request->title,
            'genre'    => $request->genre,
            'platform' => $request->platform,
            'status'   => $request->status,
            'rating'   => $request->rating,
            'notes'    => $request->notes,
            'image'    => null,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();

            $file->move($this->gameImagePath(), $filename);
            $data['image'] = $filename;
        }

        Game::create($data);

        return redirect()->route('games.index')
            ->with('success', 'Game added to your collection!');
    }

    public function edit(Game $game)
    {
        abort_if($game->user_id !== auth()->id(), 403);

        return view('games.edit', compact('game'));
    }

    public function update(Request $request, Game $game)
    {
        abort_if($game->user_id !== auth()->id(), 403);

        $request->validate([
            'title'    => 'required|string|max:255',
            'genre'    => 'required|string|max:100',
            'platform' => 'required|string|max:100',
            'status'   => 'required|in:owned,playing,completed,wishlist',
            'rating'   => 'nullable|integer|min:1|max:10',
            'notes'    => 'nullable|string',
            'image'    => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title'    => $request->title,
            'genre'    => $request->genre,
            'platform' => $request->platform,
            'status'   => $request->status,
            'rating'   => $request->rating,
            'notes'    => $request->notes,
        ];

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            if ($game->image && file_exists($this->gameImagePath($game->image))) {
                unlink($this->gameImagePath($game->image));
            }

            $file = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $file->extension();

            $file->move($this->gameImagePath(), $filename);
            $data['image'] = $filename;
        }

        $game->update($data);

        return redirect()->route('games.index')
            ->with('success', 'Game updated successfully!');
    }

    public function destroy(Game $game)
    {
        abort_if($game->user_id !== auth()->id(), 403);

        if ($game->image && file_exists($this->gameImagePath($game->image))) {
            unlink($this->gameImagePath($game->image));
        }

        $game->delete();

        return redirect()->route('games.index')
            ->with('success', 'Game removed from collection!');
    }
}
