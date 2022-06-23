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
                ->get(['Bulan','Cicilan_pokok','Cicilan_bunga','Cicilan_total','Remarks']);
        }else{
            $data=DB::table('Kopkarsbi.dbo.Kredit_Konsumtif')
            ->where('nik',$request->nik)
            ->where('kode',$request->code)
                ->get(['Bulan','Cicilan as Cicilan_pokok','Bunga as Cicilan_bunga','kredit_Kendaraan as Cicilan_total','Remarks']);
        }
       

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
}
