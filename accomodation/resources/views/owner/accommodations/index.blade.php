@extends('layouts.app')

@section('title', 'Mes hébergements')

@section('content')

<!-- Si c'est la première visite, afficher le dashboard -->
@if(request()->routeIs('owner.accommodations.index') && !request()->has('list'))
    @include('owner.dashboard')
@else

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-building mr-2"></i> Mes hébergements
                </h1>
                <p class="text-white/90">Gérez tous vos hébergements</p>
            </div>
            
            <a href="{{ route('owner.accommodations.create') }}" 
               class="bg-white text-accent px-6 py-3 rounded-full font-bold hover:bg-primary transition fade-in">
                <i class="fas fa-plus mr-2"></i> Ajouter
            </a>
        </div>
    </div>
</section>

<!-- Navigation -->
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
        
        @if($accommodations->count() > 0)
            <!-- Grille des hébergements -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($accommodations as $accommodation)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift fade-in">
                        <!-- Image -->
                        <div class="relative h-48 bg-gray-200">
                            @php
                                $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                             ?? $accommodation->images->first();
                            @endphp
                            
                            @if($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                     alt="{{ $accommodation->title }}"
                                     class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="fas fa-image text-6xl text-gray-400"></i>
                                </div>
                            @endif
                            
                            <!-- Badges -->
                            <div class="absolute top-3 left-3 flex gap-2">
                                <span class="bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-semibold">
                                    <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} mr-1"></i>
                                    {{ $accommodation->category->name }}
                                </span>
                            </div>
                            
                            <div class="absolute top-3 right-3">
                                @if($accommodation->is_verified)
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                        <i class="fas fa-check-circle"></i> Vérifié
                                    </span>
                                @else
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs">
                                        <i class="fas fa-clock"></i> En attente
                                    </span>
                                @endif
                            </div>
                            
                            <!-- Statut disponibilité -->
                            <div class="absolute bottom-3 left-3">
                                @if($accommodation->is_available)
                                    <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-check"></i> Disponible
                                    </span>
                                @else
                                    <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">
                                        <i class="fas fa-times"></i> Non disponible
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Contenu -->
                        <div class="p-4">
                            <h3 class="text-lg font-bold text-dark mb-2 line-clamp-2 h-14">
                                {{ $accommodation->title }}
                            </h3>
                            
                            <p class="text-sm text-gray-600 mb-3">
                                <i class="fas fa-map-marker-alt text-accent mr-1"></i>
                                {{ $accommodation->quartier }}
                            </p>
                            
                            <!-- Stats -->
                            <div class="grid grid-cols-3 gap-2 mb-4">
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <i class="fas fa-eye text-accent text-sm"></i>
                                    <p class="text-xs text-gray-600 mt-1">{{ $accommodation->views_count ?? 0 }}</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <i class="fas fa-calendar-check text-accent text-sm"></i>
                                    <p class="text-xs text-gray-600 mt-1">{{ $accommodation->reservations_count ?? 0 }}</p>
                                </div>
                                <div class="text-center p-2 bg-gray-50 rounded">
                                    <i class="fas fa-star text-yellow-400 text-sm"></i>
                                    <p class="text-xs text-gray-600 mt-1">
                                        @php
                                            $avgRating = $accommodation->reviews->avg('rating') ?? 0;
                                        @endphp
                                        {{ number_format($avgRating, 1) }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Prix -->
                            <div class="mb-4">
                                <span class="text-2xl font-bold text-accent">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }}</span>
                                <span class="text-gray-600 text-sm"> FCFA/nuit</span>
                            </div>
                            
                            <!-- Actions -->
                            <div class="flex gap-2">
                                <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                                   class="flex-1 text-center bg-accent/10 text-accent px-3 py-2 rounded-lg hover:bg-accent hover:text-white transition text-sm"
                                   title="Voir">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('owner.accommodations.edit', $accommodation->id) }}" 
                                   class="flex-1 text-center bg-blue-500 text-white px-3 py-2 rounded-lg hover:bg-blue-600 transition text-sm"
                                   title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button 
                                    onclick="confirmDelete({{ $accommodation->id }})" 
                                    class="flex-1 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 transition text-sm"
                                    title="Supprimer">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Aucun hébergement -->
            <div class="bg-white rounded-xl shadow-lg p-12 text-center fade-in">
                <i class="fas fa-building text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun hébergement</h3>
                <p class="text-gray-600 mb-6">Commencez par ajouter votre premier hébergement</p>
                <a href="{{ route('owner.accommodations.create') }}" class="bg-accent text-white px-8 py-3 rounded-lg inline-block hover:bg-dark transition">
                    <i class="fas fa-plus mr-2"></i> Ajouter un hébergement
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modal de confirmation suppression -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6 fade-in">
        <h3 class="text-2xl font-bold text-dark mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Supprimer l'hébergement
        </h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer cet hébergement ? Cette action est irréversible.</p>
        
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex gap-3">
                <button 
                    type="button" 
                    onclick="closeDeleteModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Annuler
                </button>
                <button 
                    type="submit" 
                    class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
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
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
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