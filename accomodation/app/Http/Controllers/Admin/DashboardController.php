<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']);
    }

    /**
     * Dashboard principal
     */
    public function index()
    {
        // Vérifier que l'utilisateur est admin
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Accès réservé aux administrateurs');
        }

        $stats = [
            'total_accommodations' => Accommodation::count(),
            'pending_accommodations' => Accommodation::where('is_verified', false)->count(),
            'verified_accommodations' => Accommodation::where('is_verified', true)->count(),
            'total_users' => User::count(),
            'total_owners' => User::where('role', 'owner')->count(),
            'active_users' => User::where('is_active', true)->count(),
            'total_reservations' => Reservation::count(),
            'month_reservations' => Reservation::whereMonth('created_at', now()->month)->count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'confirmed_reservations' => Reservation::where('status', 'confirmed')->count(),
            'completed_reservations' => Reservation::where('status', 'completed')->count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('is_verified', false)->count(),
            'verified_reviews' => Review::where('is_verified', true)->count(),
            'average_rating' => Review::avg('rating') ?? 0,
            'month_revenue' => Reservation::whereIn('status', ['confirmed', 'completed'])
                ->whereMonth('created_at', now()->month)
                ->sum('total_price'),
            'total_revenue' => Reservation::whereIn('status', ['confirmed', 'completed'])
                ->sum('total_price'),
        ];

        // Activité récente
        $recentAccommodations = Accommodation::with(['owner', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentReservations = Reservation::with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();

        $pendingReviews = Review::where('is_verified', false)
            ->with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentAccommodations', 'recentReservations', 'pendingReviews'));
    }

    /**
     * Gestion des hébergements
     */
    public function accommodations(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Accommodation::with(['owner', 'category', 'images'])
            ->withCount(['reservations', 'reviews']);

        // Filtres
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('quartier', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('status')) {
            if ($request->status == 'pending') {
                $query->where('is_verified', false);
            } elseif ($request->status == 'verified') {
                $query->where('is_verified', true);
            }
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $accommodations = $query->latest()->paginate(20);

        return view('admin.accommodations', compact('accommodations'));
    }

    /**
     * Vérifier un hébergement
     */
    public function verifyAccommodation($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $accommodation = Accommodation::findOrFail($id);
        $accommodation->update(['is_verified' => true]);

        return back()->with('success', 'Hébergement vérifié avec succès !');
    }

    /**
     * Retirer la vérification
     */
    public function unverifyAccommodation($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $accommodation = Accommodation::findOrFail($id);
        $accommodation->update(['is_verified' => false]);

        return back()->with('success', 'Vérification retirée.');
    }

    /**
     * Supprimer un hébergement (admin)
     */
    public function destroyAccommodation($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $accommodation = Accommodation::findOrFail($id);
        
        // Supprimer les images
        foreach ($accommodation->images as $image) {
            \Storage::disk('public')->delete($image->path);
        }

        $accommodation->delete();

        return back()->with('success', 'Hébergement supprimé avec succès.');
    }

    /**
     * Gestion des avis
     */
    public function reviews(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = Review::with(['user', 'accommodation']);

        if ($request->filled('status')) {
            if ($request->status == 'pending') {
                $query->where('is_verified', false);
            } elseif ($request->status == 'verified') {
                $query->where('is_verified', true);
            }
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews', compact('reviews'));
    }

    /**
     * Vérifier un avis
     */
    public function verifyReview($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $review = Review::findOrFail($id);
        $review->update(['is_verified' => true]);

        return back()->with('success', 'Avis vérifié avec succès !');
    }

    /**
     * Supprimer un avis
     */
    public function destroyReview($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $review = Review::findOrFail($id);
        $review->delete();

        return back()->with('success', 'Avis supprimé avec succès.');
    }

    /**
     * Gestion des utilisateurs
     */
    public function users(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $query = User::withCount(['accommodations', 'reservations']);

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $users = $query->latest()->paginate(20);

        return view('admin.users', compact('users'));
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleUserStatus($id)
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        $user = User::findOrFail($id);
        
        if ($user->isAdmin()) {
            return back()->with('error', 'Impossible de modifier un administrateur.');
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'Statut utilisateur mis à jour.');
    }
}