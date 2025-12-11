@extends('layouts.app')

@section('title', 'Vérifier votre email')

@section('content')

<section class="min-h-screen flex items-center justify-center py-12 px-4 bg-gradient-to-br from-primary via-secondary to-accent">
    <div class="max-w-md w-full">
        
        <!-- Card -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 fade-in">
            
            <!-- Logo et titre -->
            <div class="text-center mb-8">
                <div class="inline-block bg-accent/10 p-4 rounded-full mb-4 animate-pulse">
                    <i class="fas fa-envelope-open-text text-5xl text-accent"></i>
                </div>
                <h1 class="text-3xl font-bold text-dark mb-2">Vérifiez votre email</h1>
                <p class="text-gray-600">
                    Merci de vous être inscrit ! Avant de commencer, pourriez-vous vérifier votre adresse email en cliquant sur le lien que nous venons de vous envoyer ?
                </p>
            </div>
            
            <!-- Message de succès -->
            @if (session('status') == 'verification-link-sent')
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded mb-6 fade-in">
                    <i class="fas fa-check-circle mr-2"></i>
                    Un nouveau lien de vérification a été envoyé à votre adresse email.
                </div>
            @endif
            
            <!-- Illustration -->
            <div class="text-center my-8">
                <div class="relative inline-block">
                    <i class="fas fa-envelope text-8xl text-accent/20"></i>
                    <i class="fas fa-check-circle absolute bottom-0 right-0 text-3xl text-green-500"></i>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="space-y-4">
                <!-- Renvoyer le lien -->
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full btn-primary text-white py-3 rounded-lg font-bold"
                    >
                        <i class="fas fa-paper-plane mr-2"></i> Renvoyer l'email de vérification
                    </button>
                </form>
                
                <!-- Divider -->
                <div class="relative my-6">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-gray-300"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-2 bg-white text-gray-500">Ou</span>
                    </div>
                </div>
                
                <!-- Se déconnecter -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button 
                        type="submit" 
                        class="w-full border-2 border-accent text-accent py-3 rounded-lg font-semibold hover:bg-accent hover:text-white transition"
                    >
                        <i class="fas fa-sign-out-alt mr-2"></i> Se déconnecter
                    </button>
                </form>
            </div>
            
            <!-- Info supplémentaire -->
            <div class="mt-8 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <div class="flex items-start gap-3">
                    <i class="fas fa-info-circle text-blue-500 text-xl mt-1"></i>
                    <div class="text-sm text-gray-700">
                        <p class="font-semibold mb-1">Vous n'avez pas reçu l'email ?</p>
                        <ul class="list-disc list-inside space-y-1 text-gray-600">
                            <li>Vérifiez votre dossier spam</li>
                            <li>Attendez quelques minutes</li>
                            <li>Vérifiez que l'adresse email est correcte</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Retour accueil -->
        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-white hover:text-dark transition">
                <i class="fas fa-arrow-left mr-2"></i> Retour à l'accueil
            </a>
        </div>
    </div>
</section>

@endsection