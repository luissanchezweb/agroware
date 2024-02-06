<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function livestock()
    {
        return $this->belongsTo(Livestock::class,'livestock_id');
    }
}
