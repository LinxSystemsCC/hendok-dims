<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicingController extends Controller
{
    //
    public function viewAwaitingtoinvoice(){
        $toinvoice = DB::connection('sqlsrv')
            ->select("Exec spGetPickingTicketsWaitingToBeInvoiced" );
        return view('dims/listtoinvoice')
            ->with('readytoinvoice',$toinvoice);
    }
    public function assignweighbridgeticket(){
        $awaitingtobeassigned = DB::connection('sqlsrv')
            ->select("Exec spAssignTikets" );

        $alreadyassigned = DB::connection('sqlsrv')
            ->select("Exec spAlreadyAssigned" );
        return view('dims/ticketspage')
            ->with('awaitingtobeassgined',$awaitingtobeassigned)
            ->with('assigned',$alreadyassigned);
    }
    public function weightticketslist($ref){

        $tickets = DB::connection('weights')
            ->select("SELECT  TICKET_NUMBER,TICKET_DATE,TICKET_TIME,'' wigh
                                    FROM  [WB_Ticket_Trans]
                             where SECOND_WEIGH_OPERATOR = '' order by TICKET_NUMBER" );
        return view('dims/savetickets')->with('ref',$ref)
            ->with('listtickets',$tickets);
    }
    public function saveweightticket(Request $request)
    {
        $referenceno = $request->get('referenceno');
        $nickname = $request->get('nickname');
        DB::connection('sqlsrv3')->table('tblPickingPlanHeader')
            ->where('strUnickReference', $referenceno)
            ->update(['strTicket' => $nickname]);
    }
    public function invoicepickings($reference){

        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        try {
        //Initialise
        $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
        $sdkHelper->SetLicense("DE12111039", "4626921");
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select('exec spGetOrderNumbersToInvoice ?',
                array($reference)
            );

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
        }catch (Error $err){
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }
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
            switch ($val->intOwnerId) {
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
            try {
                $x = $sdkHelper->GetSalesOrder($val->strOrderNo);
                $reference = $x->Process();
                echo "*************".$reference;
                $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                    ->select('exec spPrintProcessedInvoiceNo ?,?,?,?,?',
                        array($userid,$val->intAutoindexID,$val->strOrderNo,$val->intOwnerId,$userName)
                    );
            }catch (Error $err){
                    echo "<h3 style='color: darkred'>__________Errors_________</h3>";
                    echo $err;
            }
            //spPrintProcessedInvoiceNo

        }
        echo "*****************************Done Invoicing******************";
        echo "*****************************Printing Started Please Check Your Printer******************";
        echo "*****************************Printer Name Is: ".$PrinterPathInvoice;

    }
    public function whtransfers($reference){
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select('exec spAutoIndexForTrasfers ?',
                array($reference)
            );

        foreach ($returnToInvoices as $innverVal){
$this->processTransfer($reference,$innverVal->AutoIndex,$innverVal->OrderNum);
        }

        /*      $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
              try {
                  //Initialise
                  $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
                  $sdkHelper->SetLicense("DE12111039", "4626921");
                  $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok_Dims;server=HKQL2019,1433');

      /*
                  $x = $sdkHelper->GetSalesOrder($val->SalesOrderNo);
                  $lineno = $innverVal->LineNos - 1;
                  $x->Detail[$lineno]->ToProcess =floatval($innverVal->Toinvoice);
                  echo "Line Index".$lineno."Line No ".$innverVal->LineNos. "**************** To Invoice".$innverVal->Toinvoice;
                      $reference = $x->Save();


            echo "*****************************Processing Invoices******************";
         //   $this->processInvoce();
            echo "*****************************Done Processing Invoices******************";
            echo "*****************************Starting to Invoice Now******************";
        }catch (Error $err){
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }*/
    }
    public function processTransfer($reference, $indexId,$ordernumebr){

        //spGetPlannedItemsToTransfers
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select('exec spGetPlannedItemsToTransfers ?',
                array($indexId)
            );

        dd($returnToInvoices);
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://linxsystems.flowgear.net/Sage',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'<WarehouseTransfers xmlns="http://flowgear.net/Schemas/PastelEvolution/WarehouseTransfers.xsd">

  <Configuration/>
</WarehouseTransfers>',
            CURLOPT_HTTPHEADER => array(
                'Authorization: Key=d3yYYD57AfWYrsbHRvU6GQC7f-EhjQiw6ZIkKVWjJaeTJlLun4mpzMLnvUo_m4WqOUbsyiz0AOH29WyGkLJlbQ',
                'Content-Type: application/xml'
            ),
        ));

        $response = curl_exec($curl);

        curl_close($curl);
        echo $response;
    }

}
