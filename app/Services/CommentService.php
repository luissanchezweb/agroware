<?php
namespace App\Services;
use App\Repositories\CommentRepository;
use Illuminate\Validation\Rule;
use App\Models\Issue;
use App\Models\User;

class CommentService{

    private CommentRepository $commentRepository;

    /**
     * [_construct]
     * @param [Comment]    $commentRepository
     */
    public function __construct(CommentRepository $commentRepository)
    {
        $this->commentRepository = $commentRepository;
    }

    public function getComments(int $id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $comments = $this->commentRepository->getComments($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener los comentarios";
            return $result;
        }

        if(empty($comments)){
            $result['message'] = "No se ha encontrado ningun comentario";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Comentarios encontrados",
            'data'       => $comments
        );

        return $result;
    }

}    