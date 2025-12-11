<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    //
    /**
     * Dashboard utilisateur
     */
    public function index()
    {
        $user = Auth::user();
        
        // Statistiques
        $stats = [
            'total_reservations' => Reservation::where('user_id', $user->id)->count(),
            'active_reservations' => Reservation::where('user_id', $user->id)
                ->whereIn('status', ['pending', 'confirmed'])
                ->count(),
            'reviews_count' => Review::where('user_id', $user->id)->count(),
            'favorites_count' => 0, // À implémenter plus tard
        ];
        
        // Prochaines réservations (confirmées et à venir)
        $upcomingReservations = Reservation::where('user_id', $user->id)
            ->with(['accommodation.images', 'accommodation.category'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('check_in', '>=', Carbon::today())
            ->orderBy('check_in', 'asc')
            ->take(3)
            ->get();
        
        // Historique récent
        $recentReservations = Reservation::where('user_id', $user->id)
            ->with(['accommodation'])
            ->whereIn('status', ['completed', 'cancelled'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboard', compact('stats', 'upcomingReservations', 'recentReservations'));
    }
}
