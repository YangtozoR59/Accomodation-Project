<?php

namespace Tests\Feature;

use App\Models\Accommodation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReservationSystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function authenticated_user_can_create_a_reservation()
    {
        $user = User::factory()->create();
        $accommodation = Accommodation::factory()->create([
            'is_available' => true,
            'max_guests' => 4,
            'price_per_night' => 10000,
        ]);

        $response = $this->actingAs($user)->post('/reservations', [
            'accommodation_id' => $accommodation->id,
            'check_in' => now()->addDays(1)->toDateString(),
            'check_out' => now()->addDays(3)->toDateString(),
            'nb_guests' => 2,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('reservations', [
            'user_id' => $user->id,
            'accommodation_id' => $accommodation->id,
            'status' => 'pending',
        ]);
    }

    /** @test */
    public function user_can_view_their_reservation_details()
    {
        $user = User::factory()->create();
        $reservation = Reservation::factory()->create([
            'user_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get('/reservations/' . $reservation->id);

        $response->assertStatus(200);
    }
}


