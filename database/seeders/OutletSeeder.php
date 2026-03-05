<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Outlet;

class OutletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $outlets = [
            [
                'name' => 'Sushi Mentai Siantar',
                'code' => 'SMT-SNT',
                'address' => 'Pematang Siantar, Sumatera Utara',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Kelapa Gading',
                'code' => 'SMT-KG',
                'address' => 'Kelapa Gading, Jakarta Utara',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Bintaro',
                'code' => 'SMT-BTR',
                'address' => 'Bintaro, Tangerang Selatan',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Alam Sutera',
                'code' => 'SMT-AS',
                'address' => 'Alam Sutera, Tangerang',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Batam',
                'code' => 'SMT-BTM',
                'address' => 'Batam, Kepulauan Riau',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Pekanbaru',
                'code' => 'SMT-PKB',
                'address' => 'Pekanbaru, Riau',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Merak Jingga',
                'code' => 'SMT-MJ',
                'address' => 'Merak Jingga, Medan',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Cemara Asri',
                'code' => 'SMT-CA',
                'address' => 'Cemara Asri, Medan',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Dr. Cipto',
                'code' => 'SMT-DC',
                'address' => 'Dr. Cipto, Medan',
                'is_active' => true,
            ],
            [
                'name' => 'Sushi Mentai Yogyakarta',
                'code' => 'SMT-YK',
                'address' => 'Yogyakarta',
                'is_active' => true,
            ],
        ];

        foreach ($outlets as $outlet) {
            Outlet::create($outlet);
        }

        $this->command->info('✓ 10 Outlets Sushi Mentai seeded successfully!');
    }
}