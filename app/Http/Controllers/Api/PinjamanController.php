<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PinjamanController extends Controller
{


    public function index()
    {
        $data=DB::select('exec spListPinjaman @nik=197088');

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detail_pinjaman(Request $request)
    {
        $code=$request->code;
        if($code=='REG')
        {
            $data=DB::table('Kopkarsbi.dbo.Cicilan_koperasi')
            ->where('nik',$request->nik)
                ->get(['Bulan','Cicilan_pokok','Cicilan_bunga','Cicilan_total','remarks']);

            $total=DB::table('Kopkarsbi.dbo.Cicilan_koperasi')
            ->where('nik',$request->nik)
                ->get( array(
                    DB::raw('count(Bulan) as Bulan'),
                    DB::raw('sum(Cicilan_pokok) as Cicilan_pokok'),
                    DB::raw('sum(Cicilan_bunga) as Cicilan_bunga'),
                    DB::raw('sum(Cicilan_total) as Cicilan_total'),
                ));
        }else{
            $data=DB::table('Kopkarsbi.dbo.Kredit_Konsumtif')
            ->where('nik',$request->nik)
                ->get(['Bulan','Cicilan','Bunga','kredit_Kendaraan','Kredit_PRT','Kode']);

            $total=DB::table('Kopkarsbi.dbo.Kredit_Konsumtif')
            ->where('nik',$request->nik)
                    ->get( array(
                        DB::raw('count(Bulan) as Bulan'),
                        DB::raw('sum(Cicilan) as Cicilan_pokok'),
                        DB::raw('sum(Bunga) as Cicilan_bunga'),
                        DB::raw('sum(kredit_Kendaraan) as Cicilan_total'),
                        DB::raw('sum(Kredit_PRT) as Kredit_PRT'),
                    ));     
        }
       
        return response()->json([
            'status' => true,
            'data' => $data,
            'total'=>$total
        ]);
    }
}
