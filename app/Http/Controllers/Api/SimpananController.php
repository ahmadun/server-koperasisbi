<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SendDataMail;
use Barryvdh\DomPDF\PDF;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;



class SimpananController extends Controller
{
    public function index(Request $req)
    {
        $nik=$req->nik;
        $simpan = $this->DataSimpanan($nik);
        $total = $this->TotalSimpanan($nik);

        return response()->json([
            'status' => true,
            'data' => $simpan,
            'total' => $total
        ]);
    }


    public function DataSimpanan($nik)
    {
        return DB::table('Kopkarsbi.dbo.Simpokrel')->where('nik', $nik)->get();
    }

    public function TotalSimpanan($nik)
    {
        return DB::table('Kopkarsbi.dbo.Simpokrel')
            ->where('nik', $nik)
            ->get(array(
                DB::raw('SUM(simpanan_wajib) AS wajib'),
                DB::raw('SUM(simpanan_pokok) AS pokok'),
                DB::raw('SUM(simpanan_sukarela) AS sukarela'),
                DB::raw('SUM(simpanan_wajib+simpanan_pokok+simpanan_sukarela) AS totals'),
            ));
    }

    public function SendMailpinjaman(Request $req)
    {

        $nik=$req->nik;

        
        $simpanan = $this->DataSimpanan($nik);
        $total = $this->TotalSimpanan($nik)->first();
        $nika['niks']=$simpanan->pluck('NIK')->first();


        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.pdf_template', $nika,compact('simpanan','total'));

        Mail::send('mail.mail_template', $nika, function ($message) use ($nika, $pdf) {
            $message->to('ahmadun.jambi@gmail.com')
                ->subject('Simpanan Koperasi')
                ->attachData($pdf->output(), "test.pdf");
        });
    }
}
