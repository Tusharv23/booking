<?php

namespace App\Http\Controllers;

use App\Property as p;//model to interact with database.
use Illuminate\Http\Request;
use phpDocumentor\Reflection\DocBlock\Tags\Property;
use Illuminate\Support\Facades\DB;

class PropertyController extends Controller
{
    //This function will return all the properties either with search queries or without it.
    public function index(Request $request)
    {
        $property = DB::table('properties');//This query will fetch all the properties.
        if(!isset($request['query'])){
            return $property->get();//If no search parameters this query will return all properties
        }
        $property = isset($request['query']['name'])?$property->where('name','like','%'.$request['query']['name'].'%'):$property;//search for given name
        $property = isset($request['query']['city'])?$property->where('city','=',$request['query']['city']):$property;//search for given property
        $property = isset($request['query']['price'])?$property->where('price','>',$request['query']['price']):$property;//search for price greater than specified.
        return $property->get();//return just searched property
    }

    public function store(Request $request)
    {
        //This will store property to database
        $inputs = $request->all();//will get post params
        $property = p::create(['name'=>$inputs['name'],'city'=>$inputs['city'], 'description'=>$inputs['description'], 'total_rooms'=>$inputs['total_rooms'], 'price'=>$inputs['price'], 'images'=>$inputs['images']]);//query to store property.
        return $property;
    }

    public function show($id)
    {
        //This will return property just for the specified Id.
        $property = p::where('id',$id)->first();
        return $property;
    }
}
