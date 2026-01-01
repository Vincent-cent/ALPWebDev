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
use Carbon\Carbon;

class ProfileController extends Controller
{
    
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
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
                                   ->where(function($q) {
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

        return view('portal.user.profile.profile', compact('orderStats', 'userGames'));
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
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

<<<<<<< HEAD
    public function show()
    {
        return view('profile.show', [
            'user' => auth()->user(),
        ]);
=======
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
                          ->where(function($q) {
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
                                  ->where(function($q) {
                                      $q->where('midtrans_status', '!=', 'cancelled')
                                        ->orWhereNull('midtrans_status');
                                  })->count(),
            'failed' => Transaksi::where('user_id', $userId)->where('midtrans_status', 'cancelled')->count(),
            'total_spent' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->sum('total') ?: 0,
            'avg_transaction' => Transaksi::where('user_id', $userId)->whereNotNull('paid_at')->avg('total') ?: 0
        ];

        return view('portal.user.profile.history', compact('transactions', 'summary'));
>>>>>>> c84f8aaf951ad36afde0f0955ac787acf022d9fc
    }
}
