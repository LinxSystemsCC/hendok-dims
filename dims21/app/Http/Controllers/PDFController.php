<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
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

    public function printRoofingLabel($id)
    {
        $job = DB::connection('sqlsrv2')->select('exec spGetRoofingLabelToPrint ?', array($id));
        // dd($job);

        $intJobID = $job[0]->intJobId;
        $qrCode = QrCode::size(25)->generate($intJobID);
        $data = ['qrCode'=>$qrCode,'job'=>$job ];

        $pdf = PDF::loadView('warehouse/labels/roofing', $data);
        $pdf->setPaper([0, 0, 90, 60]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('roofing.pdf');
        // return $pdf->download('roofing.pdf');
    }

    public function printNailsInnerLabel($id)
    {
        $job = DB::connection('sqlsrv2')->select('exec spGetNailsInnerLabelToPrint ?', array($id));
        // dd($job);
        $intJobID = $job[0]->intJobId;

        $qrCode = QrCode::size(25)->generate($intJobID);
        $barcodeValue = $job[0]->strBarcode;
        
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($barcodeValue, $generator::TYPE_EAN_13);

        $data = ['qrCode'=>$qrCode,'job'=>$job,'barcode'=>$barcode ];

        $pdf = PDF::loadView('warehouse/labels/nailsInner', $data);
        $pdf->setPaper([0, 0, 90, 60]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('nailsInner.pdf');
        // return $pdf->download('nailsInner.pdf');
    }

    public function printNailsOuterLabel($id)
    {
        $job = DB::connection('sqlsrv2')->select('exec spGetNailsOuterLabelToPrint ?', array($id));
        // dd($job);
        $intJobID = $job[0]->intJobId;

        $qrCode = QrCode::size(25)->generate($intJobID);
        $barcodeValue = $job[0]->strBarcode;
        
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($barcodeValue, $generator::TYPE_EAN_13);

        $data = ['qrCode'=>$qrCode,'job'=>$job,'barcode'=>$barcode ];

        $pdf = PDF::loadView('warehouse/labels/nailsOuter', $data);
        $pdf->setPaper([0, 0, 150, 100]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('nailsOuter.pdf');
        // return $pdf->download('nailsOuter.pdf');
    }

    public function displayPDFLabel($id){
        $intJobId = 123;
        $qrCode = QrCode::size(30)->generate($intJobId);
        $data = ['intJobId'=>$intJobId,'qrCode'=>$qrCode];

        return view('warehouse/labels/galv')->with('qrCode', $qrCode);
    }
}
