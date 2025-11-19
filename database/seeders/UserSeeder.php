<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Felipe Garzon',
                'email' => 'admin@ferrobalance.com',
                'password' => Hash::make('Admin123.'),
                'role' => 'Administrador'
            ],
            [
                'name' => 'Nana Banana',
                'email' => 'nanabnn@ferrobalance.com',
                'password' => Hash::make('Nana123.'),
                'role' => 'Cajero'
            ],
            [
                'name' => 'Andres Almacenista',
                'email' => 'andresfr@ferrobalance.com',
                'password' => Hash::make('Andres123.'),
                'role' => 'Almacenista'
            ],
            [
                'name' => 'Santiago Gutierrez',
                'email' => 'santiguti@gmail.com',
                'password' => Hash::make('Santi123.'),
                'role' => 'Cliente'
            ],
            [
                'name' => 'Juan Romero',
                'email' => 'jdromero@ferrobalance.com',
                'password' => Hash::make('Diego123.'),
                'role' => 'Cliente'
            ],
        ];

        foreach ($users as $userData) {
            $roleName = $userData['role'];
            unset($userData['role']);

            $user = User::firstOrCreate(
                ['email' => $userData['email']],
                $userData
            );

            // Asignar rol si no lo tiene
            $role = Role::where('Name', $roleName)->first();
            if ($role && !$user->roles()->where('RoleId', $role->Id)->exists()) {
                $user->roles()->attach($role->Id);
            }
        }
    }
}
