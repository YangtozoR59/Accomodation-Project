@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-calendar-alt"></i> Réservation #{{ $reservation->id }}
            </h1>
            <p class="text-white/90 text-lg flex items-center gap-2">
                <i class="fas fa-home"></i> {{ $reservation->accommodation->title }}
            </p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200 py-4 shadow-sm relative z-30">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-500 font-medium">
            <a href="{{ route('owner.accommodations.index') }}" class="hover:text-primary transition flex items-center gap-1">
                <i class="fas fa-chart-pie"></i> Dashboard
            </a>
            <span class="mx-2 text-gray-300">/</span>
            <a href="{{ route('owner.reservations.index') }}" class="hover:text-primary transition flex items-center gap-1">
                <i class="fas fa-list"></i> Réservations
            </a>
            <span class="mx-2 text-gray-300">/</span>
            <span class="text-primary font-bold">#{{ $reservation->id }}</span>
        </nav>
    </div>
</div>

<!-- Contenu -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            
            <!-- Statut et actions rapides -->
            <div class="glass-card bg-white rounded-3xl p-6 md:p-8 mb-8 animate-fade-in shadow-sm border border-white/60">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <h2 class="text-2xl font-bold text-dark mb-3">Statut</h2>
                        <span class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold uppercase tracking-wide
                            {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                               ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                               ($reservation->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
                            @if($reservation->status === 'confirmed')
                                <i class="fas fa-check-circle"></i> Confirmée
                            @elseif($reservation->status === 'pending')
                                <i class="fas fa-clock"></i> En attente de confirmation
                            @elseif($reservation->status === 'completed')
                                <i class="fas fa-check-double"></i> Séjour terminé
                            @else
                                <i class="fas fa-times-circle"></i> Annulée
                            @endif
                        </span>
                        <p class="text-sm text-gray-500 mt-3 font-medium">
                            <i class="fas fa-calendar-plus mr-1"></i> Réservée le {{ $reservation->created_at->format('d/m/Y à H:i') }}
                        </p>
                    </div>
                    
                    <div class="flex flex-wrap gap-3 w-full md:w-auto">
                        @if($reservation->status === 'pending')
                            <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full md:w-auto px-8 py-3.5 btn-secondary text-white rounded-xl font-bold shadow-lg shadow-secondary/30 hover:shadow-secondary/50 hover-lift flex items-center justify-center gap-2">
                                    <i class="fas fa-check"></i> Confirmer
                                </button>
                            </form>
                        @endif
                        
                        @if($reservation->status === 'confirmed')
                            <form action="{{ route('reservations.complete', $reservation) }}" method="POST" class="w-full md:w-auto">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="w-full md:w-auto px-8 py-3.5 bg-blue-500 text-white rounded-xl font-bold shadow-lg shadow-blue-500/30 hover:bg-blue-600 hover:shadow-blue-500/50 hover-lift flex items-center justify-center gap-2">
                                    <i class="fas fa-check-double"></i> Marquer terminée
                                </button>
                            </form>
                        @endif
                        
                        <a href="mailto:{{ $reservation->user->email }}" class="w-full md:w-auto px-6 py-3.5 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-gray-200 transition flex items-center justify-center gap-2">
                            <i class="fas fa-envelope"></i> Contacter
                        </a>
                    </div>
                </div>
            </div>
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Colonne principale -->
                <div class="lg:col-span-2 space-y-8">
                    
                    <!-- Informations client -->
                    <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                        <h2 class="text-xl font-bold text-dark mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                                <i class="fas fa-user"></i>
                            </div>
                            Informations du client
                        </h2>
                        
                        <div class="flex items-center gap-6 p-6 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-2xl font-bold flex-shrink-0 shadow-md">
                                {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-bold text-dark mb-1">{{ $reservation->user->name }}</h3>
                                
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2 text-gray-600 text-sm">
                                        <i class="fas fa-envelope text-gray-400 w-4"></i>
                                        <a href="mailto:{{ $reservation->user->email }}" class="hover:text-primary transition truncate">
                                            {{ $reservation->user->email }}
                                        </a>
                                    </div>
                                    
                                    @if($reservation->user->phone)
                                        <div class="flex items-center gap-2 text-gray-600 text-sm">
                                            <i class="fas fa-phone text-gray-400 w-4"></i>
                                            <a href="tel:{{ $reservation->user->phone }}" class="hover:text-primary transition">
                                                {{ $reservation->user->phone }}
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <div class="flex items-center gap-2 text-gray-500 text-xs font-medium pt-1">
                                        <i class="fas fa-calendar-alt text-gray-300 w-4"></i>
                                        Membre depuis {{ $reservation->user->created_at->format('M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Détails de la réservation -->
                    <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                        <h2 class="text-xl font-bold text-dark mb-6 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Détails du séjour
                        </h2>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                            <!-- Dates -->
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-2">Arrivée</p>
                                <p class="text-lg font-bold text-dark flex items-center gap-2">
                                    <i class="fas fa-calendar-check text-green-500"></i>
                                    {{ $reservation->check_in->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1 pl-6">{{ $reservation->check_in->translatedFormat('l') }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-2">Départ</p>
                                <p class="text-lg font-bold text-dark flex items-center gap-2">
                                    <i class="fas fa-calendar-times text-red-500"></i>
                                    {{ $reservation->check_out->format('d/m/Y') }}
                                </p>
                                <p class="text-sm text-gray-500 mt-1 pl-6">{{ $reservation->check_out->translatedFormat('l') }}</p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-2">Durée</p>
                                <p class="text-lg font-bold text-dark flex items-center gap-2">
                                    <i class="fas fa-moon text-indigo-500"></i>
                                    {{ $reservation->nb_nights }} nuit(s)
                                </p>
                            </div>
                            
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-100">
                                <p class="text-xs text-gray-500 font-bold uppercase mb-2">Invités</p>
                                <p class="text-lg font-bold text-dark flex items-center gap-2">
                                    <i class="fas fa-users text-orange-500"></i>
                                    {{ $reservation->nb_guests }} personne(s)
                                </p>
                            </div>
                        </div>
                        
                        <!-- Demandes spéciales -->
                        @if($reservation->special_requests)
                            <div class="mt-6 bg-yellow-50 rounded-2xl p-5 border border-yellow-100">
                                <p class="text-sm font-bold text-yellow-800 mb-2 flex items-center gap-2">
                                    <i class="fas fa-comment text-yellow-500"></i> Demandes spéciales
                                </p>
                                <p class="text-gray-700 italic">{{ $reservation->special_requests }}</p>
                            </div>
                        @endif
                        
                        <!-- Raison annulation -->
                        @if($reservation->status === 'cancelled' && $reservation->cancellation_reason)
                            <div class="mt-6 bg-red-50 rounded-2xl p-5 border border-red-100">
                                <p class="text-sm font-bold text-red-800 mb-2 flex items-center gap-2">
                                    <i class="fas fa-exclamation-triangle text-red-500"></i> Raison de l'annulation
                                </p>
                                <p class="text-gray-700 italic">{{ $reservation->cancellation_reason }}</p>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Colonne latérale -->
                <div class="space-y-8">
                    
                    <!-- Hébergement -->
                    <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in shadow-sm border border-white/60">
                        <h2 class="text-lg font-bold text-dark mb-4 flex items-center gap-2">
                            <i class="fas fa-home text-gray-400"></i> Hébergement
                        </h2>
                        
                        <div class="relative h-48 rounded-2xl overflow-hidden bg-gray-200 mb-4 shadow-md">
                            @if($reservation->accommodation->primary_image)
                                <img src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                     alt="{{ $reservation->accommodation->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                    <i class="fas fa-image text-4xl"></i>
                                </div>
                            @endif
                        </div>
                        
                        <h3 class="font-bold text-dark mb-2 text-lg leading-tight">{{ $reservation->accommodation->title }}</h3>
                        
                        <p class="text-gray-500 text-sm mb-4 flex items-start gap-2">
                            <i class="fas fa-map-marker-alt text-secondary mt-1"></i>
                            <span>{{ $reservation->accommodation->address }}, {{ $reservation->accommodation->quartier }}</span>
                        </p>
                        
                        <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                           target="_blank"
                           class="block w-full py-3 border border-gray-200 text-gray-600 font-bold rounded-xl text-center hover:bg-gray-50 hover:text-dark transition">
                            <i class="fas fa-external-link-alt mr-2 text-sm"></i> Voir l'annonce
                        </a>
                    </div>
                    
                    <!-- Récapitulatif financier -->
                    <div class="glass-card bg-white rounded-3xl p-6 animate-fade-in shadow-sm border border-white/60">
                        <h2 class="text-lg font-bold text-dark mb-4 flex items-center gap-2">
                            <i class="fas fa-receipt text-gray-400"></i> Paiement
                        </h2>
                        
                        <div class="space-y-3 mb-6 pb-6 border-b border-gray-100 text-sm">
                            <div class="flex justify-between text-gray-600">
                                <span>Prix par nuit</span>
                                <span class="font-bold text-dark">{{ number_format($reservation->accommodation->price_per_night, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-gray-600">
                                <span>Nombre de nuits</span>
                                <span class="font-bold text-dark">× {{ $reservation->nb_nights }}</span>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-lg font-bold text-dark">Total</span>
                            <span class="text-2xl font-bold text-primary">
                                {{ number_format($reservation->total_price, 0, ',', ' ') }} <span class="text-xs text-gray-400 font-medium align-top">FCFA</span>
                            </span>
                        </div>
                        
                        @if(in_array($reservation->status, ['confirmed', 'completed']))
                            <div class="mt-4 p-3 bg-green-50 rounded-xl text-xs font-bold text-green-700 flex items-center gap-2">
                                <i class="fas fa-check-circle"></i> Paiement garanti
                            </div>
                        @else
                            <div class="mt-4 p-3 bg-gray-50 rounded-xl text-xs font-bold text-gray-500 flex items-center gap-2">
                                <i class="fas fa-clock"></i> En attente de validation
                            </div>
                        @endif
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
</section>

@endsection