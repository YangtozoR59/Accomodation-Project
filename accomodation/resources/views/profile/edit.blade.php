@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-accent py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center gap-6">
            <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center text-accent text-3xl font-bold shadow-lg">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    Mon profil
                </h1>
                <p class="text-white/90">Gérez vos informations personnelles</p>
            </div>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="#informations" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-user mr-2"></i> Informations
            </a>
            <a href="#securite" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-lock mr-2"></i> Sécurité
            </a>
            <a href="#preferences" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-cog mr-2"></i> Préférences
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-8">
            
            <!-- Informations personnelles -->
            <div id="informations" class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-user-circle text-accent mr-2"></i> Informations personnelles
                </h2>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Avatar -->
                    <div class="flex items-center gap-6 pb-6 border-b">
                        <div class="relative">
                            @if(auth()->user()->avatar)
                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                     alt="Avatar"
                                     id="avatar-preview"
                                     class="w-24 h-24 rounded-full object-cover border-4 border-accent">
                            @else
                                <div id="avatar-preview" class="w-24 h-24 bg-accent rounded-full flex items-center justify-center text-white text-4xl font-bold border-4 border-accent">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                            @endif
                            
                            <label for="avatar" class="absolute bottom-0 right-0 bg-accent text-white p-2 rounded-full cursor-pointer hover:bg-dark transition">
                                <i class="fas fa-camera text-sm"></i>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                            </label>
                        </div>
                        
                        <div>
                            <h3 class="font-bold text-dark text-lg">Photo de profil</h3>
                            <p class="text-sm text-gray-600 mb-2">JPG, PNG ou JPEG (Max 2MB)</p>
                            @if(auth()->user()->avatar)
                                <button type="button" onclick="removeAvatar()" class="text-red-500 text-sm hover:underline">
                                    <i class="fas fa-trash mr-1"></i> Supprimer la photo
                                </button>
                            @endif
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="name"
                                name="name" 
                                value="{{ old('name', auth()->user()->name) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('name') border-red-500 @enderror"
                            >
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="email" 
                                id="email"
                                name="email" 
                                value="{{ old('email', auth()->user()->email) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('email') border-red-500 @enderror"
                            >
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Téléphone -->
                        <div>
                            <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                Téléphone
                            </label>
                            <input 
                                type="tel" 
                                id="phone"
                                name="phone" 
                                value="{{ old('phone', auth()->user()->phone) }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('phone') border-red-500 @enderror"
                                placeholder="+237 6XX XX XX XX"
                            >
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Rôle (lecture seule) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Type de compte
                            </label>
                            <div class="px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg">
                                <span class="inline-flex items-center gap-2">
                                    @if(auth()->user()->role === 'admin')
                                        <i class="fas fa-shield-alt text-accent"></i>
                                        <span class="font-semibold text-dark">Administrateur</span>
                                    @elseif(auth()->user()->role === 'owner')
                                        <i class="fas fa-building text-accent"></i>
                                        <span class="font-semibold text-dark">Propriétaire</span>
                                    @else
                                        <i class="fas fa-user text-accent"></i>
                                        <span class="font-semibold text-dark">Utilisateur</span>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bio (pour propriétaires) -->
                    @if(auth()->user()->isOwner())
                        <div>
                            <label for="bio" class="block text-sm font-semibold text-gray-700 mb-2">
                                Biographie / Présentation
                            </label>
                            <textarea 
                                id="bio"
                                name="bio" 
                                rows="4"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('bio') border-red-500 @enderror"
                                placeholder="Présentez votre établissement..."
                            >{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endif
                    
                    <!-- Boutons -->
                    <div class="flex gap-4 pt-4">
                        <button 
                            type="submit" 
                            class="flex-1 md:flex-initial px-8 py-3 btn-primary text-white rounded-lg">
                            <i class="fas fa-save mr-2"></i> Enregistrer les modifications
                        </button>
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 md:flex-initial px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition text-center">
                            <i class="fas fa-times mr-2"></i> Annuler
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Mot de passe -->
            <div id="securite" class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-lock text-accent mr-2"></i> Sécurité et mot de passe
                </h2>
                
                <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')
                    
                    <!-- Mot de passe actuel -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mot de passe actuel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="current_password"
                                name="current_password" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('current_password', 'updatePassword') border-red-500 @enderror"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('current_password', 'toggle-current')"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition">
                                <i class="fas fa-eye" id="toggle-current"></i>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-sm mt-1">
                                <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nouveau mot de passe -->
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('password', 'updatePassword') border-red-500 @enderror"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password', 'toggle-new')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition">
                                    <i class="fas fa-eye" id="toggle-new"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Minimum 8 caractères</p>
                        </div>
                        
                        <!-- Confirmer mot de passe -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation"
                                    name="password_confirmation" 
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation', 'toggle-confirm')"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-500 hover:text-accent transition">
                                    <i class="fas fa-eye" id="toggle-confirm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Indicateur de force -->
                    <div id="password-strength" class="hidden">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded">
                                <div id="strength-bar" class="h-2 rounded transition-all duration-300"></div>
                            </div>
                            <span id="strength-text" class="text-sm font-semibold"></span>
                        </div>
                    </div>
                    
                    <!-- Info sécurité -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-shield-alt text-blue-500 text-xl mt-1"></i>
                            <div class="text-sm text-gray-700">
                                <p class="font-semibold mb-2">Conseils pour un mot de passe sécurisé :</p>
                                <ul class="list-disc list-inside space-y-1 text-gray-600">
                                    <li>Au moins 8 caractères</li>
                                    <li>Mélangez majuscules et minuscules</li>
                                    <li>Incluez des chiffres et des symboles</li>
                                    <li>N'utilisez pas d'informations personnelles</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="flex gap-4">
                        <button 
                            type="submit" 
                            class="px-8 py-3 btn-primary text-white rounded-lg">
                            <i class="fas fa-key mr-2"></i> Changer le mot de passe
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Préférences -->
            <div id="preferences" class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-cog text-accent mr-2"></i> Préférences
                </h2>
                
                <div class="space-y-6">
                    <!-- Notifications -->
                    <div class="border-b pb-6">
                        <h3 class="font-bold text-dark mb-4">
                            <i class="fas fa-bell text-accent mr-2"></i> Notifications
                        </h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-accent transition">
                                <span class="text-gray-700">Recevoir les emails de réservation</span>
                                <input type="checkbox" checked class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            </label>
                            
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-accent transition">
                                <span class="text-gray-700">Recevoir les newsletters</span>
                                <input type="checkbox" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            </label>
                            
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-accent transition">
                                <span class="text-gray-700">Recevoir les offres promotionnelles</span>
                                <input type="checkbox" class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            </label>
                        </div>
                    </div>
                    
                    <!-- Langue -->
                    <div class="border-b pb-6">
                        <h3 class="font-bold text-dark mb-4">
                            <i class="fas fa-language text-accent mr-2"></i> Langue
                        </h3>
                        
                        <select class="w-full md:w-auto px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent">
                            <option selected>Français</option>
                            <option>English</option>
                        </select>
                    </div>
                    
                    <!-- Confidentialité -->
                    <div>
                        <h3 class="font-bold text-dark mb-4">
                            <i class="fas fa-user-shield text-accent mr-2"></i> Confidentialité
                        </h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-accent transition">
                                <span class="text-gray-700">Profil visible publiquement</span>
                                <input type="checkbox" checked class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            </label>
                            
                            <label class="flex items-center justify-between p-3 border border-gray-200 rounded-lg cursor-pointer hover:border-accent transition">
                                <span class="text-gray-700">Afficher mon numéro aux propriétaires</span>
                                <input type="checkbox" checked class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent">
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Zone dangereuse -->
            <div class="bg-red-50 border-2 border-red-200 rounded-xl p-6 fade-in">
                <h2 class="text-2xl font-bold text-red-700 mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i> Zone dangereuse
                </h2>
                <p class="text-gray-700 mb-6">Une fois votre compte supprimé, toutes vos données seront définitivement effacées.</p>
                
                <button 
                    onclick="openDeleteModal()"
                    class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    <i class="fas fa-trash mr-2"></i> Supprimer mon compte
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Modal suppression compte -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 fade-in">
        <h3 class="text-2xl font-bold text-dark mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Supprimer le compte
        </h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer votre compte ? Cette action est irréversible et toutes vos données seront perdues.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Confirmez avec votre mot de passe <span class="text-red-500">*</span>
                </label>
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-red-500"
                    placeholder="Votre mot de passe"
                >
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Annuler
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Supprimer définitivement
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Preview avatar
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.innerHTML = `<img src="${e.target.result}" class="w-24 h-24 rounded-full object-cover border-4 border-accent">`;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Remove avatar
    function removeAvatar() {
        if(confirm('Supprimer votre photo de profil ?')) {
            // Implémenter la suppression
            document.getElementById('avatar-preview').innerHTML = `
                <div class="w-24 h-24 bg-accent rounded-full flex items-center justify-center text-white text-4xl font-bold border-4 border-accent">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            `;
        }
    }
    
    // Toggle password
    function togglePassword(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
    
    // Password strength
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
            if(password.length >= 8) strength++;
            if(password.length >= 12) strength++;
            if(/[a-z]/.test(password) && /[A-Z]/.test(password)) strength++;
            if(/\d/.test(password)) strength++;
            if(/[^A-Za-z0-9]/.test(password)) strength++;
            
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-blue-500', 'bg-green-500'];
            const texts = ['Très faible', 'Faible', 'Moyen', 'Fort', 'Très fort'];
            const textColors = ['text-red-500', 'text-orange-500', 'text-yellow-500', 'text-blue-500', 'text-green-500'];
            
            strengthBar.className = `h-2 rounded transition-all duration-300 ${colors[strength]}`;
            strengthBar.style.width = `${(strength + 1) * 20}%`;
            strengthText.textContent = texts[strength];
            strengthText.className = `text-sm font-semibold ${textColors[strength]}`;
        });
    }
    
    // Modal suppression
    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
    
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeDeleteModal();
    });
    
    // Smooth scroll
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if(target) {
                target.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        });
    });
</script>
@endpush