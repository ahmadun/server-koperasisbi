<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class PinjamanController extends Controller
{


    public function index(Request $request)
    {
        $nik=$request->nik; 
        $data=DB::select('exec spListPinjaman @nik='.$nik.'');

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function detail_pinjaman(Request $request)
    {
        $nik=$request->nik; 
        $code=$request->code;
        if($code=='REG')
        {
            $pinjaman = $this->DataPinjamanReg($nik);
            $data=$pinjaman['data'];
            $total=$pinjaman['total'];

        }else{
            $pinjaman = $this->DataPinjamanKons($nik);
            $data=$pinjaman['data'];
            $total=$pinjaman['total'];
        }
       
        return response()->json([
            'status' => true,
            'data' => $data,
            'total'=>$total
        ]);
    }

    public function DataPinjamanReg($nik){
        $data=DB::table('Kopkarsbi.dbo.Cicilan_koperasi')
        ->where('nik',$nik)
            ->get(['Bulan','Cicilan_pokok','Cicilan_bunga','Cicilan_total','remarks']);

        $total=DB::table('Kopkarsbi.dbo.Cicilan_koperasi')
        ->where('nik',$nik)
            ->get( array(
                DB::raw('count(Bulan) as Bulan'),
                DB::raw('sum(Cicilan_pokok) as Cicilan_pokok'),
                DB::raw('sum(Cicilan_bunga) as Cicilan_bunga'),
                DB::raw('sum(Cicilan_total) as Cicilan_total'),
            ));
            return [
                'data' => $data,
                'total'=>$total
            ];
    }



    public function DataPinjamanKons($nik){
        $data=DB::table('Kopkarsbi.dbo.Kredit_Konsumtif')
        ->where('nik',$nik)
            ->get(['Bulan','Cicilan','Bunga','kredit_Kendaraan','Kredit_PRT','Kode']);

        $total=DB::table('Kopkarsbi.dbo.Kredit_Konsumtif')
        ->where('nik',$nik)
                ->get( array(
                    DB::raw('count(Bulan) as Bulan'),
                    DB::raw('sum(Cicilan) as Cicilan_pokok'),
                    DB::raw('sum(Bunga) as Cicilan_bunga'),
                    DB::raw('sum(kredit_Kendaraan) as Cicilan_total'),
                    DB::raw('sum(Kredit_PRT) as Kredit_PRT'),
                ));     
            return [
                'data' => $data,
                'total'=>$total
            ];
    }

    
    public function GetName($nik)
    {
        return DB::table('Kopkarsbi.dbo.Koperasi')->where('nik',$nik)->pluck('Nama')->first();
    }

    public function SendmailpinjamanReg(Request $req)
    {

        $nik=$req->nik;    
        $pinjaman = $this->DataPinjamanReg($nik);
        $nama=$this->GetName($nik); 
        $listpinjaman=$pinjaman['data'];
        $total=$pinjaman['total'];

        $data["nama"]=$nama;
        $data["jenis_pinjam"]="Reguler";

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.pdf_pinjaman_reg',["nama"=>$nama],compact(['listpinjaman','total']));

 

        Mail::send('mail.mail_pinjaman',$data, function ($message) use ($pdf) {
                $message->to('ahmadun.jambi@gmail.com')
                ->subject('Pinjaman Koperasi')
                ->attachData($pdf->output(), "PINJAMAN.pdf");
        });
    }

    public function SendmailpinjamanKons(Request $req)
    {

        $nik=$req->nik;    
        $nama=$this->GetName($nik); 
        $pinjaman = $this->DataPinjamanKons($nik);

        $listpinjaman=$pinjaman['data'];
        $total=$pinjaman['total'];
        $data["nama"]=$nama;
        $data["jenis_pinjam"]="Konsumptif";

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('pdf.pdf_pinjaman_kons',["nama"=>$nama],compact(['listpinjaman','total']));

 

        Mail::send('mail.mail_pinjaman',$data, function ($message) use ($pdf) {
                $message->to('ahmadun.jambi@gmail.com')
                ->subject('Pinjaman Koperasi')
                ->attachData($pdf->output(), "PINJAMAN.pdf");
        });
    }
}
