<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class OwnerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Vérifier si l'utilisateur a le rôle "owner"
        $user = Auth::user();
        
        // Adaptez cette condition selon votre structure de base de données
        // Exemple 1: Si vous avez un champ "role" dans la table users
        if ($user->role !== 'owner') {
            // Rediriger vers une page d'erreur ou le dashboard
            return redirect()->route('dashboard')->with('error', 'Accès réservé aux propriétaires.');
        }
        
        // Exemple 2: Si vous utilisez une relation many-to-many pour les rôles
        // if (!$user->roles()->where('name', 'owner')->exists()) {
        //     return redirect()->route('dashboard')->with('error', 'Accès réservé aux propriétaires.');
        // }
        
        // Exemple 3: Si vous avez une méthode isOwner() dans votre modèle User
        // if (!$user->isOwner()) {
        //     return redirect()->route('dashboard')->with('error', 'Accès réservé aux propriétaires.');
        // }

        return $next($request);
    }
}