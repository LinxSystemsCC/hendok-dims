<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'intQtyVariance' => $request->get('intQtyVariance'),
            'intQtyReceived' => $request->get('intQtyReceived'),
            'intAutoId' => $request->get('intAutoId'),
        ];
        $updatedRows = DB::update(
            'UPDATE tblIBTLines SET intQtyVariance = :intQtyVariance, intQtyReceived = :intQtyReceived WHERE intAutoId = :intAutoId',
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
            'intAutoId' => $request->get('SelectedIbtHeaderId'),
        ];
        $updatedRows = DB::update(
            'UPDATE tblIBTHeader SET intStatus = :intStatus, intReceivingBin = :intReceivingBin WHERE intAutoId = :intAutoId',
            $passData
        );

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
}
