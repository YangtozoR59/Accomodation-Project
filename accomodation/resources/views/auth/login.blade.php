@extends('layouts.app')

@section('title', 'Connexion')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-md w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4">
                    <i class="fas fa-home text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Bon retour !</h1>
                <p class="text-gray-600">Connectez-vous pour continuer</p>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
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
                        autocomplete="username"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('email') border-red-500 @enderror"
                        placeholder="exemple@email.com"
                    >
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
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
                
                <!-- Se souvenir de moi et mot de passe oublié -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input 
                            type="checkbox" 
                            name="remember" 
                            class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent"
                        >
                        <span class="ml-2 text-sm text-gray-700">Se souvenir de moi</span>
                    </label>
                    
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-accent hover:text-dark transition">
                            Mot de passe oublié ?
                        </a>
                    @endif
                </div>
                
                <!-- Bouton de connexion -->
                <button 
                    type="submit" 
                    class="w-full btn-primary text-white py-3 rounded-lg font-bold text-lg"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
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
            
            <!-- Lien inscription -->
            <div class="text-center">
                <p class="text-gray-600 mb-4">Vous n'avez pas de compte ?</p>
                <a 
                    href="{{ route('register') }}" 
                    class="block w-full border-2 border-accent text-accent py-3 rounded-lg font-semibold hover:bg-accent hover:text-white transition"
                >
                    <i class="fas fa-user-plus mr-2"></i> Créer un compte
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