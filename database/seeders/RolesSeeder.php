<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Creamos los permisos 
        $seeProduction = Permission::create(['name' => 'see production']);
        $seeInventory = Permission::create(['name' => 'see inventory']);
        $seeSale = Permission::create(['name' => 'see sales']);
        //Creamos los roles
        $adminRole = Role::create(['name' => 'admin']);
        $jefePatioRole = Role::create(['name' => 'jefepatio']);
        //asignamos permisos a los roles 
        $adminRole->givePermissionTo($seeInventory, $seeSale);
        $jefePatioRole->givePermissionTo($seeProduction);
    }
}