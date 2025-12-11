@extends('layouts.app')

@section('title', 'Ajouter un hébergement')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-plus-circle mr-2"></i> Ajouter un hébergement
        </h1>
        <p class="text-white/90 mt-2">Remplissez le formulaire pour publier votre hébergement</p>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('owner.accommodations.index') }}" class="hover:text-accent transition">Mes hébergements</a>
            <span class="mx-2">/</span>
            <span class="text-dark">Ajouter</span>
        </nav>
    </div>
</div>

<!-- Formulaire -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <form action="{{ route('owner.accommodations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                
                <!-- Informations de base -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-info-circle text-accent mr-2"></i> Informations de base
                    </h2>
                    
                    <div class="space-y-6">
                        <!-- Titre -->
                        <div>
                            <label for="title" class="block text-sm font-semibold text-gray-700 mb-2">
                                Titre de l'hébergement <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="title"
                                name="title" 
                                value="{{ old('title') }}"
                                required
                                maxlength="255"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('title') border-red-500 @enderror"
                                placeholder="Ex: Appartement moderne au centre-ville"
                            >
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Un titre accrocheur attire plus de clients</p>
                        </div>
                        
                        <!-- Catégorie -->
                        <div>
                            <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">
                                Catégorie <span class="text-red-500">*</span>
                            </label>
                            <select 
                                id="category_id"
                                name="category_id" 
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('category_id') border-red-500 @enderror"
                            >
                                <option value="">Sélectionnez une catégorie</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Description -->
                        <div>
                            <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                                Description <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                id="description"
                                name="description" 
                                required
                                rows="6"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('description') border-red-500 @enderror"
                                placeholder="Décrivez votre hébergement en détail : équipements, environnement, services..."
                            >{{ old('description') }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Plus la description est détaillée, plus elle est attrayante</p>
                        </div>
                        
                        <!-- Prix -->
                        <div>
                            <label for="price_per_night" class="block text-sm font-semibold text-gray-700 mb-2">
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
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('price_per_night') border-red-500 @enderror"
                                    placeholder="Ex: 15000"
                                >
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">FCFA</span>
                            </div>
                            @error('price_per_night')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Localisation -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-map-marker-alt text-accent mr-2"></i> Localisation
                    </h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Adresse -->
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="address"
                                name="address" 
                                value="{{ old('address') }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('address') border-red-500 @enderror"
                                placeholder="Ex: Avenue Ahidjo, face à la mairie"
                            >
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Quartier -->
                        <div>
                            <label for="quartier" class="block text-sm font-semibold text-gray-700 mb-2">
                                Quartier <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="quartier"
                                name="quartier" 
                                value="{{ old('quartier') }}"
                                required
                                list="quartiers"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('quartier') border-red-500 @enderror"
                                placeholder="Ex: Plateau, Mardock..."
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
                                <p class="text-red-500 text-sm mt-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <!-- Coordonnées GPS (optionnel) -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Coordonnées GPS (optionnel)
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input 
                                    type="number" 
                                    name="latitude" 
                                    value="{{ old('latitude') }}"
                                    step="0.0000001"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                    placeholder="Latitude"
                                >
                                <input 
                                    type="number" 
                                    name="longitude" 
                                    value="{{ old('longitude') }}"
                                    step="0.0000001"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                    placeholder="Longitude"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Caractéristiques -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-sliders-h text-accent mr-2"></i> Caractéristiques
                    </h2>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <!-- Chambres -->
                        <div>
                            <label for="nb_rooms" class="block text-sm font-semibold text-gray-700 mb-2">
                                Chambres <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_rooms"
                                name="nb_rooms" 
                                value="{{ old('nb_rooms', 1) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('nb_rooms') border-red-500 @enderror"
                            >
                            @error('nb_rooms')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Lits -->
                        <div>
                            <label for="nb_beds" class="block text-sm font-semibold text-gray-700 mb-2">
                                Lits <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_beds"
                                name="nb_beds" 
                                value="{{ old('nb_beds', 1) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('nb_beds') border-red-500 @enderror"
                            >
                            @error('nb_beds')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Salles de bain -->
                        <div>
                            <label for="nb_bathrooms" class="block text-sm font-semibold text-gray-700 mb-2">
                                Salles de bain <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_bathrooms"
                                name="nb_bathrooms" 
                                value="{{ old('nb_bathrooms', 1) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('nb_bathrooms') border-red-500 @enderror"
                            >
                            @error('nb_bathrooms')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <!-- Capacité -->
                        <div>
                            <label for="max_guests" class="block text-sm font-semibold text-gray-700 mb-2">
                                Invités max <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="max_guests"
                                name="max_guests" 
                                value="{{ old('max_guests', 2) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('max_guests') border-red-500 @enderror"
                            >
                            @error('max_guests')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Équipements -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-check-circle text-accent mr-2"></i> Équipements et services
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
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="amenities[]" 
                                    value="{{ $amenity }}"
                                    {{ in_array($amenity, old('amenities', [])) ? 'checked' : '' }}
                                    class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent"
                                >
                                <span class="text-sm text-gray-700">{{ $amenity }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Photos -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-camera text-accent mr-2"></i> Photos de l'hébergement
                    </h2>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-accent transition">
                        <input 
                            type="file" 
                            id="images"
                            name="images[]" 
                            multiple
                            accept="image/*"
                            class="hidden"
                            onchange="previewImages(this)"
                        >
                        <label for="images" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-6xl text-gray-400 mb-4"></i>
                            <p class="text-lg font-semibold text-gray-700 mb-2">Cliquez pour ajouter des photos</p>
                            <p class="text-sm text-gray-500">ou glissez-déposez vos images ici</p>
                            <p class="text-xs text-gray-400 mt-2">PNG, JPG, JPEG (Max 2MB par image)</p>
                        </label>
                    </div>
                    
                    <!-- Prévisualisation -->
                    <div id="preview-container" class="hidden mt-6">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Aperçu des images :</p>
                        <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    </div>
                    
                    @error('images')
                        <p class="text-red-500 text-sm mt-2">
                            <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                        </p>
                    @enderror
                    
                    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <p class="text-sm text-gray-700">
                            <i class="fas fa-lightbulb text-blue-500 mr-2"></i>
                            <strong>Conseil :</strong> Ajoutez au moins 5 photos de qualité. La première image sera l'image principale.
                        </p>
                    </div>
                </div>
                
                <!-- Boutons -->
                <div class="flex gap-4">
                    <a href="{{ route('owner.accommodations.index') }}" 
                       class="flex-1 md:flex-initial px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition text-center">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 md:flex-initial px-8 py-3 btn-primary text-white rounded-lg">
                        <i class="fas fa-save mr-2"></i> Publier l'hébergement
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
            previewGrid.innerHTML = '';
            
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                        <div class="absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            ${index === 0 ? 'Principal' : `Image ${index + 1}`}
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