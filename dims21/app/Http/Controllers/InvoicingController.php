<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicingController extends Controller
{
    //
    public function invoicepickings($reference){

        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");

        //Initialise
        $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
        $sdkHelper->SetLicense("DE12111039", "4626921");
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select('exec spGetOrderNumbersToInvoice ?',
                array($reference)
            );
        var_dump($returnToInvoices);
        foreach ($returnToInvoices as $val) {
            switch($val->intOwnerID){
                case 1:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok_Dims;server=HK-SQL2019,1433');
                    break;
                case 2:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Henroof_Dims;server=HK-SQL2019,1433');
                    break;
                case 3:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Ukhozi_Dims;server=HK-SQL2019,1433');
                    break;
            }

            $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                ->select('exec spGetOrderNumbersLinesToProcess ?,?,?',
                    array($reference,$val->SalesOrderNo,$val->intOwnerID)
                );

            $x = $sdkHelper->GetSalesOrder($val->SalesOrderNo);
            foreach ($returnGetsalesorderNoLines as $innverVal){
                $lineno = $innverVal->LineNos - 1;
                $x->Detail[$lineno]->ToProcess =floatval($innverVal->Toinvoice);
                echo "Line Index".$lineno."Line No ".$innverVal->LineNos. "**************** To Invoice".$innverVal->Toinvoice;
            }
            echo "Saved Order Number----------".$val->SalesOrderNo."<br>";
            $reference = $x->Save();



            $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                ->select('exec spProcessSavedSalesOrderLinesByOrderNumber ?,?,?,?,?',
                    array($userid,$val->intOrderId,$val->SalesOrderNo,$val->intOwnerID,$userName)
                );
        }
        echo "*****************************Processing Invoices******************";
        $this->processInvoce();
        echo "*****************************Done Processing Invoices******************";
        echo "*****************************Starting to Invoice Now******************";
    }
    public function processInvoce(){
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $PrinterPathInvoice = Auth::user()->PrinterPathInvoice;
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");

        //Initialise, We to find the resusable way
        $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
        //var_dump("Connected to common");
        $sdkHelper->SetLicense("DE12111039", "4626921");
        $returnSalesOrders = DB::connection('sqlsrv3')
            ->select('exec spGetOrderNumbersToFinalize ');
        foreach ($returnSalesOrders as $val) {
            switch ($val->intOwnerID) {
                case 1:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok_Dims;server=HK-SQL2019,1433');
                    break;
                case 2:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Henroof_Dims;server=HK-SQL2019,1433');
                    break;
                case 3:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Ukhozi_Dims;server=HK-SQL2019,1433');
                    break;
            }
            $x = $sdkHelper->GetSalesOrder($val->SalesOrderNo);
            $reference = $x->Process();
            echo "*************".$reference;
            $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                ->select('exec spPrintProcessedInvoiceNo ?,?,?,?,?',
                    array($userid,$val->intAutoindexID,$val->strOrderNo,$val->intOwnerId,$userName)
                );
            //spPrintProcessedInvoiceNo

        }
        echo "*****************************Done Invoicing******************";
        echo "*****************************Printing Started Please Check Your Printer******************";
        echo "*****************************Printer Name Is: ".$PrinterPathInvoice;
    }
}
