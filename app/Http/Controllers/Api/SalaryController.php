<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SalaryController extends Controller
{

    public function index(Request $req)
    {


        return response()->json([
            'status' => true,
            'data' => $this->DataSalary($req->nik)
        ]);
    }
    public function DataSalary($nik)
    {

        if ($nik == "") {
            return DB::table('salarys')
                ->join('users', 'users.nik', '=', 'salarys.nik')
                ->select('salarys.nik', 'users.name', 'salarys.basic_salary', 'salarys.last_salary', 'salarys.last_month_pay')
                ->get();
        } else {
            return $this->DataSalaryByone($nik);
        }
    }

    public function DataSalaryByone($nik)
    {

        return DB::table('salarys')
            ->join('users', 'users.nik', '=', 'salarys.nik')
            ->select('salarys.nik', 'users.name', 'salarys.basic_salary', 'salarys.last_salary', 'salarys.last_month_pay')
            ->where('salarys.nik', $nik)
            ->get();
    }

    public function ProsesData(Request $req)
    {
        $now = Carbon::now('utc')->toDateTimeString();
        $data = $req->all();
        if ($req->mode == 1) {
            try {
                DB::table('salarys')
                    ->where('nik', $data['nik'])
                    ->update([
                        'basic_salary' => $data['basic_salary'],
                        'last_salary' => $data['last_salary'],
                        'last_month_pay' => $data['last_month_pay'],
                        'updated_by' => $data['created_by']
                    ]);

                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            } catch (\Illuminate\Database\QueryException  $e) {
                $error = $e->errorInfo[1];
                return response()->json([
                    'status' => false,
                    'data' => $error
                ]);
            }
        } else {
            $now = Carbon::now('utc')->toDateTimeString();
            $data = $req->all();
            try {
                DB::table('salarys')->insert([
                    'nik' => $data['nik'],
                    'basic_salary' => $data['basic_salary'],
                    'last_salary' => $data['last_salary'],
                    'last_month_pay' => $data['last_month_pay'],
                    'created_by' => $data['created_by'],
                    'created_at' => $now
                ]);

                return response()->json([
                    'status' => true,
                    'data' => $data
                ]);
            } catch (\Illuminate\Database\QueryException  $e) {
                $error = $e->errorInfo[1];
                return response()->json([
                    'status' => false,
                    'data' => $error
                ]);
            }
        }
    }

    public function UploadData(Request $req)
    {
        $stage = array();
        $data = $req->all();
        $now = Carbon::now('utc')->toDateTimeString();
        foreach ($data["excelData"] as $value) {
            array_push($stage, array(
                'nik' => $value['nik'],
                'basic_salary' => $value['basic_salary'],
                'last_salary' => $value['last_salary'],
                'last_month_pay' => $value['last_month_pay'],
                'created_by' => '220021',
                'created_at' => $now
            ));
        };

        DB::table('salarys')->insert($stage);


        return response()->json([
            'status' => true,
            'data' => $this->DataSalary(null)
        ]);
    }
}
