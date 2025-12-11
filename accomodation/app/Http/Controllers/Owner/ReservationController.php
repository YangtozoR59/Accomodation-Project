<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

// Pas besoin d'Inertia

class ReservationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    /**
     * Afficher toutes les réservations de mes hébergements
     */
    public function index(Request $request)
    {
        $query = Reservation::whereHas('accommodation', function($q) {
            $q->where('user_id', Auth::id());
        })->with(['user', 'accommodation']);

        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reservations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('owner.reservations.index', compact('reservations'));
    }

    /**
     * Afficher les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        // Vérifier que c'est bien une réservation pour un de mes hébergements
        if ($reservation->accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        $reservation->load(['user', 'accommodation.images']);

        return view('owner.reservations.show', compact('reservation'));
    }
}