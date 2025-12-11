@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-2xl w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4">
                    <i class="fas fa-user-plus text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Créer un compte</h1>
                <p class="text-gray-600">Rejoignez notre communauté</p>
            </div>
            
            <!-- Choix du type de compte -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div 
                    id="user-card"
                    onclick="selectRole('user')" 
                    class="role-card border-2 border-gray-300 rounded-xl p-6 cursor-pointer hover:border-accent transition text-center"
                >
                    <div class="text-4xl mb-3">
                        <i class="fas fa-user text-accent"></i>
                    </div>
                    <h3 class="font-bold text-dark mb-2">Je cherche un hébergement</h3>
                    <p class="text-sm text-gray-600">Pour réserver et trouver des logements</p>
                </div>
                
                <div 
                    id="owner-card"
                    onclick="selectRole('owner')" 
                    class="role-card border-2 border-gray-300 rounded-xl p-6 cursor-pointer hover:border-accent transition text-center"
                >
                    <div class="text-4xl mb-3">
                        <i class="fas fa-building text-accent"></i>
                    </div>
                    <h3 class="font-bold text-dark mb-2">Je propose un hébergement</h3>
                    <p class="text-sm text-gray-600">Pour publier et gérer mes offres</p>
                </div>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf
                
                <input type="hidden" name="role" id="role-input" value="user">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nom complet -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-user mr-1 text-accent"></i> Nom complet <span class="text-red-500">*</span>
                        </label>
                        <input 
                            id="name" 
                            type="text" 
                            name="name" 
                            value="{{ old('name') }}"
                            required 
                            autofocus
                            autocomplete="name"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('name') border-red-500 @enderror"
                            placeholder="Jean Dupont"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-phone mr-1 text-accent"></i> Téléphone
                        </label>
                        <input 
                            id="phone" 
                            type="tel" 
                            name="phone" 
                            value="{{ old('phone') }}"
                            autocomplete="tel"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('phone') border-red-500 @enderror"
                            placeholder="+237 6XX XX XX XX"
                        >
                        @error('phone')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-accent"></i> Adresse email <span class="text-red-500">*</span>
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email') }}"
                        required
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1 text-accent"></i> Mot de passe <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('password') border-red-500 @enderror"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password', 'toggle-icon-1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition"
                            >
                                <i class="fas fa-eye" id="toggle-icon-1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
                    </div>
                    
                    <!-- Confirmer mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-lock mr-1 text-accent"></i> Confirmer <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                required
                                autocomplete="new-password"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation', 'toggle-icon-2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition"
                            >
                                <i class="fas fa-eye" id="toggle-icon-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Bio (pour propriétaires) -->
                <div id="bio-field" class="hidden">
                    <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-info-circle mr-1 text-accent"></i> Présentez votre établissement
                    </label>
                    <textarea 
                        id="bio" 
                        name="bio" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition"
                        placeholder="Ex: Hôtel moderne au centre-ville..."
                    >{{ old('bio') }}</textarea>
                </div>
                
                <!-- Conditions générales -->
                <div class="flex items-start">
                    <input 
                        type="checkbox" 
                        name="terms" 
                        id="terms"
                        required
                        class="w-4 h-4 mt-1 text-accent border-gray-300 rounded focus:ring-accent"
                    >
                    <label for="terms" class="ml-2 text-sm text-gray-700">
                        J'accepte les <a href="#" class="text-accent hover:underline">conditions générales d'utilisation</a> 
                        et la <a href="#" class="text-accent hover:underline">politique de confidentialité</a>
                    </label>
                </div>
                
                <!-- Bouton d'inscription -->
                <button 
                    type="submit" 
                    class="w-full btn-primary text-white py-3 rounded-lg font-bold text-lg"
                >
                    <i class="fas fa-user-plus mr-2"></i> Créer mon compte
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
            
            <!-- Lien connexion -->
            <div class="text-center">
                <p class="text-gray-600 mb-4">Vous avez déjà un compte ?</p>
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full border-2 border-accent text-accent py-3 rounded-lg font-semibold hover:bg-accent hover:text-white transition"
                >
                    <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
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
    // Sélection du rôle
    function selectRole(role) {
        document.getElementById('role-input').value = role;
        
        // Styling des cards
        const userCard = document.getElementById('user-card');
        const ownerCard = document.getElementById('owner-card');
        const bioField = document.getElementById('bio-field');
        
        if(role === 'user') {
            userCard.classList.add('border-accent', 'bg-accent/5');
            ownerCard.classList.remove('border-accent', 'bg-accent/5');
            bioField.classList.add('hidden');
        } else {
            ownerCard.classList.add('border-accent', 'bg-accent/5');
            userCard.classList.remove('border-accent', 'bg-accent/5');
            bioField.classList.remove('hidden');
        }
    }
    
    // Toggle password visibility
    function togglePassword(inputId, iconId) {
        const passwordInput = document.getElementById(inputId);
        const toggleIcon = document.getElementById(iconId);
        
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
    
    // Sélectionner "user" par défaut
    selectRole('user');
</script>
@endpush