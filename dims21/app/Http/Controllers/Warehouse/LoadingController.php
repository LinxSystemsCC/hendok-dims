<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LoadingController extends Controller
{
    public function loadTracking()
    {
        $drivers = DB::connection('sqlsrv2')->select("SELECT intEmployeeId AS DriverId, strFullName AS DriverName FROM vwSage300Drivers");
        $horses = DB::connection('sqlsrv3')->select("SELECT * FROM viewHorses");
        $trailors = DB::connection('sqlsrv3')->select("SELECT * FROM viewTrailers");
        $tickets = DB::connection('weights')->select("SELECT TICKET_NUMBER strTicket FROM WB_Ticket_Trans WHERE SECOND_WEIGH_OPERATOR IS NULL OR SECOND_WEIGH_OPERATOR = ''");

        $statuses = DB::connection('sqlsrv2')->select("SELECT intAutoId, strStatus, strType FROM tblLoadStatuses");
        $reasonTypes = DB::connection('sqlsrv2')->select("SELECT intAutoId, strReasonTypes FROM tblLoadReasonTypes");
        return view('warehouse.loading.loadTracking')
            ->with('statuses', $statuses)
            ->with('reasonTypes', $reasonTypes)
            ->with('drivers', $drivers)
            ->with('horses', $horses)
            ->with('trailors', $trailors)
            ->with('tickets', $tickets);
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
