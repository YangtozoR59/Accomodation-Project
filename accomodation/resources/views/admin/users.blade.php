@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-users text-purple-400"></i> Gestion des utilisateurs
            </h1>
            <p class="text-white/80 text-lg">Gérer tous les utilisateurs de la plateforme, leurs rôles et statuts</p>
        </div>
    </div>
</section>

<!-- Navigation Admin -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/90 backdrop-blur-xl p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-building"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-star"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" 
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-gray-900/20">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-tags"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-6 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <form method="GET" class="glass-card bg-white p-4 rounded-2xl mb-8 flex flex-col md:flex-row gap-4 items-center animate-fade-in shadow-sm border border-white/60">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Rechercher par nom ou email..." 
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none">
            </div>
            
            <div class="w-full md:w-56 relative">
                <select name="role" class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none cursor-pointer">
                    <option value="">Tous les rôles</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateurs</option>
                    <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Propriétaires</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            
            <button type="submit" class="w-full md:w-auto btn-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 hover-lift flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filtrer
            </button>
            
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('admin.users') }}" class="w-full md:w-auto px-4 py-3 text-gray-500 hover:text-dark font-medium flex items-center justify-center gap-2 transition">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            @endif
        </form>
        
        <!-- Liste des utilisateurs -->
        @if($users->count() > 0)
            <div class="glass-card bg-white rounded-3xl shadow-sm border border-white/60 overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Email</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Activité</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50/80 transition group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @if($user->avatar)
                                                <div class="relative">
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                         alt="{{ $user->name }}"
                                                         class="w-12 h-12 rounded-full object-cover shadow-sm group-hover:scale-105 transition-transform">
                                                </div>
                                            @else
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-500 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                            
                                            <div>
                                                <p class="font-bold text-dark group-hover:text-primary transition-colors">{{ $user->name }}</p>
                                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-calendar-alt"></i>
                                                    {{ $user->created_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 font-medium">{{ $user->email }}</span>
                                            @if($user->phone)
                                                <span class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-phone-alt text-xs"></i> {{ $user->phone }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role == 'admin')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-purple-100 text-purple-700">
                                                <i class="fas fa-crown text-purple-500"></i> Admin
                                            </span>
                                        @elseif($user->role == 'owner')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                                                <i class="fas fa-building text-blue-500"></i> Propriétaire
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-700">
                                                <i class="fas fa-user text-gray-500"></i> Utilisateur
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->role == 'owner')
                                            <div class="flex flex-col gap-1">
                                                <span class="text-xs font-medium text-gray-600 flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                                                    {{ $user->accommodations_count }} hébergements
                                                </span>
                                                <span class="text-xs font-medium text-gray-600 flex items-center gap-1.5">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                                    {{ $user->reservations_count }} réservations
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-xs font-medium text-gray-600 flex items-center gap-1.5">
                                                <span class="w-1.5 h-1.5 rounded-full bg-purple-500"></span>
                                                {{ $user->reservations_count }} réservations
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col gap-2">
                                            @if($user->is_active)
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-green-600">
                                                    <i class="fas fa-check-circle"></i> Actif
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-red-600">
                                                    <i class="fas fa-ban"></i> Désactivé
                                                </span>
                                            @endif
                                            
                                            @if($user->email_verified_at)
                                                <span class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-600">
                                                    <i class="fas fa-envelope-open-text"></i> Email vérifié
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if(!$user->isAdmin())
                                            <form action="{{ route('admin.users.toggle-status', $user->id) }}" 
                                                  method="POST" 
                                                  class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                
                                                @if($user->is_active)
                                                    <button type="submit" 
                                                            class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition shadow-sm"
                                                            title="Désactiver">
                                                        <i class="fas fa-ban text-xs"></i>
                                                    </button>
                                                @else
                                                    <button type="submit" 
                                                            class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-500 hover:text-white transition shadow-sm"
                                                            title="Activer">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-500 rounded-lg text-xs font-bold border border-gray-200 cursor-not-allowed">
                                                <i class="fas fa-lock mr-1"></i> Admin
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $users->links() }}
            </div>
        @else
            <div class="glass-card bg-white rounded-3xl p-12 text-center border border-white/60 shadow-sm">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-users text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-2">Aucun utilisateur trouvé</h3>
                <p class="text-gray-500">Essayez de modifier vos critères de recherche.</p>
                <a href="{{ route('admin.users') }}" class="inline-block mt-4 text-primary font-bold hover:underline">
                    Réinitialiser les filtres
                </a>
            </div>
        @endif
    </div>
</section>

@endsection