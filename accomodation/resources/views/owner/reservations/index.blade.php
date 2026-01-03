@extends('layouts.app')

@section('title', 'Réservations reçues')

@section('content')

<!-- Header avec Glassmorphisme -->
<section class="bg-gradient-to-r from-primary to-secondary py-16 relative overflow-hidden">
    <!-- Formes décoratives -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-10 left-20 w-64 h-64 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-10 right-20 w-80 h-80 bg-black/10 rounded-full blur-3xl animate-float" style="animation-delay: 3s"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <div class="animate-fade-in">
            <h1 class="text-4xl md:text-5xl font-bold text-white mb-3 flex items-center gap-3">
                <i class="fas fa-calendar-alt"></i> Réservations reçues
            </h1>
            <p class="text-white/90 text-lg">Gérez toutes les réservations de vos hébergements</p>
        </div>
    </div>
</section>

<!-- Navigation -->
<section class="sticky top-16 z-40 mb-8" style="margin-top: -30px;">
    <div class="container mx-auto px-4">
        <div class="glass-card bg-white/80 backdrop-blur-md p-2 rounded-2xl shadow-lg border border-white/40 flex gap-2 overflow-x-auto no-scrollbar">
            <a href="{{ route('owner.accommodations.index') }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-home"></i> Tableau de bord
            </a>
            <a href="{{ route('owner.accommodations.index', ['list' => 1]) }}" 
               class="px-6 py-3 rounded-xl text-gray-600 hover:text-primary hover:bg-white/50 font-medium transition whitespace-nowrap flex items-center gap-2">
                <i class="fas fa-building"></i> Mes hébergements
            </a>
            <a href="{{ route('owner.reservations.index') }}" 
               class="px-6 py-3 rounded-xl bg-primary text-white font-bold whitespace-nowrap flex items-center gap-2 shadow-lg shadow-primary/30">
                <i class="fas fa-calendar-alt"></i> Réservations
            </a>
        </div>
    </div>
</section>

<!-- Contenu -->
<section class="pb-16 pt-4">
    <div class="container mx-auto px-4">
        
        <!-- Filtres -->
        <div class="glass-card bg-white rounded-2xl p-4 mb-8 animate-fade-in shadow-sm">
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('owner.reservations.index') }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 {{ !request('status') ? 'bg-primary text-white shadow-lg shadow-primary/30' : 'bg-gray-100/50 text-gray-600 hover:bg-gray-100 hover:text-dark' }}">
                    <i class="fas fa-list"></i> Toutes
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'pending']) }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 {{ request('status') === 'pending' ? 'bg-yellow-500 text-white shadow-lg shadow-yellow-500/30' : 'bg-gray-100/50 text-gray-600 hover:bg-yellow-50 hover:text-yellow-600' }}">
                    <i class="fas fa-clock"></i> En attente
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'confirmed']) }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 {{ request('status') === 'confirmed' ? 'bg-green-500 text-white shadow-lg shadow-green-500/30' : 'bg-gray-100/50 text-gray-600 hover:bg-green-50 hover:text-green-600' }}">
                    <i class="fas fa-check-circle"></i> Confirmées
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'completed']) }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 {{ request('status') === 'completed' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-gray-100/50 text-gray-600 hover:bg-blue-50 hover:text-blue-600' }}">
                    <i class="fas fa-check-double"></i> Terminées
                </a>
                <a href="{{ route('owner.reservations.index', ['status' => 'cancelled']) }}" 
                   class="px-4 py-2.5 rounded-xl font-bold transition flex items-center gap-2 {{ request('status') === 'cancelled' ? 'bg-red-500 text-white shadow-lg shadow-red-500/30' : 'bg-gray-100/50 text-gray-600 hover:bg-red-50 hover:text-red-600' }}">
                    <i class="fas fa-times-circle"></i> Annulées
                </a>
            </div>
        </div>
        
        @if($reservations->count() > 0)
            <!-- Liste -->
            <div class="space-y-6">
                @foreach($reservations as $reservation)
                    <div class="glass-card bg-white rounded-3xl p-6 hover-lift animate-fade-in group">
                        <div class="flex flex-col md:flex-row gap-6">
                            <!-- Info hébergement -->
                            <div class="md:w-1/3">
                                <div class="relative h-48 rounded-2xl overflow-hidden bg-gray-200 mb-3 shadow-md group-hover:shadow-lg transition-shadow">
                                    @if($reservation->accommodation->primary_image)
                                        <img src="{{ asset('storage/' . $reservation->accommodation->primary_image->path) }}" 
                                             alt="{{ $reservation->accommodation->title }}"
                                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                            <i class="fas fa-image text-4xl text-gray-300"></i>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute top-3 left-3">
                                        <span class="px-3 py-1.5 rounded-lg text-xs font-bold uppercase tracking-wide backdrop-blur-md shadow-sm border border-white/20
                                            {{ $reservation->status === 'confirmed' ? 'bg-green-500/90 text-white' : 
                                               ($reservation->status === 'pending' ? 'bg-yellow-500/90 text-white' : 
                                               ($reservation->status === 'completed' ? 'bg-blue-500/90 text-white' : 'bg-red-500/90 text-white')) }}">
                                            {{ $reservation->status === 'confirmed' ? 'Confirmée' : 
                                               ($reservation->status === 'pending' ? 'En attente' : 
                                               ($reservation->status === 'completed' ? 'Terminée' : 'Annulée')) }}
                                        </span>
                                    </div>
                                </div>
                                <h3 class="font-bold text-dark text-lg line-clamp-2 group-hover:text-primary transition-colors">
                                    {{ $reservation->accommodation->title }}
                                </h3>
                                <div class="flex items-center gap-1 text-xs text-gray-500 font-medium mt-1">
                                    <i class="fas fa-hashtag text-gray-400"></i>
                                    <span>Réf: {{ $reservation->id }}</span>
                                    <span class="mx-1">•</span>
                                    <span>{{ $reservation->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            
                            <!-- Info réservation -->
                            <div class="md:w-2/3 flex flex-col">
                                <div class="flex justify-between items-start mb-6 pb-6 border-b border-gray-100">
                                    <!-- Client -->
                                    <div class="flex items-center gap-4">
                                        <div class="w-12 h-12 bg-gradient-to-br from-primary to-secondary rounded-full flex items-center justify-center text-white text-lg font-bold shadow-lg shadow-primary/20">
                                            {{ strtoupper(substr($reservation->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="font-bold text-dark text-lg">{{ $reservation->user->name }}</p>
                                            <div class="flex flex-col sm:flex-row sm:items-center gap-1 sm:gap-4 text-sm text-gray-500">
                                                <span><i class="fas fa-envelope mr-1.5 text-secondary"></i> {{ $reservation->user->email }}</span>
                                                @if($reservation->user->phone)
                                                    <span class="hidden sm:inline text-gray-300">|</span>
                                                    <span><i class="fas fa-phone mr-1.5 text-secondary"></i> {{ $reservation->user->phone }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="text-right hidden sm:block">
                                        <p class="text-3xl font-bold text-primary">
                                            {{ number_format($reservation->total_price, 0, ',', ' ') }}
                                        </p>
                                        <p class="text-xs text-gray-400 font-bold uppercase">FCFA</p>
                                    </div>
                                </div>
                                
                                <div class="flex-1">
                                    <!-- Dates -->
                                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Arrivée</p>
                                            <p class="font-bold text-dark flex items-center gap-2">
                                                <i class="fas fa-plane-arrival text-green-500"></i>
                                                {{ $reservation->check_in->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Départ</p>
                                            <p class="font-bold text-dark flex items-center gap-2">
                                                <i class="fas fa-plane-departure text-red-500"></i>
                                                {{ $reservation->check_out->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Durée</p>
                                            <p class="font-bold text-dark flex items-center gap-2">
                                                <i class="fas fa-moon text-indigo-500"></i>
                                                {{ $reservation->nb_nights }} nuit(s)
                                            </p>
                                        </div>
                                        <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                            <p class="text-xs text-gray-500 font-bold uppercase mb-1">Invités</p>
                                            <p class="font-bold text-dark flex items-center gap-2">
                                                <i class="fas fa-users text-orange-500"></i>
                                                {{ $reservation->nb_guests }} pers.
                                            </p>
                                        </div>
                                    </div>
                                    
                                    <!-- Prix Mobile -->
                                    <div class="sm:hidden mb-6 flex justify-between items-center bg-primary/5 p-4 rounded-xl border border-primary/10">
                                        <span class="font-bold text-dark">Total</span>
                                        <div class="text-right">
                                            <span class="text-xl font-bold text-primary">{{ number_format($reservation->total_price, 0, ',', ' ') }}</span>
                                            <span class="text-xs text-gray-500">FCFA</span>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Actions -->
                                <div class="flex flex-wrap gap-3 mt-auto pt-4 border-t border-gray-100">
                                    <a href="{{ route('owner.reservations.show', $reservation) }}" 
                                       class="px-5 py-2.5 bg-gray-100 text-gray-700 font-bold rounded-xl hover:bg-gray-200 transition">
                                        <i class="fas fa-eye mr-2"></i> Détails
                                    </a>
                                    
                                    @if($reservation->status === 'pending')
                                        <form action="{{ route('reservations.confirm', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-5 py-2.5 btn-secondary text-white font-bold rounded-xl shadow-lg shadow-secondary/20 hover:shadow-secondary/40 hover:scale-105 transition-all">
                                                <i class="fas fa-check mr-2"></i> Confirmer
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if($reservation->status === 'confirmed')
                                        <form action="{{ route('reservations.complete', $reservation) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" 
                                                    class="px-5 py-2.5 bg-blue-500 text-white font-bold rounded-xl shadow-lg shadow-blue-500/20 hover:bg-blue-600 hover:shadow-blue-500/40 transition">
                                                <i class="fas fa-check-double mr-2"></i> Marquer terminée
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <!-- Pagination -->
            <div class="mt-8">
                {{ $reservations->links() }}
            </div>
        @else
            <!-- Aucune réservation -->
            <div class="glass-card bg-white rounded-3xl p-16 text-center animate-fade-in border border-dashed border-gray-200 max-w-2xl mx-auto">
                <div class="w-24 h-24 mx-auto mb-6 rounded-full flex items-center justify-center bg-gray-50 text-gray-300">
                    <i class="fas fa-inbox text-5xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-dark mb-3">Aucune réservation</h3>
                <p class="text-gray-500">Vous n'avez pas encore reçu de demande de réservation pour vos hébergements.</p>
            </div>
        @endif
    </div>
</section>

@endsection