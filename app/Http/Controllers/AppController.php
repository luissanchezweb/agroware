<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Session\Session;
use Illuminate\Support\Facades\Http;
use App\Services\AnimalService;
use App\Services\EventService;
use DateTime;

class AppController extends Controller
{
    private $animalService;
    private $eventService;


    public function __construct(AnimalService $animalService, EventService $eventService)
    {
        $this->animalService  = $animalService;
        $this->eventService   = $eventService;
    }

    public function portal()
    {
        
        return view('welcome');
    }

    /*
    *Función que renderiza la página inicial, además, comprueba si existen animales en tratamiento/observación y actualiza su estado cada vez que un usuario
    *accede a esta vista
    */
    public function home()
    {
        $today = new DateTime('now');
        $animalsObv = $this->animalService->getAnimalsObserved();
        $animalsTr  = $this->animalService->getAnimalsTreated();
        $visitas = 0;
            foreach ($animalsObv['data'] as $animal) {
                $relatedEvents = $this->eventService->getAnimalRelatedEvents($animal['code']);

                foreach ($relatedEvents['data'] as $event) {
                    if(isset($event['start'])){
                        if($today->format('Y-m-d') == $event['end'] || $today->format('Y-m-d') > $event['end']){
                            $this->animalService->updateObservations($animal['code'], $animal['n_treats']);  
                        }
                    }  
                }
                
            }

            foreach ($animalsTr['data'] as $animal) {
                $relatedEvents = $this->eventService->getAnimalRelatedEvents($animal['code']);
                $numRelatedPassedEvents = $this->eventService->getNumRelatedPassedEvents($animal['code']);
                if($animal['n_treats'] != 0){
                    if($numRelatedPassedEvents['data'] != 0){
                        $visitas = $animal['n_treats']-$numRelatedPassedEvents['data'];
                    }else{
                        $visitas = $animal['n_treats']-1;
                    }
                }else{
                    $this->animalService->cureAnimal($animal['code']);
                }
                foreach ($relatedEvents['data'] as $event) {
                    if(isset($event['end'])){
                        if($today->format('Y-m-d') == $event['end'] || $today->format('Y-m-d') > $event['end']){ 
                            $this->animalService->updateTreatment($animal['code'], $visitas);
                            $this->eventService->deleteEvent($event['id']);      
                        }
                    }  
                }
                
            }

            
            
        return view('openweather');
    }


 
  

}
