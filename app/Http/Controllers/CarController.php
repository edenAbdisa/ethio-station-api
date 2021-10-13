<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Exception;
class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Car::all(),200);
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all(); 
        $car=Car::create($input);
        $car= $car->save();
        if($car){
            return response($car->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $car= Car::where('id',$id)->first();
        if($car){
            return response($car,200);
        }else{
            return response($car,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Car $car)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $car = Car::find($id);
        if($car){
            $input = $request->all();
            $result= $car->fill($input)->save(); 
            if($result){
                return response($car,201);
            }else{
                return response($car,500);
            }
        }else{
            return response($car,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        if($car){ 
            if($car->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($car,404);
        }
    }
}
