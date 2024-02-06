<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Animal;
use App\Models\Livestock;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(RoleSeeder::class);

         User::factory()->create([
             'name' => 'Manuela Carmena',
             'username' => 'carmelita',
             'email' => 'test1@example.com',
             'rol' => 'Gerente'
         ])->assignRole('Gerente');

        User::factory()->create([
            'name' => 'Luis Sánchez',
            'username' => 'luissg',
            'email' => 'test2@example.com',
            'rol'  => 'Trabajador'
        ])->assignRole('Trabajador');


        //GANADO
        Livestock::factory()->create([
            'type' => 'porcino'
        ]);

        Livestock::factory()->create([
            'type' => 'avicola'
        ]);

        Livestock::factory()->create([
            'type' => 'bovino'
        ]);

        Livestock::factory()->create([
            'type' => 'ovino'
        ]);

        //ANIMALES
        Animal::factory(200)->create();
    }
}
