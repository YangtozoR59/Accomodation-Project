@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-users mr-2"></i> Gestion des utilisateurs
        </h1>
        <p class="text-white/90 mt-2">Gérer tous les utilisateurs de la plateforme</p>
    </div>
</section>

<!-- Navigation Admin -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-tags mr-2"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <form method="GET" class="flex gap-4 items-center">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Rechercher par nom ou email..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            
            <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                <option value="">Tous les rôles</option>
                <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Utilisateurs</option>
                <option value="owner" {{ request('role') == 'owner' ? 'selected' : '' }}>Propriétaires</option>
                <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administrateurs</option>
            </select>
            
            <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-dark transition">
                <i class="fas fa-search mr-2"></i> Filtrer
            </button>
            
            @if(request()->anyFilled(['search', 'role']))
                <a href="{{ route('admin.users') }}" class="text-gray-600 hover:text-accent">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Liste des utilisateurs -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        @if($users->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Utilisateur</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Email</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Rôle</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Activité</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Statut</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                 alt="{{ $user->name }}"
                                                 class="w-10 h-10 rounded-full object-cover">
                                        @else
                                            <div class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center">
                                                <i class="fas fa-user text-accent"></i>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <p class="font-semibold text-dark">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">Inscrit le {{ $user->created_at->format('d/m/Y') }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-900">{{ $user->email }}</p>
                                    @if($user->phone)
                                        <p class="text-xs text-gray-600">{{ $user->phone }}</p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role == 'admin')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-purple-100 text-purple-800">
                                            <i class="fas fa-crown mr-1"></i> Admin
                                        </span>
                                    @elseif($user->role == 'owner')
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                                            <i class="fas fa-building mr-1"></i> Propriétaire
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-800">
                                            <i class="fas fa-user mr-1"></i> Utilisateur
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->role == 'owner')
                                        <div class="text-sm">
                                            <p class="text-gray-600">
                                                <i class="fas fa-building text-accent mr-1"></i>
                                                {{ $user->accommodations_count }} hébergement(s)
                                            </p>
                                            <p class="text-gray-600">
                                                <i class="fas fa-calendar text-accent mr-1"></i>
                                                {{ $user->reservations_count }} réservation(s)
                                            </p>
                                        </div>
                                    @else
                                        <p class="text-gray-600">
                                            <i class="fas fa-calendar-check text-accent mr-1"></i>
                                            {{ $user->reservations_count }} réservation(s)
                                        </p>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->is_active)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Actif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-red-100 text-red-800">
                                            <i class="fas fa-ban mr-1"></i> Désactivé
                                        </span>
                                    @endif
                                    
                                    @if($user->email_verified_at)
                                        <br>
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-800 mt-1">
                                            <i class="fas fa-envelope-check mr-1"></i> Email vérifié
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!$user->isAdmin())
                                        <form action="{{ route('admin.users.toggle-status', $user->id) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            
                                            @if($user->is_active)
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm"
                                                        title="Désactiver">
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @else
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm"
                                                        title="Activer">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-500 italic">Administrateur</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $users->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-users text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-600">Aucun utilisateur trouvé</p>
            </div>
        @endif
    </div>
</section>

@endsection