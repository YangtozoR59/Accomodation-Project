@extends('layouts.app')

@section('title', 'Administration')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-dark via-accent to-secondary py-12">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="fade-in">
                <h1 class="text-4xl font-bold text-white mb-2">
                    <i class="fas fa-shield-alt mr-2"></i> Administration
                </h1>
                <p class="text-white/90">Tableau de bord administrateur</p>
            </div>
            
            <div class="hidden md:block fade-in">
                <div class="bg-white/20 backdrop-blur-sm rounded-full px-6 py-3">
                    <i class="fas fa-crown text-yellow-300 mr-2"></i>
                    <span class="text-white font-semibold">Administrateur</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="bg-white shadow-md sticky top-16 z-40">
    <div class="container mx-auto px-4">
        <div class="flex gap-6 overflow-x-auto">
            <a href="{{ route('admin.dashboard') }}" class="py-4 px-2 border-b-2 border-accent text-accent font-semibold whitespace-nowrap">
                <i class="fas fa-tachometer-alt mr-2"></i> Aperçu
            </a>
            <a href="{{ route('admin.accommodations') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-building mr-2"></i> Hébergements
            </a>
            <a href="{{ route('admin.categories.index') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-th-large mr-2"></i> Catégories
            </a>
            <a href="{{ route('admin.reviews') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-star mr-2"></i> Avis
            </a>
            <a href="{{ route('admin.users') }}" class="py-4 px-2 border-b-2 border-transparent text-gray-600 hover:text-accent hover:border-accent transition whitespace-nowrap">
                <i class="fas fa-users mr-2"></i> Utilisateurs
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="py-8">
    <div class="container mx-auto px-4">
        
        <!-- Statistiques globales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total utilisateurs -->
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
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
            
            <!-- Total hébergements -->
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white hover-lift fade-in">
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
                    <i class="fas fa-clock mr-1"></i> {{ $stats['pending_accommodations'] }} en attente
                </p>
            </div>
            
            <!-- Total réservations -->
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
                    <i class="fas fa-chart-line mr-1"></i> Transactions complétées
                </p>
            </div>
        </div>
        
        <!-- Statistiques avis -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-yellow-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-star text-3xl text-yellow-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total avis</p>
                        <p class="text-3xl font-bold text-dark">{{ $stats['total_reviews'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-orange-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-clock text-3xl text-orange-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Avis en attente</p>
                        <p class="text-3xl font-bold text-dark">{{ $stats['pending_reviews'] }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-16 bg-green-100 rounded-lg flex items-center justify-center">
                        <i class="fas fa-check-circle text-3xl text-green-500"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Avis vérifiés</p>
                        <p class="text-3xl font-bold text-dark">{{ $stats['total_reviews'] - $stats['pending_reviews'] }}</p>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contenu en 2 colonnes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Hébergements récents -->
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-bold text-dark">
                        <i class="fas fa-building text-accent mr-2"></i> Hébergements récents
                    </h2>
                    <a href="{{ route('admin.accommodations') }}" class="text-accent hover:text-dark transition">
                        Voir tout <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
                
                @if($recentAccommodations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentAccommodations as $accommodation)
                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg hover:border-accent transition">
                                <div class="w-16 h-16 rounded-lg overflow-hidden bg-gray-200 flex-shrink-0">
                                    @if($accommodation->primary_image)
                                        <img src="{{ asset('storage/' . $accommodation->primary_image->path) }}" 
                                             alt="{{ $accommodation->title }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class="fas fa-image text-gray-400"></i>
                                        </div>
                                    @endif
                                </div>
                                
                                <div class="flex-1">
                                    <p class="font-semibold text-dark line-clamp-1">{{ $accommodation->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $accommodation->owner->name }}</p>
                                </div>
                                
                                @if($accommodation->is_verified)
                                    <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-xs">
                                        Vérifié
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded text-xs">
                                        En attente
                                    </span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">Aucun hébergement récent</p>
                @endif
            </div>
            
            <!-- Réservations récentes -->
            <div class="bg-white rounded-xl shadow-lg p-6 fade-in">
                <h2 class="text-2xl font-bold text-dark mb-6">
                    <i class="fas fa-calendar-alt text-accent mr-2"></i> Réservations récentes
                </h2>
                
                @if($recentReservations->count() > 0)
                    <div class="space-y-3">
                        @foreach($recentReservations as $reservation)
                            <div class="flex items-center gap-3 p-3 border border-gray-200 rounded-lg">
                                <div class="w-12 h-12 bg-accent/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-calendar-check text-accent"></i>
                                </div>
                                
                                <div class="flex-1">
                                    <p class="font-semibold text-dark line-clamp-1">{{ $reservation->accommodation->title }}</p>
                                    <p class="text-sm text-gray-600">{{ $reservation->user->name }} - {{ $reservation->check_in->format('d/m/Y') }}</p>
                                </div>
                                
                                <span class="px-2 py-1 rounded text-xs font-semibold whitespace-nowrap
                                    {{ $reservation->status === 'confirmed' ? 'bg-green-100 text-green-800' : 
                                       ($reservation->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">
                                    {{ ucfirst($reservation->status) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-gray-500 py-8">Aucune réservation récente</p>
                @endif
            </div>
        </div>
        
        <!-- Avis récents -->
        <div class="bg-white rounded-xl shadow-lg p-6 mt-8 fade-in">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-dark">
                    <i class="fas fa-star text-accent mr-2"></i> Avis récents
                </h2>
                <a href="{{ route('admin.reviews') }}" class="text-accent hover:text-dark transition">
                    Voir tout <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>
            
            @if($recentReviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @foreach($recentReviews as $review)
                        <div class="border border-gray-200 rounded-lg p-4 hover:border-accent transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="font-semibold text-dark">{{ $review->user->name }}</p>
                                    <p class="text-sm text-gray-600 line-clamp-1">{{ $review->accommodation->title }}</p>
                                </div>
                                
                                <div class="flex items-center gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star text-{{ $i <= $review->rating ? 'yellow-400' : 'gray-300' }} text-xs"></i>
                                    @endfor
                                </div>
                            </div>
                            
                            @if($review->comment)
                                <p class="text-sm text-gray-700 line-clamp-2 mb-3">{{ $review->comment }}</p>
                            @endif
                            
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                                
                                @if(!$review->is_verified)
                                    <form action="{{ route('admin.reviews.verify', $review) }}" method="POST" class="inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-xs bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                            Vérifier
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs bg-green-100 text-green-800 px-3 py-1 rounded">
                                        Vérifié
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center text-gray-500 py-8">Aucun avis récent</p>
            @endif
        </div>
    </div>
</section>

@endsection