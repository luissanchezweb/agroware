<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gerente = Role::create(['name' => 'Gerente']);
        $trabajador = Role::create(['name' => 'Trabajador']);

        Permission::create(['name' => 'ver trabajadores'])->assignRole($gerente);
        Permission::create(['name' => 'crear trabajadores'])->assignRole($gerente);
        Permission::create(['name' => 'editar trabajadores'])->assignRole($gerente);
        Permission::create(['name' => 'eliminar trabajadores'])->assignRole($gerente);
    }
}
