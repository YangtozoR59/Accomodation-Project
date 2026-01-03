@extends('layouts.app')

@section('title', 'Gestion des avis')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-star text-yellow-400"></i> Gestion des avis
            </h1>
            <p class="text-white/80 text-lg">Modérer et gérer tous les avis clients de la plateforme</p>
        </div>
    </div>
</section>

<!-- Navigation Admin -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/90 backdrop-blur-xl p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-building"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" 
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-gray-900/20">
                <i class="fas fa-star"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-tags"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Filtres -->
<section class="py-6 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <form method="GET" class="glass-card bg-white p-4 rounded-2xl mb-8 flex flex-col sm:flex-row gap-4 items-center animate-fade-in shadow-sm border border-white/60">
            <div class="w-full sm:w-64 relative">
                <select name="status" class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none cursor-pointer">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Vérifiés</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            
            <button type="submit" class="w-full sm:w-auto btn-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 hover-lift flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filtrer
            </button>
            
            @if(request('status'))
                <a href="{{ route('admin.reviews') }}" class="w-full sm:w-auto px-4 py-3 text-gray-500 hover:text-dark font-medium flex items-center justify-center gap-2 transition">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            @endif
        </form>
        
        <!-- Liste des avis -->
        @if($reviews->count() > 0)
            <div class="bg-transparent grid grid-cols-1 gap-6">
                @foreach($reviews as $review)
                    <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-white/60 hover-lift animate-fade-in group hover:border-primary/20 transition-all">
                        <div class="flex flex-col md:flex-row items-start justify-between gap-6 mb-6">
                            <!-- Informations utilisateur -->
                            <div class="flex items-center gap-4">
                                @if($review->user->avatar)
                                    <div class="relative">
                                        <img src="{{ asset('storage/' . $review->user->avatar) }}" 
                                             alt="{{ $review->user->name }}"
                                             class="w-14 h-14 rounded-2xl object-cover shadow-sm group-hover:scale-105 transition-transform">
                                    </div>
                                @else
                                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-secondary text-white flex items-center justify-center text-xl font-bold shadow-sm group-hover:scale-105 transition-transform">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                @endif
                                
                                <div>
                                    <p class="font-bold text-dark text-lg">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-500 flex items-center gap-2">
                                        <i class="fas fa-clock text-xs"></i>
                                        {{ $review->created_at->format('d/m/Y à H:i') }}
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Statut -->
                            @if($review->is_verified)
                                <span class="bg-green-100 text-green-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shadow-sm">
                                    <i class="fas fa-check-circle"></i> Vérifié
                                </span>
                            @else
                                <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-xl text-sm font-bold flex items-center gap-2 shadow-sm animate-pulse">
                                    <i class="fas fa-clock"></i> En attente
                                </span>
                            @endif
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
                            <!-- Détails de la note -->
                            <div class="md:col-span-4 bg-gray-50 rounded-2xl p-5 border border-gray-100">
                                <!-- Note globale -->
                                <div class="mb-5 text-center">
                                    <p class="text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Note globale</p>
                                    <div class="flex items-center justify-center gap-2">
                                        <span class="text-4xl font-bold text-dark">{{ $review->rating }}</span>
                                        <div class="flex flex-col items-start">
                                            <div class="flex text-yellow-400 text-sm">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star {{ $i <= $review->rating ? '' : 'text-gray-300' }}"></i>
                                                @endfor
                                            </div>
                                            <span class="text-xs text-gray-400">sur 5 étoiles</span> 
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Notes détaillées -->
                                @if($review->cleanliness_rating || $review->location_rating || $review->value_rating)
                                    <div class="space-y-3 pt-4 border-t border-gray-200">
                                        @if($review->cleanliness_rating)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600"><i class="fas fa-broom mr-2 text-blue-400"></i>Propreté</span>
                                                <span class="font-bold text-dark">{{ $review->cleanliness_rating }}/5</span>
                                            </div>
                                        @endif
                                        
                                        @if($review->location_rating)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600"><i class="fas fa-map-marker-alt mr-2 text-red-400"></i>Localisation</span>
                                                <span class="font-bold text-dark">{{ $review->location_rating }}/5</span>
                                            </div>
                                        @endif
                                        
                                        @if($review->value_rating)
                                            <div class="flex items-center justify-between text-sm">
                                                <span class="text-gray-600"><i class="fas fa-coins mr-2 text-yellow-400"></i>Qualité/Prix</span>
                                                <span class="font-bold text-dark">{{ $review->value_rating }}/5</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Commentaire et Hébergement -->
                            <div class="md:col-span-8 flex flex-col justify-between">
                                <div>
                                    <!-- Hébergement concerné -->
                                    <div class="mb-4 inline-flex items-center gap-2 px-3 py-1.5 bg-blue-50 text-blue-700 rounded-lg text-sm font-medium border border-blue-100">
                                        <i class="fas fa-home"></i>
                                        <span>Sur :</span>
                                        <a href="{{ route('accommodations.show', $review->accommodation->id) }}" 
                                           target="_blank"
                                           class="font-bold hover:underline">
                                            {{ $review->accommodation->title }}
                                        </a>
                                    </div>
                                    
                                    <!-- Commentaire -->
                                    @if($review->comment)
                                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 relative">
                                            <i class="fas fa-quote-left absolute top-4 left-4 text-gray-200 text-3xl"></i>
                                            <p class="text-gray-700 relative z-10 pl-6 italic leading-relaxed">"{{ $review->comment }}"</p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap gap-3 mt-6 pt-6 border-t border-gray-100">
                                    <a href="{{ route('accommodations.show', $review->accommodation->id) }}" 
                                       target="_blank"
                                       class="px-5 py-2.5 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-white hover:text-primary hover:shadow-md transition border border-transparent hover:border-gray-100 flex items-center gap-2">
                                        <i class="fas fa-external-link-alt"></i> Voir offre
                                    </a>
                                    
                                    @if(!$review->is_verified)
                                        <form action="{{ route('admin.reviews.verify', $review->id) }}" 
                                              method="POST" 
                                              class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-5 py-2.5 bg-green-500 text-white rounded-xl font-bold hover:bg-green-600 shadow-md shadow-green-500/20 hover:shadow-green-500/40 transition hover-lift flex items-center gap-2">
                                                <i class="fas fa-check-circle"></i> Valider l'avis
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <button onclick="confirmDelete({{ $review->id }})" 
                                            class="px-5 py-2.5 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-500 hover:text-white transition flex items-center gap-2 ml-auto">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $reviews->links() }}
            </div>
        @else
            <div class="glass-card bg-white rounded-3xl p-12 text-center border border-white/60 shadow-sm">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-star text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-2">Aucun avis trouvé</h3>
                <p class="text-gray-500">Aucun avis ne correspond à vos critères.</p>
                <a href="{{ route('admin.reviews') }}" class="inline-block mt-4 text-primary font-bold hover:underline">
                    Voir tous les avis
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Modal de suppression -->
<div id="delete-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm transition-opacity" onclick="closeDeleteModal()"></div>
    
    <div class="glass-card bg-white rounded-3xl max-w-md w-full p-8 relative z-10 animate-float shadow-2xl border border-white/40">
        <div class="w-16 h-16 mx-auto mb-6 rounded-2xl bg-red-100 text-red-500 flex items-center justify-center text-2xl animate-pulse">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        
        <h3 class="text-2xl font-bold text-dark mb-3 text-center">Supprimer l'avis ?</h3>
        <p class="text-gray-600 mb-8 text-center leading-relaxed">Cette action est irréversible. L'avis sera définitivement retiré de la plateforme.</p>
        
        <form id="delete-form" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="flex gap-4">
                <button type="button" 
                        onclick="closeDeleteModal()"
                        class="flex-1 px-6 py-3 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                    Annuler
                </button>
                <button type="submit" 
                        class="flex-1 px-6 py-3 bg-red-500 text-white rounded-xl font-bold hover:bg-red-600 shadow-lg shadow-red-500/30 transition hover-lift">
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
        document.body.style.overflow = 'hidden';
    }
    
    function closeDeleteModal() {
        document.getElementById('delete-modal').classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
    
    document.addEventListener('keydown', function(e) {
        if(e.key === 'Escape') closeDeleteModal();
    });
</script>
@endpush