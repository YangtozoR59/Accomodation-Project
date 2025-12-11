@extends('layouts.app')

@section('title', 'Espace Propriétaire')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark via-accent to-secondary py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-building mr-2"></i> Espace Propriétaire
                </h1>
                <p class="text-white/90">Gérez vos hébergements et réservations</p>
            </div>
            
            <a href="{{ route('owner.accommodations.create') }}" 
               class="hidden md:inline-block bg-white text-accent px-6 py-3 rounded-full font-bold hover:bg-primary transition fade-in">
                <i class="fas fa-plus mr-2"></i> Ajouter un hébergement
            </a>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('owner.accommodations.index') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-home mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('owner.accommodations.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Mes hébergements
            </a>
            <a href="{{ route('owner.reservations.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-calendar-alt mr-2"></i> Réservations
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total hébergements -->
            <div class="bg-gradient-to-br from-primary to-secondary rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Mes hébergements</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['total_accommodations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-check-circle mr-1"></i> {{ $stats['verified_accommodations'] ?? 0 }} vérifiés
                </p>
            </div>
            
            <!-- Réservations du mois -->
            <div class="bg-gradient-to-br from-accent to-dark rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Réservations ce mois</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['month_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-clock mr-1"></i> {{ $stats['pending_reservations'] ?? 0 }} en attente
                </p>
            </div>
            
            <!-- Revenus du mois -->
            <div class="bg-gradient-to-br from-secondary to-accent rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Revenus ce mois</p>
                        <h3 class="text-2xl font-bold mt-2">{{ number_format($stats['month_revenue'] ?? 0, 0, ',', ' ') }}</h3>
                        <p class="text-white/80 text-xs">FCFA</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-money-bill-wave text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-chart-line mr-1"></i> Total: {{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA
                </p>
            </div>
            
            <!-- Note moyenne -->
            <div class="bg-gradient-to-br from-dark to-primary rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Note moyenne</p>
                        <h3 class="text-3xl font-bold mt-2">{{ number_format($stats['average_rating'] ?? 0, 1) }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-star text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-comment mr-1"></i> {{ $stats['total_reviews'] ?? 0 }} avis
                </p>
            </div>
        </div>
        
        <!-- Contenu en 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Réservations récentes -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl font-bold text-dark">
                            <i class="fas fa-bell text-accent mr-2"></i> Nouvelles réservations
                        </h2>
                        <a href="{{ route('owner.reservations.index') }}" class="text-accent hover:text-dark transition">
                            Voir tout <i class="fas fa-arrow-right ml-1"></i>
                        </a>
                    </div>
                    
                    @if(isset($recentReservations) && $recentReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentReservations as $reservation)
                                <div class="border border-gray-200 rounded-lg p-4 hover:border-accent transition">
                                    <div class="flex justify-between items-start mb-3">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2 mb-2">
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                       ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $reservation->status === 'confirmed' ? 'Confirmée' : 
                                                       ($reservation->status === 'pending' ? 'En attente' : ucfirst($reservation->status)) }}
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    il y a {{ $reservation->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <h3 class="font-bold text-dark mb-1">
                                                {{ $reservation->accommodation->title }}
                                            </h3>
                                            
                                            <p class="text-sm text-gray-600 mb-2">
                                                <i class="fas fa-user text-accent mr-1"></i>
                                                {{ $reservation->user->name }} - {{ $reservation->nb_guests }} invité(s)
                                            </p>
                                            
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-calendar text-accent mr-1"></i>
                                                {{ $reservation->check_in->format('d/m') }} → {{ $reservation->check_out->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        
                                        <div class="text-right ml-4">
                                            <p class="text-xl font-bold text-accent">
                                                {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                            </p>
                                            <p class="text-xs text-gray-600">FCFA</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-2">
                                        <a href="{{ route('owner.reservations.show', $reservation) }}" 
                                           class="flex-1 text-center bg-accent/10 text-accent px-4 py-2 rounded-lg hover:bg-accent hover:text-white transition">
                                            <i class="fas fa-eye mr-1"></i> Voir
                                        </a>
                                        
                                        @if($reservation->status === 'pending')
                                            <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                                                    <i class="fas fa-check mr-1"></i> Confirmer
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 text-gray-500">
                            <i class="fas fa-inbox text-6xl mb-4 text-gray-300"></i>
                            <p class="text-lg">Aucune nouvelle réservation</p>
                        </div>
                    @endif
                </div>
                
                <!-- Performances des hébergements -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-chart-bar text-accent mr-2"></i> Performances de vos hébergements
                    </h2>
                    
                    @if(isset($topAccommodations) && $topAccommodations->count() > 0)
                        <div class="space-y-4">
                            @foreach($topAccommodations as $accommodation)
                                <div class="flex items-center gap-4 p-3 border border-gray-200 rounded-lg">
                                    <div class="w-16 h-16 rounded-lg bg-gray-200 flex-shrink-0 overflow-hidden">
                                        @if($accommodation->primary_image)
                                            <img src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                                 alt="{{ $accommodation->title }}"
                                                 class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1">
                                        <h3 class="font-bold text-dark line-clamp-1">{{ $accommodation->title }}</h3>
                                        <div class="flex items-center gap-4 text-sm text-gray-600 mt-1">
                                            <span>
                                                <i class="fas fa-calendar-check text-accent mr-1"></i>
                                                {{ $accommodation->reservations_count ?? 0 }} réservations
                                            </span>
                                            <span>
                                                <i class="fas fa-eye text-accent mr-1"></i>
                                                {{ $accommodation->views_count }} vues
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($accommodation->reviews_count > 0)
                                        <div class="text-right">
                                            <div class="flex items-center justify-end gap-1">
                                                <i class="fas fa-star text-yellow-400"></i>
                                                <span class="font-bold text-dark">{{ number_format($accommodation->average_rating, 1) }}</span>
                                            </div>
                                            <p class="text-xs text-gray-500">{{ $accommodation->reviews_count }} avis</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-gray-500 py-8">Aucune donnée disponible</p>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite -->
            <div class="space-y-6">
                
                <!-- Actions rapides -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4">
                        <i class="fas fa-bolt text-accent mr-2"></i> Actions rapides
                    </h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('owner.accommodations.create') }}" 
                           class="flex items-center gap-3 p-3 bg-accent text-white rounded-lg hover:bg-dark transition">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-plus"></i>
                            </div>
                            <span class="font-semibold">Ajouter un hébergement</span>
                        </a>
                        
                        <a href="{{ route('owner.accommodations.index') }}" 
                           class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 transition">
                            <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                <i class="fas fa-edit text-dark"></i>
                            </div>
                            <span class="font-semibold text-dark">Gérer mes hébergements</span>
                        </a>
                        
                        <a href="{{ route('owner.reservations.index') }}" 
                           class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 transition">
                            <div class="w-10 h-10 bg-secondary rounded-lg flex items-center justify-center">
                                <i class="fas fa-calendar-alt text-dark"></i>
                            </div>
                            <span class="font-semibold text-dark">Voir les réservations</span>
                        </a>
                    </div>
                </div>
                
                <!-- Conseils -->
                <div class="bg-gradient-to-br from-accent to-dark rounded-xl shadow-lg p-6 text-white fade-in">
                    <h2 class="text-xl font-bold mb-4">
                        <i class="fas fa-lightbulb mr-2"></i> Conseils
                    </h2>
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Ajoutez des photos de qualité pour attirer plus de clients</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Répondez rapidement aux demandes de réservation</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Mettez à jour régulièrement vos disponibilités</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <i class="fas fa-check-circle mt-1"></i>
                            <span>Maintenez une note élevée pour plus de visibilité</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4">
                        <i class="fas fa-headset text-accent mr-2"></i> Besoin d'aide ?
                    </h2>
                    <p class="text-gray-600 text-sm mb-4">
                        Notre équipe est là pour vous accompagner
                    </p>
                    <a href="#" class="block w-full text-center border-2 border-accent text-accent py-2 rounded-lg hover:bg-accent hover:text-white transition">
                        <i class="fas fa-envelope mr-2"></i> Nous contacter
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection