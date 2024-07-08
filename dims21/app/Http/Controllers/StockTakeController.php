<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockTakeController extends Controller
{
    public function stockTake()
    {
        $locations = DB::connection('sqlsrv3')->select('SELECT intLocationNameId, strLocationName FROM tblLocationNames');
        $productGroups = DB::connection('sqlsrv3')->select('SELECT DISTINCT ItemGroup, ItemGroupDescription FROM tblSageFullStock WHERE ItemGroup IS NOT NULL');

        // dd($locations, $productGroups);
        return view('warehouse.stocktake.stocktake')->with('locations', $locations)->with('productGroups', $productGroups);
    }

    public function getStockTakes(Request $request)
    {
        $datefrom = $request->get('datefrom');
        $dateto = $request->get('dateto');

        $stocktakes = DB::connection('sqlsrv2')->select('EXEC spListStockTakes ?,?', [$datefrom, $dateto]);
        return response()->json($stocktakes);
    }

    public function createStockTake(Request $request)
    {
        $reference = $request->get('reference');
        $locations = $request->get('locations');
        $bins = $request->get('bins');
        $productGroups = $request->get('productGroups');
        $teams = $request->get('teams');

        // dd("EXEC sp_C_StockTake '$reference', '$locations', '$bins', '$productGroups', '$teams'");

        $stocktakes = DB::connection('sqlsrv2')->select("EXEC sp_C_StockTake '$reference', '$locations', '$bins', '$productGroups', '$teams'");

        return response()->json($stocktakes);
    }

    public function updateStockTakeStatus(Request $request)
    {
        $stockTakeId = $request->get('stockTakeId');
        $statusId = $request->get('statusId');
        DB::connection('sqlsrv2')->statement("EXEC sp_U_StockTakeStatus $stockTakeId, $statusId");
    }

    public function getStockCounts(Request $request)
    {
        $ID = $request->get('ID');
        $counts = DB::connection('sqlsrv2')->select("SELECT * FROM viewStockCountVariances WHERE intMainStockCountID = $ID");

        return response()->json($counts);
    }

    // old unused stock take methods ----------------------------------------------

    public function saveStockTake(Request $request)
    {
        $stocktakename = $request->get('stocktakename');
        $inventoryLoc = $request->get('inventoryloc');

        DB::connection('sqlsrv2')->statement('Exec spInsertStocktakeName ?,?', [$stocktakename, $inventoryLoc]);
    }

    public function getStockTakeLines(Request $request)
    {
        $strStockTakeName = $request->get('stocktakename');
        $invLoc = $request->get('invloc');

        $stocktakes = DB::connection('sqlsrv2')->select('EXEC spStockTakeCountsLineblade ?', [$strStockTakeName]);
        $stocktakesperitemgroup = DB::connection('sqlsrv2')->select('EXEC spStockTakeCountsLinebladePerItem ?,?', [$strStockTakeName, $invLoc]);

        $output['datalines'] = $stocktakes;
        $output['datalinesperitems'] = $stocktakesperitemgroup;

        return response()->json($output);
    }

    public function selectStockTake(Request $request)
    {
        $strStockTakeName = $request->get('strStockTakeName');

        $stocktakes = DB::connection('sqlsrv2')->select('EXEC spGetStockTakeOnName ?', [$strStockTakeName]);
        return response()->json($stocktakes);
    }

    public function productStockCountMapping()
    {
        $products = DB::connection('sqlsrv2')->select('SELECT * FROM viewtblProducts');
        $stockCounts = DB::connection('sqlsrv2')->select('SELECT * FROM vwStockCounts');

        return view('warehouse.stocktake.productStockCountMapping')->with('stockCounts', $stockCounts)->with('products', $products);
    }

    public function postMappedItems(Request $request)
    {
        $stocktakename = $request->get('stocktakename');
        $xmlproducts = $request->get('xmlproducts');
        $vartosel = DB::connection('sqlsrv3')->select('EXEC spLinxCycleStockCount ?,?', [$stocktakename, $xmlproducts]);

        return response()->json($vartosel);
    }

    public function getBinsForLocations(Request $request)
    {
        $locationIds = $request->get('locationIds');
        $bins = DB::connection('sqlsrv2')->select("SELECT * FROM viewBinNames WHERE intLocationNameId IN ($locationIds)");

        return response()->json($bins);
    }
}
