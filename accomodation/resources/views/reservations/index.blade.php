@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-calendar-check mr-2"></i> Mes réservations
        </h1>
        <p class="text-white/90 mt-2">Gérez toutes vos réservations en un seul endroit</p>
    </div>
</section>

<!-- Navigation du dashboard -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-home mr-2"></i> Aperçu
            </a>
            <a href="{{ route('reservations.index') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-calendar-check mr-2"></i> Mes réservations
            </a>
            <a href="{{ route('profile.edit') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-user mr-2"></i> Mon profil
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
                <a href="{{ route('reservations.index') }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') ? 'bg-gray-100 text-gray-700' : 'bg-accent text-white' }} hover:opacity-80 transition">
                    <i class="fas fa-list mr-2"></i> Toutes
                </a>
                <a href="{{ route('reservations.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-clock mr-2"></i> En attente
                </a>
                <a href="{{ route('reservations.index', ['status' => 'confirmed']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'confirmed' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-check-circle mr-2"></i> Confirmées
                </a>
                <a href="{{ route('reservations.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'completed' ? 'bg-blue-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-check-double mr-2"></i> Terminées
                </a>
                <a href="{{ route('reservations.index', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2 rounded-lg {{ request('status') === 'cancelled' ? 'bg-red-500 text-white' : 'bg-gray-100 text-gray-700' }} hover:opacity-80 transition">
                    <i class="fas fa-times-circle mr-2"></i> Annulées
                </a>
            </div>
        </div>
        
        @if($reservations->count() > 0)
            <!-- Liste des réservations -->
            <div class="space-y-6">
                @foreach($reservations as $reservation)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift fade-in">
                        <div class="md:flex">
                            <!-- Image -->
                            <div class="md:w-1/3 h-64 md:h-auto bg-gray-200">
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
                            
                            <!-- Contenu -->
                            <div class="md:w-2/3 p-6">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                                   ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                   ($reservation->status === 'completed' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800')) }}">
                                                @if($reservation->status === 'confirmed')
                                                    <i class="fas fa-check-circle mr-1"></i> Confirmée
                                                @elseif($reservation->status === 'pending')
                                                    <i class="fas fa-clock mr-1"></i> En attente
                                                @elseif($reservation->status === 'completed')
                                                    <i class="fas fa-check-double mr-1"></i> Terminée
                                                @else
                                                    <i class="fas fa-times-circle mr-1"></i> Annulée
                                                @endif
                                            </span>
                                            
                                            <span class="text-xs text-gray-500">
                                                Réservée le {{ $reservation->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                        
                                        <h3 class="text-2xl font-bold text-dark mb-2">
                                            {{ $reservation->accommodation->title }}
                                        </h3>
                                        
                                        <p class="text-gray-600 mb-4">
                                            <i class="fas fa-map-marker-alt text-accent mr-1"></i>
                                            {{ $reservation->accommodation->address }}, {{ $reservation->accommodation->quartier }}
                                        </p>
                                    </div>
                                    
                                    <div class="text-right ml-4">
                                        <p class="text-3xl font-bold text-accent">
                                            {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                        </p>
                                        <p class="text-sm text-gray-600">FCFA</p>
                                    </div>
                                </div>
                                
                                <!-- Dates et infos -->
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Arrivée</p>
                                        <p class="font-semibold text-dark">
                                            <i class="fas fa-calendar mr-1 text-accent"></i>
                                            {{ $reservation->check_in->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Départ</p>
                                        <p class="font-semibold text-dark">
                                            <i class="fas fa-calendar mr-1 text-accent"></i>
                                            {{ $reservation->check_out->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Durée</p>
                                        <p class="font-semibold text-dark">
                                            <i class="fas fa-moon mr-1 text-accent"></i>
                                            {{ $reservation->nb_nights }} nuit(s)
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-500 mb-1">Invités</p>
                                        <p class="font-semibold text-dark">
                                            <i class="fas fa-users mr-1 text-accent"></i>
                                            {{ $reservation->nb_guests }} personne(s)
                                        </p>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('reservations.show', $reservation) }}" 
                                       class="px-4 py-2 bg-accent text-white rounded-lg hover:bg-dark transition">
                                        <i class="fas fa-eye mr-2"></i> Voir détails
                                    </a>
                                    
                                    <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                                       class="px-4 py-2 border border-accent text-accent rounded-lg hover:bg-accent hover:text-white transition">
                                        <i class="fas fa-home mr-2"></i> Voir l'hébergement
                                    </a>
                                    
                                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                                        <button 
                                            onclick="openCancelModal({{ $reservation->id }})"
                                            class="px-4 py-2 border border-red-500 text-red-500 rounded-lg hover:bg-red-500 hover:text-white transition">
                                            <i class="fas fa-times mr-2"></i> Annuler
                                        </button>
                                    @endif
                                    
                                    @if($reservation->status === 'completed' && !$reservation->reviews()->where('user_id', auth()->id())->exists())
                                        <button 
                                            onclick="openReviewModal({{ $reservation->id }}, {{ $reservation->accommodation->id }})"
                                            class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                                            <i class="fas fa-star mr-2"></i> Laisser un avis
                                        </button>
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
                <i class="fas fa-calendar-times text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucune réservation trouvée</h3>
                <p class="text-gray-600 mb-6">Vous n'avez pas encore effectué de réservation</p>
                <a href="{{ route('accommodations.index') }}" class="btn-primary text-white px-8 py-3 rounded-lg inline-block">
                    <i class="fas fa-search mr-2"></i> Rechercher un hébergement
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modal Annulation -->
<div id="cancel-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 fade-in">
        <h3 class="text-2xl font-bold text-dark mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Annuler la réservation
        </h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir annuler cette réservation ? Cette action est irréversible.</p>
        
        <form id="cancel-form" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Raison de l'annulation <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="cancellation_reason" 
                    required
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                    placeholder="Ex: Changement de plans, dates non disponibles..."
                ></textarea>
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeCancelModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Retour
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Confirmer l'annulation
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openCancelModal(reservationId) {
        const modal = document.getElementById('cancel-modal');
        const form = document.getElementById('cancel-form');
        form.action = `/reservations/${reservationId}/cancel`;
        modal.classList.remove('hidden');
    }
    
    function closeCancelModal() {
        document.getElementById('cancel-modal').classList.add('hidden');
    }
    
    // Fermer avec Escape
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            closeCancelModal();
        }
    });
</script>
@endpush