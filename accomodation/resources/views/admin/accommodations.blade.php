@extends('layouts.app')

@section('title', 'Gestion des hébergements')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-building text-blue-400"></i> Gestion des hébergements
            </h1>
            <p class="text-white/80 text-lg">Vérifier, modérer et gérer tous les hébergements de la plateforme</p>
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
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-gray-900/20">
                <i class="fas fa-building"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
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
        <form method="GET" class="glass-card bg-white p-4 rounded-2xl mb-8 flex flex-col md:flex-row gap-4 items-center animate-fade-in shadow-sm border border-white/60">
            <div class="relative flex-1 w-full">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Rechercher (titre, quartier, propriétaire)..." 
                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none">
            </div>
            
            <div class="w-full md:w-48 relative">
                <select name="status" class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none cursor-pointer">
                    <option value="">Tous les statuts</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                    <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Vérifiés</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetés</option>
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            
            <div class="w-full md:w-56 relative">
                <select name="category" class="w-full appearance-none px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none cursor-pointer">
                    <option value="">Toutes les catégories</option>
                    @foreach(\App\Models\Category::all() as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none"></i>
            </div>
            
            <button type="submit" class="w-full md:w-auto btn-primary text-white px-8 py-3 rounded-xl font-bold shadow-lg shadow-primary/30 hover-lift flex items-center justify-center gap-2">
                <i class="fas fa-filter"></i> Filtrer
            </button>
            
            @if(request()->anyFilled(['search', 'status', 'category']))
                <a href="{{ route('admin.accommodations') }}" class="w-full md:w-auto px-4 py-3 text-gray-500 hover:text-dark font-medium flex items-center justify-center gap-2 transition">
                    <i class="fas fa-times"></i>
                </a>
            @endif
        </form>
        
        <!-- Liste des hébergements -->
        @if($accommodations->count() > 0)
            <div class="glass-card bg-white rounded-3xl shadow-sm border border-white/60 overflow-hidden animate-fade-in">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50 border-b border-gray-100">
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Hébergement</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Propriétaire</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Catégorie</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Prix</th>
                                <th class="px-6 py-5 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Statut</th>
                                <th class="px-6 py-5 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach($accommodations as $accommodation)
                                <tr class="hover:bg-gray-50/80 transition group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-4">
                                            @php
                                                $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                                             ?? $accommodation->images->first();
                                            @endphp
                                            
                                            <div class="relative w-16 h-16 rounded-xl overflow-hidden shadow-sm flex-shrink-0 group-hover:shadow-md transition-all">
                                                @if($primaryImage)
                                                    <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                                         alt="{{ $accommodation->title }}"
                                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                                @else
                                                    <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                                        <i class="fas fa-image"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            
                                            <div>
                                                <p class="font-bold text-dark group-hover:text-primary transition-colors line-clamp-1">{{ $accommodation->title }}</p>
                                                <p class="text-xs text-gray-500 mt-1 flex items-center gap-1">
                                                    <i class="fas fa-map-marker-alt text-secondary"></i>
                                                    {{ $accommodation->quartier }}
                                                </p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="font-bold text-gray-800 text-sm">{{ $accommodation->owner->name }}</span>
                                            <span class="text-xs text-gray-500">{{ $accommodation->owner->email }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-700">
                                            <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} text-secondary"></i>
                                            {{ $accommodation->category->name }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-dark">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }} <span class="text-xs text-gray-500 font-normal">FCFA</span></div>
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($accommodation->is_verified)
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-green-100 text-green-700">
                                                <i class="fas fa-check-circle"></i> Vérifié
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold bg-yellow-100 text-yellow-700">
                                                <i class="fas fa-clock"></i> En attente
                                            </span>
                                        @endif
                                        
                                        <div class="mt-2">
                                        @if($accommodation->is_available)
                                            <span class="inline-flex items-center gap-1 text-xs text-blue-600 font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span> Disponible
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 text-xs text-gray-400 font-semibold">
                                                <span class="w-1.5 h-1.5 rounded-full bg-gray-400"></span> Non disp.
                                            </span>
                                        @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="flex items-center justify-end gap-2">
                                            <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                                               target="_blank"
                                               class="w-8 h-8 rounded-lg bg-gray-100 text-gray-600 flex items-center justify-center hover:bg-blue-500 hover:text-white transition shadow-sm"
                                               title="Voir">
                                                <i class="fas fa-eye text-xs"></i>
                                            </a>
                                            
                                            @if(!$accommodation->is_verified)
                                                <form action="{{ route('admin.accommodations.verify', $accommodation->id) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-500 hover:text-white transition shadow-sm"
                                                            title="Valider">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('admin.accommodations.unverify', $accommodation->id) }}" 
                                                      method="POST" 
                                                      class="inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" 
                                                            class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center hover:bg-yellow-500 hover:text-white transition shadow-sm"
                                                            title="Retirer vérification">
                                                        <i class="fas fa-times text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            <button onclick="confirmDelete({{ $accommodation->id }})" 
                                                    class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-500 hover:text-white transition shadow-sm"
                                                    title="Supprimer">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $accommodations->links() }}
            </div>
        @else
            <div class="glass-card bg-white rounded-3xl p-12 text-center border border-white/60 shadow-sm">
                <div class="w-24 h-24 mx-auto mb-6 bg-gray-50 rounded-full flex items-center justify-center text-gray-300">
                    <i class="fas fa-inbox text-5xl"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-2">Aucun hébergement trouvé</h3>
                <p class="text-gray-500">Essayez de modifier vos filtres de recherche.</p>
                <a href="{{ route('admin.accommodations') }}" class="inline-block mt-4 text-primary font-bold hover:underline">
                    Réinitialiser les filtres
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
        
        <h3 class="text-2xl font-bold text-dark mb-3 text-center">Supprimer l'hébergement ?</h3>
        <p class="text-gray-600 mb-8 text-center leading-relaxed">Cette action est irréversible. L'hébergement et toutes ses données associées seront définitivement supprimés.</p>
        
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
    function confirmDelete(accommodationId) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        form.action = `/admin/accommodations/${accommodationId}`;
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