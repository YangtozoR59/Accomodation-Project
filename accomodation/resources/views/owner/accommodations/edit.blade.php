@extends('layouts.app')

@section('title', 'Modifier l\'hébergement')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-edit mr-2"></i> Modifier l'hébergement
        </h1>
        <p class="text-white/90 mt-2">{{ $accommodation->title }}</p>
    </div>
</section>

<!-- Breadcrumb -->
<div class="bg-gray-100 py-4">
    <div class="container mx-auto px-4">
        <nav class="flex text-sm text-gray-600">
            <a href="{{ route('owner.accommodations.index') }}" class="hover:text-accent transition">Mes hébergements</a>
            <span class="mx-2">/</span>
            <span class="text-dark">Modifier</span>
        </nav>
    </div>
</div>

<!-- Formulaire -->
<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <form action="{{ route('owner.accommodations.update', $accommodation) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')
                
                <!-- Statut -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-4">
                        <i class="fas fa-toggle-on text-accent mr-2"></i> Statut
                    </h2>
                    
                    <div class="flex items-center gap-4">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input 
                                type="checkbox" 
                                name="is_available" 
                                value="1"
                                {{ old('is_available', $accommodation->is_available) ? 'checked' : '' }}
                                class="w-5 h-5 text-accent border-gray-300 rounded focus:ring-accent"
                            >
                            <span class="font-semibold text-dark">Hébergement disponible</span>
                        </label>
                        
                        @if($accommodation->is_verified)
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-full text-sm">
                                <i class="fas fa-check-circle mr-1"></i> Vérifié
                            </span>
                        @else
                            <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-sm">
                                <i class="fas fa-clock mr-1"></i> En attente de vérification
                            </span>
                        @endif
                    </div>
                </div>
                
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
                                value="{{ old('title', $accommodation->title) }}"
                                required
                                maxlength="255"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent focus:ring-2 focus:ring-accent/20 transition @error('title') border-red-500 @enderror"
                            >
                            @error('title')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('category_id') border-red-500 @enderror"
                            >
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ old('category_id', $accommodation->category_id) == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('description') border-red-500 @enderror"
                            >{{ old('description', $accommodation->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
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
                                    value="{{ old('price_per_night', $accommodation->price_per_night) }}"
                                    required
                                    min="0"
                                    step="100"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('price_per_night') border-red-500 @enderror"
                                >
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-500">FCFA</span>
                            </div>
                            @error('price_per_night')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="address"
                                name="address" 
                                value="{{ old('address', $accommodation->address) }}"
                                required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('address') border-red-500 @enderror"
                            >
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="quartier" class="block text-sm font-semibold text-gray-700 mb-2">
                                Quartier <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="quartier"
                                name="quartier" 
                                value="{{ old('quartier', $accommodation->quartier) }}"
                                required
                                list="quartiers"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('quartier') border-red-500 @enderror"
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
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Coordonnées GPS (optionnel)
                            </label>
                            <div class="grid grid-cols-2 gap-2">
                                <input 
                                    type="number" 
                                    name="latitude" 
                                    value="{{ old('latitude', $accommodation->latitude) }}"
                                    step="0.0000001"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                                    placeholder="Latitude"
                                >
                                <input 
                                    type="number" 
                                    name="longitude" 
                                    value="{{ old('longitude', $accommodation->longitude) }}"
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
                        <div>
                            <label for="nb_rooms" class="block text-sm font-semibold text-gray-700 mb-2">
                                Chambres <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_rooms"
                                name="nb_rooms" 
                                value="{{ old('nb_rooms', $accommodation->nb_rooms) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                            >
                        </div>
                        
                        <div>
                            <label for="nb_beds" class="block text-sm font-semibold text-gray-700 mb-2">
                                Lits <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_beds"
                                name="nb_beds" 
                                value="{{ old('nb_beds', $accommodation->nb_beds) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                            >
                        </div>
                        
                        <div>
                            <label for="nb_bathrooms" class="block text-sm font-semibold text-gray-700 mb-2">
                                Salles de bain <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="nb_bathrooms"
                                name="nb_bathrooms" 
                                value="{{ old('nb_bathrooms', $accommodation->nb_bathrooms) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                            >
                        </div>
                        
                        <div>
                            <label for="max_guests" class="block text-sm font-semibold text-gray-700 mb-2">
                                Invités max <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="number" 
                                id="max_guests"
                                name="max_guests" 
                                value="{{ old('max_guests', $accommodation->max_guests) }}"
                                required
                                min="1"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent"
                            >
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
                            $selectedAmenities = old('amenities', $accommodation->amenities ?? []);
                        @endphp
                        
                        @foreach($amenities as $amenity)
                            <label class="flex items-center gap-2 p-3 border border-gray-200 rounded-lg hover:border-accent hover:bg-accent/5 cursor-pointer transition">
                                <input 
                                    type="checkbox" 
                                    name="amenities[]" 
                                    value="{{ $amenity }}"
                                    {{ in_array($amenity, $selectedAmenities) ? 'checked' : '' }}
                                    class="w-4 h-4 text-accent border-gray-300 rounded focus:ring-accent"
                                >
                                <span class="text-sm text-gray-700">{{ $amenity }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
                
                <!-- Photos existantes -->
                @if($accommodation->images->count() > 0)
                    <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                        <h2 class="text-2xl font-bold text-dark mb-6">
                            <i class="fas fa-images text-accent mr-2"></i> Photos actuelles
                        </h2>
                        
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            @foreach($accommodation->images as $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image->path) }}" 
                                         alt="Image" 
                                         class="w-full h-32 object-cover rounded-lg">
                                    
                                    @if($image->is_primary)
                                        <span class="absolute top-2 left-2 bg-accent text-white px-2 py-1 rounded text-xs">
                                            Principal
                                        </span>
                                    @else
                                        <form action="{{ route('owner.accommodations.images.set-primary', $image) }}" 
                                              method="POST" 
                                              class="absolute top-2 left-2">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="bg-white/90 hover:bg-white text-gray-700 px-2 py-1 rounded text-xs transition">
                                                Définir principal
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <form action="{{ route('owner.accommodations.images.delete', $image) }}" 
                                          method="POST" 
                                          class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Supprimer cette image ?')"
                                                class="bg-red-500 hover:bg-red-600 text-white p-2 rounded">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                
                <!-- Nouvelles photos -->
                <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                    <h2 class="text-2xl font-bold text-dark mb-6">
                        <i class="fas fa-plus text-accent mr-2"></i> Ajouter de nouvelles photos
                    </h2>
                    
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-accent transition">
                        <input 
                            type="file" 
                            id="new_images"
                            name="new_images[]" 
                            multiple
                            accept="image/*"
                            class="hidden"
                            onchange="previewImages(this)"
                        >
                        <label for="new_images" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-6xl text-gray-400 mb-4"></i>
                            <p class="text-lg font-semibold text-gray-700 mb-2">Cliquez pour ajouter des photos</p>
                            <p class="text-sm text-gray-500">PNG, JPG, JPEG (Max 2MB par image)</p>
                        </label>
                    </div>
                    
                    <div id="preview-container" class="hidden mt-6">
                        <p class="text-sm font-semibold text-gray-700 mb-3">Nouvelles images :</p>
                        <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
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
                        <i class="fas fa-save mr-2"></i> Enregistrer les modifications
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
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg">
                        <div class="absolute top-2 right-2 bg-black/50 text-white px-2 py-1 rounded text-xs">
                            Nouveau ${index + 1}
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