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
        $products = DB::connection('sqlsrv2')->select("select * from viewTblProductWeightedCalc");

        return view('warehouse.ibt',compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $xmlLines = $request->input('dataxml');
        $date = $request->input('dtmCreated');
        $reference = $request->input('strReference');
        $userID = Auth::user()->UserID;
        $result = DB::connection('sqlsrv2')->select("exec spCreateIBT '$reference','$date',$userID,0,'$xmlLines' ");

        return response()->json(['success' => true]);
    }

    /**
     * This function is used for get the IBT list
     */
    public function getIBTRecords()
    {
        $returndata = DB::connection('sqlsrv2')->select("select * from viewtblIBTHeadersData");
        
        return response()->json($returndata);
    }

    /**
     * This function is used for get IBT Details
     * 
     * @param obj $request
     */
    public function getIBTDetails(Request $request)
    {
        $ibtHeaderId = $request->get('IbtHeaderId');
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
        $xmlLines = $request->input('dataxml');
        $date = $request->input('dtmCreated');
        $reference = $request->input('strReference');
        $userID = Auth::user()->UserID;
        $SelectedIbtHeaderId = $request->input('SelectedIbtHeaderId');
        $result = DB::connection('sqlsrv2')->select("exec spUpdateIBT $SelectedIbtHeaderId,'$reference','$date',$userID,0, '$xmlLines' ");

        return response()->json(['success' => true]);
    }
}
