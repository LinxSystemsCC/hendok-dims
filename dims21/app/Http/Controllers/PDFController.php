<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    // Print a pdf of truck control sheet
    public function printGalvLabel($ticketno)
    {
        $job = DB::connection('sqlsrv2')->select('exec spGetGalvLabelToPrint ?', array($ticketno));
        // dd($job);
        $intJobID = $job[0]->intJobId;

        $qrCode = QrCode::size(25)->generate($intJobID);
        $data = ['qrCode'=>$qrCode,'job'=>$job];

        $pdf = PDF::loadView('warehouse/labels/galv', $data);
        $pdf->setPaper([0, 0, 90, 60]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('galv.pdf');
        // return $pdf->download('galv.pdf');
    }

    public function displayPDFLabel($id){
        $intJobId = 123;
        $qrCode = QrCode::size(30)->generate($intJobId);
        $data = ['intJobId'=>$intJobId,'qrCode'=>$qrCode];

        return view('warehouse/labels/galv')->with('qrCode', $qrCode);
    }
}
