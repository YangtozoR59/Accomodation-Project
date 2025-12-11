@extends('layouts.app')

@section('title', 'Rechercher un hébergement')

@section('content')

<!-- Header de recherche -->
<section class="bg-gradient-to-r from-primary to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white text-center mb-8 fade-in">
            <i class="fas fa-search mr-2"></i> Trouvez votre hébergement
        </h1>
        
        <!-- Barre de recherche -->
        <div class="max-w-4xl mx-auto bg-white rounded-2xl shadow-2xl p-6 fade-in">
            <form method="GET" action="{{ route('accommodations.index') }}" id="search-form">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <!-- Recherche -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-search mr-1"></i> Recherche
                        </label>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Titre, quartier..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                        >
                    </div>
                    
                    <!-- Catégorie -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-th-large mr-1"></i> Catégorie
                        </label>
                        <select 
                            name="category" 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                        >
                            <option value="">Toutes les catégories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <!-- Quartier -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            <i class="fas fa-map-marker-alt mr-1"></i> Quartier
                        </label>
                        <input 
                            type="text" 
                            name="quartier" 
                            value="{{ request('quartier') }}"
                            placeholder="Ex: Plateau, Mardock..." 
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                        >
                    </div>
                </div>
                
                <!-- Filtres avancés (collapsible) -->
                <div id="advanced-filters" class="hidden">
                    <div class="border-t pt-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Prix min -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-money-bill-wave mr-1"></i> Prix min (FCFA)
                                </label>
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    value="{{ request('min_price') }}"
                                    placeholder="0" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                            
                            <!-- Prix max -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    Prix max (FCFA)
                                </label>
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    value="{{ request('max_price') }}"
                                    placeholder="100000" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                            
                            <!-- Chambres -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-bed mr-1"></i> Chambres min
                                </label>
                                <input 
                                    type="number" 
                                    name="nb_rooms" 
                                    value="{{ request('nb_rooms') }}"
                                    placeholder="1" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                            
                            <!-- Invités -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-users mr-1"></i> Invités
                                </label>
                                <input 
                                    type="number" 
                                    name="nb_guests" 
                                    value="{{ request('nb_guests') }}"
                                    placeholder="2" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Boutons -->
                <div class="flex justify-between items-center mt-4">
                    <button 
                        type="button" 
                        onclick="document.getElementById('advanced-filters').classList.toggle('hidden')"
                        class="text-accent hover:text-dark transition"
                    >
                        <i class="fas fa-sliders-h mr-2"></i> Filtres avancés
                    </button>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('accommodations.index') }}" class="px-6 py-2 border border-gray-300 rounded-lg hover:bg-gray-100 transition">
                            <i class="fas fa-redo mr-2"></i> Réinitialiser
                        </a>
                        <button type="submit" class="btn-primary text-white px-6 py-2 rounded-lg">
                            <i class="fas fa-search mr-2"></i> Rechercher
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Résultats -->
<section class="py-12">
    <div class="container mx-auto px-4">
        <!-- Tri et compteur -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-dark">
                {{ $accommodations->total() }} hébergement(s) trouvé(s)
            </h2>
            
            <select 
                name="sort" 
                onchange="document.getElementById('search-form').submit()"
                class="px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
            >
                <option value="">Trier par</option>
                <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Prix croissant</option>
                <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Prix décroissant</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Populaires</option>
            </select>
        </div>
        
        @if($accommodations->count() > 0)
            <!-- Grille des hébergements -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($accommodations as $accommodation)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift fade-in">
                    <!-- Image -->
                    <div class="relative h-48 bg-gray-200">
                        @if($accommodation->primary_image)
                            <img src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                 alt="{{ $accommodation->title }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-image text-6xl text-gray-400"></i>
                            </div>
                        @endif
                        
                        <!-- Badge catégorie -->
                        <div class="absolute top-3 left-3 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-sm font-semibold text-dark">
                            <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} mr-1"></i>
                            {{ $accommodation->category->name }}
                        </div>
                        
                        <!-- Badge vérifié -->
                        @if($accommodation->is_verified)
                            <div class="absolute top-3 right-3 bg-green-500 text-white px-2 py-1 rounded-full text-xs">
                                <i class="fas fa-check-circle"></i> Vérifié
                            </div>
                        @endif
                    </div>
                    
                    <!-- Contenu -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-dark mb-2 line-clamp-2 h-14">
                            {{ $accommodation->title }}
                        </h3>
                        
                        <div class="flex items-center text-gray-600 text-sm mb-3">
                            <i class="fas fa-map-marker-alt mr-1 text-accent"></i>
                            {{ $accommodation->quartier }}
                        </div>
                        
                        <!-- Infos -->
                        <div class="flex items-center gap-3 text-sm text-gray-600 mb-4">
                            <span title="Lits"><i class="fas fa-bed mr-1"></i> {{ $accommodation->nb_beds }}</span>
                            <span title="Invités"><i class="fas fa-users mr-1"></i> {{ $accommodation->max_guests }}</span>
                            <span title="Salles de bain"><i class="fas fa-bath mr-1"></i> {{ $accommodation->nb_bathrooms }}</span>
                        </div>
                        
                        <!-- Prix et note -->
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <span class="text-2xl font-bold text-accent">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }}</span>
                                <span class="text-gray-600 text-sm"> FCFA/nuit</span>
                            </div>
                            @if($accommodation->reviews->count() > 0)
                                <div class="flex items-center">
                                    <i class="fas fa-star text-yellow-400 mr-1"></i>
                                    <span class="font-semibold">{{ number_format($accommodation->average_rating, 1) }}</span>
                                    <span class="text-gray-500 text-xs ml-1">({{ $accommodation->reviews->count() }})</span>
                                </div>
                            @endif
                        </div>
                        
                        <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                           class="w-full btn-primary text-white text-center py-2 rounded-lg block">
                            <i class="fas fa-eye mr-2"></i> Voir les détails
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-12">
                {{ $accommodations->links() }}
            </div>
        @else
            <!-- Aucun résultat -->
            <div class="text-center py-16">
                <i class="fas fa-search text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucun hébergement trouvé</h3>
                <p class="text-gray-600 mb-6">Essayez de modifier vos critères de recherche</p>
                <a href="{{ route('accommodations.index') }}" class="btn-primary text-white px-6 py-3 rounded-lg inline-block">
                    <i class="fas fa-redo mr-2"></i> Réinitialiser la recherche
                </a>
            </div>
        @endif
    </div>
</section>

@endsection