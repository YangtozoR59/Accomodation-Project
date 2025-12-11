<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Accommodation;
use App\Models\Reservation;
use App\Models\Review;
use App\Models\User;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    //
     public function index()
    {
        // // Vérifier que c'est un admin
        // if (!!FacadesAuth::user()->isAdmin) {
        //     abort(403);
        // }

        $stats = [
            'total_users' => User::count(),
            'total_owners' => User::where('role', 'owner')->count(),
            'total_accommodations' => Accommodation::count(),
            'pending_accommodations' => Accommodation::where('is_verified', false)->count(),
            'total_reservations' => Reservation::count(),
            'pending_reservations' => Reservation::where('status', 'pending')->count(),
            'total_reviews' => Review::count(),
            'pending_reviews' => Review::where('is_verified', false)->count(),
            'total_revenue' => Reservation::whereIn('status', ['confirmed', 'completed'])->sum('total_price'),
        ];

        // Dernières activités
        $recentAccommodations = Accommodation::with(['owner', 'category'])
            ->latest()
            ->take(5)
            ->get();

        $recentReservations = Reservation::with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();

        $recentReviews = Review::with(['user', 'accommodation'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', [
            'stats' => $stats,
            'recentAccommodations' => $recentAccommodations,
            'recentReservations' => $recentReservations,
            'recentReviews' => $recentReviews,
        ]);
    }

    /**
     * Gérer les hébergements
     */
    public function accommodations(Request $request)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $query = Accommodation::with(['owner', 'category', 'images']);

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_verified', false);
            } elseif ($request->status === 'verified') {
                $query->where('is_verified', true);
            }
        }

        $accommodations = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.accommodations.index', [
            'accommodations' => $accommodations,
            'filters' => $request->only(['status']),
        ]);
    }

    /**
     * Vérifier/Approuver un hébergement
     */
    public function verifyAccommodation(Accommodation $accommodation)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $accommodation->update(['is_verified' => true]);

        return back()->with('success', 'Hébergement vérifié avec succès.');
    }

    /**
     * Rejeter un hébergement
     */
    public function rejectAccommodation(Accommodation $accommodation)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $accommodation->update(['is_verified' => false, 'is_available' => false]);

        return back()->with('success', 'Hébergement rejeté.');
    }

    /**
     * Gérer les avis
     */
    public function reviews(Request $request)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $query = Review::with(['user', 'accommodation']);

        if ($request->filled('status')) {
            if ($request->status === 'pending') {
                $query->where('is_verified', false);
            } elseif ($request->status === 'verified') {
                $query->where('is_verified', true);
            }
        }

        $reviews = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.reviews.index', [
            'reviews' => $reviews,
            'filters' => $request->only(['status']),
        ]);
    }

    /**
     * Vérifier un avis
     */
    public function verifyReview(Review $review)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $review->update(['is_verified' => true]);

        return back()->with('success', 'Avis vérifié avec succès.');
    }

    /**
     * Gérer les utilisateurs
     */
    public function users(Request $request)
    {
        if (!!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->withCount(['accommodations', 'reservations'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.users.index', [
            'users' => $users,
            'filters' => $request->only(['role']),
        ]);
    }

    /**
     * Activer/Désactiver un utilisateur
     */
    public function toggleUserStatus(User $user)
    {
        if (!FacadesAuth::user()->isAdmin) {
            abort(403);
        }

        $user->update(['is_active' => !$user->is_active]);

        return back()->with('success', 'Statut de l\'utilisateur mis à jour.');
    }
}
