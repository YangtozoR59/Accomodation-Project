@extends('layouts.app')

@section('title', 'Accueil - Hébergement Ngaoundéré')

@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen flex items-center justify-center overflow-hidden">
        <!-- Background Decor -->
        <div class="absolute inset-0 z-0">
            <div class="absolute top-0 right-0 w-1/2 h-full bg-gradient-to-l from-secondary/10 to-transparent"></div>
            <div class="absolute bottom-0 left-0 w-1/2 h-full bg-gradient-to-r from-primary/10 to-transparent"></div>
            <div class="absolute top-20 left-20 w-72 h-72 bg-accent/20 rounded-full blur-3xl animate-float"></div>
            <div class="absolute bottom-20 right-20 w-96 h-96 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10 text-center">
            <div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
                <span class="inline-block py-1 px-3 rounded-full bg-primary/10 text-primary font-semibold text-sm mb-4 border border-primary/20">
                    <i class="fas fa-star mr-2"></i>La référence de l'hébergement au Cameroun
                </span>
                
                <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 leading-tight">
                    Trouvez votre <span class="bg-gradient-to-r from-primary via-accent to-secondary bg-clip-text text-transparent">Havre de Paix</span>
                    <br>à Ngaoundéré
                </h1>
                
                <p class="text-xl md:text-2xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                    Des hôtels de luxe aux auberges conviviales, découvrez une sélection d'hébergements vérifiés pour un séjour inoubliable.
                </p>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <a href="{{ route('accommodations.index') }}" 
                       class="btn-primary text-white text-lg px-8 py-4 rounded-full font-bold flex items-center gap-3 w-full sm:w-auto justify-center group">
                        <span>Commencer l'exploration</span>
                        <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                    </a>
                    <a href="{{ route('login') }}" 
                       class="glass-card text-gray-700 text-lg px-8 py-4 rounded-full font-bold flex items-center gap-3 w-full sm:w-auto justify-center hover:text-primary transition-colors">
                        <i class="fas fa-user-circle"></i>
                        <span>Se connecter</span>
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-16 pt-8 border-t border-gray-200/50">
                    <div class="glass-card p-4 rounded-2xl">
                        <div class="text-3xl font-bold text-primary mb-1">500+</div>
                        <div class="text-sm text-gray-600">Hébergements</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl">
                        <div class="text-3xl font-bold text-secondary mb-1">10k+</div>
                        <div class="text-sm text-gray-600">Voyageurs</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl">
                        <div class="text-3xl font-bold text-accent-dark mb-1">4.9</div>
                        <div class="text-sm text-gray-600">Note Moyenne</div>
                    </div>
                    <div class="glass-card p-4 rounded-2xl">
                        <div class="text-3xl font-bold text-gray-800 mb-1">24/7</div>
                        <div class="text-sm text-gray-600">Support</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-20 bg-white relative">
        <div class="container mx-auto px-4">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">Pourquoi choisir LiveHouse237 ?</h2>
                <p class="text-lg text-gray-600">Une expérience simplifiée pour trouver le logement parfait au meilleur prix.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="glass-card p-8 rounded-3xl text-center group hover:bg-gradient-to-br hover:from-white hover:to-gray-50 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-primary/10 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-check-shield text-3xl text-primary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Vérifié & Sécurisé</h3>
                    <p class="text-gray-600">Chaque hébergement est inspecté pour garantir votre sécurité et votre confort.</p>
                </div>

                <!-- Feature 2 -->
                <div class="glass-card p-8 rounded-3xl text-center group hover:bg-gradient-to-br hover:from-white hover:to-gray-50 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-secondary/10 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-tags text-3xl text-secondary"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Meilleurs Prix</h3>
                    <p class="text-gray-600">Profitez de tarifs exclusifs et d'offres spéciales négociées pour vous.</p>
                </div>

                <!-- Feature 3 -->
                <div class="glass-card p-8 rounded-3xl text-center group hover:bg-gradient-to-br hover:from-white hover:to-gray-50 transition-all duration-300">
                    <div class="w-16 h-16 rounded-2xl bg-accent/10 flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform">
                        <i class="fas fa-headset text-3xl text-accent-dark"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Support Local</h3>
                    <p class="text-gray-600">Une équipe basée au Cameroun pour vous assister à chaque étape de votre voyage.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action -->
    <section class="py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-primary to-secondary opacity-90"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20"></div>
        
        <div class="container mx-auto px-4 relative z-10 text-center text-white">
            <h2 class="text-3xl md:text-5xl font-bold mb-8">Prêt à vivre une expérience unique ?</h2>
            <p class="text-xl mb-10 max-w-2xl mx-auto opacity-90">Rejoignez des milliers de voyageurs qui ont déjà trouvé leur bonheur avec LiveHouse237.</p>
            <a href="{{ route('accommodations.index') }}" 
               class="inline-block bg-white text-primary text-xl px-10 py-4 rounded-full font-bold shadow-lg hover:shadow-2xl hover:scale-105 transition-all duration-300">
                Réserver maintenant
            </a>
        </div>
    </section>
@endsection


