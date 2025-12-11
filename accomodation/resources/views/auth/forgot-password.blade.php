@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-md w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4">
                    <i class="fas fa-key text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Mot de passe oublié ?</h1>
                <p class="text-gray-600">Pas de problème ! Entrez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            </div>
            
            <!-- Message de session -->
            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 fade-in">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('status') }}
                </div>
            @endif
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-accent"></i> Adresse email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required 
                        autofocus
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('email') border-red-500 @enderror"
                        placeholder="exemple@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Bouton -->
                <button 
                    type="submit" 
                    class="w-full btn-primary text-white py-3 rounded-lg font-bold text-lg"
                >
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer le lien
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Ou</span>
                </div>
            </div>
            
            <!-- Liens -->
            <div class="space-y-3">
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full text-center border-2 border-accent text-accent py-3 rounded-lg font-semibold hover:bg-accent hover:text-white transition"
                >
                    <i class="fas fa-arrow-left mr-2"></i> Retour à la connexion
                </a>
                
                <a 
                    href="{{ route('register') }}" 
                    class="block w-full text-center text-accent hover:text-dark transition"
                >
                    Pas encore de compte ? <strong>S'inscrire</strong>
                </a>
            </div>
        </div>
        
        <!-- Retour accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-dark transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</section>

@endsection