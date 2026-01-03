@extends('layouts.app')

@section('title', 'Mot de passe oublié')

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
                <div class="w-16 h-16 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-gray-200">
                    <i class="fas fa-key text-3xl text-primary"></i>
                </div>
                <h1 class="text-2xl font-bold text-dark mb-2">Mot de passe oublié ?</h1>
                <p class="text-gray-500 text-sm leading-relaxed">Pas de problème ! Entrez votre email et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>
            </div>
            
            <!-- Message de session -->
            @if (session('status'))
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 flex items-start gap-3">
                    <i class="fas fa-check-circle mt-0.5 text-green-500"></i>
                    <p class="text-sm font-medium">{{ session('status') }}</p>
                </div>
            @endif
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Adresse email
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required 
                            autofocus
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="exemple@email.com"
                        >
                    </div>
                    @error('email')
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
                    <i class="fas fa-paper-plane mr-2"></i> Envoyer le lien
                </button>
            </form>
            
            <!-- Divider -->
            <div class="relative my-8">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white/50 backdrop-blur text-gray-500 font-medium">Ou</span>
                </div>
            </div>
            
            <!-- Liens -->
            <div class="space-y-3">
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full py-3 border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 hover:text-dark transition text-center"
                >
                    <i class="fas fa-arrow-left mr-2 text-sm"></i> Retour à la connexion
                </a>
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