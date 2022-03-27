<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use App\Models\CarsBrands;
use App\Models\CarsModels;

class CarsController extends Controller
{
    public function index(Request $request){

        if($request->brand === 'all'){
            $carsList = Cars::with('carModel.carBrand')->get();
        }

        if($request->brand !== 'all' && $request->model === 'all'){
            $carBrand = CarsBrands::where('name', $request->brand)->first();
            $CarsModelsIds = CarsModels::where('brand_id', $carBrand->id)->pluck('id');
            $carsList = Cars::whereIn('model_id', $CarsModelsIds)->with('carModel.carBrand')->get();
        }

        if($request->brand !== 'all' && $request->model !== 'all'){
            $carModel = CarsModels::where('name', $request->model)->first();
            $carsList = Cars::where('model_id', $carModel->id)->with('carModel.carBrand')->get();
        }


        return response()->json([
            "cars" => $carsList
        ], 200);

    }

    public function view($id){

        $car = Cars::with('carModel.carBrand')->findOrFail($id);

        return response()->json([
            "car" => $car
        ], 200);
    }
}
