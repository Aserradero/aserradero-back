<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RawMaterialInventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) { // Generar 10 registros aleatorios
            DB::table('raw_material_inventories')->insert([
                'stockIdeal' =>round(mt_rand(2000, 5000) / 100, 4), // Diametro entre 20.00 y 50.00 // Cantidad entre 5 y 5
                'idUsuario' =>2
            ]);
        }
    }
}
