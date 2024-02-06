<?php
namespace App\Services;
use App\Repositories\IssueRepository;
use Illuminate\Validation\Rule;

class IssueService{

    private IssueRepository $issueRepository;

    /**
     * [_construct]
     * @param [Issue]    $issueRepository
     */
    public function __construct(IssueRepository $issueRepository)
    {
        $this->issueRepository = $issueRepository;
    }

  

    public function getIssue(int $id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issue = $this->issueRepository->getIssue($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido obtener la incidencia";
            return $result;
        }

        if(empty($issue)){
            $result['message'] = "No se ha encontrado ninguna incidencia";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencia encontrada",
            'data'       => $issue
        );

        return $result;
    }

    public function getCountIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getCountIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener el número de incidencias";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias contadas",
            'data'       => $issues
        );

        return $result;
    }

    public function validateIssues(){
        request()->validate([
            'title'       => 'required',
            'type'        => 'required',
            'description' => 'required'
        ]);
    }

    public function createIssue(int $id, string $title, string $description, string $type){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issue = $this->issueRepository->createIssue($id, $title, $description, $type);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido crear la incidencia";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencia creada",
            'data'       => $issue
        );

        return $result;
    }

    public function getAnimalPendingIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getAnimalPendingIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getMachinePendingIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getMachinePendingIssues();
        
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );

        
        
        return $result;
    }

    public function getFieldPendingIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getFieldPendingIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getOtherPendingIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getOtherPendingIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getAnimalClosedIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getAnimalClosedIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getMachineClosedIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getMachineClosedIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getFieldClosedIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getFieldClosedIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function getOtherClosedIssues(){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issues = $this->issueRepository->getOtherClosedIssues();
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido encontrar las incidencias ";
            return $result;
        }

        if($issues->count()==0){
            $result['message'] = "No hay ninguna incidencia";
            $result['data'] = null;
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencias econtradas",
            'data'       => $issues
        );
        
        return $result;
    }

    public function close($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $issue = $this->issueRepository->close($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se ha podido cerrar la incidencia";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Incidencia cerrada",
            'data'       => $issue
        );

        return $result;
    }

}