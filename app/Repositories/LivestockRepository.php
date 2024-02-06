<?php
namespace App\Repositories;
use App\Models\Livestock;


class LivestockRepository {

    public function getLivestock($id){
        return Livestock::find($id);
    }
}