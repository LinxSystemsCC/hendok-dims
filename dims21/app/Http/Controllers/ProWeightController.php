<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Illuminate\Support\Carbon;

class ProWeightController extends Controller
{
    public function index()
    {
        $horses = DB::connection('sqlsrv3')->select("SELECT * FROM viewTeamLeaderHorses");
        $trailers = DB::connection('sqlsrv3')->select("SELECT * FROM viewTrailers");
        
        return view("warehouse.pro_weigh.index")
            ->with('horses', $horses)
            ->with('trailers', $trailers);
    }

    public function searchTicket(Request $request){
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = DB::table('WB_Ticket_Trans')
            ->select('TICKET_NUMBER')
            ->where('TICKET_NUMBER', 'like', '%' . $query . '%')
            ->orderBy('TICKET_NUMBER', 'desc')
            ->limit(100)
            ->get();

        return response()->json($results);
    }

    public function getProWeighTicketDetails($ticketNumber)
    {
        $ticket = DB::table('WB_Ticket_Trans')
            ->where('TICKET_NUMBER', $ticketNumber)
            ->first();

        if (!$ticket) {
            return response()->json(['error' => 'Ticket not found'], 404);
        }

        return response()->json($ticket);
    }
}
