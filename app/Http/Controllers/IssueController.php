<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Livestock;
use App\Models\Issue;
use App\Models\User;
use Illuminate\Http\Request;
use App\Services\IssueService;
use App\Services\UserService;
use App\Services\CommentService;

class IssueController extends Controller
{
    private $issueService;
    private $userService;
    private $commentService;

    public function __construct(IssueService $issueService, UserService $userService, CommentService $commentService)
    {
        $this->issueService   = $issueService;
        $this->userService    = $userService;
        $this->commentService = $commentService;
    }

    /*
     * Función para renderizar la vista de incidencias
     */
    public function index($id){
        $user          = $this->userService->getUser($id);
        $users         = $this->userService->getUsers();

        return view('components.issues',[
            'users_rep'        => $users['data'],
            'user'             => $user['data']
        ]);
    }

    /*
     * Función para obtener incidencias abiertas de animales
     */
    public function getAnimalPendingIssues(){
        $animalPendingIssues = $this->issueService->getAnimalPendingIssues();
        return $animalPendingIssues;
    }

    /*
     * Función para obtener incidencias abiertas de maquinaria
     */
    public function getMachinePendingIssues(){
        $animalPendingIssues = $this->issueService->getMachinePendingIssues();
        return $animalPendingIssues;
    }

    /*
     * Función para obtener incidencias abiertas de la finca
     */
    public function getFieldPendingIssues(){
        $animalPendingIssues = $this->issueService->getFieldPendingIssues();
        return $animalPendingIssues;
    }

    /*
     * Función para obtener incidencias abiertas de otro tipo
     */
    public function getOtherPendingIssues(){
        $animalPendingIssues = $this->issueService->getOtherPendingIssues();
        return $animalPendingIssues;
    }

    /*
     * Función para obtener incidencias cerradas de animales
     */
    public function getAnimalClosedIssues(){
        $animalClosedIssues = $this->issueService->getAnimalClosedIssues();
        return $animalClosedIssues;
    }

    /*
     * Función para obtener incidencias cerradas de maquinaria
     */
    public function getMachineClosedIssues(){
        $animalClosedIssues = $this->issueService->getMachineClosedIssues();
        return $animalClosedIssues;
    }

    /*
     * Función para obtener incidencias cerradas de la finca
     */
    public function getFieldClosedIssues(){
        $animalClosedIssues = $this->issueService->getFieldClosedIssues();
        return $animalClosedIssues;
    }

    /*
     * Función para obtener incidencias cerradas de otro tipo
     */
    public function getOtherClosedIssues(){
        $animalClosedIssues = $this->issueService->getOtherClosedIssues();
        return $animalClosedIssues;
    }

    /*
     * Función para mostrar una incidencia y su conversación
     */
    public function show($id){
        $issue      = $this->issueService->getIssue($id);
        $comments   = $this->commentService->getComments($id);
        $users      = $this->userService->getUsers();

        return view('components.issue',[
            'issue'     => $issue['data'],
            'comments'  => $comments['data'],
            'users'     => $users['data']
        ]);
    }

    /*
     * Función para obtener todas las incidencias abiertas 
     */
    public function all(){
        $issues = $this->issueService->getCountIssues();
        return $issues['data'];
    }

    /*
     * Función para crear incidencias
     */
    public function store()
    {
        $this->issueService->validateIssues();
        $issue = $this->issueService->createIssue(request()->user()->id,
                                                  request('title'),
                                                  request('description'),
                                                  request('type'));
        
        return $issue;
    }

    /*
     * Función para cerrar incidencias
     */
    public function close($id){
        $issue = $this->issueService->close($id);

        return $issue;
    }


}
