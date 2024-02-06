<?php

namespace App\Http\Controllers;

use App\Models\Animal;
use App\Models\Livestock;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\AnimalService;
use App\Services\EventService;
use App\Services\LivestockService;

class AnimalController extends Controller
{
    private $animalService;
    private $eventService;
    private $livestockService;

    public function __construct(AnimalService $animalService, EventService $eventService, LivestockService $livestockService)
    {
        $this->animalService  = $animalService;
        $this->eventService   = $eventService;
        $this->livestockService = $livestockService;
    }

    /*
    *Función para mostrar animales
    */
    public function show($id){
        $animals = $this->animalService->getAnimals($id);
        return $animals;
    }

    /*
    *Función para obtener un animal
    */
    public function getAnimal($id){
        $animal = $this->animalService->getAnimal($id);
        return $animal;
    }

    /*
    *Función para obtener las observaciones de un animal
    */
    public function getObservations($id){
        $observations = $this->animalService->getObservations($id);
        return $observations;
    }

    /*
    *Función para tratar un animal
    */
    public function treat($id){
        $animal = $this->getAnimal($id);
        $crotal = $animal['data']->code;
        $this->eventService->createClinicalEvent('Revisión para '.$crotal,'vet',
                                                request('start_date'),
                                                date('Y-m-d', strtotime(request('start_date')."+1 day")),
                                                request('n_treats'),
                                                request('n_days_between'), 
                                                $crotal);

        $result = $this->animalService->treat($id, request('n_treats'));
        return $result;
    }


    /*
    *   Función para obtener el número de animales enfermos
    */
    public function sick_animals(){
        $animals = Animal::all()->where("health_condition",'=','enfermo')->count();
        return $animals;
    }

    /*
    *   Función para obtener el número de animales en tratamiento 
    */
    public function treated_animals(){
        $animals = Animal::all()->where("health_condition",'=','tratamiento')->count();
        return $animals;
    }

    /*
    *Función para crear animales
    */
    public function store(Animal $animal){
        //validation

        $livestock   = Livestock::find(request('livestock'));
        $cod_letters = substr($livestock->type,0,3);
        $cod_letters = strtoupper($cod_letters);
        $code        = $cod_letters.request('codigo');
        $age         = $this->animalService->calculateAge(request('f_nacimiento'));

        $result      = $this->animalService->createAnimal(request('livestock'), $code, request('raza'), request('genre'), $age['data'], request('peso'),
                                             request('health_condition'), request('alimentacion'),  request('produccion'),  request('observations'),
                                             '0', '0', request('f_nacimiento'));
    


        return $result;
    }

    /*
    *Función para actualizar animales
    */    
    public function update($id){
        $animal = Animal::find($id);
        $animal->weight = request('animalweight');
        $animal->food = request('animalfood');
        $animal->production = request('animalproduction');
        $animal->save();
        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animal actualizado",
            'data'       => $animal
        );
        return $result;
    }

    /*
    *Función para eliminar animales
    */
    public function delete($id){
        $result = $this->animalService->deleteAnimal($id);
        return $result;
    }

    /*
    *Función para comprobar si existe un crotal 
    */
    public function validateCode($livestockcode,$number){
        $livestock = $this->livestockService->getLivestock($livestockcode);
        $livestockLetters = strtoupper(substr($livestock['data']['type'], 0, 3));  
        $code = $livestockLetters.$number;

        $response = $this->animalService->validateCode($code);
        return $response;
    }

    /*
    *Función para comprobar los animales disponibles en una venta
    */
    public function validateSell($livestockcode,$agemin, $agemax, $weightmin, $weightmax){
        $response = $this->animalService->checkMaxAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax);
        return $response;
    }

    /*
    *Función para vender animales
    */
    public function sell($livestockcode,$agemin, $agemax, $weightmin, $weightmax, $n_animals_sell){
        $response = $this->animalService->sellAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax, $n_animals_sell);
        return $response;
    }

    /*
    *Función para notificar una enfermedad
    */
    public function patology($id){
        $animal = Animal::find($id);
        $animal->observations = request('patology');
        $animal->health_condition = "enfermo";
        $animal->save();

        return $animal;
    }


}
