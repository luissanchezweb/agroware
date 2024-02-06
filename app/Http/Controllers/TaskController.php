<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\EventService;
use App\Services\UserService;

class TaskController extends Controller
{

    private $eventService;
    private $userService;

    public function __construct(EventService $eventService, UserService $userService)
    {
        $this->eventService = $eventService;
        $this->userService  = $userService;
    }

    /*
     * Función para renderizar la vista del tablón de tareas con las tareas del usuario
     */
    public function index(){
        $users         = User::all();
        $tasksPending  = Task::all()->where('user_id', '=', auth()->user()->id)
                                    ->where('status', '=', 'pending');
        $tasksProcess  = Task::all()->where('user_id', '=', auth()->user()->id)
                                    ->where('status', '=', 'process');
        $tasksDone     = Task::all()->where('user_id', '=', auth()->user()->id)
                                    ->where('status', '=', 'done');

        return view('components/dashboard-tasks',[
            "users" => $users,
            "tasksPen" => $tasksPending,
            "tasksPro" => $tasksProcess,
            "tasksDo" => $tasksDone
        ]);
    }

    /*
     * Función para mostrar una tarea
     */
    public function show($id){
        $task = Task::find($id);
        return response()->json($task,200);
    }

    /*
     * Función para crear una tarea
     */
    public function store(Task $tarea){
        //validation
        request()->validate([
            'title' => 'required',
            'description' => 'required',
            'user_id' => 'required'
        ]);

        //crear tarea
        $tarea->create([
            'title' => request('title'),
            'description' => request('description'),
            'user_id' => request('user_id'),
            'status' => 'pending',
            'start'  => request('start_date'),
            'finish' => request('finish_date')
        ]);
        $user = $this->userService->getUser(request('user_id'));
        $name = $user['data']->name;
        $this->eventService->createEvent(request('title')." (".$name.")", 'pending', request('start_date'), request('finish_date'), 0, 'red');

        return response()->json(['success' => 'Tarea asignada']);
    }

    /*
     * Función para actualizar el estado de una tarea
     */
    public function update($id){
        $task = Task::find($id);
        $task->status = request('status');
        $task->save();

        $user = $this->userService->getUser($task->user_id);
        $name = $user['data']->name;

        $this->eventService->updateEvent($task->title." (".$name.")",  $task->status);
        return response()->json($task,200);
    }

    /*
     * Función para eliminar una tarea
     */
    public function delete($id){
        $task = Task::find($id);
        $task->delete();
        return response()->json(['success' => 'Tarea borrada correctamente']);
    }


}
