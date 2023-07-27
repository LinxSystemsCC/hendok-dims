<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Picqer\Barcode\BarcodeGeneratorPNG;
use Illuminate\Support\Facades\DB;

class PDFController extends Controller
{
    // Actual label PDF's
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

    public function printBarbedWireLabel($id)
    {
        $job = DB::connection('sqlsrv2')->select('exec spGetBarbedWireLabelToPrint ?', array($id));
        // dd($job);
        $intJobID = $job[0]->intJobId;

        $qrCode = QrCode::size(25)->generate($intJobID);
        $barcodeValue = $job[0]->strBarcode;
        
        $generator = new BarcodeGeneratorPNG();
        $barcode = $generator->getBarcode($barcodeValue, $generator::TYPE_EAN_13);

        $data = ['qrCode'=>$qrCode,'job'=>$job,'barcode'=>$barcode ];

        $pdf = PDF::loadView('warehouse/labels/barbedWire', $data);
        $pdf->setPaper([0, 0, 120, 78]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('barbedWire.pdf');
        // return $pdf->download('barbedWire.pdf');
    }

    //Preview Labels
    public function previewGalvLabel()
    {
        $job = [
            (object)[
                "intJobId" => "0|0",
                "Customer" => "GALV CUSTOMER",
                "ProductName" => "0.00 - FG",
                "TreatedMPA" => "123",
                "SECode" => "GW123456FG",
                "Weight" => 000.00,
                "Operator" => "GALV OPERATOR",
                "DateTime" => "2023-01-01 12:00:00",
                "TicketNo" => "0000000",
                "strStatus" => "  "
            ],
        ];
    
        $intJobID = $job[0]->intJobId; // Access the property using object notation
    
        $qrCode = QrCode::size(25)->generate($intJobID);
        $data = ['qrCode' => $qrCode, 'job' => $job];
    
        $pdf = PDF::loadView('warehouse/labels/galv', $data);
        $pdf->setPaper([0, 0, 90, 60]); // 0, 0, W, H
        $pdf->render();
        return $pdf->stream('galv.pdf');
        // return $pdf->download('galv.pdf');
    }

    public function printLabelPage($department)
    {
        return view('warehouse/labels/printLabel')->with('department', $department);
    }

    public function printLabelByDepartment(Request $request)
    {
        $department = $request->get('department');
        $productCategory = $request->get('productCategory');
        $productName = $request->get('productName');
        $barcode = $request->get('barcode');

        $result = DB::connection('sqlsrv2')->select('exec spPrintLabelByDepartment ?', array($department, $productCategory, $productName, $barcode));
        return response()->json($result);
    }
}
