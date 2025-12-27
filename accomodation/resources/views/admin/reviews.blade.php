@extends('layouts.app')

@section('title', 'Gestion des avis')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-star mr-2"></i> Gestion des avis
        </h1>
        <p class="text-white/90 mt-2">Modérer et gérer tous les avis clients</p>
    </div>
</section>

<!-- Navigation Admin -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-tags mr-2"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-6 bg-gray-50">
    <div class="container mx-auto px-4">
        <form method="GET" class="flex gap-4 items-center">
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Vérifiés</option>
            </select>
            
            <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-dark transition">
                <i class="fas fa-filter mr-2"></i> Filtrer
            </button>
            
            @if(request('status'))
                <a href="{{ route('admin.reviews') }}" class="text-gray-600 hover:text-accent">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Liste des avis -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        @if($reviews->count() > 0)
            <div class="space-y-4">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                        <div class="flex items-start justify-between mb-4">
                            <!-- Informations utilisateur -->
                            <div class="flex items-center gap-4">
                                @if($review->user->avatar)
                                    <img src="{{ asset('storage/' . $review->user->avatar) }}" 
                                         alt="{{ $review->user->name }}"
                                         class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center">
                                        <i class="fas fa-user text-accent text-xl"></i>
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="font-bold text-dark">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $review->created_at->format('d/m/Y à H:i') }}</p>
                                </div>
                            </div>
                            
                            <!-- Statut -->
                            @if($review->is_verified)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-check-circle"></i> Vérifié
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-800 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-clock"></i> En attente
                                </span>
                            @endif
                        </div>
                        
                        <!-- Hébergement concerné -->
                        <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                            <p class="text-sm text-gray-600 mb-1">Hébergement :</p>
                            <a href="{{ route('accommodations.show', $review->accommodation->id) }}" 
                               target="_blank"
                               class="font-semibold text-accent hover:underline">
                                {{ $review->accommodation->title }}
                            </a>
                        </div>
                        
                        <!-- Note globale -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Note globale :</p>
                            <div class="flex items-center gap-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                @endfor
                                <span class="font-bold text-lg ml-2">{{ $review->rating }}/5</span>
                            </div>
                        </div>
                        
                        <!-- Notes détaillées -->
                        @if($review->cleanliness_rating || $review->location_rating || $review->value_rating)
                            <div class="grid grid-cols-3 gap-4 mb-4">
                                @if($review->cleanliness_rating)
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <p class="text-xs text-gray-600 mb-1">Propreté</p>
                                        <p class="font-semibold text-accent">{{ $review->cleanliness_rating }}/5</p>
                                    </div>
                                @endif
                                
                                @if($review->location_rating)
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <p class="text-xs text-gray-600 mb-1">Localisation</p>
                                        <p class="font-semibold text-accent">{{ $review->location_rating }}/5</p>
                                    </div>
                                @endif
                                
                                @if($review->value_rating)
                                    <div class="text-center p-2 bg-gray-50 rounded">
                                        <p class="text-xs text-gray-600 mb-1">Rapport qualité/prix</p>
                                        <p class="font-semibold text-accent">{{ $review->value_rating }}/5</p>
                                    </div>
                                @endif
                            </div>
                        @endif
                        
                        <!-- Commentaire -->
                        @if($review->comment)
                            <div class="mb-4 p-4 bg-gray-50 rounded-lg border-l-4 border-accent">
                                <p class="text-gray-700">{{ $review->comment }}</p>
                            </div>
                        @endif
                        
                        <!-- Actions -->
                        <div class="flex gap-2 pt-4 border-t">
                            <a href="{{ route('accommodations.show', $review->accommodation->id) }}" 
                               target="_blank"
                               class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                                <i class="fas fa-eye mr-1"></i> Voir l'hébergement
                            </a>
                            
                            @if(!$review->is_verified)
                                <form action="{{ route('admin.reviews.verify', $review->id) }}" 
                                      method="POST" 
                                      class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition text-sm">
                                        <i class="fas fa-check mr-1"></i> Vérifier
                                    </button>
                                </form>
                            @endif
                            
                            <button onclick="confirmDelete({{ $review->id }})" 
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                <i class="fas fa-trash mr-1"></i> Supprimer
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-star text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-600">Aucun avis trouvé</p>
            </div>
        @endif
    </div>
</section>

<!-- Modal de suppression -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-2xl font-bold text-dark mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Supprimer l'avis
        </h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer cet avis ? Cette action est irréversible.</p>
        
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                    Annuler
                </button>
                <button type="submit" 
                        class="flex-1 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">
                    Supprimer
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(reviewId) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        form.action = `/admin/reviews/${reviewId}`;
        modal.classList.remove('hidden');
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
    }
    
    document.getElementById('delete-modal')?.addEventListener('click', function(e) {
        if (e.target === this) closeDeleteModal();
    });
    
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush