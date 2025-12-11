@extends('layouts.app')

@section('title', 'Mon tableau de bord')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-accent py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-tachometer-alt mr-2"></i> Tableau de bord
                </h1>
                <p class="text-white/90">Bienvenue, {{ auth()->user()->name }} !</p>
            </div>
            
            <div class="hidden md:block fade-in">
                <div class="flex items-center gap-3 bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-accent text-xl font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-white">
                        <p class="font-semibold">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-white/80">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation du dashboard -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('dashboard') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-home mr-2"></i> Aperçu
            </a>
            <a href="{{ route('reservations.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-calendar-check mr-2"></i> Mes réservations
            </a>
            <a href="{{ route('profile.edit') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-user mr-2"></i> Mon profil
            </a>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total réservations -->
            <div class="bg-gradient-to-br from-primary to-secondary rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Total réservations</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['total_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-alt text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-chart-line mr-1"></i> Depuis votre inscription
                </p>
            </div>
            
            <!-- Réservations en cours -->
            <div class="bg-gradient-to-br from-accent to-dark rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">En cours</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['active_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-clock text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-hourglass-half mr-1"></i> Confirmées et à venir
                </p>
            </div>
            
            <!-- Avis laissés -->
            <div class="bg-gradient-to-br from-secondary to-accent rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Avis laissés</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['reviews_count'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-comment mr-1"></i> Votre contribution
                </p>
            </div>
            
            <!-- Hébergements favoris -->
            <div class="bg-gradient-to-br from-dark to-primary rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Favoris</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['favorites_count'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-heart text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-bookmark mr-1"></i> Sauvegardés
                </p>
            </div>
        </div>
        
        <!-- Contenu principal en 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche: Réservations récentes -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Prochaines réservations -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-dark">
                            <i class="fas fa-calendar-check text-accent mr-2"></i> Prochaines réservations
                        </h2>
                        <a href="{{ route('reservations.index') }}" class="text-accent hover:text-dark transition">
                            Voir tout <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if(isset($upcomingReservations) && $upcomingReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($upcomingReservations as $reservation)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-accent transition">
                                    <div class="flex gap-4">
                                        <!-- Image -->
                                        <div class="w-24 h-24 rounded-lg overflow-hidden flex-shrink-0 bg-gray-200">
                                            @if($reservation->accommodation->primary_image)
                                                <img 
                                                    src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                                    alt="{{ $reservation->accommodation->title }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center">
                                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Infos -->
                                        <div class="flex-1">
                                            <h3 class="font-bold text-dark mb-1 line-clamp-1">
                                                {{ $reservation->accommodation->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fas fa-map-marker-alt text-accent mr-1"></i>
                                                {{ $reservation->accommodation->quartier }}
                                            </p>
                                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                                <span>
                                                    <i class="fas fa-calendar mr-1"></i>
                                                    {{ $reservation->check_in->format('d/m/Y') }}
                                                </span>
                                                <span>→</span>
                                                <span>{{ $reservation->check_out->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Statut et prix -->
                                        <div class="text-right">
                                            <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-2
                                                {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                   ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                {{ $reservation->status === 'confirmed' ? 'Confirmée' : 
                                                   ($reservation->status === 'pending' ? 'En attente' : ucfirst($reservation->status)) }}
                                            </span>
                                            <p class="text-accent font-bold text-lg">
                                                {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex gap-2 mt-4">
                                        <a href="{{ route('reservations.show', $reservation) }}" 
                                           class="flex-1 text-center bg-accent/10 text-accent px-4 py-2 rounded-lg hover:bg-accent hover:text-white transition">
                                            <i class="fas fa-eye mr-1"></i> Voir
                                        </a>
                                        <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                                           class="flex-1 text-center border border-accent text-accent px-4 py-2 rounded-lg hover:bg-accent hover:text-white transition">
                                            <i class="fas fa-home mr-1"></i> Hébergement
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-calendar-times text-6xl mb-4 text-gray-300"></i>
                            <p class="text-lg mb-4">Aucune réservation à venir</p>
                            <a href="{{ route('accommodations.index') }}" class="btn-primary text-white px-6 py-3 rounded-lg inline-block">
                                <i class="fas fa-search mr-2"></i> Rechercher un hébergement
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Historique des réservations -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-history text-accent mr-2"></i> Historique récent
                    </h2>
                    
                    @if(isset($recentReservations) && $recentReservations->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentReservations as $reservation)
                                <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent transition">
                                    <div class="w-12 h-12 rounded-lg bg-accent/10 flex items-center justify-center">
                                        <i class="fas fa-home text-accent"></i>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-semibold text-dark line-clamp-1">{{ $reservation->accommodation->title }}</p>
                                        <p class="text-sm text-gray-600">{{ $reservation->check_in->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                                        {{ $reservation->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                           ($reservation->status === 'cancelled' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                        {{ $reservation->status === 'completed' ? 'Terminée' : 
                                           ($reservation->status === 'cancelled' ? 'Annulée' : ucfirst($reservation->status)) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Aucun historique</p>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite: Infos et raccourcis -->
            <div class="space-y-6">
                
                <!-- Profil -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4">
                        <i class="fas fa-user-circle text-accent mr-2"></i> Mon profil
                    </h2>
                    
                    <div class="text-center mb-4">
                        <div class="w-20 h-20 bg-accent rounded-full flex items-center justify-center text-white text-3xl font-bold mx-auto mb-3">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h3 class="font-bold text-dark">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600">{{ auth()->user()->email }}</p>
                        @if(auth()->user()->phone)
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-phone mr-1"></i> {{ auth()->user()->phone }}
                            </p>
                        @endif
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="block w-full text-center btn-primary text-white py-2 rounded-lg">
                        <i class="fas fa-edit mr-2"></i> Modifier mon profil
                    </a>
                </div>
                
                <!-- Actions rapides -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4">
                        <i class="fas fa-bolt text-accent mr-2"></i> Actions rapides
                    </h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('accommodations.index') }}" 
                           class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 transition">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-search text-dark"></i>
                            </div>
                            <span class="font-semibold text-dark">Chercher un hébergement</span>
                        </a>
                        
                        <a href="{{ route('reservations.index') }}" 
                           class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 transition">
                            <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-dark"></i>
                            </div>
                            <span class="font-semibold text-dark">Mes réservations</span>
                        </a>
                        
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.accommodations.index') }}" 
                               class="flex items-center gap-3 p-3 border border-accent bg-accent/5 rounded-lg hover:bg-accent/10 transition">
                                <div class="w-10 h-10 bg-accent rounded-lg flex items-center justify-center">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <span class="font-semibold text-dark">Mes hébergements</span>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Conseils -->
                <div class="bg-gradient-to-br from-accent to-dark rounded-xl shadow-lg p-6 text-white fade-in">
                    <h2 class="text-xl font-bold mb-4">
                        <i class="fas fa-lightbulb mr-2"></i> Le saviez-vous ?
                    </h2>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Réservez à l'avance pour de meilleurs prix</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Laissez des avis pour aider la communauté</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Contactez les propriétaires avant de réserver</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection