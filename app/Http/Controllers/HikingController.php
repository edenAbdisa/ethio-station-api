<?php

namespace App\Http\Controllers;

use App\Models\Hiking;
use Illuminate\Http\Request;

class HikingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Hiking::all(),200);
       
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
        $hiking=Hiking::create($input);
        $hiking= $hiking->save();
        if($hiking){
            return response($hiking->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Hiking  $hiking
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $hiking= Hiking::where('id',$id)->first();
        if($hiking){
            return response($hiking,200);
        }else{
            return response($hiking,404);
        }
    }

	/**
     * Display the specified resource.
     *
     * @param  \App\Models\Hiking  $hiking
     * @return \Illuminate\Http\Response
     */
    public function showbyname( $name)
    {
        $hiking= Hiking::where('name',$name)->first();
        if($hiking){
            return response($hiking,200);
        }else{
            return response($hiking,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Hiking  $hiking
     * @return \Illuminate\Http\Response
     */
    public function edit(Hiking $hiking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Hiking  $hiking
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hiking = Hiking::find($id);
        if($hiking){
            $input = $request->all();
            $result= $hiking->fill($input)->save(); 
            if($result){
                return response($hiking,201);
            }else{
                return response($hiking,500);
            }
        }else{
            return response($hiking,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Hiking  $hiking
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $hiking = Hiking::findOrFail($id);
        if($hiking){ 
            if($hiking->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($hiking,404);
        }
    }
}
