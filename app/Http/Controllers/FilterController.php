<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CarsBrands;
use App\Models\CarsModels;

class FilterController extends Controller
{
    public function index(Request $request){

        if($request->brand === 'all' || $request->brand == ''){
            $brands = CarsBrands::all();
            $models = [];
        }
        
        else if($request->brand !== 'all' && $request->model == 'all' || $request->model == ''){
            $brands = CarsBrands::all();
            $brandTmp = CarsBrands::where('name', $request->brand)->first();
            $models = CarsModels::where('brand_id', $brandTmp->id)->get();
        };
        
        return response()->json([
            'brands' => $brands,
            'models' => $models,
        ], 200);
        
    
    }
}
