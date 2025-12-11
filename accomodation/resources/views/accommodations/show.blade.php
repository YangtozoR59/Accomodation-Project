@extends('layouts.app')

@section('title', $accommodation->title)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-accent transition">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('accommodations.index') }}" class="hover:text-accent transition">Hébergements</a>
            <span class="mx-2">/</span>
            <span class="text-dark">{{ $accommodation->title }}</span>
        </nav>
    </div>
</div>

<!-- Contenu principal -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche: Détails -->
            <div class="lg:col-span-2">
                
                <!-- En-tête -->
                <div class="mb-6 fade-in">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-dark mb-2">
                                {{ $accommodation->title }}
                            </h1>
                            <div class="flex items-center gap-4 text-gray-600">
                                <span><i class="fas fa-map-marker-alt text-accent mr-1"></i> {{ $accommodation->quartier }}</span>
                                <span><i class="fas fa-eye text-accent mr-1"></i> {{ $accommodation->views_count }} vues</span>
                                @if($accommodation->reviews->count() > 0)
                                    <span>
                                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                                        <strong>{{ number_format($accommodation->average_rating, 1) }}</strong>
                                        ({{ $accommodation->reviews->count() }} avis)
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($accommodation->is_verified)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-check-circle mr-1"></i> Vérifié
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Galerie d'images -->
                <div class="mb-8 fade-in">
                    @if($accommodation->images->count() > 0)
                        <div class="grid grid-cols-4 gap-2">
                            <!-- Image principale -->
                            <div class="col-span-4 md:col-span-2 md:row-span-2">
                                <img 
                                    src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                    alt="{{ $accommodation->title }}"
                                    class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                                    onclick="openLightbox(0)"
                                >
                            </div>
                            
                            <!-- Images secondaires -->
                            @foreach($accommodation->images->take(4) as $index => $image)
                                @if(!$image->is_primary)
                                    <div class="col-span-2 md:col-span-1">
                                        <img 
                                            src="{{ asset('storage/' . $image->path) }}" 
                                            alt="Image {{ $index + 1 }}"
                                            class="w-full h-32 md:h-48 object-cover rounded-lg cursor-pointer hover:opacity-90 transition"
                                            onclick="openLightbox({{ $index }})"
                                        >
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if($accommodation->images->count() > 5)
                            <button class="mt-2 text-accent hover:text-dark transition" onclick="openLightbox(0)">
                                <i class="fas fa-images mr-1"></i> Voir toutes les photos ({{ $accommodation->images->count() }})
                            </button>
                        @endif
                    @else
                        <div class="bg-gray-200 rounded-lg h-96 flex items-center justify-center">
                            <i class="fas fa-image text-9xl text-gray-400"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Informations -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-4">
                        <i class="fas fa-info-circle text-accent mr-2"></i> Informations
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                        <div class="text-center p-4 bg-primary/20 rounded-lg">
                            <i class="fas fa-bed text-3xl text-accent mb-2"></i>
                            <p class="font-bold text-dark">{{ $accommodation->nb_rooms }}</p>
                            <p class="text-sm text-gray-600">Chambre(s)</p>
                        </div>
                        <div class="text-center p-4 bg-secondary/20 rounded-lg">
                            <i class="fas fa-bed text-3xl text-accent mb-2"></i>
                            <p class="font-bold text-dark">{{ $accommodation->nb_beds }}</p>
                            <p class="text-sm text-gray-600">Lit(s)</p>
                        </div>
                        <div class="text-center p-4 bg-accent/20 rounded-lg">
                            <i class="fas fa-bath text-3xl text-dark mb-2"></i>
                            <p class="font-bold text-dark">{{ $accommodation->nb_bathrooms }}</p>
                            <p class="text-sm text-gray-600">Salle(s) de bain</p>
                        </div>
                        <div class="text-center p-4 bg-primary/20 rounded-lg">
                            <i class="fas fa-users text-3xl text-accent mb-2"></i>
                            <p class="font-bold text-dark">{{ $accommodation->max_guests }}</p>
                            <p class="text-sm text-gray-600">Invité(s)</p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <h3 class="text-xl font-bold text-dark mb-3">Description</h3>
                    <p class="text-gray-700 leading-relaxed mb-6">
                        {{ $accommodation->description }}
                    </p>
                    
                    {{-- <!-- Équipements -->
                    @if($accommodation->amenities)
                        <h3 class="text-xl font-bold text-dark mb-3">
                            <i class="fas fa-check-circle text-accent mr-2"></i> Équipements
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($accommodation->amenities as $amenity)
                                <div class="flex items-center text-gray-700">
                                    <i class="fas fa-check text-green-500 mr-2"></i>
                                    {{ $amenity }}
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div> --}}
                
                <!-- Localisation -->
                <div class="bg-white rounded-xl shadow-lg p-6 mb-8 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-4">
                        <i class="fas fa-map-marker-alt text-accent mr-2"></i> Localisation
                    </h2>
                    <p class="text-gray-700 mb-4">
                        <i class="fas fa-map-pin text-accent mr-2"></i>
                        {{ $accommodation->address }}, {{ $accommodation->quartier }}
                    </p>
                    
                    <!-- Map placeholder -->
                    <div class="bg-gray-200 rounded-lg h-64 flex items-center justify-center">
                        <p class="text-gray-500">
                            <i class="fas fa-map text-4xl mb-2"></i><br>
                            Carte à venir
                        </p>
                    </div>
                </div>
                
                <!-- Avis -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in" id="reviews">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-star text-yellow-400 mr-2"></i> 
                        Avis des clients ({{ $accommodation->reviews->count() }})
                    </h2>
                    
                    @if($accommodation->reviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($accommodation->reviews->take(5) as $review)
                                <div class="border-b pb-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-semibold text-dark">{{ $review->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow-400' : 'gray-300' }}"></i>
                                            @endfor
                                        </div>
                                    </div>
                                    
                                    @if($review->comment)
                                        <p class="text-gray-700">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-8">
                            <i class="fas fa-comment-slash text-4xl mb-3"></i><br>
                            Aucun avis pour le moment
                        </p>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite: Réservation -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-xl p-6 sticky top-20 fade-in">
                    <div class="text-center mb-6">
                        <span class="text-4xl font-bold text-accent">
                            {{ number_format($accommodation->price_per_night, 0, ',', ' ') }}
                        </span>
                        <span class="text-gray-600"> FCFA</span>
                        <p class="text-gray-600 text-sm">par nuit</p>
                    </div>
                    
                    <form action="{{ route('reservations.store') }}" method="POST" id="reservation-form">
                        @csrf
                        <input type="hidden" name="accommodation_id" value="{{ $accommodation->id }}">
                        
                        <div class="space-y-4 mb-6">
                            <!-- Arrivée -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-check mr-1"></i> Arrivée
                                </label>
                                <input 
                                    type="date" 
                                    name="check_in" 
                                    id="check_in"
                                    min="{{ date('Y-m-d') }}"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                            
                            <!-- Départ -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-times mr-1"></i> Départ
                                </label>
                                <input 
                                    type="date" 
                                    name="check_out" 
                                    id="check_out"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                            </div>
                            
                            <!-- Nombre d'invités -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-users mr-1"></i> Invités
                                </label>
                                <input 
                                    type="number" 
                                    name="nb_guests" 
                                    min="1" 
                                    max="{{ $accommodation->max_guests }}"
                                    value="2"
                                    required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                >
                                <p class="text-xs text-gray-500 mt-1">Maximum: {{ $accommodation->max_guests }} invités</p>
                            </div>
                            
                            <!-- Demandes spéciales -->
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-comment mr-1"></i> Demandes spéciales (optionnel)
                                </label>
                                <textarea 
                                    name="special_requests" 
                                    rows="3"
                                    placeholder="Ex: Arrivée tardive, lit bébé..."
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                ></textarea>
                            </div>
                        </div>
                        
                        <!-- Récapitulatif -->
                        <div id="booking-summary" class="hidden bg-primary/20 rounded-lg p-4 mb-4">
                            <div class="flex justify-between text-sm mb-2">
                                <span>Prix par nuit</span>
                                <span id="price-per-night">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2">
                                <span>Nombre de nuits</span>
                                <span id="nb-nights">-</span>
                            </div>
                            <hr class="my-2">
                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span id="total-price" class="text-accent">-</span>
                            </div>
                        </div>
                        
                        @auth
                            <button type="submit" class="w-full btn-primary text-white py-3 rounded-lg font-bold text-lg">
                                <i class="fas fa-calendar-check mr-2"></i> Réserver maintenant
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="block w-full btn-primary text-white py-3 rounded-lg font-bold text-lg text-center">
                                <i class="fas fa-sign-in-alt mr-2"></i> Connexion pour réserver
                            </a>
                        @endauth
                    </form>
                    
                    <!-- Contact propriétaire -->
                    <div class="mt-6 pt-6 border-t">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white text-xl">
                                {{ strtoupper(substr($accommodation->owner->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-semibold text-dark">{{ $accommodation->owner->name }}</p>
                                <p class="text-sm text-gray-600">Propriétaire</p>
                            </div>
                        </div>
                        
                        @if($accommodation->owner->phone)
                            <a href="tel:{{ $accommodation->owner->phone }}" 
                               class="block w-full text-center border-2 border-accent text-accent py-2 rounded-lg hover:bg-accent hover:text-white transition">
                                <i class="fas fa-phone mr-2"></i> Contacter
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hébergements similaires -->
        @if($similar->count() > 0)
            <div class="mt-16">
                <h2 class="text-3xl font-bold text-dark mb-8 fade-in">
                    <i class="fas fa-thumbs-up text-accent mr-2"></i> Vous pourriez aussi aimer
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similar as $item)
                        <div class="bg-white rounded-xl shadow-lg overflow-hidden hover-lift">
                            <div class="relative h-48 bg-gray-200">
                                @if($item->primary_image)
                                    <img src="{{ asset('storage/' . $item->primary_image->path) }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-dark mb-2 line-clamp-2">{{ $item->title }}</h3>
                                <p class="text-accent font-bold">{{ number_format($item->price_per_night, 0, ',', ' ') }} FCFA/nuit</p>
                                <a href="{{ route('accommodations.show', $item->id) }}" 
                                   class="mt-3 block text-center border border-accent text-accent py-2 rounded-lg hover:bg-accent hover:text-white transition">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Calculer le prix total
    const pricePerNight = {{ $accommodation->price_per_night }};
    const checkInInput = document.getElementById('check_in');
    const checkOutInput = document.getElementById('check_out');
    
    function calculateTotal() {
        if(checkInInput.value && checkOutInput.value) {
            const checkIn = new Date(checkInInput.value);
            const checkOut = new Date(checkOutInput.value);
            const diffTime = Math.abs(checkOut - checkIn);
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
            
            if(diffDays > 0) {
                const total = diffDays * pricePerNight;
                document.getElementById('nb-nights').textContent = diffDays;
                document.getElementById('total-price').textContent = total.toLocaleString('fr-FR') + ' FCFA';
                document.getElementById('booking-summary').classList.remove('hidden');
            }
        }
    }
    
    checkInInput.addEventListener('change', function() {
        checkOutInput.min = this.value;
        calculateTotal();
    });
    
    checkOutInput.addEventListener('change', calculateTotal);
</script>
@endpush