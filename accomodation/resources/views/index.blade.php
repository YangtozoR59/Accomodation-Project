@extends('layouts.app')

@section('title', 'Accueil - Hébergement Ngaoundéré')

@section('content')

<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-primary via-secondary to-accent text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center fade-in">
            <h1 class="text-5xl md:text-6xl font-bold mb-6">
                Trouvez votre hébergement idéal à <span class="text-dark">Ngaoundéré</span>
            </h1>
            <p class="text-xl mb-8 text-gray-100">
                Hôtels, auberges, appartements... Réservez en quelques clics !
            </p>
            
            <!-- Barre de recherche -->
            <div class="bg-white rounded-2xl shadow-2xl p-6 fade-in">
                <form action="{{ route('accommodations.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1">
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher un hébergement..." 
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:border-accent text-gray-800"
                        >
                    </div>
                    <button type="submit" class="btn-primary text-white px-8 py-3 rounded-lg font-semibold">
                        <i class="fas fa-search mr-2"></i> Rechercher
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Animated waves -->
    {{-- <div class="absolute bottom-0 left-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full">
            <path fill="#f9fafb" fill-opacity="1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,154.7C960,171,1056,181,1152,165.3C1248,149,1344,107,1392,85.3L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
        </svg>
    </div> --}}
</section>

<!-- Catégories -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-dark mb-12 fade-in">
            <i class="fas fa-th-large mr-2"></i> Nos catégories
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('accommodations.index', ['category' => $category->id]) }}" 
               class="bg-white rounded-xl shadow-lg p-6 text-center hover-lift fade-in">
                <div class="text-5xl mb-4 text-accent">
                    <i class="fas fa-{{ $category->icon ?? 'building' }}"></i>
                </div>
                <h3 class="text-xl font-semibold text-dark mb-2">{{ $category->name }}</h3>
                <p class="text-gray-600 text-sm">{{ $category->accommodations_count ?? 0 }} hébergements</p>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Hébergements populaires -->
<section class="py-16 bg-gray-100">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12">
            <h2 class="text-4xl font-bold text-dark fade-in">
                <i class="fas fa-fire mr-2 text-accent"></i> Hébergements populaires
            </h2>
            <a href="{{ route('accommodations.index') }}" class="text-accent hover:text-dark transition">
                Voir tout <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($popularAccommodations as $accommodation)
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
                </div>
                
                <!-- Contenu -->
                <div class="p-4">
                    <h3 class="text-lg font-bold text-dark mb-2 line-clamp-2">
                        {{ $accommodation->title }}
                    </h3>
                    
                    <div class="flex items-center text-gray-600 text-sm mb-3">
                        <i class="fas fa-map-marker-alt mr-1 text-accent"></i>
                        {{ $accommodation->quartier }}
                    </div>
                    
                    <!-- Infos -->
                    <div class="flex items-center gap-3 text-sm text-gray-600 mb-4">
                        <span><i class="fas fa-bed mr-1"></i> {{ $accommodation->nb_beds }}</span>
                        <span><i class="fas fa-users mr-1"></i> {{ $accommodation->max_guests }}</span>
                        <span><i class="fas fa-bath mr-1"></i> {{ $accommodation->nb_bathrooms }}</span>
                    </div>
                    
                    <!-- Prix et note -->
                    <div class="flex justify-between items-center">
                        <div>
                            <span class="text-2xl font-bold text-accent">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }}</span>
                            <span class="text-gray-600 text-sm"> FCFA/nuit</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                            <span class="font-semibold">{{ number_format($accommodation->average_rating, 1) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                       class="mt-4 w-full btn-primary text-white text-center py-2 rounded-lg block">
                        <i class="fas fa-eye mr-2"></i> Voir les détails
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- Pourquoi nous choisir -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-4xl font-bold text-center text-dark mb-12 fade-in">
            <i class="fas fa-check-circle mr-2 text-accent"></i> Pourquoi nous choisir ?
        </h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center fade-in">
                <div class="w-20 h-20 bg-primary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-search-location text-4xl text-dark"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Recherche facile</h3>
                <p class="text-gray-600">
                    Trouvez rapidement l'hébergement parfait grâce à nos filtres avancés.
                </p>
            </div>
            
            <div class="text-center fade-in">
                <div class="w-20 h-20 bg-secondary rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-4xl text-dark"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Réservation sécurisée</h3>
                <p class="text-gray-600">
                    Toutes nos offres sont vérifiées pour garantir votre sécurité.
                </p>
            </div>
            
            <div class="text-center fade-in">
                <div class="w-20 h-20 bg-accent rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-headset text-4xl text-white"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3">Support 24/7</h3>
                <p class="text-gray-600">
                    Notre équipe est disponible pour vous aider à tout moment.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to action -->
<section class="py-16 bg-gradient-to-r from-accent to-dark text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold mb-6 fade-in">
            Vous êtes propriétaire d'un hébergement ?
        </h2>
        <p class="text-xl mb-8 fade-in">
            Rejoignez notre plateforme et augmentez votre visibilité !
        </p>
        <a href="{{ route('register') }}" class="inline-block bg-white text-accent px-8 py-4 rounded-full font-bold text-lg hover:bg-primary hover:text-white transition">
            <i class="fas fa-plus-circle mr-2"></i> Publier mon hébergement
        </a>
    </div>
</section>

@endsection