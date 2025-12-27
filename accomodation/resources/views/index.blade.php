@extends('layouts.app')

@section('title', 'Accueil - Hébergement Ngaoundéré')

@section('content')

<!-- Hero Section avec Glassmorphisme -->
<section class="relative bg-primary text-white py-24 overflow-hidden">
    <!-- Formes décoratives en arrière-plan -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-secondary rounded-full blur-3xl animate-float"></div>
        <div class="absolute top-40 right-20 w-96 h-96 bg-white rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
        <div class="absolute bottom-20 left-40 w-80 h-80 bg-neutral rounded-full blur-3xl animate-float" style="animation-delay: 6s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center animate-fade-in">
            <h1 class="text-5xl md:text-7xl font-bold mb-6 leading-tight">
                Trouvez votre <span class="text-secondary">hébergement idéal</span><br>
                à Ngaoundéré
            </h1>
            <p class="text-xl md:text-2xl mb-12 text-gray-100">
                Hôtels, auberges, appartements... Réservez en quelques clics !
            </p>
            
            <!-- Barre de recherche glassmorphique -->
            <div class="backdrop-blur-lg bg-white/90 rounded-3xl shadow-2xl p-6 md:p-8 animate-scale-in border border-white/20">
                <form action="{{ route('accommodations.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    <div class="flex-1 relative">
                        <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-neutral"></i>
                        <input 
                            type="text" 
                            name="search" 
                            placeholder="Rechercher un hébergement..." 
                            class="input-neomorphism w-full pl-12 pr-4 py-4 rounded-2xl text-gray-800"
                        >
                    </div>
                    <button type="submit" class="btn-neomorphism-secondary text-white px-10 py-4 rounded-2xl font-semibold flex items-center justify-center gap-2 whitespace-nowrap">
                        <i class="fas fa-search"></i>
                        <span>Rechercher</span>
                    </button>
                </form>
                
                <!-- Suggestions rapides -->
                <div class="mt-6 flex flex-wrap gap-3 justify-center">
                    <span class="text-gray-600 text-sm font-medium">Recherches populaires:</span>
                    <a href="{{ route('accommodations.index', ['search' => 'hôtel']) }}" class="badge-soft px-4 py-2 rounded-full text-sm font-medium text-primary">
                        Hôtels
                    </a>
                    <a href="{{ route('accommodations.index', ['search' => 'appartement']) }}" class="badge-soft px-4 py-2 rounded-full text-sm font-medium text-primary">
                        Appartements
                    </a>
                    <a href="{{ route('accommodations.index', ['search' => 'auberge']) }}" class="badge-soft px-4 py-2 rounded-full text-sm font-medium text-primary">
                        Auberges
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Vague décorative en bas -->
    <div class="absolute bottom-0 left-0 w-full">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 120" class="w-full">
            <path fill="#f9fafb" fill-opacity="1" d="M0,32L48,37.3C96,43,192,53,288,58.7C384,64,480,64,576,58.7C672,53,768,43,864,48C960,53,1056,75,1152,74.7C1248,75,1344,53,1392,42.7L1440,32L1440,120L1392,120C1344,120,1248,120,1152,120C1056,120,960,120,864,120C768,120,672,120,576,120C480,120,384,120,288,120C192,120,96,120,48,120L0,120Z"></path>
        </svg>
    </div>
</section>

<!-- Stats Section avec Neumorphisme -->
<section class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center animate-fade-in">
                <div class="card-neomorphism w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-home text-3xl text-secondary"></i>
                </div>
                <div class="text-4xl font-bold text-primary mb-2">500+</div>
                <div class="text-gray-600 font-medium">Hébergements</div>
            </div>
            <div class="text-center animate-fade-in" style="animation-delay: 0.1s">
                <div class="card-neomorphism w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-users text-3xl text-secondary"></i>
                </div>
                <div class="text-4xl font-bold text-primary mb-2">2000+</div>
                <div class="text-gray-600 font-medium">Clients Satisfaits</div>
            </div>
            <div class="text-center animate-fade-in" style="animation-delay: 0.2s">
                <div class="card-neomorphism w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-star text-3xl text-secondary"></i>
                </div>
                <div class="text-4xl font-bold text-primary mb-2">4.8/5</div>
                <div class="text-gray-600 font-medium">Note Moyenne</div>
            </div>
            <div class="text-center animate-fade-in" style="animation-delay: 0.3s">
                <div class="card-neomorphism w-20 h-20 mx-auto mb-4 rounded-2xl flex items-center justify-center">
                    <i class="fas fa-calendar-check text-3xl text-secondary"></i>
                </div>
                <div class="text-4xl font-bold text-primary mb-2">5000+</div>
                <div class="text-gray-600 font-medium">Réservations</div>
            </div>
        </div>
    </div>
</section>

<!-- Catégories avec Neumorphisme -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-4xl md:text-5xl font-bold text-dark mb-4">
                Explorez nos <span class="text-secondary">catégories</span>
            </h2>
            <p class="text-gray-600 text-lg">Trouvez l'hébergement qui correspond à vos besoins</p>
        </div>
        
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6">
            @foreach($categories as $category)
            <a href="{{ route('accommodations.index', ['category' => $category->id]) }}" 
               class="card-neomorphism rounded-2xl p-8 text-center group">
                <div class="text-6xl mb-4 group-hover:scale-110 transition-transform duration-300">
                    <i class="fas fa-{{ $category->icon ?? 'building' }} text-primary"></i>
                </div>
                <h3 class="text-xl font-bold text-dark mb-3 group-hover:text-secondary transition-colors">{{ $category->name }}</h3>
                <div class="badge-soft inline-flex items-center justify-center px-4 py-1 rounded-full text-sm text-primary font-semibold">
                    {{ $category->accommodations_count ?? 0 }} <i class="fas fa-home ml-2 text-xs"></i>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Hébergements populaires avec Glassmorphisme et Neumorphisme -->
<section class="py-20 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center mb-12 animate-fade-in">
            <div>
                <h2 class="text-4xl md:text-5xl font-bold text-dark mb-2 flex items-center gap-3">
                    <i class="fas fa-fire text-primary"></i> 
                    <span>Hébergements <span class="text-secondary">populaires</span></span>
                </h2>
                <p class="text-gray-600 text-lg">Les meilleures offres du moment</p>
            </div>
            <a href="{{ route('accommodations.index') }}" class="hidden md:flex items-center gap-2 text-primary hover:text-secondary transition-colors font-semibold hover-lift-subtle">
                Voir tout <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($popularAccommodations as $accommodation)
            <div class="card-neomorphism rounded-3xl overflow-hidden group">
                <!-- Image -->
                <div class="relative h-56 bg-gray-200 overflow-hidden">
                    @if($accommodation->primary_image)
                        <img src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                             alt="{{ $accommodation->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-image text-7xl text-neutral"></i>
                        </div>
                    @endif
                    
                    <!-- Badge catégorie glassmorphique -->
                    <div class="absolute top-4 left-4 backdrop-blur-lg bg-white/80 px-4 py-2 rounded-full text-sm font-semibold text-dark border border-white/20">
                        <i class="fas fa-{{ $accommodation->category->icon ?? 'building' }} mr-2 text-secondary"></i>
                        {{ $accommodation->category->name }}
                    </div>
                    
                    <!-- Badge favori -->
                    <div class="absolute top-4 right-4 card-neomorphism w-10 h-10 rounded-full flex items-center justify-center cursor-pointer hover:scale-110 transition-transform">
                        <i class="far fa-heart text-primary"></i>
                    </div>
                </div>
                
                <!-- Contenu -->
                <div class="p-6">
                    <h3 class="text-xl font-bold text-dark mb-3 line-clamp-2 group-hover:text-primary transition-colors">
                        {{ $accommodation->title }}
                    </h3>
                    
                    <div class="flex items-center text-gray-600 text-sm mb-4">
                        <i class="fas fa-map-marker-alt mr-2 text-secondary"></i>
                        <span class="font-medium">{{ $accommodation->quartier }}</span>
                    </div>
                    
                    <!-- Infos avec icônes -->
                    <div class="flex items-center gap-4 text-sm text-gray-600 mb-5 pb-5 border-b border-neutral border-opacity-20">
                        <div class="flex items-center gap-1">
                            <div class="card-inset w-8 h-8 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bed text-secondary text-sm"></i>
                            </div>
                            <span class="font-semibold">{{ $accommodation->nb_beds }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="card-inset w-8 h-8 rounded-lg flex items-center justify-center">
                                <i class="fas fa-users text-secondary text-sm"></i>
                            </div>
                            <span class="font-semibold">{{ $accommodation->max_guests }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <div class="card-inset w-8 h-8 rounded-lg flex items-center justify-center">
                                <i class="fas fa-bath text-secondary text-sm"></i>
                            </div>
                            <span class="font-semibold">{{ $accommodation->nb_bathrooms }}</span>
                        </div>
                    </div>
                    
                    <!-- Prix et note -->
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <div class="text-3xl font-bold text-primary">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }}</div>
                            <div class="text-gray-600 text-sm">FCFA / nuit</div>
                        </div>
                        <div class="flex items-center gap-1 badge-soft px-3 py-2 rounded-xl bg-yellow-50 border-yellow-200">
                            <i class="fas fa-star text-yellow-500"></i>
                            <span class="font-bold text-dark">{{ number_format($accommodation->average_rating, 1) }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ route('accommodations.show', $accommodation->id) }}" 
                       class="btn-neomorphism-secondary w-full text-white text-center py-3 rounded-xl font-semibold flex items-center justify-center gap-2">
                        <i class="fas fa-eye"></i> Voir les détails
                    </a>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Bouton mobile -->
        <div class="mt-10 text-center md:hidden">
            <a href="{{ route('accommodations.index') }}" class="inline-flex items-center gap-2 text-primary hover:text-secondary transition-colors font-semibold">
                Voir tout <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Pourquoi nous choisir avec Neumorphisme -->
<section class="py-20 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-16 animate-fade-in">
            <h2 class="text-4xl md:text-5xl font-bold text-dark mb-4">
                Pourquoi <span class="text-secondary">nous choisir</span> ?
            </h2>
            <p class="text-gray-600 text-lg">Une expérience de réservation unique et sécurisée</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <div class="text-center group animate-fade-in">
                <div class="relative inline-block mb-6">
                    <div class="card-neomorphism w-24 h-24 rounded-3xl flex items-center justify-center mx-auto group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-search-location text-5xl text-secondary"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-4">Recherche facile</h3>
                <p class="text-gray-600 leading-relaxed">
                    Trouvez rapidement l'hébergement parfait grâce à nos filtres avancés et notre interface intuitive.
                </p>
            </div>
            
            <div class="text-center group animate-fade-in" style="animation-delay: 0.1s">
                <div class="relative inline-block mb-6">
                    <div class="card-neomorphism w-24 h-24 rounded-3xl flex items-center justify-center mx-auto group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-shield-alt text-5xl text-primary"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-4">Réservation sécurisée</h3>
                <p class="text-gray-600 leading-relaxed">
                    Toutes nos offres sont vérifiées et nos paiements sont 100% sécurisés pour garantir votre tranquillité.
                </p>
            </div>
            
            <div class="text-center group animate-fade-in" style="animation-delay: 0.2s">
                <div class="relative inline-block mb-6">
                    <div class="card-neomorphism w-24 h-24 rounded-3xl flex items-center justify-center mx-auto group-hover:scale-105 transition-transform duration-300">
                        <i class="fas fa-headset text-5xl text-secondary"></i>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-4">Support 24/7</h3>
                <p class="text-gray-600 leading-relaxed">
                    Notre équipe est disponible à tout moment pour vous accompagner et répondre à vos questions.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- Call to action avec Glassmorphisme -->
<section class="py-20 bg-primary text-white relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-secondary rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 text-center relative z-10">
        <div class="max-w-3xl mx-auto">
            <div class="inline-block mb-6">
                <div class="backdrop-blur-lg bg-white/10 w-20 h-20 rounded-2xl flex items-center justify-center mx-auto border border-white/20">
                    <i class="fas fa-building text-4xl"></i>
                </div>
            </div>
            <h2 class="text-4xl md:text-5xl font-bold mb-6 animate-fade-in">
                Vous êtes propriétaire d'un hébergement ?
            </h2>
            <p class="text-xl md:text-2xl mb-10 text-gray-100 animate-fade-in">
                Rejoignez notre plateforme et augmentez votre visibilité auprès de milliers de voyageurs !
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center animate-fade-in">
                <a href="{{ route('register') }}" class="btn-neomorphism-secondary inline-flex items-center justify-center gap-3 bg-secondary text-white px-10 py-5 rounded-2xl font-bold text-lg">
                    <i class="fas fa-plus-circle text-2xl"></i>
                    <span>Publier mon hébergement</span>
                </a>
                <a href="#" class="inline-flex items-center justify-center gap-3 backdrop-blur-lg bg-white/10 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all duration-300 border-2 border-white/30">
                    <i class="fas fa-info-circle text-2xl"></i>
                    <span>En savoir plus</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection