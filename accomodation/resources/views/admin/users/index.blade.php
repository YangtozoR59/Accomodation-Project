@extends('layouts.app')

@section('title', 'Gestion des utilisateurs')

@section('content')

<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-users mr-2"></i> Gestion des utilisateurs
        </h1>
    </div>
</section>

<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition whitespace-nowrap">
                <i class="fas fa-tachometer-alt mr-2"></i> Aperçu
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition whitespace-nowrap">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
        </div>
    </div>
</section>

<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-8 fade-in">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.users') }}" 
                   class="px-4 py-2 rounded-lg {{ !request('role') ? 'bg-accent text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-list mr-2"></i> Tous
                </a>
                <a href="{{ route('admin.users', ['role' => 'user']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('role') === 'user' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-user mr-2"></i> Utilisateurs
                </a>
                <a href="{{ route('admin.users', ['role' => 'owner']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('role') === 'owner' ? 'bg-purple-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-building mr-2"></i> Propriétaires
                </a>
                <a href="{{ route('admin.users', ['role' => 'admin']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('role') === 'admin' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-shield-alt mr-2"></i> Administrateurs
                </a>
            </div>
        </div>
        
        @if($users->count() > 0)
            <!-- Liste des utilisateurs -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Utilisateur
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Rôle
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Contact
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stats
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Statut
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $user)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white font-bold mr-3">
                                                {{ strtoupper(substr($user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-dark">{{ $user->name }}</div>
                                                <div class="text-sm text-gray-500">Inscrit {{ $user->created_at->format('d/m/Y') }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->role === 'admin')
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-shield-alt mr-1"></i> Admin
                                            </span>
                                        @elseif($user->role === 'owner')
                                            <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-building mr-1"></i> Propriétaire
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-user mr-1"></i> Utilisateur
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                        @if($user->phone)
                                            <div class="text-sm text-gray-500">{{ $user->phone }}</div>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <i class="fas fa-building text-accent mr-1"></i> 
                                            {{ $user->accommodations_count }} hébergement(s)
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <i class="fas fa-calendar-check text-accent mr-1"></i>
                                            {{ $user->reservations_count }} réservation(s)
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($user->is_active)
                                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-check-circle mr-1"></i> Actif
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                                <i class="fas fa-ban mr-1"></i> Désactivé
                                            </span>
                                        @endif
                                    </td>
                                    
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($user->id !== auth()->id())
                                            <form action="{{ route('admin.users.toggle-status', $user) }}" method="POST" class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="text-accent hover:text-dark transition">
                                                    @if($user->is_active)
                                                        <i class="fas fa-ban mr-1"></i> Désactiver
                                                    @else
                                                        <i class="fas fa-check mr-1"></i> Activer
                                                    @endif
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Vous</span>
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
            <div class="bg-white rounded-xl shadow-lg p-12 text-center fade-in">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun utilisateur</h3>
                <p class="text-gray-600">Aucun utilisateur ne correspond à ces critères</p>
            </div>
        @endif
    </div>
</section>

@endsection