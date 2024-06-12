<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoofingController extends Controller
{
    public function roofingReprint()
    {
        $userId = Auth::user()->UserID;
        $printers = DB::connection('sqlsrv3')->select("SELECT * FROM viewUserPrinters WHERE UserID = $userId");
        $jobs = DB::connection('sqlsrv2')->select("SELECT * FROM viewRoofingJobsPrinted");

        // dd($printers);

        return view('warehouse.roofing.roofingReprint')
            ->with('jobs',$jobs)
            ->with('printers',$printers);
    }
    
    public function roofingInsertReprint(Request $request)
    {
        $intJobId = $request->get('intJobId');
        $intPrinterId = $request->get('intPrinterId');
        $qty = $request->get('qty');
        $userId = Auth::user()->UserID;

        $pool = '012345-6789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-';
        $t = time();
        $randomString = substr(str_shuffle(str_repeat($pool, 10)), 0, 10);
        $ID = $t . $randomString;

        // dd("EXEC spReprintDiamondMeshLabel $intJobId, $intPrinterId, $qty, '$ID', $userId");

        $request = DB::connection('sqlsrv2')->select("EXEC spReprintRoofingLabel $intJobId, $intPrinterId, $qty, '$ID', $userId");

        return response()->json($request);
    }
}
