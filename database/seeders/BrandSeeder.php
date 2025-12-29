<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\User;
use Illuminate\Database\Seeder;

final class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::first();

        $brands = [
            [
                'name' => 'Apple',
                'website' => 'https://www.apple.com',
                'country_code' => 'US',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Samsung',
                'website' => 'https://www.samsung.com',
                'country_code' => 'KR',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Sony',
                'website' => 'https://www.sony.com',
                'country_code' => 'JP',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Nike',
                'website' => 'https://www.nike.com',
                'country_code' => 'US',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Adidas',
                'website' => 'https://www.adidas.com',
                'country_code' => 'DE',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Toyota',
                'website' => 'https://www.toyota.com',
                'country_code' => 'JP',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'BMW',
                'website' => 'https://www.bmw.com',
                'country_code' => 'DE',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Coca-Cola',
                'website' => 'https://www.coca-cola.com',
                'country_code' => 'US',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Nestlé',
                'website' => 'https://www.nestle.com',
                'country_code' => 'CH',
                'created_by' => $user?->id,
            ],
            [
                'name' => 'Unilever',
                'website' => 'https://www.unilever.com',
                'country_code' => 'GB',
                'created_by' => $user?->id,
            ],
        ];

        foreach ($brands as $brand) {
            Brand::firstOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }
    }
}
