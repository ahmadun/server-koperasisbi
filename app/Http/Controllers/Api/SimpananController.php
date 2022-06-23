<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function index()
    {
        $simpanan=DB::table('Kopkarsbi.dbo.Simpokrel ')->where('nik',219492)->get();

        return response()->json([
            'status' => true,
            'data' => $simpanan
        ]);
    }
}
