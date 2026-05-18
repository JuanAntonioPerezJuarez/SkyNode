<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Cap Sergio',
            'email' => 'sergio@skynode.com', // El correo que vayas a usar
            'password' => Hash::make('Garritas00@'), // Pon tu clave aquí
            'role' => 'gerente', // O 'role_id' => 1, según cómo armaste tu lógica de roles
        ]);
    }
}