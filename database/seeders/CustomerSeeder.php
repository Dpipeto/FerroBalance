<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            [
                'Name' => 'Ana Cliente',
                'Email' => 'cliente@ferrobalance.com',
                'Phone' => '555-1234',
                'UserId' => null, // Se actualizará después
            ],
            [
                'Name' => 'Juan Romero',
                'Email' => 'jdromero@ferrobalance.com',
                'Phone' => '555-5678',
                'UserId' => null, // Se actualizará después
            ],
            [
                'Name' => 'Ferretería Central',
                'Email' => 'info@ferreteriacentral.com',
                'Phone' => '555-9999',
                'UserId' => null,
            ],
            [
                'Name' => 'Construcciones ABC',
                'Email' => 'contacto@construccionesabc.com',
                'Phone' => '555-8888',
                'UserId' => null,
            ],
        ];

        foreach ($customers as $customerData) {
            // Buscar el usuario por email si existe
            $user = User::where('email', $customerData['Email'])->first();
            if ($user) {
                $customerData['UserId'] = $user->id;
            }

            Customer::firstOrCreate(
                ['Email' => $customerData['Email']],
                $customerData
            );
        }
    }
}
