<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasbonController extends Controller
{
    public function index(Request $request)
    {
        $nik=$request->nik; 
        $data=DB::select('exec spKasbonCheck @nik='.$nik.'');

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function SaveTransaksi(Request $request)
    {
        $data=$request->all();
        $stage = array();
        $kasban = array();
        $now = Carbon::now('utc')->toDateTimeString();
        foreach($data["tableData"] as $value)
        {
            $date = Carbon::parse($value['date']);
            array_push($stage, array(
                'nik'=>$value['nik'],
                'date_bon'=>$date->format('Y-m-d'),
                'form'=>$value['form'],
                'item'=>$value['item'],
                'qty'=>$value['qty'],
                'price'=> $value['price'],
                'created_by'=>$value['user'],
                'created_at'=>$now
            ));
            
            if($value['form']==1){
                array_push($kasban, array(
                    'nik'=>$value['nik'],
                    'tgl_Bon'=>$date->format('Y-m-d'),
                    'no_nota'=>$value['item'],
                    'jumlah_bon'=>$value['price'],
                    'User_ID'=>$value['user'],
                    'Entry_dt'=> $now,
                    'Modify_dt'=>$now
                )); 
            }        
        };

        DB::beginTransaction();
        try 
        {
            $one=DB::table('kasbon')->insert($stage);
            $two=DB::table('Kopkarsbi.dbo.All_Kasbon')->insert($kasban);

            if($one || $two){
                DB::commit();
                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            }
            
        }
        catch (\Throwable $th) 
        {
            DB::rollback();
            return response()->json([
                'status' => false,
                'data' => $th->getMessage()
            ]);

        }       
    
    }
}
