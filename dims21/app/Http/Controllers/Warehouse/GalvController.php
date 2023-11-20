<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GalvController extends Controller
{
    public function galvjumbocoilsprint()
    {

        $userId =  Auth::user()->UserID;

        $printers = DB::connection('sqlsrv2')->select("EXEC spGetUserPrinters $userId");
        
        return view('warehouse.galv.galvjumbocoilsprint')
            ->with('printers', $printers);
    }

    public function getWmaxTickets(Request $request)
    {
        $searchTerm = $request->input('q');
        
        $ticketData = DB::connection('wmax')
            ->table('tblCompletedJobs')
            ->select('TicketNo')
            ->where('TicketNo', 'like', '%' . $searchTerm . '%')
            ->take(1000)
            ->get();

        return response()->json($ticketData);
    }

    public function galvPrintJumboCoil(Request $request)
    {
        $ticket =  $request->get("ticket");
        $quantity =  $request->get("quantity");
        $printer =  $request->get("printer");
        
        $result = DB::connection('sqlsrv2')->select("EXEC spPrintGalvJumboCoil '$ticket', $quantity, '$printer'");

        return response()->json($result);
    }
}
