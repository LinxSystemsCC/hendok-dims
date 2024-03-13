<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadingController extends Controller
{
    public function loadTracking()
    {
        $statuses = DB::connection('sqlsrv2')->select("SELECT intAutoId, strStatus FROM tblLoadStatuses");
        $reasonTypes = DB::connection('sqlsrv2')->select("SELECT intAutoId, strReasonTypes FROM tblLoadReasonTypes");
        return view('warehouse.loading.loadTracking')
            ->with('statuses', $statuses)
            ->with('reasonTypes', $reasonTypes);
    }

    public function getLoadTracking(Request $request){
        // $example = $request->get("example");
        
        $data = DB::connection('sqlsrv2')->select("SELECT * FROM viewLoadTrackingPickingTickets ORDER BY intAutoPickingHeader");
        return response()->json($data);
    }

    public function postLoadTrackingUpdate(Request $request){
        // $example = $request->get("example");


        $dtmPlannedDeparture = $request->get('dtmPlannedDeparture');
        $dtmActualDeparture = $request->get('dtmActualDeparture');
        $intStatus = $request->get('intStatus');
        $intReasonType = $request->get('intReasonType');
        $strReason = $request->get('strReason');
        $strUnickReference = $request->get('strUnickReference');
        $command = $request->get('command');

        // dd($strUnickReference);

        $data = DB::connection('sqlsrv2')->select("EXEC spLoadTrackingUpdate '$dtmPlannedDeparture', '$dtmActualDeparture', '$intStatus', '$intReasonType', '$strReason', '$strUnickReference', '$command'");
        return response()->json($data);
    }
}
