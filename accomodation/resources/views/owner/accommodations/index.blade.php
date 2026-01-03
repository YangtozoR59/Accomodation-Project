@extends('layouts.app')

@section('title', 'Mes hébergements')

@section('content')

<!-- Si c'est la première visite, afficher le dashboard -->
@if(request()->routeIs('owner.accommodations.index') && !request()->has('list'))
    @include('owner.dashboard')
@else

<!-- Header avec Glassmorphisme -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                    <i class="fas fa-building"></i> Mes hébergements
                </h1>
                <p class="text-white/90 text-lg">Gérez tous vos hébergements en un seul endroit</p>
            </div>
            
            <a href="{{ route('owner.accommodations.create') }}" 
               class="bg-white/20 backdrop-blur-md border border-white/30 text-white px-8 py-4 rounded-2xl font-bold flex items-center justify-center gap-2 animate-fade-in hover:bg-white/30 hover:scale-105 transition-all shadow-lg">
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
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
            <a href="{{ route('owner.accommodations.index', ['list' => 1]) }}" 
               class="px-6 py-3 rounded-xl bg-primary text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-primary/30">
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
        
        @if($accommodations->count() > 0)
            <!-- Grille des hébergements -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($accommodations as $accommodation)
                    <div class="glass-card bg-white rounded-3xl overflow-hidden animate-fade-in group hover-lift flex flex-col h-full border border-white/40">
                        <!-- Image -->
                        <div class="relative h-56 bg-gray-200 overflow-hidden">
                            @php
                                $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                             ?? $accommodation->images->first();
                            @endphp
                            
                            @if($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                     alt="{{ $accommodation->title }}"
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                    <i class="fas fa-image text-4xl text-gray-300"></i>
                                </div>
                            @endif
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-60"></div>
                            
                            <!-- Badge catégorie -->
                            <div class="absolute top-4 left-4">
                                <div class="backdrop-blur-md bg-white/90 px-3 py-1.5 rounded-xl text-xs font-bold border border-white/20 flex items-center gap-2 shadow-sm text-gray-800">
                                    <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} text-secondary"></i>
                                    <span>{{ $accommodation->category->name }}</span>
                                </div>
                            </div>
                            
                            <!-- Badge vérification -->
                            <div class="absolute top-4 right-4">
                                @if($accommodation->is_verified)
                                    <div class="backdrop-blur-md bg-green-500/90 text-white px-3 py-1.5 rounded-xl text-xs font-bold border border-white/20 shadow-sm flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> Vérifié
                                    </div>
                                @else
                                    <div class="backdrop-blur-md bg-yellow-500/90 text-white px-3 py-1.5 rounded-xl text-xs font-bold border border-white/20 shadow-sm flex items-center gap-1">
                                        <i class="fas fa-clock"></i> En attente
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Badge disponibilité -->
                            <div class="absolute bottom-4 left-4">
                                @if($accommodation->is_available)
                                    <div class="bg-green-100/90 backdrop-blur-sm text-green-700 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                        <div class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></div>
                                        Disponible
                                    </div>
                                @else
                                    <div class="bg-red-100/90 backdrop-blur-sm text-red-700 px-3 py-1.5 rounded-lg text-xs font-bold shadow-sm flex items-center gap-1">
                                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                                        Indisponible
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-dark mb-2 line-clamp-1 group-hover:text-primary transition-colors">
                                {{ $accommodation->title }}
                            </h3>
                            
                            <div class="flex items-center text-gray-500 text-sm mb-4">
                                <i class="fas fa-map-marker-alt mr-2 text-secondary"></i>
                                <span class="font-medium line-clamp-1">{{ $accommodation->quartier }}</span>
                            </div>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-2 mb-5">
                                <div class="bg-gray-50 p-2.5 rounded-xl text-center border border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <i class="fas fa-eye text-primary text-lg mb-1"></i>
                                    <p class="text-xs text-gray-600 font-bold whitespace-nowrap">{{ $accommodation->views_count ?? 0 }} vues</p>
                                </div>
                                <div class="bg-gray-50 p-2.5 rounded-xl text-center border border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <i class="fas fa-calendar-check text-secondary text-lg mb-1"></i>
                                    <p class="text-xs text-gray-600 font-bold whitespace-nowrap">{{ $accommodation->reservations_count ?? 0 }} rés.</p>
                                </div>
                                <div class="bg-gray-50 p-2.5 rounded-xl text-center border border-gray-100 group-hover:border-gray-200 transition-colors">
                                    <i class="fas fa-star text-yellow-500 text-lg mb-1"></i>
                                    <p class="text-xs text-gray-600 font-bold whitespace-nowrap">
                                        @php
                                            $avgRating = $accommodation->reviews->avg('rating') ?? 0;
                                        @endphp
                                        {{ number_format($avgRating, 1) }}
                                    </p>
                                </div>
                            </div>
                            
                            <div class="mt-auto">
                                <!-- Prix -->
                                <div class="mb-5 pb-5 border-b border-gray-100 flex items-baseline gap-1">
                                    <span class="text-2xl font-bold text-dark">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }}</span>
                                    <span class="text-gray-400 text-xs font-bold uppercase">FCFA / nuit</span>
                                </div>
                                
                                <!-- Actions -->
                                <div class="grid grid-cols-3 gap-3">
                                    <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                                       class="btn-secondary text-white py-2.5 rounded-xl hover:shadow-lg hover:shadow-secondary/20 transition flex items-center justify-center"
                                       title="Voir en ligne">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('owner.accommodations.edit', $accommodation->id) }}" 
                                       class="bg-gray-100 text-gray-700 py-2.5 rounded-xl hover:bg-gray-200 transition flex items-center justify-center"
                                       title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button 
                                        onclick="confirmDelete({{ $accommodation->id }})" 
                                        class="bg-red-50 text-red-500 border border-red-100 py-2.5 rounded-xl hover:bg-red-500 hover:text-white hover:border-red-500 transition flex items-center justify-center"
                                        title="Supprimer">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Aucun hébergement -->
            <div class="glass-card bg-white rounded-3xl p-16 text-center animate-fade-in max-w-2xl mx-auto border border-dashed border-gray-200">
                <div class="w-32 h-32 mx-auto mb-6 rounded-full flex items-center justify-center bg-gray-50 text-gray-300">
                    <i class="fas fa-building text-6xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">Aucun hébergement</h3>
                <p class="text-gray-500 mb-8">Commencez par ajouter votre premier hébergement pour recevoir des réservations.</p>
                <a href="{{ route('owner.accommodations.create') }}" 
                   class="btn-primary text-white px-8 py-3.5 rounded-xl inline-flex items-center gap-3 font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover-lift">
                    <i class="fas fa-plus"></i>
                    <span>Ajouter un hébergement</span>
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modal de confirmation suppression -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 transition-all">
    <div class="glass-card bg-white rounded-2xl max-w-md w-full p-8 animate-scale-in shadow-2xl">
        <div class="text-center mb-6">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center bg-red-100 text-red-500 animate-pulse">
                <i class="fas fa-exclamation-triangle text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-dark mb-2">Supprimer l'hébergement</h3>
            <p class="text-gray-500">Êtes-vous sûr de vouloir supprimer cet hébergement ? Cette action est irréversible.</p>
        </div>
        
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex gap-4">
                <button 
                    type="button" 
                    onclick="closeDeleteModal()"
                    class="flex-1 py-3.5 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button 
                    type="submit" 
                    class="flex-1 bg-red-500 text-white py-3.5 rounded-xl font-bold shadow-lg shadow-red-200 hover:bg-red-600 hover:shadow-red-300 transition">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

@endif

@endsection

@push('scripts')
<script>
    function confirmDelete(accommodationId) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        form.action = `/owner/accommodations/${accommodationId}`;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        document.body.style.overflow = '';
    }
    
    // Fermer le modal en cliquant en dehors
    document.getElementById('delete-modal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDeleteModal();
        }
    });
    
    // Fermer avec la touche Escape
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') {
            closeDeleteModal();
        }
    });
</script>
@endpush