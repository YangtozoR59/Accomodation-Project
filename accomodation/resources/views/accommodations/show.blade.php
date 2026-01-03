@extends('layouts.app')

@section('title', $accommodation->title)

@section('content')

<!-- Breadcrumb -->
<div class="bg-gray-50 border-b border-gray-200 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('home') }}" class="hover:text-primary transition">Accueil</a>
            <span class="mx-2">/</span>
            <a href="{{ route('accommodations.index') }}" class="hover:text-primary transition">Hébergements</a>
            <span class="mx-2">/</span>
            <span class="text-gray-900 font-medium">{{ $accommodation->title }}</span>
        </nav>
    </div>
</div>

<!-- Contenu principal -->
<section class="py-8 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Colonne gauche: Détails -->
            <div class="lg:col-span-2">
                
                <!-- En-tête -->
                <div class="mb-6 animate-fade-in">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <h1 class="text-3xl md:text-4xl font-bold text-dark mb-2">
                                {{ $accommodation->title }}
                            </h1>
                            <div class="flex items-center gap-4 text-gray-600">
                                <span><i class="fas fa-map-marker-alt text-secondary mr-1"></i> {{ $accommodation->quartier }}</span>
                                <span><i class="fas fa-eye text-primary/70 mr-1"></i> {{ $accommodation->views_count }} vues</span>
                                @if($accommodation->reviews->count() > 0)
                                    <span class="flex items-center">
                                        <i class="fas fa-star text-yellow-500 mr-1"></i>
                                        <strong>{{ number_format($accommodation->average_rating, 1) }}</strong>
                                        <span class="text-gray-400 ml-1">({{ $accommodation->reviews->count() }} avis)</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        @if($accommodation->is_verified)
                            <span class="bg-green-100 text-green-800 px-4 py-2 rounded-full text-sm font-semibold flex items-center shadow-sm">
                                <i class="fas fa-check-circle mr-1"></i> Vérifié
                            </span>
                        @endif
                    </div>
                </div>
                
                <!-- Galerie d'images -->
                <div class="mb-8 animate-fade-in rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-white">
                    @if($accommodation->images->count() > 0)
                        <div class="grid grid-cols-4 gap-2">
                            <!-- Image principale -->
                            <div class="col-span-4 md:col-span-2 md:row-span-2 relative group">
                                <img 
                                    src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                    alt="{{ $accommodation->title }}"
                                    class="w-full h-full object-cover cursor-pointer hover:opacity-95 transition duration-300"
                                    onclick="openLightbox(0)"
                                >
                                <div class="absolute inset-0 bg-black/10 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none"></div>
                            </div>
                            
                            <!-- Images secondaires -->
                            @foreach($accommodation->images->take(4) as $index => $image)
                                @if(!$image->is_primary)
                                    <div class="col-span-2 md:col-span-1 relative group">
                                        <img 
                                            src="{{ asset('storage/' . $image->path) }}" 
                                            alt="Image {{ $index + 1 }}"
                                            class="w-full h-32 md:h-48 object-cover cursor-pointer hover:opacity-95 transition duration-300"
                                            onclick="openLightbox({{ $index }})"
                                        >
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        
                        @if($accommodation->images->count() > 5)
                            <div class="p-4 bg-white text-center">
                                <button class="mt-2 text-primary font-semibold hover:text-secondary transition flex items-center justify-center gap-2 mx-auto" onclick="openLightbox(0)">
                                    <i class="fas fa-images"></i> Voir toutes les photos ({{ $accommodation->images->count() }})
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="bg-gray-100 h-96 flex items-center justify-center">
                            <i class="fas fa-image text-7xl text-gray-300"></i>
                        </div>
                    @endif
                </div>
                
                <!-- Informations -->
                <div class="glass-card bg-white rounded-2xl p-8 mb-8 animate-fade-in shadow-sm">
                    <h2 class="text-2xl font-bold text-dark mb-6 flex items-center">
                        <i class="fas fa-info-circle text-secondary mr-3 text-xl"></i> Informations
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <i class="fas fa-door-open text-3xl text-secondary mb-3"></i>
                            <p class="font-bold text-dark text-lg">{{ $accommodation->nb_rooms }}</p>
                            <p class="text-sm text-gray-500 font-medium">Chambre(s)</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <i class="fas fa-bed text-3xl text-secondary mb-3"></i>
                            <p class="font-bold text-dark text-lg">{{ $accommodation->nb_beds }}</p>
                            <p class="text-sm text-gray-500 font-medium">Lit(s)</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <i class="fas fa-bath text-3xl text-secondary mb-3"></i>
                            <p class="font-bold text-dark text-lg">{{ $accommodation->nb_bathrooms }}</p>
                            <p class="text-sm text-gray-500 font-medium">Salle(s) de bain</p>
                        </div>
                        <div class="text-center p-4 bg-gray-50 rounded-2xl border border-gray-100">
                            <i class="fas fa-users text-3xl text-secondary mb-3"></i>
                            <p class="font-bold text-dark text-lg">{{ $accommodation->max_guests }}</p>
                            <p class="text-sm text-gray-500 font-medium">Invité(s)</p>
                        </div>
                    </div>
                    
                    <!-- Description -->
                    <div class="prose max-w-none text-gray-600">
                        <h3 class="text-xl font-bold text-dark mb-3">À propos de ce logement</h3>
                        <p class="leading-relaxed whitespace-pre-line">{{ $accommodation->description }}</p>
                    </div>
                </div>
                
                <!-- Localisation -->
                <div class="glass-card bg-white rounded-2xl p-8 mb-8 animate-fade-in shadow-sm">
                    <h2 class="text-2xl font-bold text-dark mb-4 flex items-center">
                        <i class="fas fa-map-marker-alt text-secondary mr-3 text-xl"></i> Localisation
                    </h2>
                    <p class="text-gray-600 mb-6 flex items-center">
                        <i class="fas fa-map-pin text-gray-400 mr-2"></i>
                        {{ $accommodation->address }}, {{ $accommodation->quartier }}
                    </p>
                    
                    <div class="bg-gray-100 rounded-2xl h-64 flex items-center justify-center border border-gray-200">
                        <div class="text-center text-gray-400">
                            <i class="fas fa-map-marked-alt text-5xl mb-3"></i>
                            <p>Carte interactive indisponible</p>
                        </div>
                    </div>
                </div>
                
                <!-- Avis -->
                <div class="glass-card bg-white rounded-2xl p-8 animate-fade-in shadow-sm" id="reviews">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center">
                        <i class="fas fa-star text-yellow-500 mr-3 text-xl"></i> 
                        Avis des clients <span class="text-gray-400 text-lg ml-2 font-normal">({{ $accommodation->reviews->count() }})</span>
                    </h2>
                    
                    @if($accommodation->reviews->count() > 0)
                        <div class="space-y-8">
                            @foreach($accommodation->reviews->take(5) as $review)
                                <div class="border-b border-gray-100 pb-8 last:border-0 last:pb-0">
                                    <div class="flex items-center justify-between mb-4">
                                        <div class="flex items-center gap-4">
                                            <div class="w-12 h-12 bg-gradient-to-br from-secondary to-primary rounded-full flex items-center justify-center text-white font-bold text-lg shadow-md">
                                                {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <p class="font-bold text-dark text-lg">{{ $review->user->name }}</p>
                                                <p class="text-sm text-gray-500">{{ $review->created_at->format('d/m/Y') }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="bg-yellow-50 px-3 py-1 rounded-lg flex items-center gap-1">
                                            <i class="fas fa-star text-yellow-500 text-sm"></i>
                                            <span class="font-bold text-gray-800">{{ $review->rating }}</span>
                                        </div>
                                    </div>
                                    
                                    @if($review->comment)
                                        <p class="text-gray-600 leading-relaxed pl-[4rem]">{{ $review->comment }}</p>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12 bg-gray-50 rounded-2xl border border-gray-100">
                            <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm">
                                <i class="far fa-comment-dots text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-1">Aucun avis pour le moment</h3>
                            <p class="text-gray-500">Soyez le premier à partager votre expérience !</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Colonne droite: Réservation -->
            <div class="lg:col-span-1">
                <div class="glass-card bg-white rounded-2xl p-6 sticky top-24 animate-fade-in shadow-xl border border-white/20">
                    <div class="flex items-end gap-2 mb-6 pb-6 border-b border-gray-100">
                        <span class="text-3xl font-bold text-primary">
                            {{ number_format($accommodation->price_per_night, 0, ',', ' ') }}
                        </span>
                        <div class="mb-1">
                            <span class="text-lg font-bold text-gray-800">FCFA</span>
                            <span class="text-gray-500 text-sm">/ nuit</span>
                        </div>
                    </div>

                    {{-- Messages de succès / erreurs de réservation --}}
                    @if(session('success'))
                        <div class="mb-4 rounded-xl bg-green-50 text-green-800 px-4 py-3 text-sm border border-green-100 flex items-start gap-2">
                            <i class="fas fa-check-circle mt-0.5"></i>
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="mb-4 rounded-xl bg-red-50 text-red-800 px-4 py-3 text-sm border border-red-100">
                            <ul class="list-disc pl-5 space-y-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('reservations.store') }}" method="POST" id="reservation-form">
                        @csrf
                        <input type="hidden" name="accommodation_id" value="{{ $accommodation->id }}">
                        
                        <div class="space-y-4 mb-6">
                            <!-- Dates -->
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                        Arrivée
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            name="check_in" 
                                            id="check_in"
                                            min="{{ date('Y-m-d') }}"
                                            required
                                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all outline-none"
                                        >
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                        Départ
                                    </label>
                                    <div class="relative">
                                        <input 
                                            type="date" 
                                            name="check_out" 
                                            id="check_out"
                                            required
                                            class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all outline-none"
                                        >
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Nombre d'invités -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                    Invités
                                </label>
                                <div class="relative">
                                    <i class="fas fa-user-friends absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                    <input 
                                        type="number" 
                                        name="nb_guests" 
                                        min="1" 
                                        max="{{ $accommodation->max_guests }}"
                                        value="2"
                                        required
                                        class="w-full pl-9 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all outline-none"
                                    >
                                </div>
                                <p class="text-xs text-gray-500 mt-1 text-right">Max: {{ $accommodation->max_guests }} pers.</p>
                            </div>
                            
                            <!-- Demandes spéciales -->
                            <div>
                                <label class="block text-xs font-bold uppercase tracking-wider text-gray-500 mb-1">
                                    Demandes spéciales (Optionnel)
                                </label>
                                <textarea 
                                    name="special_requests" 
                                    rows="2"
                                    placeholder="Ex: Arrivée tardive, lit bébé..."
                                    class="w-full px-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm text-gray-800 focus:ring-2 focus:ring-primary focus:border-primary focus:bg-white transition-all outline-none"
                                ></textarea>
                            </div>
                        </div>
                        
                        <!-- Récapitulatif -->
                        <div id="booking-summary" class="hidden bg-gray-50 rounded-xl p-4 mb-6 border border-gray-100">
                            <div class="flex justify-between text-sm mb-2 text-gray-600">
                                <span>Prix par nuit</span>
                                <span id="price-per-night">{{ number_format($accommodation->price_per_night, 0, ',', ' ') }} FCFA</span>
                            </div>
                            <div class="flex justify-between text-sm mb-2 text-gray-600">
                                <span>Nombre de nuits</span>
                                <span id="nb-nights">-</span>
                            </div>
                            <hr class="my-3 border-gray-200">
                            <div class="flex justify-between font-bold text-lg">
                                <span class="text-gray-900">Total</span>
                                <span id="total-price" class="text-primary">-</span>
                            </div>
                        </div>
                        
                        @auth
                            <button type="submit" class="w-full btn-primary text-white py-3.5 rounded-xl font-bold text-lg hover-lift shadow-lg hover:shadow-primary/30">
                                <i class="fas fa-check-circle mr-2"></i> Réserver
                            </button>
                        @else
                            <a href="{{ route('login') }}" class="block w-full btn-secondary text-white py-3.5 rounded-xl font-bold text-lg text-center hover-lift shadow-lg">
                                <i class="fas fa-sign-in-alt mr-2"></i> Se connecter
                            </a>
                            <p class="text-center text-xs text-gray-500 mt-2">Vous devez être connecté pour réserver.</p>
                        @endauth
                    </form>
                    
                    <!-- Contact propriétaire -->
                    <div class="mt-6 pt-6 border-t border-gray-100">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-600 font-bold">
                                {{ strtoupper(substr($accommodation->owner->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-xs text-gray-500 font-medium uppercase tracking-wide">Propriétaire</p>
                                <p class="font-bold text-dark text-sm">{{ $accommodation->owner->name }}</p>
                            </div>
                        </div>
                        
                        @if($accommodation->owner->phone)
                            <a href="tel:{{ $accommodation->owner->phone }}" 
                               class="flex items-center justify-center w-full px-4 py-2 border border-secondary text-secondary rounded-xl hover:bg-secondary hover:text-white transition-colors text-sm font-semibold">
                                <i class="fas fa-phone-alt mr-2"></i> Contacter
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Hébergements similaires -->
        @if($similar->count() > 0)
            <div class="mt-20">
                <h2 class="text-2xl font-bold text-dark mb-8 flex items-center">
                    <i class="fas fa-magic text-accent mr-2"></i> Hébergements similaires
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($similar as $item)
                        <div class="glass-card bg-white rounded-2xl overflow-hidden hover-lift group">
                            <div class="relative h-48 bg-gray-200 overflow-hidden">
                                @if($item->primary_image)
                                    <img src="{{ asset('storage/' . $item->primary_image->path) }}" 
                                         alt="{{ $item->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="fas fa-image text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-opacity"></div>
                            </div>
                            <div class="p-4">
                                <div class="flex justify-between items-start mb-2">
                                    <h3 class="font-bold text-dark line-clamp-1 group-hover:text-primary transition-colors flex-1">{{ $item->title }}</h3>
                                    <div class="flex items-center gap-1 text-xs font-bold text-yellow-500 bg-yellow-50 px-2 py-0.5 rounded">
                                        <i class="fas fa-star"></i> {{ number_format($item->average_rating, 1) }}
                                    </div>
                                </div>
                                <p class="text-primary font-bold text-lg mb-3">{{ number_format($item->price_per_night, 0, ',', ' ') }} <span class="text-xs text-gray-500 font-normal">FCFA/nuit</span></p>
                                <a href="{{ route('accommodations.show', $item->id) }}" 
                                   class="block w-full text-center py-2 bg-gray-50 text-gray-700 rounded-lg text-sm font-semibold hover:bg-secondary hover:text-white transition-colors">
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
            const diffTime = checkOut - checkIn;
            
            // Validation basique
            if(diffTime <= 0) {
                // Si date départ <= date arrivée, pas de calcul
                document.getElementById('booking-summary').classList.add('hidden');
                return;
            }

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
        // La date de départ doit être au moins le lendemain
        const nextDay = new Date(this.value);
        nextDay.setDate(nextDay.getDate() + 1);
        checkOutInput.min = nextDay.toISOString().split('T')[0];
        
        if(checkOutInput.value && checkOutInput.value <= this.value) {
            checkOutInput.value = '';
            document.getElementById('booking-summary').classList.add('hidden');
        } else {
            calculateTotal();
        }
    });
    
    checkOutInput.addEventListener('change', calculateTotal);
    
    // Lightbox minimaliste
    function openLightbox(index) {
        // Implémentation simplifiée ou utilisation d'une librairie existante
        // Pour l'instant, on pourrait juste faire un overlay simple
        console.log('Open lightbox for image index: ' + index);
    }
</script>
@endpush