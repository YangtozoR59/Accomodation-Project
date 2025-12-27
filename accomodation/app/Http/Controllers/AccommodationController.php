<?php

namespace App\Http\Controllers;

use App\Models\Accommodation;
use App\Models\Category;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AccommodationController extends Controller
{
    //
/**
     * Afficher la liste des hébergements (page d'accueil + recherche)
     */
    public function index(Request $request)
    {
        $query = Accommodation::with(['category', 'owner', 'images'])
            ->orderBy('created_at', 'desc');

        // Recherche par mot-clé
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Filtrer par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filtrer par quartier
        if ($request->filled('quartier')) {
            $query->where('quartier', 'ILIKE', '%' . $request->quartier . '%');
        }

        // Filtrer par prix
        if ($request->filled('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        // Filtrer par nombre de chambres
        if ($request->filled('nb_rooms')) {
            $query->where('nb_rooms', '>=', $request->nb_rooms);
        }

        // Filtrer par nombre d'invités
        if ($request->filled('nb_guests')) {
            $query->where('max_guests', '>=', $request->nb_guests);
        }

        // Filtrer par équipements
        if ($request->filled('amenities')) {
            $amenities = is_array($request->amenities) 
                ? $request->amenities 
                : explode(',', $request->amenities);
            
            foreach ($amenities as $amenity) {
                $query->whereJsonContains('amenities', $amenity);
            }
        }

        // Trier
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price_per_night', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price_per_night', 'desc');
                    break;
                case 'popular':
                    $query->orderBy('views_count', 'desc');
                    break;
            }
        }

        $accommodations = Accommodation::all();

        return view('accommodations.index', [
            'accommodations' => $accommodations,
            'categories' => Category::all(),
            'filters' => $request->only(['search', 'category', 'quartier', 'min_price', 'max_price', 'nb_rooms', 'nb_guests', 'amenities', 'sort']),
        ]);
    }

    /**
     * Afficher les détails d'un hébergement
     */
    public function show($id)
    {
        $accommodation = Accommodation::with([
            'category',
            'owner',
            'images' => fn($q) => $q->orderBy('order'),
            'reviews' => fn($q) => $q->with('user')->latest()->take(10),
        ])->findOrFail($id);

        // Incrémenter le compteur de vues
        $accommodation->increment('views_count');

        // Récupérer des hébergements similaires
        $similar = Accommodation::where('category_id', $accommodation->category_id)
            ->where('id', '!=', $accommodation->id)
            ->with(['category', 'images'])
            ->take(4)
            ->get();

        return view('accommodations.show', [
            'accommodation' => $accommodation,
            'similar' => $similar,
            'averageRating' => $accommodation->average_rating,
            'totalReviews' => $accommodation->reviews()->count(),
        ]);
    }

    /**
     * Vérifier la disponibilité pour des dates données
     */
    public function checkAvailability(Request $request, $id)
    {
        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $accommodation = Accommodation::findOrFail($id);

        // Vérifier s'il y a des réservations confirmées pour ces dates
        $hasReservation = $accommodation->reservations()
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

        return response()->json([
            'available' => !$hasReservation,
            'message' => $hasReservation 
                ? 'Cet hébergement n\'est pas disponible pour ces dates.' 
                : 'Cet hébergement est disponible pour ces dates.',
        ]);
    }
}
