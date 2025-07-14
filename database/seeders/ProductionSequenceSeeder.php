<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductionSequenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('production_sequence')->insertOrIgnore([
            'id' => 1,
            'last_id' => 0,
            'last_identificadorP' => 0,
        ]);
    }
}
