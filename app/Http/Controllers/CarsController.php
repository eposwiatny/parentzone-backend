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

    public function store(Request $request){

        if($request->newBrand){
            $brand = CarsBrands::create(['name' => $request->newBrand]);
            $brand = $brand->id;
        }
        else{
            $brand = $request->brand;
        }

        if($request->newModel){
            $model= CarsModels::create([
                'name' => $request->newModel,
                'brand_id' => $brand,
            ]);
            $model = $model->id;
        }
        else{
            $model = $request->model;
        }

        Cars::create([
            'img_url'       => 'x',
            'description'   => $brand,
            'model_id'      => $model,
            'places'        => $request->places,
            'is_automatic'  => $request->transmission,
            'fuel_type'     => $request->fuel_type,
            'price'         => $request->price
          ]);

    }
}
