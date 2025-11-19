<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            [
                'Name' => 'Tornillo M8x50',
                'Description' => 'Tornillo de acero inoxidable M8x50mm',
                'Price' => 2.50,
                'Cost' => 1.20,
                'Stock' => 500,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Tuerca M8',
                'Description' => 'Tuerca de acero inoxidable M8',
                'Price' => 1.75,
                'Cost' => 0.80,
                'Stock' => 600,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Arandela 8mm',
                'Description' => 'Arandela de acero galvanizado 8mm',
                'Price' => 0.50,
                'Cost' => 0.20,
                'Stock' => 1000,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Perno M10x80',
                'Description' => 'Perno hexagonal M10x80mm',
                'Price' => 3.25,
                'Cost' => 1.50,
                'Stock' => 300,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Remache Pop 3/16"',
                'Description' => 'Remache pop de aluminio 3/16"',
                'Price' => 0.75,
                'Cost' => 0.35,
                'Stock' => 800,
                'CategoryId' => 2,
            ],
            [
                'Name' => 'Soldadura ER70S-2',
                'Description' => 'Carrete de soldadura ER70S-2 1kg',
                'Price' => 25.00,
                'Cost' => 12.00,
                'Stock' => 50,
                'CategoryId' => 3,
            ],
            [
                'Name' => 'Tubo estructural 2x2"',
                'Description' => 'Tubo de acero estructural 2x2 pulgadas',
                'Price' => 45.00,
                'Cost' => 22.00,
                'Stock' => 100,
                'CategoryId' => 4,
            ],
            [
                'Name' => 'Placa de acero 3mm',
                'Description' => 'Placa de acero laminado en frío 3mm',
                'Price' => 55.00,
                'Cost' => 27.00,
                'Stock' => 75,
                'CategoryId' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['Name' => $product['Name']],
                $product
            );
        }
    }
}
