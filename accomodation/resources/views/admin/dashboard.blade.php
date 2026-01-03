@extends('layouts.app')

@section('title', 'Administration')

@section('content')

<!-- Header -->
<section class="bg-gradient-to-r from-gray-900 to-gray-800 py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 right-20 w-64 h-64 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 left-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>

    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between relative z-10">
            <div class="animate-fade-in">
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                    <i class="fas fa-crown text-yellow-400"></i> Administration
                </h1>
                <p class="text-white/80 text-lg">Bienvenue, <span class="font-bold text-white">{{ auth()->user()->name }}</span></p>
            </div>
            
            <div class="hidden md:block">
                <span class="px-4 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 text-white text-sm font-semibold shadow-inner">
                    <i class="fas fa-shield-alt mr-2"></i> Mode Admin
                </span>
            </div>
        </div>
    </div>
</section>

<!-- Navigation Admin -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/90 backdrop-blur-xl p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('admin.dashboard') }}" 
               class="px-6 py-3 rounded-xl bg-gray-900 text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-gray-900/20">
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
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-gray-100/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-tags"></i> Catégories
            </a>
        </div>
    </div>
</section>

<!-- Statistiques -->
<section class="pb-12 pt-4 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        
        <!-- Row 1 : Stats principales -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            
            <!-- Hébergements -->
            <div class="glass-card bg-gradient-to-br from-blue-600 to-blue-700 rounded-3xl p-6 text-white hover-lift animate-fade-in relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-building text-9xl"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <i class="fas fa-building text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold bg-black/20 px-2 py-1 rounded-lg backdrop-blur-sm border border-white/10">Accomm.</span>
                    </div>
                    
                    <h3 class="text-4xl font-bold mb-1">{{ $stats['total_accommodations'] }}</h3>
                    <p class="text-blue-100 text-sm font-medium mb-4">Total Hébergements</p>
                    
                    <div class="pt-4 border-t border-white/10 flex items-center gap-2 text-sm text-blue-100">
                        <span class="bg-yellow-400 py-0.5 px-2 rounded text-yellow-900 font-bold text-xs">{{ $stats['pending_accommodations'] }}</span>
                         en attente
                    </div>
                </div>
            </div>
            
            <!-- Utilisateurs -->
            <div class="glass-card bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-3xl p-6 text-white hover-lift animate-fade-in relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-users text-9xl"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold bg-black/20 px-2 py-1 rounded-lg backdrop-blur-sm border border-white/10">Users</span>
                    </div>
                    
                    <h3 class="text-4xl font-bold mb-1">{{ $stats['total_users'] }}</h3>
                    <p class="text-emerald-100 text-sm font-medium mb-4">Utilisateurs inscrits</p>
                    
                    <div class="pt-4 border-t border-white/10 flex items-center gap-2 text-sm text-emerald-100">
                        <i class="fas fa-user-tie"></i>
                        <span class="font-bold">{{ $stats['total_owners'] }}</span> propriétaires
                    </div>
                </div>
            </div>
            
            <!-- Réservations -->
            <div class="glass-card bg-gradient-to-br from-purple-600 to-purple-700 rounded-3xl p-6 text-white hover-lift animate-fade-in relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-calendar-check text-9xl"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold bg-black/20 px-2 py-1 rounded-lg backdrop-blur-sm border border-white/10">Resa.</span>
                    </div>
                    
                    <h3 class="text-4xl font-bold mb-1">{{ $stats['total_reservations'] }}</h3>
                    <p class="text-purple-100 text-sm font-medium mb-4">Total Réservations</p>
                    
                    <div class="pt-4 border-t border-white/10 flex items-center gap-2 text-sm text-purple-100">
                        <span class="bg-yellow-400 py-0.5 px-2 rounded text-yellow-900 font-bold text-xs">{{ $stats['pending_reservations'] }}</span>
                        en attente
                    </div>
                </div>
            </div>
            
            <!-- Revenus totaux -->
            <div class="glass-card bg-gradient-to-br from-orange-500 to-red-600 rounded-3xl p-6 text-white hover-lift animate-fade-in relative overflow-hidden group">
                <div class="absolute top-0 right-0 p-4 opacity-10 transform translate-x-4 -translate-y-4 group-hover:scale-110 transition-transform duration-500">
                    <i class="fas fa-coins text-9xl"></i>
                </div>
                
                <div class="relative z-10">
                    <div class="flex justify-between items-start mb-6">
                        <div class="p-3 bg-white/20 backdrop-blur-sm rounded-2xl">
                            <i class="fas fa-money-bill-wave text-2xl"></i>
                        </div>
                        <span class="text-xs font-bold bg-black/20 px-2 py-1 rounded-lg backdrop-blur-sm border border-white/10">Revenus</span>
                    </div>
                    
                    <h3 class="text-3xl font-bold mb-1">{{ number_format($stats['total_revenue'], 0, ',', ' ') }}</h3>
                    <p class="text-orange-100 text-sm font-medium mb-4">FCFA Total</p>
                    
                    <div class="pt-4 border-t border-white/10 flex items-center gap-2 text-sm text-orange-100">
                        <i class="fas fa-chart-line"></i>
                        <span class="font-bold">+{{ number_format($stats['month_revenue'], 0, ',', ' ') }}</span> ce mois
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Row 2 : Stats secondaires -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            
            <!-- Avis -->
            <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-white/60 hover-lift animate-fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Avis</p>
                        <h3 class="text-3xl font-bold text-dark mt-1">{{ $stats['total_reviews'] }}</h3>
                    </div>
                    <div class="bg-yellow-100 p-3 rounded-2xl text-yellow-600">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm pt-4 border-t border-gray-100">
                    <span class="text-gray-600 flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full bg-orange-500"></span>
                        {{ $stats['pending_reviews'] }} en attente
                    </span>
                    <span class="text-dark font-bold bg-gray-100 px-2 py-1 rounded-lg">
                        {{ number_format($stats['average_rating'], 1) }}/5
                    </span>
                </div>
            </div>
            
            <!-- Réservations ce mois -->
            <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-white/60 hover-lift animate-fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Réservations (Mois)</p>
                        <h3 class="text-3xl font-bold text-dark mt-1">{{ $stats['month_reservations'] }}</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-2xl text-purple-600">
                        <i class="fas fa-calendar-day text-xl"></i>
                    </div>
                </div>
                <div class="flex gap-2 text-xs pt-4 border-t border-gray-100">
                    <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded-lg font-bold">
                        {{ $stats['pending_reservations'] }} attente
                    </span>
                    <span class="bg-green-100 text-green-700 px-2 py-1 rounded-lg font-bold">
                        {{ $stats['confirmed_reservations'] }} confirmées
                    </span>
                </div>
            </div>
            
            <!-- Hébergements vérifiés -->
            <div class="glass-card bg-white rounded-3xl p-6 shadow-sm border border-white/60 hover-lift animate-fade-in">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase tracking-wider">Hébergements vérifiés</p>
                        <h3 class="text-3xl font-bold text-dark mt-1">{{ $stats['verified_accommodations'] }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-2xl text-green-600">
                        <i class="fas fa-check-circle text-xl"></i>
                    </div>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                    @php
                        $percentage = $stats['total_accommodations'] > 0 
                            ? ($stats['verified_accommodations'] / $stats['total_accommodations']) * 100 
                            : 0;
                    @endphp
                    <div class="bg-green-500 h-2 rounded-full shadow-sm" style="width: {{ $percentage }}%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-2 font-medium text-right">{{ number_format($percentage, 1) }}% du total</p>
            </div>
        </div>

        <!-- Activité récente -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Hébergements récents -->
            <div class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-dark flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm">
                            <i class="fas fa-building"></i>
                        </div>
                        Hébergements récents
                    </h3>
                    <a href="{{ route('admin.accommodations') }}" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                        Voir tout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="space-y-4">
                    @forelse($recentAccommodations as $accommodation)
                        <div class="flex items-center gap-4 p-4 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-white hover:shadow-md transition-all group">
                            @php
                                $primaryImage = $accommodation->images->where('is_primary', true)->first() 
                                             ?? $accommodation->images->first();
                            @endphp
                            
                            <div class="relative w-16 h-16 rounded-xl overflow-hidden flex-shrink-0">
                                @if($primaryImage)
                                    <img src="{{ asset('storage/' . $primaryImage->path) }}" 
                                         alt="{{ $accommodation->title }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-dark truncate group-hover:text-primary transition-colors">{{ $accommodation->title }}</h4>
                                <p class="text-xs text-gray-500 flex items-center gap-1 mt-1">
                                    <i class="fas fa-user-circle"></i> {{ $accommodation->owner->name }}
                                    <span class="mx-1">•</span>
                                    <span>{{ $accommodation->created_at->diffForHumans() }}</span>
                                </p>
                            </div>
                            
                            @if(!$accommodation->is_verified)
                                <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">
                                    En attente
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1.5 rounded-lg whitespace-nowrap">
                                    Vérifié
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <i class="fas fa-inbox text-3xl mb-2 text-gray-300"></i>
                            <p>Aucun hébergement récent</p>
                        </div>
                    @endforelse
                </div>
            </div>
            
            <!-- Avis en attente -->
            <div class="glass-card bg-white rounded-3xl p-8 shadow-sm border border-white/60 animate-fade-in">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-dark flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-yellow-100 text-yellow-600 flex items-center justify-center text-sm">
                            <i class="fas fa-star"></i>
                        </div>
                        Avis en attente
                    </h3>
                    <a href="{{ route('admin.reviews') }}" class="text-primary text-sm font-bold hover:underline flex items-center gap-1">
                        Voir tout <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                
                <div class="space-y-4">
                    @forelse($pendingReviews as $review)
                        <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100 hover:border-primary/20 hover:bg-white hover:shadow-md transition-all">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-primary to-secondary flex items-center justify-center text-white font-bold text-xs">
                                        {{ substr($review->user->name, 0, 1) }}
                                    </div>
                                    <span class="font-bold text-dark text-sm">{{ $review->user->name }}</span>
                                </div>
                                <span class="text-xs font-medium text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            
                            <div class="flex items-center gap-1 mb-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star text-xs {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}"></i>
                                @endfor
                            </div>
                            
                            <p class="text-sm text-gray-600 line-clamp-2 italic">"{{ $review->comment }}"</p>
                            
                            <div class="mt-3 pt-3 border-t border-gray-200/50 flex items-center justify-between">
                                <p class="text-xs text-gray-500 truncate max-w-[200px]">
                                    Sur : <span class="font-semibold">{{ $review->accommodation->title }}</span>
                                </p>
                                <a href="{{ route('admin.reviews') }}" class="text-xs font-bold text-primary hover:text-secondary transition">
                                    Modérer
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-8 text-gray-500 bg-gray-50 rounded-2xl border border-dashed border-gray-200">
                            <i class="fas fa-check-circle text-3xl mb-2 text-green-200"></i>
                            <p>Tous les avis sont traités</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

@endsection