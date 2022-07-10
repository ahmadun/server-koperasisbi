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
        $kasbon = array();
        $now = Carbon::now('utc')->toDateTimeString();
        $total=0;
        foreach($data["tableData"] as $value)
        {
            $total+=$value['price'];
            $date = Carbon::parse($value['date']);
            array_push($stage, array(
                'nik'=>$value['nik'],
                'date_bon'=>$date->format('Y-m-d'),
                'form'=>$value['form'],
                'nota'=>$value['nota'],
                'item'=>$value['item'],
                'qty'=>$value['qty'],
                'price'=> $value['price'],
                'created_by'=>$value['user'],
                'created_at'=>$now
            ));
            
        };

        $kasbon=array(
            'nik'=>$stage[0]['nik'],
            'tgl_Bon'=>$date->format('Y-m-d'),
            'no_nota'=>$stage[0]['nota'],
            'jumlah_bon'=>$total,
            'User_ID'=> $stage[0]["created_by"],
            'Entry_dt'=> $now,
            'Modify_dt'=>$now
        ); 
       
        DB::beginTransaction();
        try 
        {
            $one=DB::table('kasbons')->insert($stage);
            $two=DB::table('Kopkarsbi.dbo.All_Kasbon')->insert($kasbon);

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
