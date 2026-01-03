@extends('layouts.app')

@section('title', 'Confirmer le mot de passe')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 relative overflow-hidden">
    
    <!-- Formes décoratives en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/40 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-md w-full relative z-10">
        
        <!-- Card avec glassmorphism -->
        <div class="glass-card bg-white/80 backdrop-blur-xl rounded-3xl p-8 md:p-10 animate-scale-in border border-white/50 shadow-2xl">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/20">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-dark mb-2">Zone sécurisée</h1>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Ceci est une zone sécurisée de l'application. Veuillez confirmer votre mot de passe avant de continuer.
                </p>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                @csrf
                
                <!-- Mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Mot de passe
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            autofocus
                            autocomplete="current-password"
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="••••••••"
                        >
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition p-1"
                        >
                            <i class="fas fa-eye" id="toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1.5 font-medium ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Bouton -->
                <button 
                    type="submit" 
                    class="btn-primary w-full text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-primary/30 hover:shadow-primary/50 hover-lift mt-2"
                >
                    <i class="fas fa-check-circle mr-2"></i> Confirmer
                </button>
            </form>
            
            <!-- Info sécurité -->
            <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div class="flex items-start gap-3">
                    <div class="bg-white p-2 rounded-lg shadow-sm text-secondary">
                        <i class="fas fa-lock text-lg"></i>
                    </div>
                    <div class="text-xs text-gray-500 pt-1">
                        <p class="font-bold text-gray-700 mb-1">Pourquoi cette étape ?</p>
                        <p>Pour votre sécurité, nous devons vérifier votre identité avant d'accéder à cette section sensible.</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Retour accueil -->
        <div class="text-center mt-8 animate-fade-in" style="animation-delay: 0.1s">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition font-medium py-2 px-4 rounded-full hover:bg-white/50">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Retour à l'accueil</span>
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