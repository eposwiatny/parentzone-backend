<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cars extends Model
{
    use HasFactory;

    public function carModel(){
        return $this->hasOne('App\Models\CarsModels', 'id', 'model_id');
    }

    protected $fillable = [
        'img_url',
        'description',
        'model_id',
        'places',
        'is_automatic',
        'fuel_type',
        'price'
    ];
}
