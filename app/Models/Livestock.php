<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestock extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function animals(){
        return $this->hasMany(Animal::class);
    }
}
