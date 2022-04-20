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
        //   dd($sdkHelper->);
        //   var_dump("Loaded ComHelper, version {$sdkHelper->AssemblyVersion}");
        //Initialise
        $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
        //var_dump("Connected to common");
        $sdkHelper->SetLicense("DE12111039", "4626921");
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select('exec spGetOrderNumbersToInvoice ?',
                array($reference)
            );
        $salesOrder = new \COM("Pastel.Evolution.SalesOrder");
        $orderno = "";
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
            echo "**************** Sales Order Number".$val->SalesOrderNo;
            $reference = $x->Save();
            DB::connection('sqlsrv3')->table('tblProcessSalesOrders')->insert(
                ['strOrderNo' => $val->SalesOrderNo, 'intAutoindexID' =>$val->intOrderId,'intOwnerId'=> $val->intOwnerId]
            );
        }


    }
}
