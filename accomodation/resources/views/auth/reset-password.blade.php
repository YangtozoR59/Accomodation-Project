@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

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
                    <i class="fas fa-lock-open text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-dark mb-2">Nouveau mot de passe</h1>
                <p class="text-gray-500 text-sm">Choisissez un nouveau mot de passe sécurisé pour votre compte.</p>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
                @csrf
                
                <!-- Token de réinitialisation -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
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
                            value="{{ old('email', $request->email) }}"
                            required 
                            autofocus
                            autocomplete="username"
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
                
                <!-- Nouveau mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Nouveau mot de passe
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            required
                            autocomplete="new-password"
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
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
                    
                    <!-- Indicateur de force -->
                    <div id="password-strength" class="hidden mt-3 p-2 bg-gray-50 rounded-lg border border-gray-100">
                        <div class="flex items-center gap-2 mb-1">
                            <div class="flex-1 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                <div id="strength-bar" class="h-full rounded-full transition-all duration-300 w-0 bg-red-500"></div>
                            </div>
                            <span id="strength-text" class="text-xs font-bold text-gray-500 w-16 text-right">Faible</span>
                        </div>
                    </div>
                </div>
                
                <!-- Confirmer mot de passe -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                        Confirmer le mot de passe
                    </label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            required
                            autocomplete="new-password"
                            class="w-full pl-11 pr-12 py-3 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
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
                
                <!-- Bouton -->
                <button 
                    type="submit" 
                    class="btn-primary w-full text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-primary/30 hover:shadow-primary/50 hover-lift mt-2"
                >
                    <i class="fas fa-check-circle mr-2"></i> Réinitialiser
                </button>
            </form>
            
            <!-- Lien retour login -->
            <div class="text-center mt-6">
                 <a 
                    href="{{ route('login') }}" 
                    class="text-sm font-bold text-gray-500 hover:text-primary transition"
                >
                    <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
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

@push('scripts')
<script>
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
    
    // Vérifier la force du mot de passe
    const passwordInput = document.getElementById('password');
    const strengthDiv = document.getElementById('password-strength');
    const strengthBar = document.getElementById('strength-bar');
    const strengthText = document.getElementById('strength-text');
    
    if(passwordInput) {
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            
            if(password.length === 0) {
                strengthDiv.classList.add('hidden');
                return;
            }
            
            strengthDiv.classList.remove('hidden');
            
            let strength = 0;
            
            // Longueur
            if(password.length >= 8) strength++;
            if(password.length >= 12) strength++;
            
            // Minuscules et majuscules
            if(/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            
            // Chiffres
            if(/\d/.test(password)) strength++;
            
            // Caractères spéciaux
            if(/[^A-Za-z0-9]/.test(password)) strength++;
            
            // Affichage
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
            const texts = ['Très faible', 'Faible', 'Moyen', 'Fort', 'Très fort'];
            const textColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-blue-500', 'text-green-500'];
            
            // Reset classes
            strengthBar.className = 'h-full rounded-full transition-all duration-300';
            strengthText.className = 'text-xs font-bold w-16 text-right';
            
            // Apply new classes
            strengthBar.classList.add(colors[Math.min(strength, 4)]);
            strengthText.classList.add(textColors[Math.min(strength, 4)]);
            
            strengthBar.style.width = `${(Math.min(strength, 4) + 1) * 20}%`;
            strengthText.textContent = texts[Math.min(strength, 4)];
        });
    }
</script>
@endpush