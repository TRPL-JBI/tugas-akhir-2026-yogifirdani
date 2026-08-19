<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PackageType;
use Illuminate\Support\Str;

class PackageTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Open Trip Banyuwangi',
            'One Day Trip Banyuwangi',
            '2 Day 1 Night Banyuwangi',
            '3 Day 2 Night Banyuwangi',
            '4 Day 3 Night Banyuwangi',
        ];

        foreach ($types as $type) {
            PackageType::firstOrCreate(
                ['slug' => Str::slug($type)],
                ['type_name' => $type]
            );
        }
    }
}
