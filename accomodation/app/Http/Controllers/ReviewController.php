<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{

    public function store(Request $request)
    {
        $validated = $request->validate([
            'accommodation_id' => 'required|exists:accommodations,id',
            'reservation_id' => 'nullable|exists:reservations,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'cleanliness_rating' => 'nullable|integer|min:1|max:5',
            'location_rating' => 'nullable|integer|min:1|max:5',
            'value_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $accommodation = Accommodation::findOrFail($validated['accommodation_id']);
        $userId = Auth::id();

        // Vérifier que l'utilisateur a bien séjourné dans cet hébergement
        if ($request->filled('reservation_id')) {
            Reservation::where('id', $validated['reservation_id'])
                ->where('user_id', $userId)
                ->where('accommodation_id', $accommodation->getAttribute('id'))
                ->where('status', 'completed')
                ->firstOrFail();
        } else {
            // Vérifier qu'il a au moins une réservation terminée
            $hasStayed = Reservation::where('user_id', $userId)
                ->where('accommodation_id', $accommodation->getAttribute('id'))
                ->where('status', 'completed')
                ->count() > 0;

            if (!$hasStayed) {
                return back()->withErrors([
                    'error' => 'Vous devez avoir séjourné dans cet hébergement pour laisser un avis.'
                ]);
            }
        }

        // Vérifier que l'utilisateur n'a pas déjà laissé un avis
        $existingReview = Review::where('user_id', $userId)
            ->where('accommodation_id', $accommodation->id)
            ->first();

        if ($existingReview) {
            return back()->withErrors([
                'error' => 'Vous avez déjà laissé un avis pour cet hébergement.'
            ]);
        }

        // Créer l'avis
        Review::create([
            'user_id' => $userId,
            'accommodation_id' => $accommodation->getAttribute('id'),
            'reservation_id' => $validated['reservation_id'] ?? null,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'cleanliness_rating' => $validated['cleanliness_rating'] ?? null,
            'location_rating' => $validated['location_rating'] ?? null,
            'value_rating' => $validated['value_rating'] ?? null,
            'is_verified' => false, // L'admin devra vérifier
        ]);

        return back()->with('success', 'Merci pour votre avis ! Il sera publié après vérification.');
    }

    /**
     * Modifier un avis
     */
    public function update(Request $request, Review $review)
    {
        // Vérifier que c'est bien l'auteur
        if ($review->getAttribute('user_id') !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'cleanliness_rating' => 'nullable|integer|min:1|max:5',
            'location_rating' => 'nullable|integer|min:1|max:5',
            'value_rating' => 'nullable|integer|min:1|max:5',
        ]);

        $review->update([
            'rating' => $validated['rating'],
            'comment' => $validated['comment'] ?? null,
            'cleanliness_rating' => $validated['cleanliness_rating'] ?? null,
            'location_rating' => $validated['location_rating'] ?? null,
            'value_rating' => $validated['value_rating'] ?? null,
            'is_verified' => false, // Remettre en attente de vérification
        ]);

        return back()->with('success', 'Votre avis a été mis à jour.');
    }

    /**
     * Supprimer un avis
     */
    public function destroy(Review $review)
    {
        // Vérifier que c'est bien l'auteur ou un admin
        $user = Auth::user();
        if ($review->getAttribute('user_id') !== Auth::id() && (!$user || !($user->role === 'admin'))) {
            abort(403);
        }

        $review->delete();

        return back()->with('success', value: 'L\'avis a été supprimé.');
    }
}
