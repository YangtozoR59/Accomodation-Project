@extends('layouts.app')

@section('title', 'Vérifier votre email')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gray-50 relative overflow-hidden">
    
    <!-- Formes décoratives en arrière-plan -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-96 h-96 bg-primary/20 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-20 w-80 h-80 bg-secondary/20 rounded-full blur-3xl animate-float" style="animation-delay: 2s"></div>
        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[500px] h-[500px] bg-white/40 rounded-full blur-3xl"></div>
    </div>
    
    <div class="max-w-md w-full relative z-10">
        
        <!-- Card avec glassmorphism -->
        <div class="glass-card bg-white/80 backdrop-blur-xl rounded-3xl p-8 md:p-10 animate-scale-in border border-white/50 shadow-2xl">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-gradient-to-br from-primary to-secondary rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-primary/20 animate-pulse">
                    <i class="fas fa-envelope-open-text text-3xl text-white"></i>
                </div>
                <h1 class="text-2xl font-bold text-dark mb-2">Vérifiez votre email</h1>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?
                </p>
            </div>
            
            <!-- Message de succès -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-50 border border-green-200 text-green-700 p-4 rounded-xl mb-6 flex items-start gap-3 animate-fade-in">
                    <i class="fas fa-check-circle mt-0.5 text-green-500"></i>
                    <p class="text-sm font-medium">Un nouveau lien de vérification a été envoyé à votre adresse email.</p>
                </div>
            @endif
            
            <!-- Actions -->
            <div class="space-y-4">
                <!-- Renvoyer le lien -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="btn-primary w-full text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-primary/30 hover:shadow-primary/50 hover-lift"
                    >
                        <i class="fas fa-paper-plane mr-2"></i> Renvoyer l'email
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white/50 backdrop-blur text-gray-500 font-medium">Ou</span>
                    </div>
                </div>
                
                <!-- Se déconnecter -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full py-3 border border-gray-200 text-gray-600 rounded-xl font-bold hover:bg-gray-50 hover:text-dark transition"
                    >
                        <i class="fas fa-sign-out-alt mr-2 text-sm"></i> Se déconnecter
                    </button>
                </form>
            </div>
            
            <!-- Info supplémentaire -->
            <div class="mt-8 p-4 bg-gray-50 rounded-xl border border-gray-100">
                <div class="flex items-start gap-3">
                    <div class="bg-white p-2 rounded-lg shadow-sm text-secondary">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <div class="text-xs text-gray-500">
                        <p class="font-bold text-gray-700 mb-1">Vous n'avez pas reçu l'email ?</p>
                        <ul class="list-disc list-inside space-y-1">
                            <li>Vérifiez votre dossier spam</li>
                            <li>Attendez quelques minutes</li>
                            <li>Vérifiez que l'adresse est correcte</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Retour accueil -->
        <div class="text-center mt-8 animate-fade-in" style="animation-delay: 0.1s">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-gray-500 hover:text-primary transition font-medium py-2 px-4 rounded-full hover:bg-white/50">
                <i class="fas fa-arrow-left text-sm"></i>
                <span>Retour à l'accueil</span>
            </a>
        </div>
    </div>
</section>

@endsection