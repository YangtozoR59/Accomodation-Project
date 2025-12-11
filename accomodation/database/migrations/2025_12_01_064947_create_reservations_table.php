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
         Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('accommodation_id')->constrained()->onDelete('cascade');
            
            // Dates de réservation
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('nb_guests');
            
            // Prix et paiement
            $table->decimal('total_price', 10, 2);
            
            // Statut de la réservation
            $table->enum('status', [
                'pending',      // En attente de confirmation
                'confirmed',    // Confirmée par le propriétaire
                'cancelled',    // Annulée
                'completed'     // Séjour terminé
            ])->default('pending');
            
            // Informations supplémentaires
            $table->text('special_requests')->nullable();
            $table->text('cancellation_reason')->nullable();
            
            $table->timestamps();
            
            // Index pour améliorer les performances
            $table->index('user_id');
            $table->index('accommodation_id');
            $table->index('status');
            $table->index(['check_in', 'check_out']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
