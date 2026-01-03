@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-users text-purple-400"></i> Gestion des utilisateurs
            </h1>
            <p class="text-white/80 text-lg">Gérer tous les utilisateurs de la plateforme</p>
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

<!-- Contenu Principal -->
<section class="pb-12 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        <!-- Filtres -->
        <div class="glass-card bg-white p-4 rounded-2xl mb-8 flex flex-wrap gap-3 animate-fade-in shadow-sm border border-white/60">
            <a href="{{ route('admin.users') }}" 
               class="px-5 py-2.5 rounded-xl font-bold transition-all {{ !request('role') ? 'bg-gray-900 text-white shadow-lg shadow-gray-900/20' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                <i class="fas fa-list mr-2"></i> Tous
            </a>
            <a href="{{ route('admin.users', ['role' => 'user']) }}" 
               class="px-5 py-2.5 rounded-xl font-bold transition-all {{ request('role') === 'user' ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/30' : 'bg-gray-100 text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                <i class="fas fa-user mr-2"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.users', ['role' => 'owner']) }}" 
               class="px-5 py-2.5 rounded-xl font-bold transition-all {{ request('role') === 'owner' ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/30' : 'bg-gray-100 text-gray-600 hover:bg-purple-50 hover:text-purple-600' }}">
                <i class="fas fa-building mr-2"></i> Propriétaires
            </a>
            <a href="{{ route('admin.users', ['role' => 'admin']) }}" 
               class="px-5 py-2.5 rounded-xl font-bold transition-all {{ request('role') === 'admin' ? 'bg-red-600 text-white shadow-lg shadow-red-600/30' : 'bg-gray-100 text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                <i class="fas fa-shield-alt mr-2"></i> Administrateurs
            </a>
        </div>
        
        @if($users->count() > 0)
            <!-- Liste des utilisateurs -->
            <div class="glass-card bg-white rounded-3xl shadow-sm border border-white/60 overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Utilisateur</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Rôle</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Contact</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Stats</th>
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
                                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-gray-100 to-gray-200 text-gray-500 flex items-center justify-center shadow-sm group-hover:scale-105 transition-transform font-bold text-lg">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
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
                                        @if($user->role === 'admin')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-100 text-red-700">
                                                <i class="fas fa-shield-alt"></i> Admin
                                            </span>
                                        @elseif($user->role === 'owner')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-purple-100 text-purple-700">
                                                <i class="fas fa-building"></i> Propriétaire
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-blue-100 text-blue-700">
                                                <i class="fas fa-user"></i> Utilisateur
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 font-medium text-sm">{{ $user->email }}</span>
                                            @if($user->phone)
                                                <span class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-phone-alt text-xs"></i> {{ $user->phone }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
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
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($user->is_active)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i> Actif
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-red-100 text-red-700">
                                                <i class="fas fa-ban"></i> Désactivé
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="w-8 h-8 rounded-lg flex items-center justify-center transition shadow-sm {{ $user->is_active ? 'bg-red-100 text-red-600 hover:bg-red-500 hover:text-white' : 'bg-green-100 text-green-600 hover:bg-green-500 hover:text-white' }}"
                                                        title="{{ $user->is_active ? 'Désactiver' : 'Activer' }}">
                                                    <i class="fas fa-{{ $user->is_active ? 'ban' : 'check' }} text-xs"></i>
                                                </button>
                                            </form>
                                        @else
                                            <span class="inline-block px-3 py-1 bg-gray-100 text-gray-400 rounded-lg text-xs font-bold border border-gray-200 cursor-not-allowed">
                                                Vous
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