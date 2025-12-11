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
       Schema::create('accommodations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained()->onDelete('restrict');
            
            // Informations de base
            $table->string('title');
            $table->text('description');
            $table->decimal('price_per_night', 10, 2);
            
            // Localisation
            $table->string('address');
            $table->string('quartier');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            
            // Caractéristiques
            $table->integer('nb_rooms')->default(1);
            $table->integer('nb_beds')->default(1);
            $table->integer('nb_bathrooms')->default(1);
            $table->integer('max_guests')->default(2);
            
            // Services (JSON pour plus de flexibilité)
            $table->json('amenities')->nullable();
            
            // Statut
            $table->boolean('is_available')->default(true);
            $table->boolean('is_verified')->default(false);
            
            // Statistiques
            $table->integer('views_count')->default(0);
            
            $table->timestamps();
            $table->softDeletes();
            
            // Index pour améliorer les performances
            $table->index('quartier');
            $table->index('is_available');
            $table->index('is_verified');
            $table->index(['latitude', 'longitude']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accommodations');
    }
};
