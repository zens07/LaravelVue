<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Club;
use App\Match;

class FootballController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Display All Data and only atribute name as clubname and point 
        $data = Club::select('name', 'point')->get();
        return [
            'title' => "All Club League",
            'data' => $data
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // checking request by id or clubname
        if ($request->clubhome_id && $request->clubaway_id) {
            $clubhome_id = $request->clubhome_id;
            $clubaway_id = $request->clubaway_id;
        }elseif ($request->clubhomename && $request->clubwayname){
            $clubname = [
                $request->clubhomename,
                $request->clubwayname
            ];
            $searchIdClub = Club::select('id')->whereIn('name', $clubname)->get();
            
            $clubhome_id = $searchIdClub[0]->id;
            $clubaway_id = $searchIdClub[1]->id;
        }else {
            return [
                'message' => "No Parameter this API" 
            ];
        }

        //send parameter to another function by name recordgame
        $recordgame = $this->recordgame([
            'clubhome_id' => $clubname_id,
            'clubaway_id' => $clubaway_id,
            'score' => $request->score
        ]);
        
        //return response recordgame as variable name $recordgame
        return $recordgame;
    }

    private function recordgame($param) {
        $data = [];
        //create to database to table matches
        $createMatch = Match::create([
            'clubhome_id' => $param['clubhome_id'],
            'clubaway_id' => $param['clubaway_id'],
            'score' => $param['score']
        ]);

        //explode for get score by team
        $scores = explode(":", $createMatch->score);
        $club_id = [
            $createMatch->clubhome_id,
            $createMatch->clubaway_id
        ];

        //inside array value after get score and id from response
        foreach ($scores as $index => $score) {
            $data[] = [
                'club_id' => $club_id[$index],
                'score' => intval($score)        
            ];
        }

        // check data score and get point 
        if($data[0]['score'] > $data[1]['score']){
            $point = [3,0];
        }else if ($data[0]['score'] == $data[1]['score']) {
            $point = [1,1];
        }else if ($data[0]['score'] < $data[1]['score']) {
            $point = [0,3];
        }
        
        //find team by params for check old score in table
        $searchClub = Club::whereIn('id', [
            $param['clubhome_id'],
            $param['clubaway_id']
        ])->get();
        
        if ($searchClub) {
            foreach ($searchClub as $index => $row) {
                $update[] = Club::where('id', $row->id)->update([
                   'point' => $row->point + $point[$index],
                ]);
            }
            if($update[0] == true && $update[1] == true){
                $response = Club::whereIn('id', [
                    $param['clubhome_id'],
                    $param['clubaway_id']
                ])->get();
            }else {
                $response = [
                    "message" => "data not success for updating",
                    "status" => 401
                ];
            }
            return $response;
        }
        return [
            "message" => "Not Found Score in Table please check your inputted",
            "status" => 404
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function rank(Request $request)
    {
        $data = [];

        //conditional data all data sorting by point and get limit one from query param clubname
        $clubname = $request->input('clubname');
        $allData = Club::orderBy('point', 'DESC')->get();
        $search = Club::where('name', 'like', '%'.$clubname.'%')->first();
        
        //condition foreach in php for get index array as standing/rank 
        foreach ($allData as $index => $row) {
            if ($row->id === $search->id) {
                $response = [
                    'club_name' => $row->id,
                    'standing' => $index + 1
                ];
            }else {
                $response = [
                    'message' => "Not Found ClubName in database",
                    'status' => 404
                ];
            }
        }
        return $response;
    }
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
