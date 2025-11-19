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
                'name' => 'Juan Administrador',
                'email' => 'admin@ferrobalance.com',
                'password' => Hash::make('password123'),
                'role' => 'Administrador'
            ],
            [
                'name' => 'María Cajero',
                'email' => 'cajero@ferrobalance.com',
                'password' => Hash::make('password123'),
                'role' => 'Cajero'
            ],
            [
                'name' => 'Carlos Almacenista',
                'email' => 'almacen@ferrobalance.com',
                'password' => Hash::make('password123'),
                'role' => 'Almacenista'
            ],
            [
                'name' => 'Ana Cliente',
                'email' => 'cliente@ferrobalance.com',
                'password' => Hash::make('password123'),
                'role' => 'Cliente'
            ],
            [
                'name' => 'Juan Romero',
                'email' => 'jdromero@ferrobalance.com',
                'password' => Hash::make('password123'),
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
