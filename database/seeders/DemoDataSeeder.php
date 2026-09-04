<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@nhaka.co.zw'],
            [
                'name' => 'Nhaka Admin',
                'username' => 'Nhaka',
                'password' => Hash::make('Tapiwa482'),
                'role' => 'admin',
                'is_verified' => true,
                'verified_at' => now(),
                'email_verified_at' => now(),
            ]
        );

        $agents = [
            'Tanaka Moyo Properties' => 2023,
            'Rudo Estates' => 2021,
            'Fignoc Land Co.' => 2020,
            'Chipo Lettings' => 2024,
            'CBD Commercial Group' => 2019,
            'Nketa Homes' => 2022,
        ];

        $agentUsers = [];
        foreach ($agents as $name => $since) {
            $email = \Illuminate\Support\Str::slug($name).'@nhaka.co.zw';
            $agentUsers[$name] = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'password' => Hash::make('password'),
                    'role' => 'agent',
                    'is_verified' => true,
                    'verified_at' => now()->setYear($since),
                    'email_verified_at' => now(),
                    'created_at' => now()->setYear($since),
                ]
            );
        }

        $properties = [
            [
                'title' => 'Cottage, 1 bed — Waterfalls',
                'description' => 'A self-contained cottage tucked in a quiet, leafy stand in Waterfalls. Freshly painted with a private entrance, ideal for a single tenant or young couple.',
                'category' => 'rent', 'price' => 180, 'price_period' => 'month',
                'location' => 'Waterfalls, Harare', 'province' => 'Harare',
                'bedrooms' => 1, 'bathrooms' => 1,
                'images' => ['images/listings/small-house.jpg', 'images/interiors/bedroom-beige.jpg', 'images/interiors/kitchen-island.jpg'],
                'agent' => 'Tanaka Moyo Properties',
            ],
            [
                'title' => '4 bed house — Hillside',
                'description' => 'Spacious freehold family home on a large stand in Hillside, Bulawayo, with mature garden, staff quarters and secure boundary walling.',
                'category' => 'buy', 'price' => 95000, 'price_period' => 'once',
                'location' => 'Hillside, Bulawayo', 'province' => 'Bulawayo',
                'bedrooms' => 4, 'bathrooms' => 3,
                'images' => ['images/listings/hillside-house.jpg', 'images/interiors/living-room.jpg', 'images/interiors/modern-kitchen.jpg'],
                'agent' => 'Rudo Estates',
            ],
            [
                'title' => 'Residential stand — 1,500m²',
                'description' => 'Prime residential stand in the sought-after Vainona area, fully serviced with title deed in hand — ready to build.',
                'category' => 'land', 'price' => 28000, 'price_period' => 'once',
                'location' => 'Vainona, Harare', 'province' => 'Harare',
                'bedrooms' => null, 'bathrooms' => null, 'size_sqm' => 1500,
                'images' => ['images/listings/vainona-estate.jpg'],
                'agent' => 'Fignoc Land Co.',
            ],
            [
                'title' => "Lodger room — Chitungwiza",
                'description' => "Clean, secure lodger room in St Mary's with shared bathroom and kitchen access. Walking distance to shops and public transport.",
                'category' => 'rent', 'price' => 65, 'price_period' => 'month',
                'location' => "St Mary's, Chitungwiza", 'province' => 'Harare',
                'bedrooms' => 1, 'bathrooms' => null,
                'images' => ['images/interiors/twin-room.jpg'],
                'agent' => 'Chipo Lettings',
            ],
            [
                'title' => 'Retail shop — CBD frontage',
                'description' => 'Street-facing retail space on Second Street with high foot traffic, roller shutter frontage and rear storage room.',
                'category' => 'commercial', 'price' => 1200, 'price_period' => 'month',
                'location' => 'Second Street, Harare', 'province' => 'Harare',
                'bedrooms' => null, 'bathrooms' => null, 'size_sqm' => 85,
                'images' => ['images/listings/new-development.jpg'],
                'agent' => 'CBD Commercial Group',
            ],
            [
                'title' => '3 bed house — Nketa',
                'description' => 'Well-maintained 3 bedroom home in Nketa with a fitted kitchen, tiled floors throughout and a fenced garden — move-in ready.',
                'category' => 'rent', 'price' => 350, 'price_period' => 'month',
                'location' => 'Nketa, Bulawayo', 'province' => 'Bulawayo',
                'bedrooms' => 3, 'bathrooms' => 2,
                'images' => ['images/listings/nketa-house.jpg', 'images/interiors/rustic-kitchen.jpg', 'images/interiors/bedroom-striped.jpg'],
                'agent' => 'Nketa Homes',
            ],
        ];

        foreach ($properties as $data) {
            $agentName = $data['agent'];
            unset($data['agent']);

            Property::firstOrCreate(
                ['title' => $data['title']],
                array_merge($data, [
                    'slug' => \Illuminate\Support\Str::slug($data['title']),
                    'user_id' => $agentUsers[$agentName]->id,
                    'status' => 'published',
                    'is_verified' => true,
                ])
            );
        }
    }
}
