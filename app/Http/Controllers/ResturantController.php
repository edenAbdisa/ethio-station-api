<?php

namespace App\Http\Controllers;

use App\Models\Resturant;
use Illuminate\Http\Request;

class ResturantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Resturant::all(),200);
       
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
        $resturant=Resturant::create($input);
        $resturant= $resturant->save();
        if($resturant){
            return response($resturant->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $resturant= Resturant::where('id',$id)->first();
        if($resturant){
            return response($resturant,200);
        }else{
            return response($resturant,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function edit(Resturant $resturant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resturant = Resturant::find($id);
        if($resturant){
            $input = $request->all();
            $result= $resturant->fill($input)->save(); 
            if($result){
                return response($resturant,201);
            }else{
                return response($resturant,500);
            }
        }else{
            return response($resturant,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resturant  $resturant
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resturant = Resturant::findOrFail($id);
        if($resturant){ 
            if($resturant->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($resturant,404);
        }
    }
}
