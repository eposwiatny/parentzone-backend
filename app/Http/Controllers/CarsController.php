<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cars;

class CarsController extends Controller
{
    public function index(){

        $carsList = Cars::with('carModel.carBrand')->get();

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
