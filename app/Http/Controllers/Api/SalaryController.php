<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalaryController extends Controller
{
    public function UploadData(Request $req){

        $stage = array();
        $data=$req->all();
        foreach($data["excelData"] as $value)
        {
            array_push($stage, array(
                'nik'=>$value['nik'],
                'nama'=>$value['nama'],

            ));
            
        };

        return response()->json([
            'status' => true,
            'data' => $stage
        ]);



    }
}
