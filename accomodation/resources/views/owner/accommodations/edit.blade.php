@extends('layouts.app')

@section('title', 'Modifier l\'hébergement')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-edit"></i> Modifier l'hébergement
            </h1>
            <p class="text-white/90 text-lg flex items-center gap-2">
                <i class="fas fa-home"></i> {{ $accommodation->title }}
            </p>
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
            <span class="text-dark font-bold">Modifier</span>
        </nav>
    </div>
</div>

<!-- Formulaire -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            
            <form action="{{ route('owner.accommodations.update', $accommodation) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf
                @method('PATCH')
                
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
                
                <!-- Statut -->
                <div class="glass-card bg-white rounded-3xl p-8 animate-fade-in shadow-sm border border-white/60">
                    <h2 class="text-2xl font-bold text-dark mb-8 flex items-center gap-3 pb-4 border-b border-gray-100">
                        <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center text-blue-500">
                            <i class="fas fa-toggle-on"></i>
                        </div>
                        Statut
                    </h2>
                    
                    <div class="flex flex-wrap items-center gap-6">
                        <label class="group flex items-center gap-3 cursor-pointer bg-gray-50 px-6 py-4 rounded-xl border border-gray-200 hover:border-primary/50 hover:bg-primary/5 transition-all">
                            <div class="relative flex items-center">
                                <input 
                                    type="checkbox" 
                                    name="is_available" 
                                    value="1"
                                    {{ old('is_available', $accommodation->is_available) ? 'checked' : '' }}
                                    class="peer sr-only"
                                >
                                <div class="h-6 w-11 rounded-full bg-gray-200 after:absolute after:top-[2px] after:left-[2px] after:h-5 after:w-5 after:rounded-full after:border after:border-gray-300 after:bg-white after:transition-all after:content-[''] peer-checked:bg-primary peer-checked:after:translate-x-full peer-checked:after:border-white peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20"></div>
                            </div>
                            <span class="font-bold text-dark group-hover:text-primary transition-colors">Hébergement disponible</span>
                        </label>
                        
                        @if($accommodation->is_verified)
                            <div class="bg-green-100 text-green-700 border border-green-200 px-5 py-3 rounded-xl font-bold flex items-center gap-2">
                                <i class="fas fa-check-circle"></i> Vérifié
                            </div>
                        @else
                            <div class="bg-yellow-100 text-yellow-700 border border-yellow-200 px-5 py-3 rounded-xl font-bold flex items-center gap-2">
                                <i class="fas fa-clock"></i> En attente de vérification
                            </div>
                        @endif
                    </div>
                </div>
                
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
                                value="{{ old('title', $accommodation->title) }}"
                                required
                                maxlength="255"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium @error('title') border-red-500 @enderror"
                            >
                            @error('title')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
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
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none appearance-none font-medium @error('category_id') border-red-500 @enderror"
                                >
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" 
                                            {{ old('category_id', $accommodation->category_id) == $category->id ? 'selected' : '' }}>
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
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none resize-y min-h-[120px] font-medium @error('description') border-red-500 @enderror"
                            >{{ old('description', $accommodation->description) }}</textarea>
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
                                    value="{{ old('price_per_night', $accommodation->price_per_night) }}"
                                    required
                                    min="0"
                                    step="100"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-lg @error('price_per_night') border-red-500 @enderror"
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
                        <div class="md:col-span-2">
                            <label for="address" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Adresse complète <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="address"
                                name="address" 
                                value="{{ old('address', $accommodation->address) }}"
                                required
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium @error('address') border-red-500 @enderror"
                            >
                            @error('address')
                                <p class="text-red-500 text-xs mt-1.5 font-bold ml-1">
                                    <i class="fas fa-exclamation-circle mr-1"></i> {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="quartier" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Quartier <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="quartier"
                                name="quartier" 
                                value="{{ old('quartier', $accommodation->quartier) }}"
                                required
                                list="quartiers"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium @error('quartier') border-red-500 @enderror"
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
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Coordonnées GPS <span class="font-normal text-gray-400 text-xs">(Optionnel)</span>
                            </label>
                            <div class="grid grid-cols-2 gap-3">
                                <input 
                                    type="number" 
                                    name="latitude" 
                                    value="{{ old('latitude', $accommodation->latitude) }}"
                                    step="0.0000001"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium"
                                    placeholder="Lat"
                                >
                                <input 
                                    type="number" 
                                    name="longitude" 
                                    value="{{ old('longitude', $accommodation->longitude) }}"
                                    step="0.0000001"
                                    class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium"
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
                        <div>
                            <label for="nb_rooms" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Chambres
                            </label>
                            <input 
                                type="number" 
                                id="nb_rooms"
                                name="nb_rooms" 
                                value="{{ old('nb_rooms', $accommodation->nb_rooms) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <div>
                            <label for="nb_beds" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Lits
                            </label>
                            <input 
                                type="number" 
                                id="nb_beds"
                                name="nb_beds" 
                                value="{{ old('nb_beds', $accommodation->nb_beds) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <div>
                            <label for="nb_bathrooms" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Salles de bain
                            </label>
                            <input 
                                type="number" 
                                id="nb_bathrooms"
                                name="nb_bathrooms" 
                                value="{{ old('nb_bathrooms', $accommodation->nb_bathrooms) }}"
                                required
                                min="1"
                                class="w-full px-5 py-3.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-semibold text-center"
                            >
                        </div>
                        
                        <div>
                            <label for="max_guests" class="block text-sm font-bold text-gray-700 mb-2 pl-1">
                                Invités max
                            </label>
                            <input 
                                type="number" 
                                id="max_guests"
                                name="max_guests" 
                                value="{{ old('max_guests', $accommodation->max_guests) }}"
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
                            $selectedAmenities = old('amenities', $accommodation->amenities ?? []);
                        @endphp
                        
                        @foreach($amenities as $amenity)
                            <label class="group flex items-center gap-3 p-3 rounded-xl border border-gray-100 hover:border-secondary/30 hover:bg-secondary/5 cursor-pointer transition-all">
                                <div class="relative flex items-center">
                                    <input 
                                        type="checkbox" 
                                        name="amenities[]" 
                                        value="{{ $amenity }}"
                                        {{ in_array($amenity, $selectedAmenities) ? 'checked' : '' }}
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
                    
                    <!-- Photos existantes -->
                    @if($accommodation->images->count() > 0)
                        <div class="mb-8">
                            <h3 class="text-lg font-bold text-gray-700 mb-4">Photos actuelles</h3>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                @foreach($accommodation->images as $image)
                                    <div class="relative group rounded-2xl overflow-hidden shadow-sm aspect-[4/3]">
                                        <img src="{{ asset('storage/' . $image->path) }}" 
                                             alt="Image" 
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors"></div>
                                        
                                        @if($image->is_primary)
                                            <div class="absolute top-2 left-2 backdrop-blur-lg bg-yellow-400 text-white px-2 py-1 rounded-lg text-xs font-bold shadow-sm">
                                                <i class="fas fa-star mr-1"></i>Une
                                            </div>
                                        @else
                                            <form action="{{ route('owner.accommodations.images.set-primary', $image) }}" 
                                                  method="POST" 
                                                  class="absolute top-2 left-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" 
                                                        class="backdrop-blur-lg bg-white/90 text-gray-700 px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-white transition shadow-sm hover:text-primary">
                                                    Mettre en une
                                                </button>
                                            </form>
                                        @endif
                                        
                                        <form action="{{ route('owner.accommodations.images.delete', $image) }}" 
                                              method="POST" 
                                              class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    onclick="return confirm('Supprimer cette image ?')"
                                                    class="bg-red-500 text-white w-8 h-8 rounded-full flex items-center justify-center hover:bg-red-600 transition shadow-sm">
                                                <i class="fas fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    
                    <!-- Nouvelles photos -->
                    <div class="border-3 border-dashed border-gray-200 rounded-3xl p-12 text-center hover:border-secondary/50 hover:bg-secondary/5 transition-all cursor-pointer group bg-gray-50/50">
                        <input 
                            type="file" 
                            id="new_images"
                            name="new_images[]" 
                            multiple
                            accept="image/*"
                            class="hidden"
                            onchange="previewImages(this)"
                        >
                        <label for="new_images" class="cursor-pointer block">
                            <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center bg-white shadow-md text-gray-400 group-hover:text-secondary group-hover:scale-110 transition-all">
                                <i class="fas fa-cloud-upload-alt text-4xl"></i>
                            </div>
                            <p class="text-xl font-bold text-dark mb-2">Ajouter de nouvelles photos</p>
                            <p class="text-gray-500 mb-4">PNG, JPG, JPEG (Max 2MB par image)</p>
                            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-gray-100 text-xs font-bold text-gray-500">
                                <span>Glisser-déposer ou cliquer</span>
                            </div>
                        </label>
                    </div>
                    
                    <div id="preview-container" class="hidden mt-8">
                        <p class="text-sm font-bold text-gray-700 mb-4 flex items-center gap-2">
                            <i class="fas fa-images text-secondary"></i>
                            Nouvelles images à ajouter :
                        </p>
                        <div id="preview-grid" class="grid grid-cols-2 md:grid-cols-4 gap-4"></div>
                    </div>
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
                        <i class="fas fa-save"></i>
                        <span>Enregistrer les modifications</span>
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
                    div.className = 'relative rounded-2xl overflow-hidden shadow-sm aspect-[4/3] border border-gray-100';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute top-2 right-2 backdrop-blur-md bg-black/60 text-white px-2 py-1 rounded-lg text-xs font-bold border border-white/20">
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