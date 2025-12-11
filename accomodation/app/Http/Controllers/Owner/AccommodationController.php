<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Category;
use App\Models\Image;
use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Pas besoin d'Inertia
use Illuminate\Support\Facades\Storage;

class AccommodationController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth', 'verified']);
    // }

    public function index()
    {
        $userId = Auth::id();
        $accommodations = Accommodation::where('user_id', $userId)
            ->with(['category', 'images'])
            ->withCount('reservations')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        
        // Statistiques pour le dashboard
        $stats = [
            'total_accommodations' => Accommodation::where('user_id', $userId)->count(),
            'verified_accommodations' => Accommodation::where('user_id', $userId)->where('is_verified', true)->count(),
            'month_reservations' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))
                ->whereMonth('created_at', now()->month)->count(),
            'pending_reservations' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))
                ->where('status', 'pending')->count(),
            'month_revenue' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))
                ->whereMonth('created_at', now()->month)
                ->whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'total_revenue' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))
                ->whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'average_rating' => Review::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))->avg('rating') ?? 0,
            'total_reviews' => Review::whereHas('accommodation', fn($q) => $q->where('user_id', $userId))->count(),
        ];
        // Réservations récentes
        $recentReservations = Reservation::whereHas('accommodation', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();
        
        // Top hébergements
        $topAccommodations = Accommodation::where('user_id', $userId)
            ->with(['images'])
            ->withCount(['reservations', 'reviews'])
            ->withAvg('reviews', 'rating')
            ->orderBy('reservations_count', 'desc')
            ->take(5)
            ->get();

        return view('owner.accommodations.index', compact('accommodations', 'stats', 'recentReservations', 'topAccommodations'));
    }

    /**
     * Formulaire de création
     */
    public function create()
    {
        return view('owner.accommodations.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Enregistrer un nouvel hébergement
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'quartier' => 'required|string|max:100',
            'nb_rooms' => 'required|integer|min:1',
            'nb_beds' => 'required|integer|min:1',
            'nb_bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'images.*' => 'nullable|image|max:2048', // Max 2MB par image
        ]);
        $id = Auth::id();
        // Créer l'hébergement
        $accommodation = Accommodation::create([
            'user_id' => $id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'address' => $request->address,
            'quartier' => $request->quartier,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'nb_rooms' => $request->nb_rooms,
            'nb_beds' => $request->nb_beds,
            'nb_bathrooms' => $request->nb_bathrooms,
            'max_guests' => $request->max_guests,
            'amenities' => $request->amenities,
            'is_available' => true,
            'is_verified' => false, // Doit être vérifié par l'admin
        ]);
        // Gérer les images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store("accommodations/{$accommodation->id}", 'public');
                
                Image::create([
                    'accommodation_id' => $accommodation->id,
                    'path' => $path,
                    'is_primary' => $index === 0, // La première image est l'image principale
                    'order' => $index,
                ]);
            }
        }
            
        

        return redirect()->route('owner.accommodations.index')
            ->with('success', 'Votre hébergement a été créé et sera vérifié par un administrateur.');
    }

    /**
     * Formulaire de modification
     */
    public function edit(Accommodation $accommodation)
    {
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        $accommodation->load('images');

        return view('owner.accommodations.edit', [
            'accommodation' => $accommodation,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Mettre à jour un hébergement
     */
    public function update(Request $request, Accommodation $accommodation)
    {
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'quartier' => 'required|string|max:100',
            'nb_rooms' => 'required|integer|min:1',
            'nb_beds' => 'required|integer|min:1',
            'nb_bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'is_available' => 'boolean',
            'new_images.*' => 'nullable|image|max:2048',
        ]);

        $accommodation->update([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'description' => $request->description,
            'price_per_night' => $request->price_per_night,
            'address' => $request->address,
            'quartier' => $request->quartier,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'nb_rooms' => $request->nb_rooms,
            'nb_beds' => $request->nb_beds,
            'nb_bathrooms' => $request->nb_bathrooms,
            'max_guests' => $request->max_guests,
            'amenities' => $request->amenities,
            'is_available' => $request->is_available ?? true,
        ]);
        // Ajouter de nouvelles images
        if ($request->hasFile('new_images')) {
            $lastOrder = $accommodation->images()->max('order') ?? -1;
            
            foreach ($request->file('new_images') as $index => $image) {
                $path = $image->store("accommodations/{$accommodation->id}", 'public');
                
                Image::create([
                    'accommodation_id' => $accommodation->id,
                    'path' => $path,
                    'is_primary' => false,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }
            
        

        return redirect()->route('owner.accommodations.index')
            ->with('success', 'Votre hébergement a été mis à jour.');
    }

    /**
     * Supprimer un hébergement
     */
    public function destroy(Accommodation $accommodation)
    {
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de réservations en cours
        $hasActiveReservations = $accommodation->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveReservations) {
            return back()->withErrors([
                'error' => 'Impossible de supprimer cet hébergement car il a des réservations actives.'
            ]);
        }

        // Supprimer les images du stockage
        foreach ($accommodation->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $accommodation->delete();

        return redirect()->route('owner.accommodations.index')
            ->with('success', 'Votre hébergement a été supprimé.');
    }

    /**
     * Supprimer une image
     */
    public function deleteImage(Image $image)
    {
        // Vérifier que c'est bien le propriétaire
        if ($image->accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'L\'image a été supprimée.');
    }

    /**
     * Définir une image comme principale
     */
    public function setPrimaryImage(Image $image)
    {
        // Vérifier que c'est bien le propriétaire
        if ($image->accommodation->user_id !== Auth::id()) {
            abort(403);
        }

        // Retirer le statut principal de toutes les images
        $image->accommodation->images()->update(['is_primary' => false]);

        // Définir cette image comme principale
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Image principale définie.');
    }
}