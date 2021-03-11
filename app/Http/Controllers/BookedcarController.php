<?php

namespace App\Http\Controllers;

use App\Models\Bookedcar;
use Illuminate\Http\Request;

class BookedcarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Bookedcar::all(),200);
       
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
        $bookedcar=Bookedcar::create($input);
        $bookedcar= $bookedcar->save();
        if($bookedcar){
            return response($bookedcar->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bookedcar  $bookedcar
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $bookedcar= Bookedcar::where('id',$id)->first();
        if($bookedcar){
            return response($bookedcar,200);
        }else{
            return response($bookedcar,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bookedcar  $bookedcar
     * @return \Illuminate\Http\Response
     */
    public function edit(Bookedcar $bookedcar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bookedcar  $bookedcar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $bookedcar = Bookedcar::find($id);
        if($bookedcar){
            $input = $request->all();
            $result= $bookedcar->fill($input)->save(); 
            if($result){
                return response($bookedcar,201);
            }else{
                return response($bookedcar,500);
            }
        }else{
            return response($bookedcar,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bookedcar  $bookedcar
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookedcar = Bookedcar::findOrFail($id);
        if($bookedcar){ 
            if($bookedcar->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($bookedcar,404);
        }
    }
}
