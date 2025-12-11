<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Accommodation;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Afficher mes réservations
     */
    public function index(Request $request)
    {
        $query = Reservation::where('user_id', Auth::id())
            ->with(['accommodation.images', 'accommodation.category'])
            ->orderBy('created_at', 'desc');
        
        // Filtrer par statut
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $reservations = $query->paginate(10);

        return view('reservations.index', compact('reservations'));
    }

    /**
     * Créer une nouvelle réservation
     */
    public function store(Request $request)
    {
        $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
            'nb_guests' => 'required|integer|min:1',
            'special_requests' => 'nullable|string|max:500',
        ]);

        $accommodation = Accommodation::findOrFail($request->accommodation_id);

        // Vérifier que l'hébergement est disponible
        if (!$accommodation->is_available || !$accommodation->is_verified) {
            return back()->withErrors(['error' => 'Cet hébergement n\'est pas disponible.']);
        }

        // Vérifier le nombre maximum d'invités
        if ($request->nb_guests > $accommodation->max_guests) {
            return back()->withErrors([
                'nb_guests' => 'Le nombre d\'invités dépasse la capacité maximale.'
            ]);
        }

        // Vérifier s'il y a des réservations qui chevauchent
        $hasConflict = Reservation::where('accommodation_id', $accommodation->id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function($query) use ($request) {
                $query->whereBetween('check_in', [$request->check_in, $request->check_out])
                    ->orWhereBetween('check_out', [$request->check_in, $request->check_out])
                    ->orWhere(function($q) use ($request) {
                        $q->where('check_in', '<=', $request->check_in)
                          ->where('check_out', '>=', $request->check_out);
                    });
            })
            ->exists();

        if ($hasConflict) {
            return back()->withErrors(['error' => 'Ces dates ne sont pas disponibles.']);
        }

        // Calculer le nombre de nuits et le prix total
        $checkIn = Carbon::parse($request->check_in);
        $checkOut = Carbon::parse($request->check_out);
        $nbNights = $checkIn->diffInDays($checkOut);
        $totalPrice = $nbNights * $accommodation->price_per_night;

        // Créer la réservation
        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'accommodation_id' => $accommodation->id,
            'check_in' => $request->check_in,
            'check_out' => $request->check_out,
            'nb_guests' => $request->nb_guests,
            'total_price' => $totalPrice,
            'status' => 'pending',
            'special_requests' => $request->special_requests,
        ]);

        return redirect()->route('reservations.show', $reservation)
            ->with('success', 'Votre réservation a été créée avec succès !');
    }

    /**
     * Afficher les détails d'une réservation
     */
    public function show(Reservation $reservation)
    {
        // Vérifier que l'utilisateur a le droit de voir cette réservation
        if ($reservation->user_id !== Auth::id() && 
            $reservation->accommodation->user_id !== Auth::id() &&
            !Auth::user()->isAdmin) {
            abort(403);
        }

        $reservation->load(['accommodation.images', 'accommodation.owner', 'user']);

        return Inertia::render('Reservations/Show', [
            'reservation' => $reservation,
        ]);
    }

    /**
     * Annuler une réservation
     */
    public function cancel(Request $request, Reservation $reservation)
    {
        // Vérifier que l'utilisateur a le droit d'annuler
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        // On ne peut annuler que les réservations pending ou confirmed
        if (!in_array($reservation->status, ['pending', 'confirmed'])) {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être annulée.']);
        }

        $request->validate([
            'cancellation_reason' => 'required|string|max:500',
        ]);

        $reservation->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->cancellation_reason,
        ]);

        return redirect()->route('reservations.index')
            ->with('success', 'Votre réservation a été annulée.');
    }

    /**
     * Confirmer une réservation (propriétaire)
     */
    public function confirm(Reservation $reservation)
    {
        // Vérifier que c'est le propriétaire
        if ($reservation->accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin) {
            abort(403);
        }

        if ($reservation->status !== 'pending') {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être confirmée.']);
        }

        $reservation->update(['status' => 'confirmed']);

        return back()->with('success', 'Réservation confirmée avec succès.');
    }

    /**
     * Marquer une réservation comme terminée
     */
    public function complete(Reservation $reservation)
    {
        // Vérifier que c'est le propriétaire
        if ($reservation->accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin) {
            abort(403);
        }

        if ($reservation->status !== 'confirmed') {
            return back()->withErrors(['error' => 'Cette réservation ne peut pas être marquée comme terminée.']);
        }

        $reservation->update(['status' => 'completed']);

        return back()->with('success', 'Réservation marquée comme terminée.');
    }
}