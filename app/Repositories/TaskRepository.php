<?php
namespace App\Repositories;
use App\Models\Task;


class TaskRepository {

    public function deleteTask($title){
        $task = Task::where('title','=', $title)->first();
        $task->delete();
        return $task;
    }
}