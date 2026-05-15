<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Administrador',
                'email'    => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'rol'      => 'administrador',
            ]
        );

        User::firstOrCreate(
            ['email' => 'veterinario@gmail.com'],
            [
                'name'     => 'Veterinario',
                'email'    => 'veterinario@gmail.com',
                'password' => Hash::make('veterinario'),
                'rol'      => 'veterinario',
            ]
        );
    }
}
