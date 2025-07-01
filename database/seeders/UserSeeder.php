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
            'telefono' => '9512123567',
            'genero' => 'M',
            'nombreUsuario' => 'juanperez2',
            'contrasena' => Hash::make('contrasena123'), // opcional
            'email' => 'juan@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            "image" => "usuarios/usuario.jpg",
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
            'password' => Hash::make('123456789'),
            "image" => "usuarios/usuario.jpg",
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Asignar rol
        $usuariod->assignRole('jefepatio'); // O 'jefepatio'




        $usuario = User::create([
            'name' => 'saul',
            'apellidos' => 'Pérez Gómez',
            'telefono' => '6621234590',
            'genero' => 'M',
            'nombreUsuario' => 'saul34',
            'contrasena' => Hash::make('contrasena123'), // opcional
            'email' => 'saul@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            "image" => "usuarios/usuario.jpg",
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Asignar rol
        $usuario->assignRole('admin'); // O 'jefepatio'


        $usuariod = User::create([
            'name' => 'saul dos',
            'apellidos' => 'Pérez Gómez',
            'telefono' => '9512349010',
            'genero' => 'M',
            'nombreUsuario' => 'saul5466',
            'contrasena' => Hash::make('contrasena123'), // opcional
            'email' => 'sauldos@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123456789'),
            "image" => "usuarios/usuario.jpg",
            'remember_token' => \Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        // Asignar rol
        $usuariod->assignRole('jefepatio'); // O 'jefepatio'
    }
}
