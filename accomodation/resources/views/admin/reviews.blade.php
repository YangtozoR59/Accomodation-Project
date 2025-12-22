<!-- resources/views/admin/reviews.blade.php -->
@extends('layouts.app')

@section('title', 'Gestion des avis')

@section('content')

<section class="bg-gradient-to-r from-dark to-accent py-12">
    <div class="container mx-auto px-4">
        <h1 class="text-4xl font-bold text-white fade-in">
            <i class="fas fa-star mr-2"></i> Gestion des avis
        </h1>
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
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold">
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
        <div class="bg-white rounded-xl shadow-md p-4 mb-8">
            <div class="flex gap-3">
                <a href="{{ route('admin.reviews') }}" class="px-4 py-2 rounded-lg {{ !request('status') ? 'bg-accent text-white' : 'bg-gray-100 text-gray-700' }}">
                    Tous
                </a>
                <a href="{{ route('admin.reviews', ['status' => 'pending']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'pending' ? 'bg-yellow-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    En attente
                </a>
                <a href="{{ route('admin.reviews', ['status' => 'verified']) }}" class="px-4 py-2 rounded-lg {{ request('status') === 'verified' ? 'bg-green-500 text-white' : 'bg-gray-100 text-gray-700' }}">
                    Vérifiés
                </a>
            </div>
        </div>
        
        @if($reviews->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($reviews as $review)
                    <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                        <div class="flex justify-between items-start mb-4">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-accent rounded-full flex items-center justify-center text-white text-lg font-bold">
                                    {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="font-bold text-dark">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-600">{{ $review->created_at->format('d/m/Y') }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow-400' : 'gray-300' }}"></i>
                                @endfor
                            </div>
                        </div>
                        
                        <p class="font-semibold text-dark mb-2">{{ $review->accommodation->title }}</p>
                        
                        @if($review->comment)
                            <p class="text-gray-700 mb-4">{{ $review->comment }}</p>
                        @endif
                        
                        <div class="flex gap-2">
                            @if(!$review->is_verified)
                                <form action="{{ route('admin.reviews.verify', $review) }}" method="POST" class="flex-1">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="w-full bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600">
                                        Vérifier
                                    </button>
                                </form>
                            @else
                                <span class="flex-1 text-center bg-green-100 text-green-800 px-4 py-2 rounded-lg">
                                    Vérifié
                                </span>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-8">{{ $reviews->links() }}</div>
        @else
            <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-700">Aucun avis</h3>
            </div>
        @endif
    </div>
</section>
@endsection