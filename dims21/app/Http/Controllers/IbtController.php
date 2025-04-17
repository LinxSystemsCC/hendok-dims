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
        $products = DB::connection('sqlsrv2')
            ->select("select * from viewTblProductWeightedCalc");
        $dcData = DB::connection('sqlsrv2')
            ->select("select * from tblDCNames");

        return view('warehouse.ibt.index',compact('products','dcData'));
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

    public function getIssuedIBTDetails(Request $request)
    {
        if (is_array($request->all())) {
            $ibtHeaderId = $request->all()['IbtHeaderId'];

        } else {
            $ibtHeaderId = $request->get('IbtHeaderId');
        }
        $ibtDetails = DB::connection('sqlsrv2')->select("exec spGetIssuedIBTDetails ?", array($ibtHeaderId));

        return response()->json($ibtDetails);
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
        $intReceivedBy = Auth::user()->UserID;

        if (!empty($lines)) {
            $xml = $this->toxml($lines, "xml", array("result"));
        }

        // dd("EXEC usp_C_RecieveIBTandMove $ibtHeader, '$xml', $receivingBin, $intReceivedBy");
        $updatedRows = DB::connection('sqlsrv2')->select("EXEC usp_C_RecieveIBTandMove $ibtHeader, '$xml', $receivingBin, $intReceivedBy");

        if ($updatedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Update failed.']);
    }

    /**
     * This function is used for get the bins
     *
     * @param obj $request
     */
    public function getBins(Request $request)
    {
        $dcId = $request->get('dc_id');
        if ($request->has('is_from_dc') && $request->get('is_from_dc')) {
            $bins = DB::connection('sqlsrv2')
                ->select("
                    SELECT * FROM viewBinNames bn
                    INNER JOIN tblLocationNames ln  ON ln.intLocationNameId = bn.intLocationId
                    INNER JOIN tblLocationTypes lt ON LT.intLocationTypeId = ln.intLocationTypeId
                    WHERE strLocationType = 'Transit' AND intDcId = '$dcId'
                ");
        } elseif ($request->has('is_to_dc') && $request->get('is_to_dc')) {
            $varianceBins = DB::connection('sqlsrv2')
                ->select("
                    SELECT * FROM viewBinNames bn
                    INNER JOIN tblLocationNames ln  ON ln.intLocationNameId = bn.intLocationId
                    INNER JOIN tblLocationTypes lt ON LT.intLocationTypeId = ln.intLocationTypeId
                    WHERE strLocationType = 'Variance' AND intDcId = '$dcId'
                ");
            $receivingBins = DB::connection('sqlsrv2')
                ->select("
                    SELECT * FROM viewBinNames bn
                    INNER JOIN tblLocationNames ln  ON ln.intLocationNameId = bn.intLocationId
                    INNER JOIN tblLocationTypes lt ON LT.intLocationTypeId = ln.intLocationTypeId
                    WHERE strLocationType = 'Receiving' AND intDcId = '$dcId'
                ");
            $bins = [
                'varianceBins' => $varianceBins,
                'receivingBins' => $receivingBins,
            ];
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
