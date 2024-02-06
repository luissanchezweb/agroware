<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $code = "";
        $livestockId = fake()->numberBetween(1,4);
        $gender = fake()->randomElement(['macho','hembra']);
        $race = array();
        $food = array('pienso concentrado', 'pienso natural', 'semillas', 'heno', 'fruta', 'paja');
        $production = array('carne', 'cría', 'leche', 'espectáculo','huevos','ventas');
        $health_condition = fake()->randomElement(['saludable', 'enfermo']);
        if($health_condition == 'saludable'){
            $observations = "Este animal está sano.";
        }else{
            $observations = "Este animal está enfermo. ";
        }
        

        switch ($livestockId){
            case 1://cerdos
                $code = "POR";
                $race = array('Duroc', 'Ibérico', 'Pietrain', 'Chato', 'Landrace', 'Large White', 'Porco Celta');
                $food = array('pienso concentrado', 'pienso natural', 'fruta');
                $production = 'carne';
                break;
            case 2://aves
                $code = "AVI";
                $race = array('Andaluza azul', 'Combatiente Espanol', 'Castellana Negra', 'Pedresa', 'Murciana', 'Utrerana', 'Pardo de León');
                $food = array('pienso concentrado', 'pienso natural', 'fruta', 'semillas');
                $production = 'huevos';
                break;
            case 3://vacas
                $code= "BOV";
                $race = array('Albera', 'Frisona', 'Charolesa', 'Berrenda', 'Asturiana', 'Lidia', 'Retinta', 'Rubia gallega', 'Serrana negra', 'Parda', 'Negra Andaluza');
                $food = array('pienso concentrado', 'pienso natural', 'fruta', 'heno', 'paja');
                $production = 'leche';
                break;
            case 4://ovejas
                $code = "OVI";
                $race = array('Churra', 'Lacaune', 'Cartera', 'Merina', 'Ojalada', 'Guirra', 'Carranza');
                $food = array('pienso concentrado', 'pienso natural', 'fruta', 'heno', 'paja');
                $production = 'ventas';
                break;
        }


        return [
            'livestock_id' => $livestockId,
            'code' => $code.fake()->numberBetween(1,200),
            'race' => fake()->randomElement($race),
            'genre' => $gender,
            'age' => fake()->numberBetween(1,10),
            'weight' => fake()->numberBetween(50,150),
            'health_condition' => $health_condition,
            'observations' => $observations,
            'food' => fake()->randomElement($food),
            'production' => $production,
            'birth_date' => fake()->dateTimeBetween('-10 years'),
            'waiting_vet' => 0,
            'n_treats' => 0
        ];
    }
}
