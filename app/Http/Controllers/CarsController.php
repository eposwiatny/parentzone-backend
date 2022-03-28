<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;
use App\Models\CarsBrands;
use App\Models\CarsModels;
use Illuminate\Support\Facades\Validator;


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


        $validator = Validator::make($request->all(), [
            'brand' => 'required_if:!newBrand,==,""',
            'newBrand' => 'required_if:!brand,==,""',
            'model' => 'required_if:!newModel,==,""',
            'newModel' => 'required_if:!model,==,""',
            'description'   => 'required',
            'fuel_type'   => 'required',
            'places'   => 'numeric|required',
            'price'   => 'numeric',
            'transmission'   => 'required',
          ]);

          
      
            if ($validator->fails()) {
              return response()->json(
                $validator->errors(),
              400);
            }
            else{

        if($request->newBrand){
            $brand = CarsBrands::create(['name' => $request->newBrand]);
            $brand = $brand->id;
        }
        else{
            $brand = CarsBrands::where('name', $request->brand)->first();
            $brand = $brand->id;
        }

        if($request->newModel){
            $model= CarsModels::create([
                'name' => $request->newModel,
                'brand_id' => $brand,
            ]);
            $model = $model->id;
        }
        else{
            $model = CarsModels::where('name', $request->model)->first();
            $model = $model->id;
        }


        Cars::create([
            'img_url'       => null,
            'description'   => $brand,
            'model_id'      => $model,
            'places'        => $request->places,
            'is_automatic'  => $request->transmission,
            'fuel_type'     => $request->fuel_type,
            'price'         => $request->price
          ]);

        }

    }
}
