<?php

namespace Database\Seeders;

use App\Models\Accommodation;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
     public function run(): void
    {
        // // Créer un admin
        // $admin = User::create([
        //     'name' => 'Admin Système',
        //     'email' => 'admin@hebergement.cm',
        //     'password' => Hash::make('password'),
        //     'role' => 'admin',
        //     'phone' => '+237 677 00 00 00',
        //     'is_active' => true,
        // ]);

        // // Créer quelques propriétaires
        // $owner1 = User::create([
        //     'name' => 'Hôtel du Plateau',
        //     'email' => 'plateau@hebergement.cm',
        //     'password' => Hash::make('password'),
        //     'role' => 'owner',
        //     'phone' => '+237 677 11 11 11',
        //     'bio' => 'Hôtel de luxe au cœur de Ngaoundéré',
        //     'is_active' => true,
        // ]);

        // $owner2 = User::create([
        //     'name' => 'Auberge Mardock',
        //     'email' => 'mardock@hebergement.cm',
        //     'password' => Hash::make('password'),
        //     'role' => 'owner',
        //     'phone' => '+237 677 22 22 22',
        //     'bio' => 'Auberge conviviale et abordable',
        //     'is_active' => true,
        // ]);

        // // Créer quelques utilisateurs normaux
        // User::create([
        //     'name' => 'Jean Dupont',
        //     'email' => 'jean@example.com',
        //     'password' => Hash::make('password'),
        //     'role' => 'user',
        //     'phone' => '+237 677 33 33 33',
        // ]);

        // Créer les catégories
        $categories = [
            [
                'name' => 'Hôtel',
                'slug' => 'hotel',
                'description' => 'Hôtels avec services complets',
                'icon' => 'building',
            ],
            [
                'name' => 'Auberge',
                'slug' => 'auberge',
                'description' => 'Auberges et petits hôtels',
                'icon' => 'home',
            ],
            [
                'name' => 'Appartement',
                'slug' => 'appartement',
                'description' => 'Appartements meublés',
                'icon' => 'door-open',
            ],
            [
                'name' => 'Studio',
                'slug' => 'studio',
                'description' => 'Studios pour courts séjours',
                'icon' => 'bed',
            ],
            [
                'name' => 'Chambre meublée',
                'slug' => 'chambre-meublee',
                'description' => 'Chambres simples meublées',
                'icon' => 'door-closed',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // // Créer quelques hébergements
        // $hotel = Category::where('slug', 'hotel')->first();
        // $auberge = Category::where('slug', 'auberge')->first();

        // $accommodations = [
        //     [
        //         'user_id' => $owner1->id,
        //         'category_id' => $hotel->id,
        //         'title' => 'Hôtel du Plateau - Chambre Deluxe',
        //         'description' => 'Magnifique chambre avec vue sur la ville. Climatisation, TV satellite, WiFi gratuit. Restaurant et bar sur place.',
        //         'price_per_night' => 25000,
        //         'address' => 'Avenue Ahidjo, Quartier Plateau',
        //         'quartier' => 'Plateau',
        //         'latitude' => 7.3167,
        //         'longitude' => 13.5833,
        //         'nb_rooms' => 1,
        //         'nb_beds' => 2,
        //         'nb_bathrooms' => 1,
        //         'max_guests' => 2,
        //         'amenities' => json_encode([
        //             'WiFi gratuit',
        //             'Climatisation',
        //             'TV satellite',
        //             'Restaurant',
        //             'Bar',
        //             'Parking',
        //             'Service en chambre'
        //         ]),
        //         'is_available' => true,
        //         'is_verified' => true,
        //     ],
        //     [
        //         'user_id' => $owner2->id,
        //         'category_id' => $auberge->id,
        //         'title' => 'Auberge Mardock - Chambre Standard',
        //         'description' => 'Chambre confortable et propre. Idéale pour les étudiants et voyageurs à petit budget. WiFi disponible.',
        //         'price_per_night' => 8000,
        //         'address' => 'Quartier Mardock',
        //         'quartier' => 'Mardock',
        //         'latitude' => 7.3200,
        //         'longitude' => 13.5900,
        //         'nb_rooms' => 1,
        //         'nb_beds' => 1,
        //         'nb_bathrooms' => 1,
        //         'max_guests' => 2,
        //         'amenities' => json_encode([
        //             'WiFi gratuit',
        //             'Ventilateur',
        //             'Eau chaude',
        //             'Parking'
        //         ]),
        //         'is_available' => true,
        //         'is_verified' => true,
        //     ],
        //     [
        //         'user_id' => $owner1->id,
        //         'category_id' => $hotel->id,
        //         'title' => 'Hôtel du Plateau - Suite Familiale',
        //         'description' => 'Suite spacieuse pouvant accueillir une famille. Deux chambres, salon, kitchenette. Vue panoramique.',
        //         'price_per_night' => 45000,
        //         'address' => 'Avenue Ahidjo, Quartier Plateau',
        //         'quartier' => 'Plateau',
        //         'latitude' => 7.3167,
        //         'longitude' => 13.5833,
        //         'nb_rooms' => 2,
        //         'nb_beds' => 3,
        //         'nb_bathrooms' => 2,
        //         'max_guests' => 5,
        //         'amenities' => json_encode([
        //             'WiFi gratuit',
        //             'Climatisation',
        //             'TV satellite',
        //             'Kitchenette',
        //             'Restaurant',
        //             'Bar',
        //             'Parking',
        //             'Piscine',
        //             'Salle de sport'
        //         ]),
        //         'is_available' => true,
        //         'is_verified' => true,
        //     ],
        // ];

        // foreach ($accommodations as $accommodationData) {
        //     Accommodation::create($accommodationData);
        // }

        $this->command->info('✅ Base de données remplie avec succès !');
        // $this->command->info('📧 Admin: admin@hebergement.cm | password');
        // $this->command->info('📧 Owner1: plateau@hebergement.cm | password');
        // $this->command->info('📧 Owner2: mardock@hebergement.cm | password');
        // $this->command->info('📧 User: jean@example.com | password');
    }
}
