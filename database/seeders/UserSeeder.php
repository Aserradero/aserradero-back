<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $usuario = User::create([
            'name' => 'Juan',
            'apellidos' => 'Pérez Gómez',
            'telefono' => '6621234567',
            'genero' => 'M',
            'nombreUsuario' => 'juanperez',
            'contrasena' => Hash::make('contrasena123'), // opcional
            'email' => 'juan@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar rol
        $usuario->assignRole('admin'); // O 'jefepatio'

        $usuariod = User::create([
            'name' => 'Luis',
            'apellidos' => 'Pérez Gómez',
            'telefono' => '6621234562',
            'genero' => 'M',
            'nombreUsuario' => 'luisfeee',
            'contrasena' => Hash::make('contrasena123'), // opcional
            'email' => 'luis@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Asignar rol
        $usuariod->assignRole('jefepatio'); // O 'jefepatio'
    }
}
