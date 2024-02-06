<?php
namespace App\Services;
use App\Repositories\EventRepository;
use Illuminate\Validation\Rule;
use App\Models\Event;


class EventService{

    private EventRepository $eventRepository;

    /**
     * [_construct]
     * @param [Event]    $eventRepository
     */
    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function createEvent($title, $type ,$start, $end, $code, $color){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $this->eventRepository->createEvent($title, $type ,$start, $end, $code, $color);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido crear el evento";
            return $result;
        }


        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Evento creado correctamente",
            'data'       => null
        );

        return $result;
    }    

    public function createClinicalEvent($title, $type ,$start, $end, $n_treats, $n_days_between, $code){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        //$date = $start;
        //$date_start_plus = date('Y-m-d', strtotime($date.'+'.$n_days_between.' days'));
        //date('Y-m-d', strtotime($start."+1 day"))

        try {
            for ($i=0; $i < $n_treats; $i++){ 
                if($i == 0){
                    $this->eventRepository->createAnimalEvent($title, $type ,$start, $end, $code);
                }else{
                    $start_plus = date('Y-m-d', strtotime($start.'+'.$n_days_between.' days'));
                    $this->eventRepository->createAnimalEvent($title, $type ,$start_plus, date('Y-m-d', strtotime($start_plus."+1 day")), $code);
                    $start = $start_plus;
                }
                
            }
            
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido crear el evento clinico";
            return $result;
        }


        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Evento clinico creado correctamente",
            'data'       => null
        );

        return $result;
    }    

    public function getAnimalRelatedEvents($code){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animals = $this->eventRepository->getAnimalRelatedEvents($code);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los eventos de ".$code;
            return $result;
        }
  
        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Eventos encontrados",
            'data'       => $animals
        );

        return $result;
    }

    public function getNumRelatedPassedEvents($code){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $animals = $this->eventRepository->getNumRelatedPassedEvents($code);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los eventos de ".$code;
            return $result;
        }
  
        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Eventos encontrados",
            'data'       => $animals
        );

        return $result;
    }

    public function deleteEvent($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $event = $this->eventRepository->deleteEvent($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido eliminar el evento";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Evento eliminado",
            'data'       => $event
        );

        return $result;
    }

    public function getEvent($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $event = $this->eventRepository->getEvent($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar el evento";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Evento encontrado",
            'data'       => $event
        );

        return $result;
    }

    public function getEvents(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $event = $this->eventRepository->getEvents();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar los eventos";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Eventos encontrados",
            'data'       => $event
        );

        return $result;
    }

    public function updateEvent($title, $type){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $event = $this->eventRepository->updateEvent($title, $type);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido actualizar el evento";
            return $result;
        }


        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Evento actualizado",
            'data'       => $event
        );

        return $result;
    }

}