<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnggotaContoller extends Controller
{
    public static function GetName($nik)
    {
        return DB::table('Kopkarsbi.dbo.Koperasi')
                    ->where('nik',$nik)->pluck('Nama')->first();
    }

    public function CheckAnggota(Request $req)
    {
        $nik=$req->nik;
        $data=$this->GetName($nik);
        $user=DB::table('users')->where('nik',$nik)->get(['role','no_hp','email','email']);

        return response()->json([
            'status' => true,
            'data' => $data,
            'user' => $user
        ]);
    }
}
