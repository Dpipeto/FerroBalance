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
                'Price' => 800,
                'Cost' => 400,
                'Stock' => 500,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Tuerca M8',
                'Description' => 'Tuerca de acero inoxidable M8',
                'Price' => 600,
                'Cost' => 300,
                'Stock' => 600,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Arandela 8mm',
                'Description' => 'Arandela de acero galvanizado 8mm',
                'Price' => 200,
                'Cost' => 100,
                'Stock' => 1000,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Perno M10x80',
                'Description' => 'Perno hexagonal M10x80mm',
                'Price' => 1200,
                'Cost' => 600,
                'Stock' => 300,
                'CategoryId' => 1,
            ],
            [
                'Name' => 'Remache Pop 3/16"',
                'Description' => 'Remache pop de aluminio 3/16"',
                'Price' => 250,
                'Cost' => 120,
                'Stock' => 800,
                'CategoryId' => 2,
            ],
            [
                'Name' => 'Soldadura ER70S-2',
                'Description' => 'Carrete de soldadura ER70S-2 1kg',
                'Price' => 8500,
                'Cost' => 4200,
                'Stock' => 50,
                'CategoryId' => 3,
            ],
            [
                'Name' => 'Tubo estructural 2x2"',
                'Description' => 'Tubo de acero estructural 2x2 pulgadas',
                'Price' => 15000,
                'Cost' => 7500,
                'Stock' => 100,
                'CategoryId' => 4,
            ],
            [
                'Name' => 'Placa de acero 3mm',
                'Description' => 'Placa de acero laminado en frío 3mm',
                'Price' => 18500,
                'Cost' => 9200,
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
