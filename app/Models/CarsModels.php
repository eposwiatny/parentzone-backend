<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarsModels extends Model
{
    use HasFactory;

    public function carBrand(){
        return $this->hasOne('App\Models\CarsBrands', 'id', 'brand_id');
    }

    protected $fillable = [
        'name',
        'brand_id'
    ];

}
