@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-10 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-10 w-80 h-80 bg-white/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row items-center gap-8">
            <div class="relative group">
                <div class="w-24 h-24 rounded-full border-4 border-white/30 bg-white/10 backdrop-blur-md flex items-center justify-center text-white text-4xl font-bold shadow-2xl relative overflow-hidden group-hover:scale-105 transition-transform duration-300">
                    @if(auth()->user()->avatar)
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="w-full h-full object-cover">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <!-- Badge role -->
                <div class="absolute -bottom-2 left-1/2 -translate-x-1/2 bg-white text-primary text-xs font-bold px-3 py-1 rounded-full shadow-lg border border-primary/10 whitespace-nowrap">
                    @if(auth()->user()->role === 'admin')
                        Administrateur
                    @elseif(auth()->user()->role === 'owner')
                        Propriétaire
                    @else
                        Utilisateur
                    @endif
                </div>
            </div>
            
            <div class="text-center md:text-left animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-2 tracking-tight">
                    {{ auth()->user()->name }}
                </h1>
                <p class="text-white/80 text-lg flex items-center justify-center md:justify-start gap-2">
                    <i class="fas fa-envelope opacity-70"></i> {{ auth()->user()->email }}
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/90 backdrop-blur-xl p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar justify-center md:justify-start">
            <a href="#informations" class="px-6 py-3 rounded-xl bg-primary text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-primary/30 transition-all hover:scale-105">
                <i class="fas fa-user-circle"></i> Informations
            </a>
            <a href="#securite" class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-lock"></i> Sécurité
            </a>
            <a href="#preferences" class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-cog"></i> Préférences
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="pb-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto space-y-8">
            
            <!-- Informations personnelles -->
            <div id="informations" class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in scroll-mt-32">
                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold shadow-inner">
                        <i class="fas fa-user-edit"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-dark">Informations personnelles</h2>
                        <p class="text-gray-500 text-sm">Mettez à jour vos coordonnées et votre profil public</p>
                    </div>
                </div>
                
                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                    @csrf
                    @method('PATCH')
                    
                    <!-- Avatar -->
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 flex flex-col md:flex-row items-center gap-8 group hover:border-primary/20 transition-colors">
                        <div class="relative shrink-0">
                            <div class="w-32 h-32 rounded-full overflow-hidden border-4 border-white shadow-lg bg-gray-200" id="avatar-container">
                                @if(auth()->user()->avatar)
                                    <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                         alt="Avatar"
                                         id="avatar-preview"
                                         class="w-full h-full object-cover">
                                @else
                                    <div id="avatar-placeholder" class="w-full h-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white text-5xl font-bold">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <img src="" id="avatar-preview" class="w-full h-full object-cover hidden">
                                @endif
                            </div>
                            
                            <label for="avatar" class="absolute bottom-0 right-0 w-10 h-10 bg-white text-primary rounded-full shadow-lg flex items-center justify-center cursor-pointer hover:bg-primary hover:text-white transition-all hover:scale-110 border border-gray-100">
                                <i class="fas fa-camera"></i>
                                <input type="file" id="avatar" name="avatar" accept="image/*" class="hidden" onchange="previewAvatar(this)">
                            </label>
                        </div>
                        
                        <div class="text-center md:text-left flex-1">
                            <h3 class="font-bold text-dark text-lg mb-1">Photo de profil</h3>
                            <p class="text-sm text-gray-500 mb-4 leading-relaxed">Cette photo sera visible par les autres utilisateurs. <br>Formats acceptés : JPG, PNG (Max 2MB)</p>
                            @if(auth()->user()->avatar)
                                <button type="button" onclick="removeAvatar()" class="text-red-500 text-sm font-bold hover:text-red-700 bg-red-50 px-4 py-2 rounded-lg transition hover:bg-red-100 inline-flex items-center gap-2">
                                    <i class="fas fa-trash-alt"></i> Supprimer la photo
                                </button>
                            @endif
                            <input type="hidden" name="remove_avatar" id="remove_avatar_input" value="0">
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nom -->
                        <div class="group">
                            <label for="name" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Nom complet <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="name"
                                    name="name" 
                                    value="{{ old('name', auth()->user()->name) }}"
                                    required
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-dark placeholder-gray-400 @error('name') border-red-500 @enderror"
                                >
                                <i class="fas fa-user absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Email -->
                        <div class="group">
                            <label for="email" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="email" 
                                    id="email"
                                    name="email" 
                                    value="{{ old('email', auth()->user()->email) }}"
                                    required
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium text-gray-700 @error('email') border-red-500 @enderror"
                                >
                                <i class="fas fa-envelope absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Téléphone -->
                        <div class="group">
                            <label for="phone" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Téléphone
                            </label>
                            <div class="relative">
                                <input 
                                    type="tel" 
                                    id="phone"
                                    name="phone" 
                                    value="{{ old('phone', auth()->user()->phone) }}"
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium text-gray-700 @error('phone') border-red-500 @enderror"
                                    placeholder="+237 6XX XX XX XX"
                                >
                                <i class="fas fa-phone absolute right-5 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            </div>
                            @error('phone')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Type de compte -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Type de compte
                            </label>
                            <div class="px-5 py-4 bg-gray-100/50 border border-gray-200 rounded-xl flex items-center gap-3 text-gray-600">
                                @if(auth()->user()->role === 'admin')
                                    <div class="w-8 h-8 rounded-lg bg-red-100 items-center justify-center flex text-red-600">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <span class="font-bold">Administrateur</span>
                                @elseif(auth()->user()->role === 'owner')
                                    <div class="w-8 h-8 rounded-lg bg-purple-100 items-center justify-center flex text-purple-600">
                                        <i class="fas fa-building"></i>
                                    </div>
                                    <span class="font-bold">Propriétaire</span>
                                @else
                                    <div class="w-8 h-8 rounded-lg bg-blue-100 items-center justify-center flex text-blue-600">
                                        <i class="fas fa-user"></i>
                                    </div>
                                    <span class="font-bold">Utilisateur</span>
                                @endif
                                <span class="ml-auto text-xs bg-gray-200 text-gray-600 px-2 py-1 rounded font-mono">Lecture seule</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Bio (pour propriétaires) -->
                    @if(auth()->user()->isOwner())
                        <div class="group">
                            <label for="bio" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Biographie / Présentation
                            </label>
                            <textarea 
                                id="bio"
                                name="bio" 
                                rows="4"
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium text-gray-700 placeholder-gray-400 min-h-[120px] resize-y @error('bio') border-red-500 @enderror"
                                placeholder="Présentez votre établissement, votre expérience et ce que les voyageurs peuvent attendre..."
                            >{{ old('bio', auth()->user()->bio) }}</textarea>
                            @error('bio')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    @endif
                    
                    <!-- Boutons -->
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                        <button 
                            type="submit" 
                            class="flex-1 btn-primary text-white px-8 py-4 rounded-xl font-bold hover-lift shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                        <a href="{{ route('dashboard') }}" 
                           class="flex-1 px-8 py-4 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition text-center flex items-center justify-center gap-2">
                            Annuler
                        </a>
                    </div>
                </form>
            </div>
            
            <!-- Sécurité -->
            <div id="securite" class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in scroll-mt-32">
                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-600 flex items-center justify-center text-xl font-bold shadow-inner">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-dark">Sécurité</h2>
                        <p class="text-gray-500 text-sm">Gérez votre mot de passe et l'accès à votre compte</p>
                    </div>
                </div>
                
                <form action="{{ route('password.update') }}" method="POST" class="space-y-8">
                    @csrf
                    @method('PUT')
                    
                    <!-- Mot de passe actuel -->
                    <div class="group">
                        <label for="current_password" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                            Mot de passe actuel <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="password" 
                                id="current_password"
                                name="current_password" 
                                required
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-dark placeholder-gray-400 @error('current_password', 'updatePassword') border-red-500 @enderror"
                                placeholder="••••••••"
                            >
                            <button 
                                type="button" 
                                onclick="togglePassword('current_password', 'toggle-current')"
                                class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition p-1">
                                <i class="fas fa-eye" id="toggle-current"></i>
                            </button>
                        </div>
                        @error('current_password', 'updatePassword')
                            <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                <i class="fas fa-exclamation-circle"></i> {{ $message }}
                            </p>
                        @enderror
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nouveau mot de passe -->
                        <div class="group">
                            <label for="password" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Nouveau mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password"
                                    name="password" 
                                    required
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-dark placeholder-gray-400 @error('password', 'updatePassword') border-red-500 @enderror"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password', 'toggle-new')"
                                    class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition p-1">
                                    <i class="fas fa-eye" id="toggle-new"></i>
                                </button>
                            </div>
                            @error('password', 'updatePassword')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Confirmer mot de passe -->
                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                                Confirmer le mot de passe <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="password" 
                                    id="password_confirmation"
                                    name="password_confirmation" 
                                    required
                                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-dark placeholder-gray-400"
                                    placeholder="••••••••"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation', 'toggle-confirm')"
                                    class="absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-primary transition p-1">
                                    <i class="fas fa-eye" id="toggle-confirm"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Indicateur de force -->
                    <div id="password-strength" class="hidden bg-gray-50 p-4 rounded-xl border border-gray-100">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-widest">Force du mot de passe</span>
                            <span id="strength-text" class="text-xs font-bold"></span>
                        </div>
                        <div class="h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div id="strength-bar" class="h-full rounded-full transition-all duration-300 w-0"></div>
                        </div>
                        <ul class="mt-3 text-xs text-gray-500 space-y-1 pl-4 list-disc">
                            <li>Au moins 8 caractères</li>
                            <li>Au moins une majuscule et une minuscule</li>
                            <li>Au moins un chiffre ou symbole spécial</li>
                        </ul>
                    </div>
                    
                    <!-- Boutons -->
                    <div class="pt-6 border-t border-gray-100">
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto px-8 py-4 btn-secondary text-white rounded-xl font-bold hover:bg-secondary-dark hover-lift shadow-lg shadow-secondary/20 flex items-center justify-center gap-2">
                            <i class="fas fa-key"></i> Mettre à jour le mot de passe
                        </button>
                    </div>
                </form>
            </div>
            
            <!-- Préférences -->
            <div id="preferences" class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in scroll-mt-32">
                <div class="flex items-center gap-4 mb-8 pb-4 border-b border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl font-bold shadow-inner">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-dark">Préférences</h2>
                        <p class="text-gray-500 text-sm">Personnalisez votre expérience</p>
                    </div>
                </div>
                
                <div class="space-y-8">
                    <!-- Notifications -->
                    <div class="space-y-4">
                        <h3 class="font-bold text-dark flex items-center gap-2">
                            <i class="fas fa-bell text-gray-400"></i> Notifications
                        </h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-white hover:shadow-md transition border border-transparent hover:border-gray-100 group">
                                <span class="text-gray-700 font-medium group-hover:text-primary transition-colors">Recevoir les emails de réservation</span>
                                <div class="relative">
                                    <input type="checkbox" checked class="peer sr-only">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </div>
                            </label>
                            
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-white hover:shadow-md transition border border-transparent hover:border-gray-100 group">
                                <span class="text-gray-700 font-medium group-hover:text-primary transition-colors">Recevoir les newsletters</span>
                                <div class="relative">
                                    <input type="checkbox" class="peer sr-only">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                    
                    <!-- Confidentialité -->
                    <div class="space-y-4">
                        <h3 class="font-bold text-dark flex items-center gap-2">
                            <i class="fas fa-user-shield text-gray-400"></i> Confidentialité
                        </h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center justify-between p-4 bg-gray-50 rounded-xl cursor-pointer hover:bg-white hover:shadow-md transition border border-transparent hover:border-gray-100 group">
                                <span class="text-gray-700 font-medium group-hover:text-primary transition-colors">Profil visible publiquement</span>
                                <div class="relative">
                                    <input type="checkbox" checked class="peer sr-only">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Zone dangereuse -->
            <div class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-red-100 animate-fade-in scroll-mt-32 relative overflow-hidden">
                <div class="absolute inset-0 bg-red-50/30 pointer-events-none"></div>
                <div class="relative z-10">
                    <h2 class="text-2xl font-bold text-red-600 mb-4 flex items-center gap-3">
                        <i class="fas fa-exclamation-triangle"></i> Zone dangereuse
                    </h2>
                    <p class="text-gray-700 mb-6 max-w-2xl">La suppression de votre compte est irréversible. Toutes vos données personnelles, réservations et historique seront définitivement effacés.</p>
                    
                    <button 
                        onclick="openDeleteModal()"
                        class="px-6 py-3 bg-white border-2 border-red-100 text-red-600 rounded-xl hover:bg-red-50 hover:border-red-200 transition font-bold shadow-sm flex items-center gap-2">
                        <i class="fas fa-trash-alt"></i> Supprimer mon compte
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Modal suppression compte -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    
    <div class="glass-card bg-white rounded-3xl max-w-md w-full p-8 relative z-10 animate-float shadow-2xl border border-white/40">
        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-red-100 text-red-500 flex items-center justify-center text-3xl animate-pulse">
            <i class="fas fa-user-times"></i>
        </div>
        
        <h3 class="text-2xl font-bold text-dark mb-3 text-center">Supprimer votre compte ?</h3>
        <p class="text-gray-600 mb-8 text-center leading-relaxed">Cette action est <strong>irréversible</strong>. Veuillez saisir votre mot de passe pour confirmer.</p>
        
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mb-6">
                <input 
                    type="password" 
                    name="password" 
                    required
                    class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all outline-none font-bold text-center"
                    placeholder="Votre mot de passe"
                >
            </div>
            
            <div class="flex gap-4">
                <button 
                    type="button" 
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-3 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg shadow-red-500/30 transition hover-lift">
                    Confirmer
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
                const placeholder = document.getElementById('avatar-placeholder');
                
                if(preview && placeholder) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    
    // Remove avatar
    function removeAvatar() {
        if(confirm('Voulez-vous vraiment supprimer votre photo de profil ?')) {
            document.getElementById('remove_avatar_input').value = '1';
            const preview = document.getElementById('avatar-preview');
            const placeholder = document.getElementById('avatar-placeholder');
            
            if(preview && placeholder) {
                preview.classList.add('hidden');
                placeholder.classList.remove('hidden');
            }
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
            
            const index = Math.min(strength, 4);
            
            strengthBar.className = `h-full rounded-full transition-all duration-300 ${colors[index]}`;
            strengthBar.style.width = `${(strength + 1) * 20}%`;
            strengthText.textContent = texts[index];
            strengthText.className = `text-xs font-bold ${textColors[index]}`;
        });
    }
    
    // Modal suppression
    function openDeleteModal() {
        document.getElementById('delete-modal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush