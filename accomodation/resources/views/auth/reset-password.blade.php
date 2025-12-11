@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-md w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4">
                    <i class="fas fa-lock-open text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Nouveau mot de passe</h1>
                <p class="text-gray-600">Choisissez un nouveau mot de passe sécurisé</p>
            </div>
            
            <!-- Formulaire -->
            <form method="POST" action="{{ route('password.store') }}" class="space-y-6">
                @csrf
                
                <!-- Token de réinitialisation -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">
                
                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-1 text-accent"></i> Adresse email
                    </label>
                    <input 
                        id="email" 
                        type="email" 
                        name="email" 
                        value="{{ old('email', $request->email) }}"
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
                
                <!-- Nouveau mot de passe -->
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-1 text-accent"></i> Nouveau mot de passe
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
                        <i class="fas fa-lock mr-1 text-accent"></i> Confirmer le mot de passe
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
                
                <!-- Indicateur de force du mot de passe -->
                <div id="password-strength" class="hidden">
                    <div class="flex items-center gap-2 mb-2">
                        <div class="flex-1 h-2 bg-gray-200 rounded">
                            <div id="strength-bar" class="h-2 rounded transition-all duration-300"></div>
                        </div>
                        <span id="strength-text" class="text-sm font-semibold"></span>
                    </div>
                </div>
                
                <!-- Bouton -->
                <button 
                    type="submit" 
                    class="w-full btn-primary text-white py-3 rounded-lg font-bold text-lg"
                >
                    <i class="fas fa-check-circle mr-2"></i> Réinitialiser le mot de passe
                </button>
            </form>
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
        
        strengthBar.className = `h-2 rounded transition-all duration-300 ${colors[strength]}`;
        strengthBar.style.width = `${(strength + 1) * 20}%`;
        strengthText.textContent = texts[strength];
        strengthText.className = `text-sm font-semibold ${textColors[strength]}`;
    });
</script>
@endpush