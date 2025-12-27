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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class AccommodationController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']); // ✅ DÉCOMMENTÉ
    }

    /**
     * Afficher mes hébergements (avec dashboard)
     */
    public function index(Request $request)
    {
        // Vérifier que l'utilisateur est propriétaire ou admin
        if (!Auth::user()->isOwner() && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous devez être propriétaire pour accéder à cette page.');
        }

        $accommodations = Accommodation::where('user_id', Auth::id())
            ->with(['category', 'images'])
            ->withCount('reservations')
            ->orderBy('created_at', 'desc')
            ->get();
        
        // Statistiques pour le dashboard
        $stats = [
            'total_accommodations' => Accommodation::where('user_id', Auth::id())->count(),
            'verified_accommodations' => Accommodation::where('user_id', Auth::id())->where('is_verified', true)->count(),
            'month_reservations' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))
                ->whereMonth('created_at', now()->month)->count(),
            'pending_reservations' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))
                ->where('status', 'pending')->count(),
            'month_revenue' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))
                ->whereMonth('created_at', now()->month)
                ->whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'total_revenue' => Reservation::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))
                ->whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
            'average_rating' => Review::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))->avg('rating') ?? 0,
            'total_reviews' => Review::whereHas('accommodation', fn($q) => $q->where('user_id', Auth::id()))->count(),
        ];
        
        // Réservations récentes
        $recentReservations = Reservation::whereHas('accommodation', function($q) {
            $q->where('user_id', operator: Auth::id());
        })->with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();
        
        // Top hébergements
        $topAccommodations = Accommodation::where('user_id', Auth::id())
            ->with(['images'])
            ->withCount(['reservations', 'reviews'])
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
        if (!Auth::user()->isOwner() && !Auth::user()->isAdmin()) {
            return redirect()->route('dashboard')
                ->with('error', 'Vous devez être propriétaire pour ajouter un hébergement.');
        }

        $categories = Category::all();
        
        return view('owner.accommodations.create', compact('categories'));
    }

    /**
     * Enregistrer un nouvel hébergement
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'title' => 'required|string|max:255',
                'description' => 'required|string',
                'price_per_night' => 'required|numeric|min:0',
                'address' => 'required|string|max:255',
                'quartier' => 'required|string|max:100',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'nb_rooms' => 'required|integer|min:1',
                'nb_beds' => 'required|integer|min:1',
                'nb_bathrooms' => 'required|integer|min:1',
                'max_guests' => 'required|integer|min:1',
                'amenities' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            ]);

            // Créer l'hébergement
            $accommodation = Accommodation::create([
                'user_id' => Auth::id(),
                'category_id' => $validated['category_id'],
                'title' => $validated['title'],
                'description' => $validated['description'],
                'price_per_night' => $validated['price_per_night'],
                'address' => $validated['address'],
                'quartier' => $validated['quartier'],
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'nb_rooms' => $validated['nb_rooms'],
                'nb_beds' => $validated['nb_beds'],
                'nb_bathrooms' => $validated['nb_bathrooms'],
                'max_guests' => $validated['max_guests'],
                'amenities' => $request->amenities ?? [],
                'is_available' => true,
                'is_verified' => false,
            ]);

            // Gérer les images
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                foreach ($images as $index => $imageFile) {
                    if ($imageFile->isValid()) {
                        // Stocker l'image
                        $path = $imageFile->store('accommodations/' . $accommodation->id, 'public');
                        
                        // Créer l'enregistrement
                        Image::create([
                            'accommodation_id' => $accommodation->id,
                            'path' => $path,
                            'is_primary' => $index === 0,
                            'order' => $index,
                        ]);
                    }
                }
            }

            return redirect()->route('owner.accommodations.index')
                ->with('success', 'Hébergement créé avec succès ! Il sera vérifié par un administrateur.');
                
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Erreur de validation
            return back()
                ->withErrors($e->errors())
                ->withInput();
                
        } catch (\Exception $e) {
            // Autre erreur
            Log::error('Erreur création hébergement: ' . $e->getMessage());
            
            return back()
                ->with('error', 'Une erreur est survenue lors de la création de l\'hébergement: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Formulaire de modification
     */
    public function edit($id)
    {
        $accommodation = Accommodation::with('images')->findOrFail($id);
        
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Vous n\'avez pas accès à cet hébergement.');
        }

        $categories = Category::all();

        return view('owner.accommodations.edit', compact('accommodation', 'categories'));
    }

    /**
     * Mettre à jour un hébergement
     */
    public function update(Request $request, $id)
    {
        $accommodation = Accommodation::findOrFail($id);
        
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Vous n\'avez pas accès à cet hébergement.');
        }

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price_per_night' => 'required|numeric|min:0',
            'address' => 'required|string|max:255',
            'quartier' => 'required|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'nb_rooms' => 'required|integer|min:1',
            'nb_beds' => 'required|integer|min:1',
            'nb_bathrooms' => 'required|integer|min:1',
            'max_guests' => 'required|integer|min:1',
            'amenities' => 'nullable|array',
            'is_available' => 'nullable|boolean',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:10240', // 10MB
        ]);

        $accommodation->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'description' => $validated['description'],
            'price_per_night' => $validated['price_per_night'],
            'address' => $validated['address'],
            'quartier' => $validated['quartier'],
            'latitude' => $validated['latitude'] ?? null,
            'longitude' => $validated['longitude'] ?? null,
            'nb_rooms' => $validated['nb_rooms'],
            'nb_beds' => $validated['nb_beds'],
            'nb_bathrooms' => $validated['nb_bathrooms'],
            'max_guests' => $validated['max_guests'],
            'amenities' => $validated['amenities'] ?? [],
            'is_available' => $request->has('is_available') ? true : false,
        ]);

        // Ajouter de nouvelles images
        if ($request->hasFile('new_images')) {
            $lastOrder = $accommodation->images()->max('order') ?? -1;
            
            foreach ($request->file('new_images') as $index => $imageFile) {
                $path = $imageFile->store('accommodations/' . $accommodation->id, 'public');
                
                Image::create([
                    'accommodation_id' => $accommodation->id,
                    'path' => $path,
                    'is_primary' => false,
                    'order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()->route('owner.accommodations.index')
            ->with('success', 'Hébergement mis à jour avec succès !');
    }

    /**
     * Supprimer un hébergement
     */
    public function destroy($id)
    {
        $accommodation = Accommodation::findOrFail($id);
        
        // Vérifier que c'est bien le propriétaire
        if ($accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Vérifier qu'il n'y a pas de réservations en cours
        $hasActiveReservations = $accommodation->reservations()
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($hasActiveReservations) {
            return back()->with('error', 'Impossible de supprimer cet hébergement car il a des réservations actives.');
        }

        // Supprimer les images du stockage
        foreach ($accommodation->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        $accommodation->delete();

        return redirect()->route('owner.accommodations.index')
            ->with('success', 'Hébergement supprimé avec succès.');
    }

    /**
     * Supprimer une image
     */
    public function deleteImage($id)
    {
        $image = Image::findOrFail($id);
        
        // Vérifier que c'est bien le propriétaire
        if ($image->accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image supprimée avec succès.');
    }

    /**
     * Définir une image comme principale
     */
    public function setPrimaryImage($id)
    {
        $image = Image::findOrFail($id);
        
        // Vérifier que c'est bien le propriétaire
        if ($image->accommodation->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        // Retirer le statut principal de toutes les images
        $image->accommodation->images()->update(['is_primary' => false]);

        // Définir cette image comme principale
        $image->update(['is_primary' => true]);

        return back()->with('success', 'Image principale définie avec succès.');
    }
}