<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RawMaterialsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $calidades = ['primera', 'segunda', 'tercera']; // Opciones para calidad

        for ($i = 0; $i < 100; $i++) { // Generar 10 registros aleatorios
            DB::table('raw_materials')->insert([
                'cantidad' => rand(5, 50), // Cantidad entre 5 y 50
                'diametroUno' => round(mt_rand(2000, 5000) / 100, 4), // Diametro entre 20.00 y 50.00
                'diametroDos' => round(mt_rand(2000, 5000) / 100, 4), // Diametro entre 20.00 y 50.00
                'largo' => round(mt_rand(4000, 10000) / 100, 4), // Largo entre 40.00 y 100.00
                'metroCR' => round(mt_rand(5000, 20000) / 100, 4), // Metro cúbico entre 50.00 y 200.00
                'fechaRegistro' => Carbon::now()->subDays(rand(0, 365))->format('Y-m-d'), // Fecha aleatoria en el último año
                'calidad' => $calidades[array_rand($calidades)], // Selección aleatoria de calidad
                'identificadorP' => 0, // Siempre 0
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}
