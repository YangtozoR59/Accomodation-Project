@extends('layouts.app')

@section('title', 'Gestion des catégories')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 via-gray-800 to-gray-900 py-16 relative overflow-hidden">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4 relative z-10">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                    <i class="fas fa-tags text-pink-400"></i> Gestion des catégories
                </h1>
                <p class="text-white/80 text-lg">Gérez les types d'hébergements disponibles sur la plateforme</p>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" 
               class="btn-primary text-white px-8 py-4 rounded-xl font-bold hover-lift shadow-lg shadow-primary/30 flex items-center gap-2 animate-fade-in">
                <i class="fas fa-plus"></i> Nouvelle catégorie
            </a>
        </div>
    </div>
</section>

<!-- Navigation Admin -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/90 backdrop-blur-xl p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-chart-line"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-building"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-star"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-users"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" 
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-gray-900/20">
                <i class="fas fa-tags"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Liste des catégories -->
<section class="pb-12 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($categories as $category)
                    <div class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 hover-lift animate-fade-in group hover:border-primary/20 transition-all flex flex-col h-full">
                        <div class="flex-1">
                            <div class="flex items-start justify-between mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-gray-100 to-gray-50 text-secondary flex items-center justify-center text-3xl font-bold shadow-inner group-hover:scale-110 group-hover:bg-primary/10 group-hover:text-primary transition-all duration-300">
                                    <i class="fas fa-{{ $category->icon ?? 'building' }}"></i>
                                </div>
                                <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-lg text-xs font-bold border border-gray-200">
                                    ID: {{ $category->id }}
                                </span>
                            </div>
                            
                            <h3 class="text-2xl font-bold text-dark mb-3 group-hover:text-primary transition-colors">{{ $category->name }}</h3>
                            <p class="text-gray-600 mb-6 text-sm leading-relaxed">{{ $category->description }}</p>
                            
                            <div class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-bold mb-6 w-full">
                                <i class="fas fa-home"></i>
                                {{ $category->accommodations_count }} hébergement(s) associé(s)
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-3 pt-6 border-t border-gray-100">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="flex items-center justify-center gap-2 px-4 py-3 bg-gray-100 text-gray-700 rounded-xl font-bold hover:bg-white hover:text-primary hover:shadow-md transition border border-transparent hover:border-gray-100">
                                <i class="fas fa-edit"></i> Modifier
                            </a>
                            
                            @if($category->accommodations_count === 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="w-full">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Supprimer cette catégorie ?')"
                                            class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-red-50 text-red-600 rounded-xl font-bold hover:bg-red-500 hover:text-white transition">
                                        <i class="fas fa-trash-alt"></i> Supprimer
                                    </button>
                                </form>
                            @else
                                <button disabled
                                        class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-gray-50 text-gray-400 rounded-xl font-bold cursor-not-allowed opacity-60"
                                        title="Impossible de supprimer (hébergements associés)">
                                    <i class="fas fa-lock"></i> Supprimer
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="glass-card bg-white rounded-3xl p-16 text-center border border-white/60 shadow-lg max-w-2xl mx-auto">
                <div class="w-32 h-32 mx-auto mb-8 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 animate-pulse">
                    <i class="fas fa-th-large text-6xl"></i>
                </div>
                <h3 class="text-3xl font-bold text-dark mb-4">Aucune catégorie</h3>
                <p class="text-xl text-gray-500 mb-8">Commencez par ajouter votre première catégorie d'hébergement pour structurer votre plateforme.</p>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary text-white px-10 py-4 rounded-xl font-bold text-lg inline-flex items-center gap-3 hover-lift shadow-xl shadow-primary/30">
                    <i class="fas fa-plus"></i> Créer une catégorie
                </a>
            </div>
        @endif
    </div>
</section>

@endsection