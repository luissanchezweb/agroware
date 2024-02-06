<?php
namespace App\Repositories;
use App\Models\Animal;


class AnimalRepository {

    public function getAnimals($id){
        return Animal::where("livestock_id",'=',$id)->get();
    }

    public function getAnimal($id){
        return Animal::find($id);
    }

    public function getObservations($id){
        return Animal::where('id', '=', $id)->value('observations');  
    }

    public function observe($id, $n_tratamientos){
        $animal = $this->getAnimal($id);
        $animal->health_condition = 'observacion';
        $animal->waiting_vet = '1';
        $animal->observations = 'Este animal recibirá un tratamiento';
        $animal->n_treats = $n_tratamientos;
        $animal->save(); 
    }

    public function getAnimalsObserved(){
        $animals = Animal::where('health_condition', '=', 'observacion')->get();  
        return $animals;
    }

    public function getAnimalsTreated(){
        $animals = Animal::where('health_condition', '=', 'tratamiento')->get();
        return $animals;
    }

    public function updateObservations($code, $n_tratamientos){

        $animal = Animal::where('code', '=',$code)->first();
        $animal->health_condition = 'tratamiento';
        $animal->observations = "Este animal está siendo tratado por un veterinario, recibirá ".$n_tratamientos." visitas."; 
        $animal->save(); 
        
        return $animal;
    }

    public function updateTreatment($code, $n_tratamientos){

        $animal = Animal::where('code', '=',$code)->first();
        $animal->health_condition = 'tratamiento';
        $animal->n_treats = $n_tratamientos;
        if($n_tratamientos > 1){
            $animal->observations = "Este animal está siendo tratado por un veterinario, tiene ".$n_tratamientos." visitas pendientes."; 
        }else{
            $animal->observations = "Este animal está siendo tratado por un veterinario, debe recibir una última visita."; 
        }        
        $animal->save(); 
        
        return $animal;
    }

    public function cureAnimal($code){

        $animal = Animal::where('code', '=',$code)->first();
        $animal->health_condition = 'saludable';
        $animal->n_treats = 0;
        $animal->waiting_vet = 0;
        $animal->observations = "Este animal está sano."; 
        $animal->save(); 
        
        return $animal;
    }

    public function createAnimal($livestock_id, $code, $race, $genre, $age,$weight, $health_condition, $food, $production, $observations, $waiting_vet, $n_treats, $birth_date){
        $animal = Animal::create([
            'livestock_id'      => $livestock_id,
            'code'              => $code,
            'race'              => $race,
            'genre'             => $genre,
            'age'               => $age,
            'weight'            => $weight,
            'health_condition'  => $health_condition,
            'food'              => $food,
            'production'        => $production,
            'observations'      => $observations,
            'waiting_vet'       => $waiting_vet,
            'n_treats'          => $n_treats,
            'birth_date'        => $birth_date
        ]);    

        return $animal;
    }

    public function getCode(string $code){
        $animal = Animal::where('code',$code) -> first();

        if(empty($animal)){
            return true;
        }else{
            return false;
        }
    }

    public function checkMaxAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax){
        if($agemin <= $agemax && $weightmin <= $weightmax){
            $animal = Animal::where('livestock_id','=', $livestockcode)
                    ->where('health_condition','=','saludable')
                    ->where('age','>=', $agemin)
                    ->where('age','<=', $agemax)
                    ->where('weight','>=', $weightmin)
                    ->where('weight','<=', $weightmax)
                    ->get();

        
        
            if(count($animal)>0){
                return $animal;
            }else{
                return 0;
            }

        }else{
            return false;
        }

    }

    public function sellAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax, $n_animals_sell){
        $cont = 0;
        $animals = Animal::where('livestock_id','=', $livestockcode)
                    ->where('health_condition','=','saludable')
                    ->where('age','>=', $agemin)
                    ->where('age','<=', $agemax)
                    ->where('weight','>=', $weightmin)
                    ->where('weight','<=', $weightmax)
                    ->get();

        foreach ($animals as $animal) {
            if($cont < $n_animals_sell){
                $animal->delete();
                $cont ++;
               }         
            }
                    
        
            return $animals;

    }

    public function deleteAnimal($id){
        $animal = $this->getAnimal($id);
        $animal->delete();
        return $animal;
    }
}