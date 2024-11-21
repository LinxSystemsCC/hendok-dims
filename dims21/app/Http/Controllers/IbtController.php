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
        $gitData = DB::connection('sqlsrv2')
            ->select("select * from tblLocationNames ln inner join tblLocationTypes lt ON LT.intLocationTypeId = LN.intLocationTypeId where strLocationType = 'Transit'");
        $varianceData = DB::connection('sqlsrv2')
            ->select("select * from tblLocationNames ln inner join tblLocationTypes lt ON LT.intLocationTypeId = LN.intLocationTypeId where strLocationType = 'Variance'");


        return view('warehouse.ibt.index',compact('products','dcData','gitData','varianceData'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('intStatus') && $request->get('intStatus') == 1) {
            $status = 3;
        } else {
            $status = 0;
        }
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
        $intStatus = $request->has('intStatus') && $request->get('intStatus') == 1 ? 3 : 0;

        $strTlNumber = $request->get('strTlNumber') ?: null;
        $intVariance = $request->get('intVariance') ?: null;
        $result = DB::connection('sqlsrv2')->select(
            'EXEC spUpdateIBT
                @SelectedIbtHeaderId = :SelectedIbtHeaderId,
                @reference = :reference,
                @date = :date,
                @userID = :userID,
                @intStatus = :intStatus,
                @strTlNumber = :strTlNumber,
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
                'strTlNumber' => $strTlNumber,
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
        $key = $request->input('key');
        $values = $request->input('values');
        $qtyReceived = $values['intQtyReceived'];
        $qtyVariance = $values['QtyVariance'];
        $updatedRows = DB::update('UPDATE tblIBTLines
            SET intQtyVariance = ?, intQtyReceived = ?
            WHERE intAutoId = ?',
            [$qtyVariance, $qtyReceived, $key]);

        if ($updatedRows > 0) {
            return response()->json(['success' => true, 'message' => 'Record updated successfully.']);
        } else {
            return response()->json(['success' => false, 'message' => 'Update failed.']);
        }
    }
}
