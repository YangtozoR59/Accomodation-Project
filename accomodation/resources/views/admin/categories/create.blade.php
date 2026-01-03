@extends('layouts.app')

@section('title', 'Nouvelle catégorie')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-plus-circle text-green-400"></i> Nouvelle catégorie
            </h1>
            <p class="text-white/80 text-lg">Ajouter un nouveau type d'hébergement</p>
        </div>
    </div>
</section>

<!-- Formulaire -->
<section class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            
            <form action="{{ route('admin.categories.store') }}" method="POST" class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in relative z-10">
                @csrf
                
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-2xl font-bold shadow-lg mb-8 mx-auto">
                    <i class="fas fa-feather-alt"></i>
                </div>
                
                <!-- Nom -->
                <div class="mb-8 group">
                    <label for="name" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                        Nom de la catégorie <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="name"
                            name="name" 
                            value="{{ old('name') }}"
                            required
                            class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-bold text-dark placeholder-gray-400 @error('name') border-red-500 @enderror"
                            placeholder="Ex: Hôtel, Auberge, Appartement..."
                        >
                        <i class="fas fa-tag absolute right-5 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary transition-colors"></i>
                    </div>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Description -->
                <div class="mb-8 group">
                    <label for="description" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                        Description
                    </label>
                    <textarea 
                        id="description"
                        name="description" 
                        rows="3"
                        class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium text-gray-700 placeholder-gray-400 min-h-[120px] resize-y @error('description') border-red-500 @enderror"
                        placeholder="Brève description de ce type d'hébergement..."
                    >{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                </div>
                
                <!-- Icône -->
                <div class="mb-8 group">
                    <label for="icon" class="block text-sm font-bold text-gray-700 mb-2 pl-1 group-focus-within:text-primary transition-colors">
                        Icône Font Awesome <span class="text-gray-400 text-xs font-normal">(sans le préfixe "fa-")</span>
                    </label>
                    <div class="flex items-center gap-4">
                        <div class="relative flex-1">
                            <input 
                                type="text" 
                                id="icon"
                                name="icon" 
                                value="{{ old('icon', 'building') }}"
                                class="w-full px-5 py-4 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none font-medium font-mono text-gray-700 @error('icon') border-red-500 @enderror"
                                placeholder="Ex: building"
                            >
                        </div>
                        <div class="w-16 h-14 rounded-xl bg-gray-100 flex items-center justify-center text-2xl text-primary border border-gray-200 shadow-inner">
                            <i id="icon-preview" class="fas fa-building"></i>
                        </div>
                    </div>
                    @error('icon')
                        <p class="text-red-500 text-xs mt-1.5 font-bold ml-1 flex items-center gap-1">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </p>
                    @enderror
                    
                    <p class="text-xs text-gray-500 mt-3 ml-1 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i>
                        Voir les icônes disponibles : 
                        <a href="https://fontawesome.com/icons?d=gallery&m=free" target="_blank" class="text-primary hover:underline font-bold">
                            fontawesome.com
                        </a>
                    </p>
                </div>
                
                <!-- Boutons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('admin.categories.index') }}" 
                       class="flex-1 text-center px-6 py-4 border border-gray-200 text-gray-700 rounded-xl font-bold hover:bg-gray-50 transition">
                        Annuler
                    </a>
                    <button 
                        type="submit" 
                        class="flex-1 btn-primary text-white px-6 py-4 rounded-xl font-bold hover-lift shadow-lg shadow-primary/30 flex items-center justify-center gap-2">
                        <i class="fas fa-save"></i> Créer la catégorie
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
        const iconName = this.value.trim() || 'building';
        document.getElementById('icon-preview').className = `fas fa-${iconName}`;
    });
</script>
@endpush