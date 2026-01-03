@extends('layouts.app')

@section('title', 'Mes réservations')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-secondary py-12 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-48 h-48 bg-black/10 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <h1 class="text-4xl font-bold text-white animate-fade-in flex items-center gap-3">
            <i class="fas fa-calendar-check"></i> Mes réservations
        </h1>
        <p class="text-white/90 mt-2 text-lg">Gérez toutes vos réservations en un seul endroit</p>
    </div>
</section>

<!-- Navigation du dashboard -->
<section class="sticky top-16 z-40 mb-8">
    <div class="glass-card bg-white/80 backdrop-blur-md border-b border-white/20">
        <div class="container mx-auto px-4">
            <div class="flex gap-1 overflow-x-auto no-scrollbar">
                <a href="{{ route('dashboard') }}" class="py-4 px-6 text-gray-600 hover:text-primary transition font-medium whitespace-nowrap flex items-center gap-2 border-b-2 border-transparent hover:border-primary/30">
                    <i class="fas fa-home"></i> Aperçu
                </a>
                <a href="{{ route('reservations.index') }}" class="py-4 px-6 text-primary font-bold whitespace-nowrap flex items-center gap-2 border-b-2 border-primary bg-primary/5">
                    <i class="fas fa-calendar-check"></i> Mes réservations
                </a>
                <a href="{{ route('profile.edit') }}" class="py-4 px-6 text-gray-600 hover:text-primary transition font-medium whitespace-nowrap flex items-center gap-2 border-b-2 border-transparent hover:border-primary/30">
                    <i class="fas fa-user"></i> Mon profil
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="pb-16 pt-4">
    <div class="container mx-auto px-4">
        
        <!-- Filtres -->
        <div class="glass-card bg-white rounded-2xl p-4 mb-8 animate-fade-in">
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('reservations.index') }}" 
                   class="px-4 py-2 rounded-xl border border-transparent {{ !request('status') ? 'bg-primary text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-gray-100' }} transition flex items-center gap-2 font-medium">
                    <i class="fas fa-list"></i> Toutes
                </a>
                <a href="{{ route('reservations.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2 rounded-xl border border-transparent {{ request('status') === 'pending' ? 'bg-yellow-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }} transition flex items-center gap-2 font-medium">
                    <i class="fas fa-clock"></i> En attente
                </a>
                <a href="{{ route('reservations.index', ['status' => 'confirmed']) }}" 
                   class="px-4 py-2 rounded-xl border border-transparent {{ request('status') === 'confirmed' ? 'bg-green-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-green-50 hover:text-green-600' }} transition flex items-center gap-2 font-medium">
                    <i class="fas fa-check-circle"></i> Confirmées
                </a>
                <a href="{{ route('reservations.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2 rounded-xl border border-transparent {{ request('status') === 'completed' ? 'bg-blue-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-blue-50 hover:text-blue-600' }} transition flex items-center gap-2 font-medium">
                    <i class="fas fa-check-double"></i> Terminées
                </a>
                <a href="{{ route('reservations.index', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2 rounded-xl border border-transparent {{ request('status') === 'cancelled' ? 'bg-red-500 text-white shadow-md' : 'bg-gray-50 text-gray-600 hover:bg-red-50 hover:text-red-600' }} transition flex items-center gap-2 font-medium">
                    <i class="fas fa-times-circle"></i> Annulées
                </a>
            </div>
        </div>
        
        @if($reservations->count() > 0)
            <!-- Liste des réservations -->
            <div class="space-y-6">
                @foreach($reservations as $reservation)
                    <div class="glass-card bg-white rounded-2xl overflow-hidden hover-lift animate-fade-in group border border-white/40">
                        <div class="md:flex">
                            <!-- Image -->
                            <div class="md:w-1/3 h-64 md:h-auto bg-gray-200 relative overflow-hidden">
                                @if($reservation->accommodation->primary_image)
                                    <img 
                                        src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                        alt="{{ $reservation->accommodation->title }}"
                                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-6xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-r from-black/20 to-transparent"></div>
                            </div>
                            
                            <!-- Contenu -->
                            <div class="md:w-2/3 p-6 flex flex-col justify-between">
                                <div>
                                    <div class="flex flex-col md:flex-row md:justify-between md:items-start mb-4 gap-4">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider
                                                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-700' : 
                                                       ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : 
                                                       ($reservation->status === 'completed' ? 'bg-blue-100 text-blue-700' : 'bg-red-100 text-red-700')) }}">
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
                                                
                                                <span class="text-xs text-gray-400 font-medium">
                                                    <i class="far fa-clock mr-1"></i> {{ $reservation->created_at->format('d/m/Y') }}
                                                </span>
                                            </div>
                                            
                                            <h3 class="text-2xl font-bold text-dark mb-2 group-hover:text-primary transition-colors">
                                                {{ $reservation->accommodation->title }}
                                            </h3>
                                            
                                            <p class="text-gray-500 mb-4 flex items-center text-sm">
                                                <i class="fas fa-map-marker-alt text-secondary mr-2"></i>
                                                {{ $reservation->accommodation->address }}, {{ $reservation->accommodation->quartier }}
                                            </p>
                                        </div>
                                        
                                        <div class="text-left md:text-right">
                                            <p class="text-3xl font-bold text-primary">
                                                {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                            </p>
                                            <p class="text-xs text-gray-400 uppercase tracking-wide font-semibold">Total FCFA</p>
                                        </div>
                                    </div>
                                    
                                    <!-- Dates et infos -->
                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 p-4 bg-gray-50 rounded-xl border border-gray-100">
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Arrivée</p>
                                            <p class="font-semibold text-dark text-sm">
                                                <i class="fas fa-calendar-alt mr-2 text-secondary"></i>
                                                {{ $reservation->check_in->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Départ</p>
                                            <p class="font-semibold text-dark text-sm">
                                                <i class="fas fa-calendar-check mr-2 text-secondary"></i>
                                                {{ $reservation->check_out->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Durée</p>
                                            <p class="font-semibold text-dark text-sm">
                                                <i class="fas fa-moon mr-2 text-secondary"></i>
                                                {{ $reservation->nb_nights }} nuit(s)
                                            </p>
                                        </div>
                                        <div>
                                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Invités</p>
                                            <p class="font-semibold text-dark text-sm">
                                                <i class="fas fa-users mr-2 text-secondary"></i>
                                                {{ $reservation->nb_guests }} pers.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap gap-3 mt-auto pt-4 border-t border-gray-100">
                                    <a href="{{ route('reservations.show', $reservation) }}" 
                                       class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold text-sm flex items-center gap-2">
                                        <i class="fas fa-eye"></i> Détails
                                    </a>
                                    
                                    <a href="{{ route('accommodations.show', $reservation->accommodation) }}" 
                                       class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold text-sm flex items-center gap-2">
                                        <i class="fas fa-external-link-alt"></i> Hébergement
                                    </a>
                                    
                                    @if(in_array($reservation->status, ['pending', 'confirmed']))
                                        <button 
                                            onclick="openCancelModal({{ $reservation->id }})"
                                            class="px-5 py-2.5 border border-red-200 text-red-600 bg-red-50 rounded-xl hover:bg-red-100 hover:border-red-300 transition font-semibold text-sm flex items-center gap-2 ml-auto">
                                            <i class="fas fa-times"></i> Annuler
                                        </button>
                                    @endif
                                    
                                    @if($reservation->status === 'completed' && !$reservation->reviews()->where('user_id', auth()->id())->exists())
                                        <button 
                                            onclick="openReviewModal({{ $reservation->id }}, {{ $reservation->accommodation->id }})"
                                            class="px-5 py-2.5 bg-yellow-400 text-white rounded-xl hover:bg-yellow-500 transition font-semibold text-sm flex items-center gap-2 ml-auto shadow-md shadow-yellow-200">
                                            <i class="fas fa-star"></i> Noter le séjour
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $reservations->links() }}
            </div>
        @else
            <!-- Aucune réservation -->
            <div class="glass-card bg-white rounded-3xl p-16 text-center animate-fade-in max-w-2xl mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-calendar-times text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">Aucune réservation trouvée</h3>
                <p class="text-gray-500 mb-8 max-w-md mx-auto">Vous n'avez pas encore effectué de réservation correspondant à ces critères.</p>
                <a href="{{ route('accommodations.index') }}" class="btn-primary text-white px-8 py-3.5 rounded-xl inline-flex items-center hover-lift shadow-lg font-bold">
                    <i class="fas fa-search mr-2"></i> Rechercher un hébergement
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modal Annulation -->
<div id="cancel-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="glass-card bg-white rounded-2xl max-w-md w-full p-8 animate-scale-in shadow-2xl relative">
        <button onclick="closeCancelModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-2xl text-red-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-dark">Annuler la réservation</h3>
            <p class="text-gray-500 mt-2">Cette action est irréversible. Êtes-vous sûr de vouloir continuer ?</p>
        </div>
        
        <form id="cancel-form" method="POST">
            @csrf
            @method('PATCH')
            
            <div class="mb-6">
                <label class="block text-sm font-bold text-gray-700 mb-2">
                    Motif de l'annulation <span class="text-red-500">*</span>
                </label>
                <textarea 
                    name="cancellation_reason" 
                    required
                    rows="3"
                    class="w-full px-4 py-3 input-glass bg-gray-50 rounded-xl focus:bg-white transition-all outline-none resize-none"
                    placeholder="Dites-nous pourquoi vous annulez..."
                ></textarea>
            </div>
            
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeCancelModal()"
                    class="flex-1 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition font-semibold">
                    Retour
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-3 bg-red-500 text-white rounded-xl hover:bg-red-600 transition font-semibold shadow-lg shadow-red-200 hover:shadow-xl">
                    Confirmer
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
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }
    
    function closeCancelModal() {
        document.getElementById('cancel-modal').classList.add('hidden');
        document.body.style.overflow = ''; // Restore scrolling
    }
    
    // Fermer avec Escape
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            closeCancelModal();
        }
    });
    
    // Fermer en cliquant en dehors
    document.getElementById('cancel-modal').addEventListener('click', function(e) {
        if(e.target === this) {
            closeCancelModal();
        }
    });
</script>
@endpush