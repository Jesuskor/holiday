<?php

namespace Database\Seeders;

use App\Models\Hotel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotels = [
            [
                'name' => 'Grand Plaza Resort',
                'city' => 'Cancún',
                'address' => 'Blvd. Kukulcan Km 12',
                'star_rating' => 5,
                'price_per_night' => 350.00,
                'image_url' => 'https://cf.bstatic.com/xdata/images/hotel/max1024x768/295523248.jpg?k=912d680b3e86f6c1374ea10c6c7152e4c2fc9ab2e697c0ccc5d223732698cad9&o=',
            ],
            [
                'name' => 'Sunset Boutique Hotel',
                'city' => 'Tulum',
                'address' => 'Zona Hotelera Sur',
                'star_rating' => 4,
                'price_per_night' => 180.50,
                'image_url' => 'https://a.loveholidays.com/a4b/a4b2f88c9752b904191cd4b54dd5e55c4fa9316c.jpg?auto=avif%2Cwebp&quality=70&dpr=2&optimize=high&fit=crop&width=750&height=500',
            ],
            [
                'name' => 'City Business Hub',
                'city' => 'Ciudad de México',
                'address' => 'Av. Reforma 222',
                'star_rating' => 3,
                'price_per_night' => 85.00,
                'image_url' => 'https://images.trvl-media.com/lodging/9000000/8080000/8075700/8075634/fa1a8464.jpg?impolicy=resizecrop&rw=1200&ra=fit',
            ],
            [
                'name' => 'Mountain View Cabin',
                'city' => 'Valle de Bravo',
                'address' => 'Camino al Bosque S/N',
                'star_rating' => 4,
                'price_per_night' => 120.00,
                'image_url' => 'https://media.vrbo.com/lodging/106000000/105240000/105239500/105239431/3518834f.jpg?impolicy=resizecrop&rw=1200&ra=fit',
            ],
            [
                'name' => 'Backpacker Hostel Central',
                'city' => 'Guadalajara',
                'address' => 'Calle Libertad 101',
                'star_rating' => 2,
                'price_per_night' => 25.00,
                'image_url' => 'https://www.joinmytrip.com/blog/wp-content/uploads/2022/10/alexander-kaunas-TAgGZWz6Qg8-unsplash.jpg',
            ]
        ];

        foreach ($hotels as $hotel) {
            Hotel::create($hotel);
        }
    }
}
