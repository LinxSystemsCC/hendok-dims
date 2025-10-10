<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class IbtController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //Order is DC, truck load, wear hourse, ibt,

                    $products = DB::connection('sqlsrv2')->select('EXEC usp_GetProducts');


        $dcData = DB::connection('sqlsrv2')->select('EXEC usp_GetDCName');
 $bins = DB::connection('sqlsrv3')->select("EXEC usp_GetActiveBinLocations");



return view('warehouse.ibt.index', compact('products', 'dcData', 'bins'));
    }


    
    public function outstandingibt()
    {



        $dateFrom = date('Y-m-d', strtotime('-7 days'));
        $dateTo = date('Y-m-d');

return view('warehouse.backorderibt.index')
            ->with('dateFrom', $dateFrom)
            ->with('dateTo', $dateTo);
    }
    public function getBackOrderIBT(Request $request){

        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');

    $outstandingibt = DB::connection('sqlsrv2')
        ->select('EXEC [usp_R_GetIbtOutStandingBalance] ?,?', array($dateFrom,$dateTo)); 

    return response()->json($outstandingibt);
    }


    
    public function tlreport()
    {


        $dcData = DB::connection('sqlsrv2')->select('EXEC usp_GetDCName');
        $bins = DB::connection('sqlsrv3')->select("EXEC usp_GetActiveBinLocations");
        $dateFrom = date('Y-m-d', strtotime('-7 days'));
        $dateTo = date('Y-m-d');

    return view('warehouse.tlreport.index')
            ->with('dcData', $dcData)
            ->with('bins', $bins)
            ->with('dateFrom', $dateFrom)
            ->with('dateTo', $dateTo);
    }
    public function getTLsDateRange(Request $request){

        $dateFrom = $request->get('dateFrom');
        $dateTo = $request->get('dateTo');

    $outstandingibt = DB::connection('sqlsrv2')
        ->select('EXEC [usp_R_GetTLsDateRange] ?,?', array($dateFrom,$dateTo)); 

    return response()->json($outstandingibt);
    }

        public function receiveTLNumberData(Request $request)
    {
        $rows = $request->get('rows');
        $dc = $request->get('dc');
        $warehouse = $request->get('warehouse');
        $bin = $request->get('bin');
        $xml = new \SimpleXMLElement('<Rows/>');

        foreach ($rows as $row) {
            $rowElement = $xml->addChild('Row');
            foreach ($row as $key => $value) {
                $rowElement->addChild($key, htmlspecialchars($value ?? ''));
            }
        }

        $xmlString = $xml->asXML();


        DB::connection('sqlsrv2')->statement(
            'EXEC [usp_C_PostTLData] ?, ?, ?, ?',
            [$xmlString, $dc, $warehouse, $bin]
        );

        return response()->json(['success' => true]);
    }




    
    public function getTLItemsPerIBT(Request $request){

        $strTLNumber = $request->get('strTLNumber');

    $itemperTL = DB::connection('sqlsrv2')
        ->select('EXEC [usp_R_GetItemsPerIBTTLNumber] ?', array($strTLNumber)); 

    return response()->json($itemperTL);
    }






    public function getTruckLoadsByDC(Request $request)
{
    $dcId = $request->get('dc_id');

    $truckLoads = DB::connection('sqlsrv2')
        ->select('EXEC usp_GetIssuedIBTTruckLoadsByDC ?', [$dcId]); 

    return response()->json($truckLoads);
}



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $status = 0;
        $result = DB::connection('sqlsrv2')->select(
            'EXEC spCreateIBT
                @reference = :reference,
                @date = :date,
                @userID = :userID,
                @intStatus = :intStatus,
                @intFromDC = :intFromDC,
                @intToDC = :intToDC,
                @intGIT = :intGIT,
                @intVariance = :intVariance,
                @xmlLines = :xmlLines',
            [
                'reference' => $request->get('strReference'),
                'date' => $request->get('dtmCreated'),
                'userID' => Auth::user()->UserID,
                'intStatus' => $status,
                'intFromDC' => $request->get('intFromDC'),
                'intToDC' => $request->get('intToDC'),
                'intGIT' => $request->get('intGIT'),
                'intVariance' => $request->get('intVariance'),
                'xmlLines' => $request->get('dataxml')
            ]
        );

        if ($result[0]->Result == 'Success') {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * This function is used for get the IBT list
     */
    public function getIBTRecords()
    {
        $returndata = DB::connection('sqlsrv2')
            ->select("SELECT * FROM dbo.viewtblIBTHeadersData ORDER BY intAutoId DESC");

        return response()->json($returndata);
    }

    /**
     * This function is used for get IBT Details
     *
     * @param obj $request
     */
    public function getIBTDetails(Request $request)
    {
        if (is_array($request->all())) {
            $ibtHeaderId = $request->all()['IbtHeaderId'];

        } else {
            $ibtHeaderId = $request->get('IbtHeaderId');
        }
        $ibtDetails = DB::connection('sqlsrv2')->select("exec spGetIBTDetails ?", array($ibtHeaderId));

        return response()->json($ibtDetails);
    }

    public function getIssuedIBTTruckLoads(Request $request)
    {
        if (is_array($request->all())) {
            $IbtHeaderId = $request->all()['IbtHeaderId'];

        } else {
            $IbtHeaderId = $request->get('IbtHeaderId');
        }
        $ibtDetails = DB::connection('sqlsrv2')->select("exec spGetIssuedIBTTruckLoads ?", array($IbtHeaderId));

        return response()->json($ibtDetails);
    }

    public function getIssuedIBTDetails(Request $request)
    {
        if (is_array($request->all())) {
            $intTLNumber = $request->all()['intTLNumber'];
            $intIBTHeaderId = $request->all()['intIBTHeaderId'];

        } else {
            $intTLNumber = $request->get('intTLNumber');
            $intIBTHeaderId = $request->get('intIBTHeaderId');
        }
        $ibtDetails = DB::connection('sqlsrv2')->select("exec spGetIssuedIBTDetails ?, ?", array($intTLNumber, $intIBTHeaderId));

        return response()->json($ibtDetails);
    }

    /**
     * This function is used for Cancelling an IBT
     *
     * @param obj $request
     */
    public function cancelIBT(Request $request)
    {
        $intStatus = $request->has('intStatus') && $request->get('intStatus') ? $request->get('intStatus') : 0;
        $result = DB::connection('sqlsrv2')->select(
            'EXEC spCancelIBT
                @SelectedIbtHeaderId = :SelectedIbtHeaderId,
                @userID = :userID,
                @intStatus = :intStatus',
            [
                'SelectedIbtHeaderId' => $request->get('SelectedIbtHeaderId'),
                'userID' => Auth::user()->UserID,
                'intStatus' => $intStatus
            ]
        );
        if (isset($result[0]->Result) && $result[0]->Result == 'Success') {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }

    /**
     * This function is used for Update IBT Details
     *
     * @param obj $request
     */
    public function updateIBTDetails(Request $request)
    {
        $intStatus = $request->has('intStatus') && $request->get('intStatus') ? $request->get('intStatus') : 0;
        $intTlNumber = $request->get('intTlNumber') ?: null;
        $intVariance = $request->get('intVariance') ?: null;
        $result = DB::connection('sqlsrv2')->select(
            'EXEC spUpdateIBT
                @SelectedIbtHeaderId = :SelectedIbtHeaderId,
                @reference = :reference,
                @date = :date,
                @userID = :userID,
                @intStatus = :intStatus,
                @intTlNumber = :intTlNumber,
                @intFromDC = :intFromDC,
                @intToDC = :intToDC,
                @intGIT = :intGIT,
                @intVariance = :intVariance,
                @xmlLines = :xmlLines',
            [
                'SelectedIbtHeaderId' => $request->get('SelectedIbtHeaderId'),
                'reference' => $request->get('strReference'),
                'date' => $request->get('dtmCreated'),
                'userID' => Auth::user()->UserID,
                'intStatus' => $intStatus,
                'intTlNumber' => $intTlNumber,
                'intFromDC' => $request->get('intFromDC'),
                'intToDC' => $request->get('intToDC'),
                'intGIT' => $request->get('intGIT'),
                'intVariance' => $intVariance,
                'xmlLines' => $request->get('dataxml')
            ]
        );
        if (isset($result[0]->Result) && $result[0]->Result == 'Success') {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }




    /**
     * This function is used for Update Qty Received And QtyVariance
     *
     * @param obj $request
     */
    public function updateIbtLines(Request $request)
    {
        $passData = [
            'mnyQtyVariance' => $request->get('mnyQtyVariance'),
            'mnyQtyReceived' => $request->get('mnyQtyReceived'),
            'intAutoId' => $request->get('intAutoId'),
        ];

        $updatedRows = DB::update(
            'UPDATE tblIBTLines SET mnyQtyVariance = :mnyQtyVariance, mnyQtyReceived = :mnyQtyReceived WHERE intAutoId = :intAutoId',
            $passData
        );

        if ($updatedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Update failed.']);
    }
    /**
     * This function is used for Deleting untouched IBT Lines
     *
     * @param Request $request
     */
    public function deleteIBTLine(Request $request)
    {
        $passData = [
            'intAutoId' => $request->get('intAutoId'),
        ];

        $deletedRows = DB::delete(
            'DELETE FROM tblIBTLines WHERE intAutoId = :intAutoId',
            $passData
        );

        if ($deletedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Record deleted successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Deletion failed or record not found.']);
    }

        

    /**
     * This function is used for update the status
     *
     * @param obj $request
     */
    public function updateStatus(Request $request)
    {
        $passData = [
            'intStatus' => $request->get('intStatus'),
            'intReceivingBin' => $request->get('intReceivingBin'),
            'dtmReceived' => Carbon::now(),
            'intReceivedBy' => Auth::user()->UserID,
            'intAutoId' => $request->get('SelectedIbtHeaderId'),
        ];
        $updatedRows = DB::update(
            '
                UPDATE tblIBTHeader SET
                    intStatus = :intStatus,
                    intReceivingBin = :intReceivingBin,
                    dtmReceived = :dtmReceived,
                    intReceivedBy = :intReceivedBy,
                    intAutoRecieveId = (
                        SELECT ISNULL(MAX(intAutoRecieveId), 0) + 1 FROM tblIBTHeader
                    )
                WHERE intAutoId = :intAutoId
            ',
            $passData
        );

        // This is added to adjust the stock when an ibt is moved
        $ibtHeaderid = $request->get('SelectedIbtHeaderId');
        $userId = Auth::user()->UserID;

        $move = DB::connection('sqlsrv2')->select("EXEC usp_C_RecieveIBTandMove $ibtHeaderid, $userId");

        if ($updatedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Update failed.']);
    }

    /**
     * This function is used to receive an ibt
     *
     * @param obj $request
     */
    public function receive(Request $request)
    {
        $ibtHeader = $request->get('ibtHeader');
        $lines = $request->get('lines');
        $receivingBin = $request->get('bin');
        $intTLNumber = $request->get('intTLNumber');
        $intReceivedBy = Auth::user()->UserID;

        $xml = !empty($lines) ? $this->toxml($lines, "xml", ["result"]) : null;

        $results = DB::connection('sqlsrv2')->select(
            "EXEC usp_C_RecieveIBTandMove ?, ?, ?, ?, ?",
            [$ibtHeader, $xml, $receivingBin, $intReceivedBy, $intTLNumber]
        );

        // Assume stored proc returns a row with Status and Message
        $response = $results[0] ?? ['Status' => 0, 'Message' => 'No response from stored procedure'];

        return response()->json($response);
    }

    /**
     * This function is used for get the bins
     *
     * @param obj $request
     */
 public function getBins(Request $request)
{
    //All converted to store procedure
    $dcId = $request->get('dc_id'); // 1 or 2

    if ($request->has('is_from_dc') && $request->get('is_from_dc')) {
        $bins = DB::connection('sqlsrv2')->select('EXEC usp_GetTransitBinsByDC ?', [$dcId]);
    } elseif ($request->has('is_to_dc') && $request->get('is_to_dc')) {
        $varianceBins = DB::connection('sqlsrv2')->select('EXEC usp_GetVarianceBinsByDC ?', [$dcId]);
        $receivingBins = DB::connection('sqlsrv2')->select('EXEC usp_GetReceivingBinsByDC ?', [$dcId]);

        $bins = [
            'varianceBins' => $varianceBins,
            'receivingBins' => $receivingBins,
        ];
    } else {
        $bins = [];
    }

    return response()->json($bins);
}


    private static function getTabs($tabcount)
    {
        $tabs = '';
        for($i = 0; $i < $tabcount; $i++)
        {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = [], $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . htmlspecialchars($element, ENT_XML1 | ENT_QUOTES, 'UTF-8') . ">";

            if (!is_array($val)) {
                // Escape special characters for XML, including single quotes
                $result .= htmlspecialchars($val, ENT_XML1 | ENT_QUOTES, 'UTF-8');
            } else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }

            $result .= "</" . htmlspecialchars($element, ENT_XML1 | ENT_QUOTES, 'UTF-8') . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = Array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}
