<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ReservationFactory extends Factory
{
    protected $model = Reservation::class;

    public function definition(): array
    {
        $checkIn = Carbon::today()->addDays($this->faker->numberBetween(1, 10));
        $checkOut = (clone $checkIn)->addDays($this->faker->numberBetween(1, 7));

        return [
            'user_id' => User::factory(),
            'accommodation_id' => Accommodation::factory(),
            'check_in' => $checkIn->toDateString(),
            'check_out' => $checkOut->toDateString(),
            'nb_guests' => $this->faker->numberBetween(1, 4),
            'total_price' => $this->faker->numberBetween(20000, 150000),
            'status' => 'pending',
            'special_requests' => $this->faker->optional()->sentence(),
            'cancellation_reason' => null,
        ];
    }
}


