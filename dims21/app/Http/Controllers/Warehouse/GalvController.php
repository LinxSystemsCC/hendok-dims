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

    public function wmaxscrap(){
        $scales = DB::connection('sqlsrv2')->select("exec spGetScalesByDeptName 'Galv Line 1 and 2'");
        $scrapBins = DB::connection('sqlsrv2')->select("SELECT * FROM tblScrapBins ORDER BY strBinName");
        return view('warehouse.galv.wmaxscrap')
            ->with('scales', $scales)
            ->with('scrapBins', $scrapBins);
    }

    public function postScrapWeigh(Request $request)
    {
        $id =  $request->get("id");
        $bin =  $request->get("bin");
        $weight =  $request->get("weight");
        $command =  $request->get("command");
        
        $result = DB::connection('sqlsrv2')->select("EXEC spGalvScrapWeighCRUD $id, $bin, $weight, '$command'");

        return response()->json($result);
    }
}
