@extends('layouts.app')

@section('title', 'Ajouter un hébergement')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-plus-circle"></i> Ajouter un hébergement
            </h1>
            <p class="text-white/90 text-lg">Remplissez le formulaire pour publier votre hébergement</p>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-white border-b border-gray-200 py-4 shadow-sm relative z-30">
    <div class="container mx-auto px-4">
        <nav class="flex items-center text-sm text-gray-500 font-medium">
            <a href="{{ route('owner.accommodations.index') }}" class="hover:text-primary transition flex items-center gap-1">
                <i class="fas fa-arrow-left"></i> Mes hébergements
            </a>
            <i class="fas fa-chevron-right mx-3 text-xs text-gray-300"></i>
            <span class="text-dark font-bold">Ajouter</span>
        </nav>
    </div>
</div>

<!-- Formulaire -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <form action="{{ route('owner.accommodations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                @if ($errors->any())
                    <div class="glass-card bg-red-50 border border-red-200 text-red-800 p-6 rounded-2xl animate-fade-in shadow-sm">
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 bg-red-100 text-red-500 rounded-full flex items-center justify-center flex-shrink-0 animate-pulse">
                                <i class="fas fa-exclamation-triangle text-xl"></i>
                            </div>
                            <div class="flex-1">
                                <strong class="font-bold text-lg mb-2 block">Veuillez corriger les erreurs suivantes :</strong>
                                <ul class="list-disc list-inside space-y-1 text-sm font-medium opacity-90">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                
                <!-- Informations de base -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                            <i class="fas fa-info-circle"></i>
                        </div>
                        Informations de base
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Titre de l'hébergement <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title"
                                name="title" 
                                value="{{ old('title') }}"
                                required
                                maxlength="255"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('title') border-red-500 @enderror"
                                placeholder="Ex: Appartement moderne au centre-ville"
                            >
                            @error('title')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-2 flex items-center gap-1 ml-1">
                                <i class="fas fa-lightbulb text-yellow-500"></i>
                                Un titre accrocheur attire plus de clients
                            </p>
                        </div>
                        
                        <!-- Catégorie -->
                        <div>
                            <label for="category_id" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <select 
                                    id="category_id"
                                    name="category_id" 
                                    required
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none @error('category_id') border-red-500 @enderror"
                                >
                                    <option value="">Sélectionnez une catégorie</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-gray-500">
                                    <i class="fas fa-chevron-down"></i>
                                </div>
                            </div>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="description"
                                name="description" 
                                required
                                rows="6"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none resize-y min-h-[120px] @error('description') border-red-500 @enderror"
                                placeholder="Décrivez votre hébergement en détail : équipements, environnement, services..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Prix -->
                        <div>
                            <label for="price_per_night" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Prix par nuit (FCFA) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input 
                                    type="number" 
                                    id="price_per_night"
                                    name="price_per_night" 
                                    value="{{ old('price_per_night') }}"
                                    required
                                    min="0"
                                    step="100"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-lg @error('price_per_night') border-red-500 @enderror"
                                    placeholder="Ex: 15000"
                                >
                                <div class="absolute right-5 top-1/2 -translate-y-1/2 font-bold text-gray-400 bg-gray-100 px-2 py-1 rounded text-xs">FCFA</div>
                            </div>
                            @error('price_per_night')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Localisation -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-secondary/10 flex items-center justify-center text-secondary">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        Localisation
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Adresse -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="address"
                                name="address" 
                                value="{{ old('address') }}"
                                required
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('address') border-red-500 @enderror"
                                placeholder="Ex: Avenue Ahidjo, face à la mairie"
                            >
                            @error('address')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Quartier -->
                        <div>
                            <label for="quartier" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Quartier <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="quartier"
                                name="quartier" 
                                value="{{ old('quartier') }}"
                                required
                                list="quartiers"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none @error('quartier') border-red-500 @enderror"
                                placeholder="Ex: Plateau"
                            >
                            <datalist id="quartiers">
                                <option value="Plateau">
                                <option value="Mardock">
                                <option value="Dang">
                                <option value="Bamyanga">
                                <option value="Baladji">
                                <option value="Petit Marché">
                            </datalist>
                            @error('quartier')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Coordonnées GPS -->
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Coordonnées GPS <span class="font-normal text-gray-400 text-xs">(Optionnel)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <input 
                                    type="number" 
                                    name="latitude" 
                                    value="{{ old('latitude') }}"
                                    step="0.0000001"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                    placeholder="Lat"
                                >
                                <input 
                                    type="number" 
                                    name="longitude" 
                                    value="{{ old('longitude') }}"
                                    step="0.0000001"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none"
                                    placeholder="Long"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Caractéristiques -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-orange-100 flex items-center justify-center text-orange-500">
                            <i class="fas fa-sliders-h"></i>
                        </div>
                        Caractéristiques
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Chambres -->
                        <div>
                            <label for="nb_rooms" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Chambres
                            </label>
                            <input 
                                type="number" 
                                id="nb_rooms"
                                name="nb_rooms" 
                                value="{{ old('nb_rooms', 1) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <!-- Lits -->
                        <div>
                            <label for="nb_beds" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Lits
                            </label>
                            <input 
                                type="number" 
                                id="nb_beds"
                                name="nb_beds" 
                                value="{{ old('nb_beds', 1) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <!-- Salles de bain -->
                        <div>
                            <label for="nb_bathrooms" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Salles de bain
                            </label>
                            <input 
                                type="number" 
                                id="nb_bathrooms"
                                name="nb_bathrooms" 
                                value="{{ old('nb_bathrooms', 1) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <!-- Capacité -->
                        <div>
                            <label for="max_guests" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Invités max
                            </label>
                            <input 
                                type="number" 
                                id="max_guests"
                                name="max_guests" 
                                value="{{ old('max_guests', 2) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                    </div>
                </div>
                
                <!-- Équipements -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-green-100 flex items-center justify-center text-green-500">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        Équipements et services
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @php
                            $amenities = [
                                'WiFi gratuit', 'Climatisation', 'Ventilateur', 'TV satellite',
                                'Eau chaude', 'Parking', 'Restaurant', 'Bar',
                                'Piscine', 'Salle de sport', 'Jardin', 'Balcon',
                                'Cuisine équipée', 'Réfrigérateur', 'Micro-ondes', 'Machine à laver',
                                'Service en chambre', 'Petit-déjeuner', 'Sécurité 24h/24', 'Générateur'
                            ];
                        @endphp
                        
                        @foreach($amenities as $amenity)
                            <label class="group flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-secondary/30 hover:bg-secondary/5 cursor-pointer transition-all">
                                <div class="relative flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="amenities[]" 
                                        value="{{ $amenity }}"
                                        {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}
                                        class="peer h-5 w-5 cursor-pointer appearance-none rounded border border-gray-300 shadow-sm transition-all checked:border-secondary checked:bg-secondary hover:shadow-md"
                                    >
                                    <div class="pointer-events-none absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 text-white opacity-0 transition-opacity peer-checked:opacity-100">
                                        <i class="fas fa-check text-xs"></i>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-700 font-medium group-hover:text-dark">{{ $amenity }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Photos -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-purple-100 flex items-center justify-center text-purple-500">
                            <i class="fas fa-camera"></i>
                        </div>
                        Photos
                    </h2>
                    
                    <div class="border-3 border-dashed border-gray-200 rounded-3xl p-12 text-center hover:border-secondary/50 hover:bg-secondary/5 transition-all cursor-pointer group bg-gray-50/50">
                        <input 
                            type="file" 
                            id="images"
                            name="images[]" 
                            multiple
                            accept="image/*"
                            class="hidden"
                            onchange="previewImages(this)"
                        >
                        <label for="images" class="cursor-pointer block">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center bg-white shadow-md text-gray-400 group-hover:text-secondary group-hover:scale-110 transition-all">
                                <i class="fas fa-cloud-upload-alt text-4xl"></i>
                            </div>
                            <p class="text-xl font-bold text-dark mb-2">Cliquez pour ajouter des photos</p>
                            <p class="text-gray-500 mb-4">ou glissez-déposez vos images ici</p>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-xs font-bold text-gray-500">
                                <span>JPG, PNG, WEBP</span>
                                <span class="w-1 h-1 rounded-full bg-gray-400"></span>
                                <span>Max 2MB</span>
                            </div>
                        </label>
                    </div>
                    
                    <!-- Prévisualisation -->
                    <div id="preview-container" class="hidden mt-8">
                        <p class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-images text-secondary"></i>
                            Images sélectionnées :
                        </p>
                        <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                        <div class="mt-8 p-4 bg-gray-50 rounded-2xl border border-gray-100 flex items-start gap-3">
                            <i class="fas fa-info-circle text-secondary text-lg mt-0.5"></i>
                            <div class="text-sm text-gray-600">
                                <span class="font-bold text-dark">Conseil pro :</span> Ajoutez au moins 5 photos de haute qualité. La première image sélectionnée sera utilisée comme image de couverture.
                            </div>
                        </div>
                    </div>
                    
                    @error('images')
                        <p class="text-red-500 text-sm mt-3 flex items-center font-bold">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4">
                    <a href="{{ route('owner.accommodations.index') }}" 
                       class="flex-1 sm:flex-initial px-8 py-4 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 hover:text-dark text-center transition">
                        Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 btn-primary text-white px-8 py-4 rounded-xl font-bold shadow-lg shadow-primary/30 hover:shadow-primary/50 hover-lift flex items-center justify-center gap-2">
                        <i class="fas fa-paper-plane"></i>
                        <span>Publier l'hébergement</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    function previewImages(input) {
        const previewContainer = document.getElementById('preview-container');
        const previewGrid = document.getElementById('preview-grid');
        
        if (input.files && input.files.length > 0) {
            previewContainer.classList.remove('hidden');
            previewContainer.classList.add('animate-fade-in');
            previewGrid.innerHTML = '';
            
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group rounded-2xl overflow-hidden aspect-[4/3] shadow-md border border-gray-100';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="absolute top-2 right-2 backdrop-blur-md bg-black/60 text-white px-2 py-1 rounded-lg text-xs font-bold border border-white/20">
                            ${index === 0 ? '<i class="fas fa-star text-yellow-400 mr-1"></i>Principale' : `Img ${index + 1}`}
                        </div>
                    `;
                    previewGrid.appendChild(div);
                }
                
                reader.readAsDataURL(file);
            });
        } else {
            previewContainer.classList.add('hidden');
        }
    }
</script>
@endpush