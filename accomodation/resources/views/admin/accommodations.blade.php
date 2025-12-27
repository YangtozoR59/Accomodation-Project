@extends('layouts.app')

@section('title', 'Gestion des hébergements')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-building mr-2"></i> Gestion des hébergements
        </h1>
        <p class="text-white/90 mt-2">Vérifier et gérer tous les hébergements</p>
    </div>
</section>

<!-- Navigation Admin -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
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
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Rechercher un hébergement..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
            
            <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                <option value="">Tous les statuts</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>En attente</option>
                <option value="verified" {{ request('status') == 'verified' ? 'selected' : '' }}>Vérifiés</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejetés</option>
            </select>
            
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-accent">
                <option value="">Toutes les catégories</option>
                @foreach(\App\Models\Category::all() as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="bg-accent text-white px-6 py-2 rounded-lg hover:bg-dark transition">
                <i class="fas fa-search mr-2"></i> Filtrer
            </button>
            
            @if(request()->anyFilled(['search', 'status', 'category']))
                <a href="{{ route('admin.accommodations') }}" class="text-gray-600 hover:text-accent">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            @endif
        </form>
    </div>
</section>

<!-- Liste des hébergements -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        @if($accommodations->count() > 0)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Hébergement</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Propriétaire</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Catégorie</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Prix</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Statut</th>
                            <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($accommodations as $accommodation)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                                         ?? $accommodation->images->first();
                                        @endphp
                                        
                                        @if($primaryImage)
                                            <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                                 alt="{{ $accommodation->title }}"
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                        
                                        <div>
                                            <p class="font-semibold text-gray-900">{{ $accommodation->title }}</p>
                                            <p class="text-sm text-gray-600">
                                                <i class="fas fa-map-marker-alt text-accent mr-1"></i>
                                                {{ $accommodation->quartier }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $accommodation->owner->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->owner->email }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                                        <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} mr-1"></i>
                                        {{ $accommodation->category->name }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="font-semibold text-accent">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }} FCFA</p>
                                    <p class="text-xs text-gray-600">par nuit</p>
                                </td>
                                <td class="px-6 py-4">
                                    @if($accommodation->is_verified)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800">
                                            <i class="fas fa-check-circle mr-1"></i> Vérifié
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-800">
                                            <i class="fas fa-clock mr-1"></i> En attente
                                        </span>
                                    @endif
                                    
                                    <br>
                                    
                                    @if($accommodation->is_available)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-blue-100 text-blue-800 mt-1">
                                            <i class="fas fa-check mr-1"></i> Disponible
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs bg-gray-100 text-gray-800 mt-1">
                                            <i class="fas fa-times mr-1"></i> Non disponible
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex gap-2">
                                        <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                                           target="_blank"
                                           class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 transition text-sm"
                                           title="Voir">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(!$accommodation->is_verified)
                                            <form action="{{ route('admin.accommodations.verify', $accommodation->id) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-green-500 text-white rounded hover:bg-green-600 transition text-sm"
                                                        title="Vérifier">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.accommodations.unverify', $accommodation->id) }}" 
                                                  method="POST" 
                                                  class="inline">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="px-3 py-1 bg-orange-500 text-white rounded hover:bg-orange-600 transition text-sm"
                                                        title="Retirer vérification">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <button onclick="confirmDelete({{ $accommodation->id }})" 
                                                class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition text-sm"
                                                title="Supprimer">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            <div class="mt-6">
                {{ $accommodations->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <p class="text-xl text-gray-600">Aucun hébergement trouvé</p>
            </div>
        @endif
    </div>
</section>

<!-- Modal de suppression -->
<div id="delete-modal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl max-w-md w-full p-6">
        <h3 class="text-2xl font-bold text-dark mb-4">
            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i> Supprimer l'hébergement
        </h3>
        <p class="text-gray-600 mb-6">Êtes-vous sûr de vouloir supprimer cet hébergement ? Cette action est irréversible.</p>
        
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
    function confirmDelete(accommodationId) {
        const modal = document.getElementById('delete-modal');
        const form = document.getElementById('delete-form');
        form.action = `/admin/accommodations/${accommodationId}`;
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