@extends('layouts.app')

@section('title', 'Inscription')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 relative overflow-hidden">
    
    <!-- Formes décoratives en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 right-10 w-96 h-96 bg-secondary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 left-20 w-80 h-80 bg-primary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[600px] h-[600px] bg-white/40 rounded-full blur-3xl animate-pulse-slow"></div>
    </div>
    
    <div class="max-w-3xl w-full relative z-10">
        
        <!-- Card avec glassmorphism -->
        <div class="glass-card bg-white/80 backdrop-blur-xl rounded-3xl p-8 md:p-10 animate-scale-in border border-white/50 shadow-2xl">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-secondary to-primary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-secondary/20">
                    <i class="fas fa-user-plus text-3xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Créer un compte</h1>
                <p class="text-gray-500">Rejoignez notre communauté dès aujourd'hui</p>
            </div>
            
            <!-- Choix du type de compte -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div 
                    id="user-card"
                    onclick="selectRole('user')" 
                    class="role-card bg-white border-2 border-transparent rounded-2xl p-6 cursor-pointer hover:shadow-lg transition-all text-center relative overflow-hidden group"
                >
                    <div class="absolute inset-0 bg-secondary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-secondary group-hover:bg-secondary group-hover:text-white transition-colors">
                            <i class="fas fa-user text-xl"></i>
                        </div>
                        <h3 class="font-bold text-dark mb-1">Voyageur</h3>
                        <p class="text-xs text-gray-500">Je cherche un hébergement</p>
                    </div>
                </div>
                
                <div 
                    id="owner-card"
                    onclick="selectRole('owner')" 
                    class="role-card bg-white border-2 border-transparent rounded-2xl p-6 cursor-pointer hover:shadow-lg transition-all text-center relative overflow-hidden group"
                >
                    <div class="absolute inset-0 bg-primary/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    <div class="relative z-10">
                        <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                            <i class="fas fa-building text-xl"></i>
                        </div>
                        <h3 class="font-bold text-dark mb-1">Hôte</h3>
                        <p class="text-xs text-gray-500">Je propose un hébergement</p>
                    </div>
                </div>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('register') }}" class="space-y-5">
                @csrf
                
                <input type="hidden" name="role" id="role-input" value="user">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Nom complet -->
                    <div>
                        <label for="name" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                            Nom complet <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                id="name" 
                                type="text" 
                                name="name" 
                                value="{{ old('name') }}"
                                required 
                                autofocus
                                autocomplete="name"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                                placeholder="Jean Dupont"
                            >
                        </div>
                        @error('name')
                            <p class="text-red-500 text-xs mt-1.5 font-medium ml-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <!-- Téléphone -->
                    <div>
                        <label for="phone" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                            Téléphone
                        </label>
                        <div class="relative">
                            <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                id="phone" 
                                type="tel" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                autocomplete="tel"
                                class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                                placeholder="+237 6XX XX XX XX"
                            >
                        </div>
                        @error('phone')
                            <p class="text-red-500 text-xs mt-1.5 font-medium ml-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Adresse email <span class="text-primary">*</span>
                    </label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            id="email" 
                            type="email" 
                            name="email" 
                            value="{{ old('email') }}"
                            required
                            autocomplete="username"
                            class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                            placeholder="exemple@email.com"
                        >
                    </div>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1.5 font-medium ml-1">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Mot de passe -->
                    <div>
                        <label for="password" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                            Mot de passe <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                id="password" 
                                type="password" 
                                name="password" 
                                required
                                autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password', 'toggle-icon-1')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition p-1"
                            >
                                <i class="fas fa-eye" id="toggle-icon-1"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1.5 font-medium ml-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-2 pl-1">Minimum 8 caractères</p>
                    </div>
                    
                    <!-- Confirmer mot de passe -->
                    <div>
                        <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                            Confirmer <span class="text-primary">*</span>
                        </label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input 
                                id="password_confirmation" 
                                type="password" 
                                name="password_confirmation" 
                                required
                                autocomplete="new-password"
                                class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-secondary/20 focus:border-secondary transition-all outline-none"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('password_confirmation', 'toggle-icon-2')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition p-1"
                            >
                                <i class="fas fa-eye" id="toggle-icon-2"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Bio (pour propriétaires) -->
                <div id="bio-field" class="hidden animate-fade-in">
                    <label for="bio" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Présentez votre établissement
                    </label>
                    <div class="relative">
                        <textarea 
                            id="bio" 
                            name="bio" 
                            rows="3"
                            class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                            placeholder="Ex: Hôtel moderne au centre-ville..."
                        >{{ old('bio') }}</textarea>
                    </div>
                </div>
                
                <!-- Conditions générales -->
                <div class="flex items-start p-4 bg-gray-50 rounded-xl border border-gray-100">
                    <div class="flex items-center h-5">
                        <input 
                            type="checkbox" 
                            name="terms" 
                            id="terms"
                            required
                            class="w-4 h-4 text-secondary border-gray-300 rounded focus:ring-secondary"
                        >
                    </div>
                    <label for="terms" class="ml-3 text-sm text-gray-600 font-medium">
                        J'accepte les <a href="#" class="text-secondary hover:text-primary transition underline decoration-2 decoration-transparent hover:decoration-primary">conditions générales d'utilisation</a> 
                        et la <a href="#" class="text-secondary hover:text-primary transition underline decoration-2 decoration-transparent hover:decoration-primary">politique de confidentialité</a>
                    </label>
                </div>
                
                <!-- Bouton d'inscription -->
                <button 
                    type="submit" 
                    id="submit-btn"
                    class="btn-secondary w-full text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-secondary/30 hover:shadow-secondary/50 hover-lift mt-2"
                >
                    <i class="fas fa-user-plus mr-2"></i> Créer mon compte
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
            
            <!-- Lien connexion -->
            <div class="text-center">
                <p class="text-gray-600 mb-4 font-medium">Vous avez déjà un compte ?</p>
                <a 
                    href="{{ route('login') }}" 
                    class="block w-full py-3.5 border-2 border-dashed border-gray-300 text-gray-600 rounded-xl font-bold hover:border-primary hover:text-primary hover:bg-primary/5 transition group"
                >
                    <i class="fas fa-sign-in-alt mr-2 group-hover:translate-x-1 transition-transform"></i>
                    Se connecter
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

@push('styles')
<style>
    /* Style pour les cartes de rôle sélectionnées */
    .role-card.selected-user {
        border-color: #007A5E;
        background-color: rgb(0 122 94 / 0.05);
        box-shadow: 0 10px 30px -10px rgba(0, 122, 94, 0.2);
    }
    
    .role-card.selected-user .w-12 {
        background-color: #007A5E;
        color: white;
    }
    
    .role-card.selected-owner {
        border-color: #CE1126;
        background-color: rgb(206 17 38 / 0.05);
        box-shadow: 0 10px 30px -10px rgba(206, 17, 38, 0.2);
    }
    
    .role-card.selected-owner .w-12 {
        background-color: #CE1126;
        color: white;
    }
</style>
@endpush

@push('scripts')
<script>
    // Sélection du rôle
    function selectRole(role) {
        document.getElementById('role-input').value = role;
        
        // Styling des cards
        const userCard = document.getElementById('user-card');
        const ownerCard = document.getElementById('owner-card');
        const bioField = document.getElementById('bio-field');
        const submitBtn = document.getElementById('submit-btn');
        
        // Retirer la classe selected de toutes les cartes
        userCard.classList.remove('selected-user');
        ownerCard.classList.remove('selected-owner');
        
        if(role === 'user') {
            userCard.classList.add('selected-user');
            bioField.classList.add('hidden');
            bioField.classList.remove('animate-fade-in');
            
            // Changer le style du bouton
            submitBtn.classList.remove('btn-primary', 'shadow-primary/30');
            submitBtn.classList.add('btn-secondary', 'shadow-secondary/30');
        } else {
            ownerCard.classList.add('selected-owner');
            bioField.classList.remove('hidden');
            bioField.classList.add('animate-fade-in');
            
            // Changer le style du bouton
            submitBtn.classList.remove('btn-secondary', 'shadow-secondary/30');
            submitBtn.classList.add('btn-primary', 'shadow-primary/30');
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
    
    // Sélectionner "user" par défaut au chargement
    document.addEventListener('DOMContentLoaded', function() {
        selectRole('user');
    });
</script>
@endpush