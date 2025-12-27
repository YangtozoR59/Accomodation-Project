@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-calendar-alt mr-2"></i> Réservation #{{ $reservation->id }}
        </h1>
        <p class="text-white/90 mt-2">{{ $reservation->accommodation->title }}</p>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('owner.accommodations.index') }}" class="hover:text-accent transition">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('owner.reservations.index') }}" class="hover:text-accent transition">Réservations</a>
            <span class="mx-2">/</span>
            <span class="text-dark">Réservation #{{ $reservation->id }}</span>
        </nav>
    </div>
</div>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-5xl mx-auto">
            
            <!-- Statut et actions rapides -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-dark mb-2">Statut de la réservation</h2>
                        <span class="inline-block px-4 py-2 rounded-full text-sm font-semibold
                            {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                               ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                               ($reservation->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                            @if($reservation->status === 'confirmed')
                                <i class="fas fa-check-circle mr-1"></i> Confirmée
                            @elseif($reservation->status === 'pending')
                                <i class="fas fa-clock mr-1"></i> En attente de confirmation
                            @elseif($reservation->status === 'completed')
                                <i class="fas fa-check-double mr-1"></i> Séjour terminé
                            @else
                                <i class="fas fa-times-circle mr-1"></i> Annulée
                            @endif
                        </span>
                        <p class="text-sm text-gray-600 mt-2">Réservée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <div class="flex gap-2">
                        @if($reservation->status === 'pending')
                            <form action="{{ route('reservations.confirm', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                    <i class="fas fa-check mr-2"></i> Confirmer
                                </button>
                            </form>
                        @endif
                        
                        @if($reservation->status === 'confirmed')
                            <form action="{{ route('reservations.complete', $reservation) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                    <i class="fas fa-check-double mr-2"></i> Marquer terminée
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Informations client -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-user text-accent mr-2"></i> Informations du client
                </h2>
                
                <div class="flex items-center gap-6 p-4 bg-gray-50 rounded-lg">
                    <div class="w-20 h-20 bg-accent rounded-full flex items-center justify-center text-white text-3xl font-bold flex-shrink-0">
                        {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                    </div>
                    
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-dark mb-2">{{ $reservation->user->name }}</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div class="flex items-center gap-2 text-gray-700">
                                <i class="fas fa-envelope text-accent"></i>
                                <a href="mailto:{{ $reservation->user->email }}" class="hover:text-accent transition">
                                    {{ $reservation->user->email }}
                                </a>
                            </div>
                            
                            @if($reservation->user->phone)
                                <div class="flex items-center gap-2 text-gray-700">
                                    <i class="fas fa-phone text-accent"></i>
                                    <a href="tel:{{ $reservation->user->phone }}" class="hover:text-accent transition">
                                        {{ $reservation->user->phone }}
                                    </a>
                                </div>
                            @endif
                        </div>
                        
                        <div class="mt-3 text-sm text-gray-600">
                            <i class="fas fa-calendar mr-1"></i>
                            Membre depuis {{ $reservation->user->created_at->format('M Y') }}
                        </div>
                    </div>
                    
                    @if($reservation->user->phone)
                        <div>
                            <a href="tel:{{ $reservation->user->phone }}" 
                               class="inline-block px-6 py-3 bg-accent text-white rounded-lg hover:bg-dark transition">
                                <i class="fas fa-phone mr-2"></i> Appeler
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Détails de la réservation -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-info-circle text-accent mr-2"></i> Détails de la réservation
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Dates -->
                    <div class="border-l-4 border-accent pl-4">
                        <p class="text-sm text-gray-500 mb-1">Date d'arrivée</p>
                        <p class="text-lg font-bold text-dark">
                            <i class="fas fa-calendar-check text-accent mr-2"></i>
                            {{ $reservation->check_in->format('d/m/Y') }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $reservation->check_in->translatedFormat('l') }}</p>
                    </div>
                    
                    <div class="border-l-4 border-accent pl-4">
                        <p class="text-sm text-gray-500 mb-1">Date de départ</p>
                        <p class="text-lg font-bold text-dark">
                            <i class="fas fa-calendar-times text-accent mr-2"></i>
                            {{ $reservation->check_out->format('d/m/Y') }}
                        </p>
                        <p class="text-sm text-gray-600">{{ $reservation->check_out->translatedFormat('l') }}</p>
                    </div>
                    
                    <div class="border-l-4 border-secondary pl-4">
                        <p class="text-sm text-gray-500 mb-1">Durée du séjour</p>
                        <p class="text-lg font-bold text-dark">
                            <i class="fas fa-moon text-secondary mr-2"></i>
                            {{ $reservation->nb_nights }} nuit(s)
                        </p>
                    </div>
                    
                    <div class="border-l-4 border-secondary pl-4">
                        <p class="text-sm text-gray-500 mb-1">Nombre d'invités</p>
                        <p class="text-lg font-bold text-dark">
                            <i class="fas fa-users text-secondary mr-2"></i>
                            {{ $reservation->nb_guests }} personne(s)
                        </p>
                    </div>
                </div>
                
                <!-- Demandes spéciales -->
                @if($reservation->special_requests)
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-dark mb-2">
                            <i class="fas fa-comment text-blue-500 mr-2"></i> Demandes spéciales
                        </p>
                        <p class="text-gray-700">{{ $reservation->special_requests }}</p>
                    </div>
                @endif
                
                <!-- Raison annulation -->
                @if($reservation->status === 'cancelled' && $reservation->cancellation_reason)
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-dark mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Raison de l'annulation
                        </p>
                        <p class="text-gray-700">{{ $reservation->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Informations de l'hébergement -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-home text-accent mr-2"></i> Hébergement concerné
                </h2>
                
                <div class="flex flex-col md:flex-row gap-6">
                    <!-- Image -->
                    <div class="md:w-1/3">
                        <div class="relative h-48 rounded-lg overflow-hidden bg-gray-200">
                            @if($reservation->accommodation->primary_image)
                                <img src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                     alt="{{ $reservation->accommodation->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-6xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Infos -->
                    <div class="md:w-2/3">
                        <h3 class="text-xl font-bold text-dark mb-2">{{ $reservation->accommodation->title }}</h3>
                        
                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt text-accent mr-1"></i>
                            {{ $reservation->accommodation->address }}, {{ $reservation->accommodation->quartier }}
                        </p>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <i class="fas fa-bed text-accent text-lg"></i>
                                <p class="text-xs text-gray-600 mt-1">{{ $reservation->accommodation->nb_beds }} lit(s)</p>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <i class="fas fa-door-open text-accent text-lg"></i>
                                <p class="text-xs text-gray-600 mt-1">{{ $reservation->accommodation->nb_rooms }} chambre(s)</p>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <i class="fas fa-bath text-accent text-lg"></i>
                                <p class="text-xs text-gray-600 mt-1">{{ $reservation->accommodation->nb_bathrooms }} salle(s)</p>
                            </div>
                            <div class="text-center p-2 bg-gray-50 rounded">
                                <i class="fas fa-users text-accent text-lg"></i>
                                <p class="text-xs text-gray-600 mt-1">Max {{ $reservation->accommodation->max_guests }}</p>
                            </div>
                        </div>
                        
                        <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                           target="_blank"
                           class="inline-block px-6 py-2 border border-accent text-accent rounded-lg hover:bg-accent hover:text-white transition">
                            <i class="fas fa-external-link-alt mr-2"></i> Voir l'hébergement
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Récapitulatif financier -->
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-money-bill-wave text-accent mr-2"></i> Récapitulatif financier
                </h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-700">
                        <span>Prix par nuit</span>
                        <span class="font-semibold">{{ number_format($reservation->accommodation->price_per_night, 0, ',', ' ') }} FCFA</span>
                    </div>
                    <div class="flex justify-between text-gray-700">
                        <span>Nombre de nuits</span>
                        <span class="font-semibold">× {{ $reservation->nb_nights }}</span>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-bold text-dark">Total</span>
                    <span class="text-4xl font-bold text-accent">
                        {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                    </span>
                </div>
                
                @if(in_array($reservation->status, ['confirmed', 'completed']))
                    <div class="mt-4 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <p class="text-sm text-green-700">
                            <i class="fas fa-check-circle mr-2"></i>
                            Ce montant sera crédité après le séjour
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection