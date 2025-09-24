<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Perfil;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrador',
                'password' => Hash::make(env('ADMIN_PASSWORD', 'admin')),
                'username_verified_at' => now(),
            ]
        );

        Perfil::firstOrCreate(
            ['user_id' => $user->id],
            [
                'nome_completo' => 'Administrador',
                'adm' => true,
            ]
        );
    }
}
