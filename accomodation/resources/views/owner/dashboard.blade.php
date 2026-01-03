@extends('layouts.app')

@section('title', 'Espace Propriétaire')

@section('content')

<!-- Header avec Glassmorphisme -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-10 w-96 h-96 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-10 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
        <div class="absolute top-1/2 left-1/2 w-64 h-64 bg-white/5 rounded-full blur-3xl animate-float" style="animation-delay: 6s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                    <i class="fas fa-building"></i> Espace Propriétaire
                </h1>
                <p class="text-white/90 text-lg">Gérez vos hébergements et réservations</p>
            </div>
            
            <a href="{{ route('owner.accommodations.create') }}" 
               class="hidden md:flex bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-2xl font-bold items-center gap-2 animate-fade-in hover:bg-white/30 hover:scale-105 transition-all shadow-lg">
                <i class="fas fa-plus text-xl"></i>
                <span>Ajouter un hébergement</span>
            </a>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/80 backdrop-blur-md p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('owner.accommodations.index') }}" 
               class="px-6 py-3 rounded-xl bg-primary text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-primary/30">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
            <a href="{{ route('owner.accommodations.index', ['list' => 1]) }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-building"></i> Mes hébergements
            </a>
            <a href="{{ route('owner.reservations.index') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-calendar-alt"></i> Réservations
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="pb-16 pt-4">
    <div class="container mx-auto px-4">
        
        <!-- Statistiques -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
            <!-- Total hébergements -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in group">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">Mes hébergements</p>
                        <h3 class="text-4xl font-bold text-dark group-hover:text-primary transition-colors">{{ $stats['total_accommodations'] ?? 0 }}</h3>
                    </div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 bg-primary/10 text-primary">
                        <i class="fas fa-building text-3xl"></i>
                    </div>
                </div>
                <div class="bg-green-50 border border-green-100 px-3 py-2 rounded-xl text-sm font-semibold text-green-700 inline-flex items-center gap-2">
                    <i class="fas fa-check-circle text-green-500"></i>
                    <span>{{ $stats['verified_accommodations'] ?? 0 }} vérifiés</span>
                </div>
            </div>
            
            <!-- Réservations du mois -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in group" style="animation-delay: 0.1s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">Réservations ce mois</p>
                        <h3 class="text-4xl font-bold text-dark group-hover:text-secondary transition-colors">{{ $stats['month_reservations'] ?? 0 }}</h3>
                    </div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 bg-secondary/10 text-secondary">
                        <i class="fas fa-calendar-check text-3xl"></i>
                    </div>
                </div>
                <div class="bg-yellow-50 border border-yellow-100 px-3 py-2 rounded-xl text-sm font-semibold text-yellow-700 inline-flex items-center gap-2">
                    <i class="fas fa-clock text-yellow-500"></i>
                    <span>{{ $stats['pending_reservations'] ?? 0 }} en attente</span>
                </div>
            </div>
            
            <!-- Revenus du mois -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in group" style="animation-delay: 0.2s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">Revenus ce mois</p>
                        <h3 class="text-3xl font-bold text-dark group-hover:text-primary transition-colors">{{ number_format($stats['month_revenue'] ?? 0, 0, ',', ' ') }}</h3>
                        <p class="text-gray-400 text-xs font-bold mt-1">FCFA</p>
                    </div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 bg-primary/10 text-primary">
                        <i class="fas fa-money-bill-wave text-3xl"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-chart-line text-green-500"></i>
                    <span>Total: {{ number_format($stats['total_revenue'] ?? 0, 0, ',', ' ') }} FCFA</span>
                </div>
            </div>
            
            <!-- Note moyenne -->
            <div class="glass-card bg-white rounded-3xl p-8 hover-lift animate-fade-in group" style="animation-delay: 0.3s">
                <div class="flex justify-between items-start mb-6">
                    <div class="flex-1">
                        <p class="text-gray-500 text-sm font-bold uppercase mb-2">Note moyenne</p>
                        <h3 class="text-4xl font-bold text-dark group-hover:text-yellow-500 transition-colors">{{ number_format($stats['average_rating'] ?? 0, 1) }}</h3>
                    </div>
                    <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 bg-yellow-100 text-yellow-500">
                        <i class="fas fa-star text-3xl"></i>
                    </div>
                </div>
                <div class="text-sm text-gray-600 font-medium flex items-center gap-2">
                    <i class="fas fa-comment text-secondary"></i>
                    <span>{{ $stats['total_reviews'] ?? 0 }} avis</span>
                </div>
            </div>
        </div>
        
        <!-- Contenu en 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche -->
            <div class="lg:col-span-2 space-y-8">
                
                <!-- Réservations récentes -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-2xl md:text-3xl font-bold text-dark flex items-center gap-3">
                            <i class="fas fa-bell text-secondary"></i> Nouvelles réservations
                        </h2>
                        <a href="{{ route('owner.reservations.index') }}" 
                           class="text-secondary hover:text-primary transition font-bold flex items-center gap-2 group">
                            <span>Voir tout</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                    </div>
                    
                    @if(isset($recentReservations) && $recentReservations->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentReservations as $reservation)
                                <div class="bg-gray-50 rounded-2xl p-5 hover:bg-white hover:shadow-lg transition-all border border-gray-100">
                                    <div class="flex flex-col md:flex-row justify-between items-start gap-4 mb-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                                                       ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700') }}">
                                                    @if($reservation->status === 'confirmed')
                                                        <i class="fas fa-check-circle mr-1"></i> Confirmée
                                                    @elseif($reservation->status === 'pending')
                                                        <i class="fas fa-clock mr-1"></i> En attente
                                                    @else
                                                        {{ ucfirst($reservation->status) }}
                                                    @endif
                                                </span>
                                                <span class="text-xs text-gray-400 font-medium">
                                                    {{ $reservation->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            
                                            <h3 class="font-bold text-dark mb-2 text-lg hover:text-primary transition cursor-pointer">
                                                {{ $reservation->accommodation->title }}
                                            </h3>
                                            
                                            <p class="text-sm text-gray-600 mb-2 flex items-center gap-2">
                                                <i class="fas fa-user text-secondary"></i>
                                                <span class="font-bold text-dark">{{ $reservation->user->name }}</span>
                                                <span class="text-gray-300">•</span>
                                                <span>{{ $reservation->nb_guests }} invité(s)</span>
                                            </p>
                                            
                                            <p class="text-sm text-gray-600 flex items-center gap-2">
                                                <i class="fas fa-calendar text-secondary"></i>
                                                <span class="font-medium">{{ $reservation->check_in->format('d/m') }} → {{ $reservation->check_out->format('d/m/Y') }}</span>
                                            </p>
                                        </div>
                                        
                                        <div class="text-left md:text-right">
                                            <p class="text-2xl font-bold text-primary">
                                                {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                            </p>
                                            <p class="text-xs text-gray-400 font-bold uppercase">FCFA</p>
                                        </div>
                                    </div>
                                    
                                    <div class="flex gap-3 pt-3 border-t border-gray-100">
                                        <a href="{{ route('owner.reservations.show', $reservation) }}" 
                                           class="flex-1 text-center py-2.5 rounded-xl border border-gray-200 text-gray-700 font-semibold hover:bg-gray-50 transition flex items-center justify-center gap-2">
                                            <i class="fas fa-eye"></i>
                                            <span>Détails</span>
                                        </a>
                                        
                                        @if($reservation->status === 'pending')
                                            <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="flex-1">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="w-full btn-secondary text-white px-4 py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 shadow-lg shadow-secondary/20 hover:shadow-xl hover:-translate-y-0.5 transition-all">
                                                    <i class="fas fa-check"></i>
                                                    <span>Confirmer</span>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-16 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                            <div class="w-20 h-20 mx-auto mb-6 rounded-3xl flex items-center justify-center bg-white shadow-sm">
                                <i class="fas fa-inbox text-4xl text-gray-300"></i>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Aucune nouvelle réservation</h3>
                            <p class="text-gray-500">Les nouvelles demandes apparaîtront ici</p>
                        </div>
                    @endif
                </div>
                
                <!-- Performances des hébergements -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm">
                    <h2 class="text-2xl md:text-3xl font-bold text-dark mb-6 flex items-center gap-3">
                        <i class="fas fa-chart-bar text-secondary"></i> Performances
                    </h2>
                    
                    @if(isset($topAccommodations) && $topAccommodations->count() > 0)
                        <div class="space-y-4">
                            @foreach($topAccommodations as $accommodation)
                                <div class="flex items-center gap-4 bg-gray-50 p-4 rounded-2xl hover:bg-white hover:shadow-md transition-all border border-gray-100 group">
                                    <div class="w-20 h-20 rounded-2xl flex-shrink-0 overflow-hidden bg-gray-200">
                                        @if($accommodation->primary_image)
                                            <img src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                                 alt="{{ $accommodation->title }}"
                                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <i class="fas fa-image text-2xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-dark line-clamp-1 mb-2 group-hover:text-primary transition-colors">{{ $accommodation->title }}</h3>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                            <span class="flex items-center gap-1.5 bg-white px-2 py-1 rounded-lg border border-gray-200 shadow-sm">
                                                <i class="fas fa-calendar-check text-secondary"></i>
                                                <span class="font-bold">{{ $accommodation->reservations_count ?? 0 }}</span>
                                            </span>
                                            <span class="flex items-center gap-1.5 bg-white px-2 py-1 rounded-lg border border-gray-200 shadow-sm">
                                                <i class="fas fa-eye text-primary"></i>
                                                <span class="font-bold">{{ $accommodation->views_count }}</span>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    @if($accommodation->reviews_count > 0)
                                        <div class="text-right flex-shrink-0">
                                            <div class="bg-yellow-100 text-yellow-700 px-3 py-1.5 rounded-xl inline-flex items-center gap-1.5 font-bold shadow-sm">
                                                <i class="fas fa-star text-yellow-500"></i>
                                                <span>{{ number_format($accommodation->average_rating, 1) }}</span>
                                            </div>
                                            <p class="text-xs text-gray-500 mt-1 font-medium">{{ $accommodation->reviews_count }} avis</p>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-3xl border border-dashed border-gray-200">
                            <div class="w-16 h-16 mx-auto mb-4 rounded-3xl flex items-center justify-center bg-white shadow-sm">
                                <i class="fas fa-chart-line text-3xl text-gray-300"></i>
                            </div>
                            <p class="text-gray-500 font-medium">Aucune donnée disponible</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite -->
            <div class="space-y-6">
                
                <!-- Actions rapides -->
                <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in shadow-sm">
                    <h2 class="text-xl font-bold text-dark mb-6 flex items-center gap-2">
                        <i class="fas fa-bolt text-secondary"></i> Actions rapides
                    </h2>
                    
                    <div class="space-y-3">
                        <a href="{{ route('owner.accommodations.create') }}" 
                           class="btn-primary flex items-center gap-3 p-4 text-white rounded-2xl hover-lift shadow-lg shadow-primary/30 group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-white/20 backdrop-blur-sm">
                                <i class="fas fa-plus text-white"></i>
                            </div>
                            <span class="font-bold">Ajouter un hébergement</span>
                        </a>
                        
                        <a href="{{ route('owner.accommodations.index', ['list' => 1]) }}" 
                           class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 hover:border-primary hover:bg-primary/5 transition-all group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-colors">
                                <i class="fas fa-edit"></i>
                            </div>
                            <span class="font-semibold text-dark group-hover:text-primary">Gérer mes hébergements</span>
                        </a>
                        
                        <a href="{{ route('owner.reservations.index') }}" 
                           class="flex items-center gap-3 p-4 rounded-2xl border border-gray-200 hover:border-secondary hover:bg-secondary/5 transition-all group">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 bg-secondary/10 text-secondary group-hover:bg-secondary group-hover:text-white transition-colors">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                            <span class="font-semibold text-dark group-hover:text-secondary">Voir les réservations</span>
                        </a>
                    </div>
                </div>
                
                <!-- Conseils -->
                <div class="glass-card bg-gradient-to-br from-indigo-50 to-purple-50 rounded-3xl p-6 animate-fade-in border border-indigo-100">
                    <div class="mb-6 text-center">
                        <div class="w-14 h-14 mx-auto mb-4 rounded-2xl flex items-center justify-center bg-white shadow-md text-indigo-500">
                            <i class="fas fa-lightbulb text-2xl"></i>
                        </div>
                        <h2 class="text-xl font-bold text-indigo-900">Conseils pour réussir</h2>
                    </div>
                    
                    <ul class="space-y-3 text-sm">
                        <li class="flex items-start gap-3 bg-white/60 p-3 rounded-xl border border-white">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Ajoutez des photos de qualité HD</span>
                        </li>
                        <li class="flex items-start gap-3 bg-white/60 p-3 rounded-xl border border-white">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Répondez en moins d'une heure</span>
                        </li>
                        <li class="flex items-start gap-3 bg-white/60 p-3 rounded-xl border border-white">
                            <i class="fas fa-check-circle text-green-500 mt-0.5 flex-shrink-0"></i>
                            <span class="text-gray-700 font-medium">Mettez à jour votre calendrier</span>
                        </li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in shadow-sm">
                    <div class="text-center mb-4">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-full flex items-center justify-center bg-gray-100 text-gray-500">
                            <i class="fas fa-headset text-xl"></i>
                        </div>
                        <h3 class="font-bold text-dark">Besoin d'aide ?</h3>
                    </div>
                    <a href="#" class="btn-secondary block w-full text-center text-white py-3 rounded-xl font-bold hover-lift shadow-md shadow-secondary/20 flex items-center justify-center gap-2">
                        <i class="fas fa-envelope"></i>
                        <span>Nous contacter</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection