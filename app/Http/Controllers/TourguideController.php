<?php

namespace App\Http\Controllers;

use App\Models\Tourguide;
use Illuminate\Http\Request;

class TourguideController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Tourguide::all(),200);
       
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
        $tourguide=Tourguide::create($input);
        $tourguide= $tourguide->save();
        if($tourguide){
            return response($tourguide->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tourguide  $tourguide
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $tourguide= Tourguide::where('id',$id)->first();
        if($tourguide){
            return response($tourguide,200);
        }else{
            return response($tourguide,404);
        }
    }

 /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tourguide  $tourguide
     * @return \Illuminate\Http\Response
     */
    public function showbyname( $name)
    {
        $tourguide= Tourguide::where('name',$name)->first();
        if($tourguide){
            return response($tourguide,200);
        }else{
            return response($tourguide,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tourguide  $tourguide
     * @return \Illuminate\Http\Response
     */
    public function edit(Tourguide $tourguide)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tourguide  $tourguide
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $tourguide = Tourguide::find($id);
        if($tourguide){
            $input = $request->all();
            $result= $tourguide->fill($input)->save(); 
            if($result){
                return response($tourguide,201);
            }else{
                return response($tourguide,500);
            }
        }else{
            return response($tourguide,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tourguide  $tourguide
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tourguide = Tourguide::findOrFail($id);
        if($tourguide){ 
            if($tourguide->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($tourguide,404);
        }
    }
}
