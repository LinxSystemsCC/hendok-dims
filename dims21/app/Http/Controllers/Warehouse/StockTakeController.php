<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\Controller;
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

    public function getNextStockTakeId(){
        $lastStockTakeId = DB::table('tblStockTakenames')->latest('intAutoId')->pluck('intAutoId')->first();

        if ($lastStockTakeId) {
            $nextIdNumber = intval($lastStockTakeId) + 1;
        } else {
            $nextIdNumber = 1; // Start from 1 if there's no previous ID
        }

        // Format the next identifier
        $stockTakeId = 'STK' . str_pad($nextIdNumber, 7, '0', STR_PAD_LEFT);

        return $stockTakeId;
    }

    public function getBinsForLocations(Request $request)
    {
        $locationIds = $request->get('locationIds');
        $bins = DB::connection('sqlsrv2')->select("SELECT * FROM viewBinNames WHERE intLocationId IN ($locationIds)");

        return response()->json($bins);
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

    public function stockCounts($ID)
    {
        $counts = DB::connection('sqlsrv2')->select("SELECT * FROM viewStockCountVariances WHERE intMainStockCountID = $ID");
        $isApproved = DB::table('tblStockTakenames')->latest('bitAdjustmentApproved')->pluck('bitAdjustmentApproved')->first();
        // dd($isApproved);
        return view('warehouse.stocktake.stockCounts')->with('counts', $counts)->with('isApproved', $isApproved);
    }

    public function approveVarianceAdjustment(Request $request)
    {
        $gridData = $request->get('gridData');
        $userId = Auth::user()->UserID;

        if (is_array($gridData)) {
            $xml = $this->toxml($gridData, "xml", array("result"));

            // dd("EXEC sp_C_stockCountVarianceStockAdjustment '$xml', $userId");

            // Execute the stored procedure
            $response = DB::connection('sqlsrv2')->select("EXEC sp_C_stockCountVarianceStockAdjustment '$xml', $userId");
        } else {
            $response = ['error' => 'Invalid grid data'];
        }

        return response()->json($response);
    }
    
    public function syncStockMovements(Request $request)
    {
        $response = DB::connection('sqlsrv2')->statement("EXEC spPostJsonData");
        return response()->json($response);
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
    
    private static function getTabs($tabcount)
    {
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = array(), $tabcount = 0)
    {
        $result = '';
        $tabs = self::getTabs($tabcount);
        foreach ($arr as $key => $val) {
            $element = isset($elements[0]) ? $elements[0] : $key;
            $result .= $tabs;
            $result .= "<" . $element . ">";
            if (!is_array($val))
                $result .= $val;
            else {
                $result .= "\r\n";
                $result .= self::asxml($val, array_slice($elements, 1, true), $tabcount + 1);
                $result .= $tabs;
            }
            $result .= "</" . $element . ">\r\n";
        }
        return $result;
    }

    public static function toxml($arr, $root = "xml", $elements = array())
    {
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}
