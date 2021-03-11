<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response(Rate::all(),200);
       
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
        $rate=Rate::create($input);
        $rate= $rate->save();
        if($rate){
            return response($rate->id,200);
        }else{
            return response('',500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show( $id)
    {
        $rate= Rate::where('id',$id)->first();
        if($rate){
            return response($rate,200);
        }else{
            return response($rate,404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rate = Rate::find($id);
        if($rate){
            $input = $request->all();
            $result= $rate->fill($input)->save(); 
            if($result){
                return response($rate,201);
            }else{
                return response($rate,500);
            }
        }else{
            return response($rate,404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $rate = Rate::findOrFail($id);
        if($rate){ 
            if($rate->delete()){
                return response(true,200);
            }else{
                return response(false,500);
            }
        }else{
            return response($rate,404);
        }
    }
}
