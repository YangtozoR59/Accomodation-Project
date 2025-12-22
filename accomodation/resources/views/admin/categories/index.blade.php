@extends('layouts.app')

@section('title', 'Gestion des catégories')

@section('content')

<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-4xl font-bold text-white fade-in">
                    <i class="fas fa-th-large mr-2"></i> Gestion des catégories
                </h1>
                <p class="text-white/90 mt-2">Gérez les types d'hébergements</p>
            </div>
            
            <a href="{{ route('admin.categories.create') }}" 
               class="bg-white text-accent px-6 py-3 rounded-full font-bold hover:bg-primary transition">
                <i class="fas fa-plus mr-2"></i> Nouvelle catégorie
            </a>
        </div>
    </div>
</section>

<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition">
                <i class="fas fa-tachometer-alt mr-2"></i> Aperçu
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.categories.index') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold">
                <i class="fas fa-th-large mr-2"></i> Catégories
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent transition">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
        </div>
    </div>
</section>

<section class="py-8">
    <div class="container mx-auto px-4">
        
        @if($categories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($categories as $category)
                    <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex-1">
                                <div class="text-5xl mb-3 text-accent">
                                    <i class="fas fa-{{ $category->icon ?? 'building' }}"></i>
                                </div>
                                <h3 class="text-2xl font-bold text-dark mb-2">{{ $category->name }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $category->description }}</p>
                                
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-gray-600">
                                        <i class="fas fa-home text-accent mr-1"></i>
                                        {{ $category->accommodations_count }} hébergement(s)
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex gap-2 pt-4 border-t">
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="flex-1 text-center bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition">
                                <i class="fas fa-edit mr-1"></i> Modifier
                            </a>
                            
                            @if($category->accommodations_count === 0)
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            onclick="return confirm('Supprimer cette catégorie ?')"
                                            class="w-full bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition">
                                        <i class="fas fa-trash mr-1"></i> Supprimer
                                    </button>
                                </form>
                            @else
                                <button disabled
                                        class="flex-1 bg-gray-300 text-gray-500 px-4 py-2 rounded-lg cursor-not-allowed"
                                        title="Impossible de supprimer (hébergements associés)">
                                    <i class="fas fa-lock mr-1"></i> Supprimer
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-th-large text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700 mb-2">Aucune catégorie</h3>
                <p class="text-gray-600 mb-6">Commencez par ajouter votre première catégorie</p>
                <a href="{{ route('admin.categories.create') }}" class="btn-primary text-white px-8 py-3 rounded-lg inline-block">
                    <i class="fas fa-plus mr-2"></i> Nouvelle catégorie
                </a>
            </div>
        @endif
    </div>
</section>

@endsection