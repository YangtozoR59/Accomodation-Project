@extends('layouts.app')

@section('title', 'Accueil - Hébergement Ngaoundéré')

@section('content')
    <section class="py-20 bg-gradient-to-r from-primary via-secondary to-accent text-white">
        <div class="container mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Bienvenue sur la plateforme d'hébergements de Ngaoundéré
            </h1>
            <p class="text-lg mb-8 max-w-2xl mx-auto">
                Découvrez des hôtels, auberges et appartements adaptés à vos besoins.
            </p>
            <a href="{{ route('accommodations.index') }}"
               class="inline-block bg-white text-accent px-8 py-3 rounded-full font-semibold hover:bg-primary hover:text-white transition">
                Voir les hébergements
            </a>
        </div>
    </section>
@endsection


