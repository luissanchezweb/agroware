<?php

namespace App\Http\Controllers;

use App\Models\Livestock;
use Illuminate\Http\Request;
use App\Services\AnimalService;
use App\Services\EventService;

class LivestockController extends Controller
{
    private $animalService;
    private $eventService;


    public function __construct(AnimalService $animalService, EventService $eventService)
    {
        $this->animalService  = $animalService;
        $this->eventService   = $eventService;
    }


    /*
     * Función para renderizar la vista de ganados
     */
    public function index(){
        $livestocks = Livestock::all();
        return view('components.livestock');
    }

    /*
     * Función para obtener los ganados
     */
    public function show(){
        $livestocks = Livestock::all();
        return $livestocks;
    }

    /*
     * Función para crear un ganado
     */
    public function store(Livestock $livestock){
        //validation
        request()->validate([
            'type' => 'required'
        ]);

        //crear ganado
        $livestock->create([
            'type' => request('type'),
        ]);

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Ganado registrado",
            'data'       => $livestock
        );
        return $result;
    }
}
