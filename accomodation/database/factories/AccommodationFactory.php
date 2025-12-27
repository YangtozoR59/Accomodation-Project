<?php

namespace Database\Factories;

use App\Models\Accommodation;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AccommodationFactory extends Factory
{
    protected $model = Accommodation::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'title' => $this->faker->sentence(4),
            'description' => $this->faker->paragraph(),
            'price_per_night' => $this->faker->numberBetween(10000, 80000),
            'address' => $this->faker->streetAddress(),
            'quartier' => $this->faker->city(),
            'latitude' => $this->faker->latitude(),
            'longitude' => $this->faker->longitude(),
            'nb_rooms' => $this->faker->numberBetween(1, 5),
            'nb_beds' => $this->faker->numberBetween(1, 6),
            'nb_bathrooms' => $this->faker->numberBetween(1, 3),
            'max_guests' => $this->faker->numberBetween(1, 8),
            'is_available' => true,
            'views_count' => 0,
        ];
    }
}


