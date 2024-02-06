<?php
namespace App\Services;
use App\Repositories\LivestockRepository;
use Illuminate\Validation\Rule;
use App\Models\Issue;
use App\Models\User;

class LivestockService{

    private LivestockRepository $livestockRepository;

    /**
     * [_construct]
     * @param [Livestock]    $livestockRepository
     */
    public function __construct(LivestockRepository $livestockRepository)
    {
        $this->livestockRepository = $livestockRepository;
    }

    public function getLivestock($id){
        $result = array(
            'status'     => false,
            'statusCode' => 400,
            'message'    => "Ups! Ha ocurrido un error",
            'data'       => null
        );

        try {
            $livestock = $this->livestockRepository->getLivestock($id);
        } catch (\Throwable $th) {
            $result['message'] = "No se han podido obtener el ganado";
            return $result;
        }

        $result = array(
            'status'     => true,
            'statusCode' => 200,
            'message'    => "Ganado encontrado",
            'data'       => $livestock
        );

        return $result;
    }

}