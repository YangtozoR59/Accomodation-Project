@extends('layouts.app')

@section('title', 'Nouvelle catégorie')

@section('content')

<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-plus-circle mr-2"></i> Nouvelle catégorie
        </h1>
    </div>
</section>

<section class="py-8">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-xl shadow-lg p-6 fade-in">
                @csrf
                
                <!-- Nom -->
                <div class="mb-6">
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                        Nom de la catégorie <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="text" 
                        id="name"
                        name="name" 
                        value="{{ old('name') }}"
                        required
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('name') border-red-500 @enderror"
                        placeholder="Ex: Hôtel, Auberge, Appartement..."
                    >
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('description') border-red-500 @enderror"
                        placeholder="Description de la catégorie..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Icône -->
                <div class="mb-6">
                    <label for="icon" class="block text-sm font-semibold text-gray-700 mb-2">
                        Icône Font Awesome <span class="text-gray-500 text-xs">(sans le préfixe "fa-")</span>
                    </label>
                    <input 
                        type="text" 
                        id="icon"
                        name="icon" 
                        value="{{ old('icon', 'building') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-accent @error('icon') border-red-500 @enderror"
                        placeholder="Ex: building, home, hotel, bed..."
                    >
                    @error('icon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    
                    <!-- Preview icône -->
                    <div class="mt-2 flex items-center gap-2 text-sm text-gray-600">
                        <span>Aperçu :</span>
                        <i id="icon-preview" class="fas fa-building text-2xl text-accent"></i>
                    </div>
                    
                    <p class="text-xs text-gray-500 mt-2">
                        Voir les icônes disponibles : 
                        <a href="https://fontawesome.com/icons" target="_blank" class="text-accent hover:underline">
                            fontawesome.com/icons
                        </a>
                    </p>
                </div>
                
                <!-- Boutons -->
                <div class="flex gap-4">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex-1 text-center px-6 py-3 border-2 border-gray-300 text-gray-700 rounded-lg hover:bg-gray-100 transition">
                        <i class="fas fa-times mr-2"></i> Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 btn-primary text-white px-6 py-3 rounded-lg">
                        <i class="fas fa-save mr-2"></i> Créer la catégorie
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script>
    // Preview de l'icône
    document.getElementById('icon').addEventListener('input', function() {
        const iconName = this.value || 'building';
        document.getElementById('icon-preview').className = `fas fa-${iconName} text-2xl text-accent`;
    });
</script>
@endpush