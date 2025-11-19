<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Factura;
use App\Models\FacturaLinea;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;

class FacturaSeeder extends Seeder
{
    public function run(): void
    {
        // Obtener datos necesarios
        $customers = Customer::all();
        $products = Product::all();
        $users = User::all();
        
        // Si no tenemos datos base, salir
        if ($customers->isEmpty() || $products->isEmpty() || $users->isEmpty()) {
            echo "\n⚠️ No hay datos base (customers, products o users). Saltando FacturaSeeder.\n";
            return;
        }

        // Usar usuarios disponibles (cualquier usuario)
        $cajero = $users->first();
        $admin = $users->count() > 1 ? $users->get(1) : $users->first();

        // Limpiar facturas existentes (de forma segura respetando foreign keys)
        FacturaLinea::query()->delete();
        Factura::query()->delete();

        // Crear 5 facturas de ejemplo
        $facturas = [
            [
                'InvoiceNumber' => 'FAC-001-2025',
                'CustomerId' => $customers->first()->Id,
                'Date' => Carbon::now()->subDays(10),
                'DueDate' => Carbon::now()->subDays(3),
                'Status' => 'Pagado',
                'CreatedBy' => $cajero->id,
                'items' => [
                    ['product_id' => 1, 'quantity' => 10, 'discount' => 0],
                    ['product_id' => 2, 'quantity' => 5, 'discount' => 0],
                ]
            ],
            [
                'InvoiceNumber' => 'FAC-002-2025',
                'CustomerId' => $customers->get(1)?->Id ?? $customers->first()->Id,
                'Date' => Carbon::now()->subDays(7),
                'DueDate' => Carbon::now()->addDays(8),
                'Status' => 'Pendiente',
                'CreatedBy' => $cajero->id,
                'items' => [
                    ['product_id' => 3, 'quantity' => 20, 'discount' => 1000],
                    ['product_id' => 4, 'quantity' => 2, 'discount' => 0],
                ]
            ],
            [
                'InvoiceNumber' => 'FAC-003-2025',
                'CustomerId' => $customers->get(2)?->Id ?? $customers->first()->Id,
                'Date' => Carbon::now()->subDays(5),
                'DueDate' => Carbon::now()->addDays(10),
                'Status' => 'Pagado',
                'CreatedBy' => $admin->id,
                'items' => [
                    ['product_id' => 5, 'quantity' => 15, 'discount' => 0],
                    ['product_id' => 6, 'quantity' => 1, 'discount' => 500],
                ]
            ],
            [
                'InvoiceNumber' => 'FAC-004-2025',
                'CustomerId' => $customers->first()->Id,
                'Date' => Carbon::now()->subDays(2),
                'DueDate' => Carbon::now()->addDays(5),
                'Status' => 'Pendiente',
                'CreatedBy' => $cajero->id,
                'items' => [
                    ['product_id' => 7, 'quantity' => 3, 'discount' => 0],
                ]
            ],
            [
                'InvoiceNumber' => 'FAC-005-2025',
                'CustomerId' => $customers->get(3)?->Id ?? $customers->first()->Id,
                'Date' => Carbon::now()->subDays(1),
                'DueDate' => Carbon::now()->addDays(14),
                'Status' => 'Pendiente',
                'CreatedBy' => $cajero->id,
                'items' => [
                    ['product_id' => 1, 'quantity' => 50, 'discount' => 5000],
                    ['product_id' => 2, 'quantity' => 30, 'discount' => 3000],
                    ['product_id' => 8, 'quantity' => 2, 'discount' => 0],
                ]
            ],
        ];

        foreach ($facturas as $facturaData) {
            $items = $facturaData['items'];
            unset($facturaData['items']);

            // Calcular subtotal, impuesto y total
            $subtotal = 0;
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $subtotal += ($product->Price * $item['quantity']) - $item['discount'];
                }
            }

            $tax = $subtotal * 0.19; // 19% IVA
            $total = $subtotal + $tax;

            $facturaData['Subtotal'] = $subtotal;
            $facturaData['Tax'] = $tax;
            $facturaData['Total'] = $total;

            // Crear factura directamente
            try {
                $factura = Factura::create($facturaData);
                
                // Crear líneas de factura
                foreach ($items as $item) {
                    $product = Product::find($item['product_id']);
                    if ($product) {
                        FacturaLinea::create([
                            'InvoiceId' => $factura->Id,
                            'ProductId' => $product->Id,
                            'Cantidad' => $item['quantity'],
                            'Precio' => $product->Price,
                            'Descuento' => $item['discount'],
                        ]);
                    }
                }
                echo "✅ Factura {$facturaData['InvoiceNumber']} creada exitosamente\n";
            } catch (\Exception $e) {
                echo "❌ Error creando factura {$facturaData['InvoiceNumber']}: " . $e->getMessage() . "\n";
            }
        }
    }
}
