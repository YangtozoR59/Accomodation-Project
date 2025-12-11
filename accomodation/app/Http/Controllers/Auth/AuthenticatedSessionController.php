<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Afficher le formulaire de connexion
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Traiter la tentative de connexion
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Vérifier si l'utilisateur existe et est actif
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Vérifier si l'utilisateur est actif
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => __('Votre compte a été désactivé. Veuillez contacter l\'administrateur.'),
                ]);
            }

            $request->session()->regenerate();

            // Redirection selon le rôle
            return $this->redirectBasedOnRole($user);
        }

        throw ValidationException::withMessages([
            'email' => __('Ces identifiants ne correspondent pas à nos enregistrements.'),
        ]);
    }

    /**
     * Rediriger l'utilisateur selon son rôle
     */
    protected function redirectBasedOnRole($user)
    {
        return match($user->role) {
            'admin' => redirect()->intended(route('admin.dashboard')),
            'owner' => redirect()->intended(route('owner.accommodations.index')),
            default => redirect()->intended(route('dashboard')),
        };
    }

    /**
     * Déconnecter l'utilisateur
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}