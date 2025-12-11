@extends('layouts.app')

@section('title', 'Réservations reçues')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-calendar-alt mr-2"></i> Réservations reçues
        </h1>
        <p class="text-white/90 mt-2">Gérez toutes les réservations de vos hébergements</p>
    </div>
</section>

<!-- Navigation -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('owner.accommodations.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-home mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('owner.accommodations.index', ['list' => 1]) }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Mes hébergements
            </a>
            <a href="{{ route('owner.reservations.index') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-calendar-alt mr-2"></i> Réservations
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Filtres -->
        <div class="bg-white rounded-xl shadow-md p-4 mb-8 fade-in">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('owner.reservations.index') }}" 
                   class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-accent text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-list mr-2"></i> Toutes
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-clock mr-2"></i> En attente
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'confirmed']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-check-circle mr-2"></i> Confirmées
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-check-double mr-2"></i> Terminées
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-times-circle mr-2"></i> Annulées
                </a>
            </div>
        </div>
        
        @if($reservations->count() > 0)
            <!-- Liste -->
            <div class="space-y-6">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Info hébergement -->
                            <div class="md:w-1/3">
                                <div class="relative h-48 rounded-lg overflow-hidden bg-gray-200 mb-3">
                                    @if($reservation->accommodation->primary_image)
                                        <img src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                             alt="{{ $reservation->accommodation->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-4xl text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                <h3 class="font-bold text-dark line-clamp-2">
                                    {{ $reservation->accommodation->title }}
                                </h3>
                            </div>
                            
                            <!-- Info réservation -->
                            <div class="md:w-2/3">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold
                                            {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                               ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                               ($reservation->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                            {{ $reservation->status === 'confirmed' ? 'Confirmée' : 
                                               ($reservation->status === 'pending' ? 'En attente' : 
                                               ($reservation->status === 'completed' ? 'Terminée' : 'Annulée')) }}
                                        </span>
                                        <p class="text-xs text-gray-500 mt-1">
                                            Réservation #{{ $reservation->id }} - {{ $reservation->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-accent">
                                            {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                        </p>
                                        <p class="text-sm text-gray-600">FCFA</p>
                                    </div>
                                </div>
                                
                                <!-- Client -->
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white text-lg font-bold">
                                            {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-dark">{{ $reservation->user->name }}</p>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-envelope mr-1"></i> {{ $reservation->user->email }}
                                            </p>
                                            @if($reservation->user->phone)
                                                <p class="text-sm text-gray-600">
                                                    <i class="fas fa-phone mr-1"></i> {{ $reservation->user->phone }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Dates -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Arrivée</p>
                                        <p class="font-semibold text-dark">{{ $reservation->check_in->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Départ</p>
                                        <p class="font-semibold text-dark">{{ $reservation->check_out->format('d/m/Y') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Durée</p>
                                        <p class="font-semibold text-dark">{{ $reservation->nb_nights }} nuit(s)</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Invités</p>
                                        <p class="font-semibold text-dark">{{ $reservation->nb_guests }}</p>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('owner.reservations.show', $reservation) }}" 
                                       class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-dark transition">
                                        <i class="fas fa-eye mr-2"></i> Détails
                                    </a>
                                    
                                    @if($reservation->status === 'pending')
                                        <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition">
                                                <i class="fas fa-check mr-2"></i> Confirmer
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($reservation->status === 'confirmed')
                                        <form action="{{ route('reservations.complete', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition">
                                                <i class="fas fa-check-double mr-2"></i> Marquer terminée
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $reservations->links() }}
            </div>
        @else
            <!-- Aucune réservation -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center fade-in">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucune réservation</h3>
                <p class="text-gray-600">Vous n'avez pas encore reçu de réservation</p>
            </div>
        @endif
    </div>
</section>

@endsection