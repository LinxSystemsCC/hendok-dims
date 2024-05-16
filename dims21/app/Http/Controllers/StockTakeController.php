<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTakeController extends Controller
{
    public function stockTake(){

        $locations = DB::connection('sqlsrv3')->select("SELECT intLocationNameId, strLocationName FROM tblLocationNames");
        return view('warehouse.stocktake.stocktake')->with('locations', $locations);
    }

    public function getStockTakes(Request $request){
        $datefrom = $request->get('datefrom');
        $dateto = $request->get('dateto');

        $stocktakes = DB::connection('sqlsrv2')->select("EXEC spListStockTakes ?,?",array($datefrom, $dateto));
        return response()->json($stocktakes);
    }

    public function saveStockTake(Request $request){
        $stocktakename = $request->get('stocktakename');
        $inventoryLoc = $request->get('inventoryloc');

        DB::connection('sqlsrv2')->statement("Exec spInsertStocktakeName ?,?", array($stocktakename, $inventoryLoc));
    }

    public function getStockTakeLines(Request $request){
        $strStockTakeName = $request->get('stocktakename');
        $invLoc = $request->get('invloc');

        $stocktakes = DB::connection('sqlsrv2')->select("EXEC spStockTakeCountsLineblade ?",array($strStockTakeName));
        $stocktakesperitemgroup = DB::connection('sqlsrv2')->select("exec spStockTakeCountsLinebladePerItem ?,?",array($strStockTakeName, $invLoc));

        $output["datalines"] = $stocktakes;
        $output["datalinesperitems"] = $stocktakesperitemgroup;

        return response()->json($output);
    }

    public function selectStockTake(Request $request){
        $strStockTakeName = $request->get('strStockTakeName');

        $stocktakes = DB::connection('sqlsrv2')->select("EXEC spGetStockTakeOnName ?",array($strStockTakeName));
        return response()->json($stocktakes);
    }

    public function updateStockTakeStatus(Request $request){
        $status = $request->get('status');
        $stocktakeid = $request->get('stocktakeid');
        DB::connection('sqlsrv2')->statement("EXEC spUpdateStockTakeStatus ?,?",array($stocktakeid, $status));
    }

    public function productStockCountMapping()
    {
        $products = DB::connection('sqlsrv2')->select('select * from viewtblProducts');
        $stockCounts = DB::connection('sqlsrv2')->select('select * from vwStockCounts');

        return view('warehouse.stocktake.productStockCountMapping')->with('stockCounts', $stockCounts)->with('products', $products);
    }

    public function postMappedItems(Request $request){
        $stocktakename = $request->get('stocktakename');
        $xmlproducts = $request->get('xmlproducts');
        $vartosel = DB::connection('sqlsrv3')->select('exec spLinxCycleStockCount ?,?', array($stocktakename,$xmlproducts)  );
        
        return response()->json($vartosel);
    }
}
