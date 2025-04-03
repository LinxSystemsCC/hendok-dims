<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class StockControlController extends Controller
{
    public function stockLocation(){
        $sageWarehouses = DB::connection('sqlsrv2')->select("SELECT Code, [Name] FROM [Hendok Distribution].dbo.WhseMst");
        $DCs = DB::connection('sqlsrv2')->select("SELECT intAutoId, strDCName FROM tblDCNames");
        return view('warehouse.stockcontrol.stockLocation')
            ->with('sageWarehouses', $sageWarehouses)
            ->with('DCs', $DCs);
    }

    public function getStockLocationSummary(Request $request){
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockSummary $intDCId");
        return response()->json($data);
    }

    public function getStockDetailsSummary(Request $request){
        $ItemCode = $request->get("ItemCode");
        $intDCId = $request->get('intDCid');
        $data = DB::connection('sqlsrv2')->select("EXEC spGetStockDetailSummary '$ItemCode', $intDCId");
        return response()->json($data);
    }

    public function stockAdjustment(){
        $products = DB::connection('sqlsrv2')->select("SELECT StockLink intStockLink, Code strPartNumber, Description_1 strPartDescription FROM tblSageFullStock");
        $dcs = DB::connection('sqlsrv2')->select("SELECT intAutoId intDcId, strDCName FROM tblDCNames");
        $locations = DB::connection('sqlsrv2')->select("SELECT intLocationNameId intLocationId, strLocationName FROM viewLocationNames");
        $bins = DB::connection('sqlsrv2')->select("SELECT intBinId, strBin FROM viewBinNames");
        
        return view('warehouse.stockcontrol.stockAdjustment')
            ->with('products', $products)
            ->with('dcs', $dcs)
            ->with('locations', $locations)
            ->with('bins', $bins);
    }


  
    
    
    public function getBinStockCount(Request $request){

        $intBinId = $request->get('intBinId');
        $intStockLink = $request->get('intStockLink');

        $data = DB::connection('sqlsrv2')->select("SELECT ISNULL((SELECT mnyOnHand FROM tblInventoryBin WHERE intBinId = $intBinId AND intStockLink = $intStockLink), 0) AS mnyOnHand");

        return response()->json($data);
    }

    public function processStockAdjustment(Request $request){
        $gridData = $request->get('gridData');
        $userId = Auth::user()->UserID;

        if (is_array($gridData)) {
            $xml = $this->toxml($gridData, "xml", array("result"));

            // dd("EXEC usp_C_processStockAdjustment '$xml', $userId");

            // Execute the stored procedure
            $response = DB::connection('sqlsrv2')->select("EXEC usp_C_processStockAdjustment '$xml', $userId");
        } else {
            $response = ['error' => 'Invalid grid data'];
        }

        return response()->json($response);
    }

    private static function getTabs($tabcount){
        $tabs = '';
        for ($i = 0; $i < $tabcount; $i++) {
            $tabs .= "\t";
        }
        return $tabs;
    }

    private static function asxml($arr, $elements = array(), $tabcount = 0){
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

    public static function toxml($arr, $root = "xml", $elements = array()){
        $result = '';
        $result .= "<" . $root . ">\r\n";
        $result .= self::asxml($arr, $elements, 1);
        $result .= "</" . $root . ">\r\n";
        return $result;
    }
}
