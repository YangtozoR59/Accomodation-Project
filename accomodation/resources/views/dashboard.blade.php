@extends('layouts.app')

@section('title', 'Mon tableau de bord')

@section('content')

<!-- Header -->
<section class="bg-primary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-10 w-96 h-96 bg-secondary rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-white rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-secondary rounded-full blur-3xl animate-float" style="animation-delay: 6s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                    <i class="fas fa-tachometer-alt"></i> Tableau de bord
                </h1>
                <p class="text-white text-lg">Bienvenue, {{ auth()->user()->name }} !</p>
            </div>
            
            <div class="hidden md:block animate-fade-in">
                <div class="backdrop-blur-lg bg-white/20 rounded-3xl px-8 py-4 flex items-center gap-4 border border-white/20">
                    <div class="w-16 h-16 rounded-full flex items-center justify-center text-secondary text-2xl font-bold bg-white shadow-lg">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="text-white">
                        <p class="font-bold text-lg">{{ auth()->user()->name }}</p>
                        <p class="text-sm text-white/80">{{ ucfirst(auth()->user()->role) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="bg-white/80 backdrop-blur-md shadow-sm sticky top-20 z-40 border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex gap-2 overflow-x-auto py-4">
            <a href="{{ route('dashboard') }}" 
               class="px-6 py-3 rounded-xl text-white bg-secondary font-semibold whitespace-nowrap flex items-center gap-2 shadow-lg">
                <i class="fas fa-home"></i> Aperçu
            </a>
            <a href="{{ route('reservations.index') }}" 
               class="px-6 py-3 rounded-xl text-gray-700 hover:text-primary font-medium transition whitespace-nowrap flex items-center gap-2 glass-card hover:bg-white">
                <i class="fas fa-calendar-check"></i> Mes réservations
            </a>
            <a href="{{ route('profile.edit') }}" 
               class="px-6 py-3 rounded-xl text-gray-700 hover:text-primary font-medium transition whitespace-nowrap flex items-center gap-2 glass-card hover:bg-white">
                <i class="fas fa-user"></i> Mon profil
            </a>
        </div>
    </div>
</section>

<!-- Contenu principal -->
<section class="py-12 bg-gray-50">
    <div class="container mx-auto px-4">
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total réservations -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold mb-2">Total réservations</p>
                        <h3 class="text-4xl font-bold text-primary">{{ $stats['total_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-primary/10 w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-calendar-alt text-3xl text-secondary"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-chart-line text-secondary"></i>
                    <span>Depuis votre inscription</span>
                </div>
            </div>
            
            <!-- Réservations en cours -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in" style="animation-delay: 0.1s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold mb-2">En cours</p>
                        <h3 class="text-4xl font-bold text-primary">{{ $stats['active_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-secondary/10 w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-clock text-3xl text-secondary"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-hourglass-half text-secondary"></i>
                    <span>Confirmées et à venir</span>
                </div>
            </div>
            
            <!-- Avis laissés -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in" style="animation-delay: 0.2s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold mb-2">Avis laissés</p>
                        <h3 class="text-4xl font-bold text-primary">{{ $stats['reviews_count'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-accent/10 w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-star text-3xl text-yellow-500"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-comment text-secondary"></i>
                    <span>Votre contribution</span>
                </div>
            </div>
            
            <!-- Hébergements favoris -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in" style="animation-delay: 0.3s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-600 text-sm font-semibold mb-2">Favoris</p>
                        <h3 class="text-4xl font-bold text-primary">{{ $stats['favorites_count'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-gray-100 w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-heart text-3xl text-secondary"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-bookmark text-secondary"></i>
                    <span>Sauvegardés</span>
                </div>
            </div>
        </div>
        
        <!-- Contenu principal en 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche: Réservations récentes -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Prochaines réservations -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-dark flex items-center gap-3">
                            <i class="fas fa-calendar-check text-secondary"></i> Prochaines réservations
                        </h2>
                        <a href="{{ route('reservations.index') }}" 
                           class="text-secondary hover:text-primary transition font-semibold flex items-center gap-2 hover-lift">
                            <span>Voir tout</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>
                    
                    @if(isset($upcomingReservations) && $upcomingReservations->count() > 0)
                        <div class="space-y-5">
                            @foreach($upcomingReservations as $reservation)
                                <div class="bg-gray-50 rounded-2xl p-5 hover:scale-102 transition-transform border border-gray-100">
                                    <div class="flex gap-4 mb-4">
                                        <!-- Image -->
                                        <div class="glass-card w-28 h-28 rounded-2xl overflow-hidden flex-shrink-0">
                                            @if($reservation->accommodation->primary_image)
                                                <img 
                                                    src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                                    alt="{{ $reservation->accommodation->title }}"
                                                    class="w-full h-full object-cover"
                                                >
                                            @else
                                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                                    <i class="fas fa-image text-3xl text-gray-400"></i>
                                                </div>
                                            @endif
                                        </div>
                                        
                                        <!-- Infos -->
                                        <div class="flex-1 min-w-0">
                                            <h3 class="font-bold text-dark mb-2 text-lg line-clamp-1">
                                                {{ $reservation->accommodation->title }}
                                            </h3>
                                            <p class="text-sm text-gray-600 mb-3 flex items-center gap-2">
                                                <i class="fas fa-map-marker-alt text-secondary"></i>
                                                <span class="font-medium">{{ $reservation->accommodation->quartier }}</span>
                                            </p>
                                            <div class="flex items-center gap-3 text-sm text-gray-600 font-medium">
                                                <i class="fas fa-calendar text-secondary"></i>
                                                <span>{{ $reservation->check_in->format('d/m/Y') }}</span>
                                                <i class="fas fa-arrow-right text-xs text-gray-400"></i>
                                                <span>{{ $reservation->check_out->format('d/m/Y') }}</span>
                                            </div>
                                        </div>
                                        
                                        <!-- Statut et prix -->
                                        <div class="text-right flex flex-col justify-between items-end flex-shrink-0">
                                            <span class="px-4 py-2 rounded-xl text-xs font-bold
                                                {{ $reservation->status === 'confirmed' ? 'bg-green-50 text-green-700 border border-green-200' : 
                                                   ($reservation->status === 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : 'bg-gray-50 text-gray-700 border border-gray-200') }}">
                                                @if($reservation->status === 'confirmed')
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmée
                                                @elseif($reservation->status === 'pending')
                                                    <i class="fas fa-clock mr-1"></i> En attente
                                                @else
                                                    {{ ucfirst($reservation->status) }}
                                                @endif
                                            </span>
                                            <div>
                                                <p class="text-2xl font-bold text-primary">
                                                    {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                                </p>
                                                <p class="text-xs text-gray-500 font-medium">FCFA</p>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Actions -->
                                    <div class="flex gap-3 pt-4 border-t border-gray-200">
                                        <a href="{{ route('reservations.show', $reservation) }}" 
                                           class="flex-1 text-center glass-card text-secondary px-4 py-3 rounded-xl hover-lift font-semibold flex items-center justify-center gap-2 hover:bg-white">
                                            <i class="fas fa-eye"></i>
                                            <span>Voir</span>
                                        </a>
                                        <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                                           class="flex-1 text-center glass-card text-primary px-4 py-3 rounded-xl hover-lift font-semibold flex items-center justify-center gap-2 hover:bg-white">
                                            <i class="fas fa-home"></i>
                                            <span>Hébergement</span>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="glass-card w-24 h-24 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-gray-50">
                                <i class="fas fa-calendar-times text-5xl text-gray-300"></i>
                            </div>
                            <p class="text-lg text-gray-600 font-medium mb-6">Aucune réservation à venir</p>
                            <a href="{{ route('accommodations.index') }}" 
                               class="btn-secondary text-white px-8 py-4 rounded-2xl inline-flex items-center gap-2 font-bold">
                                <i class="fas fa-search"></i>
                                <span>Rechercher un hébergement</span>
                            </a>
                        </div>
                    @endif
                </div>
                
                <!-- Historique des réservations -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in">
                    <h2 class="text-2xl md:text-3xl font-bold text-dark mb-6 flex items-center gap-3">
                        <i class="fas fa-history text-secondary"></i> Historique récent
                    </h2>
                    
                    @if(isset($recentReservations) && $recentReservations->count() > 0)
                        <div class="space-y-3">
                            @foreach($recentReservations as $reservation)
                                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl hover:scale-102 transition-transform border border-gray-100">
                                    <div class="glass-card w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0 bg-white">
                                        <i class="fas fa-home text-secondary text-xl"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <p class="font-bold text-dark line-clamp-1 mb-1">{{ $reservation->accommodation->title }}</p>
                                        <p class="text-sm text-gray-600 font-medium">{{ $reservation->check_in->format('d/m/Y') }}</p>
                                    </div>
                                    <span class="px-4 py-2 rounded-xl text-xs font-bold flex-shrink-0
                                        {{ $reservation->status === 'completed' ? 'bg-green-50 text-green-700 border border-green-200' : 
                                           ($reservation->status === 'cancelled' ? 'bg-red-50 text-red-700 border border-red-200' : 'bg-gray-50 text-gray-700 border border-gray-200') }}">
                                        @if($reservation->status === 'completed')
                                            <i class="fas fa-check mr-1"></i> Terminée
                                        @elseif($reservation->status === 'cancelled')
                                            <i class="fas fa-times mr-1"></i> Annulée
                                        @else
                                            {{ ucfirst($reservation->status) }}
                                        @endif
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="glass-card w-20 h-20 mx-auto mb-4 rounded-3xl flex items-center justify-center bg-gray-50">
                                <i class="fas fa-history text-4xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-600 font-medium">Aucun historique</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite: Infos et raccourcis -->
            <div class="space-y-6">
                
                <!-- Profil -->
                <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-6 flex items-center gap-2">
                        <i class="fas fa-user-circle text-secondary"></i> Mon profil
                    </h2>
                    
                    <div class="text-center mb-6">
                        <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center text-secondary text-3xl font-bold bg-gray-50 shadow-inner">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <h3 class="font-bold text-dark text-lg mb-1">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-gray-600 mb-1">{{ auth()->user()->email }}</p>
                        @if(auth()->user()->phone)
                            <p class="text-sm text-gray-600 flex items-center justify-center gap-1">
                                <i class="fas fa-phone text-secondary"></i>
                                <span>{{ auth()->user()->phone }}</span>
                            </p>
                        @endif
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" 
                       class="btn-secondary block w-full text-center text-white py-4 rounded-2xl font-semibold hover-lift flex items-center justify-center gap-2">
                        <i class="fas fa-edit"></i>
                        <span>Modifier mon profil</span>
                    </a>
                </div>
                
                <!-- Actions rapides -->
                <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in">
                    <h2 class="text-xl font-bold text-dark mb-6 flex items-center gap-2">
                        <i class="fas fa-bolt text-secondary"></i> Actions rapides
                    </h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('accommodations.index') }}" 
                           class="bg-gray-50 border border-gray-100 flex items-center gap-3 p-4 rounded-2xl hover:scale-105 transition-transform">
                            <div class="glass-card w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-white">
                                <i class="fas fa-search text-primary"></i>
                            </div>
                            <span class="font-semibold text-dark">Chercher un hébergement</span>
                        </a>
                        
                        <a href="{{ route('reservations.index') }}" 
                           class="bg-gray-50 border border-gray-100 flex items-center gap-3 p-4 rounded-2xl hover:scale-105 transition-transform">
                            <div class="glass-card w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 bg-white">
                                <i class="fas fa-calendar-alt text-secondary"></i>
                            </div>
                            <span class="font-semibold text-dark">Mes réservations</span>
                        </a>
                        
                        @if(auth()->user()->isOwner())
                            <a href="{{ route('owner.accommodations.index') }}" 
                               class="btn-secondary flex items-center gap-3 p-4 rounded-2xl hover-lift text-white">
                                <div class="bg-white/20 w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-building text-white"></i>
                                </div>
                                <span class="font-semibold">Mes hébergements</span>
                            </a>
                        @endif
                    </div>
                </div>
                
                <!-- Conseils -->
                <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in">
                    <div class="mb-6">
                        <div class="bg-yellow-50 w-14 h-14 mx-auto mb-4 rounded-2xl flex items-center justify-center">
                            <i class="fas fa-lightbulb text-3xl text-accent"></i>
                        </div>
                        <h2 class="text-xl font-bold text-dark text-center">Le saviez-vous ?</h2>
                    </div>
                    
                    <ul class="space-y-4 text-sm">
                        <li class="flex items-start gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <i class="fas fa-check-circle text-secondary mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Réservez à l'avance pour de meilleurs prix</span>
                        </li>
                        <li class="flex items-start gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <i class="fas fa-check-circle text-secondary mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Laissez des avis pour aider la communauté</span>
                        </li>
                        <li class="flex items-start gap-3 bg-gray-50 p-3 rounded-xl border border-gray-100">
                            <i class="fas fa-check-circle text-secondary mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Contactez les propriétaires avant de réserver</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection