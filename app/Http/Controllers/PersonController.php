<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Person;
use Carbon\Carbon;
class PersonController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $persons = Person::all();
        foreach ($persons as $person) {
            $data[] =  [
                "title" => "index show all",
                "first_name" => $person->first_name,
                "last_name" => $person->last_name,
                "created_at" => Carbon::parse($person->created_at)->format('Y-m-d H:i:s'),
            ];
        }
        return $data; 
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
        // return $request;
        $data['title'] = "create database";
        $data['data'] = Person::create([
            "first_name" => $request->first_name,
            "last_name" => $request->last_name
        ]);
        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['title'] = "Show Tabel Person";
        $data['data'] = Person::find($id);
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data['title'] = "Update Tabel Person";
        $data['data'] = Person::where('id', $id)->update($request->all());

        return $data;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data['title'] = "Deleted data";
        $data['data'] = Person::where('id', $id)->delete();
        return $data;
    }
}
