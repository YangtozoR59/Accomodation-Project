@extends('layouts.app')

@section('title', 'Confirmer le mot de passe')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-md w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4">
                    <i class="fas fa-shield-alt text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Zone sécurisée</h1>
                <p class="text-gray-600">
                    Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
                </p>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
                @csrf
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-accent"></i> Mot de passe
                    </label>
                    <div class="relative">
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            autofocus
                            autocomplete="current-password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('password') border-red-500 @enderror"
                            placeholder="••••••••"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition"
                        >
                            <i class="fas fa-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
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
                    <i class="fas fa-check-circle mr-2"></i> Confirmer
                </button>
            </form>
            
            <!-- Info sécurité -->
            <div class="mt-6 p-4 bg-amber-50 rounded-lg border border-amber-200">
                <div class="flex items-start gap-3">
                    <i class="fas fa-exclamation-triangle text-amber-500 text-xl mt-1"></i>
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold mb-1">Pourquoi cette étape ?</p>
                        <p class="text-gray-600">
                            Pour votre sécurité, nous devons vérifier votre identité avant d'accéder à cette section sensible.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Retour -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-dark transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggle-icon');
        
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.classList.remove('fa-eye');
            toggleIcon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            toggleIcon.classList.remove('fa-eye-slash');
            toggleIcon.classList.add('fa-eye');
        }
    }
</script>
@endpush