<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGame;
use App\Models\Game;
use Illuminate\Support\Facades\Auth;

class UserGameController extends Controller
{
    /**
     * Display the form for adding a new user game.
     */
    public function create()
    {
        $games = Game::all();
        return view('portal.user.profile.usergame.usergame-add', compact('games'));
    }

    /**
     * Store a newly created user game.
     */
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_game_uid' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ]);

        UserGame::create([
            'user_id' => Auth::id(),
            'game_id' => $request->game_id,
            'user_game_uid' => $request->user_game_uid,
            'nickname' => $request->nickname,
        ]);

        return redirect()->route('profile.show')
                        ->with('success', 'Game ID berhasil ditambahkan!');
    }

    /**
     * Show the form for editing the specified user game.
     */
    public function edit(UserGame $userGame)
    {
        // Ensure user can only edit their own games
        if ($userGame->user_id !== Auth::id()) {
            abort(403);
        }

        $games = Game::all();
        return view('portal.user.profile.usergame.usergame-update', compact('userGame', 'games'));
    }

    /**
     * Update the specified user game.
     */
    public function update(Request $request, UserGame $userGame)
    {
        // Ensure user can only update their own games
        if ($userGame->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'game_id' => 'required|exists:games,id',
            'user_game_uid' => 'required|string|max:255',
            'nickname' => 'nullable|string|max:255',
        ]);

        $userGame->update([
            'game_id' => $request->game_id,
            'user_game_uid' => $request->user_game_uid,
            'nickname' => $request->nickname,
        ]);

        return redirect()->route('profile.show')
                        ->with('success', 'Game ID berhasil diperbarui!');
    }

    /**
     * Remove the specified user game.
     */
    public function destroy(UserGame $userGame)
    {
        // Ensure user can only delete their own games
        if ($userGame->user_id !== Auth::id()) {
            abort(403);
        }

        $userGame->delete();

        return redirect()->route('profile.show')
                        ->with('success', 'Game ID berhasil dihapus!');
    }
}