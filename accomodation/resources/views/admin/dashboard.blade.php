@extends('layouts.app')

@section('title', 'Administration')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark via-accent to-secondary py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-crown mr-2"></i> Tableau de bord Admin
                </h1>
                <p class="text-white/90">Bienvenue, {{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Admin -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-chart-line mr-2"></i> Tableau de bord
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
            <a href="{{ route('admin.categories.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-tags mr-2"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Row 1 : Stats principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Hébergements -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Hébergements</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['total_accommodations'] }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-building text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-clock mr-1"></i> {{ $stats['pending_accommodations'] }} en attente de vérification
                </p>
            </div>
            
            <!-- Utilisateurs -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Utilisateurs</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-users text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-user-tie mr-1"></i> {{ $stats['total_owners'] }} propriétaires
                </p>
            </div>
            
            <!-- Réservations -->
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Réservations</p>
                        <h3 class="text-3xl font-bold mt-2">{{ $stats['total_reservations'] }}</h3>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-calendar-check text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-hourglass-half mr-1"></i> {{ $stats['pending_reservations'] }} en attente
                </p>
            </div>
            
            <!-- Revenus totaux -->
            <div class="bg-gradient-to-br from-yellow-500 to-orange-500 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-white/80 text-sm font-medium">Revenus totaux</p>
                        <h3 class="text-2xl font-bold mt-2">{{ number_format($stats['total_revenue'], 0, ',', ' ') }}</h3>
                        <p class="text-white/80 text-xs">FCFA</p>
                    </div>
                    <div class="bg-white/20 p-3 rounded-lg">
                        <i class="fas fa-money-bill-wave text-2xl"></i>
                    </div>
                </div>
                <p class="text-white/80 text-sm">
                    <i class="fas fa-calendar mr-1"></i> {{ number_format($stats['month_revenue'], 0, ',', ' ') }} FCFA ce mois
                </p>
            </div>
        </div>
        
        <!-- Row 2 : Stats secondaires -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Avis -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Avis</p>
                        <h3 class="text-2xl font-bold text-dark mt-1">{{ $stats['total_reviews'] }}</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-lg">
                        <i class="fas fa-star text-yellow-500 text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <span class="text-gray-600">
                        <i class="fas fa-clock text-orange-500 mr-1"></i>
                        {{ $stats['pending_reviews'] }} en attente
                    </span>
                    <span class="text-accent font-semibold">
                        {{ number_format($stats['average_rating'], 1) }}/5
                    </span>
                </div>
            </div>
            
            <!-- Réservations ce mois -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Réservations ce mois</p>
                        <h3 class="text-2xl font-bold text-dark mt-1">{{ $stats['month_reservations'] }}</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-lg">
                        <i class="fas fa-calendar-alt text-blue-500 text-xl"></i>
                    </div>
                </div>
                <div class="flex gap-2 text-xs">
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded">
                        {{ $stats['pending_reservations'] }} en attente
                    </span>
                    <span class="bg-green-100 text-green-800 px-2 py-1 rounded">
                        {{ $stats['confirmed_reservations'] }} confirmées
                    </span>
                </div>
            </div>
            
            <!-- Hébergements vérifiés -->
            <div class="bg-white rounded-xl shadow-lg p-6 hover-lift fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-600 text-sm font-medium">Hébergements vérifiés</p>
                        <h3 class="text-2xl font-bold text-dark mt-1">{{ $stats['verified_accommodations'] }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-lg">
                        <i class="fas fa-check-circle text-green-500 text-xl"></i>
                    </div>
                </div>
                <div class="w-full bg-gray-200 rounded-full h-2">
                    @php
                        $percentage = $stats['total_accommodations'] > 0 
                            ? ($stats['verified_accommodations'] / $stats['total_accommodations']) * 100 
                            : 0;
                    @endphp
                    <div class="bg-green-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                </div>
                <p class="text-xs text-gray-600 mt-2">{{ number_format($percentage, 1) }}% des hébergements</p>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            <!-- Hébergements récents -->
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-dark">
                        <i class="fas fa-building text-accent mr-2"></i> Hébergements récents
                    </h3>
                    <a href="{{ route('admin.accommodations') }}" class="text-accent text-sm hover:underline">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($recentAccommodations as $accommodation)
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            @php
                                $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                             ?? $accommodation->images->first();
                            @endphp
                            
                            @if($primaryImage)
                                <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                     alt="{{ $accommodation->title }}"
                                     class="w-12 h-12 object-cover rounded">
                            @else
                                <div class="w-12 h-12 bg-gray-300 rounded flex items-center justify-center">
                                    <i class="fas fa-image text-gray-500"></i>
                                </div>
                            @endif
                            
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-dark truncate">{{ $accommodation->title }}</p>
                                <p class="text-xs text-gray-600">
                                    Par {{ $accommodation->owner->name }} • {{ $accommodation->created_at->diffForHumans() }}
                                </p>
                            </div>
                            
                            @if(!$accommodation->is_verified)
                                <span class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">En attente</span>
                            @else
                                <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Vérifié</span>
                            @endif
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Aucun hébergement récent</p>
                    @endforelse
                </div>
            </div>
            
            <!-- Avis en attente -->
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-dark">
                        <i class="fas fa-star text-yellow-500 mr-2"></i> Avis en attente
                    </h3>
                    <a href="{{ route('admin.reviews') }}" class="text-accent text-sm hover:underline">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                <div class="space-y-3">
                    @forelse($pendingReviews as $review)
                        <div class="p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="flex items-center justify-between mb-2">
                                <div class="flex items-center gap-2">
                                    <span class="font-medium text-dark">{{ $review->user->name }}</span>
                                    <div class="flex items-center gap-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 line-clamp-2">{{ $review->comment }}</p>
                            <p class="text-xs text-gray-500 mt-1">
                                Pour : {{ $review->accommodation->title }}
                            </p>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Aucun avis en attente</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection