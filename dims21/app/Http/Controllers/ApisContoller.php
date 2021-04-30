<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ApisContoller extends Controller
{
    public function store(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $data2 = $data['data'];
        $string = array();
        foreach($data2 as $value){
             $string[] = "'".$value['ID']."'";
        }
        $jsonString = implode(",",$string);
       echo response()->json($jsonString);

    }
}
