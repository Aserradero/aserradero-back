<?php

namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use function Laravel\Prompts\table;
use Illuminate\Support\Facades\DB;


class CatalogProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //creando el cantalgo de productos
        DB::table('catalog_products')->insert([
            //madera de primera
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //7
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 8.25,
                'precioUnitario' => 24.50,
                'tipoProducto' => "Madera de primera",
                'codigoProducto' => "primera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

            //madera tercera
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 8.25,
                'precioUnitario' => 18.50,
                'tipoProducto' => "Madera de tercera",
                'codigoProducto' => "tercera",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


            //madera de cuarta
            //1
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de cuarta",
                'codigoProducto' => "cuarta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de cuarta",
                'codigoProducto' => "cuarta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de cuarta",
                'codigoProducto' => "cuarta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de cuarta",
                'codigoProducto' => "cuarta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de cuarta",
                'codigoProducto' => "cuarta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //madera de quinta
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 8.25,
                'precioUnitario' => 14,
                'tipoProducto' => "Madera de quinta",
                'codigoProducto' => "quinta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 2
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 2,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 3
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 3,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 4
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 4,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 5
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 5,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 6
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 6,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //tableta largo 7
            //1
            [
                'grosor' => 0.75,
                'ancho' => 3,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 0.75,
                'ancho' => 4,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //3
            [
                'grosor' => 0.75,
                'ancho' => 6,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //4
            [
                'grosor' => 0.75,
                'ancho' => 8,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //5
            [
                'grosor' => 0.75,
                'ancho' => 10,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //6
            [
                'grosor' => 0.75,
                'ancho' => 12,
                'largo' => 7,
                'precioUnitario' => 14,
                'tipoProducto' => "Tableta",
                'codigoProducto' => "tableta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //Polin
            //1
            [
                'grosor' => 3,
                'ancho' => 3,
                'largo' => 8.25,
                'precioUnitario' => 10.50,
                'tipoProducto' => "Polin",
                'codigoProducto' => "polin",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //2
            [
                'grosor' => 4,
                'ancho' => 4,
                'largo' => 8.25,
                'precioUnitario' => 10.50,
                'tipoProducto' => "Polin",
                'codigoProducto' => "polin",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //Vigueta
            //1
              [
                'grosor' => 0,
                'ancho' => 0,
                'largo' => 0,
                'precioUnitario' => 0,
                'tipoProducto' => "Vigueta",
                'codigoProducto' => "vigueta",
                "image"=>"productos/1748986073_th.jpeg",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],


        ]);
    }
}
