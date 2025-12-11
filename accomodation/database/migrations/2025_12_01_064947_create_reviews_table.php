<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            $table->foreignId('reservation_id')->nullable()->constrained()->onDelete('set null');
            
            // Note principale (1-5)
            $table->integer('rating')->unsigned();
            $table->text('comment')->nullable();
            
            // Notes détaillées (optionnel, 1-5)
            $table->integer('cleanliness_rating')->unsigned()->nullable();
            $table->integer('location_rating')->unsigned()->nullable();
            $table->integer('value_rating')->unsigned()->nullable();
            
            // Vérification par l'admin
            $table->boolean('is_verified')->default(false);
            
            $table->timestamps();
            
            // Un utilisateur ne peut laisser qu'un seul avis par hébergement
            $table->unique(['user_id', 'accommodation_id']);
            
            // Index pour améliorer les performances
            $table->index('accommodation_id');
            $table->index('rating');
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
