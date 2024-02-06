<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\TaskService;

class EventController extends Controller
{

    private $eventService;
    private $taskService;

    public function __construct(EventService $eventService, TaskService $taskService)
    {
        $this->eventService = $eventService;
        $this->taskService  = $taskService;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index()
    {
        return view('components.calendar.calendar');
    }

    /*
     * Función para obtener los eventos de un calendario
     */
    public function getEvents(){
        return $this->eventService->getEvents();
    }
    
    /*
     * Función para obtener el tipo de evento
     */
    public function type($id){
        return $this->eventService->getEvent($id);

    }

    /*
     * Función para eliminar un evento
     */
    public function delete($title, $titleTask){
        $event = Event::where('title', '=', $title)->first();
        $event->delete();
        $this->taskService->deleteTask($titleTask);

        return $event;
    }

    public function ajax(Request $request): JsonResponse
    {

        switch ($request->type) {
            case 'add':
                $color = "";
                if(request('type') == 'pendingTask'){
                    $color = "red";
                }else{
                    $color = "blue";
                }
                $result = $this->eventService->createEvent(request('title'), request('type'), request('start'), request('end'), "none", $color);

                return response()->json($result['data']);
                break;

            case 'update':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $result = $this->eventService->deleteEvent(request('id'));
                return response()->json($result['data']);
                break;
        }
    }
}
