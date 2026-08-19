<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 3,
                'category_name' => 'Ekonomis Trip',
                'category_name_en' => 'Economy Trip',
                'description' => 'Hotel Non Bintang (Home Stay / Guest House)',
                'description_en' => 'Non-Star Hotel (Home Stay / Guest House)',
            ],
            [
                'id' => 4,
                'category_name' => 'Exclusive Trip',
                'category_name_en' => 'Exclusive Trip',
                'description' => 'Minimal Hotel Bintang 3 dan Fasilitas mobil',
                'description_en' => 'Minimum 3-Star Hotel, car facilities',
            ],
            [
                'id' => 5,
                'category_name' => 'Luxury Trip',
                'category_name_en' => 'Luxury Trip',
                'description' => 'Minimal Hotel Bintang 5 dan Mobil Luxury',
                'description_en' => 'Minimum 5-Star Hotel and Luxury Car',
            ],
            [
                'id' => 6,
                'category_name' => 'Comparment Trip',
                'category_name_en' => 'Compartment Trip',
                'description' => 'Minimal bintang 5 dan market disini Artis Atau tamu VVIP, Public Figur shooting Iklan promosi',
                'description_en' => 'Minimum 5-Star, tailored for Artists, VVIP guests, Public Figures, Ad shooting & promotion',
            ],
            [
                'id' => 7,
                'category_name' => 'Education Trip',
                'category_name_en' => 'Education Trip',
                'description' => 'Conference, symposium, seminar international, Study Tour, Summer / Winter Tour, Gathering',
                'description_en' => 'Conference, symposium, international seminar, Study Tour, Summer / Winter Tour, Gathering',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(
                ['id' => $cat['id']],
                [
                    'category_name' => $cat['category_name'],
                    'category_name_en' => $cat['category_name_en'],
                    'slug' => Str::slug($cat['category_name']),
                    'description' => $cat['description'],
                    'description_en' => $cat['description_en'],
                    'is_active' => true,
                ]
            );
        }
    }
}
