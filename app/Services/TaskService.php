<?php
namespace App\Services;
use App\Repositories\TaskRepository;
use Illuminate\Validation\Rule;
use App\Models\Issue;
use App\Models\User;

class TaskService{

    private TaskRepository $taskRepository;

    /**
     * [_construct]
     * @param [Task]    $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function deleteTask($title){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $task = $this->taskRepository->deleteTask($title);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido eliminar la tarea";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Tarea eliminada",
            'data'       => $task
        );

        return $result;
    }
    
}