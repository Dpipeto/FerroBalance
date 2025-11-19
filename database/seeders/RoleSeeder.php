<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['Name' => 'Administrador', 'Description' => 'Acceso total al sistema'],
            ['Name' => 'Cajero', 'Description' => 'Gestión de ventas y facturas'],
            ['Name' => 'Almacenista', 'Description' => 'Gestión de inventario'],
            ['Name' => 'Cliente', 'Description' => 'Acceso de cliente estándar'],
        ];

        foreach ($roles as $role) {
            Role::firstOrCreate(
                ['Name' => $role['Name']],
                ['Description' => $role['Description']]
            );
        }
    }
}
