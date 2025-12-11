<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Afficher le formulaire d'inscription
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Traiter l'inscription
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['nullable', 'in:user,owner'], // Seuls user et owner peuvent s'inscrire
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role ?? 'user', // Par défaut 'user'
            'is_active' => true,
        ]);

        event(new Registered($user));

        Auth::login($user);

        // Redirection selon le rôle
        return $this->redirectBasedOnRole($user);
    }

    /**
     * Rediriger l'utilisateur selon son rôle
     */
    protected function redirectBasedOnRole($user)
    {
        return match($user->role) {
            'owner' => redirect()->route('owner.accommodations.index')
                ->with('success', 'Bienvenue ! Vous pouvez maintenant ajouter vos hébergements.'),
            default => redirect()->route('dashboard')
                ->with('success', 'Bienvenue ! Votre compte a été créé avec succès.'),
        };
    }
}