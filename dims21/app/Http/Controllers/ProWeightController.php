<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class ProWeightController extends Controller
{
    public function index()
    {
        $horses = DB::connection('sqlsrv3')->select("SELECT * FROM viewHorses WHERE TruckType IN ('Rigid', 'Articulated')");

        return view("warehouse.pro_weigh.index")
            ->with('horses', $horses);
    }

    public function searchTicket(Request $request){
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = DB::table('[HK-SQL2012].[ProWeigh].[dbo].[WB_Ticket_Trans]')
            ->select('TICKET_NUMBER')
            ->where('TICKET_NUMBER', 'like', '%' . $query . '%')
            ->where('TRANSPORTER_CODE', '=', 'Hendok')
            ->orderBy('TICKET_NUMBER', 'desc')
            ->limit(100)
            ->get();

        return response()->json($results);
    }

    public function getProWeighTicketDetails($ticketNumber)
    {
        $ticket = DB::table('[HK-SQL2012].[ProWeigh].[dbo].[WB_Ticket_Trans]')
            ->select(
                'TICKET_NUMBER',
                'REG_NUMBER',
                'TRAILER1_REG_NUMBER',
                'TRAILER2_REG_NUMBER',
                'TRUCK_TARE_WEIGHT',
                'FIRST_WEIGHT',
                'SECOND_WEIGHT'
            )
            ->where('TICKET_NUMBER', $ticketNumber)
            ->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }

    public function updateProWeighData(Request $request)
    {
        $strTicket = $request->get("strTicket");
        $strOldRegNumber = $request->get("strOldRegNumber");
        $decOldFirstWeigh = $request->get("decOldFirstWeigh");
        $decOldTruckTareWeight = $request->get("decOldTruckTareWeight");
        $strNewRegNumber = $request->get("strNewRegNumber");
        $decNewFirstWeigh = $request->get("decNewFirstWeigh");
        $decNewTruckTareWeight = $request->get("decNewTruckTareWeight");
        $intCreatedBy = Auth::user()->UserID;
        
        // dd("EXEC usp_U_ProWeighData '$strTicket', '$strOldRegNumber', $decOldFirstWeigh, $decOldTruckTareWeight, '$strNewRegNumber', $decNewFirstWeigh, $decNewTruckTareWeight, $intCreatedBy");

        $result = DB::connection('sqlsrv3')->select("EXEC usp_U_ProWeighData '$strTicket', '$strOldRegNumber', $decOldFirstWeigh, $decOldTruckTareWeight, '$strNewRegNumber', $decNewFirstWeigh, $decNewTruckTareWeight, $intCreatedBy");

        return response()->json($result[0]);
    }
}
