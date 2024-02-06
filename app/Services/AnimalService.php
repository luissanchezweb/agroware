<?php
namespace App\Services;
use App\Repositories\AnimalRepository;
use Illuminate\Validation\Rule;
use App\Models\Animal;
use DateTime;

class AnimalService{

    private AnimalRepository $animalRepository;

    /**
     * [_construct]
     * @param [Animal]    $animalRepository
     */
    public function __construct(AnimalRepository $animalRepository)
    {
        $this->animalRepository = $animalRepository;
    }

    public function getAnimals($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animals = $this->animalRepository->getAnimals($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los animales";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animales encontrados",
            'data'       => $animals
        );

        return $result;
    }

    public function getAnimal($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animal = $this->animalRepository->getAnimal($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido obtener el animal";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animal encontrado",
            'data'       => $animal
        );

        return $result;
    }


    public function getObservations($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animal = $this->animalRepository->getObservations($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido obtener las notas clínicas";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Notas encontradas",
            'data'       => $animal
        );

        return $result;
    }

    public function treat($id, $n_tratamientos){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animal = $this->animalRepository->observe($id, $n_tratamientos);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido tratar al animal";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Solicitud de tratamiento correcta",
            'data'       => $animal
        );

        return $result;
    }

    public function getAnimalsObserved(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animals = $this->animalRepository->getAnimalsObserved();

        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los animales en observación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animales encontrados",
            'data'       => $animals
        );

        return $result;
    }

    public function getAnimalsTreated(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animals = $this->animalRepository->getAnimalsTreated();

        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los animales en tratamiento";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animales encontrados",
            'data'       => $animals
        );

        return $result;
    }

    public function updateObservations($code, $n_tratamientos){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $observations = $this->animalRepository->updateObservations($code, $n_tratamientos);
            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido actualizar las observaciones médicas";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Observaciones actualizadas",
            'data'       => $observations
        );

        return $result;
    }

    public function updateTreatment($code, $n_tratamientos){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $observations = $this->animalRepository->updateTreatment($code, $n_tratamientos);
            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido actualizar las observaciones médicas";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Observaciones actualizadas",
            'data'       => $observations
        );
        return $result;
    }

    public function cureAnimal($code){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $observations = $this->animalRepository->cureAnimal($code);
            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido curar al animal";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animal curado",
            'data'       => $observations
        );

        return $result;
    }

    public function calculateAge($f_nacimiento){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $birth = new DateTime($f_nacimiento);
            $now = new DateTime(date("Y-m-d"));
            $age = $now->diff($birth);            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido calcular la edad";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Edad calculada",
            'data'       => $age->format("%y")
        );

        return $result;
    }

    public function createAnimal($livestock_id, $code, $race, $genre,  $age ,$weight, $health_condition, $food, $production, $observations, $waiting_vet, $n_treats, $birth_date){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animal = $this->animalRepository->createAnimal($livestock_id, $code, $race, $genre, $age, 
                                                            $weight, $health_condition, $food, $production, 
                                                            $observations, $waiting_vet, $n_treats, $birth_date);
            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido crear al animal";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animal creado",
            'data'       => $animal
        );

        return $result;
    }

    public function validateCode($code){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->animalRepository->getCode($code);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }

    public function checkMaxAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->animalRepository->checkMaxAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido realizar la comparación";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Operación realizada",
            'data'       => $response
        );
        
        return $result;
    }

    public function sellAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax, $n_animals_sell){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->animalRepository->sellAnimals($livestockcode, $agemin, $agemax, $weightmin, $weightmax, $n_animals_sell);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido vender los animales";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animales vendidos",
            'data'       => $response
        );
        
        return $result;
    }

    public function deleteAnimal($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
        );

        try {
            $response = $this->animalRepository->deleteAnimal($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido eliminar el animal";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Animal eliminado",
            'data'       => $response
        );
        
        return $result;
    }

    
}