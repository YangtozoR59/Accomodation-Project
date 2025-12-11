@extends('layouts.app')

@section('title', 'Détails de la réservation')

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('dashboard') }}" class="hover:text-accent transition">Dashboard</a>
            <span class="mx-2">/</span>
            <a href="{{ route('reservations.index') }}" class="hover:text-accent transition">Mes réservations</a>
            <span class="mx-2">/</span>
            <span class="text-dark">Réservation #{{ $reservation->id }}</span>
        </nav>
    </div>
</div>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <!-- En-tête -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h1 class="text-3xl font-bold text-dark mb-2">Réservation #{{ $reservation->id }}</h1>
                        <p class="text-gray-600">Créée le {{ $reservation->created_at->format('d/m/Y à H:i') }}</p>
                    </div>
                    
                    <span class="px-4 py-2 rounded-full text-sm font-semibold
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
                </div>
            </div>
            
            <!-- Informations de l'hébergement -->
            <div class="bg-white rounded-xl shadow-lg overflow-hidden mb-6 fade-in">
                <div class="md:flex">
                    <!-- Image -->
                    <div class="md:w-2/5 h-64 md:h-auto bg-gray-200">
                        @if($reservation->accommodation->primary_image)
                            <img 
                                src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                alt="{{ $reservation->accommodation->title }}"
                                class="w-full h-full object-cover"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-6xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Infos -->
                    <div class="md:w-3/5 p-6">
                        <h2 class="text-2xl font-bold text-dark mb-3">{{ $reservation->accommodation->title }}</h2>
                        
                        <p class="text-gray-600 mb-4">
                            <i class="fas fa-map-marker-alt text-accent mr-2"></i>
                            {{ $reservation->accommodation->address }}, {{ $reservation->accommodation->quartier }}
                        </p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4">
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-primary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-bed text-accent"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Chambres</p>
                                    <p class="font-semibold text-dark">{{ $reservation->accommodation->nb_rooms }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-2">
                                <div class="w-10 h-10 bg-secondary/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-users text-accent"></i>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Capacité</p>
                                    <p class="font-semibold text-dark">{{ $reservation->accommodation->max_guests }} pers.</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                           class="inline-block px-6 py-2 border border-accent text-accent rounded-lg hover:bg-accent hover:text-white transition">
                            <i class="fas fa-home mr-2"></i> Voir l'hébergement
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Détails de la réservation -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-xl font-bold text-dark mb-4">
                    <i class="fas fa-info-circle text-accent mr-2"></i> Détails de la réservation
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
                    
                    <!-- Durée et invités -->
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
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm font-semibold text-dark mb-2">
                            <i class="fas fa-comment text-blue-500 mr-2"></i> Demandes spéciales
                        </p>
                        <p class="text-gray-700">{{ $reservation->special_requests }}</p>
                    </div>
                @endif
                
                <!-- Raison annulation -->
                @if($reservation->status === 'cancelled' && $reservation->cancellation_reason)
                    <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                        <p class="text-sm font-semibold text-dark mb-2">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Raison de l'annulation
                        </p>
                        <p class="text-gray-700">{{ $reservation->cancellation_reason }}</p>
                    </div>
                @endif
            </div>
            
            <!-- Récapitulatif financier -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-xl font-bold text-dark mb-4">
                    <i class="fas fa-money-bill-wave text-accent mr-2"></i> Récapitulatif financier
                </h2>
                
                <div class="space-y-3 mb-4">
                    <div class="flex justify-between text-gray-700">
                        <span>{{ number_format($reservation->accommodation->price_per_night, 0, ',', ' ') }} FCFA x {{ $reservation->nb_nights }} nuit(s)</span>
                        <span>{{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA</span>
                    </div>
                </div>
                
                <hr class="my-4">
                
                <div class="flex justify-between items-center">
                    <span class="text-xl font-bold text-dark">Total</span>
                    <span class="text-3xl font-bold text-accent">
                        {{ number_format($reservation->total_price, 0, ',', ' ') }} FCFA
                    </span>
                </div>
            </div>
            
            <!-- Contact propriétaire -->
            <div class="bg-white rounded-xl shadow-lg p-6 mb-6 fade-in">
                <h2 class="text-xl font-bold text-dark mb-4">
                    <i class="fas fa-user-tie text-accent mr-2"></i> Propriétaire
                </h2>
                
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-accent rounded-full flex items-center justify-center text-white text-2xl font-bold">
                        {{ strtoupper(substr($reservation->accommodation->owner->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-dark text-lg">{{ $reservation->accommodation->owner->name }}</p>
                        @if($reservation->accommodation->owner->phone)
                            <p class="text-gray-600">
                                <i class="fas fa-phone mr-1"></i> {{ $reservation->accommodation->owner->phone }}
                            </p>
                        @endif
                    </div>
                    
                    @if($reservation->accommodation->owner->phone)
                        <a href="tel:{{ $reservation->accommodation->owner->phone }}" 
                           class="px-6 py-2 bg-accent text-white rounded-lg hover:bg-dark transition">
                            <i class="fas fa-phone mr-2"></i> Appeler
                        </a>
                    @endif
                </div>
            </div>
            
            <!-- Actions -->
            @if(in_array($reservation->status, ['pending', 'confirmed']))
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-xl font-bold text-dark mb-4">Actions</h2>
                    
                    <div class="flex gap-3">
                        <button 
                            onclick="if(confirm('Êtes-vous sûr de vouloir annuler cette réservation ?')) window.location.href='#cancel-modal'"
                            class="px-6 py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                            <i class="fas fa-times mr-2"></i> Annuler la réservation
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>

@endsection