<?php

namespace Tests\Feature;

use App\Models\Accommodation;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccommodationSystemTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function public_accommodations_index_loads()
    {
        $category = Category::factory()->create();
        Accommodation::factory()->create(['category_id' => $category->id]);

        $response = $this->get('/hebergements');

        $response->assertStatus(200);
    }

    /** @test */
    public function public_accommodation_show_loads()
    {
        $category = Category::factory()->create();
        $accommodation = Accommodation::factory()->create(['category_id' => $category->id]);

        $response = $this->get('/hebergements/' . $accommodation->id);

        $response->assertStatus(200);
    }
}


