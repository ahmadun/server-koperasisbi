<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BelanjaKontanController extends Controller
{
    public function SaveTransaksi(Request $req)
    {
     

        try 
        {
            DB::insert('insert Kopkarsbi.dbo.BLJ_Kontan  values (?,?,?,?,?,?)', [$req->nik,Carbon::parse($req->tgl)->format('Y-m-d'),'NAK',$req->jumlah,$req->nik,'2022-06-06']);
                return response()->json([
                    'status' => true,
                ]);
                   
        }
        catch (\Illuminate\Database\QueryException  $e) 
        {
            $error = $e->errorInfo[1];
            return response()->json([
                'status' => false,
                'data' => $error
            ]);

        }       
    }
}
