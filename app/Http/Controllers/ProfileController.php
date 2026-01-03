<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Transaksi;
use App\Models\UserGame;
use App\Models\Game;
use Carbon\Carbon;

class ProfileController extends Controller
{
    
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $user = $request->user();
        return view('portal.user.profile.editprofile', compact('user'));
    }


    /**
     * Update user profile.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
        ]);

        // Update name and email
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Update password if provided
        if (!empty($validated['password'])) {
            $user->update([
                'password' => bcrypt($validated['password']),
            ]);
        }

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui');
    }

    /**
     * Display the user's profile dashboard.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Calculate transaction statistics
        $userId = $user->id;
        $orderStats = [
            'successful' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->count(),
            'processing' => Transaksi::where('user_id', $userId)
                ->whereNull('paid_at')
                ->where(function ($q) {
                    $q->where('midtrans_status', '!=', 'cancelled')
                        ->orWhereNull('midtrans_status');
                })->count(),
            'unpaid' => Transaksi::where('user_id', $userId)
                ->whereNull('paid_at')
                ->whereNull('midtrans_status')
                ->count(),
            'failed' => Transaksi::where('user_id', $userId)->where('midtrans_status', 'cancelled')->count(),
        ];

        // Get user's game accounts
        $userGames = UserGame::with('game')->where('user_id', $userId)->get();

        return view('portal.user.profile.profile', compact('user', 'orderStats', 'userGames'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    /**
     * Display the user's transaction history with filtering.
     */
    public function history(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect()->route('login');
        }

        $query = Transaksi::with(['items.tipeItem', 'items.item.game', 'metodePembayaran'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc');

        // Apply status filter
        if ($request->filled('status')) {
            switch ($request->status) {
                case 'success':
                    $query->whereNotNull('paid_at');
                    break;
                case 'pending':
                    $query->whereNull('paid_at')
                        ->where(function ($q) {
                            $q->where('midtrans_status', '!=', 'cancelled')
                                ->orWhereNull('midtrans_status');
                        });
                    break;
                case 'failed':
                    $query->where('midtrans_status', 'cancelled');
                    break;
            }
        }

        // Apply date filters
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $transactions = $query->paginate(10)->appends($request->query());

        // Calculate summary stats - create separate queries for each calculation
        $userId = $user->id;

        $summary = [
            'total' => Transaksi::where('user_id', $userId)->count(),
            'successful' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->count(),
            'pending' => Transaksi::where('user_id', $userId)
                ->whereNull('paid_at')
                ->where(function ($q) {
                    $q->where('midtrans_status', '!=', 'cancelled')
                        ->orWhereNull('midtrans_status');
                })->count(),
            'failed' => Transaksi::where('user_id', $userId)->where('midtrans_status', 'cancelled')->count(),
            'total_spent' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->sum('total') ?: 0,
            'avg_transaction' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->avg('total') ?: 0
        ];

        return view('portal.user.profile.history', compact('transactions', 'summary'));
    }
}
