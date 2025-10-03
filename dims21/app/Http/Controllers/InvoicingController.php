<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InvoicingController extends Controller
{
    //
    public function viewAwaitingtoinvoice()
    {
        $toinvoice = DB::connection('sqlsrv')
            ->select("Exec spGetPickingTicketsWaitingToBeInvoiced");
        return view('dims/listtoinvoice')
            ->with('readytoinvoice', $toinvoice);
    }
    public function assignweighbridgeticket()
    {
        $awaitingtobeassigned = DB::connection('sqlsrv')
            ->select("Exec spAssignTikets");

        $alreadyassigned = DB::connection('sqlsrv')
            ->select("Exec spAlreadyAssigned");
        return view('dims/ticketspage')
            ->with('awaitingtobeassgined', $awaitingtobeassigned)
            ->with('assigned', $alreadyassigned);
    }
    public function weightticketslist($ref)
    {

        $tickets = DB::connection('weights')
            ->select("SELECT  TICKET_NUMBER,TICKET_DATE,TICKET_TIME,'' wigh
                                    FROM  [WB_Ticket_Trans]
                             where SECOND_WEIGH_OPERATOR = '' order by TICKET_NUMBER");
        return view('dims/savetickets')->with('ref', $ref)
            ->with('listtickets', $tickets);
    }
    public function saveweightticket(Request $request)
    {
        $referenceno = $request->get('referenceno');
        $nickname = $request->get('nickname');
        DB::connection('sqlsrv3')->table('tblPickingPlanHeader')
            ->where('strUnickReference', $referenceno)
            ->update(['strTicket' => $nickname]);
    }

 

public function individualInvoicing(Request $request)
{
    $ownersId = $request->get('ownerid');
    $SoNumber = $request->get('SONumber');
    $invoiceid = $request->get('invoiceid');
    $ref = $request->get('ref');

    $userid = Auth::user()->UserID;
    $userName = Auth::user()->UserName;

    try {

        $invoiceMessage = $this->updateTheDocIds($invoiceid, $ownersId, $ref);
		 if ($invoiceMessage !== "Success") {
		 
		  return response()->json([
                    'status' => 'error',
                    'message' => 'Something wrong with order# '.$SoNumber.' : '.$invoiceid,
                ]);
		 } 
		
            $result = DB::connection('sqlsrv3')
                ->select("EXEC usp_CheckIfOrderIdExists ?", [$invoiceid]);

            $CheckOrderIDExist = $result && isset($result[0]->ExistsFlag) && $result[0]->ExistsFlag == 1;

            if ($CheckOrderIDExist) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order ID already exists. Cannot re-invoice again.'
                ]);
            }

        // 2. Update picking plan header flag
        DB::connection('sqlsrv3')->table('tblPickingPlanHeader')
            ->where('strUnickReference', $ref)
            ->update(['isReadyForInvoicing' => 1]);

        // 3. If it's an IBT
        if ($invoiceid < 0) {
            DB::connection('sqlsrv3')->statement("EXEC usp_C_IssueIBTandMove '$ref', $userid");

            return response()->json([
                'status' => 'success',
                'message' => 'IBT processed and halted.'
            ]);
        }

        // 4. Check credit limit
        $invnum = $this->returnInvoiceNumber($invoiceid, $ownersId);
        $hasLimits = $this->CheckIfCreditLimitFine($invoiceid, $ownersId);

        if ($hasLimits !== "Success") {
            return response()->json([
                'status' => 'error',
                'message' => $hasLimits
            ]);
        }
		
         $invoiceMessage = $this->updateTheDocIds($invoiceid, $ownersId, $ref);
		 if ($invoiceMessage !== "Success") {
		 
		  return response()->json([
                    'status' => 'error',
                    'message' => 'Something wrong with order# '.$SoNumber.' : '.$invoiceid,
                ]);
		 }
        
        // 5. Build order XML
        $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
            ->select(
                'exec spGetOrderNumbersLinesToProcess ?,?,?',
                [$ref, $SoNumber, $ownersId]
            );

            
            if (empty($returnGetsalesorderNoLines)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No data returned for the references/order/owner combination.'
                ]);


            }

        $orderHeadersLines = "<Order><Header>";
        $orderHeadersLines .= "<OrderNo>{$SoNumber}</OrderNo>";
        $orderHeadersLines .= "<OwnerId>{$ownersId}</OwnerId>";
        $orderHeadersLines .= "<UserId>{$userid}</UserId>";
        $orderHeadersLines .= "<UserName>{$userName}</UserName>";
        $orderHeadersLines .= "<UniqueID>{$invoiceid}_{$ref}</UniqueID>";
        $orderHeadersLines .= "<InvoiceDate>{$returnGetsalesorderNoLines[0]->InvoiceDate}</InvoiceDate>";
        $orderHeadersLines .= "<CustomerCode>{$returnGetsalesorderNoLines[0]->Account}</CustomerCode>";
        $orderHeadersLines .= "<PlanID>{$returnGetsalesorderNoLines[0]->intAutoPickingHeader}</PlanID>";
        $orderHeadersLines .= "<invoiceid>{$invoiceid}</invoiceid></Header><Details>";

        $v = new \App\Http\Controllers\SalesForm();
        $isCapeUser = $v->getThings($this->getusergroupid($userid), 'isCapeUser');

        foreach ($returnGetsalesorderNoLines as $line) {
            $orderHeadersLines .= "<Line>";
            $lineno = $line->LineNos - 1;

            $warehouse = ($isCapeUser == "1") ? "CPT" : "Mstr";
            $adjustQty = $line->qtyonorder;

            if (
                $line->soldByWeight == "SoldByWeight" &&
                floatval($line->remaining) < floatval($line->Toinvoice) &&
                floatval($line->remaining) != 0
            ) {
                $adjustQty += (floatval($line->Toinvoice) - floatval($line->remaining));
            }

            $orderHeadersLines .= "<LineNo>{$lineno}</LineNo>";
            $orderHeadersLines .= "<ItemCode>{$line->ItemCode}</ItemCode>";
            $orderHeadersLines .= "<OrderDetails>{$line->intorderdetailId}</OrderDetails>";
            $orderHeadersLines .= "<Warehouse>{$warehouse}</Warehouse>";
            $orderHeadersLines .= "<QtyAdjust>" . str_replace(".", ",", $adjustQty) . "</QtyAdjust>";
            $orderHeadersLines .= "<ToProcess>" . str_replace(".", ",", $line->Toinvoice) . "</ToProcess>";
            $orderHeadersLines .= "</Line>";
        }

        $orderHeadersLines .= "</Details></Order>";

        // 6. Insert into tblXmlOrders
        $xmlresponse = DB::connection('sqlsrv3')->select(
            'exec spInsertXmlOrder ?,?,?',
            [$orderHeadersLines, "{$invoiceid}_{$ref}", $invoiceid]
        );

        return response()->json($xmlresponse);
    } catch (\Throwable $err) {
        return response()->json([
            'status' => 'error',
            'message' => $err->getMessage()
        ]);
    }
}





    //Reprint Controller:    
    public function reprintInvoicing(Request $request)
{
    try {
        $ownersId = $request->get('ownerid');
        $SoNumber = $request->get('SONumber');
        $invoiceid = $request->get('invoiceid');
        $ref = $request->get('ref');

        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        DB::connection('sqlsrv3')->table('tblPickingPlanHeader')
            ->where('strUnickReference', $ref)
            ->update(['isReadyForInvoicing' => 1]);

        if ($invoiceid < 0) {
            DB::connection('sqlsrv3')->statement("EXEC usp_C_IssueIBTandMove '$ref', $userid");
            return response()->json(['status' => 'success', 'message' => 'IBT reprocessed and halted.']);
        }

        $invnum = $this->returnInvoiceNumber($invoiceid, $ownersId);
        $hasLimits = $this->CheckIfCreditLimitFine($invoiceid, $ownersId);

        if ($hasLimits !== "Success") {
            return response()->json([
                'status' => 'error',
                'message' => $hasLimits
            ]);
        }

        if (!is_string($invnum) || strlen(trim($invnum)) <= 4) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid invoice number.. Please contact admin'
            ]);
        }

        $result = DB::connection('sqlsrv3')
            ->select(
                'exec spRePrintProcessedInvoiceNo ?,?,?,?,?',
                [$userid, $invoiceid, $SoNumber, $ownersId, $userName]
            );

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Invoice successfully reprinted.'
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Reprint failed. Stored procedure returned no results.'
            ]);
        }
    } catch (\Throwable $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'Exception: ' . $e->getMessage()
        ]);
    }
}




    public function individualInvoicingAPITest($ownersId, $SoNumber, $invoiceid, $ref, $userid, $userName)
    {
        dump($ownersId, $SoNumber, $invoiceid, $ref, $userid, $userName);
    }
    //{ownersId}/{SoNumber}/{invoiceid}/{ref}/{userid}/{userName}
    public function individualInvoicingAPI($ownersId, $SoNumber, $invoiceid, $ref, $userid, $userName)
    {
        $refDescription = "";
        $mustStockAdjust = 0;
        DB::connection('sqlsrv3')->table('tblPickingPlanHeader')
            ->where('strUnickReference', $ref)
            ->update(['isReadyForInvoicing' => 1]);
 

        if ($invoiceid < 0) {
            $UserID = Auth::user()->UserID;
            DB::connection('sqlsrv3')->statement("EXEC usp_C_IssueIBTandMove '$ref', $UserID");
            return response()->json(['status' => 'success', 'message' => 'Process completed and execution halted.']);
        }

       
       
		/*$invoiceMessage = $this->updateTheDocIds($invoiceid, $ownersId, $ref);
		 if ($invoiceMessage !== "Success") {
		 
		  return response()->json([
                    'status' => 'error',
                    'message' => 'Something wrong with order# '.$SoNumber.' : '.$invoiceid,
                ]);
		 } */
		 $invnum = $this->returnInvoiceNumber($invoiceid, $ownersId); 
		 $hasLimits = $this->CheckIfCreditLimitFine($invoiceid, $ownersId);

        if ($hasLimits == "Success") {
            if (strlen(trim($invnum)) > 4) {
                //dd($userid."-".$invoiceid."-".$SoNumber."".$ownersId."-".$userName) ;
                $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                    ->select(
                        'exec spRePrintProcessedInvoiceNo ?,?,?,?,?',
                        array($userid, $invoiceid, $SoNumber, $ownersId, $userName)
                    );
                return response()->json($returnGetsalesorderNoLines);
            } else {


                try {
                    //Initialise

                    $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                        ->select(
                            'exec spGetOrderNumbersLinesToProcess ?,?,?',
                            array($ref, $SoNumber, $ownersId)
                        );

                        

                    $orderHeadersLines = "<Order><Header>";
                    $orderHeadersLines .= "<OrderNo>" . $SoNumber . "</OrderNo>";
                    $orderHeadersLines .= "<OwnerId>" . $ownersId . "</OwnerId>";
                    $orderHeadersLines .= "<UserId>" . $userid . "</UserId>";
                    $orderHeadersLines .= "<UserName>" . $userName . "</UserName>";
                    $orderHeadersLines .= "<UniqueID>" . $invoiceid . '_' . $ref . "</UniqueID>";
                    $orderHeadersLines .= "<InvoiceDate>" . $returnGetsalesorderNoLines[0]->InvoiceDate . "</InvoiceDate>";
                    $orderHeadersLines .= "<CustomerCode>" . $returnGetsalesorderNoLines[0]->Account . "</CustomerCode>";
                    $orderHeadersLines .= "<PlanID>" . $returnGetsalesorderNoLines[0]->intAutoPickingHeader . "</PlanID>";
                    $orderHeadersLines .= "<invoiceid>" . $invoiceid . "</invoiceid>
                </Header>
                <Details>";

                    $v = new \App\Http\Controllers\SalesForm();
                    $isCapeUser = $v->getThings($this->getusergroupid($userid), 'isCapeUser');


                    $orderlinexml = "<Lines>";


                    foreach ($returnGetsalesorderNoLines as $innverVal) {
                        $orderHeadersLines .= "<Line>";
                        $lineno = $innverVal->LineNos - 1;
                        $linenoApi = $innverVal->LineNos - 1;

                        $warehouse = "Mstr";
                        $orderHeadersLines .= "<LineNo>" . $linenoApi . "</LineNo>";
                        $orderHeadersLines .= "<ItemCode>" . $innverVal->ItemCode . "</ItemCode>";
                        $orderHeadersLines .= "<OrderDetails>" . $innverVal->intorderdetailId . "</OrderDetails>";
                        if ($isCapeUser == "1") {
                            $warehouse = "CPT";
                        }

                        $orderHeadersLines .= "<Warehouse>" . $warehouse . "</Warehouse>";
                        $adjustQty = $innverVal->qtyonorder;
                        if ($innverVal->soldByWeight == "SoldByWeight" && floatval($innverVal->remaining) < floatval($innverVal->Toinvoice) && floatval($innverVal->remaining) != 0) {
                            $QuantityAdj = $adjustQty + (floatval($innverVal->Toinvoice) - (floatval($innverVal->remaining)));
                            $adjustQty = $QuantityAdj;
                        }

                        $orderHeadersLines .= "<QtyAdjust>" . str_replace(".", ",", $adjustQty) . "</QtyAdjust>";
                        $orderHeadersLines .= "<ToProcess>" . str_replace(".", ",", $innverVal->Toinvoice) . "</ToProcess>";
                        $orderHeadersLines .= "</Line>";
                    }
                    $orderHeadersLines .= "</Details></Order>";

                    $xmlresponse = DB::connection('sqlsrv3')
                        ->select(
                            'exec spInsertXmlOrder ?,?,?',
                            array($orderHeadersLines, $invoiceid . '_' . $ref, $invoiceid)
                        );

                    return response()->json($xmlresponse);

                } catch (Error $err) {
                    echo "<h3 style='color: darkred'>__________Errors_________</h3>";
                    return $err;
                }
            }
        } else {
            return $hasLimits;
        }
    }
	public function updateDimsPickingplanIds($ref){
		 $returndata = DB::connection('sqlsrv3')
            ->select(
                'exec [sp_CheckInvoiceEligibilityAndUpdateOutOfSyncDataBatch] ?',
                array($ref)
            );
		return response()->json($returndata);
	}
    //NOT IBT
    public function testWarehouseT($ref, $SoNumber, $ownersId)
    {
        $itemstotransfers = DB::connection('sqlsrv3')
            ->select(
                'exec [spGetOrderNumbersLinesToProcessToTransfer] ?,?,?',
                array($ref, $SoNumber, $ownersId)
            );
        echo "Outside the loop";
        foreach ($itemstotransfers as $value) {
            echo "Inside the loop";
            $this->warehousetransfer($value->ItemCode, 'CPT', 'UKH', $value->Toinvoice, $value->ItemCode, $value->ItemCode, $value->intorderdetailId);
        }
    }
    public function invoicepickings($reference)
    {

        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        try {
            //Initialise
            $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $returnToInvoices = DB::connection('sqlsrv3')
                ->select(
                    'exec spGetOrderNumbersToInvoice ?',
                    array($reference)
                );

            //dd($returnToInvoices);

            if (count($returnToInvoices) > 0) {

                foreach ($returnToInvoices as $val) {
                    switch ($val->intOwnerID) {
                        case 1:
                            $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok Distribution;server=HK-SQL2019,1433');
                            break;
                        case 2:
                            $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Henroof_Dims;server=HK-SQL2019,1433');
                            break;
                        case 3:
                            $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Ukhozi_Dims;server=HK-SQL2019,1433');
                            break;
                    }

                    $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                        ->select(
                            'exec spGetOrderNumbersLinesToProcess ?,?,?',
                            array($reference, $val->SalesOrderNo, $val->intOwnerID)
                        );
                    echo "_________Sales Order Number__________________" . $val->SalesOrderNo . "<br>";

                    $x = $sdkHelper->GetSalesOrder($val->SalesOrderNo);
                    foreach ($returnGetsalesorderNoLines as $innverVal) {
                        $lineno = $innverVal->LineNos - 1;
                        $x->Detail[$lineno]->ToProcess = floatval($innverVal->Toinvoice);
                        echo "Line Index " . $lineno . "Line No " . $innverVal->LineNos . "**************** To Invoice" . $innverVal->Toinvoice . "<br>";
                    }
                    echo "Saving Order Number----------" . $val->SalesOrderNo . "<br>***************************************************************************<br>";
                    $reference = $x->Save();

                    $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                        ->select(
                            'exec spProcessSavedSalesOrderLinesByOrderNumber ?,?,?,?,?',
                            array($userid, $val->intOrderId, $val->SalesOrderNo, $val->intOwnerID, $userName)
                        );
                }
                echo "*****************************Processing Invoices************************<br>";
                $this->processInvoce();
                echo "*****************************Done Processing Invoices******************<br>";
                echo "*****************************Starting to Invoice Now*******************<br>";
            } else {
                //spGetTransfersReadyForIBT
                $returnToInvoices = DB::connection('sqlsrv3')
                    ->select(
                        'exec spGetTransfersReadyForIBT ?',
                        array($reference)
                    );

                if (count($returnToInvoices) > 0) {
                    echo "****************************************TRANFER STARTING*************************************<br>";
                    $this->whtransfers($reference);
                    //transfer
                }
            }
        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }



    }
    public function processInvoce()
    {
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
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok Distribution;server=HK-SQL2019,1433');
                    break;
                case 2:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Henroof;server=HK-SQL2019,1433');
                    break;
                case 3:
                    $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Ukhosi;server=HK-SQL2019,1433');
                    break;
            }
            try {
                echo "************* SALES ORDERNO BEFORE INV***" . $val->strOrderNo . "<br>";
                $x = $sdkHelper->GetSalesOrder($val->strOrderNo);
                $reference = $x->Process();
                echo "************* INV CREATED***" . $reference . "<br>";
                $returnGetsalesorderNoLines = DB::connection('sqlsrv3')
                    ->select(
                        'exec spPrintProcessedInvoiceNo ?,?,?,?,?',
                        array($userid, $val->intAutoindexID, $val->strOrderNo, $val->intOwnerId, $userName)
                    );
            } catch (Error $err) {
                echo "<h3 style='color: darkred'>__________Errors_________</h3>";
                echo $err;
            }
            //spPrintProcessedInvoiceNo

        }
        echo "*****************************Done Invoicing**********************************************<br>";
        echo "*****************************Printing Started Please Check Your Printer******************<br>";
        echo "*****************************Printer Name Is: " . $PrinterPathInvoice . "********************<br>";


        //spGetTransfersReadyForIBT
        $readyibt = DB::connection('sqlsrv3')
            ->select(
                'exec spGetTransfersReadyForIBT ?',
                array($reference)
            );
        //dd($readyibt);
        if (count($readyibt) > 0) {
            echo "****************************************TRANFER STARTING*************************************<br>";
            $this->whtransfers($reference);
            //transfer
        } else {
            echo "****************************************NO TRANFERS FOUND*************************************<br>";

        }

    }
    public function whtransfers($reference, $orderId)
    {
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $returnNegativeItems = DB::connection('sqlsrv3')
            ->select(
                'exec spNegativeInventory ?',
                array($reference)
            );
        if (count($returnNegativeItems) > 0) {

            echo "<table><thead><th>Item Code</th><th>Qty Loaded</th><th>In Stock Qty</th><th>Qty Needed</th></thead><tbody>";
            foreach ($returnNegativeItems as $val) {
                echo "<tr><td>" . $val->Code . "</td><td>" . $val->Toinvoice . "</td><td>" . $val->QtyInStock . "</td><td>" . $val->qty . "</td></tr>";
            }
            echo "</tbody></table>";
            //dd("Testing the list @Chris please wait");
            $this->negativeInventory($reference);
        } else {
            $returnToInvoices = DB::connection('sqlsrv3')
                ->select(
                    'exec spAutoIndexForTrasfers ?,?',
                    array($reference, $orderId)
                );

            foreach ($returnToInvoices as $innverVal) {
                $this->processTransfer($reference, $innverVal->AutoIndex, $innverVal->OrderNum);
            }
        }
    }
    public function warehousetransfer($itemcode, $FromWarehouse, $ToWarehouse, $Quantity, $ref1, $ref2, $intorderdetailId)
    {
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        try {
            //Initialise
            //  echo "Entering ";

            //dd($indexId." - ".$reference);
            $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $sdkHelper->CreateConnection(env(HENDOK));
            $warehouseTransfer = new \COM("Pastel.Evolution.WarehouseTransfer");

            $warehouseTransfer->Account = $sdkHelper->GetStockItem($itemcode);
            $warehouseTransfer->FromWarehouse = $sdkHelper->GetWarehouseByCode($FromWarehouse);//From Warehouse
            $warehouseTransfer->ToWarehouse = $sdkHelper->GetWarehouseByCode($ToWarehouse);//TO Warehouse
            $warehouseTransfer->Quantity = floatval($Quantity);
            $warehouseTransfer->Reference = $ref1;
            $warehouseTransfer->Reference2 = $ref2;
            $warehouseTransfer->Post();
            //echo "Finished";
            //isTranferedToCentralWH
            DB::connection('sqlsrv3')->table('tblPickingPlan')
                ->where('intorderdetailId', $intorderdetailId)
                ->update(['isTranferedToCentralWH' => 1]);

        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }
    }
    //INVENTORY ADJUSTMENTS
    public function transactionAdj($itemcode, $Warehouse, $Quantity, $ref1, $ref2, $intorderdetailId, $invoiceid, $ownersId, $date)
    {
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        //	dd(get_declared_classes());

        try {
            //Initialise
            //  echo "Entering ";


            //dd($indexId." - ".$reference);
            $sdkHelper->CreateCommonDBConnection(env('COMMON'));
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $sdkHelper->CreateConnection(env('HENDOK'));
            $InventoryTransaction = new \COM("Pastel.Evolution.InventoryTransaction");
            // dd($sdkHelper->GetInventoryOperation( "Increase"));
            //dd();

            $ref2 = $this->returnInvoiceNumber($invoiceid, $ownersId);
            // dd( $ref2);
            $InventoryTransaction->TransactionCode = $sdkHelper->GetTransactionCode(11, "ADJ");//new TransactionCode(Module.Inventory, "ADJ");// specify a inventory transaction type generally this will be ADJ
            $InventoryTransaction->InventoryItem = $sdkHelper->GetStockItem($itemcode);
            $InventoryTransaction->Warehouse = $sdkHelper->GetWarehouseByCode($Warehouse);
            $InventoryTransaction->Operation = 0;//Select the necessary enumerator increase , decrease or cost adjustment 0=Descrease , 1 = increase, 2=CostAdjustment
            $InventoryTransaction->Quantity = floatval($Quantity);

            $InventoryTransaction->Reference = $ref1;
            $InventoryTransaction->Reference2 = $ref2;
            $InventoryTransaction->Date = (new \DateTime($date))->format('Y-m-d');
            $InventoryTransaction->Description = "Dims Ajustments";

            $InventoryTransaction->Post();

            //echo "Finished";
            //isTranferedToCentralWH
            DB::connection('sqlsrv3')->table('tblPickingPlan')
                ->where('intorderdetailId', $intorderdetailId)
                ->update(['isTranferedToCentralWH' => 1]);

        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }

    }
    //DIMS Manual Adjustment
    public function getdimsmanuals()
    {
        return view('dims/warehouseadj');
    }
    public function getusergroupid($userid)
    {
        $groupformid = DB::connection('sqlsrv3')
            ->select("select GroupId from tblDIMSUSERS where UserId=" . $userid);
        return $groupformid[0]->GroupId;
    }
    public function getqrcode()
    {
        return view('warehouse/jobqrcode');
    }
    public function qrcodeimage($machine, $qty, $itemcode)
    {

        $username = "Reginald";
        $userID = "2";
        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;
        return view('warehouse/qrcodeimage')
            ->with('machine', $machine)
            ->with(' ', $qty)
            ->with('username', $username)
            ->with('1', $userID)
            ->with('ID', $ID)
            ->with('item', $itemcode);
    }
    public function dimsmanualadjustment(Request $request)
    {

        $itemCode = $request->get('itemCode');
        $warehousecode = $request->get('warehousecode');
        $adjmentType = $request->get('adjmentType');
        $companyname = $request->get('companyname');
        $invnumber = $request->get('invnumber');
        $trandate = $request->get('trandate');
        $adjustmenttype = $request->get('adjustmenttype');
        $Qty = $request->get('Qty');
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        $result = "Something Went Wrong";
        //	dd(get_declared_classes());

        try {
            //Initialise
            //  echo "Entering ";
            //dd($indexId." - ".$reference);
            $sdkHelper->CreateCommonDBConnection(env('COMMON'));
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $sdkHelper->CreateConnection(env('HENDOK'));
            $InventoryTransaction = new \COM("Pastel.Evolution.InventoryTransaction");
            // dd($sdkHelper->GetInventoryOperation( "Increase"));
            //dd();


            // dd( $ref2);
            if ($adjustmenttype == "WHT") {
                $InventoryTransaction->TransactionCode = $sdkHelper->GetTransactionCode(11, "WHT");
            } else {
                $InventoryTransaction->TransactionCode = $sdkHelper->GetTransactionCode(11, "ADJ");
            }
            //new TransactionCode(Module.Inventory, "ADJ");// specify a inventory transaction type generally this will be ADJ
            $InventoryTransaction->InventoryItem = $sdkHelper->GetStockItem($itemCode);
            $InventoryTransaction->Warehouse = $sdkHelper->GetWarehouseByCode($warehousecode);
            $InventoryTransaction->Operation = intval($adjmentType);//Select the necessary enumerator increase , decrease or cost adjustment 0=Descrease , 1 = increase, 2=CostAdjustment
            $InventoryTransaction->Quantity = floatval($Qty);

            $InventoryTransaction->Reference = $companyname;
            $InventoryTransaction->Reference2 = $invnumber;
            $InventoryTransaction->Date = (new \DateTime($trandate))->format('Y-m-d');
            if ($adjustmenttype == "WHT") {
                $InventoryTransaction->Description = "Dims Warehouse Transfer";
            } else {
                $InventoryTransaction->Description = "Dims Ajustments";
            }


            $InventoryTransaction->Post();
            $result = "Done";

            //echo "Finished";
            //isTranferedToCentralWH
            //  DB::connection('sqlsrv3')->table('tblPickingPlan')
            // ->where('intorderdetailId',$intorderdetailId )
            //    ->update(['isTranferedToCentralWH' => 1]);//

        } catch (Error $err) {
            $result = $err;
            //  echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            //echo $err;
        }
        return $result;

    }
    //NEGATIVE INVENTORY ITEMS TO ADJUST
    public function negativeInventory($ref)
    {
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        //	dd(get_declared_classes());

        try {
            //Initialise
            //  echo "Entering ";
//spNegativeInventory

            //dd($indexId." - ".$reference);
            $sdkHelper->CreateCommonDBConnection(env('COMMON'));
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $sdkHelper->CreateConnection(env('HENDOK'));
            $InventoryTransaction = new \COM("Pastel.Evolution.InventoryTransaction");
            // dd($sdkHelper->GetInventoryOperation( "Increase"));
            //dd();
            $returnNegativeItems = DB::connection('sqlsrv3')
                ->select(
                    'exec spNegativeInventory ?',
                    array($ref)
                );

            foreach ($returnNegativeItems as $val) {
                $InventoryTransaction->TransactionCode = $sdkHelper->GetTransactionCode(11, "ADJ");//new TransactionCode(Module.Inventory, "ADJ");// specify a inventory transaction type generally this will be ADJ
                $InventoryTransaction->InventoryItem = $sdkHelper->GetStockItem($val->Code);
                $InventoryTransaction->Warehouse = $sdkHelper->GetWarehouseByCode($val->warehouse);
                $InventoryTransaction->Operation = 1;//Select the necessary enumerator increase , decrease or cost adjustment 0=Descrease , 1 = increase, 2=CostAdjustment
                $InventoryTransaction->Quantity = floatval($val->qty);

                $InventoryTransaction->Reference = $val->OrderNum;
                $InventoryTransaction->Reference2 = $ref;
                $InventoryTransaction->Date = (new \DateTime($val->dtmDate))->format('Y-m-d');
                $InventoryTransaction->Description = "Dims Ajustments Neg Inv";

                $InventoryTransaction->Post();
            }

            //echo "Finished";
            //isTranferedToCentralWH
            echo "DONE ADJUSTING ---Please Refresh";


        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }

    }
    public function returnInvoiceNumber($invoiceid, $ownerId)
    {
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select(
                'exec spGetOrderNumberInv ?,?',
                array($invoiceid, $ownerId)
            );
        $inv = $returnToInvoices[0]->InvNumber;
        return $inv;

    }
	public function updateTheDocIds($invoiceid, $ownerId,$reference)
    {
        $returnDocStatus = DB::connection('sqlsrv3')
            ->select(
                'exec sp_CheckInvoiceEligibilityAndUpdateOutOfSyncData ?,?,?',
                array($reference, $ownerId ,$invoiceid)
            );
        $Result = $returnDocStatus[0]->Result;
        return $Result;

    }
    public function CheckIfCreditLimitFine($invoiceid, $ownerId)
    {
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select(
                'exec spCreditLimitDoubleCheckBeforeInvoicing ?,?',
                array($invoiceid, $ownerId)
            );
        $inv = $returnToInvoices[0]->Results;
        return $inv;

    }
    //IBT
    public function processTransfer($reference, $indexId, $ordernumebr)
    {

        //spGetPlannedItemsToTransfers
        $userid = Auth::user()->UserID;
        $trasferID = -1;
        $returnToInvoices = DB::connection('sqlsrv3')
            ->select(
                'exec spGetPlannedItemsToTranferCheckNegativeInveontory ?,?',
                array($indexId, $reference)
            );

        if (count($returnToInvoices) > 0) {
            echo '<h2>Please Check The Stock For The Following Items</h2><br>';
            echo '<table style=" border-collapse: collapse;width: 100%;"><thead><tr> <th style="border: 1px solid #dddddd;">InventoryItem</th><th style="border: 1px solid #dddddd;">QuantityLoaded</th><th style="border: 1px solid #dddddd;">ToUseQty</th><th style="border: 1px solid #dddddd;">QtyOnHand</th> </tr></thead><tbody>';
            foreach ($returnToInvoices as $val) {
                echo '<tr><td style="border: 1px solid #dddddd;">' . $val->InventoryItem . '</td>';
                echo '<td style="border: 1px solid #dddddd;">' . $val->QuantityLoaded . '</td>';
                echo '<td style="border: 1px solid #dddddd;">' . $val->ToUseQty . '</td>';
                echo '<td style="border: 1px solid #dddddd;">' . $val->QtyOnHand . '</td></tr>';
            }
            echo '</tbody></table>';
            dd("PLEASE FIX THE STOCK ISSUE");

        } else {

            $returnToInvoices = DB::connection('sqlsrv3')
                ->select(
                    'exec spGetPlannedItemsToTransfers ?,?',
                    array($indexId, $reference)
                );

            $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
            try {
                //Initialise

                //dd($indexId." - ".$reference);
                $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
                $sdkHelper->SetLicense("DE12111039", "4626921");
                $sdkHelper->CreateConnection(env('HENDOK'));

                $warehouseIBT = new \COM("Pastel.Evolution.WarehouseIBT");
                $warehouse = new \COM("Pastel.Evolution.Warehouse");
                //   dd($warehouse);


                $warehouseIBT->WarehouseFrom = $sdkHelper->GetWarehouseByCode("Mstr");//Specify From which warehouse qty will be transfered from
                $warehouseIBT->WarehouseTo = $sdkHelper->GetWarehouseByCode("CPT");//Specify From which warehouse qty will be transfered from
                $warehouseIBT->Description = $ordernumebr; //Will user SONumber
                $warehouseIBT->Reference1 = "ID#" . $indexId; //Will user SONumber
                $warehouseIBT->Reference2 = "Planning#" . $reference; //Will user SONumber

                foreach ($returnToInvoices as $val) {
                    $WarehouseIBTLine = new \COM("Pastel.Evolution.WarehouseIBTLine");
                    $WarehouseIBTLine->InventoryItem = $sdkHelper->GetStockItem($val->InventoryItem);
                    $WarehouseIBTLine->Description = $val->InventoryItem;
                    $WarehouseIBTLine->Reference = "" . $val->Reference;
                    $WarehouseIBTLine->QuantityIssued = floatval($val->Quantity);
                    $warehouseIBT->Detail->Add($WarehouseIBTLine);
                }
                $referenceibt = $warehouseIBT->IssueStock();
                $trasferID = $warehouseIBT->ID;

            } catch (Error $err) {
                echo "<h3 style='color: darkred'>__________Errors_________</h3>";
                echo $err;
                dd();
            }
        }

        /*
        if( $data->Result->Status->Success == "true"){

                     $returnToInvoices = DB::connection('sqlsrv3')
                    ->select('exec spUpdateTblOwsersSoNumber ');
                    $cancelltransfer = DB::connection('sqlsrv3')
                    ->select("exec spMarkTransferOrderAsCancelled '$indexId'");

                    echo $cancelltransfer[0]->results;


            }*/
        //$trasferID
        echo "**************************************DONE TRANSFERING*********************************************<br>";
        /*$transferremainings = DB::connection('sqlsrv3')
            ->select('exec spGetBalanceItemsRemaining ?,?,?',
                array($reference,$trasferID,$indexId)
            ); */

        echo "**************************************CHECKING TO SEE IF TRANSFER HAS REMAINING ITEMS********************************************* AutoIndex#" . $indexId . "<br> TRANSFERID#" . $trasferID . "<br>";


        echo "UPDATE PICKING REFERENCE WITH A NEW IBT DEL NOTE <br>";
        //dd($reference);
        $checks = DB::connection('sqlsrv3')
            ->select(
                'exec spUpdatePickingHeaderIfIBT ?,?,?',
                array($trasferID, $reference, $userid)
            );

        /*echo "**********************************PRINT TRIPSHEET**************************************************************************** <br>";
        $transferremainings = DB::connection('sqlsrv3')
            ->select('exec spInsertHendokTripsheet ?,?',
                array($reference,$userid)
            );
        echo "**********************************DONE PRINTING TRIPSHEET******************************************************************** <br>";*/
        //[spInsertHendokTripsheet]
        $this->getRemainingBalance($reference, $trasferID, $indexId);

    }


    public function getRemainingBalance($reference, $trasferID, $indexId)
    {

        echo "/////////////////////////////Entering The Remaining Items Method/////////////////////////////////////";
        $transferremainings = DB::connection('sqlsrv3')
            ->select(
                'exec spGetBalanceItemsRemaining ?,?,?',
                array($reference, $trasferID, $indexId)
            );

        if (count($transferremainings) > 0) {

            $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
            try {
                //Initialise

                $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
                $sdkHelper->SetLicense("DE12111039", "4626921");
                $sdkHelper->CreateConnection(env('HENDOK'));

                $salesOrder = new \COM("Pastel.Evolution.SalesOrder");
                //  $taxRate = new \COM("Pastel.Evolution.TaxRate");
                //$orderDetail = new \COM("Pastel.Evolution.OrderDetail");
                //   dd($warehouse);

                $cashAccount = $sdkHelper->GetARAccount("HDK_CPT");
                $salesOrder->Customer = $cashAccount;
                $salesOrder->TaxMode = 0;
                //External order number
                //Rep
                //Delivery method
                //Area
                //Placed By
                // $warehouseIBT->WarehouseFrom =  $sdkHelper->GetWarehouseByCode("Mstr");//Specify From which warehouse qty will be transfered from
                //$warehouseIBT->WarehouseTo =  $sdkHelper->GetWarehouseByCode("CPT");//Specify From which warehouse qty will be transfered from
                //   $salesOrder->ExtOrderNum = $reference; //Will user SONumber
                //salesOrder->GetWarehouseByCode
                //  	$orderDetail->salesOrder = ;
                $ExtOrderNum = "";
                $DocRepID = 9;
                $DelMethodID = 2;
                foreach ($transferremainings as $val) {
                    $orderDetail = new \COM("Pastel.Evolution.OrderDetail");
                    $orderDetail->InventoryItem = $sdkHelper->GetStockItem($val->Code);
                    $orderDetail->Quantity = floatval($val->qty);
                    $orderDetail->TaxMode = 0;
                    $orderDetail->TaxType = $sdkHelper->GetTaxRate("1");
                    $orderDetail->Warehouse = $sdkHelper->GetWarehouseByCode("Mstr");
                    $orderDetail->UnitSellingPrice = floatval($val->fUnitPriceExcl);
                    $ExtOrderNum = $val->ExtOrderNum;
                    //	$orderDetail->TaxMode = "";
                    $salesOrder->Detail->Add($orderDetail);
                }
                $salesOrder->ExtOrderNum = $ExtOrderNum;
                $salesOrder->DocRepID = $DocRepID;
                $salesOrder->DelMethodID = $DelMethodID;
                $reference = $salesOrder->Save();

                $transferremainings = DB::connection('sqlsrv3')
                    ->select(
                        'exec spCancelOldTranfer ?',
                        array($indexId)
                    );
                echo "________________________________________________Cancelled Old Transfer________________________________________________ " . $indexId . "<br>";

            } catch (Error $err) {
                echo "<h3 style='color: darkred'>__________Errors_________</h3>";
                echo $err;
                dd();
            }
        } else {

            echo "****************The Transfer Is Fully Loaded..........No Remaining Items ";
            dd("");
        }
        //dd()

    }

    public function trywarehouse()
    {
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        try {
            //Initialise

            $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
            $sdkHelper->SetLicense("DE12111039", "4626921");
            $sdkHelper->CreateConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=Hendok Distribution;server=HK-SQL2019,1433');

            $warehouseIBT = new \COM("Pastel.Evolution.WarehouseIBT");
            $warehouse = new \COM("Pastel.Evolution.Warehouse");
            //   dd($warehouse);


            $warehouseIBT->WarehouseFrom = $sdkHelper->GetWarehouseByCode("Mstr");//Specify From which warehouse qty will be transfered from
            $warehouseIBT->WarehouseTo = $sdkHelper->GetWarehouseByCode("CPT");//Specify From which warehouse qty will be transfered from
            $warehouseIBT->Description = "led-test"; //Will user SONumber
            $warehouseIBT->Reference1 = "picking reference"; //Will user SONumber

            $WarehouseIBTLine = new \COM("Pastel.Evolution.WarehouseIBTLine");
            $WarehouseIBTLine->InventoryItem = $sdkHelper->GetStockItem("BBW31550");
            $WarehouseIBTLine->Description = "testline1";
            $WarehouseIBTLine->Reference = "R01";
            $WarehouseIBTLine->QuantityIssued = 1;
            $warehouseIBT->Detail->Add($WarehouseIBTLine);

            $WarehouseIBTLine = new \COM("Pastel.Evolution.WarehouseIBTLine");
            $WarehouseIBTLine->InventoryItem = $sdkHelper->GetStockItem("BBW1605");
            $WarehouseIBTLine->Description = "t1";
            $WarehouseIBTLine->Reference = "R2";
            $WarehouseIBTLine->QuantityIssued = 1;
            $warehouseIBT->Detail->Add($WarehouseIBTLine);

            $WarehouseIBTLine = new \COM("Pastel.Evolution.WarehouseIBTLine");
            $WarehouseIBTLine->InventoryItem = $sdkHelper->GetStockItem("RWSTRIP");
            $WarehouseIBTLine->Description = "testline1";
            $WarehouseIBTLine->Reference = "Ref003";
            $WarehouseIBTLine->QuantityIssued = 1;
            $warehouseIBT->Detail->Add($WarehouseIBTLine);

            //$warehouseIBT->Detail->Add($WarehouseIBTLine);
            $reference = $warehouseIBT->IssueStock();
            dd($warehouseIBT->ID);




        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }
    }
    public function invManualAdj($ref, $SoNumber, $ownersId, $autoIndex, $dates)
    {

        $refDescription = "";
        $sdkHelper = new \COM("Pastel.Evolution.ComHelper");
        try {
            //Initialise
            $sdkHelper->CreateCommonDBConnection('uid=dims;pwd=$D1ms_L1nx#;Initial Catalog=SageCommon;server=HK-SQL2019');
            $sdkHelper->SetLicense("DE12111039", "4626921");
            switch ($ownersId) {
                case 1:

                    $refDescription = "Hendok";
                    break;
                case 2:

                    $refDescription = "Henroof";
                    $mustStockAdjust = 1;
                    break;
                case 3:

                    $refDescription = "Ukhosi";
                    $mustStockAdjust = 1;
                    break;
            }
            $itemstotransfers = DB::connection('sqlsrv3')
                ->select(
                    'exec [spGetOrderNumbersLinesToProcessToTransfer] ?,?,?',
                    array($ref, $SoNumber, $ownersId)
                );
            foreach ($itemstotransfers as $value) {
                //If you need to do normal warehouse transfer
                // $this->warehousetransfer($value->ItemCode,'CPT','UKH',$value->Toinvoice,$value->ItemCode,$SoNumber,$value->intorderdetailId);
                $this->transactionAdj($value->ItemCode, env('CPTW'), $value->Toinvoice, $refDescription, $SoNumber, $value->intorderdetailId, $autoIndex, $ownersId, $dates);
            }

        } catch (Error $err) {
            echo "<h3 style='color: darkred'>__________Errors_________</h3>";
            echo $err;
        }

    }

    public function printtripsheet($ref)
    {
        //
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;
        $checkifinvoicedbeforetripsheet = DB::connection('sqlsrv3')
            ->select(
                'exec spCheckIfOrderBeforePrintingTripSheet ?',
                array($ref)
            );
        $isfullyInvoiced = "NO";
        if (count($checkifinvoicedbeforetripsheet) == 0) {
            $isfullyInvoiced = "YES";
            //[spPrintTruckSheet]
            $checkifinvoicedbeforetripsheet = DB::connection('sqlsrv3')
                ->select(
                    'exec spPrintTruckSheet ?,?,?',
                    array($ref, $userid, $userName)
                );
        }

        return view('dims/printtrucksheet')->with('linesnotInvoiced', $checkifinvoicedbeforetripsheet)->with('isinvoicednot', $isfullyInvoiced);
    }

    public function teamLeaderPrintTripSheet(Request $request)
    {
        $ref = $request->get("ref");
        $userid = Auth::user()->UserID;
        $userName = Auth::user()->UserName;

        $print = DB::connection('sqlsrv3')->select("exec spPrintingTripSheetApp ?,?,?", array($ref, $userid, $userName));

        return response()->json($print);
    }


    public function reprintInvoice()
    {

    }

}
